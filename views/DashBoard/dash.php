<!DOCTYPE html class="hidden">
<html lang="en">

<head>
  <title>Dashboard</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <link rel="stylesheet" href="../../css_folder/globalcss/globalCss.css">

  <link rel="stylesheet" href="../../css_folder/pop-up.css" />
  <link rel="stylesheet" href="../../css_folder/styles-dash.css" />
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

    <div class="sidebar">

      <div class="sidebar-header">
        <div class="app-icon" id="app-icon-title">
          Green House
        </div>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item <?php echo ($message === 'home' || $message === '') ? 'active' : ''; ?> ">
          <a href="?msg=home">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
              <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <span>Home</span>
          </a>
        </li>
        <li class="sidebar-list-item  <?php echo ($message === 'pc') ? 'active' : ''; ?>">
          <a href="?msg=pc">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
              <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <path d="M16 10a4 4 0 0 1-8 0" />
            </svg>
            <span>Plant Care</span>
          </a>
        </li>
        <li class="sidebar-list-item <?php echo ($message === 'tm') ? 'active' : ''; ?>">
          <a href="?msg=tm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Tasks</span>
          </a>
        </li>

      </ul>

      <div class="account-info">
        <div class="  account-info-picture open-popup-btn" id="side-logout-btn" data-popup-Id="logoutPopup">
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

    <div class="app-content home <?php echo ($message === 'home' || $message === '') ? '' : 'hidden'; ?>">

      <div class="app-content-header ">
        <h1 class="app-content-headerText" id="plant-alias"> Its me </h1>
        <button class="mode-switch" title="Switch Theme">
          <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
            <defs></defs>
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
          </svg>
        </button>

        <div class="headerAction">
          <button class="app-content-headerButton " id="bkGarden">Garden</button>
          <button class="app-content-headerButton open-popup-btn" data-popup-id="editPlant"> Edit Plant</button>
          <button class="app-content-headerButton open-popup-btn" data-popup-id="deletePlant"> Delete Plant</button>
          <button class=" side-toggle" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width='25' height='25' enable-background="new 0 0 24 24" xml:space="preserve">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <g>
                  <g>
                    <g>
                      <path d="M7.5,19.5c-0.8,0-1.5-0.3-2.1-0.9c-1.2-1.2-1.2-3.1,0-4.2c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4c-0.4,0.4-0.4,1,0,1.4 c0.4,0.4,1,0.4,1.4,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4C9,19.2,8.2,19.5,7.5,19.5z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M20.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4c1.2-1.2,1.2-3.1,0-4.2c-1.1-1.1-3.1-1.1-4.2,0 c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4C14.8,5,16,4.5,17.4,4.5S20,5,20.9,5.9c1.9,1.9,1.9,5.1,0,7.1 C20.7,13.2,20.4,13.3,20.2,13.3z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M6,16.1c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C6.6,16,6.3,16.1,6,16.1z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M1.8,19.4"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M11.7,21.8c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C12.2,21.7,12,21.8,11.7,21.8z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M8.9,18.9c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C9.4,18.9,9.1,18.9,8.9,18.9z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4.6,22.2"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M3.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4L13.8,0.3c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4L3.9,13 C3.7,13.2,3.5,13.3,3.2,13.3z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M7.5,23.5c-1.8,0-3.6-0.7-4.9-2c-1.3-1.3-2-3.1-2-4.9s0.7-3.6,2-4.9c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 c-0.9,0.9-1.5,2.2-1.5,3.5c0,1.3,0.5,2.6,1.5,3.5c1.9,1.9,5.1,1.9,7.1,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 C11,22.9,9.3,23.5,7.5,23.5z"></path>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </button>
        </div>
      </div>

      <div class="plantData">
        <div class="plantInfo" id='infosec1'>
          <div class="row">
            <div class="info-sec">
              <span>Streak</span>
              <span class="value"> 100%</span>
            </div>
          </div>
        </div>
        <div class="plantInfo" id='infosec2'>
          <div class="row" id="row1">
            <div class="info-sec" id='sec1'>
              <span>Name :</span>
              <span class="value"> placeholder</span>
            </div>
            <div class="info-sec" id='sec2'>
              <span>Species :</span>
              <span class="value"> placeholder</span>
            </div>
          </div>
          <div class="row">
            <div class="info-sec" id='sec3'>
              <span>Description:</span>
              <p class="value">
                dfdfdf
              </p>
            </div>
            <div class="info-sec" id='sec4'>
              <span>Notes:</span>
              <p class="value">
                zbzagfd
              </p>
            </div>
          </div>

        </div>
      </div>
      <div class="homepagetable" id="hometablecontainer">
        <div class="table-title">
          <div class="link">
            <a href="#">
              To Do
            </a>
          </div>
          <div>Scroll</div>
        </div>
        <div class="tableView homeTasks" id="Hometable">

          <div class="products-header">
            <div class="product-cell care"> Care title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell nxtdue">Next Due</div>
            <div class="product-cell check">
              Check
            </div>
            <div class="product-cell datecreated"> Details </div>

          </div>


          <div class="products-row" data-row-id="">
            <div class="product-cell care"> Care Title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell nxtdue">Next Due</div>
            <div class="product-cell check">
              <label class="toggle-switch">
                <input type="checkbox" class="toggle-checkbox" data-toggle-id="1">
                <div class="toggle-switch-background">
                  <div class="toggle-switch-handle"></div>
                </div>
              </label>
            </div>

            <div class="product-cell action">

              <div class="action-buttons">
                <a href="#">
                  details
                </a>
              </div>
            </div>
          </div>


        </div>
      </div>




    </div>

    <div class="app-content plantCare <?php echo ($message === 'pc') ? '' : 'hidden'; ?>">

      <div class="app-content-header ">
        <h1 class="app-content-headerText">Care Activities </h1>
        <button class="mode-switch" title="Switch Theme">
          <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
            <defs></defs>
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
          </svg>
        </button>
        <div class="headerAction">
          <button class="app-content-headerButton open-popup-btn" data-popup-id="addPlantCare">Add Plant Care</button>
          <button class="app-content-headerButton open-popup-btn" id='create-plt' data-popup-id="createPlantCare">Create Custom Care</button>
          
        </div>
        <button class=" side-toggle" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width='25' height='25' enable-background="new 0 0 24 24" xml:space="preserve">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <g>
                  <g>
                    <g>
                      <path d="M7.5,19.5c-0.8,0-1.5-0.3-2.1-0.9c-1.2-1.2-1.2-3.1,0-4.2c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4c-0.4,0.4-0.4,1,0,1.4 c0.4,0.4,1,0.4,1.4,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4C9,19.2,8.2,19.5,7.5,19.5z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M20.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4c1.2-1.2,1.2-3.1,0-4.2c-1.1-1.1-3.1-1.1-4.2,0 c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4C14.8,5,16,4.5,17.4,4.5S20,5,20.9,5.9c1.9,1.9,1.9,5.1,0,7.1 C20.7,13.2,20.4,13.3,20.2,13.3z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M6,16.1c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C6.6,16,6.3,16.1,6,16.1z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M1.8,19.4"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M11.7,21.8c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C12.2,21.7,12,21.8,11.7,21.8z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M8.9,18.9c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C9.4,18.9,9.1,18.9,8.9,18.9z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4.6,22.2"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M3.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4L13.8,0.3c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4L3.9,13 C3.7,13.2,3.5,13.3,3.2,13.3z"></path>
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M7.5,23.5c-1.8,0-3.6-0.7-4.9-2c-1.3-1.3-2-3.1-2-4.9s0.7-3.6,2-4.9c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 c-0.9,0.9-1.5,2.2-1.5,3.5c0,1.3,0.5,2.6,1.5,3.5c1.9,1.9,5.1,1.9,7.1,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 C11,22.9,9.3,23.5,7.5,23.5z"></path>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </button>

      </div>
      <div class="stat-container">
        <div class="stats">

        </div>
      </div>
      <div class="plantcaretable">
        <div class="table-title">
          <div class="link">
            <a href="#">
              Plant Care Added
            </a>
          </div>
          <div>Scroll</div>
        </div>
        <div class="tableView " id="pc-table">

          <div class="products-header">
            <div class="product-cell care">Plant Care</div>
            <div class="product-cell description">Description</div>
            <div class="product-cell action">Actions</div>
          </div>


        </div>
      </div>
    </div>

    <div class="app-content taskManager <?php echo ($message === 'tm') ? '' : 'hidden'; ?>">

      <div class="app-content-header ">
        <h1 class="app-content-headerText"> Tasks</h1>
        <button class="mode-switch" title="Switch Theme">
          <svg class="moon" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
            <defs></defs>
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
          </svg>
        </button>
        <button class="app-content-headerButton open-popup-btn" data-popup-id="addTask"> Add Task </button>
       
      </div>
      <button class="  side-toggle" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width='25' height='25' enable-background="new 0 0 24 24" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <g>
                <g>
                  <g>
                    <path d="M7.5,19.5c-0.8,0-1.5-0.3-2.1-0.9c-1.2-1.2-1.2-3.1,0-4.2c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4c-0.4,0.4-0.4,1,0,1.4 c0.4,0.4,1,0.4,1.4,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4C9,19.2,8.2,19.5,7.5,19.5z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M20.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4c1.2-1.2,1.2-3.1,0-4.2c-1.1-1.1-3.1-1.1-4.2,0 c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4C14.8,5,16,4.5,17.4,4.5S20,5,20.9,5.9c1.9,1.9,1.9,5.1,0,7.1 C20.7,13.2,20.4,13.3,20.2,13.3z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M6,16.1c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C6.6,16,6.3,16.1,6,16.1z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M1.8,19.4"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M11.7,21.8c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C12.2,21.7,12,21.8,11.7,21.8z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M8.9,18.9c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4l-8.5,8.5 C9.4,18.9,9.1,18.9,8.9,18.9z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path stroke="#2D2D2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4.6,22.2"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M3.2,13.3c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1,0-1.4L13.8,0.3c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4L3.9,13 C3.7,13.2,3.5,13.3,3.2,13.3z"></path>
                  </g>
                </g>
                <g>
                  <g>
                    <path d="M7.5,23.5c-1.8,0-3.6-0.7-4.9-2c-1.3-1.3-2-3.1-2-4.9s0.7-3.6,2-4.9c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 c-0.9,0.9-1.5,2.2-1.5,3.5c0,1.3,0.5,2.6,1.5,3.5c1.9,1.9,5.1,1.9,7.1,0c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 C11,22.9,9.3,23.5,7.5,23.5z"></path>
                  </g>
                </g>
              </g>
            </g>
          </svg>
        </button>

      <div class="taskmanagertable">
        <div class="tableView Tasks" id="tasktable">
          <div class="table-title">
            <div class="link">
              <a href="#">
                Manage Tasks
              </a>
            </div>
          </div>
          <div class="products-header">
            <div class="product-cell care"> Care Title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell datecreated"> Created</div>
            <div class="product-cell datenext">NextDue</div>
            <div class="product-cell schedule">Schedule</div>
            <div class="product-cell action">Action</div>
          </div>


          <div class="products-row" data-row-id="">
            <div class="product-cell care"> Care Title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell datecreated"> Created</div>
            <div class="product-cell datenext">NextDue</div>
            <div class="product-cell schedule">Schedule</div>
            <div class="product-cell action">

              <div class="action-buttons">

                <!-- Edit button with SVG icon -->
                <button class="action-btn open-popup-btn edit-btn" data-popup-Id='editTask' data-taskId="<?php echo $a["Task_ID"]; ?>">
                  <svg width="25px" height="25px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <path fill="none" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                  </svg>
                </button>

                <!-- Delete button with SVG icon -->
                <button class="action-btn delete-button del-btn" data-taskId="">

                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                      <path d="M10 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M14 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M4 7H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                  </svg>

                </button>

              </div>
            </div>
          </div>


        </div>
      </div>

    </div>

  </div>

  <div class="popup-region">

    <div id="addTask" class="popup">
      <form action="#" id="addTask-form" name="addTask-form" method="post">
        <div class="popup-title">
          <label for="close-btn"> Create Task</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
        <hr>

        <div class="col" id="col-1">
          <div class="section" id="plantcare-name">
            <label for="pc-name">Plant Care: </label>
            <select name="pc-name" id="plant-care"></select>
          </div>

          <div class="section" id="schedule">
            <label for="schedule">Task Schedule:</label>
            <select name="pc-schedule" id="plant-schedule"></select>
          </div>
        </div>
        <button type="submit" id="addTask-btn" class="popup-btn"> Add </button>
      </form>
    </div>

    <div id="addPlantCare" class=" popup">
      <form action="#" id="addPlantCare-form" name="addPlantCare-form" method="POST">
        <div class="popup-title">
          <label for=" close-btn">Add Custom Plant Care</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
        <hr>
        <div class="col" id="col-1">
          <div class="section" id="plantcare-name">
            <label for="pc-name">Plant Care Name:</label>
            <select name="pc-name" id="pc-name"></select>
          </div>
        </div>
        <button type="submit" id="addPlantCare-btn" class="popup-btn"> Add </button>
      </form>
    </div>

    <div id="editTask" class="popup">
      <form id="editTask-form" name="editTask-form" method="POST">
        <div class="popup-title">
          <label for=" close-btn">Edit Task</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>

        <hr>

        <div class="col" id="col-1">

          <div class="section" id="schedule">
            <label for="schedule-in">Task Schedule:</label>
            <select name="task-sch" id="editTasksch"></select>
          </div>
        </div>
        <button type="submit" id="editTask-btn" class="popup-btn"> save </button>

      </form>

    </div>

    <div id="editPlant" class="popup">
      <form action="#" id="editPlant-form" name="editPlant-form" method="post">

        <div class="popup-title">
          <label for="close-btn"> Edit Plant</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
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
        <button type="submit" form="editPlant-form" id="addplant" class="popup-btn">Add</button>
      </form>
    </div>

    <div id="createPlantCare" class=" popup">

      <form action="#" id="createPlantCare-form" name="createPlantCare-form" method="POST">
        <div class="popup-title">
          <label for=" close-btn">Customize Care</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
        <hr>
        <div class="col" id="col-1">

          <div class="section" id="plantcare-name">
            <label for="pc-name">Plant Care Name:</label>
            <input type="text" id="pc-name" name="pc-name" placeholder="Eg. DePrunning" required>
          </div>

          <div class="section" id="Description">
            <label for="plantdesc">Description</label>
            <input type="text" id="plantdesc" name="pc-description" placeholder="Eg. removing thorns" required>
          </div>


        </div>
        <button type="submit" id="createPlantCare-btn" class="popup-btn"> Save </button>
      </form>

    </div>
    <div id="editPlantCare" class=" popup">

      <form action="#" id="editPlantCare-form" name="editPlantCare-form" method="POST">
        <div class="popup-title">
          <label for=" close-btn">Customize Care</label>
          <div>
            <button class="close-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
        <hr>
        <div class="col" id="col-1">

          <div class="section" id="plantcare-name">
            <label for="pc-name">Plant Care Name:</label>
            <input type="text" id="care-pc-name" name="pc-name" placeholder="Eg. DePrunning" required>
          </div>

          <div class="section" id="Description">
            <label for="plantdesc">Description</label>
            <input type="text" id="care-plantdesc" name="pc-description" placeholder="Eg. removing thorns" required>
          </div>


        </div>
        <button type="submit" id="editPlantCare-btn" class="popup-btn"> Save </button>
      </form>

    </div>


    <div id="Task-info" class=" popup">
      <div class="popup-title">
        <label for="close-btn"> Plant Info : </label>
        <div>
          <button class="close-btn" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <div class="popup-content">
        <div id="status-info"></div>
        <div id="date-created-info"></div>
        <div id="date-next-info"></div>
        <div id="schedule-info"></div>
      </div>


    </div>

  </div>

  <div id="logoutPopup" class="popup">

    <div class="popup-title">
      <label for="close-btn"> Logout</label>
      <div>
        <button class="close-btn" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="currentcolor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
    </div>


    <button type="button" id="logout-btn" class="popup-btn">Logout ?</button>


  </div>

</body>
<?php include("../../includes/dash_scripts.php") ?>

</html>