<?php
    define('BASE_PATH', __DIR__ . '/..');
    require_once BASE_PATH . '/controllers/AuthController.php';
    require_once BASE_PATH . '/controllers/TaskController.php';
    require_once BASE_PATH . '/models/User.php';
    require_once BASE_PATH . '/models/Tasks.php';
    session_start();
    $isLoggedIn=false;
    if (isset($_SESSION['user_id'])) {
        $user = new User();
        $_SESSION['initialized'] = true;
        $isLoggedIn = $user->isUserLoggedIn($_SESSION['user_id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Oblivia</title>
    <link href="../Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/css/fontawesome.css">
    <link rel="stylesheet" href="../Assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="../Assets/css/animate.css">
    <link rel="stylesheet" href="../Assets/css/todolist.css">
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
                    <a href="../index.php" class="logo">
                        <img src="../Assets/images/logo.png" alt="Oblivia">
                    </a>
                    <ul class="nav">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="list.php" class="active">Your List</a></li>
                        <li id="profile-link"></li>
                        <script>
                            const profileLink = document.getElementById('profile-link');
                            if (!isLoggedIn) {
                                profileLink.innerHTML = '<a href="../index.php?action=login">Log in/Sign in</a>';
                            } else {
                                profileLink.innerHTML = '<a href="profile.php">Profile</a>';
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
                <?php if ($isLoggedIn): ?>
                    <div class="list-tdl">
                        <div id="myDIV" class="header">
                            <h2>My To Do List</h2>
                            <input type="text" id="myInput" placeholder="Title...">
                            <span onclick="newElement()" class="addBtn">Add</span>
                        </div>
                        <ul id="myUL">
                        </ul>
                        <div class="import-export-buttons">
                            <button id="exportTasks">Export Tasks</button>
                            <form id="importForm" enctype="multipart/form-data" >
                                <input type="file" id="importFile" name="file" accept="application/json" >
                                <button type="submit">Import Tasks</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="main-button">
                        <center><a id="list-button" href="../index.php?action=login">Log In to Create To-do list</a></center>
                    </div>
                <?php endif; ?>
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
<script src="../Assets/vendor/jquery/jquery.min.js"></script>
<script src="../Assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../Assets/js/isotope.min.js"></script>
<script src="../Assets/js/owl-carousel.js"></script>
<script src="../Assets/js/tabs.js"></script>
<script src="../Assets/js/popup.js"></script>
<script src="../Assets/js/custom.js"></script>
<script src="../Assets/js/todolist.js"></script>
</body>
</html>
