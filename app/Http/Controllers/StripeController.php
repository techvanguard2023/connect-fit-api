<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use Carbon\Carbon;

class StripeController extends Controller
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret', env('STRIPE_SECRET')));
    }

    // cria (ou recupera) o customer na Stripe
    private function ensureStripeCustomer(Customer $customer): string
    {
        if ($customer->stripe_customer_id) {
            return $customer->stripe_customer_id;
        }
        
        $stripeCustomer = $this->stripe->customers->create([
            'email' => $customer->email,
            'name'  => $customer->name,
            'metadata' => ['app_customer_id' => (string)$customer->id],
        ]);
        
        $customer->stripe_customer_id = $stripeCustomer->id;
        $customer->save();
        
        return $stripeCustomer->id;
    }


    // POST /api/v1/stripe/checkout
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        /** @var Customer $customer */
        $customer = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);

        if (!$plan->stripe_price_id) {
            return response()->json(['message' => 'Plano sem stripe_price_id configurado.'], 422);
        }

        $customerId = $this->ensureStripeCustomer($customer);

        $success = rtrim(config('app.frontend_url', env('APP_FRONTEND_URL', 'http://localhost:5173')), '/')
                 . '/paywall/sucesso';
        $cancel  = rtrim(config('app.frontend_url', env('APP_FRONTEND_URL', 'http://localhost:5173')), '/')
                 . '/paywall?cancelled=1';

        $session = $this->stripe->checkout->sessions->create([
            'mode'               => 'subscription',
            'customer'           => $customerId,
            'line_items'         => [[ 'price' => $plan->stripe_price_id, 'quantity' => 1 ]],
            'success_url'        => $success,
            'cancel_url'         => $cancel,
            'allow_promotion_codes' => true,
            'metadata' => [
                'app_customer_id' => (string)$customer->id,
                'app_plan_id' => (string)$plan->id,
            ],
        ]);

        return response()->json(['url' => $session->url], Response::HTTP_OK);
    }

    // POST /api/v1/stripe/webhook
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig     = $request->header('Stripe-Signature');
        $secret  = config('services.stripe.webhook_secret', env('STRIPE_WEBHOOK_SECRET'));

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig, $secret);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'customer.subscription.created':
                $session = $event->data->object;

                $subscription = $this->stripe->subscriptions->retrieve($session->id);
                $customerId   = $session->customer;
                $priceId      = $session->items->data[0]->price->id ?? null;

                $customer = Customer::where('stripe_customer_id', $customerId)->first();
                $plan = Plan::where('stripe_price_id', $priceId)->first();

                if ($customer && $plan) {
                    Subscription::updateOrCreate(
                        [
                            'customer_id' => $customer->id,
                            'plan_id' => $plan->id,
                            'stripe_subscription_id' => $session->id,
                        ],
                        [
                            'start_date' => Carbon::createFromTimestamp($session->items->data[0]->current_period_start)->toDateString(),
                            'end_date'   => Carbon::createFromTimestamp($session->items->data[0]->current_period_end)->toDateString(),
                            'status'     => in_array($session->status, ['active', 'trialing']),
                        ]
                    );
                }
                break;

            // atualizações de ciclo/status
            case 'customer.subscription.updated':
            case 'customer.subscription.deleted':
                /** @var \Stripe\Subscription $sub */
                $sub = $event->data->object;
                $customer = Customer::where('stripe_customer_id', $sub->customer)->first();
                if ($customer) {
                    Subscription::where('stripe_subscription_id', $sub->id)->update([
                        'start_date' => Carbon::createFromTimestamp($sub->items->data[0]->current_period_start)->toDateString(),
                        'end_date'   => Carbon::createFromTimestamp($sub->items->data[0]->current_period_end)->toDateString(),
                        'status'     => in_array($sub->status, ['active', 'trialing']),
                    ]);
                }
                break;
        }

        return response()->json(['received' => true]);
    }
}
