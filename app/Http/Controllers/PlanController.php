<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('features')->get();
        return PlanResource::collection($plans);
    }
}
