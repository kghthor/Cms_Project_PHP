function openEditModal(id) {
    // Fetch user data using AJAX
    $.ajax({
        url: '?url=fuser',
        type: 'GET',
        data: {id: id},
        dataType: 'json',
        success: function(response) {
            $('#editUserId').val(response.id);
            $('#editFirstName').val(response.first_name);
            $('#editLastName').val(response.last_name);
            $('#editUsername').val(response.username);
            $('#editEmail').val(response.email);
            $('#editType').val(response.type);
            $('#editUserModal').show();
        }
    });
}

function closeModal(modalId) {
    $('#' + modalId).hide();
}

$('#editUserForm').on('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    $.ajax({
        url: '?url=uuser',
        type: 'POST',
        data: $(this).serialize(), // Serialize form data
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('User updated successfully.');
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Error updating user.');
            }
        }
    });
});

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: '?url=duser',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('User deleted successfully.');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error deleting user.');
                }
            }
        });
    }
}

