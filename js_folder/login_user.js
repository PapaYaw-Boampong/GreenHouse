window.onload = function() {
    window.location.reload();
  };

function validateLoginForm(){
    // Get form data
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Validate form data
    if (email.trim() === '' || password.trim() === '') {
        // Show SweetAlert for empty fields
        swal({
            title: 'Error!',
            text: 'Please enter your email and password.',
            icon: 'error',
            button: 'OK'
        });
        
        return { isValid: false, message: 'fields Cannot be empty' };
    }

    // Check email format using regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.trim())) {
        // Show SweetAlert for invalid email format
        swal({
            title: 'Error!',
            text: 'Please enter a valid email address.',
            icon: 'error',
            button: 'OK'
        });
        return { isValid: false, message: 'Email does not meet criteria' };
    }

    // Check password format (for example, minimum length of 6 characters) using regex
    const passwordRegex = /^.{8,}$/;
    if (!passwordRegex.test(password.trim())) {
        // Show SweetAlert for invalid password format
        swal({
            title: 'Error!',
            text: 'Please enter a password with at least 6 characters.',
            icon: 'error',
            button: 'OK'
        });
        return { isValid: false, message: 'Passwords does not meet criteria' };
    }

    return { isValid: true, message: '' };
}

document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    var validationResult = validateLoginForm();
    if (!validationResult.isValid) {
        swal({
            title: 'Error',
            text: validationResult.message,
            icon: 'error',
            button: 'OK'
        });
        return;
    }

    // Submit the form data using fetch
    fetch('../../server/Post/login.php', {
        method: 'POST',
        body: new FormData(document.getElementById('login-form'))
    })
    .then(response => response.json()) // Parse response body as JSON
    .then(data => {
        if (data) {
            // Handle the success status returned by the PHP file
            if (data.success) {
                // Set session ID in local storage
                localStorage.setItem("sessionID", data.sessionID);
                // Show success message and redirect to home page
                swal({
                    title: 'Success!',
                    text: 'Welcome.',
                    icon: 'success',
                    button: 'OK'
                }).then((value) => {
                    if (value) {
                        window.location.href = '../Home/home.php';
                    }
                });
            } else {
                // Display a SweetAlert for login error
                throw new Error(data.message || 'Invalid email or password.');
            }
        } else {
            // No data received, show generic error
            throw new Error('No data received.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show SweetAlert for unexpected error
        swal({
            title: 'Error!',
            text: error.message || 'An unexpected error occurred. Please try again later.',
            icon: 'error',
            button: 'OK'
        });
    });
});
