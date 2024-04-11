
// Function to validate form data
function validateForm() {
    // Get form fields
    var firstName = document.getElementById('firstName').value.trim();
    var lastName = document.getElementById('lastName').value.trim();
    var gender = document.querySelector('input[name="gender"]:checked');
    var username = document.getElementById('username').value.trim();
    var dob = new Date(document.getElementById('dob').value);
    console.log(dob);
    var pnum = document.getElementById('pnum').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();
    var confirmPassword = document.getElementById('confirm-password').value.trim();
    
    // Check if any field is empty
    if (firstName === '' || lastName === '' || gender === null || username === '' || dob === '' || pnum === '' || email === '' || password === '' || confirmPassword === '') {
        return { isValid: false, message: 'Please fill in all fields.' };
    }

    // Check username format (alphanumeric characters only)
    var usernameRegex = /^[a-zA-Z0-9]+$/;
    if (!usernameRegex.test(username)) {
        return { isValid: false, message: 'Username can only contain alphanumeric characters.' };
    }

    // Check if DOB is not today or in the future
    var today = new Date();
    if (dob >= today) {
        return { isValid: false, message: 'Date of birth cannot be today or in the future.' };
    }

    // Check phone number format (10 digits only)
    var pnumRegex = /^\d{10}$/;
    if (!pnumRegex.test(pnum)) {
        return { isValid: false, message: 'Please enter a valid 10-digit phone number.' };
    }

    // Check email format using regex
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return { isValid: false, message: 'Please enter a valid email address.' };
    }

    // Check password format (minimum 8 characters)
    if (password.length < 8) {
        return { isValid: false, message: 'Password must be at least 8 characters long.' };
    }

    // Check if passwords match
    if (password !== confirmPassword) {
        return { isValid: false, message: 'Passwords do not match.' };
    }

    // If all validations pass, return true
    return { isValid: true, message: '' };
}

document.getElementById("register-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    var validationResult = validateForm();

    if (!validationResult.isValid) {
        swal({
            title: 'Error',
            text: validationResult.message,
            icon: 'error',
            button: 'OK'
        });
        return; 
    }
    
    fetch('../../server/Post/register.php', {
        method: 'POST',
        body: new FormData(document.getElementById('register-form'))
    })
    .then(response => response.json()) // Parse response body as JSON
    .then(data => {
        if (data.success) {
            // Registration successful, trigger SweetAlert
            swal({
                title: 'Success!',
                text: 'You have been successfully registered.',
                icon: 'success',
                button: 'OK'
            }).then((value) => {
                if (value) {
                    // Redirect to another page after success if needed
                    window.location.href = '../Login/login_view.php';
                }
            });
        } else {
            // Registration failed, handle errors if needed
            swal({
                title: 'Error!',
                text: data.message || 'Registration failed. Please try again later.',
                icon: 'error',
                button: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle any unexpected errors if needed
        swal({
            title: 'Error!',
            text: 'An unexpected Server error occurred. \n Please try again later.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});


