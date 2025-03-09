<?php
require_once 'Database.php';
class Tasks {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function addTask($userId, $taskData) {
        $task = htmlspecialchars($taskData['task'], ENT_QUOTES, 'UTF-8');
        $query = "INSERT INTO tasks (user_id, task) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $userId, $task);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getTasks($userId) {
        $query = "SELECT id, task, is_completed FROM tasks WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteTask($userId, $taskId) {
        $query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $taskId, $userId);
        $stmt->execute();
    }
    public function updateTaskStatus($userId, $taskId, $isCompleted) {
        $query = "UPDATE tasks SET is_completed = ? WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $isCompleted, $taskId, $userId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function exportTasks($userId) {
        $query = "SELECT id, task, is_completed FROM tasks WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        return json_encode($tasks);
    }

    public function importTasks($userId, $tasks) {
        foreach ($tasks as $task) {
            $taskText = htmlspecialchars($task['task'], ENT_QUOTES, 'UTF-8');
            $isCompleted = $task['is_completed'];
            $query = "INSERT INTO tasks (user_id, task, is_completed) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isi", $userId, $taskText, $isCompleted);
            $stmt->execute();
        }
        return true;
    }



}
