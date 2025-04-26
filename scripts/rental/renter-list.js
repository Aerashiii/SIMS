document.addEventListener('DOMContentLoaded', function () {


    /*********************| FOR DISPLAYING RENTER LIST |************************************ */
    const renterBoxTableBody = document.getElementById('renter-list-table').querySelector('tbody');

    fetchRenterData();

    function fetchRenterData(query = '') {
        const formData = new URLSearchParams();
        formData.append('query', query);
       
    
        fetch('../handler/rental/renter/retrieve-renter-list.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateRenterTable(data.data);
            } else {
                renterBoxTableBody.innerHTML = '<tr><td colspan="12">Norenter found</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load boxes:', err));
    }


       // POPULATE RENTAL BOX TABLE 
    function populateRenterTable(renters) {
        renterBoxTableBody.innerHTML = '';
    
       renters.forEach(renter => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${renter.renter_name}</td>
                <td>${renter.contact_number}</td>                           
                <td>
                    <button data-id="${renter.renter_id}" class="renter-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>                  
                </td>
            `;
            renterBoxTableBody.appendChild(row);
        });
        attachRenterActionListeners();
    }

        function attachRenterActionListeners() {
            document.querySelectorAll('.renter-edit-button').forEach(button =>
                button.addEventListener('click', handleEditRenter)
            );
            /*
            document.querySelectorAll('.box-delete-button').forEach(button =>
                button.addEventListener('click', handleDeleteRentalBox)
            );
            */
        }

/**===========================| FOR EDITING RENTER |=========================================================== */
const editRenterModalCon = document.querySelector('.rental-edit-renter-modal-container');
const editRenterSaveButton = document.getElementById('edit-renter-save-button');
const editRenterExitButton = document.getElementById('edit-renter-cancel-button');

//RETRIEVE RENTAL BOX DETAILS FOR EDITING
function handleEditRenter(event) {
    const renterId = event.currentTarget.dataset.id;
    console.log(renterId);
    fetch(`../handler/rental/renter/retrieve-renter-details.php?renter_id=${renterId}`)
        .then(response => response.json())
        .then(rentalbox => displayEditRenterDetails(rentalbox))
        .catch(error => console.error('Error fetching product details:', error));
}
// DISPLAY RENTAL BOX DETAILS IN THE MODAL
function displayEditRenterDetails(renter) {
    document.getElementById('rental-edit-renter-id').value = renter.renter_id;
    document.getElementById('rental-renter-name').value = renter.renter_name;
    document.getElementById('rental-edit-contact-number').value = renter.contact_number;
    
     
    editRenterModalCon.style.display = 'flex';
}

// Listen for save button click to save the edited supplier
editRenterSaveButton.addEventListener('click', function (event) {
    event.preventDefault();

    // Gather all the input field values into an object
    const renterDetails = {
        renter_id: document.getElementById('rental-edit-renter-id').value,
        renter_name: document.getElementById('rental-renter-name').value.trim(),
        contact_number: document.getElementById('rental-edit-contact-number').value.trim(),
       
    };   
    

    // Send a POST request to the PHP handler to save the data
    fetch('../handler/rental/renter/edit-renter-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(renterDetails),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Renter updated successfully!');
            editRenterModalCon.style.display = 'none';
            fetchRenterData(); 
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => console.error('Error during fetch:', error));
});

// Listen for exit button to close the modal
editRenterExitButton .addEventListener('click', function () {
    editRenterModalCon.style.display = 'none';
});




/****************| FOR SEARCHING RENTER TABLE |********************* */
const renterSearchInput = document.getElementById('renter-search-input');

// Update search filter
renterSearchInput.addEventListener('input', () => {
    currentSearchQuery = renterSearchInput.value.trim();
    fetchRenterData(currentSearchQuery);
});
// Event: Search as you type
renterSearchInput.addEventListener('input', () => {
    const query = renterSearchInput.value.trim();

    fetch('../handler/rental/renter/retrieve-renter-list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'query=' + encodeURIComponent(query)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateRenterTable(data.data);
            } else {
                renterBoxTableBody.innerHTML = '<tr><td colspan="4">No renter found.</td></tr>';
            }
        })
        .catch(err => console.error('Search failed:', err));
});

// Enter key trigger search
renterSearchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        currentSearchQuery = renterSearchInput.value.trim();
        fetchRenterData(currentSearchQuery);
    }
});


});
