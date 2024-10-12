$(document).ready(function() {
    // Get modal element
    var modal = $('#userModal');
    // Get open modal button
    var openModalBtn = $('#openModalBtn');
    // Get close button
    var closeBtn = $('.close');

    // Open modal
    openModalBtn.on('click', function() {
        modal.show();
    });

    // Close modal
    closeBtn.on('click', function() {
        modal.hide();
    });

    // Close modal if clicked outside
    $(window).on('click', function(event) {
        if ($(event.target).is(modal)) {
            modal.hide();
        }
    });

    // Handle form submission
    $('#createUserForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            url: '?url=adduser', // Adjust URL to match your routing setup
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            dataType: 'json',
            success: function(response) {
                if (response.errors) {
                    let errorsHtml = '<ul>';
                    response.errors.forEach(function(error) {
                        errorsHtml += '<li>' + error + '</li>';
                    });
                    errorsHtml += '</ul>';
                    $('#responseMessage').html(errorsHtml).css('color', 'red');
                } else if (response.success) {
                    $('#responseMessage').html(response.success).css('color', 'green');
                    $('#createUserForm')[0].reset(); // Reset form fields
                }
            },
            error: function() {
                $('#responseMessage').html('An error occurred while processing your request.').css('color', 'red');
            }
        });
    });
});
