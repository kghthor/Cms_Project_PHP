<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group input[type="password"] {
            margin-bottom: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .error {
            color: #ff4d4d;
        }
        .success {
            color: #4CAF50;
        }
        .add-user-btn {
    display: block;
    margin: 20px 0;
    text-align: right;
}
.add-user-btn button {
    padding: 10px 20px;
    background-color: #5cb85c;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
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
    </style>
</head>
<body>
<header id="header">
        <h1>User Management </h1>
        <a id="logout" href="?url=logout">Logout</a>
        <a id="portal" href="https://kghthor.netlify.app/" target="_blank">Check My Portal</a>
    </header>
    <br>
    <div class="container">
        <h2>User Profile</h2>
        <div class="add-user-btn">
        <button onclick="window.location.href='?url=welcome'">Dashboard</button>
    </div>
        <?php if (isset($success_message)) { ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php } ?>

        <?php if (isset($error_message)) { ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST" action="?url=upro">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Current Password:</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label>New Password (optional):</label>
                <input type="password" name="new_password">
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</body>
</html>
