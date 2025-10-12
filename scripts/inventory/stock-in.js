//stock-in.js
document.addEventListener('DOMContentLoaded', function() { 

    const stockinProductSelectionButton = document.getElementById('inventory-stockin-product-selection-button');
    const stockinInventoryTable = document.getElementById('stock-in-inventory-table').querySelector('tbody');

    //FOR STOCK IN PRODUCT SELECTION MODAL
    const stockinProductSelectionModal = document.querySelector('.stockin-product-selection-modal-container');
    const stockinProductSelectionCancelButton = document.getElementById('stockin-product-selection-exit-button');
    const stockinProductSelectionTable  = document.getElementById('stockin-product-selection-table').querySelector('tbody');
    const posProductSearchInput = document.getElementById('stockin-product-selection-search-input');
    const stockinProductSelectionSearchButton = document.getElementById('product-selection-search-button');


    //FOR STOCK IN CONFIRMATION MODAL
    const stockinSaveButton = document.getElementById('stock-in-save-button');
    const stockinConfirmSaveButton = document.getElementById('confirm-submit-stock-in-button');
    const stockinConfirmCancelButton = document.getElementById('cancel-submit-stock-in-button');
    const stockinConfirmationModal = document.querySelector('.confirm-submit-stock-in-modal-container');

 

    stockinProductSelectionButton.addEventListener('click', function() {
        stockinProductSelectionModal.style.display = 'flex';
    });
    stockinProductSelectionCancelButton.addEventListener('click', function() {
        stockinProductSelectionModal.style.display = 'none';
    });
    stockinConfirmCancelButton.addEventListener('click', function() {
        stockinConfirmationModal.style.display = 'none';
    });

    stockinSaveButton.addEventListener('click', function() {     
        stockinConfirmationModal.style.display = 'flex';    
    });


    let stockIn= [];


    fetchProducts();
    
// Fetch products (all or filtered)
function fetchProducts(query = '') {
    fetch('../handler/inventory/stock-in/stockin-retrieve-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'query=' + encodeURIComponent(query)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductTable(data.data);
            } else {
                stockinProductSelectionTable.innerHTML = '<tr><td colspan="4">No products found</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load products:', err));
}
function populateProductTable(products) {
    stockinProductSelectionTable.innerHTML = '';
    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.product_name}</td>
            <td>${product.brand_name}</td>
            <td>${product.barcode}</td>
            <td>${product.quantity}</td>
            <td>
                <button class="add-to-stockin-button"
                    data-id="${product.id}"
                    data-name="${product.product_name}"
                    data-brand="${product.brand_name}"
                    data-barcode="${product.barcode}">
                    Add
                </button>
            </td>
        `;
        stockinProductSelectionTable.appendChild(row);

    });

    document.querySelectorAll('.add-to-stockin-button').forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.id;
            const name = btn.dataset.name;
            const brand = btn.dataset.brand;
            const barcode = btn.dataset.barcode;

            const exists = stockIn.find(item => item.productId === productId);
            if (!exists) {
                stockIn.push({ productId, name, brand, barcode });
                renderStockinTable();
               
            }
        });
    });
}

    // Search button click
// Event: Search as you type
posProductSearchInput.addEventListener('input', () => {
    const query = posProductSearchInput.value.trim();

    fetch('../handler/inventory/stock-in/stockin-retrieve-products.php', {
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
                stockinProductSelectionTable.innerHTML = '<tr><td colspan="4">No products found.</td></tr>';
            }
        })
        .catch(err => console.error('Search failed:', err));
});

// Enter key trigger search
posProductSearchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        const query = posProductSearchInput.value.trim();
        fetchProducts(query);
    }
});

function renderStockinTable() {
    stockinInventoryTable.innerHTML = '';
    stockIn.forEach((item, index) => {
        const Row = document.createElement('tr');
        Row.innerHTML = `
            <td style="display: none;"><input type="hidden" name="product_id[]" value="${item.productId}">${item.productId}</td>
            <td>${item.description}</td>
             <td>${item.barcode}</td>
            <td>${item.brand}</td>     
            <td><input type="number" name="quantity[]" min="1" required></td>
            <td><button type="button" onclick="removeProductItem(${index})">Remove</button></td>
        `;
        stockinInventoryTable.appendChild(Row);
    });
      // Correct way to check if table body has rows
      if (stockinInventoryTable.children.length > 0) {
        stockinSaveButton.style.display = 'block';
    } else {
        stockinSaveButton.style.display = 'none';
    }
}

window.removeProductItem = function (index) {
    stockIn.splice(index, 1);
    renderStockinTable();
};


// for saving stockin products.
stockinConfirmSaveButton.addEventListener('click', function () {
    const formData = new FormData();

    document.querySelectorAll('input[name="product_id[]"]').forEach(input => {
        formData.append('product_id[]', input.value);
    });

    document.querySelectorAll('input[name="quantity[]"]').forEach(input => {
        formData.append('quantity[]', input.value);
    });

    fetch('../handler/inventory/stock-in/stockin-update-product-details.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert(result.message);
            window.location.reload(); // Optional: refresh to reflect changes
        } else {
            alert('Error: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
});
















});