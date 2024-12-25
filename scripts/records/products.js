document.addEventListener('DOMContentLoaded', function(){
    // FOR PRODUCT LIST TABLE
    const productListTable = document.getElementById('product-list-table');

    // FOR ADD PRODUCT
    const recordsAllContentContainer = document.querySelector('.records-all-content-container');
    const addProductModal = document.querySelector('.add-product-modal');
    const addProductButton = document.getElementById('product-list-add-product-button');
    const addProductCancelButton =document.getElementById('add-product-cancel-button');
    const addProductForm = document.getElementById('add-product-form');

    addProductButton.addEventListener('click', function(){
        recordsAllContentContainer.style.display ='none';
        addProductModal.style.display = 'block';

        console.log("clicked add product");
    })
    addProductCancelButton.addEventListener('click', function(){
        recordsAllContentContainer.style.display ='block';
        addProductModal.style.display = 'none';
    })

    /*************************| FOR ADD PRODUCT |**************************** */
    addProductForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form); // Gather form data

        // Perform fetch request to your PHP handler
        fetch('../handler/records/products/add-product-handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data);

                if (data.success) {
                    messageElement.textContent = data.message || 'Product added successfully!';
                    messageElement.style.color = 'green';
                    form.reset(); // Optionally reset the form
                } else {
                    messageElement.textContent = 'Error: ' + (data.message || 'Unknown error');
                    messageElement.style.color = 'red';
                }
            })
            .catch(error => {
                console.log('An error occurred:', error);
                messageElement.textContent = 'An error occurred: ' + error.message;
                messageElement.style.color = 'red';
            });
    });


});