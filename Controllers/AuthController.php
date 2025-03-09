<?php
require_once __DIR__ . '/../models/User.php';
class AuthController {
    private $userModel;
    public function __construct() {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            try {
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Invalid email format.');
                }
                if (strlen($password) < 6 || strlen($password) > 128) {
                    throw new Exception('Password must be between 6 and 128 characters.');
                }
                $user = $this->userModel->findByEmail($email);
                if (!$user || !password_verify($password, $user['password'])) {
                    throw new Exception('Invalid email or password.');
                }
                $_SESSION['user_id'] = $user['id'];
                $this->userModel->insertLoggedInUser($user['id']);
                header("Location: index.php");
                exit;
            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                echo "<script>
                alert('{$e->getMessage()}');
                window.location.href = 'Views/loginPage.php';
              </script>";
            }
        } else {
            header("Location: Views/loginPage.php");
            exit;
        }
    }
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            try {
                $this->userModel->logoutUser($_SESSION['user_id']);
            } catch (Exception $e) {
                error_log("Logout error: " . $e->getMessage());
            }
        }
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            try {
                if (!$name || strlen($name) < 3 || strlen($name) > 50) {
                    throw new Exception('Name must be between 3 and 50 characters.');
                }
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Invalid email format.');
                }
                if (strlen($password) < 6 || strlen($password) > 128) {
                    throw new Exception('Password must be between 6 and 128 characters.');
                }
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->create($name, $email, $hashedPassword);
                header("Location: index.php");
                exit;
            } catch (Exception $e) {
                error_log("Registration error: " . $e->getMessage());
                echo "<script>
                    alert('{$e->getMessage()}');
                    window.location.href = 'Views/register.php';
                  </script>";
            }
        } else {
            header("Location: Views/register.php");
            exit;
        }
    }
}
