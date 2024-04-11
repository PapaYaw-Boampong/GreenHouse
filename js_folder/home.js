function loadPlantInfo() {
  // Get the plant ID from wherever you have it
  var plantId = localStorage.getItem("selectedPlantId");

  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Define the onload event handler
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Parse the JSON response
      var response = JSON.parse(xhr.responseText);
      if (response.plants.length > 0) {
        response = response.plants[0];
        document.getElementById('plant-alias').textContent = " Hi, ... Im "+ response.name;;


        // Render the plant information in the infosec2 div
        document.getElementById("sec1").querySelector(".value").textContent =
          response.name;
        document.getElementById("sec2").querySelector(".value").textContent =
          response.species;
        document.getElementById("sec3").querySelector(".value").textContent =
          response.description;
        document.getElementById("sec4").querySelector(".value").textContent =
          response.personal_notes;
      }

    } else {
      console.error(
        "Failed to retrieve plant information. Status code: " + xhr.status
      );
    }
  };

  // Set up the request
  xhr.open("GET", "../../server/Get/getPlants.php?plant_id=" + plantId, true);
  xhr.send();
}

function populatePlantEditForm() {
  // Select each input field individually
  const plantNameInput = document.getElementById('plantname');
  const speciesInput = document.getElementById('plantspecies');
  const descriptionInput = document.getElementById('plantdescription');
  const notesInput = document.getElementById('plantnotes');

  plantNameInput.value = document.getElementById("sec1").querySelector(".value").textContent;
  speciesInput.value = document.getElementById("sec2").querySelector(".value").textContent;
  descriptionInput.value = document.getElementById("sec3").querySelector(".value").textContent;
  notesInput.value = document.getElementById("sec4").querySelector(".value").textContent;

}

document.addEventListener('DOMContentLoaded', function () {
  // Add event listener to the button
  var editPlantButton = document.querySelector('.open-popup-btn[data-popup-id="editPlant"]');

  editPlantButton.addEventListener('click', function () {
    populatePlantEditForm();

  });
});

// Function to validate form data
function validateFormPlantEdit() {

  const plantNameInput = document.getElementById('plantname').value.trim();
  const speciesInput = document.getElementById('plantspecies').value.trim();
  const descriptionInput = document.getElementById('plantdescription').value.trim();
  const notesInput = document.getElementById('plantnotes').value.trim();


  // Check if any field is empty
  if (plantNameInput === '' || speciesInput === '') {
    return { isValid: false, message: 'Please fill in all fields.' };
  }

  // Check username format (alphanumeric characters only)
  var nameRegex = /^[a-zA-Z0-9\-()\s]*$/;
  if (!nameRegex.test(plantNameInput) || !nameRegex.test(speciesInput) || !nameRegex.test(descriptionInput) || !nameRegex.test(notesInput)) {
    return { isValid: false, message: 'Can only contain alphanumeric characters, -, (, ), or spaces.' };
  }


  // If all validations pass, return true
  return { isValid: true, message: '' };
}

document.getElementById("editPlant-form").addEventListener("submit", function (event) {

  event.preventDefault(); // Prevent form submission
  var validationResult = validateFormPlantEdit();

  if (!validationResult.isValid) {

    swal({
      title: 'Error',
      text: validationResult.message,
      icon: 'error',
      button: 'OK'
    });
    return;
  }

  var form = new FormData(document.getElementById('editPlant-form'));

  var plantId = localStorage.getItem('selectedPlantId');
  form.append('plant_id', plantId);
  fetch('../../server/Put/updatePlant.php', {
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



// Call the function to fetch data and build tables when needed

document.addEventListener("DOMContentLoaded", function () {
  // Call fetchCareStats function when the document is loaded
  if (document.getElementById("sec1").querySelector(".value")) {
    loadPlantInfo();
  }

});



document.addEventListener('DOMContentLoaded', function () {
  // Add event listener to the button
  var deletePlantButton = document.querySelector('.open-popup-btn[data-popup-id="deletePlant"]');

  deletePlantButton.addEventListener('click', function () {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        // If user confirms, make AJAX request to delete the assignment
        var plantId = localStorage.getItem('selectedPlantId');
        fetch('../../server/Delete/deletePlant.php', {
          method: 'POST',
          body: JSON.stringify({ plantId: plantId }),
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
                'Plant deleted.',
                'success'
              ).then(() => {

                // Unset the plant ID from local storage

                localStorage.removeItem('selectedPlantId');

                window.history.replaceState({}, '', '../Home/home.php');

                // Clear history stack
                var len = window.history.length;
                for (var i = 0; i < len; i++) {
                  window.history.replaceState({}, '', '../Home/home.php');
                }

                // Redirect to login page
                window.location.href = "../Home/home.php";

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
        swal("Aborted");
        hidePopup();
      }
    });

  });
});
