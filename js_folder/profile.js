// Function to render user information in the specified div
function renderUserInfo(user) {
    // Get elements and set their content
    document.getElementById('fname').textContent = user.fname;
    document.getElementById('lname').textContent = user.lname;
    document.getElementById('gender').textContent = (user.gender == 0) ? 'Male' : 'Female';;
    document.getElementById('user').textContent = user.username;
    document.getElementById('email').textContent = user.email;
    document.getElementById('phone').textContent = user.phone;
    document.getElementById('bio').textContent = user.bio;
    document.getElementById('date').textContent = user.dob;
}

function populateUserForm() {
    // Select each input field individually
    const firstNameInput = document.getElementById('firstName');
    const lastNameInput = document.getElementById('lastName');
    const usernameInput = document.getElementById('username');
    const dobInput = document.getElementById('dob');
    const pnumInput = document.getElementById('pnum');
    const maleInput = document.getElementById('male');
    const femaleInput = document.getElementById('female');
    const emailInput = document.getElementById('email-in');
    const passwordInput = document.getElementById('password');
    const bio = document.getElementById('bio-in');

    // Set default values for each input field
    firstNameInput.value = document.getElementById('fname').textContent;
    lastNameInput.value = document.getElementById('lname').textContent;
    usernameInput.value = document.getElementById('user').textContent;
    dobInput.value = document.getElementById('date').textContent;
    pnumInput.value = document.getElementById('phone').textContent;
    if(document.getElementById('gender').textContent === 'Male'){
        maleInput.checked = true;
    }else{
        femaleInput.checked = true;
    }
    bio.value = document.getElementById('bio').textContent;
    emailInput.value = document.getElementById('email').textContent;
}

document.addEventListener("DOMContentLoaded", function () {
    // Make a GET request to retrieve user information
    fetch('../../server/Get/getUser.php', {
        method: "GET"
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Check if user information was successfully retrieved
            if (data.success) {
                // Render user information in the div
                renderUserInfo(data.user);
            } else {
                // Display error message if user information retrieval failed
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching user information:', error);
        });


});

document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the button
    var editProfileButton = document.querySelector('.open-popup-btn[data-popup-id="editProfile"]');
    editProfileButton.addEventListener('click', function() {
        populateUserForm();
    });
});

// Function to validate form data
function validateFormEdit() {

    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const username = document.getElementById('username').value.trim();
    const dobInput = new Date(document.getElementById('dob').value);
    const pnum = document.getElementById('pnum').value.trim();
    const gender = document.getElementById('male').value;
    const email = document.getElementById('email-in').value.trim();
    const password = document.getElementById('password').value.trim();
    const bio = document.getElementById('bio-in').value.trim();

    
    // Check if any field is empty
    if (firstName === '' || lastName === '' || gender === null || username === '' || dob === '' || pnum === '' || email === '') {
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
    if (password.length < 8 && password.length!=0) {
        return { isValid: false, message: 'Password must be at least 8 characters long.' };
    }


    // If all validations pass, return true
    return { isValid: true, message: '' };
}

document.getElementById("editProfile-form").addEventListener("submit", function(event) {
    
    event.preventDefault(); // Prevent form submission
    var validationResult = validateFormEdit();

    if (!validationResult.isValid) {
        
        swal({
            title: 'Error',
            text: validationResult.message,
            icon: 'error',
            button: 'OK'
        });
        return; 
    }
   
    fetch('../../server/Put/updateUser.php', {
        method: 'POST',
        body: new FormData(document.getElementById('editProfile-form'))
    })
    .then(response => {
        if (response.ok) {
            // Registration successful, trigger SweetAlert
            swal({
                title: 'Success!',
                text: 'Edit Successful.',
                icon: 'success',
                button: 'OK'
            }).then((value) => {
                if (value) {
                   window.location.reload();
                }
            });
        } else {
            // Registration failed, handle errors if needed
            swal({
                title: 'Error!',
                text: 'Edit Failed',
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



