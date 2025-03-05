// ALL RENTAL-BOXES CONTENT SCRIPTS ONLY HERE
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.rental-boxes-switch-content-buttons-container button');
    const contentContainers = document.querySelectorAll('.rental-boxes-content-container');

    const addProductButton = document.getElementById('add-rental-button');
    const addProductCancelButton = document.getElementById('add-rental-cancel-button');
    const addProductModalCon = document.querySelector('.add-rental-modal-container');


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

    //DISPLAY THE ADD PRODUCT MODAL WHEN ADD NEW PRODUCT BUTTON CLICKED
    addProductButton.addEventListener('click', function(){
        addProductModalCon.style.display = 'flex';
    })
    //HIDE THE ADD PRODUCT MODAL WHEN CANCEL BUTTON CLICKED
    addProductCancelButton.addEventListener('click', function(){
        addProductModalCon.style.display = 'none';
    })





});