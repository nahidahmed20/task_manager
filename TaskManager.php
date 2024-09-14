<?php

require_once 'Task.php';

class TaskManager {
    private $tasks = [];

    public function __construct() {
        $this->loadTasks();
    }

    public function addTask(Task $task) {
        $this->tasks[$task->getId()] = $task;
        $this->saveTasks();
    }

    public function getTask($id) {
        return isset($this->tasks[$id]) ? $this->tasks[$id] : null;
    }

    public function getAllTasks() {
        return $this->tasks;
    }

    public function updateTask(Task $task) {
        $this->tasks[$task->getId()] = $task;
        $this->saveTasks();
    }

    public function deleteTask($id) {
        unset($this->tasks[$id]);
        $this->saveTasks();
    }

    private function loadTasks() {
        if (file_exists('tasks.json')) {
            $data = json_decode(file_get_contents('tasks.json'), true);
            foreach ($data as $taskData) {
                $task = new Task($taskData['id'], $taskData['title'], $taskData['description'], $taskData['status']);
                $this->tasks[$task->getId()] = $task;
            }
        }
    }

    private function saveTasks() {
        $data = [];
        foreach ($this->tasks as $task) {
            $data[] = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus(),
            ];
        }
        file_put_contents('tasks.json', json_encode($data));
    }
}
