document.addEventListener('DOMContentLoaded', function(){
    
    //ON HAND PRODUCT LIST DISPLAY
    const onhandProductListTable = document.getElementById('onhand-inventory-table');

    // FOR ADDING PRODUCT 
    const addProductForm = document.getElementById('add-product-form');


/************| FOR CALLING THE FUNCTIONS |**************** */
fetchProductData();

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
    fetch('../handler/inventory/onhand-product/retrieve-products.php')
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
        onhandProductListTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

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
                    <button data-id="${product.id}" class="product-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${product.id}" class="product-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            onhandProductListTable.appendChild(row);
        });
       // attachProductActionListeners();
    }
/*
    function attachProductActionListeners() {
        document.querySelectorAll('.product-edit-button').forEach(button =>
            button.addEventListener('click', handleEditProduct)
        );
        document.querySelectorAll('.product-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteProduct)

        );
    }
*/

}); 