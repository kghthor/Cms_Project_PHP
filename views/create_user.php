<?php include 'views/inc/header.php'; ?>

<!-- Trigger/Open The Modal -->
<button id="openModalBtn">Create New User</button>
<button onclick="window.location.href='?url=welcome'">Dashboard</button>

<!-- The Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Create New User</h1>
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
            <button type="submit">Create User</button>
        </form>
        <div id="responseMessage"></div>
    </div>
</div>

<?php include 'views/inc/footer.php'; ?>
