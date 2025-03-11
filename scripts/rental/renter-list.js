document.addEventListener('DOMContentLoaded', function(){
    // FOR PRODUCT LIST TABLE
    const renterListTable = document.getElementById('renter-list-table');

    // FOR ADD PRODUCT
    const addRentalModalCon = document.querySelector('.add-rental-modal-container');
    const addRentalButton = document.getElementById('add-rental-button');
    const addRentalCancelButton =document.getElementById('add-rental-cancel-button');
    const addRentalForm = document.getElementById('add-rental-form');


    // FOR EDIT PRODUCT
    const editProductExitButton = document.getElementById('product-edit-exit-button');
    const editProductModalCon = document.querySelector('.edit-product-modal-container');
    const editProductSaveButton = document.getElementById('save-edit-product-button');
    const editProductSelectBrand = document.getElementById('edit-product-brand');
    const editProductSelectCategory = document.getElementById('edit-product-category');
    const editProductSelectSubcategory= document.getElementById('edit-product-subcategory');
    const editProductSelectSupplier = document.getElementById('edit-product-supplier');

  
    

    addRentalButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'flex';      
    })
    addRentalCancelButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'none';
    })
/*=====================================| FOR ADD PRODUCT |========================================================================== */
    fetchSelectBrandAddProduct();
    fetchSelectCategoryAddProduct();
    fetchSelectSubcategoryAddProduct();
    fetchSelectSupplierAddProduct();
    fetchProductData();

    /**| RETRIEVE BRAND FOR ADD PRODUCT SELECT BRAND  |** */ 
    function fetchSelectBrandAddProduct() {
        fetch('../handler/records/brand/retrieve-brand.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                populateSelectBrandAddProduct(data); 
                populateSelectBrandEditProduct(data);
            })
            .catch(error => console.error('Error fetching brand data:', error));
    }

    function populateSelectBrandAddProduct(brands) {
        brands.forEach(brand => {
            const brandOption = document.createElement('option');
            brandOption.innerHTML = brand.brand_name;
            brandOption.value = brand.brand_id;      
            addProductSelectBrand.appendChild(brandOption);
        });
       
    }
    function populateSelectBrandEditProduct(brands) {
        brands.forEach(brand => {
            const brandOption = document.createElement('option');
            brandOption.innerHTML = brand.brand_name;
            brandOption.value = brand.brand_id;      
            editProductSelectBrand.appendChild(brandOption);
        });
       
    }
    /***| RETRIEVE CATEGORY FOR ADD PRODUCT SELECT CATEGORY |* */
     // DISPLAY CATEGORY
   function fetchSelectCategoryAddProduct() {
    fetch('../handler/records/category/retrieve-category.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                console.warn('No category data found.');
            } else {
                populateSelectCategoryAddProduct(data);
                populateSelectCategoryEditProduct(data);
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
    }

    // Populate select category for adding product
    function populateSelectCategoryAddProduct(categories) {
        categories.forEach(category => {
            const categoryOption = document.createElement('option');
            categoryOption.innerHTML = category.category_name;
            categoryOption.value = category.category_id;
            addProductSelectCategory.appendChild(categoryOption);
        });
    }
     // Populate select category for Editing product
     function populateSelectCategoryEditProduct(categories) {
        categories.forEach(category => {
            const categoryOption = document.createElement('option');
            categoryOption.innerHTML = category.category_name;
            categoryOption.value = category.category_id;
            editProductSelectCategory.appendChild(categoryOption);
        });
    }

    /***| RETRIEVE SUBCATEGORY FOR ADD PRODUCT SELECT SUBCATEGORY |* */
     // DISPLAY CATEGORY
   function fetchSelectSubcategoryAddProduct() {
    fetch('../handler/records/category/retrieve-subcategory.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                console.warn('No category data found.');
            } else {
                populateSelectSubcategoryAddProduct(data);
                populateSelectSubcategoryEditProduct(data);
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
    }

    // Populate select subcategory for adding product
    function populateSelectSubcategoryAddProduct(subcategories) {
        subcategories.forEach(subcategory => {
            const subcategoryOption = document.createElement('option');
            subcategoryOption.innerHTML = subcategory.subcategory_name;
            subcategoryOption.value = subcategory.subcategory_id;
            addProductSelectSubcategory.appendChild(subcategoryOption);
        });
    }
    // Populate select subcategory for editing product
    function populateSelectSubcategoryEditProduct(subcategories) {
        subcategories.forEach(subcategory => {
            const subcategoryOption = document.createElement('option');
            subcategoryOption.innerHTML = subcategory.subcategory_name;
            subcategoryOption.value = subcategory.subcategory_id;
            editProductSelectSubcategory.appendChild(subcategoryOption);
        });
    }

     /***| RETRIEVE SUPPLIER FOR ADD PRODUCT SELECT SUPPLIER |* */
     // DISPLAY CATEGORY
   function fetchSelectSupplierAddProduct() { 
        fetch('../handler/records/supplier/retrieve-supplier.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (!data.success || data.data.length === 0) {
                    console.warn('No supplier data found.');
                } else {
                    populateSelectSupplierAddProduct(data.data);
                    populateSelectSupplierEditProduct(data.data);
                }
            })
            .catch(error => console.error('Error fetching supplier data:', error));
    
    }
    // Populate select supplier for adding product
    function populateSelectSupplierAddProduct(suppliers) {
        suppliers.forEach(supplier => {
            const supplierOption = document.createElement('option');
            supplierOption.innerHTML = supplier.supplier_name;
            supplierOption.value = supplier.supplier_id;
            addProductSelectSupplier.appendChild(supplierOption);
        });
    }
     // Populate select supplier for editing product
     function populateSelectSupplierEditProduct(suppliers) {
        suppliers.forEach(supplier => {
            const supplierOption = document.createElement('option');
            supplierOption.innerHTML = supplier.supplier_name;
            supplierOption.value = supplier.supplier_id;
            editProductSelectSupplier.appendChild(supplierOption);
        });
    }

 
 /**======================| FOR ADD PRODUCT |=============================== */
addProductForm.addEventListener('submit', function (event) {
    event.preventDefault();
    addProduct();
});

// Function to handle product creation
function addProduct() {
    // Get form values and trim any extra spaces, ensure element exists first
    const addProductName = document.getElementById("add-product-name")?.value.trim() || "";
    const addProductBrand = document.getElementById("add-product-brand")?.value.trim() || "";
    const addProductCategory = document.getElementById("add-product-category")?.value.trim() || "";
    const addProductSubcategory = document.getElementById("add-product-subcategory")?.value.trim() || "";
    const addProductBarcode = document.getElementById("add-product-barcode")?.value.trim() || "";
    const addProductOriginalPrice = document.getElementById("add-product-original-price")?.value.trim() || "";
    const addProductSellingPrice = document.getElementById("add-product-selling-price")?.value.trim() || "";
    const addProductQuantity = document.getElementById("add-product-quantity")?.value.trim() || "";
    const addProductReorderPoint = document.getElementById("add-product-reorder-point")?.value.trim() || "";
    const addProductStatus = document.getElementById("add-product-status")?.value.trim() || "";
    const addProductSupplier = document.getElementById("add-product-select-supplier")?.value.trim() || "";

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