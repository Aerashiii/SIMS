// pos.js
import { printReceipt } from './print-receipt.js';

document.addEventListener('DOMContentLoaded', () => {
    /* ========== 🧾 TOAST SETUP ========== */
    const toastEl = document.getElementById('toast');

    function showToast(message) {
    if (!toastEl) return;
    toastEl.textContent = message;
    toastEl.classList.add('show');

    setTimeout(() => {
        toastEl.classList.remove('show');
        toastEl.textContent = '';
    }, 3000);
}

    /* ========== ELEMENTS ========== */
    const selectProductButton = document.getElementById('pos-select-product-button');
    const productSelectionModal = document.querySelector('.pos-product-selection-modal-container');
    const productSelectionModalCloseButton = document.getElementById('pos-product-selection-exit-button');
    const productSelectionTable = document.querySelector('#pos-product-selection-table tbody');
    const cartTableBody = document.querySelector('#pos-shopping-cart-table tbody');
    const receiptTableBody = document.querySelector('#pos-receipt-item-table tbody');

    const subTotalEl = document.getElementById('pos-shopping-sub-total');
    const amountReceivedInput = document.getElementById('pos-input-amount-recieved');
    const changeEl = document.getElementById('pos-shopping-change');

    const receiptTotalEl = document.getElementById('pos-receipt-amount-due');
    const receiptAmountReceivedEl = document.getElementById('pos-receipt-cash-amount');
    const receiptChangeEl = document.getElementById('pos-receipt-change-amount');

    // Transaction modal
    const processPaymentButton = document.getElementById('pos-transaction-process-button');
    const cancelTransactionButton = document.getElementById('pos-transaction-cancel-button');
    const transactionProcessModal = document.querySelector('.pos-sales-process-modal-container');
    const transactionProcessModalCloseButton = document.getElementById('pos-sales-process-exit-button');
    const processTransactionTable = document.querySelector('#pos-sales-process-table tbody');
    const processTransactsubTotal = document.getElementById('pos-sales-sub-total');
    const processTransactCashAmount = document.getElementById('pos-sale-cash-amount');
    const processTransactChangeAmount = document.getElementById('pos-sale-change-amount');
    const posSalesProcessConfirmButton = document.getElementById('pos-sales-process-confirm-button');
    const processTransactPaymentCancel = document.getElementById('pos-sales-process-cancel-button');

    let cart = [];

   

    


    // ========== 🧾 SUCCESS MODAL BUTTONS ==========
const successModal = document.querySelector('.pos-sales-success-modal-container');
const printReceiptBtn = document.getElementById('pos-transact-print-receipt-button');
const nextOrderBtn = document.getElementById('pos-transact-next-order-button');

// 🖨 PRINT RECEIPT BUTTON
printReceiptBtn.addEventListener('click', () => {
    const cashReceived = parseFloat(amountReceivedInput.value);
    const subTotal = parseFloat(subTotalEl.textContent);
    const paymentMethod = "Cash";
    const userName = document.getElementById('pos-receipt-cashier').textContent || 'Cashier';
    const customerName = document.getElementById('pos-customer-name-input').value || 'Guest';
    const customerContact = document.getElementById('pos-customer-contact-number-input').value || '';

    if (typeof printReceipt === "function") {
        printReceipt(cart, cashReceived, paymentMethod, userName, customerName, customerContact);
        showToast("Printing receipt...");
    } else {
        console.error("printReceipt() function not found!");
        showToast("Unable to print receipt: printReceipt() not found.");
    }
});

// 🔁 NEXT ORDER BUTTON
nextOrderBtn.addEventListener('click', () => {
    // Hide success modal
    successModal.style.display = 'none';

    // Clear all fields and cart
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
    document.getElementById('pos-customer-name-input').value = '';
    document.getElementById('pos-customer-contact-number-input').value = '';

    showToast("Ready for next order!");
});

    /* ========== 🛒 SELECT PRODUCT MODAL ========== */
    selectProductButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'flex';
        fetchProducts();
    });

    productSelectionModalCloseButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'none';
    });

    /* ========== 💳 PROCESS PAYMENT MODAL ========== */
    processPaymentButton.addEventListener('click', () => {
        if (cart.length === 0) {
            showToast('Please add items to the cart before processing payment.');
            return;
        }

        const amountReceived = parseFloat(amountReceivedInput.value);
        const subTotal = parseFloat(subTotalEl.textContent) || 0;
        if (isNaN(amountReceived) || amountReceived < subTotal) {
            showToast('Please enter a valid amount received.');
            return;
        }

        transactionProcessModal.style.display = 'flex';
    });

    transactionProcessModalCloseButton.addEventListener('click', () => {
        transactionProcessModal.style.display = 'none';
    });

    processTransactPaymentCancel.addEventListener('click', () => {
        transactionProcessModal.style.display = 'none';
    });

    /* ========== ✅ CONFIRM TRANSACTION ========== */
  /* ========== ✅ CONFIRM TRANSACTION ========== */
posSalesProcessConfirmButton.addEventListener('click', () => {
    if (cart.length === 0) {
        showToast('No items in the cart.');
        return;
    }

    const cashReceived = parseFloat(amountReceivedInput.value);
    const subTotal = parseFloat(subTotalEl.textContent);
    const paymentMethod = "Cash";
    const userId = document.getElementById('pos-receipt-cashier-id')?.value || null;
    const customerName = document.getElementById('pos-customer-name-input').value || 'Guest';
    const customerContact = document.getElementById('pos-customer-contact-number-input').value || '';

    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const changeAmount = cashReceived - subTotal;

     if (!userId) {
        console.error('❌ No user ID found.');
        showToast('User ID not found. Please re-login.');
        return;
    }

    // Debug log
    console.log({
        cart,
        totalItems,
        totalPayment: subTotal,
        cash: cashReceived,
        change: changeAmount,
        paymentMethod,
        customerName,
        customerContact,
        userId
    });

    // Prepare data for backend
    const formData = new FormData();
    formData.append('cart', JSON.stringify(cart));
    formData.append('total_items', totalItems);
    formData.append('total_payment', subTotal);
    formData.append('cash', cashReceived);
    formData.append('change', changeAmount);
    formData.append('payment_method', paymentMethod);
    formData.append('customer_name', customerName);
    formData.append('contact_number', customerContact);
    formData.append('user_id', userId);

    fetch('../handler/pos/process-sale.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Transaction completed successfully!');
                transactionProcessModal.style.display = 'none';
                
                // ✅ Show success modal
                document.querySelector('.pos-sales-success-modal-container').style.display = 'flex';

                // Reset fields
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
            } else {
                showToast('Transaction failed: ' + data.message);
                console.error(data.error);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showToast('An error occurred while processing the transaction.');
        });
});


    /* ========== ❌ CANCEL TRANSACTION ========== */
    cancelTransactionButton.addEventListener('click', () => {
        if (cart.length === 0) {
            showToast('No items in the cart to cancel.');
            return;
        }
        if (!confirm('Are you sure you want to cancel the transaction?')) return;

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
        showToast('Transaction cancelled.');
    });

    /* ========== 📦 FETCH PRODUCTS ========== */
    function fetchProducts(query = '') {
        fetch('../handler/pos/pos-retrieve-products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'query=' + encodeURIComponent(query)
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) populateProductTable(data.data);
                else productSelectionTable.innerHTML = '<tr><td colspan="3">No products found</td></tr>';
            })
            .catch(err => console.error('Error loading products:', err));
    }

    /* ========== 🧩 POPULATE PRODUCT TABLE ========== */
    /* ========== 🧩 POPULATE PRODUCT TABLE (UPDATED) ========== */
function populateProductTable(products) {
    productSelectionTable.innerHTML = '';
    products.forEach(p => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${p.description}</td>
            <td>${parseFloat(p.selling_price).toFixed(2)}</td>
            <td>${p.quantity > 0 ? p.quantity : '<span style="color:red;">Out of Stock</span>'}</td>
            <td>
                <button class="add-to-cart-button"
                    data-name="${p.description}"
                    data-price="${p.selling_price}"
                    data-quantity="${p.quantity}">
                    🛒 Add
                </button>
            </td>`;
        productSelectionTable.appendChild(tr);
    });

    document.querySelectorAll('.add-to-cart-button').forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const stockQty = parseInt(btn.dataset.quantity);

            // 🚫 Prevent adding if stock is zero
            if (stockQty <= 0) {
                showToast(`⚠️ ${name} is out of stock!`);
                return;
            }

            const existing = cart.find(item => item.name === name);

            if (existing) {
                // 🚫 Prevent exceeding stock
                if (existing.quantity >= stockQty) {
                    showToast(`⚠️ Not enough stock for ${name}. Available: ${stockQty}`);
                    return;
                }

                existing.quantity++;
                existing.total = existing.quantity * existing.price;
                showToast(`Added another ${name} (x${existing.quantity})`);
            } else {
                cart.push({ name, price, quantity: 1, total: price, stock: stockQty });
                showToast(`${name} added to cart!`);
            }

            renderCart();
        });
    });
}


    /* ========== 🔍 PRODUCT SEARCH ========== */
    const searchInput = document.getElementById('pos-product-selection-search-input');
    const searchButton = document.getElementById('pos-product-selection-search-submit-button');
    searchInput.addEventListener('input', () => fetchProducts(searchInput.value.trim()));
    searchButton.addEventListener('click', () => fetchProducts(searchInput.value.trim()));

    /* ========== 🧾 RENDER CART ========== */
    function renderCart() {
        cartTableBody.innerHTML = '';
        receiptTableBody.innerHTML = '';
        processTransactionTable.innerHTML = '';

        let subTotal = 0;
        cart.forEach((item, i) => {
            subTotal += item.total;

            const cartRow = document.createElement('tr');
            cartRow.innerHTML = `
                <td>${item.name}</td>
                <td>${item.price.toFixed(2)}</td>
                <td><input type="number" value="${item.quantity}" min="1" data-index="${i}" class="qty-input"></td>
                <td>${item.total.toFixed(2)}</td>
                <td><button data-index="${i}" class="remove-btn">Remove</button></td>`;
            cartTableBody.appendChild(cartRow);

            const receiptRow = document.createElement('tr');
            receiptRow.innerHTML = `<td>${item.quantity}</td><td>${item.name}</td><td>${item.total.toFixed(2)}</td>`;
            receiptTableBody.appendChild(receiptRow);

            const processRow = document.createElement('tr');
            processRow.innerHTML = `<td>${item.name}</td><td>${item.price.toFixed(2)}</td><td>${item.quantity}</td><td>${item.total.toFixed(2)}</td>`;
            processTransactionTable.appendChild(processRow);
        });

        subTotalEl.textContent = subTotal.toFixed(2);
        receiptTotalEl.textContent = subTotal.toFixed(2);
        processTransactsubTotal.textContent = subTotal.toFixed(2);
        calculateChange();
    }

    /* ========== 💰 CHANGE CALCULATION ========== */
    function calculateChange() {
        const subTotal = parseFloat(subTotalEl.textContent) || 0;
        const received = parseFloat(amountReceivedInput.value) || 0;
        const change = received - subTotal;
        changeEl.textContent = change.toFixed(2);
        receiptAmountReceivedEl.textContent = received.toFixed(2);
        receiptChangeEl.textContent = change.toFixed(2);
        processTransactCashAmount.textContent = received.toFixed(2);
        processTransactChangeAmount.textContent = change.toFixed(2);
    }
    amountReceivedInput.addEventListener('input', calculateChange);

    /* ========== ❌ REMOVE ITEM & UPDATE QTY ========== */
    cartTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-btn')) {
            const i = e.target.dataset.index;
            showToast(`${cart[i].name} removed from cart.`);
            cart.splice(i, 1);
            renderCart();
        }
    });

    cartTableBody.addEventListener('input', (e) => {
        if (e.target.classList.contains('qty-input')) {
            const i = e.target.dataset.index;
            const qty = parseInt(e.target.value);
            if (qty > 0) {
                cart[i].quantity = qty;
                cart[i].total = qty * cart[i].price;
                renderCart();
                showToast(`Updated ${cart[i].name} quantity to ${qty}.`);
            }
        }
    });
});
