document.addEventListener('DOMContentLoaded', function(){
    // FOR RENTER LIST TABLE
    const renterListTable = document.getElementById('renter-list-table');

    // FOR ADD RENTER LIST
    const addRentalModalCon = document.querySelector('.add-rental-modal-container');
    const addRentalButton = document.getElementById('add-rental-button');
    const addRentalCancelButton =document.getElementById('add-rental-cancel-button');
    const addRentalForm = document.getElementById('add-rental-form');


    // FOR EDIT RENTER LIST
    const editRenterExitButton = document.getElementById('renter-edit-exit-button');
    const editRenterModalCon = document.querySelector('.edit-renter-modal-container');
    const editRenterSaveButton = document.getElementById('save-edit-renter-button');
   

    addRentalButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'flex';      
    })
    addRentalCancelButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'none';
    })
/*=====================================| FOR ADD RENTAL |========================================================================== */
// Fetch categories on page load
fetchRenterData()

addRentalForm.addEventListener('submit', function (event) {
    event.preventDefault();
    addRental();
});

// Function to handle product creation
function addRental() {
    // Get form values and trim any extra spaces, ensure element exists first
    const addBoxNumber = document.getElementById("add-box-number")?.value.trim() || "";
    const addBoxSize = document.getElementById("add-box-size")?.value.trim() || "";
    const addRentalFee = document.getElementById("add-rental-fee")?.value.trim() || "";
    const addRentalStartDate = document.getElementById("add-rental-start-date")?.value.trim() || "";
    const addPRentalEndDate = document.getElementById("add-rental-end-date")?.value.trim() || "";
    const addRenterName= document.getElementById("add-renter-name")?.value.trim() || "";
    const addContactNumber= document.getElementById("add-contact-number")?.value.trim() || "";
    const addRenterStatus = document.getElementById("add-renter-status")?.value.trim() || "";
    const addPaymentStatus = document.getElementById("add-payment-status")?.value.trim() || "";

    //edit lang ulit  pag tapos na sa front end
    
    // Create FormData object to send to the server
    const formData = new FormData(); 
    formData.append("product_name", addProductName);
    formData.append("product_brand", addProductBrand);
    formData.append("product_category", addProductCategory);
    formData.append("product_subcategory", addProductSubcategory);
    formData.append("product_barcode", addProductBarcode);
    formData.append("original_price", addProductOriginalPrice);
    formData.append("selling_price", addProductSellingPrice);
    formData.append("quantity", addProductQuantity);
    formData.append("reorder_point", addProductReorderPoint);
    formData.append("status", addProductStatus);
    formData.append("supplier_id", addProductSupplier);

    console.log(formData);

    // Send data to PHP script using Fetch API
    fetch("../handler/records/products/add-product-handler.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            return response.text().then((text) => {
                throw new Error(`Server responded with status ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            alert("Product added successfully!");
            addProductModalCon.style.display = 'none'; // Close the modal
            location.reload(); // Reload page to update table
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while adding the product.");
    });
}
/**==========================| FOR DISPLAYING PRODUCT |=============================================== */
 // DISPLAY PRODUCTS
 function fetchProductData() {
    fetch('../handler/records/products/retrieve-products.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (!data.success || data.data.length === 0) {
                console.warn('No product data found.');
            } else {
                populateProductTable(data.data);
            }
        })
        .catch(error => console.error('Error fetching products data:', error));
}

    // Populate supplier table
    function populateProductTable(products) {
        productListTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.product_name}</td>
                <td>${product.category_name}</td>
                <td>${product.subcategory_name}</td>
                <td>${product.brand_name}</td>
                <td>${product.barcode}</td>
                <td>${product.quantity}</td>
                <td>${product.reorder_point}</td>
                <td>${product.original_price}</td>
                <td>${product.selling_price}</td>
                <td>${product.supplier}</td>
                <td>${product.status}</td>
                <td>
                    <button data-id="${product.id}" class="product-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${product.id}" class="product-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            productListTable.appendChild(row);
        });
        attachProductActionListeners();
    }

    function attachProductActionListeners() {
        document.querySelectorAll('.product-edit-button').forEach(button =>
            button.addEventListener('click', handleEditProduct)
        );
        document.querySelectorAll('.product-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteProduct)

        );
    }

/**===========================| FOR EDITING PRODUCT |=========================================================== */



function handleEditProduct(event) {
    const productId = event.currentTarget.dataset.id;
    console.log(productId);
    fetch(`../handler/records/products/retrieve-product-details.php?id=${productId}`)
        .then(response => response.json())
        .then(product => displayEditProductDetails(product))
        .catch(error => console.error('Error fetching product details:', error));
}

function displayEditProductDetails(product) {
    document.getElementById('edit-product-id').value = product.id;
    document.getElementById('edit-product-name').value = product.product_name;
    document.getElementById('edit-product-category').value = product.category_name;
    document.getElementById('edit-product-subcategory').value = product.subcategory_name;
    document.getElementById('edit-product-brand').value = product.brand_name;
    document.getElementById('edit-product-barcode').value = product.barcode;
    document.getElementById('edit-product-quantity').value = product.quantity;
    document.getElementById('edit-product-reorder-point').value = product.reorder_point;
    document.getElementById('edit-product-original-price').value = product.original_price;
    document.getElementById('edit-product-selling-price').value = product.selling_price;
    document.getElementById('edit-product-status').value = product.status;
    document.getElementById('edit-product-supplier').value = product.supplier_name;   
    editProductModalCon.style.display = 'flex';
}


// Listen for save button click to save the edited supplier
editProductSaveButton.addEventListener('click', function (event) {
event.preventDefault();

// Gather all the input field values into an object
const productDetails = {
    product_id: document.getElementById('edit-product-id').value,
    product_name: document.getElementById('edit-product-name').value.trim(),
    barcode: document.getElementById('edit-product-barcode').value.trim(),
    brand_id: document.getElementById('edit-product-brand').value,
    category_id: document.getElementById('edit-product-category').value.trim(),
    subcategory_id: document.getElementById('edit-product-subcategory').value.trim(),
    original_price: document.getElementById('edit-product-original-price').value.trim(),
    selling_price: document.getElementById('edit-product-selling-price').value.trim(),
    quantity: document.getElementById('edit-product-quantity').value.trim(),
    reorder_point: document.getElementById('edit-product-reorder-point').value.trim(),
    status: document.getElementById('edit-product-status').value.trim(),
    supplier_id: document.getElementById('edit-product-supplier').value.trim()   
};

// Send a POST request to the PHP handler to save the data
fetch('../handler/records/products/product-edit-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(productDetails),
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Product updated successfully!');
        editProductModalCon.style.display = 'none';
        fetchProductData(); // Assuming this function fetches and updates the supplier data
    } else {
        alert(`Error: ${data.message}`);
    }
})
.catch(error => console.error('Error during fetch:', error));
});

// Listen for exit button to close the modal
editProductExitButton .addEventListener('click', function () {
editProductModalCon.style.display = 'none';
});


/***************************| FOR DELETE PRODUCT |***********************************/
const deleteProductModal = document.querySelector('.delete-product-modal-container');
const deleteProductYesButton = document.querySelector('#delete-product-yes-button');
const cancelDeleteProductButton = document.querySelector('#delete-product-no-button');


let productId = null;  // Define productId globally for the delete process

// Handle product deletion
function handleDeleteProduct(event) {
  productId = event.currentTarget.dataset.id;  // Get the product ID from the button's data-id attribute
  console.log(productId);

  fetch(`../handler/records/products/retrieve-product-details.php?id=${productId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to fetch product details');
      }
      return response.json(); // Parse JSON if response is okay
    })
    .then(product => {
      if (product.error) {
        console.error('Error fetching product details for deleting product:', product.error);
        return;
      }
      displayDeleteProductDetails(product);
    })
    .catch(error => console.error('Error fetching product details:', error));
}

// Display product details for deletion
function displayDeleteProductDetails(product) {
  deleteProductModal.style.display = 'flex';
  document.querySelector('#delete-product-name').textContent = product.product_name;
}

// Confirm delete product
deleteProductYesButton.addEventListener('click', function () {
  console.log(productId);
  if (!productId) {
    console.error('Product ID is not defined.');
    return;
  }

  fetch('../handler/records/products/product-delete-handler.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `id=${productId}`  // Send the product ID as part of the body
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to delete product');
      }
      return response.text();  // Read as text to inspect raw response
    })
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

// Cancel delete product
cancelDeleteProductButton.addEventListener('click', function () {
  deleteProductModal.style.display = 'none'; 
});












});