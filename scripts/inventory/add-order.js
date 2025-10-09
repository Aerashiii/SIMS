document.addEventListener('DOMContentLoaded', function() {
    //DISPLAY AND CLOSE THE ADD PURCHASE PRODUCT MODAL
    const addProductButton = document.getElementById('add-purchase-product-button');
    const addProductCancelButton = document.getElementById('add-order-product-cancel-button');
    const addProductModal = document.querySelector('.add-order-modal-container');

    //
    const generateBarcodeBtn = document.querySelector("#inventory-add-order-product-generate-barcode-button");
    const addProductBarcodeInput = document.getElementById("add-order-product-barcode");

    //
    const addOrderProductBrand = document.getElementById('add-order-product-brand');
    const addOrderProductCategory = document.getElementById('add-order-product-category');
    const addOrderProductSubcategory = document.getElementById('add-order-product-subcategory');
    const addOrderProductSupplier = document.getElementById('add-order-product-select-supplier');
   


    // Load dropdowns
  fetchOptions("../handler/records/brand/retrieve-brand.php", addOrderProductBrand, "brand_id", "brand_name");
  fetchOptions("../handler/records/category/retrieve-category.php", addOrderProductCategory, "category_id", "category_name");
  fetchOptions("../handler/records/category/retrieve-subcategory.php", addOrderProductSubcategory, "subcategory_id", "subcategory_name");
  fetchOptions("../handler/records/supplier/retrieve-supplier.php", addOrderProductSupplier, "supplier_id", "supplier_name");

  function fetchOptions(url, selectElement, valueKey, textKey) {
  fetch(url)
    .then(response => response.json())
    .then(data => {
      console.log("📦 Response from", url, data); // DEBUG

      // Support both plain array and {success:true, data:[...]} format
      let items = [];
      if (Array.isArray(data)) {
        items = data;
      } else if (data.success && Array.isArray(data.data)) {
        items = data.data;
      }

      // Reset dropdown
      selectElement.innerHTML = `<option value="">-- Select --</option>`;

      if (items.length === 0) {
        selectElement.innerHTML = `<option value="">⚠ No records found</option>`;
        return;
      }

      items.forEach(item => {
        const option = document.createElement("option");
        option.value = item[valueKey];
        option.textContent = item[textKey];
        selectElement.appendChild(option);
      });
    })
    .catch(error => {
      console.error(`Error fetching ${url}:`, error);
      selectElement.innerHTML = `<option value="">⚠ Error loading data</option>`;
    });
}

/*************| DISPLAY AND CLOSE THE ADD PURCHASE PRODUCT MODAL |**************** */
    addProductButton.addEventListener('click', function() {
        addProductModal.style.display = 'flex';
    });
    addProductCancelButton.addEventListener('click', function() {
        addProductModal.style.display = 'none';
    });



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



 

});