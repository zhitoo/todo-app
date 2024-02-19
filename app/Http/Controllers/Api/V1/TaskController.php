<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\StoreRequest;
use App\Http\Requests\V1\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::query()->where('user_id', auth()->id())->latest()->paginate(15);
        return response()->json(['data' =>  TaskResource::collection($tasks)]);
    }
    public function show(Task $task)
    {
        return response()->json(['data' => new TaskResource($task)]);
    }
    public function store(StoreRequest $request)
    {
        Task::query()->create([
            'user_id' => auth()->id(),
            'task' => $request->input('task'),
            'completed' => (bool)$request->input('completed')
        ]);
        return response()->json(['message' => 'success'], 201);
    }
    public function update(UpdateRequest $request, Task $task)
    {
        $task->update([
            'task' => $request->input('task'),
            'completed' => (bool)$request->input('completed')
        ]);
        return response()->json(['message' => 'success']);
    }

    public function toggleCompleted(Task $task)
    {
        $task->update([
            'completed' => !(bool)$task->completed
        ]);
        return response()->json(['message' => 'success', 'data' => new TaskResource($task)]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'success']);
    }
}
