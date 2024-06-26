function renderGardenContent() {
  // Construct the API endpoint URL
  const apiEndpoint = "../../server/Get/getPlants.php";

  // Make a GET request to the API endpoint
  fetch(apiEndpoint, {
    method: "GET",
  })
    .then((response) => {
      // Check if the response is successful
      if (response.ok) {
        // Parse the JSON response
        return response.json();
      } else {
        if (response.success) {
          return response.json();
        } else {
          // Handle error response
          throw new Error("Failed to fetch data");
        }
      }
    })
    .then((data) => {
      // Check if the response contains plants data
      if (data.success && data.plants) {
        // Render the plants data in the garden div
        const gardenDiv = document.querySelector(".garden");
        // Clear previous content of the garden div
        gardenDiv.innerHTML = "";
        if(data.plants.length===0){
            gardenDiv.textContent = " Add Plants Here";
            
        }
        // Iterate over the plants data and create HTML elements to display each plant
        data.plants.forEach((plant) => {
          // Create a new plant element
          const plantElement = document.createElement("div");
          plantElement.dataset.plantId = plant.plant_id;
          plantElement.classList.add("plant");
          // Create span for name
          const nameSpan = document.createElement("span");
          nameSpan.textContent = plant.name;
          // Create div for species
          const speciesDiv = document.createElement("div");
          // Create SVG element
          const svgDiv = document.createElement("div");

          svgDiv.innerHTML = `
                <svg fill="none" height="45px" width="45px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <g>
                                <path d="M384.88,244.172c14.093-22.901,20.943-49.311,20.943-80.741V48.339H388.56c-28.644,0-54.897,9.291-75.393,26.431 c-5.549-14.573-13.374-27.535-23.37-38.531C268.553,12.871,238.457,0,205.051,0h-17.264v77.098 c-18.181-11.246-39.648-17.25-62.662-17.25h-17.264v109.338c0,31.429,6.851,57.84,20.943,80.741 c7.259,11.795,16.403,22.433,27.369,31.888h-49.997l10.354,176.019C118.318,488.208,143.552,512,173.977,512h154.221 c30.427,0,55.66-23.793,57.446-54.166l10.355-176.019h-45.574C364.594,270.991,376.11,258.423,384.88,244.172z M314.389,119.567 v84.147c0,36.037-14.753,61.172-46.037,77.665v-63.853v-25.32C268.352,153.985,285.927,127.138,314.389,119.567z M222.315,36.12 c30.207,5.792,51.997,27.102,61.267,59.066c-8.254,4.685-15.753,10.641-22.25,17.79c-8.867,9.754-15.664,21.36-20.289,34.451 c-5.549-5.226-11.825-9.572-18.729-12.916V36.12z M203.9,164.146c6.14,2.332,11.538,5.992,15.999,10.898 c9.111,10.021,13.925,24.71,13.925,42.481v62.038c-29.925-18.621-29.924-38.7-29.924-52.831V164.146z M142.389,169.189V95.924 c18.467,3.437,33.894,12.498,45.397,26.139v4.568c-0.386-0.005-0.764-0.028-1.151-0.028h-17.264v100.131 c0,6.474,0.327,13.873,1.784,21.741c-4.985-5.192-9.311-10.737-12.944-16.641C147.565,214.533,142.389,194.042,142.389,169.189z M351.176,455.806c-0.715,12.149-10.807,21.666-22.978,21.666H173.977c-12.171,0-22.263-9.517-22.978-21.666l-4.142-70.408 h208.462L351.176,455.806z M359.38,316.343l-2.031,34.528H144.826l-2.031-34.528H359.38z M344.105,241.033 c3.213-11.425,4.812-23.797,4.812-37.319V92.058c6.833-3.56,14.314-6.142,22.379-7.643v79.017 c0,24.853-5.176,45.344-15.822,62.645C352.231,231.348,348.427,236.329,344.105,241.033z"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                
                `;

          const speciesSpan = document.createElement("span");
          speciesSpan.textContent = plant.species;

          // Append species span to species div
          speciesDiv.appendChild(speciesSpan);

          // Append name span and species div to plant element
          plantElement.appendChild(nameSpan);

          // Append species svg to species div
          plantElement.appendChild(svgDiv);

          plantElement.appendChild(speciesDiv);
          // Append the plant element to the garden div
          gardenDiv.appendChild(plantElement);

          plantElement.addEventListener("click", plantDash);
        });
      } else {
        // Render the plants data in the garden div
        const gardenDiv = document.querySelector(".garden");
        // Clear previous content of the garden div
        gardenDiv.innerHTML = "";
        const plantElement = document.createElement("div");
        plantElement.textContent = data.message;
        // Append the plant element to the garden div
        gardenDiv.appendChild(plantElement);
      }
    })
    .catch((error) => {
      swal({
        title: "Error!",
        text: "Internal Server Error",
        icon: "error",
        button: "OK",
      }).then((value) => {
        console.log(error);
      });
    });
}

document.addEventListener("DOMContentLoaded", renderGardenContent);

document.getElementById("add-Plant-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    // Get form data
    const plantName = document.getElementById("plantname").value;
    const plantSpecies = document.getElementById("plantspecies").value;
    const plantDescription = document.getElementById("plantdescription").value;
    const plantNotes = document.getElementById("plantnotes").value;

    // Submit the form data using fetch
    fetch("../../server/Post/addPlant.php", {
      method: "POST",
      body: JSON.stringify({
        plantName: plantName,
        plantSpecies: plantSpecies,
        plantDescription: plantDescription,
        plantNotes: plantNotes,
      }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          // Show SweetAlert for error
          swal({
            title: "Error!",
            text: "Failed to add plant.",
            icon: "error",
            button: "OK",
          });
        }
      })
      .then((data) => {
        // Handle the response
        if (data.success) {
          // Plant added successfully, trigger SweetAlert
          swal({
            title: "Success!",
            text: "Plant added successfully.",
            icon: "success",
            button: "OK",
          }).then((value) => {
            if (value) {
              // Redirect to another page or perform any other action
              window.location.reload();
            }
          });
        } else {
          // Display a SweetAlert for error
          swal({
            title: "Error!",
            text: "Failed to add plant.",
            icon: "error",
            button: "OK",
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        // Show SweetAlert for unexpected error
        swal({
          title: "Error!",
          text: "An unexpected error occurred. Please try again later.",
          icon: "error",
          button: "OK",
        });
      });
  });

function plantDash(event) {
  // Prevent default behavior of the event
  event.preventDefault();

  // Get the .plant element
  var plant = event.target.closest(".plant");

  // Extract the dataset attribute from the event target
  console.log(event.dataset);
  const plantId = plant.dataset.plantId;

  // Check if the plantId is valid
  if (plantId) {
    // Store the plantId in local storage
    localStorage.setItem("selectedPlantId", plantId);

    // Redirect to the dashboard view
    window.location.href = "../DashBoard/dash.php";
  } else {
    swal({
      title: "Error",
      text: "Cannot Access Plant",
      icon: "error",
      button: "OK",
    }).then((value) => {
      console.log("plant unavialable");
    });
  }
}

// Get the div element
var profile = document.querySelector(".account-info-picture");

if (profile) {
  // Attach event listener to the div
  profile.addEventListener("click", function (event) {
    // Redirect to target page
    window.location.href = "../Profiles/profile.php";
  });
}
