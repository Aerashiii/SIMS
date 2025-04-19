document.addEventListener('DOMContentLoaded', function () {
    const selectProductButton = document.getElementById('pos-select-product-button');
    const productSelectionModal = document.querySelector('.pos-product-selection-modal-container');
    const productSelectionModalCloseButton = document.getElementById('pos-product-selection-exit-button');
    const productSelectionTable = document.getElementById('pos-product-selection-table').querySelector('tbody');
    const cartTableBody = document.getElementById('pos-shopping-cart-table').querySelector('tbody');
    const subTotalEl = document.getElementById('pos-shopping-sub-total');
    const amountReceivedInput = document.getElementById('pos-input-amount-recieved');
    const changeEl = document.getElementById('pos-shopping-change');

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

                const found = cart.find(item => item.barcode === barcode);
                if (found) {
                    found.quantity++;
                    found.total = found.quantity * found.price;
                } else {
                    cart.push({ name, barcode, price, quantity: 1, total: price });
                }

                updateCartTable();
                // Do NOT close modal
            });
        });
    }

    function updateCartTable() {
        cartTableBody.innerHTML = '';
        let subtotal = 0;

        cart.forEach((item, index) => {
            subtotal += item.total;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.barcode}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
                <td><button onclick="removeCartItem(${index})">Remove</button></td>
            `;
            cartTableBody.appendChild(row);
        });

        subTotalEl.textContent = subtotal.toFixed(2);
        calculateChange();
    }

    window.removeCartItem = function (index) {
        cart.splice(index, 1);
        updateCartTable();
    }

    function calculateChange() {
        const amountReceived = parseFloat(amountReceivedInput.value);
        const subtotal = parseFloat(subTotalEl.textContent);
        const change = isNaN(amountReceived) ? 0 : amountReceived - subtotal;
        changeEl.textContent = change >= 0 ? change.toFixed(2) : '0.00';
    }

    amountReceivedInput.addEventListener('input', calculateChange);
});