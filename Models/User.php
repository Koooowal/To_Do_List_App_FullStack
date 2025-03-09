<?php
require_once 'Database.php';
class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function findByEmail($email) {
        $query = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception('Database query preparation failed.');
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $email, $hashedPassword) {
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception('Database query preparation failed.');
        }
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        if (!$stmt->execute()) {
            throw new Exception('Failed to create user.');
        }
        return $stmt->insert_id;
    }
    public function logoutUser($userId) {
        $query = "DELETE FROM logged_in_users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception('Database query preparation failed.');
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
    public function isUserLoggedIn($userId) {
        $query = "SELECT user_id FROM logged_in_users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare query.");
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function insertLoggedInUser($userId) {
        $query = "INSERT INTO logged_in_users (user_id, login_time) VALUES (?, NOW())";
        $this->db->executeQuery($query, [$userId], 'i');
    }
    public function getUserById($userId) {
        $query = "SELECT name, email FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }



}
