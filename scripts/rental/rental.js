// ALL RENTAL-BOXES CONTENT SCRIPTS ONLY HERE
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.rental-boxes-switch-content-buttons-container button');
    const contentContainers = document.querySelectorAll('.rental-boxes-content-container');


    // ADD AND REMOVE ACTIVE CLASS
    buttons.forEach((button, index) => {
        button.addEventListener('click', function () {
            // Remove 'active' class from all buttons and containers
            buttons.forEach(btn => btn.classList.remove('active'));
            contentContainers.forEach(container => container.classList.remove('active'));

            // Add 'active' class to the clicked button and corresponding container
            button.classList.add('active');
            contentContainers[index].classList.add('active');
        });
    });


    // FOR DISPLAYING THE ADD RENTAL TRANSACTION 
    const addRentalTransactionButton = document.getElementById('add-rental-button');
    const addRentalTransactionBackButton = document.getElementById('add-rental-back-button');
    const addRentalTransactionModalCon = document.querySelector('.add-rental-transaction-container');
    const rentalManagementContentCon = document.querySelector('.rental-management-content-container');

    addRentalTransactionButton.addEventListener('click', function() {
        addRentalTransactionButton.style.display = 'none';
        addRentalTransactionBackButton.style.display = 'block';

        addRentalTransactionModalCon.style.display = 'block';
        rentalManagementContentCon.style.display = 'none';
    });

    addRentalTransactionBackButton.addEventListener('click', function() {
        addRentalTransactionButton.style.display = 'block';
        addRentalTransactionBackButton.style.display = 'none';

        addRentalTransactionModalCon.style.display = 'none';
        rentalManagementContentCon.style.display = 'block';
    });






});