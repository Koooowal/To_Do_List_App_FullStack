<?php
    require_once '../Controllers/AuthController.php';
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);
    if ($isLoggedIn) {
        header("Location: /index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../Assets/css/style.css">
</head>
<body>
<div class="wrapper">
    <form action="../index.php?action=register" method="POST" onsubmit="return validateRegistrationForm();">
        <h2>Register</h2>
        <div class="input-field">
            <input type="text" name="name" required minlength="3" maxlength="50">
            <label>Enter your name</label>
        </div>
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Enter your email</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" required minlength="6" maxlength="128">
            <label>Create a password</label>
        </div>
        <button type="submit">Register</button>
        <div class="login">
            <p>Already have an account? <a href="loginPage.php">Log In</a></p>
        </div>
    </form>
</div>
<script>
    function validateRegistrationForm() {
        const nameField = document.querySelector('input[name="name"]');
        const emailField = document.querySelector('input[name="email"]');
        const passwordField = document.querySelector('input[name="password"]');
        if (!nameField.value.trim() || !emailField.value.trim() || !passwordField.value.trim()) {
            alert('All fields are required.');
            return false;
        }
        if (nameField.value.length < 3 || nameField.value.length > 50) {
            alert('Name must be between 3 and 50 characters.');
            return false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            alert('Please enter a valid email address.');
            return false;
        }
        if (passwordField.value.length < 6 || passwordField.value.length > 128) {
            alert('Password must be between 6 and 128 characters.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
