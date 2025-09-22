document.addEventListener("DOMContentLoaded", function () {
  const addProductForm = document.getElementById("add-product-form");
  const addProductModalCon = document.getElementById("add-product-modal");
  const addProductSelectSupplier = document.getElementById("add-product-select-supplier");

  const addProductSelectBrand = document.getElementById('add-product-brand');
  const addProductSelectCategory = document.getElementById('add-product-category');
  const addProductSelectSubcategory = document.getElementById('add-product-subcategory');

  const addProductBarcodeInput = document.getElementById("add-product-barcode");
const generateBarcodeBtn = document.getElementById("inventory-add-product-generate-barcode-button");

  
  //Fetch suppliers for dropdown
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

  function fetchSelectSupplierAddProduct() { 
    fetch('../handler/records/supplier/retrieve-supplier.php')
      .then(response => response.json())
      .then(data => {
        if (data.success && data.data.length > 0) {
          populateSelectSupplierAddProduct(data.data);
        }
      })
      .catch(error => console.error('Error fetching supplier data:', error));
  }

  function populateSelectSupplierAddProduct(suppliers) {
    suppliers.forEach(supplier => {
      const supplierOption = document.createElement('option');
      supplierOption.textContent = supplier.supplier_name;
      supplierOption.value = supplier.supplier_id;
      addProductSelectSupplier.appendChild(supplierOption);
    });
  }



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

  // Cancel button → reset form
  document.getElementById("add-product-cancel-button").addEventListener("click", function () {
    addProductForm.reset();
    addProductSelectSupplier.value = "";
  });

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
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Product added successfully!"); 
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(error => {
      console.error("Error:", error);
      alert("An error occurred while adding the product.");
    });
  }
});