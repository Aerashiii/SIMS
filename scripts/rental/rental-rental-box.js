document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#rental-box-table tbody');
    const modalContainer = document.getElementById('editBoxModalContainer');
    const saveBtn = document.getElementById('edit-box-rental-save-button');
    const cancelBtn = document.getElementById('edit-box-rental-cancel-button');
    const toastEl = document.getElementById('toast');

    // 🧱 DELETE MODAL ELEMENTS
    const deleteModal = document.querySelector('.delete-box-modal-container');
    const deleteYesBtn = document.getElementById('delete-box-yes-button');
    const deleteNoBtn = document.getElementById('delete-box-no-button');
    const deleteBoxNumber = document.getElementById('delete-box-number');
    let currentDeleteBoxId = null;

    // ✅ FETCH & DISPLAY RENTAL BOXES
    async function fetchRentalBoxes() {
        try {
            const response = await fetch('../handler/rental/rental-box/retrieve-rental-boxes.php');
            const result = await response.json();
            tableBody.innerHTML = '';

            if (result.success && result.data.length > 0) {
                result.data.forEach(box => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${box.box_number}</td>
                        <td>${box.box_size}</td>
                        <td>${box.width} cm</td>
                        <td>${box.length} cm</td>
                        <td>₱ ${box.rental_fee}</td>
                        <td>${box.quantity}</td>
                        <td>${box.status}</td>
                        <td>
                            <button class="box-edit-btn" data-id="${box.box_id}">Edit</button>
                            <button class="box-delete-btn" data-id="${box.box_id}" data-number="${box.box_number}">Delete</button>
                        </td>`;
                    tableBody.appendChild(tr);
                });
            } else {
                tableBody.innerHTML = `<tr><td colspan="8">No rental boxes found.</td></tr>`;
            }
        } catch (error) {
            console.error('Error fetching boxes:', error);
            tableBody.innerHTML = `<tr><td colspan="8">⚠️ Failed to load data.</td></tr>`;
        }

        attachProductActionListeners();
    }

    // ✅ Attach event listeners
    function attachProductActionListeners() {
        document.querySelectorAll('.box-edit-btn').forEach(button =>
            button.addEventListener('click', handleEditBox)
        );
        document.querySelectorAll('.box-delete-btn').forEach(button =>
            button.addEventListener('click', handleDeleteBox)
        );
    }

    // ✅ OPEN EDIT MODAL
    async function handleEditBox(e) {
        const boxId = e.target.dataset.id;
        try {
            const response = await fetch(`../handler/rental/rental-box/retrieve-rental-box-details.php?box_id=${boxId}`);
            const text = await response.text();
            let box = JSON.parse(text);

            if (box.success && box.data) {
                const data = box.data;
                document.getElementById('rental-edit-box-id').value = data.box_id;
                document.getElementById('rental-edit-box-number').value = data.box_number;
                document.getElementById('rental-edit-box-size').value = data.box_size;
                document.getElementById('rental-edit-box-width').value = data.width;
                document.getElementById('rental-edit-box-length').value = data.length;
                document.getElementById('rental-edit-box-rental-fee').value = data.rental_fee;
                document.getElementById('rental-edit-box-quantity').value = data.quantity;
                document.getElementById('rental-edit-box-status').value = data.status;
                modalContainer.style.display = 'flex';
            } else {
                showToast('❌ Failed to load box details.');
            }
        } catch (error) {
            console.error("Error loading box details:", error);
            showToast("⚠️ Failed to fetch box details.");
        }
    }

    // ✅ CLOSE EDIT MODAL
    cancelBtn.addEventListener('click', () => {
        modalContainer.style.display = 'none';
    });

    // ✅ SAVE EDIT
    saveBtn.addEventListener('click', async () => {
        const data = {
            box_id: document.getElementById('rental-edit-box-id').value,
            box_number: document.getElementById('rental-edit-box-number').value,
            box_size: document.getElementById('rental-edit-box-size').value,
            width: document.getElementById('rental-edit-box-width').value,
            length: document.getElementById('rental-edit-box-length').value,
            rental_fee: document.getElementById('rental-edit-box-rental-fee').value,
            quantity: document.getElementById('rental-edit-box-quantity').value,
            status: document.getElementById('rental-edit-box-status').value
        };

        try {
            const response = await fetch('../handler/rental/rental-box/edit-rental-box-handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();

            if (result.success) {
                showToast('✅ Box updated successfully!');
                modalContainer.style.display = 'none';
                fetchRentalBoxes();
            } else {
                showToast('❌ Error: ' + result.message);
            }
        } catch (err) {
            console.error("Save error:", err);
            showToast("⚠️ Failed to update box.");
        }
    });

    // ✅ OPEN DELETE MODAL
    function handleDeleteBox(e) {
        currentDeleteBoxId = e.target.dataset.id;
        const boxNumber = e.target.dataset.number;
        deleteBoxNumber.textContent = `Box #${boxNumber}`;
        deleteModal.style.display = 'flex';
    }

    // ✅ CONFIRM DELETE
    deleteYesBtn.addEventListener('click', async () => {
        if (!currentDeleteBoxId) return;
        try {
            const response = await fetch('../handler/rental/rental-box/delete-rental-box-handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ box_id: currentDeleteBoxId })
            });

            const result = await response.json();
            if (result.success) {
                showToast('✅ Box deleted successfully!');
                deleteModal.style.display = 'none';
                fetchRentalBoxes();
            } else {
                showToast('❌ Error: ' + result.message);
            }
        } catch (error) {
            console.error('Delete error:', error);
            showToast('⚠️ Failed to delete box.');
        }
    });

    // ❌ CANCEL DELETE
    deleteNoBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none';
        currentDeleteBoxId = null;
    });

    // ✅ FETCH ON LOAD
    fetchRentalBoxes();

    // ✅ TOAST FUNCTION
    function showToast(message) {
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }
});
