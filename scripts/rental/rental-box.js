document.addEventListener("DOMContentLoaded", function () {
    const addRentalBoxButton = document.getElementById('rental-add-rental-box-button');
    const addRentalModalContainer = document.querySelector('.rental-add-box-rental-modal-container');
    const addRentalBoxCancelButton = document.getElementById('add-box-rental-cancel-button');
    const rentalBoxForm = document.getElementById('rental-add-rental-box-form');

    

    if (!addRentalBoxButton || !addRentalModalContainer || !addRentalBoxCancelButton || !rentalBoxForm) return;

    addRentalBoxButton.addEventListener('click', () => {
        addRentalModalContainer.style.display = 'flex';
    });

    addRentalBoxCancelButton.addEventListener('click', () => {
        addRentalModalContainer.style.display = 'none';
    });

    rentalBoxForm.addEventListener('submit', function (event) {
        event.preventDefault();
        addRentalBox();
    });

    function addRentalBox() {
        const addBoxNumber = document.getElementById("rental-add-box-number")?.value.trim() || "";
        const addBoxSize = document.getElementById("rental-add-box-size")?.value.trim() || "";
        const addBoxWidth = document.getElementById("rental-add-box-width")?.value.trim() || "";
        const addBoxLength = document.getElementById("rental-add-box-length")?.value.trim() || "";
        const addBoxRentalFee = document.getElementById("rental-add-box-rental-fee")?.value.trim() || "";
        const addBoxQuantity = document.getElementById("rental-add-box-quantity")?.value.trim() || "";
        const addBoxStatus = document.getElementById("rental-add-box-status")?.value.trim() || "";

           // Check for missing fields and log them
           if (!addBoxNumber || !addBoxSize || !addBoxWidth || !addBoxLength || !addBoxRentalFee || !addBoxQuantity || !addBoxStatus) {
            alert("All fields are required.");
            return;
        }

        const formData = new FormData();
        formData.append("box_number", addBoxNumber);
        formData.append("box_size", addBoxSize);
        formData.append("box_width", addBoxWidth);
        formData.append("box_length", addBoxLength);
        formData.append("box_rental_fee", addBoxRentalFee);
        formData.append("box_quantity", addBoxQuantity);
        formData.append("box_status", addBoxStatus);


        console.log("Form Data:", {
            box_number: addBoxNumber,
            box_size: addBoxSize,
            box_width: addBoxWidth,
            box_length: addBoxLength,
            box_rental_fee: addBoxRentalFee,
            box_quantity: addBoxQuantity,
            box_status: addBoxStatus
        });

        fetch("../handler/rental/rental-box/add-rental-box.php", {
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server responded with status ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert("Rental box added successfully!");
                addRentalModalContainer.style.display = 'none';
                location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while adding the rental box.");
        });
    }

/*********************| FOR DISPLAYING RENTAL BOXES |************************************ */
    const rentalBoxTableBody = document.getElementById('rental-box-table').querySelector('tbody');

    fetchRentalBoxesData();

    function fetchRentalBoxesData(query = '') {
        const formData = new URLSearchParams();
        formData.append('query', query);
       
    
        fetch('../handler/rental/rental-box/retrieve-rental-boxes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateRentalBoxTable(data.data);
            } else {
                onhandProductListTable.innerHTML = '<tr><td colspan="12">No products found</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load boxes:', err));
    }


       // POPULATE RENTAL BOX TABLE 
       function populateRentalBoxTable(boxes) {
        rentalBoxTableBody.innerHTML = '';
    
        boxes.forEach(box => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${box.box_number}</td>
                <td>${box.box_size}</td>
                <td>${box.width}</td>
                <td>${box.length}</td>
                <td>${box.rental_fee}</td>
                <td>${box.quantity}</td>
                <td>${box.status}</td>
                
                <td>
                    <button data-id="${box.box_id}" class="box-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${box.box_id}" class="box-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            rentalBoxTableBody.appendChild(row);
        });
        attachRentalBoxActionListeners();
    }

        function attachRentalBoxActionListeners() {
            document.querySelectorAll('.box-edit-button').forEach(button =>
                button.addEventListener('click', handleEditRentalBox)
            );
            document.querySelectorAll('.box-delete-button').forEach(button =>
                button.addEventListener('click', handleDeleteRentalBox)
            );
        }
    

/**===========================| FOR EDITING RENTAL BOX |=========================================================== */
const editRentalBoxModalCon = document.querySelector('.rental-edit-box-rental-modal-container');
const editRentalBoxSaveButton = document.getElementById('edit-box-rental-save-button');
const editRentalBoxExitButton = document.getElementById('edit-box-rental-cancel-button');

//RETRIEVE RENTAL BOX DETAILS FOR EDITING
function handleEditRentalBox(event) {
    const boxId = event.currentTarget.dataset.id;
    console.log(boxId);
    fetch(`../handler/rental/rental-box/retrieve-rental-box-details.php?box_id=${boxId}`)
        .then(response => response.json())
        .then(rentalbox => displayEditBoxDetails(rentalbox))
        .catch(error => console.error('Error fetching product details:', error));
}
// DISPLAY RENTAL BOX DETAILS IN THE MODAL
function displayEditBoxDetails(box) {
    document.getElementById('rental-edit-box-id').value = box.box_id;
    document.getElementById('rental-edit-box-number').value = box.box_number;
    document.getElementById('rental-edit-box-size').value = box.box_size;
    document.getElementById('rental-edit-box-width').value = box.width;
    document.getElementById('rental-edit-box-length').value = box.length;
    document.getElementById('rental-edit-box-rental-fee').value = box.rental_fee;
    document.getElementById('rental-edit-box-quantity').value = box.quantity;
    document.getElementById('rental-edit-box-status').value = box.status;
     
    editRentalBoxModalCon.style.display = 'flex';
}


// Listen for save button click to save the edited supplier
editRentalBoxSaveButton.addEventListener('click', function (event) {
    event.preventDefault();

    // Gather all the input field values into an object
    const rentalboxDetails = {
        box_id: document.getElementById('rental-edit-box-id').value,
        box_number: document.getElementById('rental-edit-box-number').value.trim(),
        box_size: document.getElementById('rental-edit-box-size').value.trim(),
        width: document.getElementById('rental-edit-box-width').value,
        length: document.getElementById('rental-edit-box-length').value.trim(),
        rental_fee: document.getElementById('rental-edit-box-rental-fee').value.trim(),
        quantity: document.getElementById('rental-edit-box-quantity').value.trim(),
        status: document.getElementById('rental-edit-box-status').value.trim(),
    };   
    

    // Send a POST request to the PHP handler to save the data
    fetch('../handler/rental/rental-box/edit-rental-box-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(rentalboxDetails),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Rental Box updated successfully!');
            editRentalBoxModalCon.style.display = 'none';
            fetchRentalBoxesData(); // Assuming this function fetches and updates the supplier data
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => console.error('Error during fetch:', error));
});

// Listen for exit button to close the modal
editRentalBoxExitButton .addEventListener('click', function () {
    editRentalBoxModalCon.style.display = 'none';
});

/**************************| FOR DELETING RENTAL BOX |***************************************************** */

const deleteBoxModal = document.querySelector('.delete-box-modal-container');
const deleteBoxYesButton = document.getElementById('delete-box-yes-button');
const cancelDeleteBoxButton = document.getElementById('delete-box-no-button');


let boxId = null; // Declare boxId in a broader scope
// Handle supplier deletion
function handleDeleteRentalBox(event) {
  boxId = event.currentTarget.dataset.id;  
  console.log(boxId);

  fetch(`../handler/rental/rental-box/retrieve-rental-box-details.php?box_id=${boxId}`)
    .then(response => response.json())
    .then(box => {
      if (box.error) {
        console.error('Error fetching box details:', box.error);
        return;
      }
      displayDeleteBoxDetails(box);
    })
    .catch(error => console.error('Error fetching box details:', error));
}

// Display supplier details for deletion
function displayDeleteBoxDetails(box) {
    deleteBoxModal.style.display = 'flex';
  document.querySelector('#delete-box-number').textContent = box.box_number;
}

// Confirm delete supplier
deleteBoxYesButton.addEventListener('click', function () {
  console.log(boxId);
  if (!boxId) {
    console.error('Box ID is not defined.');
    return;
  }

  fetch('../handler/rental/rental-box/delete-rental-box-handler.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `box_id=${boxId}`  
  })
    .then(response => response.text())  // Read as text to inspect raw response
    .then(text => {
      try {
        const data = JSON.parse(text);
        if (data.success) {
          alert(data.success);
          window.location.reload();
        } else {
          alert(data.error);
        }
      } catch (error) {
        console.error('Response not JSON:', text);
        alert('Something went wrong');
      }
    })
    .catch(error => console.error('Error:', error));
});

// Cancel delete supplier
cancelDeleteBoxButton.addEventListener('click', function () {
    deleteBoxModal.style.display = 'none';  
});











/****************| FOR SEARCHING RENTAL BOX NUMBER  ON RENTAL BOX INFORMATION TABLE |********************* */
const rentalBoxSearchInput = document.getElementById('rental-box-search-input');

// Update search filter
rentalBoxSearchInput.addEventListener('input', () => {
    currentSearchQuery = rentalBoxSearchInput.value.trim();
    fetchRentalBoxesData(currentSearchQuery);
});
// Event: Search as you type
rentalBoxSearchInput.addEventListener('input', () => {
    const query = rentalBoxSearchInput.value.trim();

    fetch('../handler/rental/rental-box/retrieve-rental-boxes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'query=' + encodeURIComponent(query)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateRentalBoxTable(data.data);
            } else {
                rentalBoxTableBody.innerHTML = '<tr><td colspan="4">No boxes found.</td></tr>';
            }
        })
        .catch(err => console.error('Search failed:', err));
});

// Enter key trigger search
rentalBoxSearchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        currentSearchQuery = rentalBoxSearchInput.value.trim();
        fetchRentalBoxesData(currentSearchQuery);
    }
});




});
