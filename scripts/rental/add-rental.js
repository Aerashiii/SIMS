document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('add-rental-transaction-form');
    const addBoxBtn = document.getElementById('add-rental-box-transaction-button');
    const boxTableBody = document.querySelector('#add-rental-box-transaction-table tbody');
    const totalAmountEl = document.getElementById('add-rental-transaction-total-amount');
    const rentalBoxModal = document.querySelector('.rentalbox-selection-modal-container');
    const exitModalBtn = document.getElementById('rentalbox-selection-exit-button');

    let selectedBoxes = [];

    // ✅ Show modal when clicking "Add Rental Box"
    addBoxBtn.addEventListener('click', (e) => {
        e.preventDefault();
        rentalBoxModal.style.display = 'flex';
        rentalBoxModal.classList.add('show');
        fetchRentalBoxes();
    });

    // ✅ Close modal when clicking the X or background
    exitModalBtn.addEventListener('click', closeModal);
    rentalBoxModal.addEventListener('click', (e) => {
        if (e.target === rentalBoxModal) closeModal();
    });

    function closeModal() {
        rentalBoxModal.classList.remove('show');
        setTimeout(() => (rentalBoxModal.style.display = 'none'), 150);
    }

    // ✅ Fetch available rental boxes
    async function fetchRentalBoxes() {
        const tbody = document.querySelector('#rentalbox-selection-table tbody');
        tbody.innerHTML = '<tr><td colspan="6">Loading...</td></tr>';

        try {
            const response = await fetch('../handler/rental/rental-box/retrieve-rental-boxes.php');
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                tbody.innerHTML = '';
                result.data.forEach(box => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${box.box_number}</td>
                        <td>${box.box_size}</td>
                        <td>${box.width} cm</td>
                        <td>${box.length} cm</td>
                        <td>₱${box.rental_fee}</td>
                        <td><button class="select-box-btn"
                            data-id="${box.box_id}"
                            data-number="${box.box_number}"
                            data-size="${box.box_size}"
                            data-fee="${box.rental_fee}">Select</button></td>`;
                    tbody.appendChild(tr);
                });

                document.querySelectorAll('.select-box-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const box = {
                            id: e.target.dataset.id,
                            number: e.target.dataset.number,
                            size: e.target.dataset.size,
                            fee: parseFloat(e.target.dataset.fee),
                            quantity: 1,
                            total: parseFloat(e.target.dataset.fee)
                        };
                        selectedBoxes.push(box);
                        renderSelectedBoxes();
                        closeModal();
                    });
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6">No boxes available.</td></tr>';
            }
        } catch (error) {
            console.error('Error fetching boxes:', error);
            tbody.innerHTML = '<tr><td colspan="6">⚠️ Failed to load boxes.</td></tr>';
        }
    }

    // ✅ Render selected boxes
    function renderSelectedBoxes() {
        boxTableBody.innerHTML = '';
        let total = 0;
        selectedBoxes.forEach((box, index) => {
            total += box.total;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${box.number}</td>
                <td>${box.size}</td>
                <td>₱${box.fee}</td>
                <td><input type="number" min="1" value="${box.quantity}" class="box-qty" data-index="${index}"></td>
                <td>₱${box.total.toFixed(2)}</td>
                <td><button class="remove-box-btn" data-index="${index}">Remove</button></td>
            `;
            boxTableBody.appendChild(tr);
        });
        totalAmountEl.textContent = `₱${total.toFixed(2)}`;
        attachBoxActions();
    }

    // ✅ Quantity & remove handling
    function attachBoxActions() {
        document.querySelectorAll('.box-qty').forEach(input => {
            input.addEventListener('input', (e) => {
                const idx = e.target.dataset.index;
                const qty = Math.max(1, parseInt(e.target.value));
                selectedBoxes[idx].quantity = qty;
                selectedBoxes[idx].total = qty * selectedBoxes[idx].fee;
                renderSelectedBoxes();
            });
        });

        document.querySelectorAll('.remove-box-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const idx = e.target.dataset.index;
                selectedBoxes.splice(idx, 1);
                renderSelectedBoxes();
            });
        });
    }

    // ✅ Handle form submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (selectedBoxes.length === 0) {
            alert('Please add at least one rental box.');
            return;
        }

        const data = {
            renter_name: document.getElementById('customer-name').value.trim(),
            contact_number: document.getElementById('customer-contact-number').value.trim(),
            status: document.getElementById('customer-status').value,
            rental_start_date: document.getElementById('rental-start-date').value,
            rental_end_date: document.getElementById('rental-end-date').value,
            boxes: selectedBoxes
        };

        try {
            const response = await fetch('../handler/rental/add-rental-transaction-handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Rental transaction added successfully!');
                form.reset();
                selectedBoxes = [];
                boxTableBody.innerHTML = '';
                totalAmountEl.textContent = '';
            } else {
                alert('❌ ' + result.message);
            }
        } catch (error) {
            console.error('Submit error:', error);
            alert('⚠️ Failed to add transaction.');
        }
    });
});
