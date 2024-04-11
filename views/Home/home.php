<!DOCTYPE html>
<html lang="en">

<head>
    <title>Garden</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" href="../../css_folder/globalcss/globalCss.css">
    <link rel="stylesheet" href="../../css_folder/pop-up.css" />
    <link rel="stylesheet" href="../../css_folder/garden.css" />
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
                <h1 class="app-content-headerText">Welcome To your Garden</h1>

                <button class="mode-switch" title="Switch Theme">
                    <svg class="moon" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
                        <defs></defs>
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>
                <button class="app-content-headerButton open-popup-btn" data-popup-id="addplant">Add Plant</button>
                
            </div>


            <div class="gardenContainer">
                <div class="garden">

                    

                </div>
            </div>


            <div class="app-content-header ">
                <div class="  account-info-picture " data-id="info">
                    <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="white">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>profile_round [#1346]</title>
                            <desc>Created with Sketch.</desc>
                            <defs> </defs>
                            <g id="Page-1"  stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-380.000000, -2119.000000)" fill='none'>
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M338.083123,1964.99998 C338.083123,1962.79398 336.251842,1960.99998 334,1960.99998 C331.748158,1960.99998 329.916877,1962.79398 329.916877,1964.99998 C329.916877,1967.20599 331.748158,1968.99999 334,1968.99999 C336.251842,1968.99999 338.083123,1967.20599 338.083123,1964.99998 M341.945758,1979 L340.124685,1979 C339.561214,1979 339.103904,1978.552 339.103904,1978 C339.103904,1977.448 339.561214,1977 340.124685,1977 L340.5626,1977 C341.26898,1977 341.790599,1976.303 341.523154,1975.662 C340.286989,1972.69799 337.383888,1970.99999 334,1970.99999 C330.616112,1970.99999 327.713011,1972.69799 326.476846,1975.662 C326.209401,1976.303 326.73102,1977 327.4374,1977 L327.875315,1977 C328.438786,1977 328.896096,1977.448 328.896096,1978 C328.896096,1978.552 328.438786,1979 327.875315,1979 L326.054242,1979 C324.778266,1979 323.773818,1977.857 324.044325,1976.636 C324.787453,1973.27699 327.107688,1970.79799 330.163906,1969.67299 C328.769519,1968.57399 327.875315,1966.88999 327.875315,1964.99998 C327.875315,1961.44898 331.023403,1958.61898 334.733941,1959.04198 C337.422678,1959.34798 339.650022,1961.44698 340.05323,1964.06998 C340.400296,1966.33099 339.456073,1968.39599 337.836094,1969.67299 C340.892312,1970.79799 343.212547,1973.27699 343.955675,1976.636 C344.226182,1977.857 343.221734,1979 341.945758,1979 M337.062342,1978 C337.062342,1978.552 336.605033,1979 336.041562,1979 L331.958438,1979 C331.394967,1979 330.937658,1978.552 330.937658,1978 C330.937658,1977.448 331.394967,1977 331.958438,1977 L336.041562,1977 C336.605033,1977 337.062342,1977.448 337.062342,1978" id="profile_round-[#1346]"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>

                <div class="  account-info-picture open-popup-btn log" data-popup-Id="logoutPopup">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17"  stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M15 12L2 12M2 12L5.5 9M2 12L5.5 15"  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>

            </div>


        </div>

    </div>

    <div class="popup-region">
        <div id="addplant" class="popup">
            <form action="#" id="add-Plant-form" name="add-Plant-form" method="post">

                <div class="popup-title">
                    <label for="close-btn">Add new Plant</label>
                    <div>
                        <button class="close-btn" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <hr>
                <div class="col" id="col-1">
                    <div class="section" id="plantNameSec">
                        <label for="plantname">Plant Name:</label>
                        <input type="text" id="plantname" name="plantname" placeholder="Plant Name" required>
                    </div>

                    <div class="section" id="species">
                        <label for="plantspecies">Species:</label>
                        <input type="text" id="plantspecies" name="plantspecies" placeholder="Eg. Fern" required>
                    </div>

                    <div class="section" id="Description">
                        <label for="plantdescription">Description</label>
                        <input type="text" id="plantdescription" name="plantdescription" placeholder="Eg. Short shrub with thorns" required>
                    </div>
                    <div class="section" id="notes">
                        <label for="plantnotes">Notes</label>
                        <input type="text" id="plantnotes" name="plantnotes" placeholder="Optional">
                    </div>
                </div>
                <button type="submit" id="addplant" class="popup-btn">Add</button>
            </form>
        </div>

        <div id="logoutPopup" class="popup">

            <div class="popup-title">
                <label for="close-btn"> Logout</label>
                <div>
                    <button class="close-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"   stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>


            <button type="button" id="logout-btn" class="popup-btn">Logout ?</button>


        </div>
    </div>

</body>
<?php include("../../includes/garden_scripts.php"); ?>

</html>