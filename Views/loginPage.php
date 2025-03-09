<?php
require_once '../Controllers/AuthController.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Assets/css/style.css">
</head>
<body>
<div class="wrapper">
    <form action="../index.php?action=login" method="POST" onsubmit="return validateRegistrationForm();">
        <h2>Login</h2>
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Enter your email</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" required minlength="6" maxlength="128">
            <label>Enter your password</label>
        </div>
        <button type="submit">Log In</button>
        <div class="register">
            <p>Don't have an account? <a href="registerPage.php">Register</a></p><br/>
            <p>Home Page -> <a href="../index.php">Oblivia</a></p>
        </div>
    </form>
</div>
<script>
    function validateForm() {
        const emailField = document.querySelector('input[name="email"]');
        const passwordField = document.querySelector('input[name="password"]');
        if (!emailField.value.trim() || !passwordField.value.trim()) {
            alert('All fields are required.');
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
