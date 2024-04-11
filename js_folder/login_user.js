document.getElementById("login-form").addEventListener("submit", function (event) {

    event.preventDefault(); // Prevent form submission

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
        return;
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
        return;
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
        return;
    }


    // Submit the form data using fetch
    fetch('../../server/Post/login.php', {
        method: 'POST',
        body: new FormData(document.getElementById('login-form'))
    }).then(response => {
            if (response.ok) {
                return response.json();

            } else {
                // Show SweetAlert for login error
                swal({
                    title: 'Error!',
                    text: 'Invalid email or password.',
                    icon: 'error',
                    button: 'OK'
                });
            }
        })
        .then(data => {
            // Handle the success status returned by the PHP file
            if (data.success) {
                sessionID = data.sessionID;
                localStorage.setItem("sessionID", sessionID);
                // Registration successful, trigger SweetAlert
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
                swal({
                    title: 'Error!',
                    text: 'Invalid email or password.',
                    icon: 'error',
                    button: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show SweetAlert for unexpected error
            swal({
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again later.',
                icon: 'error',
                button: 'OK'
            });
        });
});