<!DOCTYPE html>
<html lang="en">

<head>

    <title>Garden</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" href="../../css_folder/globalcss/globalCss.css">
    <link rel="stylesheet" href="../../css_folder/pop-up.css" />
    <link rel="stylesheet" href="../../css_folder/garden.css" />
    <link rel="stylesheet" href="../../css_folder/profile.css" />
    <script>
        var mode = localStorage.getItem('mode') || 'light'; // Default to light mode if no mode is stored
        document.documentElement.classList.add(mode);
    </script>
    <script src="../../js_folder/auth.js"></script>

</head>

<body>
    <div class="popup-overlay"></div>

    <div class="app-container ">

        <?php

        // Retrieve the message parameter from the URL
        $message = isset($_GET['msg']) ? $_GET['msg'] : '';

        ?>

        <div class="app-content">


            <div class="app-content-header ">
                <h1 class="app-content-headerText">Hi Papa</h1>

                <button class="mode-switch" title="Switch Theme">
                    <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
                        <defs></defs>
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>

                <div class="headerAction">
                    <button class="app-content-headerButton " id="bkGarden">Garden</button>
                    <button class="app-content-headerButton open-popup-btn" data-popup-id="editProfile">Edit Profile</button>
                </div>


            </div>

            <div class="userData">
                <div class="dataContainer">
                    <div class="col" id="col-1">
                        <div class="section" id="fname-sec">
                            <span>
                                FirstName:
                            </span>
                            <div class="value" id="fname">
                                
                            </div>

                        </div>

                        <div class="section" id="lname-sec">
                            <span>
                                FastName:
                            </span>
                            <div class="value" id="lname">
                                
                            </div>

                        </div>

                        <div class="section" id="gen-sec">
                            <span>
                                Gender:
                            </span>
                            <div class="value" id="gender">
                                
                            </div>

                        </div>

                    </div>

                    <div class="col" id="col-2">

                        <div class="section" id="user-sec">
                            <span>
                                UserName:
                            </span>
                            <div class="value" id="user">
                                
                            </div>

                        </div>

                        <div class="section" id="email-sec">
                            <span>
                                Email:
                            </span>
                            <div class="value" id="email">
                                
                            </div>

                        </div>

                        <div class="section" id="phone-sec">
                            <span>
                                Phone number:
                            </span>
                            <div class="value" id="phone">
                                
                            </div>

                        </div>

                    </div>

                    <div class="col" id="col-3">
                        <div class="section" id="data-sec">
                            <span>
                                Date of Birth:
                            </span>
                            <div class="value" id="date"></div>
                        </div>

                        <div class="section" id="bio-sec">
                            <span>
                                Bio:
                            </span>
                            <div class="value" id="bio"></div>
                        </div>



                    </div>

                </div>

            </div>

            <div class="app-content-header ">

                <div class="  account-info-picture open-popup-btn" data-popup-Id="logoutPopup">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M15 12L2 12M2 12L5.5 9M2 12L5.5 15" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>

            </div>

        </div>

        <div class="popup-region">
            <div id="logoutPopup" class="popup">

                <div class="popup-title">
                    <label for="close-btn"> Logout</label>
                    <div>
                        <button class="close-btn" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" id='logout-btn' class="popup-btn">logout</button>




            </div>

            <div id="editProfile" class="popup">
                <div class="popup-title">
                    <label for="close-btn">Profile Information (scroll)</label>
                    <div>
                        <button class="close-btn" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                <hr>

                <form action="" id="editProfile-form">
                    <div class="section" id="firstName-sec">
                        <label for="firstName">First Name:</label>
                        <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                    </div>

                    <div class="section" id="lastName-sec">
                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                    </div>
                    <div class="section" id="Username-sec">
                        <label for="lastName">User Name:</label>
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="section" id="dob-sec">
                        <label for="dob">DOB:</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>

                    <div class="section" id="pnum-sec">
                        <label for="pnum">Phone Number:</label>
                        <input type="text" id="pnum" name="pnum" placeholder="**********" required pattern="^\d{10}$">
                    </div>

                    <div class="section" id="gender-sec">
                        <label>Gender:</label>
                        <div class="options">
                            <input type="radio" id="male" name="gender" value="0" required>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="1" required>
                            <label for="female">Female</label>
                        </div>
                    </div>
                    <div class="section">
                        <label for="email">Email:</label>
                        <input type="email" id="email-in" name="email" placeholder="example@gmail.com" required pattern="^.+@.+\..+$">
                    </div>

                    <div class="section">
                        <label for="bio-in">Bio:</label>
                        <input type="text" id="bio-in" name="bio-in" placeholder="About you(optional)" >
                    </div>

                    <div class="section">
                        <label for="password">Password:</label>
                        <input type="text" id="password" name="password" placeholder="Change Password"  ">

                    </div>

                </form>
                <button type="submit" form='editProfile-form' id="editPerson" class="popup-btn">Save</button>

            </div>


        </div>

</body>
<?php include("../../includes/profile_scripts.php"); ?>
</html>