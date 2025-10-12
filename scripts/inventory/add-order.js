document.addEventListener('DOMContentLoaded', function() {
    //DISPLAY AND CLOSE THE ADD PURCHASE PRODUCT MODAL
    const addProductButton = document.getElementById('add-purchase-product-button');
    const addProductCancelButton = document.getElementById('add-order-product-cancel-button');
    const addProductModal = document.querySelector('.add-order-modal-container');

    // Buttons & Table
    const generateBarcodeBtn = document.querySelector("#inventory-add-order-product-generate-barcode-button");
    const addProductBarcodeInput = document.getElementById("add-order-product-barcode");
    const addProductSubmitButton = document.getElementById("add-order-product-submit-button"); // ✅ Declare
    const productsTable = document.getElementById("purchase-order-products-table"); // ✅ Declare
    const savePurchaseOrderButton = document.getElementById("save-purchase-order-button"); // ✅ Declare

    // Dropdowns
    const addOrderProductBrand = document.getElementById('add-order-product-brand');
    const addOrderProductCategory = document.getElementById('add-order-product-category');
    const addOrderProductSubcategory = document.getElementById('add-order-product-subcategory');
    const addOrderProductSupplier = document.getElementById('add-order-product-select-supplier');

    // Form inputs
    const inputName = document.getElementById('add-order-product-name');
    const inputBrand = document.getElementById('add-order-product-brand');
    const inputCategory = document.getElementById('add-order-product-category');
    const inputSubcategory = document.getElementById('add-order-product-subcategory');
    const inputBarcode = document.getElementById('add-order-product-barcode');
    const inputQuantity = document.getElementById('add-order-product-quantity');
    const inputReorder = document.getElementById('add-order-product-reorder-point');
    const inputOriginalPrice = document.getElementById('add-order-product-original-price');
    const inputSellingPrice = document.getElementById('add-order-product-selling-price');
    const inputSupplier = document.getElementById('add-order-product-select-supplier');
    const inputStatus = document.getElementById('add-order-product-status');
    const inputDescription = document.getElementById('purchase-order-description');


     const toastEl = document.getElementById("toast");

    // Array to hold order products
    let purchaseOrderProducts = [];

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

                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data.success && Array.isArray(data.data)) {
                    items = data.data;
                }

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

    /*************| DISPLAY AND CLOSE MODAL |**************** */
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

    // ADD product to array + update table
    addProductSubmitButton.addEventListener('click', () => {
        const product = {
            name: inputName.value.trim(),
            brand_id: inputBrand.value || null,
            brand_name: inputBrand.selectedIndex > 0 ? inputBrand.options[inputBrand.selectedIndex].text : '',
            category_id: inputCategory.value || null,
            category_name: inputCategory.selectedIndex > 0 ? inputCategory.options[inputCategory.selectedIndex].text : '',
            subcategory_id: inputSubcategory.value || null,
            subcategory_name: inputSubcategory.selectedIndex > 0 ? inputSubcategory.options[inputSubcategory.selectedIndex].text : '',
            barcode: inputBarcode.value.trim(),
            quantity: Number(inputQuantity.value) || 0,
            reorder_point: Number(inputReorder.value) || 0,
            original_price: Number(inputOriginalPrice.value) || 0,
            selling_price: Number(inputSellingPrice.value) || 0,
            supplier_id: inputSupplier.value || null,
            supplier_name: inputSupplier.selectedIndex > 0 ? inputSupplier.options[inputSupplier.selectedIndex].text : '',
            status: inputStatus.value || '',
            description: inputDescription.value.trim()
        };

        if (!product.name || product.original_price <= 0) {
            alert("⚠ Please fill required fields (Name and Original Price).");
            return;
        }

        purchaseOrderProducts.push(product);
        renderProductsTable();
        addProductModal.style.display = 'none';
    });

    // Render products in table
    function renderProductsTable() {
        productsTable.querySelectorAll("tr:not(:first-child)").forEach(row => row.remove());

        purchaseOrderProducts.forEach((p, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${p.name}</td>
                <td>${p.category_name || "-"}</td>
                <td>${p.quantity}</td>
                <td>${p.original_price.toFixed(2)}</td>
                <td><button data-index="${index}" class="remove-product-btn">❌</button></td>
            `;
            productsTable.appendChild(row);
        });

        document.querySelectorAll(".remove-product-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = this.getAttribute("data-index");
                purchaseOrderProducts.splice(idx, 1);
                renderProductsTable();
            });
        });
    }

    // SAVE entire purchase order
    savePurchaseOrderButton.addEventListener('click', () => {
        if (purchaseOrderProducts.length === 0) {
            alert("⚠ No products in order.");
            return;
        }

        const formData = new FormData();
        formData.append("products", JSON.stringify(purchaseOrderProducts));

        fetch("../handler/inventory/purchase-order/save-purchase-order.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                  showToast("✅ " + data.message);
                purchaseOrderProducts = [];
                renderProductsTable();
            } else {
                showToast("❌ Failed to save order: " + data.message);
            }
        })
        .catch(err => {
            console.error("Save error:", err);
            showToast("❌ Error saving order.");
        });
    });


    function showToast(message) {
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }

});
