<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\PlantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function doTasks()
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

        // $user = Auth::user();

        // $plants = PlantUser::where('user_id', $user->id)
        // ->get();

        return response()->json([
            'status' => true,
            'message' => 'Daily tasks found',
            // 'plants' => $plants,
        ], 200);
    }
}
