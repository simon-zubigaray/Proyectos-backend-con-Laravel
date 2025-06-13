<?php

namespace App\Http\Controllers;

use App\Business\Services\TaskService;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAll();
        return response()->json($tasks);
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $task = $this->taskService->create($request->validated());
            return response()->json($task, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $validatedData = $request->validated();
            $this->taskService->update($task, $validatedData);
            return response()->json([
                'message' => 'Tarea actualizada correctamente.',
                'task' => $task
            ]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->taskService->delete($task);
            return response()->json([
                'message' => 'Tarea eliminada correctamente.',
                'task' => $task
            ]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        $task = $this->taskService->show($id);
        return response()->json($task);
    }

    public function getByStatus(string $status)
    {
        try {
            if (!in_array($status, ['pending', 'completed', 'canceled'])) {
                return response()->json(['error' => 'Estado inválido.'], Response::HTTP_BAD_REQUEST);
            }

            $tasks = $this->taskService->getByStatus($status);

            if ($tasks->isEmpty()) {
                return response()->json(["error" => "No existen elementos con ese estado."], Response::HTTP_NOT_FOUND);
            }

            return response()->json($tasks);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function countByStatus()
    {
        try{
            $amountByStatus = $this->taskService->countByStatus();
            return response()->json($amountByStatus);
        } catch(Exception $e){
            return response()->json(["error" => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
