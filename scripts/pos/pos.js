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

    let cart = [];

    selectProductButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'flex';
    });

    productSelectionModalCloseButton.addEventListener('click', () => {
        productSelectionModal.style.display = 'none';
    });

    fetchProducts();

    function fetchProducts() {
        fetch('../handler/pos/pos-retrieve-products.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateProductTable(data.data);
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
               // productSelectionModal.style.display = 'none';
            });
        });
    }

    function renderCart() {
        cartTableBody.innerHTML = '';
        receiptTableBody.innerHTML = '';

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
        });

        subTotalEl.textContent = subTotal.toFixed(2);
        receiptTotalEl.textContent = subTotal.toFixed(2);
        calculateChange();
    }

    function calculateChange() {
        const subTotal = parseFloat(subTotalEl.textContent) || 0;
        const received = parseFloat(amountReceivedInput.value) || 0;
        const change = received - subTotal;

        changeEl.textContent = change.toFixed(2);
        receiptAmountReceivedEl.textContent = received.toFixed(2);
        receiptChangeEl.textContent = change.toFixed(2);
    }

    amountReceivedInput.addEventListener('input', calculateChange);

    // Remove item from cart
    window.removeCartItem = function(index) {
        cart.splice(index, 1);
        renderCart();
    };
});