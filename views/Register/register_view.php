<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="..\..\css_folder\globalcss\globalCss.css">
    <link rel="stylesheet" href="..\..\css_folder\form-styles.css">
</head>
<body>
   <div class="container"> 
      <div class ="page-title">
         <h1 id ="register-page-title">Register</h1>
      </div>
      <div id ="register">
         <form action="#" id="register-form" name="register-form" method="post">

            <div class="row">
               <div class="col" id="col-1">
                  <div class = "section" id="firstName-sec">
                     <label for="firstName">First Name:</label>
                     <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                  </div>
                  
                  <div class = "section" id="lastName-sec">
                     <label for="lastName">Last Name:</label>
                     <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                  </div>    
                     
                  <div class = "section" id ="gender-sec" >
                     <label>Gender:</label>
                     <div class="options">
                        <input type="radio" id="male" name="gender" value="0" required>
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="1" required>
                        <label for="female">Female</label>
                     </div>
                  </div>
               </div>

               <div class="col" id="col 2">

                  <div class = "section" id="Username-sec">
                     <label for="lastName">User Name:</label>
                     <input type="text" id="username" name="username" placeholder="Username" required>
                  </div>

                  <div class = "section" id ="dob-sec" >
                     <label for="dob">DOB:</label>
                     <input type="date" id="dob" name="dob"  required >
                  </div>

                  <div class = "section" id ="pnum-sec" >
                     <label for="pnum">Phone Number:</label>
                     <input type="text" id="pnum" name="pnum" placeholder="**********" required pattern="^\d{10}$"> 
                  </div>

               </div> 

               <div class="col" id="col-3">
                  <div class="section">
                     <label for="email">Email:</label>
                     <input type="email" id="email" name="email" placeholder="example@gmail.com" required pattern="^.+@.+\..+$" >
                  </div>

                  <div class="section">
                     <label for="password">Password:</label>
                     <input type="password" id="password" name="password" placeholder="***********" required pattern=".{8,}">  
                     <!-- ^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()-_+=])[a-zA-Z0-9!@#$%^&*()-_+=]{8,}$ -->
                  </div>

                  <div class="section">
                     <label for="confirm-password">Confirm Password:</label>
                     <input type="password" id="confirm-password" name="confirm-password" placeholder="***********" required required pattern=".{8,}">
                  </div>

               </div>  
            </div>

            <div id="register-button">
            <button type="submit" name="register-button">Register</button>        
            </div>
         </form>

         <a href="../Login/login_view.php" class="login-link" >
            Already have an account?
         </a>

      </div>
   </div>
</body>
<?php include("../../includes/register_scripts.php")?>
</html>


