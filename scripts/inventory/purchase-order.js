// ALL INVENTORY CONTENT SCRIPTS ONLY HERE
document.addEventListener('DOMContentLoaded', function () {
 
    const addProductOrderButton = document.getElementById('inventory-add-order-button');
    const addProductOrderCancelButton = document.getElementById('add-order-product-cancel-button');
    const addProductOrderModalCon = document.querySelector('.add-order-modal-container');

 
    //DISPLAY THE ADD PRODUCT MODAL WHEN ADD NEW PRODUCT BUTTON CLICKED
    addProductOrderButton.addEventListener('click', function(){
        addProductOrderModalCon.style.display = 'flex';
    })
    //HIDE THE ADD PRODUCT MODAL WHEN CANCEL BUTTON CLICKED
    addProductOrderCancelButton.addEventListener('click', function(){
        addProductOrderModalCon.style.display = 'none';
    })


/**=========================| START FOR ADD PRODUCT ORDER |=============================== */
/**=========================| START FOR ADD PRODUCT ORDER |=============================== */

/************| FOR CALLING THE FUNCTIONS |**************** */
fetchSelectBrandAddProduct();
fetchSelectCategoryAddProduct();
fetchSelectSubcategoryAddProduct();
fetchSelectSupplierAddProduct();

// FOR ADDING PRODUCT 
const addProductOrderForm = document.getElementById('add-order-product-form');
const addProductOrderSelectBrand = document.getElementById('add-order-product-brand');
const addProductOrderSelectCategory = document.getElementById('add-order-product-category');
const addProductOrderSelectSubcategory = document.getElementById('add-order-product-subcategory');
const addProductOrderSelectSupplier = document.getElementById('add-order-product-select-supplier');

/*****| RETRIEVE BRAND  |******/ 
function fetchSelectBrandAddProduct() {
    fetch('../handler/records/brand/retrieve-brand.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            populateSelectBrandAddProduct(data);                
        })
        .catch(error => console.error('Error fetching brand data:', error));
}

// FUNCTION TO POPULATE  ADD ORDER SELECT BRAND
function populateSelectBrandAddProduct(brands) {
    brands.forEach(brand => {
        const brandOption = document.createElement('option');
        brandOption.innerHTML = brand.brand_name;
        brandOption.value = brand.brand_id;      
        addProductOrderSelectBrand.appendChild(brandOption);
    });     
}

/***| RETRIEVE CATEGORY FOR ADD PRODUCT ORDER SELECT CATEGORY |* */
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
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
}

// FUNCTION TO POPULATE  ADD ORDER SELECT CATEGORY
function populateSelectCategoryAddProduct(categories) {
    categories.forEach(category => {
        const categoryOption = document.createElement('option');
        categoryOption.innerHTML = category.category_name;
        categoryOption.value = category.category_id;
        addProductOrderSelectCategory.appendChild(categoryOption);
    });
}

/***| RETRIEVE SUBCATEGORY FOR ADD PRODUCT ORDER SELECT SUBCATEGORY |* */
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
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
}

// FUNCTION TO POPULATE  ADD ORDER SELECT SUBCATEGORY
function populateSelectSubcategoryAddProduct(subcategories) {
    subcategories.forEach(subcategory => {
        const subcategoryOption = document.createElement('option');
        subcategoryOption.innerHTML = subcategory.subcategory_name;
        subcategoryOption.value = subcategory.subcategory_id;
        addProductOrderSelectSubcategory.appendChild(subcategoryOption);
    });
} 

/***| RETRIEVE SUPPLIER FOR ADD PRODUCT ORDER SELECT SUPPLIER |* */
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
            }
        })
        .catch(error => console.error('Error fetching supplier data:', error));    
}

// FUNCTION TO POPULATE  ADD ORDER SELECT SUPPLIER
function populateSelectSupplierAddProduct(suppliers) {
    suppliers.forEach(supplier => {  
        const supplierOption = document.createElement('option');
        supplierOption.innerHTML = supplier.supplier_name;
        supplierOption.value = supplier.supplier_id;
        addProductOrderSelectSupplier.appendChild(supplierOption);
    });
}

const addProductOrderBarcodeInput = document.getElementById('add-order-product-barcode');
const generateBarcodeBtn = document.getElementById('inventory-add-order-product-generate-barcode-button');

// Prevent non-digit characters and enforce max 13 characters
addProductOrderBarcodeInput.addEventListener('input', () => {
    addProductOrderBarcodeInput.value = addProductOrderBarcodeInput.value.replace(/\D/g, '').slice(0, 13);
});

// Generate 13-digit random barcode
generateBarcodeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const randomBarcode = generate13DigitBarcode();
    addProductOrderBarcodeInput.value = randomBarcode;
});

// Barcode generation helper function
function generate13DigitBarcode() {
    let barcode = '';
    for (let i = 0; i < 13; i++) {
        barcode += Math.floor(Math.random() * 10);
    }
    return barcode;
}

// Handle form submission
addProductOrderForm.addEventListener('submit', function (event) {
    event.preventDefault();
    addProduct();
});

// Function to handle product creation
function addProduct() {
    const formData = new FormData(addProductOrderForm);
    
    // Additional validation
    const barcode = formData.get('product_barcode');
    if (barcode.length !== 13) {
        alert("Barcode must be exactly 13 digits.");
        return;
    }

    // Convert numeric fields to proper types
    const originalPrice = parseFloat(formData.get('original_price'));
    const sellingPrice = parseFloat(formData.get('selling_price'));
    const quantity = parseInt(formData.get('quantity'));
    const reorderPoint = parseInt(formData.get('reorder_point'));

    if (isNaN(originalPrice) || isNaN(sellingPrice) || isNaN(quantity) || isNaN(reorderPoint)) {
        alert("Please enter valid numeric values for price and quantity fields.");
        return;
    }

    if (sellingPrice < originalPrice) {
        alert("Selling price should be greater than or equal to original price.");
        return;
    }

    // Submit via fetch
    fetch("../handler/inventory/purchase-order/add-order.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert("Purchase order added successfully!");
            addProductOrderForm.reset();
            window.location.reload();
            document.querySelector(".add-order-modal-container").style.display = "none";
            // Optionally refresh product list here
        } else {
            alert("Error adding product: " + (data.message || "Unknown error"));
        }
    })
    .catch(error => {
        console.error("Error submitting purchase order:", error);
        alert("An error occurred while submitting the form. Please try again.");
    });
}
/*=====================================| END OF ADD ORDER SCRIPT |====================================================== */


/*=================================| START OF DISPLAYING ORDER PRODUCTS SCRIPT |==================================== */


    const orderProductListTableBody  = document.getElementById('purchase-order-inventory-table').querySelector('tbody');
    const orderProductSearchInput = document.getElementById('inventory-purchase-order-search-input');
    const SelectCategoryOnOrderTable = document.getElementById('select-order-product-by-category');

    // Initial data fetch
    fetchCategoryDataForSelectCategory();
    fetchProductData();

// Add global state for current filters
let currentSearchQuery = '';
let currentSelectedCategory = '';
// Fetch products (all or filtered)

function fetchProductData(query = '', categoryId = '') {
    const formData = new URLSearchParams();
    formData.append('query', query);
    formData.append('category_id', categoryId);

    fetch('../handler/inventory/purchase-order/retrieve-order-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateProductTable(data.data);
        } else {
            orderProductListTableBody.innerHTML = '<tr><td colspan="12">No products found</td></tr>';
        }
    })
    .catch(err => console.error('Failed to load products:', err));
}


    function populateProductTable(products) {
        orderProductListTableBody.innerHTML = '';

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.barcode}</td>
                <td>${product.product_name}</td>
                <td>${product.category_name}</td>
                <td>${product.subcategory_name}</td>
                <td>${product.brand_name}</td>
                <td>${product.quantity}</td>
                <td>${product.reorder_point}</td>
                <td>${product.original_price}</td>
                <td>${product.selling_price}</td>
                <td>${product.supplier}</td>
                <td>${product.status}</td>
                <td>
                    <button data-id="${product.order_id}" class="purchase-completed-button">Completed</button>
                    <button data-id="${product.order_id}" class="purchase-remove-button style="display:none;"">Remove</button>

                    
                </td>
            `;
            orderProductListTableBody.appendChild(row);
        });

        attachOrderlActionListeners();
    }

    
    function attachOrderlActionListeners() {    
        document.querySelectorAll('.purchase-completed-button').forEach(button =>
            button.addEventListener('click', handlecompletedPurchase)
        );
        document.querySelectorAll('.purchase-remove-button').forEach(button =>
            button.addEventListener('click', handleRemovePurchase)
        );
    
    }


/*******************| FOR CHANGE THE STATUS OF RENTAL WHEN USER CLICK THE rental-completed-button |*************************************** */
function handlecompletedPurchase(event) {
    const purchaseId = event.currentTarget.dataset.id;

    if (confirm('Are you sure you want to mark this rental as completed?')) {
        const formData = new URLSearchParams();
        formData.append('purchase_transaction_id', purchaseId);

        fetch('../handler/inventory/purchase-order/update-purchase-status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Purchase Order  status updated to completed!');
                fetchProductData(); // Refresh the rental list after update
            } else {
                alert('Failed to update rental status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating Purchase status:', error);
            alert('Error updating Purchase status.');
        });
    }
}
/*******************| FOR PURCHASE TRANSACTION DELETION |*************************************** */
function handleRemovePurchase(event) {
    const purchaseId = event.currentTarget.dataset.id;

    if (confirm('Are you sure you want to remove this purchase transaction?')) {
        const formData = new URLSearchParams();
        formData.append('purchase_transaction_id', purchaseId);

        fetch('../handler/inventory/purchase-order/remove-purchase-order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Purchase Order  status updated to completed!');
                fetchProductData(); // Refresh the rental list after update
            } else {
                alert('Failed to update rental status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating Purchase status:', error);
            alert('Error updating Purchase status.');
        });
    }
}


/*************************| FOR SELECTING CATEGORY |******************************** */
    function fetchCategoryDataForSelectCategory() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    console.warn('No category data found.');
                } else {
                    populateSelectCategoryOnSubcategoryTable(data);
                }
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function populateSelectCategoryOnSubcategoryTable(categories) {
        SelectCategoryOnOrderTable.innerHTML = ''; // Clear previous options
        const defaultOption = document.createElement('option');
        defaultOption.text = 'All Categories';
        defaultOption.value = '';
        SelectCategoryOnOrderTable.appendChild(defaultOption);

        categories.forEach(category => {
            const option = document.createElement('option');
            option.text = category.category_name;
            option.value = category.category_id;
            SelectCategoryOnOrderTable.appendChild(option);
        });
    }


/****************| FOR SEARCHING PRODUCT ON ONHAND PRODUCT TABLE |********************* */
// Update category filter
SelectCategoryOnOrderTable.addEventListener('change', function () {
    currentSelectedCategory = this.value;
    fetchProductData(currentSearchQuery, currentSelectedCategory);
});

// Update search filter
orderProductSearchInput.addEventListener('input', () => {
    currentSearchQuery = orderProductSearchInput.value.trim();
    fetchProductData(currentSearchQuery, currentSelectedCategory);
});
// Event: Search as you type
orderProductSearchInput.addEventListener('input', () => {
    const query = orderProductSearchInput.value.trim();

    fetch('../handler/inventory/purchase-order/retrieve-order-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'query=' + encodeURIComponent(query)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductTable(data.data);
            } else {
                orderProductListTableBody.innerHTML = '<tr><td colspan="4">No products found.</td></tr>';
            }
        })
        .catch(err => console.error('Search failed:', err));
});

// Enter key trigger search
orderProductSearchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        currentSearchQuery = orderProductSearchInput.value.trim();
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    }
});










});