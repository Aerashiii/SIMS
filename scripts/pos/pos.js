//pos.js
document.addEventListener('DOMContentLoaded', function () {
    const selectProductButton = document.getElementById('pos-select-product-button');
    const productSelectionModal = document.querySelector('.pos-product-selection-modal-container');
    const productSelectionModalCloseButton = document.getElementById('pos-product-selection-exit-button');
    const productSelectionTable = document.getElementById('pos-product-selection-table').querySelector('tbody');
    const cartTableBody = document.getElementById('pos-shopping-cart-table').querySelector('tbody');
    const receiptTableBody = document.getElementById('pos-product-sales-receipt-table').querySelector('tbody');
   

    const subTotalEl = document.getElementById('pos-shopping-sub-total');
    const amountReceivedInput = document.getElementById('pos-input-amount-recieved');
    const changeEl = document.getElementById('pos-shopping-change');
    
    const receiptTotalEl = document.getElementById('pos-receiptt-total-sales-amount');
    const receiptAmountReceivedEl = document.getElementById('pos-receipt-amount-received');
    const receiptChangeEl = document.getElementById('pos-receipt-change-amount');


    // FOR POS TRANSACTION PROCESS PAYMENT AND CANCEL TRANSACTION BUTTONS
    const processPaymentButton = document.getElementById('pos-transaction-process-button');
    const cancelTransactionButton = document.getElementById('pos-transaction-cancel-button');

    //FOR TRANSACTION PROCESS MODAL
    const transactionProcessModal = document.querySelector('.pos-sales-process-modal-container');
    const transactionProcessModalCloseButton = document.getElementById('pos-sales-process-exit-button');
    const processTransactionTable = document.getElementById('pos-sales-process-table').querySelector('tbody');
    const processTransactsubTotal= document.getElementById('pos-sales-sub-total');
    const processTransactCashAmount = document.getElementById('pos-sale-cash-amount');
    const processTransactChangeAmount = document.getElementById('pos-sale-change-amount');
    const processTransactPaymentMethod = document.getElementById('pos-sales-process-cancel-button');


    let cart = [];

    selectProductButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'flex';
    });

    productSelectionModalCloseButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'none';
    });
// FOR DIPLAYING AND HIDING TRANSACTION PROCESS MODAL

    processPaymentButton.addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Please add items to the cart before processing payment.');
            return;
        }
        transactionProcessModal.style.display = 'flex';
    });
    transactionProcessModalCloseButton.addEventListener('click', () => {
        transactionProcessModal.style.display = 'none';
    });
    processTransactPaymentMethod.addEventListener('click', () => {
        transactionProcessModal.style.display = 'none';
    });
    cancelTransactionButton.addEventListener('click', () => {
        if (cart.length === 0) {
            alert('No items in the cart to cancel.');
            return;
        }
        cart = [];

        // Clear tables
        cartTableBody.innerHTML = '';
        receiptTableBody.innerHTML = '';
        processTransactionTable.innerHTML = '';

         // Reset values
         subTotalEl.textContent = '0.00';
         amountReceivedInput.value = '';
         changeEl.textContent = '0.00';
  
        receiptTotalEl.textContent = '0.00';     
        receiptAmountReceivedEl.textContent = '0.00';
        receiptChangeEl.textContent = '0.00';

        processTransactsubTotal.textContent = '0.00';
        processTransactCashAmount.textContent = '0.00';
        processTransactChangeAmount.textContent = '0.00';

        productSelectionModal.style.display = 'none';
    });

// FOR DISPLAYING THE PRODUCT SELECTION PRODUCT
    fetchProducts();

const posProductSearchInput = document.getElementById('pos-product-selection-search-input');
const posProductSearchButton = document.getElementById('pos-product-selection-search-submit-button');  




// Fetch products (all or filtered)
function fetchProducts(query = '') {
    fetch('../handler/pos/pos-retrieve-products.php', {
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
                productSelectionTable.innerHTML = '<tr><td colspan="4">No products found</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load products:', err));
}

    function populateProductTable(products) {
        productSelectionTable.innerHTML = '';
        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.product_name}</td>
                <td>${product.barcode}</td>
                <td>${product.selling_price}</td>
                <td>
                    <button class="add-to-cart-button"
                        data-id="${product.id}"
                        data-name="${product.product_name}"
                        data-barcode="${product.barcode}"
                        data-price="${product.selling_price}">
                        <img src="../assets/images/icons/add-to-cart.png" alt="Add to cart" class="add-to-cart-icon">
                        Add to cart
                    </button>
                </td>
            `;
            productSelectionTable.appendChild(row);
        });

        document.querySelectorAll('.add-to-cart-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const name = btn.dataset.name;
                const barcode = btn.dataset.barcode;
                const price = parseFloat(btn.dataset.price);

                const existing = cart.find(item => item.barcode === barcode);
                if (existing) {
                    existing.quantity++;
                    existing.total = existing.quantity * existing.price;
                } else {
                    cart.push({ name, barcode, price, quantity: 1, total: price });
                }

                renderCart();
              
            });
        });
    }

    // Search button click
// Event: Search as you type
posProductSearchInput.addEventListener('input', () => {
    const query = posProductSearchInput.value.trim();

    fetch('../handler/pos/pos-retrieve-products.php', {
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
                productSelectionTable.innerHTML = '<tr><td colspan="4">No products found.</td></tr>';
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

    function renderCart() {
        cartTableBody.innerHTML = '';
        receiptTableBody.innerHTML = '';
        processTransactionTable.innerHTML = '';

        let subTotal = 0;

        cart.forEach((item, index) => {
            subTotal += item.total;

            // Cart table
            const cartRow = document.createElement('tr');
            cartRow.innerHTML = `
                <td>${item.name}</td>
                <td>${item.barcode}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
                <td><button onclick="removeCartItem(${index})">Remove</button></td>
            `;
            cartTableBody.appendChild(cartRow);

            // Receipt table
            const receiptRow = document.createElement('tr');
            receiptRow.innerHTML = `
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
            `;
            receiptTableBody.appendChild(receiptRow);

            // transaction table
            const transactionRow = document.createElement('tr');
            transactionRow.innerHTML = `
                <td>${item.name}</td>
                <td>${item.barcode}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>            
            `;
            processTransactionTable.appendChild(transactionRow);
        });

        subTotalEl.textContent = subTotal.toFixed(2);
        receiptTotalEl.textContent = subTotal.toFixed(2);
        processTransactsubTotal.textContent = subTotal.toFixed(2);
        calculateChange();
    }

    function calculateChange() {
        const subTotal = parseFloat(subTotalEl.textContent) || 0;
        const received = parseFloat(amountReceivedInput.value) || 0;
        const change = received - subTotal;

        changeEl.textContent = change.toFixed(2);
        receiptAmountReceivedEl.textContent = received.toFixed(2);
        receiptChangeEl.textContent = change.toFixed(2);

        processTransactsubTotal.textContent = subTotal.toFixed(2);
        processTransactCashAmount.textContent = received.toFixed(2);
        processTransactChangeAmount.textContent = change.toFixed(2);
    }

    amountReceivedInput.addEventListener('input', calculateChange);

    // Remove item from cart
    window.removeCartItem = function(index) {
        cart.splice(index, 1);
        renderCart();
    };


/******************| FOR UPDATE THE QUANTITY OF THE PRODUCT AFTER CONFIRM THE PAYMENT |************************************ */
function updateProductQuantitiesAfterCheckout(addedProducts) {
    fetch('../assets/handler/pos/update-products-quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            addedProducts,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Product quantities updated successfully.');
            } else {
                console.error('Failed to update product quantities:', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating product quantities:', error);
        });
}


/*************************************************** */
document.getElementById('pos-sales-process-confirm-button').addEventListener('click', () => {
    const cashReceived = parseFloat(processTransactCashAmount.textContent);
    const change = parseFloat(processTransactChangeAmount.textContent);
    const paymentMethod = 'Cash'; // change this if you support more methods

    // Save to DB
    fetch('../assets/handler/pos/process-payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            products: cart,
            total: parseFloat(subTotalEl.textContent),
            cashReceived,
            change,
            paymentMethod
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            updateProductQuantitiesAfterCheckout(cart);
            alert("Transaction saved!");

            // Call print
            import('./print-receipt.js').then(({ printReceipt }) => {
                printReceipt(cart, cashReceived, paymentMethod);
            });

            // Reset all
            cart = [];
            cartTableBody.innerHTML = '';
            receiptTableBody.innerHTML = '';
            processTransactionTable.innerHTML = '';

            subTotalEl.textContent = '0.00';
            amountReceivedInput.value = '';
            changeEl.textContent = '0.00';

            receiptTotalEl.textContent = '0.00';
            receiptAmountReceivedEl.textContent = '0.00';
            receiptChangeEl.textContent = '0.00';

            processTransactsubTotal.textContent = '0.00';
            processTransactCashAmount.textContent = '0.00';
            processTransactChangeAmount.textContent = '0.00';

            productSelectionModal.style.display = 'none';
            transactionProcessModal.style.display = 'none';
        } else {
            alert("Failed to save transaction: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error saving transaction:", error);
    });
});














});