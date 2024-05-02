<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\PlantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function doWateringTasks()
    {
        $user = Auth::user();
        try {
            $lastTask = Task::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($lastTask) {
                $lastWateringDate = Carbon::parse($lastTask->created_at)->startOfDay();
                $today = Carbon::today();
                $yesterday = Carbon::yesterday();

                if ($lastWateringDate->equalTo($today)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Daily missions have already been completed for today'
                    ], 400);
                } elseif ($lastWateringDate->equalTo($yesterday)) {
                    $user->watering_streak += 1;
                    $message = "You have been watering your plants for " . $user->watering_streak . " consecutive days";
                } else {
                    $user->watering_streak = 0;
                    $message = "Successful completion of daily missions";
                }
            }
            $user->save();

            $task = Task::create([
                'user_id' => $user->id,
            ]);

            $task->save();

            return response()->json([
                'status' => true,
                'message' => $message
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

        $plants = PlantUser::where('user_id', $user->id)
            ->with('plant')
            ->get();

        $wateringPlants = [];

        foreach ($plants as $plant) {
            $lastWatering = new DateTime($plant->last_watering);

            $daysElapsed = $lastWatering->diff(new DateTime($request->day))->days;

            if (($daysElapsed % $plant->plant->watering_rythm) == 0) {
                $wateringPlants[] = [
                    'id' => $plant->plant->id,
                    'name' => $plant->plant->name,
                    'img' => $plant->plant->img,
                ];
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            'wateringPlants' => $wateringPlants,
        ], 200);
    }

    public function checkDailyTask()
    {
        $user = Auth::user();
        $lastTask = Task::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($lastTask) {
            $lastWateringDate = Carbon::parse($lastTask->created_at)->startOfDay();
            $today = Carbon::today();

            if ($lastWateringDate->equalTo($today)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Daily missions have already been completed for today'
                ], 400);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Daily tasks not yet completed'
        ], 500);
    }
}