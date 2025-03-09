<?php
require_once __DIR__ . '/../Config/config.php';
class Database {
    private $conn;

    public function __construct() {
        try {
            $config = require __DIR__ . '/../Config/config.php';
            $dbConfig = $config['database'];
            $this->conn = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);
            if ($this->conn->connect_error) {
                throw new Exception("Database connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage(), 3, 'logs/error.log');
            die("An error occurred while connecting to the database. Please try again later.");
        }
    }
    public function prepare($query) {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Query preparation failed: " . $this->conn->error);
            throw new Exception("Failed to prepare the query.");
        }
        return $stmt;
    }
    public function executeQuery($query, $params = [], $types = '') {
        $stmt = $this->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        if (!$stmt->execute()) {
            error_log("Query execution failed: " . $stmt->error);
            throw new Exception("Failed to execute query.");
        }
        return $stmt;
    }

    public function insertLoggedInUser($userId) {
        $query = "INSERT INTO logged_in_users (user_id) VALUES (?)";
        $this->executeQuery($query, [$userId], 'i');
    }

    public function selectUserBySession($userId) {
        $query = "SELECT user_id FROM logged_in_users WHERE user_id = ?";
        $stmt = $this->executeQuery($query, [$userId], 'i');
        $stmt->bind_result($loggedInUserId);
        if ($stmt->fetch()) {
            $stmt->close();
            return $loggedInUserId;
        }
        $stmt->close();
        return -1;
    }
}
