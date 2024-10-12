<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
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
        #imagePreview img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        #imagePreviewContainer {
    margin-top: 10px;
}

#imagePreview {
    border: 1px solid #ddd;
    padding: 5px;
    width: 471px;  /* Fixed width */
    height: 282px; /* Fixed height */
    object-fit: cover; /* Ensure the image fits the specified dimensions */
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
        <h1>User Management</h1>
        <a id="logout" href="?url=logout">Logout</a>
        <a id="portal" href="https://kghthor.netlify.app/" target="_blank">Check My Portal</a>
    </header>
<div class="add-user-btn">
        <button onclick="window.location.href='?url=mart'">Manage Article</button>
        <button onclick="window.location.href='?url=welcome'">Dashboard</button>
    </div>
    <div class="container">
        <h1>Create Article</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <div id="imagePreview"></div>
            </div>
            <div class="form-group">
                <br>
                <br>
                <br>
                <br>
                <br>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
    <script>
        // JavaScript to preview the uploaded image
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Image preview">';
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
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
