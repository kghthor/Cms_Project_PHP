<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #header {
            background-color: #333333;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        #logout {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff4d4d;
            color: #ffffff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        #logout:hover {
            background-color: #ff1a1a;
        }
        #portal {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        #portal:hover {
            background-color: #45a049;
        }
        #main {
            padding: 20px;
            text-align: center;
            flex: 1;
        }
        .button {
            display: inline-block;
            margin: 20px;
            padding: 15px 30px;
            background-color: #095f59;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }
        .button:hover {
            background-color: #077a6a;
        }
        .overview {
            margin-top: 20px;
            text-align: center;
        }
        .overview h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .overview .counter {
            display: inline-block;
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .overview .counter i {
            font-size: 36px;
            display: block;
            margin-bottom: 10px;
        }
        .overview .counter span {
            font-size: 24px;
            font-weight: bold;
        }
        h1 {
            color: red;
        }
        footer {
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-left, .footer-center, .footer-right {
            flex: 1;
            text-align: center;
        }
        .footer-left {
            text-align: left;
            font-size: 14px;
        }
        .footer-center {
            text-align: center;
            font-size: 14px;
        }
        .footer-right {
            text-align: right;
        }
        .footer-right a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 20px;
        }
        .footer-right a:hover {
            color: #dddddd;
        }
    </style>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header id="header">
        <h1>Content Management System</h1>
        <a id="logout" href="?url=logout">Logout</a>
        <a id="portal" href="https://kghthor.netlify.app/" target="_blank">Check My Portal</a>
    </header>

    <section id="main">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <!-- Website Overview Section -->
        <section class="overview">
            <h2>Website Overview</h2>
            <div class="counter">
                <i class="fa fa-user"></i> <!-- Font Awesome User Icon -->
                <span><?php echo $total_users; ?></span> Total Users
            </div>
            <div class="counter">
                <i class="fa fa-file-text"></i> <!-- Font Awesome File Text Icon -->
                <span><?php echo $total_posts; ?></span> Total Posts
            </div>
            <div class="counter">
                <i class="fa fa-list"></i> <!-- Font Awesome List Icon -->
                <span><?php echo $total_categories; ?></span> Total Categories
            </div>
        </section>

        <!-- Dashboard Buttons -->
        <a class="button" href="?url=mart">Manage Article</a>
        <a class="button" href="?url=mcat">Manage Categories</a>
        <!-- <a class="button" href="?url=adduser">Add Users</a> -->
        <a class="button" href="?url=bview">Blog-View</a>
        <a class="button" href="?url=muser">Manage Users</a>
        <a class="button" href="?url=uart">Create Article</a>
        <a class="button" href="?url=upro">Manage Profile</a>
    </section>

    <footer>
        <div class="footer-left">
            Designed and Developed by Harish K G
        </div>
        <div class="footer-center">
            Copyright © 2024 Harish K G
        </div>
        <div class="footer-right">
            <a href="https://github.com/kghthor" target="_blank">
                <i class="fab fa-github"></i> <!-- GitHub Icon -->
            </a>
            <a href="https://www.instagram.com/kghthor" target="_blank">
                <i class="fab fa-instagram"></i> <!-- Instagram Icon -->
            </a>
            <a href="https://www.facebook.com/kgharish.kgharish/" target="_blank">
                <i class="fab fa-facebook"></i> <!-- Facebook Icon -->
            </a>
            <a href="https://twitter.com/kghthor7" target="_blank">
                <i class="fab fa-twitter"></i> <!-- Twitter Icon -->
            </a>
        </div>
    </footer>
</body>
</html>
