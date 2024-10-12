<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filter-form select, .filter-form input {
            margin-right: 10px;
            padding: 5px;
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h2 {
            color: #555;
        }
        .post p {
            color: #777;
        }
        .post .meta {
            font-size: 14px;
            color: #999;
        }
        .post .read-more {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #4cae4c;
        }
        .pagination a:hover {
            background-color: #4cae4c;
        }
        .no-posts {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 20px;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
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
        .post img {
            width: 262px; /* Fixed width */
            height: 192px; /* Fixed height */
            object-fit: cover; /* Crop image to fit the dimensions */
            display: block;
            margin-top: 10px;
        }
        .meta {
            font-size: 14px;
            color: #999;
        }
        .meta strong {
            color: #003366; /* Dark blue for field labels */
        }
        .meta .value {
            color: #e65c00; /* Dark orange for the actual results */
        }
        p {
            line-height: 1.6;
            color: #555;
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

<div class="container">
    <h1>Blog Posts</h1>
    <button onclick="window.location.href='?url=welcome'">Dashboard</button>

    <form method="GET" action="" class="filter-form">
        <input type="hidden" name="url" value="bview">
        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="">All</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="published" <?php echo (isset($_GET['status']) && $_GET['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
            <option value="archived" <?php echo (isset($_GET['status']) && $_GET['status'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
            <option value="rejected" <?php echo (isset($_GET['status']) && $_GET['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
        </select>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">

        <button type="submit">Filter</button>
    </form>

    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="meta">
        <strong>Category:</strong> <span class="value"><?php echo htmlspecialchars($post['category_name']); ?></span> |
        <strong>Username:</strong> <span class="value"><?php echo htmlspecialchars($post['username']); ?></span> |
        <strong>Status:</strong> <span class="value"><?php echo htmlspecialchars($post['status']); ?></span> |
        <strong>Created:</strong> <span class="value"><?php echo htmlspecialchars($post['created']); ?></span>
    </p>
                <p><?php echo htmlspecialchars(substr($post['message'], 0, 150)); ?>...</p>
                <?php if (!empty($post['image'])): ?>
                  
                  <img src="../sgcms/postpics/<?php echo ($post['image']); ?>" alt="Post Image" ">
              <?php else: ?>
                  <p>No image</p>
              <?php endif; ?>
                <a class="read-more" href="?url=bread&id=<?php echo $post['id']; ?>">Read More</a>
                
            </div>
        <?php endforeach; ?>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?url=bview&page=<?php echo $page - 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : ''; ?><?php echo isset($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : ''; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?url=bview&page=<?php echo $i; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : ''; ?><?php echo isset($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : ''; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?url=bview&page=<?php echo $page + 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['start_date']) ? '&start_date=' . $_GET['start_date'] : ''; ?><?php echo isset($_GET['end_date']) ? '&end_date=' . $_GET['end_date'] : ''; ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="no-posts">No post to show. Post first!</p>
    <?php endif; ?>
</div>
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
