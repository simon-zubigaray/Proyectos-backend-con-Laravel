<?php

namespace App\Business\Services;

use App\Models\Task;

class TaskService
{

    // Crear tarea
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    // Obtener todas las tareas
    public function getAll()
    {
        return Task::all();
    }

    // Traer tarea por id
    public function show(int $id): Task
    {
        return Task::findOrFail($id);
    }

    // Actualizar tarea
    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    // Eliminar tarea
    public function delete(Task $task): void
    {
        $task->delete();
    }

    /* Funciones extras al CRUD */

    // Traer todas las tareas por usuario
    public function getAllTaskByUser(int $id)
    {
        return Task::where('user_id', $id)->get();
    }

    // Traer tareas por status
    public function getByStatus(string $status)
    {
        return Task::where('status', $status)->get();
    }

    // Traer cantidad de tareas por status
    public function countByStatus() 
    {
        return [
            'pending' => Task::where('status', 'pending')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'canceled' => Task::where('status', 'canceled')->count(),
        ];
    }
}
