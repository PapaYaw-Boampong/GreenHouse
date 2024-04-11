
function handleCareEditFormSubmission(event) {
  event.preventDefault(); // Prevent form submission

  const form = new FormData(document.getElementById('editPlantCare-form'))
  careId = event.target.dataset.id;
  custom = event.target.dataset.custom
  form.append('care_Id', careId);

  if (custom === "-1") {
    swal({
      text: 'Cannot edit Default Care',
      icon: 'warning',
      button: 'OK'
    });
  } else {
    fetch('../../server/Put/updateCare.php', {
      method: 'POST',
      body: form
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
  }

}

// load task edit info
function loadCareEditInfo(event) {
  var editBtn = event.target.closest('.edit-btn');

  var row = event.target.closest('.products-row');

  document.getElementById('editPlantCare-form').dataset.id = editBtn.dataset.id;
  document.getElementById('editPlantCare-form').dataset.custom = editBtn.dataset.custom;
  const care = row.querySelector('.care').textContent;
  const desc = row.querySelector('.description').textContent;

  document.getElementById('care-pc-name').value = care;
  document.getElementById('care-plantdesc').value = desc;
}

// Add event listener to handle edit form submission
document.getElementById('editPlantCare-form').addEventListener('submit', handleCareEditFormSubmission);


// Function to handle edit form submission
function handleEditFormSubmission(event) {
  event.preventDefault();

  // Get chore ID and updated chore name
  var form = event.target;
  var choreId = form.querySelector('input#old-chore').dataset.choreId;
  var choreName = form.querySelector('input[name="choreName"]').value;

  // Send AJAX request to update chore
  var xhr = new XMLHttpRequest();

  xhr.open('POST', '../../actions/edit_chore_action.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 400) {
      // Chore updated successfully
      hidePopup();
      setupCloseButtons()
      swal({
        title: 'Success!',
        text: 'New Chore Added.',
        icon: 'success',
        button: 'OK'
      }).then((value) => {
        if (value) {
          // Redirect to another page after success if needed

        }
      });
    } else {
      // Handle error
      console.error('Failed to update chore');
    }
  };
  xhr.onerror = function () {
    // Handle error
    console.error('Failed to update chore');
  };
  // Log the JSON payload before sending the request
  var payload = JSON.stringify({ id: choreId, name: choreName });

  xhr.send(payload); // Send the request with chore ID and name in JSON format



}


// function to handle task deletions
function handleCareDeleteButtonClick(event) {
  // Get the parent button element containing the SVG
  const deleteButton = event.target.closest('.delete-button');
  // Get the task ID from the dataset attribute of the clicked button
  const care_id = deleteButton.dataset.id;
  const custom = deleteButton.dataset.custom;
  console.log(deleteButton)

  if (custom === '-1') {
    // Show confirmation dialog
    swal({
      title: "Are you sure?",
      text: "Custom Item will be removed from you plant but still avialable",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        // If user confirms, make AJAX request to delete the task
        fetch('../../server/Delete/deleteCareItem.php', {
          method: 'POST',
          body: JSON.stringify({
            care_Id: care_id,
            custom: true
          }),
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
                'Add Care to re-Add',
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
  } else {
    // Show confirmation dialog
    swal({
      title: "Are you sure?",
      text: "Item cannot be retrieved",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        // If user confirms, make AJAX request to delete the task
        fetch('../../server/Delete/deleteCareItem.php', {
          method: 'POST',
          body: JSON.stringify({
            care_Id: care_id,
            custom: false
          }),
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
                'Successfully Removed',
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



}

// Function to render plant care data in the table
function renderPlantCareData(plantCareData) {
  const pcTable = document.getElementById('pc-table');

  // Clear previous content of the table
  pcTable.innerHTML = '';

  // Create table header
  const tableHeader = document.createElement('div');
  tableHeader.classList.add('products-header');
  tableHeader.innerHTML = `
    <div class="product-cell care">Plant Care</div>
    <div class="product-cell description">Description</div>
    <div class="product-cell action">Actions</div>
  `;
  pcTable.appendChild(tableHeader);

  const tableContents = document.createElement('div')
  tableContents.classList.add('tablecontents');
  pcTable.appendChild(tableContents);

  


  // Check if plant care data is empty
  if (plantCareData.length === 0) {
    const noDataMessage = document.createElement('div');

    noDataMessage.classList.add('products-row');
    noDataMessage.classList.add('product-cell');
    noDataMessage.textContent = 'Add Plant Care Here';
    pcTable.appendChild(noDataMessage);
    return;
  }

  // Iterate over plant care data and create table rows
  plantCareData.forEach(plantCare => {
    const row = document.createElement('div');
    row.classList.add('products-row');

    row.dataset.id = plantCare.activity_id;

    row.innerHTML = `
      <div class="product-cell care">${plantCare.activity_name}</div>
      <div class="product-cell description">${plantCare.description}</div>
      <div class="product-cell action">
        <div class="action-buttons">
          <button class="action-btn open-popup-btn edit-btn" data-popup-Id="editPlantCare"  data-custom = "${plantCare.custom !== null ? plantCare.custom : -1}" data-Id="${plantCare.activity_id}">
            <svg width="25px" height="25px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
              <path fill="none" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z"/>
            </svg>
          </button>
          <button class="action-btn delete-button" data-custom = "${plantCare.custom !== null ? plantCare.custom : -1}" data-Id="${plantCare.activity_id}">
              <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier">
                  <path d="M10 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M14 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M4 7H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
              </svg>
  
          </button>
        </div>
      </div>
    `;
    tableContents.appendChild(row);
    // Attach event listener to the delete button
    const deleteButton = row.querySelector('.delete-button');
    deleteButton.addEventListener('click', handleCareDeleteButtonClick)

    const editButton = row.querySelector('.edit-btn');
    editButton.addEventListener('click', loadCareEditInfo)

  });
  setupOpenPopupButtons();
  setupCloseButtons();
}

// Function to fetch plant care data from the server
function fetchPlantCareData() {
  plant = localStorage.getItem('selectedPlantId');
  fetch('../../server/Get/getPlantCare.php?plant_id=' + plant) // Change plant_id value as needed
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        if (response.success) {
          return;
        } else {
          throw new Error('Failed to fetch plant care data.');
        }

      }
    })
    .then(data => {
      if (data.success) {
        renderPlantCareData(data.plantCare);
      } else {

        console.error(data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}



// Add event listener to handle the delete button click event
document.addEventListener('DOMContentLoaded', function () {
  fetchPlantCareData();
});


function populateAddPlantCare() {
  // Fetch request to the PHP script
  plant = localStorage.getItem('selectedPlantId');
  fetch('../../server/Get/getCareActivities.php?plant_id='+ plant, {
    method: 'GET'
  }).then(response => response.json())
    .then(data => {
      // Check if the request was successful
      if (data.success) {
        const plantCareSelect = document.getElementById('pc-name');
        plantCareSelect.innerHTML ="";
        // Loop through the plant care information and create options
        data.plantCare.forEach(care => {
          const option = document.createElement('option');
          option.value = care.activity_id;
          option.textContent = care.activity_name;
          // Set custom col as dataset attribute
          option.dataset.custom = care.custom;
          // Append the option to the select element
          plantCareSelect.appendChild(option);
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


document.addEventListener('DOMContentLoaded', function () {
  // Add event listener to the button
  var addPlantCareButton = document.querySelector('.open-popup-btn[data-popup-id="addPlantCare"]');

  var createPlantCareButton = document.querySelector('.open-popup-btn[data-popup-id="createPlantCare"]');


  addPlantCareButton.addEventListener('click', function () {
    populateAddPlantCare();
  });

});


document.getElementById("addPlantCare-form").addEventListener("submit", function (event) {

  event.preventDefault(); // Prevent form submission

  var form = new FormData(document.getElementById('addPlantCare-form'));

  var plantId = localStorage.getItem('selectedPlantId');
  form.append('plant_id', plantId);

  fetch('../../server/Post/addCare.php', {
    method: 'POST',
    body: form
  })
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
      if (data.success) {
        // Operation successful, trigger SweetAlert
        swal({
          title: 'Success!',
          text: data.message,  // Use the message from the server response
          icon: 'success',
          button: 'OK'
        }).then((value) => {
          if (value) {
            window.location.reload();
          }
        });
      } else {
        // Operation failed, handle errors
        swal({
          title: 'Error!',
          text: data.message,  // Use the message from the server response
          icon: 'error',
          button: 'OK'
        });
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Handle any unexpected errors
      swal({
        title: 'Error!',
        text: 'An unexpected Server error occurred. \n Please try again later.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    });

});


document.getElementById("createPlantCare-form").addEventListener("submit", function (event) {

  event.preventDefault(); // Prevent form submission
  console.log(document.getElementById('createPlantCare-form'));

  console.log('here2');
  var form = new FormData(document.getElementById('createPlantCare-form'));

  var plantId = localStorage.getItem('selectedPlantId');
  form.append('plant_id', plantId);

  fetch('../../server/Post/createPlantCare.php', {
    method: 'POST',
    body: form
  })
    .then(response => {
      if (response.ok) {
        // Registration successful, trigger SweetAlert
        swal({
          title: 'Success!',
          text: 'Successful.',
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
          text: 'Failed',
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