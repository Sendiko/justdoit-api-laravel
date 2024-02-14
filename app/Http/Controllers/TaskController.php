<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $task = Task::where('user_id', $user_id)->get();
        
        return response()->json([
            "status" => 200,
            "message" => "data successfully sent",
            "task" => $task,
        ], 200);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "string|required",
            "description" => "string",
            "user_id" => "string|required",
            "is_done" => "boolean|integer",
        ]);

        $task = Task::create($validated);

        return response()->json([
            "status" => 201,
            "message" => "data successfully stored",
            "task" => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);

        return response()->json([
            "status" => 200,
            "message" => "data successfully sent",
            "task" => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "title" => "string",
            "description" => "string",
            "is_done" => "string",
        ]);

        $task = Task::findOrFail($id);

        $task->update($validated);

        return response()->json([
            "status" => 200,
            "message" => "data successfully updated",
            "task" => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response()->json([
            "status" => "200",
            "message" => "data deleted successfully"
        ], 200);
    }
}
