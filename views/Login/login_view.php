<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="..\..\css_folder\globalcss\globalCss.css">
    <link rel="stylesheet" href="..\..\css_folder\form-styles.css">
</head>
<body>
   <div class="container" id="loginContainer"> 
      <div class="page-title">
         <h1 id ="login-page-title">Login</h1>
      </div>
      
      <div id="login">
         <form id="login-form" method ="post" action="#" name="login-form" >
            <label for="email">Email:</label>
            <input type="text"  id="email" name="email" required placeholder="example@gmail.com">
            <label for="password">Password:</label>
            <input type="password"  id="password" name="password" required placeholder="************" >
            <button type="submit" id="login-button" name="login-button">Login</button>        
         </form>
         <a href="../Register/register_view.php" class="register-link">
            Create an Account
         </a>
      </div> 
   </div>
</body>

<?php include("../../includes/login_scripts.php")?>

</html>


