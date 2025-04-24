document.addEventListener("DOMContentLoaded", function () {
    const addRentalBoxButton = document.getElementById('rental-add-rental-box-button');
    const addRentalModalContainer = document.querySelector('.rental-add-box-rental-modal-container');
    const addRentalBoxCancelButton = document.getElementById('add-box-rental-cancel-button');
    const addRentalBoxsSaveButton = document.getElementById('add-box-rental-save-button');

    // FOR DISPLAYING ADD RENTAL BOX MODAL
    addRentalBoxButton.addEventListener('click', function () {
        addRentalModalContainer.style.display = 'flex';
    });

    // FOR CLOSING ADD RENTAL BOX MODAL
    addRentalBoxCancelButton.addEventListener('click', function () {
        addRentalModalContainer.style.display = 'none';
    });

    // FOR SENDING FORM DATA TO PHP BACKEND
    addRentalBoxsSaveButton.addEventListener('click', function (event) {
        event.preventDefault();  // Prevent form from submitting normally

        // Get form data
        const boxNumber = document.getElementById('rental-add-box-number').value;
        const boxSize = document.getElementById('rental-add-box-size').value;
        const rentalFee = document.getElementById('rental-add-box-rental-fee').value;
        const quantity = document.getElementById('rental-add-box-quantity').value;
        const status = document.getElementById('rental-add-box-status').value;

        // Prepare data for sending
        const formData = new FormData();
        formData.append('box_number', boxNumber);
        formData.append('box_size', boxSize);
        formData.append('rental_fee', rentalFee);
        formData.append('quantity', quantity);
        formData.append('status', status);

        // Send data to PHP backend
        fetch('../handler/rental/rental-box/add-rental-box.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(data.message);
                addRentalModalContainer.style.display = 'none';  // Close modal on success
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add rental box.');
        });
    });
});
