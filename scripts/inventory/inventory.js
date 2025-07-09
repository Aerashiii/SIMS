// ALL INVENTORY CONTENT SCRIPTS ONLY HERE
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.inventory-switch-content-buttons-container button');
    const contentContainers = document.querySelectorAll('.inventory-content-container');


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

/*=====================================| FOR ADD PRODUCT |========================================================================== */
     
    const addProductSelectBrand = document.getElementById('add-product-brand');
    const addProductSelectCategory = document.getElementById('add-product-category');
    const addProductSelectSubcategory = document.getElementById('add-product-subcategory');
    const addProductSelectSupplier = document.getElementById('add-product-select-supplier');

    const addProductModalCon = document.getElementById('add-product-modal');
    const addProductButton = document.getElementById('inventory-add-product-button');
    const addProductCancelButton = document.getElementById('add-product-cancel-button');

    fetchSelectBrandAddProduct();
    fetchSelectCategoryAddProduct();
    fetchSelectSubcategoryAddProduct();
    fetchSelectSupplierAddProduct();
   

        //DISPLAY THE ADD PRODUCT MODAL WHEN ADD NEW PRODUCT BUTTON CLICKED
    ///addProductButton.addEventListener('click', function(){
    //    addProductModalCon.style.display = 'flex';
  //      console.log('Add Product Button Clicked');
  //  })


    /**| RETRIEVE BRAND FOR ADD PRODUCT SELECT BRAND  |** */ 
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
        suppliers.forEach(supplier => {
            const supplierOption = document.createElement('option');
            supplierOption.innerHTML = supplier.supplier_name;
            supplierOption.value = supplier.supplier_id;
            addProductSelectSupplier.appendChild(supplierOption);
        });
    }
   

 
 /**======================| FOR ADD PRODUCT |=============================== */

const addProductForm = document.getElementById("add-product-form");
const addProductBarcodeInput = document.getElementById("add-product-barcode");
const generateBarcodeBtn = document.getElementById("inventory-add-product-generate-barcode-button");

// Allow only digits, max 13
addProductBarcodeInput.addEventListener("input", () => {
  addProductBarcodeInput.value = addProductBarcodeInput.value.replace(/\D/g, "").slice(0, 13);
});

// Generate 13-digit barcode
generateBarcodeBtn.addEventListener("click", (e) => {
  e.preventDefault();
  addProductBarcodeInput.value = generate13DigitBarcode();
});

function generate13DigitBarcode() {
  return Array.from({ length: 13 }, () => Math.floor(Math.random() * 10)).join('');
}

// Handle form submission
addProductForm.addEventListener("submit", function (event) {
  event.preventDefault();
  addProduct();
});

function addProduct() {
  const formData = new FormData(addProductForm);

  fetch("../handler/inventory/add-product.php", {
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
        addProductModalCon.style.display = "none";
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred while adding the product.");
    });
}


  //HIDE THE ADD PRODUCT MODAL WHEN CANCEL BUTTON CLICKED
    addProductCancelButton.addEventListener('click', function(){
        addProductModalCon.style.display = 'none';
    })



});