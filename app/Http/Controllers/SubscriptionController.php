<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;



class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::where('user_id', $request->user()->id)->get();
        $subscriptions->load('plan');
        return response()->json($subscriptions);
    }
}
