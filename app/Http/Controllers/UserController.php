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

    public function nextPlantsToHarvest()
    {
        $user = Auth::user();
        $currentMonth = date('n'); // Obtenez le mois actuel (sans le zéro initial)
        $nextThreeMonths = [$currentMonth, ($currentMonth + 1) % 12, ($currentMonth + 2) % 12, ($currentMonth + 3) % 12];

        $plants = PlantUser::where('user_id', $user->id)
            ->with(['plant' => function ($query) use ($nextThreeMonths) {
                $query->whereIn('start_harvest_month', $nextThreeMonths);
            }])
            ->get();

        $plantsThisMonth = [];
        $plantsNextThreeMonths = [];
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
            ];

            if (in_array($plant->start_harvest_month, [$currentMonth])) {
                $plantsThisMonth[] = $plantInfo;
            } elseif (count($plantsNextThreeMonths) < 3) {
                $plantsNextThreeMonths[] = $plantInfo;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            'plantsThisMonth' => $plantsThisMonth,
            'plantsNextThreeMonths' => $plantsNextThreeMonths,
        ], 200);
    }
}
