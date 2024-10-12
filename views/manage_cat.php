
<?php include 'views/inc/header2.php'; ?>
    <!-- Add/Edit Category Button -->
    <div class="add-category-btn">
        <button onclick="openModal()">Add Category</button>
        <button onclick="window.location.href='?url=welcome'">Dashboard</button>

    </div>

    <!-- Add/Edit Category Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add Category</h2>
            <form id="categoryForm" action="?url=mcat" method="POST">
                <input type="hidden" id="categoryId" name="id">
                <div>
                    <label for="categoryName">Category Name:</label>
                    <input type="text" id="categoryName" name="name" required>
                </div>
                <button type="submit">Save Category</button>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['id']) ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td class="action-buttons">
    <button onclick="editCategory(<?= $category['id'] ?>, '<?= htmlspecialchars($category['name']) ?>')" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px; margin: 2px 1px; cursor: pointer;">Edit</button>
    <a href="?url=mcat&delete=<?= $category['id'] ?>" onclick="return confirm('Are you sure you want to delete this category?')" style="color: red; text-decoration: none; margin-left: 10px;">Delete</a>
</td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
<?php include 'views/inc/footer2.php'; ?>
