<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
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
            color: #333;
        }
        .meta {
            font-size: 14px;
            color: #999;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #4cae4c;
        }
        .post-image {
            width: 262px; /* Set the width of the image */
            height: 192px; /* Set the height of the image */
            object-fit: cover; /* Ensure the image covers the dimensions without distortion */
            display: block;
            margin: 20px 0;
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
    </style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p class="meta">
        <strong>Category:</strong> <span class="value"><?php echo htmlspecialchars($post['category_name']); ?></span> |
        <strong>Username:</strong> <span class="value"><?php echo htmlspecialchars($post['username']); ?></span> |
        <strong>Status:</strong> <span class="value"><?php echo htmlspecialchars($post['status']); ?></span> |
        <strong>Created:</strong> <span class="value"><?php echo htmlspecialchars($post['created']); ?></span>
    </p>
    <p><?php echo nl2br(htmlspecialchars($post['message'])); ?></p>
    <?php if (!empty($post['image'])): ?>
        <img src="../sgcms/postpics/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
    <?php endif; ?>
    <a href="?url=bview">Back to Blog</a>
</div>

</body>
</html>
