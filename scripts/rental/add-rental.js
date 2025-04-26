import { printReceipt } from './rental-transaction-print-receipt.js';

document.addEventListener('DOMContentLoaded', function () {
    // Element Selectors
    const addRentalBoxButton = document.getElementById('add-rental-box-transaction-button');
    const addRentalBoxExitButton = document.getElementById('rentalbox-selection-exit-button');
    const rentalBoxModal = document.querySelector('.rentalbox-selection-modal-container');
    const addRentalBoxTableBody = document.getElementById('add-rental-box-transaction-table').querySelector('tbody');
    const totalAmountDisplay = document.getElementById('add-rental-transaction-total-amount');
    const searchInput = document.getElementById('rentalbox-selection-search-input');
    const rentalBoxSelectionTableBody = document.getElementById('rentalbox-selection-table').querySelector('tbody');

    let boxCart = [];

    // Modal Toggle
    addRentalBoxButton.addEventListener('click', () => rentalBoxModal.style.display = 'flex');
    addRentalBoxExitButton.addEventListener('click', () => rentalBoxModal.style.display = 'none');

    // Fetch and populate rental boxes
    function fetchRentalBox(query = '') {
        fetch('../handler/rental/retrieve-rental-box.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'query=' + encodeURIComponent(query)
        })
        .then(response => response.json())
        .then(data => {
            rentalBoxSelectionTableBody.innerHTML = '';
            if (data.success && data.data.length > 0) {
                populateRentalBoxTable(data.data);
            } else {
                rentalBoxSelectionTableBody.innerHTML = '<tr><td colspan="6">No Rental Box found</td></tr>';
            }
        })
        .catch(err => {
            console.error('Failed to load Rental Box:', err);
            rentalBoxSelectionTableBody.innerHTML = '<tr><td colspan="6">Error loading rental boxes.</td></tr>';
        });
    }

    function populateRentalBoxTable(rentalBoxes) {
        rentalBoxes.forEach(box => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${box.box_number}</td>
                <td>${box.box_size}</td>
                <td>${box.width}</td>
                <td>${box.length}</td>
                <td>${parseFloat(box.rental_fee).toFixed(2)}</td>
                <td>
                    <button class="add-to-cart-button"
                        data-id="${box.box_id}"
                        data-number="${box.box_number}"
                        data-size="${box.box_size} ${box.width}x${box.length}"
                        data-price="${box.rental_fee}"
                        data-max="${box.quantity || 10}">
                        Add
                    </button>
                </td>
            `;
            rentalBoxSelectionTableBody.appendChild(row);
        });

        // Add listeners for "Add" buttons
        document.querySelectorAll('.add-to-cart-button').forEach(button => {
            button.addEventListener('click', () => addToCart(button));
        });
    }

    function addToCart(button) {
        const id = button.dataset.id;   
        const number = button.dataset.number;
        const size = button.dataset.size;
        const price = parseFloat(button.dataset.price);

        const existingItem = boxCart.find(item => item.number === number);

        if (existingItem) {
            existingItem.quantity++;
            existingItem.total = existingItem.quantity * existingItem.price;
        } else {
            boxCart.push({
                id,
                number,
                size,
                price,
                quantity: 1,
                total: price,
                max: parseInt(button.dataset.max) || 10
            });
        }

        renderCartTable();
    }

    function renderCartTable() {
        addRentalBoxTableBody.innerHTML = '';
        let subtotal = 0;

        boxCart.forEach((item, index) => {
            subtotal += item.total;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.number}</td>
                <td>${item.size}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>
                    <input type="number" min="1" max="${item.max}" value="${item.quantity}" data-index="${index}" class="quantity-input">
                </td>
                <td>${item.total.toFixed(2)}</td>
                <td><button class="remove-button" data-index="${index}">Remove</button></td>
            `;
            addRentalBoxTableBody.appendChild(row);
        });

        totalAmountDisplay.textContent = subtotal.toFixed(2);

        // Attach event listeners after rendering
        attachCartEventListeners();
    }

    function attachCartEventListeners() {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', e => updateQuantity(e));
        });

        document.querySelectorAll('.remove-button').forEach(button => {
            button.addEventListener('click', e => removeBoxItem(parseInt(button.dataset.index)));
        });
    }

    function updateQuantity(event) {
        const index = parseInt(event.target.dataset.index);
        let newQuantity = parseInt(event.target.value);

        if (isNaN(newQuantity) || newQuantity <= 0) newQuantity = 1;
        if (newQuantity > boxCart[index].max) newQuantity = boxCart[index].max;

        boxCart[index].quantity = newQuantity;
        boxCart[index].total = newQuantity * boxCart[index].price;
        renderCartTable();
    }

    function removeBoxItem(index) {
        boxCart.splice(index, 1);
        renderCartTable();
    }

    // Search event
    searchInput.addEventListener('input', () => fetchRentalBox(searchInput.value.trim()));
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            fetchRentalBox(searchInput.value.trim());
        }
    });

    fetchRentalBox();


    /**************************| FOR SAVING RENTAL TRANSACTION DATA |***********************************/
const addRentalTransactionForm = document.getElementById('add-rental-transaction-form');

// Customer Info Inputs
const customerNameInput = document.getElementById('customer-name');
const customerContactInput = document.getElementById('customer-contact-number');
const customerStatusSelect = document.getElementById('customer-status');
const rentalStartDateInput = document.getElementById('rental-start-date');
const rentalEndDateInput = document.getElementById('rental-end-date');

addRentalTransactionForm.addEventListener('submit', function (event) {
    event.preventDefault();
    saveRentalTransaction();
});

function saveRentalTransaction() {
    // Validate form
    if (boxCart.length === 0) {
        alert('Please add at least one rental box.');
        return;
    }
    
    const customerName = customerNameInput.value.trim();
    const customerContact = customerContactInput.value.trim();
    const customerStatus = customerStatusSelect.value;
    const rentalStartDate = rentalStartDateInput.value;
    const rentalEndDate = rentalEndDateInput.value;

    if (!customerName || !customerStatus || !rentalStartDate || !rentalEndDate) {
        alert('Please fill all required fields.');
        return;
    }

    const transactionData = {
        customer_name: customerName,
        contact_number: customerContact,
        status: customerStatus,
        rental_start_date: rentalStartDate,
        rental_end_date: rentalEndDate,
        payment: totalAmountDisplay.textContent,
        boxes: boxCart
    };

    console.log('Submitting:', transactionData);

    fetch('../handler/rental/save-rental-transaction.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(transactionData)
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`Server error: ${response.status} - ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Rental transaction saved successfully!');
            renderCartTable();
           
            printReceiptModalCon.style.display = 'flex';
        } else {
            alert('Failed to save transaction: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error saving transaction:', error);
        alert('An error occurred while saving the transaction. Please check console for details.');
    });
}


/***************| FOR PRINTING RENTAL BOX RECEIPT |*********************** */
const printReceiptModalCon = document.querySelector('.print-receipt-modal-container');
const printreceiptYesButton = document.getElementById('print-receipt-yes-button');
const printreceiptNoButton = document.getElementById('print-receipt-no-button');

printreceiptYesButton.addEventListener('click', function(){

    const payment = totalAmountDisplay.textContent;
    const customer_name = customerNameInput.value.trim();
    const contact_number = customerContactInput.value.trim();
    const rentalStartDate = rentalStartDateInput.value.trim();
    const endDate =  rentalEndDateInput.value.trim();
  
    printReceipt( boxCart,payment, customer_name, contact_number, rentalStartDate, endDate);
    // Clear everything
    boxCart = [];
    customerNameInput.value = '';
    customerContactInput.value = '';
    customerStatusSelect.value = 'active';
    rentalStartDateInput.value = '';
    rentalEndDateInput.value = '';
    totalAmountDisplay.textContent = '0.00';
    renderCartTable();
});


printreceiptNoButton.addEventListener('click', function(){
    // Clear everything
    boxCart = [];
    customerNameInput.value = '';
    customerContactInput.value = '';
    customerStatusSelect.value = 'active';
    rentalStartDateInput.value = '';
    rentalEndDateInput.value = '';
    totalAmountDisplay.textContent = '0.00';
    renderCartTable(); // <-- Important to refresh the cart table

    printReceiptModalCon.style.display = 'none'
});



});
