<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>

.filter-section {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 20px;
   
}

.filter-section select,
.filter-section button {
    margin-right: 10px;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;

}

.filter-section button {
    background-color: #5cb85c;
    color: white;
    cursor: pointer;

}

.filter-section button:hover {
    background-color: #4cae4c;
}

.filter-section .filter-label {
    font-weight: bold;
    margin-right: 10px;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <link rel="stylesheet" href="views/css/style2.css">

</head>
<body>

<header id="header">
        <h1>User Management </h1>
        <a id="logout" href="?url=logout">Logout</a>
        <a id="portal" href="https://kghthor.netlify.app/" target="_blank">Check My Portal</a>
    </header>