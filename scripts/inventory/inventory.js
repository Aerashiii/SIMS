// ALL INVENTORY CONTENT SCRIPTS ONLY HERE
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.inventory-switch-content-buttons-container button');
    const contentContainers = document.querySelectorAll('.inventory-content-container');

    const addProductButton = document.getElementById('inventory-add-product-button');
    const addProductCancelButton = document.getElementById('add-product-cancel-button');
    const addProductModalCon = document.querySelector('.add-product-modal-container');


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