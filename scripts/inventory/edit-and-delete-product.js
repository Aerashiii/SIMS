// THIS IS edit-and-delete-product.js

document.addEventListener('DOMContentLoaded', function () {
    const editProductExitButton = document.getElementById('edit-product-exit-button');
    const editProductModalCon = document.querySelector('.edit-product-modal-container');
    const editProductSaveButton = document.getElementById('save-edit-product-button');

    const editProductSelectBrand = document.getElementById('edit-product-brand');
    const editProductSelectCategory = document.getElementById('edit-product-category');
    const editProductSelectSubcategory = document.getElementById('edit-product-subcategory');
    const editProductSelectSupplier = document.getElementById('edit-product-select-supplier');


    // Load dropdowns
  fetchOptions("../handler/records/brand/retrieve-brand.php", editProductSelectBrand, "brand_id", "brand_name");
  fetchOptions("../handler/records/category/retrieve-category.php", editProductSelectCategory, "category_id", "category_name");
  fetchOptions("../handler/records/category/retrieve-subcategory.php", editProductSelectSubcategory, "subcategory_id", "subcategory_name");
  fetchOptions("../handler/records/supplier/retrieve-supplier.php", editProductSelectSupplier, "supplier_id", "supplier_name");
 // fetchCategoryData();
  
  function fetchOptions(url, selectElement, valueKey, textKey) {
    fetch(url)
      .then(response => response.json())
      .then(data => {
        // Handle wrapped response
        const items = Array.isArray(data) ? data : data.data;

        if (!Array.isArray(items)) {
          console.warn(`⚠️ No valid array data found in ${url}`, data);
          return;
        }

        // Clear old options except first placeholder
        selectElement.innerHTML = '<option value="">Select</option>';

        items.forEach(item => {
          const option = document.createElement("option");
          option.value = item[valueKey];
          option.textContent = item[textKey];
          selectElement.appendChild(option);
        });
      })
      .catch(error => console.error(`❌ Error fetching ${url}:`, error));
  }

    editProductSaveButton.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('edit-product-form');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const productDetails = {
            product_id: document.getElementById('edit-product-id').value,
            product_name: document.getElementById('edit-product-name').value.trim(),
            barcode: document.getElementById('edit-product-barcode').value.trim(),
            brand_id: editProductSelectBrand.value,
            category_id: editProductSelectCategory.value,
            subcategory_id: editProductSelectSubcategory.value,
            original_price: document.getElementById('edit-product-original-price').value.trim(),
            selling_price: document.getElementById('edit-product-selling-price').value.trim(),
            quantity: document.getElementById('edit-product-quantity').value.trim(),
            reorder_point: document.getElementById('edit-product-reorder-point').value.trim(),
            status: document.getElementById('edit-product-status').value.trim(),
            supplier_id: editProductSelectSupplier.value,
            description: document.getElementById('edit-product-description').value.trim()
    };

        fetch('../handler/inventory/edit-product-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(productDetails),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Product updated successfully!');
                editProductModalCon.style.display = 'none';
                if (typeof fetchProductData === 'function') {
                    fetchProductData();
                }
                window.location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(err => console.error('Error during update:', err));
    });

    editProductExitButton.addEventListener('click', () => {
        editProductModalCon.style.display = 'none';
    });
});

/***************| FUNCTION FOR DELETING PRODUCT |**************************** */
// exporting this function to be used in onhand-product-list.js, low-stock-product.js, and out-of-stock-product.js
export function handleEditProduct(event) {
    const productId = event.currentTarget.dataset.id;
    fetch(`../handler/inventory/product-details.php?id=${productId}`)
        .then(res => res.json())
        .then(product => {
            if (product.error) {
                console.error('Error fetching product details:', product.error);
            } else {
                displayEditProductDetails(product);
            }
        })
        .catch(err => console.error('Error:', err));
}

function displayEditProductDetails(product) {
    document.getElementById('edit-product-id').value = product.id;
    document.getElementById('edit-product-name').value = product.product_name;
    document.getElementById('edit-product-barcode').value = product.barcode;
    document.getElementById('edit-product-brand').value = product.brand_id;
    document.getElementById('edit-product-category').value = product.category_id;
    document.getElementById('edit-product-subcategory').value = product.subcategory_id;
    document.getElementById('edit-product-original-price').value = product.original_price;
    document.getElementById('edit-product-selling-price').value = product.selling_price;
    document.getElementById('edit-product-quantity').value = product.quantity;
    document.getElementById('edit-product-reorder-point').value = product.reorder_point;
    document.getElementById('edit-product-status').value = product.status;
    document.getElementById('edit-product-select-supplier').value = product.supplier_id;

    // Set the selected options for brand, category, subcategory, and supplier
    setSelectedOption('edit-product-brand', product.brand_id);
    setSelectedOption('edit-product-category', product.category_id);
    setSelectedOption('edit-product-subcategory', product.subcategory_id);
    setSelectedOption('edit-product-select-supplier', product.supplier_id);

    document.querySelector('.edit-product-modal-container').style.display = 'flex';
}
function setSelectedOption(selectId, value) {
    const selectElement = document.getElementById(selectId);
    if (selectElement) {
        for (let option of selectElement.options) {
            if (option.value == value) {
                option.selected = true;
                break;
            }
        }
    }
}

// Delete section
let productIdToDelete = null;
const deleteProductModal = document.querySelector('.delete-product-modal-container');
const deleteProductYesButton = document.querySelector('#delete-product-yes-button');
const cancelDeleteProductButton = document.querySelector('#delete-product-no-button');

export function handleDeleteProduct(event) {
    productIdToDelete = event.currentTarget.dataset.id;

    fetch(`../handler/inventory/product-details.php?id=${productIdToDelete}`)
        .then(res => res.ok ? res.json() : Promise.reject(res.status))
        .then(product => {
            if (product.error) {
                console.error('Error:', product.error);
            } else {
                document.querySelector('#delete-product-name').textContent = product.product_name;
                deleteProductModal.style.display = 'flex';
            }
        })
        .catch(err => console.error('Error loading product for delete:', err));
}

deleteProductYesButton.addEventListener('click', () => {
    if (!productIdToDelete) {
        return alert('No product selected.');
    }

    fetch('../handler/inventory/delete-product-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${productIdToDelete}`
    })
    .then(res => res.text())
    .then(text => {
        try {
            const json = JSON.parse(text);
            if (json.success) {
                alert(json.success);
                window.location.reload();
            } else {
                alert(json.error);
            }
        } catch {
            console.error('Non-JSON response:', text);
            alert('Unexpected error occurred.');
        }
    })
    .catch(err => console.error('Delete request failed:', err));
});

cancelDeleteProductButton.addEventListener('click', () => {
    deleteProductModal.style.display = 'none';
});
