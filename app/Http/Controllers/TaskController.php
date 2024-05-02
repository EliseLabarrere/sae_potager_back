<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\PlantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function doWateringTasks()
    {
        $user = Auth::user();
        try {
            $task = Task::create([
                'user_id' => $user->id,
            ]);

            $task->save();

            return response()->json([
                'status' => true,
                'message' => 'Successful completion of daily missions'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Daily missions could not be recorded as completed',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function completedTasks(Request $request)
    {
        $request->validate([
            'firstDate' => 'required',
            'lastDate' => 'required',
        ]);

        $user = Auth::user();

        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('created_at', [$request->firstDate, $request->lastDate])
            ->pluck('created_at')
            ->map(function ($item) {
                return $item->toDateString();
            })
            ->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Tasks retrieved successfully',
            'tasks' => $tasks,
        ], 200);
    }

    public function haveTasks(Request $request)
    {
        $request->validate([
            'day' => 'required',
        ]);

        $user = Auth::user();

        // $plant->load('categ_plant', 'categ_garden', 'compatibilities.otherPlant');


        // $plants = DB::table('plant_user')
        //     // ->join('plants', 'plant_user.plant_id', '=', 'plants.id')
        //     ->where('plant_user.user_id', $user->id)
        //     // ->select('plant_user.plant_id', 'plant_user.last_watering', 'plants.watering_rythm')
        //     ->get();

        // function doitEtreArrose($last_watering, $watering_rythme)
        // {
        //     $last_watering_date = new DateTime($last_watering);

        //     $today = new DateTime();

        //     $interval = $last_watering_date->diff($today);
        //     $days_since_last_watering = $interval->days;

        //     return ($days_since_last_watering % $watering_rythme) == 0;
        // }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            // 'plants' => $plants,
        ], 200);
    }
}
