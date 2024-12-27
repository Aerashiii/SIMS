document.addEventListener('DOMContentLoaded', function(){
    // FOR PRODUCT LIST TABLE
    const productListTable = document.getElementById('product-list-table');

    // FOR ADD PRODUCT
    const addProductModalCon = document.querySelector('.delete-product-modal-container');
    const addProductButton = document.getElementById('product-list-add-product-button');
    const addProductCancelButton =document.getElementById('add-product-cancel-button');
    const addProductForm = document.getElementById('add-product-form');
    // FOR ADD PRODUCT SELECT BRAND
    const addProductSelectBrand = document.getElementById('add-product-brand');
    const addProductSelectCategory = document.getElementById('add-product-category');
    const addProductSelectSubcategory = document.getElementById('add-product-subcategory');
  
    

    addProductButton.addEventListener('click', function(){
        addProductModalCon.style.display = 'flex';      
    })
    addProductCancelButton.addEventListener('click', function(){
        addProductModalCon.style.display = 'none';
    })
/*=====================================| FOR ADD PRODUCT |========================================================================== */
    fetchSelectBrandAddProduct();
    fetchSelectCategoryAddProduct();
    fetchSelectSubcategoryAddProduct();
    fetchSelectSupplierAddProduct();

    /**| RETRIEVE BRAND FOR ADD PRODUCT SELECT BRAND  |** */ 
    function fetchSelectBrandAddProduct() {
        fetch('../handler/records/brand/retrieve-brand.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => populateSelectBrandAddProduct(data))
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
                }
            })
            .catch(error => console.error('Error fetching supplier data:', error));
    
    }
    // Populate select supplier for adding product
    function populateSelectSupplierAddProduct(suppliers) {
        const addProductSelectSupplier = document.getElementById('add-product-select-supplier');
        suppliers.forEach(supplier => {
            const supplierOption = document.createElement('option');
            supplierOption.innerHTML = supplier.supplier_name;
            supplierOption.value = supplier.supplier_id;
            addProductSelectSupplier.appendChild(supplierOption);
        });
    }

 
 /**======================| FOR ADD PRODUCT |=============================== */
addProductForm.addEventListener('submit', function (event) {
    event.preventDefault();
    addProduct();
});

// Function to handle product creation
function addProduct() {
     // Get form values and trim any extra spaces
     const addProductName = document.getElementById("add-product-name").value.trim();
     const addProductBrand = document.getElementById("add-product-brand").value.trim();
     const addProductCategory = document.getElementById("add-product-category").value.trim();
     const addProductSubcategory = document.getElementById("add-product-subcategory").value.trim();
     const addProductBarcode = document.getElementById("add-product-barcode").value.trim();
     const addProductOriginalPrice = document.getElementById("add-product-original-price").value.trim();
     const addProductSellingPrice = document.getElementById("add-product-selling-price").value.trim();
     const addProductQuantity = document.getElementById("add-product-quantity").value.trim();
     const addProductReorderPoint = document.getElementById("add-product-reorder-point").value.trim();
     const addProductStatus = document.getElementById("add-product-status").value.trim();
     const addProductSupplier = document.getElementById("add-product-select-supplier").value.trim();

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













});