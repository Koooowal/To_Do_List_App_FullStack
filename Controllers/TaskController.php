<?php
require_once __DIR__ . '/../models/Tasks.php';
class TaskController {
    private $tasks;

    public function __construct() {
        $this->tasks = new Tasks();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';
        $userId = (int)$_SESSION['user_id'];
        try {
            switch ($action) {
                case 'addTask':
                    if ($method === 'POST') {
                        $input = json_decode(file_get_contents('php://input'), true);
                        if (!$input || !isset($input['task'])) {
                            throw new Exception('Invalid input.');
                        }
                        $taskId = $this->tasks->addTask($userId, $input);
                        echo json_encode(['success' => true, 'task_id' => $taskId]);
                    }
                    break;
                case 'getTasks':
                    if ($method === 'GET') {
                        $tasks = $this->tasks->getTasks($userId);
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'tasks' => $tasks]);
                    }
                    break;
                case 'deleteTask':
                    if ($method === 'POST') {
                        $input = json_decode(file_get_contents('php://input'), true);
                        if (!isset($input['task_id'])) {
                            throw new Exception('Invalid input.');
                        }
                        $this->tasks->deleteTask($userId, $input['task_id']);
                        echo json_encode(['success' => true]);
                    }
                    break;
                case 'updateTask':
                    if ($method === 'POST') {
                        $input = json_decode(file_get_contents('php://input'), true);
                        if (!isset($input['task_id'], $input['is_completed'])) {
                            throw new Exception('Invalid input.');
                        }
                        $updated = $this->tasks->updateTaskStatus($userId, $input['task_id'], (int)$input['is_completed']);
                        echo json_encode(['success' => $updated]);
                    }
                    break;
                case 'exportTasks':
                    if ($method === 'GET') {
                        header('Content-Type: application/json');
                        echo $this->tasks->exportTasks($userId);
                    }
                    break;
                case 'importTasks':
                    if ($method === 'POST' && isset($_FILES['file'])) {
                        $file = $_FILES['file']['tmp_name'];
                        $data = json_decode(file_get_contents($file), true);
                        if (!$data || !is_array($data)) {
                            throw new Exception('Invalid file format.');
                        }
                        $this->tasks->importTasks($userId, $data);
                        echo json_encode(['success' => true]);
                    }
                    break;
                default:
                    throw new Exception('Invalid action.');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}
