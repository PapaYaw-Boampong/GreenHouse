
// Light mode switch
// Add class indicating page loading
document.addEventListener('DOMContentLoaded', function () {
  var modeSwitches = document.querySelectorAll('.mode-switch');

  // Function to toggle mode and store in local storage
  function toggleMode() {
    // Toggle light mode class on the document
    document.documentElement.classList.toggle('light');

    // Toggle active class on all mode switch buttons
    modeSwitches.forEach(function (btn) {
      btn.classList.toggle('active');
    });

    // Store current mode in local storage
    var currentMode = document.documentElement.classList.contains('light') ? 'light' : 'dark';
    localStorage.setItem('mode', currentMode);
  }

  // Apply stored mode when page is loaded
  var storedMode = localStorage.getItem('mode');
  if (storedMode) {
    document.documentElement.classList.add(storedMode);
  }

  // Add click event listener to mode switches
  if (modeSwitches) {
    modeSwitches.forEach(function (modeSwitch) {
      modeSwitch.addEventListener('click', toggleMode);
    });
  }
});

// Selecting sidebar list items
var sidebarItems = document.querySelectorAll('.sidebar-list-item');
if (sidebarItems) {
  sidebarItems.forEach(function (item) {
    item.addEventListener('click', function () {
      sidebarItems.forEach(function (otherItem) {
        otherItem.classList.remove('active');
      });
      item.classList.add('active');
    });
  });

}


// Select the button element by its ID
const gardenButton = document.getElementById('bkGarden');
// Add a click event listener to the button
if (gardenButton) {
  gardenButton.addEventListener('click', function () {
    // Define the target page URL
    const targetPage = '../Home/home.php';

    // Redirect the page to the target page URL
    window.location.href = targetPage;
  });
}

// Function to switch display divs
function togglePages(event) {
  event.preventDefault();

  var clickedElement = event.target.closest('a');

  var homePage = document.querySelector('.home');
  var manageCare = document.querySelector('.plantCare');
  var assignTasks = document.querySelector('.taskManager');

  if (clickedElement) {
    if (homePage) {
      homePage.classList.toggle('hidden', clickedElement.textContent.trim() !== "Home");
    }
    if (manageCare) {
      manageCare.classList.toggle('hidden', clickedElement.textContent.trim() !== "Plant Care");
    }
    if (assignTasks) {
      assignTasks.classList.toggle('hidden', clickedElement.textContent.trim() !== "Tasks");
    }
  }
}

// Function to show the overlay and specified pop-up
function showPopup(popupId) {
  const overlay = document.querySelector('.popup-overlay');
  const popup = document.getElementById(popupId);
  if (overlay) {
    overlay.classList.add('active');
  }
  if (popup) {
    popup.classList.add('active');
  }
}

// Function to empty the contents of the form
function closeForm(button) {
  const form = button.closest('form');
  if (form) {
    form.reset();
  }
}

// Function to hide all pop-ups and overlay
function hidePopup() {
  const overlay = document.querySelector('.popup-overlay');
  const popups = document.querySelectorAll('.popup');
  if (overlay) {
    overlay.classList.remove('active');
  }
  if (popups) {
    popups.forEach(popup => {
      if (popup) {
        popup.classList.remove('active');
      }
    });
  }
}

// Add event listeners to open pop-up buttons
function setupOpenPopupButtons() {
  const openPopupButtons = document.querySelectorAll('.open-popup-btn');
  if (openPopupButtons) {
    openPopupButtons.forEach(button => {
      button.addEventListener('click', function () {
        const popupId = this.dataset.popupId;
        if (popupId) {
          showPopup(popupId);
        }
      });
    });
  }
}

// Add event listener to close buttons
function setupCloseButtons() {
  const closeButtons = document.querySelectorAll('.close-btn');
  if (closeButtons) {
    closeButtons.forEach(button => {
      button.addEventListener('click', function () {
        hidePopup();
        closeForm(button);
      });
    });
  }
}

// Global object to store total completion counts and totals overall
let globalStats = {
  totalCompletionCounts: 0,
  totalOverall: 0
};

// Function to calculate the total and completed tasks
function totalAndCompletedTasks(createdDate, currentDate, schedule, count) {

  let totalTasks = 0;
  // Convert the dates to "YYYY-MM-DD" format
  let dateString1 = currentDate.toISOString().split('T')[0];
  let dateString2 = createdDate.toISOString().split('T')[0];
  if (dateString1 === dateString2) {
    totalTasks = 1;
  } else {
    switch (schedule) {
      case 'Daily':
        totalTasks = Math.floor((currentDate - createdDate) / (24 * 60 * 60 * 1000));
        break;
      case 'Weekly':
        totalTasks = Math.floor((currentDate - createdDate) / (7 * 24 * 60 * 60 * 1000));
        break;
      case 'Monthly':
        totalTasks = Math.floor((currentDate - createdDate) / (30 * 24 * 60 * 60 * 1000));
        break;
      case 'Yearly':
        totalTasks = Math.floor((currentDate - createdDate) / (365 * 24 * 60 * 60 * 1000));
        break;
      default:
        console.error('Invalid schedule provided');
        return { total: null, completed: null };
    }

  }


  // Update the global statistics
  globalStats.totalCompletionCounts += count;
  globalStats.totalOverall += totalTasks;

  return { total: totalTasks };
}

// Function to calculate the completion percentage
function calculateCompletionPercentage(createdDate, currentDate, count, schedule) {
  // Calculate the total number of required task completions based on the schedule
  let totalAndCompleted = totalAndCompletedTasks(createdDate, currentDate, schedule, count);

  let totalTasks = totalAndCompleted.total;

  // Calculate the completion percentage based on the recorded completions

  let percentage = totalTasks ? (count / totalTasks) * 100 : 0;

  return { completionPercentage: percentage, totalTasks, count };
}


// load task edit info
function loadEditInfo(event) {
  var editBtn = event.target.closest('.edit-btn');
  console.log(editBtn);

  document.getElementById('editTask-form').dataset.id = editBtn.dataset.taskid;
  // Fetch request to the PHP script
  fetch('../../server/Get/getSchedules.php', {
    method: 'GET'
  }).then(response => response.json())
    .then(data => {
      // Check if the request was successful
      if (data.success) {
        const scheduleSelect = document.getElementById('editTasksch');
        scheduleSelect.innerHTML = "";
        // Loop through the plant care information and create options
        data.schedules.forEach(sch => {
          const option = document.createElement('option');
          option.value = sch.schedule_id;
          option.textContent = sch.schedule_name;

          // Append the option to the select element
          scheduleSelect.appendChild(option);
        });
      } else {
        // Handle error message if request was not successful
        console.error(data.message);
      }
    })
    .catch(error => {
      // Handle error if fetch request fails
      console.error('Error:', error);
    });
}

function loadTaskInfo(event){
  var infoButton = event.target.closest('.info-btn');
  var rowId = infoButton.dataset.taskid;
  // Select the row element with the given rowId
  const row = document.querySelector(`.products-row[data-row-id="${rowId}"]`);
  console.log(rowId);

  // Check if the row exists
  if (row) {
      // Accessing the text content of cells within the row
      const statusCellText = row.querySelector('.product-cell.status').textContent;
      const dateCreatedText = row.querySelector('.product-cell.datecreated').textContent;
      const dateNextText = row.querySelector('.product-cell.datenext').textContent;
      const scheduleCellText = row.querySelector('.product-cell.schedule').textContent;

      document.getElementById('status-info').textContent = `Status: ${statusCellText}`;
      document.getElementById('date-created-info').textContent = `Date Created: ${dateCreatedText}`;
      document.getElementById('date-next-info').textContent = `Date Next: ${dateNextText}`;
      document.getElementById('schedule-info').textContent = `Schedule: ${scheduleCellText}`;
  } 


}

// function to handle task deletions
function handleTaskDeleteButtonClick(event) {
  // Get the parent button element containing the SVG
  const deleteButton = event.target.closest('.delete-button');
  // Get the task ID from the dataset attribute of the clicked button
  const taskId = deleteButton.dataset.taskid;


  // Show confirmation dialog
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      // If user confirms, make AJAX request to delete the task
      fetch('../../server/Delete/deleteTask.php', {
        method: 'POST',
        body: JSON.stringify({ task_id: taskId }),
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(response => response.json())
        .then(data => {
          // Handle the response
          if (data.success) {
            // Show success message
            swal(
              'Deleted!',
              'Task deleted.',
              'success'
            ).then(() => {
              // Refresh the page to reflect the changes
              window.location.reload();
            });
          } else {
            // Show error message
            swal(
              'Error!',
              data.message,
              'error'
            );
          }
        }).catch(error => {
          // Show error message if request fails
          swal(
            'Error!',
            'An error occurred while processing your request.',
            'error'
          );
        });
    } else {
      // User cancelled the deletion
      swal("Aborted");
    }
  });
}

function buildTable2(data, currentDate) {
  const tableContainer = document.querySelector(".tableView.Tasks");
  tableContainer.innerHTML = ""; // Clear existing content

  // Add table title
  tableContainer.innerHTML += `
        <div class="table-title">
            <div class="link">
                <a href="#">
                    Manage Tasks
                </a>
               
            </div>
            <div>Scroll</div>
        </div>
    `;

  // Add table headers
  tableContainer.innerHTML += `
        <div class="products-header">
            <div class="product-cell care"> Care Title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell datecreated"> Created</div>
            <div class="product-cell datenext">NextDue</div>
            <div class="product-cell schedule">Schedule</div>
            <div class="product-cell action">Action</div>
        </div>
    `;

  const tableContents = document.createElement('div')
  tableContents.classList.add('tablecontents');
  tableContents.id = 'Tasktablecontents';
  tableContainer.appendChild(tableContents);

  if (data.length === 0) {
    const noDataMessage = document.createElement('div');

    noDataMessage.classList.add('products-row');
    noDataMessage.classList.add('product-cell');
    noDataMessage.textContent = 'Care Task Display Here';
    tableContents.appendChild(noDataMessage);
    return;
  }


  // Add table rows
  data.forEach((task) => {
    const {
      activity_name,
      status_name,
      status_id,
      last_activity_update,
      schedule_name,
      schedule_id,
      task_id,
      activity_id,
      created_at
    } = task;
    const nextDueDate = calculateNextDueDate(
      new Date(last_activity_update),
      new Date(),
      schedule_name
    );
    const row = document.createElement('div');
    row.classList.add('products-row');
    row.dataset.rowId = task_id;

    row.innerHTML += `
       
                <div class="product-cell care" data-careId="${activity_id}">${activity_name}</div>
                <div class="product-cell status" data-statusId = "${status_id}">${status_name}</div>
                <div class="product-cell datecreated">${created_at}</div>
                <div class="product-cell datenext">${nextDueDate}</div>
                <div class="product-cell schedule" data-scheduleID = "${schedule_id}">${schedule_name}</div>
                <div class="product-cell action">
                    <div class="action-buttons">
                        <button class="action-btn open-popup-btn edit-btn" data-popup-Id='editTask' data-taskId="${task_id}">
                            <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <path fill="none" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                            </svg>
                        </button>
                        <button class="action-btn delete-button del-btn-task" data-taskId="${task_id}">
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
                        <button class="action-btn open-popup-btn info-btn" data-popup-Id='Task-info' data-taskId="${task_id}">
                        <svg  height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32.055 32.055" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M3.968,12.061C1.775,12.061,0,13.835,0,16.027c0,2.192,1.773,3.967,3.968,3.967c2.189,0,3.966-1.772,3.966-3.967 C7.934,13.835,6.157,12.061,3.968,12.061z M16.233,12.061c-2.188,0-3.968,1.773-3.968,3.965c0,2.192,1.778,3.967,3.968,3.967 s3.97-1.772,3.97-3.967C20.201,13.835,18.423,12.061,16.233,12.061z M28.09,12.061c-2.192,0-3.969,1.774-3.969,3.967 c0,2.19,1.774,3.965,3.969,3.965c2.188,0,3.965-1.772,3.965-3.965S30.278,12.061,28.09,12.061z"></path> </g> </g></svg>
                        </button>
                    </div>
                </div>
    
        `;

    tableContents.appendChild(row);

    // Add event listener to the delete button in this row
    const deleteButton = row.querySelector(`.delete-button`);
    deleteButton.addEventListener('click', handleTaskDeleteButtonClick);

    const editButton = row.querySelector(`.edit-btn`);
    editButton.addEventListener('click', loadEditInfo);

    const infoButton = row.querySelector(`.info-btn`);
    infoButton.addEventListener('click', loadTaskInfo);


  });
  setupOpenPopupButtons();
  setupCloseButtons();

}
function buildTable1(data) {
  var tableContainer = document.getElementById('Hometable');
  tableContainer.innerHTML = ""; // Clear existing content


  // Add table headers
  tableContainer.innerHTML += `
        <div class="products-header">
            <div class="product-cell care"> Care title</div>
            <div class="product-cell status"> Status</div>
            <div class="product-cell nxtdue">Next Due</div>
            <div class="product-cell check">
                Check
            </div>
        </div>
    `;

  const tableContents = document.createElement('div')
  tableContents.classList.add('tablecontents');
  tableContainer.appendChild(tableContents);


  if (data.length === 0) {
    const noDataMessage = document.createElement('div');

    noDataMessage.classList.add('products-row');
    noDataMessage.classList.add('product-cell');
    noDataMessage.textContent = 'Care Task Display Here';
    tableContents.appendChild(noDataMessage);
    return;
  }

  // Add table rows
  data.forEach((task) => {

    if (task.status_id === "2") {
      const {
        task_id,
        activity_name,
        status_name,
        status_id,
        last_activity_update,
        activity_count,
        activity_id,
        schedule_name,
        schedule_id
      } = task;
      const nextDueDate = calculateNextDueDate(
        new Date(last_activity_update),
        new Date(),
        schedule_name
      ); // Assuming 'daily' schedule for Table 1
      tableContents.innerHTML += `
              <div class="products-row" data-rowId="${task_id}">
                  <div class="product-cell care" data-careId="${activity_id}">${activity_name}</div>
                  <div class="product-cell status" data-statusId = "${status_id}" data-taskId ="${task_id}">${status_name}</div>
                  <div class="product-cell nxtdue">${nextDueDate}</div>
                  <div class="product-cell check">
                      <label class="toggle-switch">
                          <input type="checkbox" class="toggle-checkbox" data-toggle-id="${task_id}">
                          <div class="toggle-switch-background">
                              <div class="toggle-switch-handle"></div>
                          </div>
                      </label>
                  </div>
              </div>
          `;
    }

  });
}


// Function to populate the stat containers
function populateStatContainers(statsInformation) {
  // Get the container element
  let statContainer = document.querySelector('.stats');

  // Loop through the stats information and populate the container
  statsInformation.forEach(statInfo => {
    // Create the stat element
    let statElement = document.createElement('div');
    statElement.classList.add('stat');

    // Create the anchor element
    let anchorElement = document.createElement('a');
    anchorElement.href = '#';
    anchorElement.dataset.id = statInfo.task_id;
    anchorElement.dataset.name = statInfo.activity_name;

    // Create the state container
    let stateContainer = document.createElement('div');
    stateContainer.classList.add('state-container');
    stateContainer.id = `stat-${statInfo.task_id}`; // Assuming each stat has a unique name

    // Create the state tag
    let stateTag = document.createElement('div');
    stateTag.classList.add('state-tag');

    // Create the icon container
    let iconContainer = document.createElement('div');
    iconContainer.classList.add('icon');

    // SVG HTML
    let iconSVGHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
          <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>`;

    // Set the HTML content of the icon container
    iconContainer.innerHTML = iconSVGHTML;

    // Create the span for the stat name
    let statNameSpan = document.createElement('span');
    statNameSpan.textContent = statInfo.activity_name;

    // Append elements to state tag
    stateTag.appendChild(iconContainer);
    stateTag.appendChild(statNameSpan);

    // Create the state number element
    let stateNumElement = document.createElement('div');
    stateNumElement.classList.add('state-num');
    stateNumElement.id = `stat-${statInfo.task_id}-num`;

    // Append state tag and state number to state container
    stateContainer.appendChild(stateTag);
    stateContainer.appendChild(stateNumElement);

    // Append state container to anchor element
    anchorElement.appendChild(stateContainer);

    // Append anchor element to stat element
    statElement.appendChild(anchorElement);

    // Append stat element to stat container
    statContainer.appendChild(statElement);

    // Calculate completion percentage and update the UI
    let { completionPercentage, totalTasks, count } = calculateCompletionPercentage(
      new Date(statInfo.created_at),
      new Date(), parseInt(statInfo.activity_count),
      statInfo.schedule_name);
    document.getElementById(`stat-${statInfo.task_id}-num`).textContent = `${count}/${totalTasks} (${completionPercentage.toFixed(2)}%)`;
  });
}


// Function to generate the next due dates
function calculateNextDueDate(lastUpdatedDate, currentDate, schedule) {
  let nextDueDate = new Date(lastUpdatedDate); // Initialize next due date with the last updated date

  // Update the next due date based on the schedule
  switch (schedule) {
    case 'Daily':
      while (nextDueDate < currentDate) {
        nextDueDate.setDate(nextDueDate.getDate() + 1); // Increment by 1 day
      }
      break;
    case 'Weekly':
      while (nextDueDate < currentDate) {
        nextDueDate.setDate(nextDueDate.getDate() + 7); // Increment by 7 days
      }
      break;
    case 'Monthly':
      while (nextDueDate < currentDate) {
        nextDueDate.setMonth(nextDueDate.getMonth() + 1); // Increment by 1 month
      }
      break;
    case 'Yearly':
      while (nextDueDate < currentDate) {
        nextDueDate.setFullYear(nextDueDate.getFullYear() + 1); // Increment by 1 year
      }
      break;
    default:
      console.error('Invalid schedule provided');
      return null;
  }

  return nextDueDate.toLocaleDateString();
}

function renderPlantStreak(totalCompletionCounts, totalOverall) {
  // Get the plantInfo container element
  let plantInfoContainer = document.getElementById('infosec1');

  // Calculate the overall completion percentage
  let overallPercentage = totalOverall ? (totalCompletionCounts / totalOverall) * 100 : 0;

  // Update the HTML content of the plantInfo container
  plantInfoContainer.innerHTML = `
      <div class="row">
          <div class="info-sec">
              <span>Streak</span>
              <span class="value">${overallPercentage.toFixed(2)}%</span>
              <span class="value">${totalCompletionCounts}/${totalOverall}</span>
              
          </div>
  `;
}

// Updating next due and completion statuses
function updatehistory(plant_Id) {
  fetch('../../server/Put/updateHistory.php', {
    method: 'POST',
    body: JSON.stringify({ plant_Id: plant_Id }),
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => response.json())
    .then(data => {
      // Handle the response
      if (data.success) {
        // Show success message
        console.log(data.message);
      } else {
        console.log(data.message);
      }
    }).catch(error => {
      console.log(data.message);
    });

}


function fetchDataAndBuildTables() {
  var plant_id = localStorage.getItem("selectedPlantId");
  fetch("../../server/Get/getTasks.php?plant_id=" + plant_id, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok || response.success) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        if (data.tasks.length >= 0) {
          updatehistory(plant_id);
          // Process the data and build tables
          buildTable1(data.tasks);
          buildTable2(data.tasks);
          populateStatContainers(data.tasks);
          renderPlantStreak(globalStats.totalCompletionCounts, globalStats.totalOverall)
        }
      } else {
        console.log("Server error");
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
}

// fetching table data
document.addEventListener("DOMContentLoaded", function () {
  var tableContainer = document.getElementById('Hometable');
  if (tableContainer) {
    // Call fetchCareStats function when the document is loaded
    fetchDataAndBuildTables();
  }

});


function updateStatus(statusElement, isChecked, toggleid) {
  if (statusElement) {
    if (isChecked) {
      statusElement.textContent = 'Complete';
      var stat_id = toggleid;
      // Show confirmation dialog
      swal({
        title: "Greet Progress",
        icon: "success",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          // If user confirms, make AJAX request to delete the task
          fetch('../../server/Put/updateStat.php', {
            method: 'POST',
            body: JSON.stringify({ stat_id: stat_id }),
            headers: {
              'Content-Type': 'application/json'
            }
          }).then(response => response.json())
            .then(data => {
              // Handle the response
              if (data.success) {
                // Show success message
                swal(
                  'Deleted!',
                  'loving the momentum ',
                  'success'
                ).then(() => {
                  // Refresh the page to reflect the changes
                  window.location.reload();
                });
              } else {
                // Show error message
                swal(
                  'Error!',
                  data.message,
                  'error'
                );
              }
            }).catch(error => {
              // Show error message if request fails
              swal(
                'Error!',
                'Sorry an Error occured.',
                'error'
              );
            });
        } else {
          // User cancelled the deletion
          swal("Aborted");
        }
      });

    } else {
      statusElement.textContent = 'Incomplete';
    }


  }
}

// Toggle Button
document.addEventListener('change', function (event) {
  if (event.target.classList.contains('toggle-checkbox')) {
    var toggleId = event.target.dataset.toggleId;
    console.log(toggleId);
    var statusElement = document.querySelector(`.status[data-taskId="${toggleId}"]`);
    var isChecked = event.target.checked;
    updateStatus(statusElement, isChecked, toggleId);
  }
});

// Add event listener to handle toggle switch changes
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.sidebar-list-item a').forEach(function (link) {
    link.addEventListener('click', togglePages);
  });
});



// Get the .stats element
let statsElement = document.querySelector('.stats');
if (statsElement) {
  // Add an event listener for the wheel event
  statsElement.addEventListener('wheel', function (event) {
    // Check if the user is scrolling vertically
    if (event.deltaY !== 0) {
      // Invert the scroll direction for horizontal scrolling
      let scrollAmount = event.deltaY * 2; // Adjust the scrolling speed

      // Calculate the new scroll position
      let newScrollLeft = statsElement.scrollLeft + scrollAmount;

      // Smoothly scroll to the new position
      statsElement.scrollTo({
        left: newScrollLeft,
        behavior: 'smooth' // Use smooth scrolling behavior
      });

      // Prevent the default vertical scrolling behavior
      event.preventDefault();
    }
  });
}



// Initialize the popup functionality
document.addEventListener("DOMContentLoaded", function () {
  setupOpenPopupButtons();
  setupCloseButtons();
});

// logout functionality
document.addEventListener("DOMContentLoaded", function () {
  // Select the logout button
  var logoutButton = document.getElementById('logout-btn');
  
  if (logoutButton) {
    // Add click event listener
    logoutButton.addEventListener('click', function () {
      // Send request to logout.php using AJAX
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../../server/Post/logout.php", true); // Changed "Post" to "POST"
      xhr.onload = function () {
        if (xhr.status === 200) {
          swal({
            title: 'Goodbye ;)',
            text: 'Logged out successfully',
            icon: 'success',
            button: 'OK'
          }).then((value) => {
            if (value) {
              localStorage.removeItem('sessionID');
              localStorage.removeItem('mode');
              // Redirect to another page after success if needed
              window.history.replaceState({}, '', 'http://51.11.183.36/GreenHouse/views/Login/login_view.php');

              // Clear history stack
              var len = window.history.length;
              for (var i = 0; i < len; i++) {
                window.history.replaceState({}, '', 'http://51.11.183.36/GreenHouse/views/Login/login_view.php');
              }

              // Redirect to login page
              window.location.href = "http://51.11.183.36/GreenHouse/views/Login/login_view.php";
            }
          });
        } else {
          // Handle errors
          console.error("Error:", xhr.statusText);
        }
      };
      xhr.send();

    });
  }

});




const toggleBtns = document.querySelectorAll('.side-toggle');

toggleBtns.forEach(function(btn) {

  btn.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
      sidebar.classList.toggle('show');
    }
  });
});