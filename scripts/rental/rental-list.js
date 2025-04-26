document.addEventListener('DOMContentLoaded', function () {
    const rentalTableBody = document.getElementById('rental-list-table').querySelector('tbody');
    const rentalSearchInput = document.getElementById('rental-search-input');
    const rentalSearchButton = document.getElementById('rental-search-submit-button');
    const rentalStatusSelect = document.getElementById('rental-select-status');

    function fetchRentalData(query = '', status = '') {
        const formData = new URLSearchParams();
        formData.append('query', query);
        formData.append('status', status);

        fetch('../handler/rental/rental-list/retrieve-rental-list.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateRentalTable(data.data);
            } else {
                rentalTableBody.innerHTML = '<tr><td colspan="7">No rental transactions found.</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load rentals:', err));
    }

    function populateRentalTable(rentals) {
        rentalTableBody.innerHTML = '';

        rentals.forEach(rental => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${rental.renter_name}</td>
                <td>${rental.quantity}</td>
                <td>${rental.payment}</td>
                <td>${rental.rental_start_date}</td>
                <td>${rental.rental_end_date}</td>
                <td>${rental.status}</td>
                <td>
                    <button data-id="${rental.id}" class="rental-view-details-button">View Details</button>
                    <button data-id="${rental.id}" class="rental-completed-button">Completed</button>                
                </td>
            `;
            rentalTableBody.appendChild(row);
        });
        attachRentalActionListeners();
    }

    function attachRentalActionListeners() {
        document.querySelectorAll('.rental-view-details-button').forEach(button =>
            button.addEventListener('click', handleViewDetails)
        );     
        document.querySelectorAll('.rental-completed-button').forEach(button =>
            button.addEventListener('click', handlecompletedrental)
        );
    }
/***************| FOR HANDLE VIEW DETAILS |******************************** */
const rentalViewDetails = document.querySelector('.rental-list-view-details-content-container');
const rentalContentList = document.getElementById('rental-list-content-container');
const rentalViewDetailsExitButton = document.getElementById('rental-view-details-exit-button');

//RETRIEVE RENTAL  DETAILS FOR VIEW DETAILS
function handleViewDetails(event) {
    const rentalId = event.currentTarget.dataset.id;

    fetch(`../handler/rental/rental-list/retrieve-rental-list-details.php?rental_transaction_id=${rentalId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayRentalTransactionDetails(data.data);
                rentalViewDetails.style.display = 'block'; // Show the view details panel
                rentalContentList.style.display = 'none'; // Hide rental list
            } else {
                alert('Failed to retrieve rental details.');
            }
        })
        .catch(error => console.error('Error fetching rental transaction details:', error));
}
function displayRentalTransactionDetails(data) {
    document.getElementById('rental-list-view-details-renter-name').textContent = data.renter_name;
    document.getElementById('rental-list-view-details-renter-contact-num').textContent = data.contact_number;
    document.getElementById('rental-list-view-details-renter-start-date').textContent = data.rental_start_date;
    document.getElementById('rental-list-view-details-renter-due-date').textContent = data.rental_end_date;

    const boxListTableBody = document.getElementById('box-list-rented-table').querySelector('tbody');
    boxListTableBody.innerHTML = ''; // Clear existing rows

    let totalAmount = 0;

    data.rented_boxes.forEach(box => {
        const row = document.createElement('tr');
        const total = box.rental_fee * box.quantity;
        totalAmount += total;

        row.innerHTML = `
            <td>${box.box_number}</td>
            <td>${box.box_size}</td>
            <td>${box.quantity}</td>
            <td>${total}</td>
        `;
        boxListTableBody.appendChild(row);
    });

    document.getElementById('box-rented-total-amount').textContent = totalAmount;
}
rentalViewDetailsExitButton.addEventListener('click', function(){
    rentalViewDetails.style.display = 'none'; // Show the view details panel
    rentalContentList.style.display = 'block';
});
/*******************| FOR CHANGE THE STATUS OF RENTAL WHEN USER CLICK THE rental-completed-button |*************************************** */
/*******************| FOR CHANGE THE STATUS OF RENTAL WHEN USER CLICK THE rental-completed-button |*************************************** */
function handlecompletedrental(event) {
    const rentalId = event.currentTarget.dataset.id;

    if (confirm('Are you sure you want to mark this rental as completed?')) {
        const formData = new URLSearchParams();
        formData.append('rental_transaction_id', rentalId);

        fetch('../handler/rental/rental-list/update-rental-status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Rental status updated to completed!');
                fetchRentalData(); // Refresh the rental list after update
            } else {
                alert('Failed to update rental status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating rental status:', error);
            alert('Error updating rental status.');
        });
    }
}








/*****************| FOR SEARCHING RENTER NAME ON RENTAL LIST |*********************************** */
    // Initial fetch
    fetchRentalData();

    // Event: Search button clicked
    rentalSearchButton.addEventListener('click', () => {
        const query = rentalSearchInput.value.trim();
        const status = rentalStatusSelect.value; // <--- NEW
        fetchRentalData(query, status);
    });

    // Event: Search as you type (optional if you want instant search)
    rentalSearchInput.addEventListener('input', () => {
        const query = rentalSearchInput.value.trim();
        const status = rentalStatusSelect.value; // <--- NEW
        fetchRentalData(query, status);
    });

    // Event: Press Enter to search
    rentalSearchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const query = rentalSearchInput.value.trim();
            const status = rentalStatusSelect.value; // <--- NEW
            fetchRentalData(query, status);
        }
    });
    // Status filter change event
    rentalStatusSelect.addEventListener('change', () => {
        const query = rentalSearchInput.value.trim();
        const status = rentalStatusSelect.value; // <--- NEW
        fetchRentalData(query, status);
    });

});
