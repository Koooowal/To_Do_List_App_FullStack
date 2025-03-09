<?php
require_once __DIR__ . '/../models/User.php';
class UserController {
    private $userModel;
    public function __construct() {
        $this->userModel = new User();
        session_start();
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /views/login.php");
            exit;
        }
        $userId = $_SESSION['user_id'];
        $userData = $this->getProfileData($userId);
        require_once '../Views/profile.php';
    }

    public function getProfileData($userId) {
        try {
            return $this->userModel->findById($userId);
        } catch (Exception $e) {
            error_log("Error retrieving profile data: " . $e->getMessage());
            return null;
        }
    }
}
