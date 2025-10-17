<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MuscleGroup;


use Illuminate\Http\Request;

class MuscleGroupController extends Controller
{
    public function index()
    {
        $muscleGroups = MuscleGroup::orderBy('name', 'asc')->withCount('exercises')->get();
        return response()->json($muscleGroups);
    }


    public function show(Request $request, $id)
    {
        $muscleGroup = MuscleGroup::orderBy('name', 'asc')->with('exercises')->find($id);
        if (!$muscleGroup) {
            return response()->json(['message' => 'Grupo muscular não encontrado'], 404);
        }
        return response()->json($muscleGroup);
    }
}
