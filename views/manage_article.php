<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit, .delete {
            cursor: pointer;
            color: blue;
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .edit {
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
        img.preview {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin-top: 10px;
        }
        .no-image {
            color: gray;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            padding: 8px 16px;
            margin: 0 4px;
            border: 1px solid #ddd;
            color: #337ab7;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #5cb85c;
            color: white;
            border: 1px solid #5cb85c;
        }
        .pagination a:hover {
            background-color: #ddd;
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

<h1>Manage Articles</h1>
<button onclick="window.location.href='?url=welcome'">Dashboard</button>
<button onclick="window.location.href='?url=uart'">Add New</button>

<?php if (empty($articles)): ?>
    <p>Not yet posted.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>Title</th>
                <th>Message</th>
                <th>Category</th>
                <th>Username</th>
                <th>Status</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $index => $article): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($article['title']); ?></td>
                    <td><?php echo htmlspecialchars($article['message']); ?></td>
                    <td><?php echo htmlspecialchars($article['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($article['username']); ?></td>
                    <td><?php echo htmlspecialchars($article['status']); ?></td>
                    <td><?php echo htmlspecialchars($article['created']); ?></td>
                    <td><?php echo htmlspecialchars($article['updated']); ?></td>
                    <td>
                        <?php if ($article['image']): ?>
                          
                            <img src="../sgcms/postpics/<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="preview"><br>
        <form action="?url=mart" method="post" style="display:inline;">
            <button type="submit" name="remove_image" value="1" onclick="return confirm('Do you want to delete this image?');">Remove Image</button>
            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">
        </form>
                           
                        <?php else: ?>
                            <span class="no-image">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="edit" onclick="editArticle(<?php echo $index; ?>)">Edit</button> |
                        <form action="?url=mart" method="post" style="display:inline;">
                            <button type="submit" name="delete" value="1" onclick="return confirm('Are You sure you want to delete this post?');">Delete</button>
                            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">
                        </form>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?url=mart&page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?url=mart&page=<?php echo $i; ?>" class="<?php echo $i == $currentPage ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?url=mart&page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Article</h2>
        <form id="editForm" action="?url=mart" method="post" enctype="multipart/form-data">
            <input type="hidden" name="article_id" id="modalArticleId">
            <label for="title">Title:</label>
            <input type="text" id="modalTitle" name="title" required><br><br>
            <label for="message">Message:</label>
            <textarea id="modalMessage" name="message" rows="4" required></textarea><br><br>
            <label for="category_id">Category:</label>
            <select id="modalCategoryId" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <label for="status">Status:</label>
            <select id="modalStatus" name="status" required>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
            </select><br><br>
            <label for="image">Image:</label>
            <input type="file" id="modalImage" name="image" accept="image/*"><br><br>
            <img id="imagePreview" src="" alt="Image Preview" class="preview" style="display: none;"><br><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</div>

<script>
    
    
function editArticle(index) {
  
    const articles = <?php echo json_encode($articles); ?>;
    const article = articles[index];

    document.getElementById('modalArticleId').value = article.id;
    document.getElementById('modalTitle').value = article.title;
    document.getElementById('modalMessage').value = article.message;
    document.getElementById('modalCategoryId').value = article.category_id;
    document.getElementById('modalStatus').value = article.status;

    const imagePath = article.image ? '../sgcms/postpics/' + article.image : '';
    
    const imagePreview = document.getElementById('imagePreview');

    if (imagePath) {
        imagePreview.src = imagePath;
        imagePreview.style.display = 'block';
    } else {
        imagePreview.style.display = 'none';
    }

    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

document.getElementById('modalImage').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const imagePreview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.style.display = 'none';
    }
});
function removeImage(index) {
    if (confirm('Do you want to remove this image?')) {
        const article = <?php echo json_encode($articles); ?>[index];
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '?url=mart';
        form.innerHTML = `
            <input type="hidden" name="article_id" value="${article.id}">
            <input type="hidden" name="remove_image" value="1">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<br>
<br>
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