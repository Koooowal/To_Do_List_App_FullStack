<?php
    define('BASE_PATH', __DIR__ . '/..');
    require_once BASE_PATH . '/Controllers/UserController.php';
    require_once BASE_PATH . '/Controllers/AuthController.php';
    require_once BASE_PATH . '/Models/User.php';
    require_once BASE_PATH . '/Models/Tasks.php';
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);
    if ($isLoggedIn) {
        $user = new User();
        $isLoggedIn = $user->isUserLoggedIn($_SESSION['user_id']);

        if ($isLoggedIn) {
            $userData = $user->getUserById($_SESSION['user_id']);
            $userName = $userData['name'] ?? '';
            $userEmail = $userData['email'] ?? '';
        }
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
                        <img src="../Assets/images/logo.png" alt="">
                    </a>
                    <ul class="nav">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="list.php">Your List</a></li>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-profile">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="../Assets/images/profile.jpg" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="col-lg-4 align-self-center">
                                    <div class="main-info header-text">
                                        <h4><?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></h4>
                                        <p><?php echo htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8'); ?></p>
                                        <div class="main-border-button">
                                            <a href="../index.php?action=logout">LOG OUT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="clips"></div>
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
<script src="../Assets/vendor/jquery/jquery.min.js"></script>
<script src="../Assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../Assets/js/isotope.min.js"></script>
<script src="../Assets/js/owl-carousel.js"></script>
<script src="../Assets/js/tabs.js"></script>
<script src="../Assets/js/popup.js"></script>
<script src="../Assets/js/custom.js"></script>
</body>
</html>
