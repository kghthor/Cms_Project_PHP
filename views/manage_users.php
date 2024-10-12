<?php include 'views/inc/header1.php'; ?>
<div class="add-user-btn">

<?php include 'views/inc/header.php'; ?>

<!-- Trigger/Open The Modal -->
<button id="openModalBtn">Add User</button>

<!-- The Modal -->
<div id="userModal" class="modal userModal"  style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>New User</h1>
        <form id="createUserForm" method="post">
            <div>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                </div>
            <div style="text-align: center;">
    <button id="kl-create" type="submit" style="padding: 5px 10px; border: none; border-radius: 4px; background-color: #5cb85c; color: white; font-size: 14px; cursor: pointer; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        Create User
    </button>
    <button id="kl-close" type="button" style="padding: 5px 10px; border: none; border-radius: 4px; background-color: #ff0000; color: white; font-size: 14px; cursor: pointer; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-left: 10px;">
        Close
    </button>
</div>
<script>
    // Close operation for the "Close" button
    document.getElementById('kl-close').onclick = function() {
        document.getElementById('userModal').style.display = 'none';
    };
</script>

        </form>
        <div id="responseMessage"></div>
    </div>
</div>
<?php include 'views/inc/footer.php'; ?>

    <button onclick="window.location.href='?url=welcome'">Dashboard</button>
    <br>
    <br>
    <div class="search-bar">
    <input type="text" id="userSearch" placeholder="Search by username or email..." value="<?= htmlspecialchars($search) ?>">
    <button id="searchButton">Search</button>
</div>
</div>

<!-- Search Form -->


<table>
    <thead>
        <tr>
            <th>SN</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="userTable">
        <?php if ($users): ?>
            <?php foreach ($users as $index => $user): ?>
            <tr>
                <td><?= $start + $index + 1 ?></td>
                <td><?= htmlspecialchars($user['first_name']) ?></td>
                <td><?= htmlspecialchars($user['last_name']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['type'] == 1 ? 'Admin' : 'User' ?></td>
                <td class="action-buttons">
                    <button onclick="openEditModal(<?= $user['id'] ?>)">Edit</button>
                    <button onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No users found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?url=muser&page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>" class="<?= $i == $page ? 'active' : '' ?>">
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>

<!-- JavaScript to handle the search functionality -->
<script>
document.getElementById('searchButton').addEventListener('click', function() {
    const searchValue = document.getElementById('userSearch').value;
    window.location.href = "?url=muser&search=" + encodeURIComponent(searchValue);
});
</script>

<!-- Edit Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editUserModal')">&times;</span>
        <h2>Edit User</h2>
        <form id="editUserForm">
            <input type="hidden" id="editUserId" name="id">
            <div>
                <label for="editFirstName">First Name:</label>
                <input type="text" id="editFirstName" name="first_name" required>
            </div>
            <div>
                <label for="editLastName">Last Name:</label>
                <input type="text" id="editLastName" name="last_name" required>
            </div>
            <div>
                <label for="editUsername">Username:</label>
                <input type="text" id="editUsername" name="username" required>
            </div>
            <div>
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" required>
            </div>
            <div>
                <label for="editType">Type:</label>
                <select id="editType" name="type">
                    <option value="1">Admin</option>
                    <option value="0">User</option>
                </select>
            </div>
            <div style="text-align: center;">
            <button type="submit" style="padding: 5px 10px; border: none; border-radius: 4px; background-color: #5cb85c; color: white; font-size: 14px; cursor: pointer; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    Update User
</button>
<button id="kl-cl" type="button" style="padding: 5px 10px; border: none; border-radius: 4px; background-color: #ff0000; color: white; font-size: 14px; cursor: pointer; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-left: 10px;">
        Close
    </button>
</div>
<script>
    // Close operation for the "Close" button
    document.getElementById('kl-cl').onclick = function() {
        document.getElementById('editUserModal').style.display = 'none';
    };
</script>
        </form>
    </div>
</div>

<?php include 'views/inc/footer1.php'; ?>
