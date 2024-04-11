document.addEventListener('DOMContentLoaded', function() {
    // Check if session ID is set in local storage
    if (!localStorage.getItem('sessionID')) {
        window.location.href = '../Login/login_view.php';

        // Redirect to another page after success if needed
        window.history.replaceState({}, '', 'http://localhost/final-project/views/Login/login_view.php');

        // Clear history stack
        var len = window.history.length;
        for (var i = 0; i < len; i++) {
          window.history.replaceState({}, '', 'http://localhost/final-project/views/Login/login_view.php');
        }

        // Redirect to login page
        window.location.href = "http://localhost/final-project/views/Login/login_view.php";
    }
});
