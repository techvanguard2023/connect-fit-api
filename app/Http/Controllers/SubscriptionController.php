<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::where('user_id', $request->user()->id)->get();
        return response()->json($subscriptions);
    }
}
