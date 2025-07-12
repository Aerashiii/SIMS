//pos.js

import { printReceipt } from './print-receipt.js';
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
    
    // FOR TRANSACTION CONFIRMATION 
    const posSalesProcessConfirmButton = document.getElementById('pos-sales-process-confirm-button');
    const processTransactPaymentMethod = document.getElementById('pos-sales-process-cancel-button');

    let cart = [];

    selectProductButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'flex';
    });

    productSelectionModalCloseButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'none';
    });
// FOR DIPLAYING AND HIDING TRANSACTION PROCESS MODAL

    // Inside DOMContentLoaded
    processPaymentButton.addEventListener('click', () => {
        if (cart.length === 0 ) {
            alert('Please add items to the cart before processing payment.');
            return;
        }

        const amountReceived = parseFloat(amountReceivedInput.value);
        if ( amountReceived <= 0 || amountReceived < subTotalEl.textContent) {
            alert('Please enter a valid amount received before processing payment.');
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
                <td>${product.description}</td>
                <td>${product.selling_price}</td>
                <td>
                    <button class="add-to-cart-button"
                        data-id="${product.id}"
                        data-name="${product.description}"
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
                <td>${item.description}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
                <td><button onclick="removeCartItem(${index})">Remove</button></td>
            `;
            cartTableBody.appendChild(cartRow);

            // Receipt table
            const receiptRow = document.createElement('tr');
            receiptRow.innerHTML = `
                <td>${item.description}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
            `;
            receiptTableBody.appendChild(receiptRow);

            // transaction table
            const transactionRow = document.createElement('tr');
            transactionRow.innerHTML = `
                <td>${item.description}</td>
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
/***************| FOR BARCODE SCANNER |************************* */
   //FOR SCANNER
const barcodeInput = document.getElementById('pos-barcode-scanner-input');
// Focus input automatically when page loads
barcodeInput.focus();

// Handle scanner input
barcodeInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        const scannedBarcode = barcodeInput.value.trim();
        console.log('Scanned Barcode:', scannedBarcode); // Debugging line
       
        // Fetch product by barcode
        fetch('../handler/pos/pos-retrieve-products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'barcode=' + encodeURIComponent(scannedBarcode)
        })
        .then(response => response.json())
        .then(data => {
            console.log('API Response Data:', data);  // Debugging line
            if (data.success && data.data.length > 0) {
                const product = data.data[0]; // Assuming first match is the product
                console.log('Product Found:', product); // Debugging line

                const existing = cart.find(item => item.barcode === product.barcode);
                if (existing) {
                    existing.quantity++;
                    existing.total = existing.quantity * existing.price;
                } else {
                    cart.push({
                        name: product.product_name,
                        barcode: product.barcode,
                        price: parseFloat(product.selling_price),
                        quantity: 1,
                        total: parseFloat(product.selling_price)
                    });
                }

                renderCart();  // Update the cart UI after adding the product
                barcodeInput.value = ''; // Clear barcode input after adding
            } else {
                alert('Product not found.');
                barcodeInput.value = ''; // Clear input if product not found
            }
        })
        .catch(error => {
            //console.error('Error fetching product by barcode:', error);
           // alert('Failed to fetch product.');
            barcodeInput.value = ''; // Clear input on error
        });
    }
});

/******************| FOR UPDATE THE QUANTITY OF THE PRODUCT AFTER CONFIRM THE PAYMENT |************************************ */

const posPrintReceiptButton = document.getElementById('pos-transact-print-receipt-button');
/*************************************************** */
// On Confirm Button Click
posSalesProcessConfirmButton.addEventListener('click', () => {
    const cash = parseFloat(processTransactCashAmount.textContent);
    const change = parseFloat(processTransactChangeAmount.textContent);
    const total_payment = parseFloat(processTransactsubTotal.textContent);
    const total_items = cart.reduce((sum, item) => sum + item.quantity, 0);
    const payment_method = "Cash";

    // Get customer inputs
    const customerNameInput = document.getElementById('pos-customer-name-input');
    const customerContactInput = document.getElementById('pos-customer-contact-number-input');
  
      const customer_name = customerNameInput && customerNameInput.value.trim() !== ''
          ? customerNameInput.value.trim()
          : 'Guest';
  
      const contact_number = customerContactInput && customerContactInput.value.trim() !== ''
          ? customerContactInput.value.trim()
          : null;

            // Now, call printReceipt
            printReceipt(cart, cash, payment_method, customer_name, contact_number);

    // Simulate server call here...
    fetch('../handler/pos/process-sale.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            cash,
            change,
            total_payment,
            total_items,
            payment_method,
            customer_name,
            contact_number,
            cart: JSON.stringify(cart)
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Hide transaction modal
            transactionProcessModal.style.display = 'none';



            // Show success modal
            document.querySelector('.pos-sales-success-modal-container').style.display = 'flex';
        } else {
            alert('Transaction failed. Please try again.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred while processing the transaction.');
    });
});
 
// On Next Order Button Click
document.getElementById('pos-transact-next-order-button').addEventListener('click', () => {
    location.reload(); // Reload page to reset everything
});


});