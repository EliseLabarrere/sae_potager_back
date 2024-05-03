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
                'number_of_plant' => $plant->number_of_plant
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            'plantsInGarden' => $plantsInGarden,
        ], 200);
    }

    public function nextPlantsToHarvest()
    {
        $user = Auth::user();
        $currentMonth = date('n');

        $plants = PlantUser::where('user_id', $user->id)
            ->with('plant')
            ->get();

        $plantsThisMonth = [];
        $plantsNextMonths = [];

        $monthNames = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin',
            7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];

        foreach ($plants as $plantUser) {
            $plant = $plantUser->plant;
            $plantInfo = [
                'id' => $plant->id,
                'name' => $plant->name,
                'img' => $plant->img,
                'start_harvest_month' => $monthNames[$plant->start_harvest_month],
                'start_harvest_month_nbr' => $plant->start_harvest_month,
            ];

            if ($plant->start_harvest_month == $currentMonth && count($plantsThisMonth) < 3) {
                $plantsThisMonth[] = $plantInfo;
            } else {
                $plantsNextMonths[] = $plantInfo;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            'plantsThisMonth' => $plantsThisMonth,
            'plantsNextMonths' => $plantsNextMonths,
        ], 200);
    }

    public function getNumberOfPlants($plant_id)
    {
        $user = Auth::user();

        $plants = PlantUser::where('user_id', $user->id)
            ->where('plant_id', $plant_id)
            ->select('number_of_plant')
            ->first();

        if (!$plants) {
            $numberOfPlants = 0;
        } else {
            $numberOfPlants = $plants->number_of_plant;
        }

        return response()->json(['number_of_plants' => $numberOfPlants]);
    }

    public function addPlantInGarden(Request $request)
    {
        $request->validate([
            'plant_id' => 'required',
            'number_to_add' => 'required',
        ]);

        $user = Auth::user();

        $plant = PlantUser::where('user_id', $user->id)
            ->where('plant_id', $request->plant_id)
            ->first();

        if (!$plant) {
            $plant = PlantUser::create([
                'user_id' => $user->id,
                'plant_id' => $user->id,
                'number_of_plant' => $request->number_to_add,
            ]);
            $message = "Plant added to your garden";
        } else {
            $plant->number_of_plant += $request->number_to_add;
            $plant->save();
            $message = "You added one plant to your garden, you now have " . $plant->number_of_plant . " plants";
        }

        return response()->json([
            'status' => true,
            'message' => $message,
        ], 200);
    }
}
