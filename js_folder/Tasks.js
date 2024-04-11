
function handleTaskEditFormSubmission(event) {
    event.preventDefault(); // Prevent form submission
    const form  = new FormData(document.getElementById('editTask-form'))
  console.log(event.target);
    taskId = event.target.dataset.id;

    form.append('task_Id',taskId )
  fetch('../../server/Put/updateTask.php', {
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
}

// Add event listener to handle edit form submission
document.getElementById('editTask-form').addEventListener('submit', handleTaskEditFormSubmission);


function populateAddTaskCare() {
  plant_id = localStorage.getItem('selectedPlantId');

  // Fetch request to the PHP script
  fetch('../../server/Get/getPlantCare.php?plant_id=' + plant_id, {
    method: 'GET'
  }).then(response => response.json())
    .then(data => {
      // Check if the request was successful
      if (data.success) {
        const plantCareSelect = document.getElementById('plant-care');
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

function populateAddTaskSchedule() {
  // Fetch request to the PHP script
  fetch('../../server/Get/getSchedules.php', {
    method: 'GET'
  }).then(response => response.json())
    .then(data => {
      // Check if the request was successful
      if (data.success) {
        const scheduleSelect = document.getElementById('plant-schedule');
        scheduleSelect.innerHTML ="";
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

// add task pop listner
document.addEventListener('DOMContentLoaded', function () {
  // Add event listener to the button
  var addTask = document.querySelector('.open-popup-btn[data-popup-id="addTask"]');

  addTask.addEventListener('click', function () {
    populateAddTaskCare();
    populateAddTaskSchedule();

  });

});

document.getElementById("addTask-form").addEventListener("submit", function (event) {

  event.preventDefault(); // Prevent form submission

  var form = new FormData(document.getElementById('addTask-form'));

  var plantId = localStorage.getItem('selectedPlantId');
  form.append('plant_id', plantId);

  fetch('../../server/Post/addTask.php', {
    method: 'POST',
    body: form
  })
    .then(response =>  response.json())
    .then(data =>{
      if (data.success) {
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
          text: data.message,
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





