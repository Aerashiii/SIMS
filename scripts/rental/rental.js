document.addEventListener('DOMContentLoaded', () => {
    const rentalTableBody = document.querySelector('#rental-list-table tbody');
    const searchInput = document.getElementById('rental-search-input');
    const statusSelect = document.getElementById('rental-select-status');
    const markAsCompletedButton = document.getElementById('mark-as-completed-button');

    let currentTransactionId = null; // store current rental transaction ID

    // Load all rentals initially
    fetchRentalTransactions();

    // ✅ Fetch and display rental transactions
    async function fetchRentalTransactions() {
        rentalTableBody.innerHTML = `<tr><td colspan="6">Loading...</td></tr>`;

        try {
            const response = await fetch('../handler/rental/rental/retrieve-rental-transactions.php');
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                renderRentals(result.data);
            } else {
                rentalTableBody.innerHTML = `<tr><td colspan="6">No rental transactions found.</td></tr>`;
            }
        } catch (error) {
            console.error('Error loading rental transactions:', error);
            rentalTableBody.innerHTML = `<tr><td colspan="6">⚠️ Error loading data.</td></tr>`;
        }
    }

    // ✅ Render table
    function renderRentals(transactions) {
        rentalTableBody.innerHTML = '';
        transactions.forEach(rental => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${rental.renter_name}</td>
                <td>${rental.rented_quantity}</td>
                <td>${rental.rental_start_date}</td>
                <td>${rental.rental_end_date}</td>
                <td>${rental.status}</td>
                <td>
                    <button class="view-details-btn" data-id="${rental.rental_transaction_id}">View</button>
                </td>
            `;
            rentalTableBody.appendChild(tr);
        });

        // Add event listener for each "View" button
        document.querySelectorAll('.view-details-btn').forEach(btn => {
            btn.addEventListener('click', () => viewDetails(btn.dataset.id));
        });
    }

    // ✅ Search + Filter
    searchInput.addEventListener('input', filterTable);
    statusSelect.addEventListener('change', filterTable);

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const status = statusSelect.value.toLowerCase();

        document.querySelectorAll('#rental-list-table tbody tr').forEach(row => {
            const name = row.children[0].textContent.toLowerCase();
            const stat = row.children[4].textContent.toLowerCase();

            const matchesSearch = name.includes(search);
            const matchesStatus = !status || stat === status;

            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }

    // ✅ View Details Handler
    async function viewDetails(transactionId) {
        try {
            const response = await fetch(`../handler/rental/rental/retrieve-rental-details.php?id=${transactionId}`);
            const result = await response.json();

            if (result.success) {
                const rental = result.data;
                const detailContainer = document.querySelector('.rental-list-view-details-content-container');
                const listContainer = document.getElementById('rental-list-content-container');

                // Store current transaction ID for update
                currentTransactionId = transactionId;

                // Toggle visibility
                detailContainer.style.display = 'block';
                listContainer.style.display = 'none';

                // Fill renter details
                document.getElementById('rental-list-view-details-renter-name').textContent = rental.renter_name;
                document.getElementById('rental-list-view-details-renter-contact-num').textContent = rental.contact_number;
                document.getElementById('rental-list-view-details-renter-start-date').textContent = rental.rental_start_date;
                document.getElementById('rental-list-view-details-renter-due-date').textContent = rental.rental_end_date;

                // Fill box list
                const tbody = document.querySelector('#box-list-rented-table tbody');
                tbody.innerHTML = '';
                let total = 0;

                if (rental.boxes && rental.boxes.length > 0) {
                    rental.boxes.forEach(box => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${box.box_number}</td>
                            <td>${box.box_size}</td>
                            <td>${box.quantity}</td>
                            <td>₱${parseFloat(box.total_fee).toFixed(2)}</td>
                        `;
                        tbody.appendChild(tr);
                        total += parseFloat(box.total_fee);
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="4">No boxes found for this rental.</td></tr>`;
                }

                document.getElementById('box-rented-total-amount').textContent = `₱${total.toFixed(2)}`;
            } else {
                alert('Rental details not found.');
            }
        } catch (error) {
            console.error('Error loading rental details:', error);
        }
    }

    // ✅ Close view details
    document.getElementById('rental-view-details-exit-button').addEventListener('click', () => {
        document.querySelector('.rental-list-view-details-content-container').style.display = 'none';
        document.getElementById('rental-list-content-container').style.display = 'block';
    });

    // ✅ Handle "Mark as Completed"
    markAsCompletedButton.addEventListener('click', async () => {
        if (!currentTransactionId) {
            alert("No transaction selected!");
            return;
        }

        const confirmAction = confirm("Are you sure you want to mark this rental as completed?");
        if (!confirmAction) return;

        try {
            const response = await fetch('../handler/rental/rental/update-rental-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    rental_transaction_id: currentTransactionId,
                    status: 'completed'
                })
            });

            const result = await response.json();

            if (result.success) {
                alert("Rental marked as completed successfully!");
                // Hide details view and refresh list
                document.querySelector('.rental-list-view-details-content-container').style.display = 'none';
                document.getElementById('rental-list-content-container').style.display = 'block';
                fetchRentalTransactions();
            } else {
                alert("Failed to update rental status: " + result.message);
            }
        } catch (error) {
            console.error("Error updating status:", error);
            alert("An error occurred while updating status.");
        }
    });
});
