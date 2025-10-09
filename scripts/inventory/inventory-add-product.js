// inventory-add-product.js
document.addEventListener("DOMContentLoaded", function () {
  const addProductForm = document.getElementById("add-product-form");
  const addProductSelectSupplier = document.getElementById("add-product-select-supplier");
  const addProductSelectBrand = document.getElementById("add-product-brand");
  const addProductSelectCategory = document.getElementById("add-order-product-category");
  const addProductSelectSubcategory = document.getElementById("add-product-subcategory");
  const addProductBarcodeInput = document.getElementById("add-product-barcode");
  const generateBarcodeBtn = document.getElementById("inventory-add-product-generate-barcode-button");

  // Load dropdowns
  fetchOptions("../handler/records/brand/retrieve-brand.php", addProductSelectBrand, "brand_id", "brand_name");
  fetchOptions("../handler/records/category/retrieve-category.php", addProductSelectCategory, "category_id", "category_name");
  fetchOptions("../handler/records/category/retrieve-subcategory.php", addProductSelectSubcategory, "subcategory_id", "subcategory_name");
  fetchOptions("../handler/records/supplier/retrieve-supplier.php", addProductSelectSupplier, "supplier_id", "supplier_name");
 // fetchCategoryData();
  
  function fetchOptions(url, selectElement, valueKey, textKey) {
    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (!Array.isArray(data)) return;
        data.forEach(item => {
          const option = document.createElement("option");
          option.value = item[valueKey];
          option.textContent = item[textKey];
          selectElement.appendChild(option);
        });
      })
      .catch(error => console.error(`Error fetching ${url}:`, error));
  }




  // Barcode restrictions
  addProductBarcodeInput.addEventListener("input", () => {
    addProductBarcodeInput.value = addProductBarcodeInput.value.replace(/\D/g, "").slice(0, 13);
  });

  generateBarcodeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    addProductBarcodeInput.value = Array.from({ length: 13 }, () => Math.floor(Math.random() * 10)).join('');
  });

  // Cancel button
  document.getElementById("add-product-cancel-button").addEventListener("click", function () {
    addProductForm.reset();
    addProductSelectSupplier.value = "";
  });

  // Submit
  addProductForm.addEventListener("submit", function (event) {
    event.preventDefault();
  

    const formData = new FormData(addProductForm);

   

    fetch("../handler/inventory/add-product.php", {
      method: "POST",
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("✅ Product added successfully!");
          location.reload();
        } else {
          alert("❌ Error: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while adding the product.");
      });
  });
});
