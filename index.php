<?php
    define('BASE_PATH', __DIR__);
    require_once BASE_PATH . '/controllers/TaskController.php';
    require_once BASE_PATH . '/controllers/AuthController.php';
    require_once BASE_PATH . '/controllers/UserController.php';
    require_once BASE_PATH . '/models/User.php';
    require_once BASE_PATH . '/models/Tasks.php';
    session_start();
    $isLoggedIn=false;
    if (isset($_SESSION['user_id'])) {
        $user = new User();
        $isLoggedIn = $user->isUserLoggedIn($_SESSION['user_id']);
    }
    $action = $_GET['action'] ?? null;
    switch ($action) {
        case 'register':
            $authController = new AuthController();
            $authController->register();
            break;
        case 'login':
            $authController = new AuthController();
            $authController->login();
            break;
        case 'logout':
            $authController = new AuthController();
            $authController->logout();
            break;
        case 'getTasks':
        case 'addTask':
        case 'deleteTask':
        case 'updateTask':
        case 'exportTasks':
        case 'importTasks':
            $taskController = new TaskController();
            $taskController->handleRequest();
            exit;
        default:
            $isLoggedIn = isset($_SESSION['user_id']);
            require_once BASE_PATH . '/index.php';
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Oblivia</title>
    <link href="Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/fontawesome.css">
    <link rel="stylesheet" href="Assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="Assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <script>
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    </script>
</head>
<body>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.php" class="logo">
                        <img src="Assets/images/logo.png" alt="Oblivia">
                    </a>
                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="Views/list.php">Your List</a></li>
                        <li id="profile-link"></li>
                        <script>
                            const profileLink = document.getElementById('profile-link');
                            if (!isLoggedIn) {
                                profileLink.innerHTML = '<a href="index.php?action=login">Log in/Sign in</a>';
                            } else {
                                profileLink.innerHTML = '<a href="Views/profile.php">Profile</a>';
                            }
                        </script>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-content">
                <div class="main-banner">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="header-text">
                                <h6>Oblivia</h6>
                                <h4><em>Gamify</em> your life</h4>
                                <div class="main-button">
                                    <a id="list-button" href="Views/list.php">Create your to-do list </a>
                                    <script>
                                        const listButton = document.getElementById('list-button');
                                        if (!isLoggedIn) {
                                            listButton.innerHTML = '<a href="Views/loginPage.php">Log in/Sign in</a>';
                                        } else {
                                            listButton.innerHTML = '<a href="Views/list.php">Create your to-do list</a>';
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © Oblivia All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<script src="Assets/vendor/jquery/jquery.min.js"></script>
<script src="Assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="Assets/js/isotope.min.js"></script>
<script src="Assets/js/owl-carousel.js"></script>
<script src="Assets/js/tabs.js"></script>
<script src="Assets/js/popup.js"></script>
<script src="Assets/js/custom.js"></script>
<script src="Assets/js/todolist.js"></script>
</body>
</html>
