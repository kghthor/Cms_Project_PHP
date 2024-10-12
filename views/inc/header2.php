<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="views/css/style3.css">
    <style>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header id="header">
        <h1>Manage Catagories </h1>
        <a id="logout" href="?url=logout">Logout</a>
        <a id="portal" href="https://kghthor.netlify.app/" target="_blank">Check My Portal</a>
    </header>