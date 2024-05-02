<?php

namespace App\Http\Controllers;
use App\Models\PlantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexPlants()
    {
        $user = Auth::user();

        $plants = PlantUser::where('user_id', $user->id)
        ->with('plant')
        ->get();

        $plantsInGarden = [];

        foreach ($plants as $plant) {
            $plantsInGarden[] = [
                'id' => $plant->plant->id,
                'name' => $plant->plant->name,
                'img' => $plant->plant->img,
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            'plantsInGarden' => $plantsInGarden,
        ], 200);
    }
}
