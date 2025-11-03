document.addEventListener("DOMContentLoaded", () => {
    const switchIcon = document.getElementById('switch-metrics-boxes-icon');
    const boxOne = document.querySelector('.metrics-box-container-one');
    const boxTwo = document.querySelector('.metrics-box-container-two');

    // Toggle metrics boxes
    switchIcon?.addEventListener('click', () => {
        boxOne?.classList.toggle('active');
        boxTwo?.classList.toggle('active');
    });

    // Generic fetch helper
    async function fetchData(url, callback) {
        try {
            const res = await fetch(url);
            const json = await res.json();
            if (json.success && json.data) {
                callback(json.data);
            } else {
                console.error('Error fetching:', json.message || json);
            }
        } catch (err) {
            console.error('Fetch failed:', url, err);
        }
    }

    // ✅ Fetch Total Products
    fetchData('../handler/dashboard/retrieve-total-products.php', (data) => {
        const totalProducts = document.getElementById('total-products');
        if (totalProducts) totalProducts.textContent = data.total_products ?? '0';
    });

    // ✅ Fetch Total Low Stock Products
    fetchData('../handler/dashboard/retrieve-low-stock-products.php', (data) => {
        const lowStockEl = document.getElementById('low-stock-items');
        if (lowStockEl) lowStockEl.textContent = data.low_stock_count ?? '0';
    });


    // ✅ Fetch Total Sales
    fetchData('../handler/dashboard/retrieve-total-sales.php', (data) => {
        const salesEl = document.getElementById('total-sales');
        if (salesEl) {
            // Format as peso currency
            salesEl.textContent = `₱${Number(data.total_sales).toLocaleString()}`;
        }
    });

    // ✅ Fetch Total Inventory Value
    fetchData('../handler/dashboard/retrieve-total-value.php', (data) => {
        const valueEl = document.getElementById('total-value');
        if (valueEl) {
            valueEl.textContent = `₱${Number(data.total_value).toLocaleString()}`;
        }
    });
    // ✅ Fetch Total Expenses
   fetchData('../handler/dashboard/retrieve-total-expenses.php', (data) => {
        const expenseEl = document.getElementById('total-expenses');
        if (expenseEl) {
            expenseEl.textContent = `₱${Number(data.total_expenses).toLocaleString()}`;
        }
    });

    // ✅ Fetch Total Pending Orders
    fetchData('../handler/dashboard/retrieve-pending-orders.php', (data) => {
        const pendingEl = document.getElementById('total-pending-orders');
        if (pendingEl) {
            pendingEl.textContent = data.total_pending_orders ?? '0';
        }
    });

    // ✅ Fetch and display Low Stock Products
    fetchData('../handler/dashboard/retrieve-low-stock-alert.php', (data) => {
        const tbody = document.querySelector('#low-stock-alert-table tbody');
        if (!tbody) return;

        tbody.innerHTML = ''; // Clear existing rows

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="3" style="text-align:center;">No low-stock items</td></tr>
            `;
            return;
        }

        data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.product_name}</td>
                <td>${item.quantity}</td>
                <td>${item.alert_status}</td>
            `;
            tbody.appendChild(tr);
        });
    });

    // ✅ Fetch Recent Sales
    fetchData('../handler/dashboard/retrieve-recent-sales.php', (sales) => {
        const tbody = document.querySelector('#recent-sales-table tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (sales.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" style="text-align:center;">No recent sales found</td></tr>`;
            return;
        }

        sales.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.date}</td>
                <td>${item.customer_name}</td>
                <td>${item.total_items}</td>
                <td>₱${Number(item.total_payment).toLocaleString()}</td>
            `;
            tbody.appendChild(tr);
        });
    });


    // ✅ Fetch Total Rental Boxes
    fetchData('../handler/dashboard/retrieve-total-rental-boxes.php', (data) => {
        const totalEl = document.getElementById('total-rental-boxes');
        if (totalEl) totalEl.textContent = data.total_rental_boxes ?? '0';
    });

    // ✅ Fetch Occupied Rental Boxes
    fetchData('../handler/dashboard/retrieve-occupied-rental-boxes.php', (data) => {
        const occupiedEl = document.getElementById('occupied-rental-boxes');
        if (occupiedEl) occupiedEl.textContent = data.occupied_boxes ?? '0';
    });

    // ✅ Fetch Rental Box Summary Table
    fetchData('../handler/dashboard/retrieve-rental-box-summary.php', (data) => {
        const tbody = document.querySelector('#rental-box-summary-table tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (!data || data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" style="text-align:center;">No rental box records found</td></tr>`;
            return;
        }

        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.renter}</td>
                <td>${row.total_boxes}</td>
                <td>${row.status}</td>
                <td>${row.date}</td>
            `;
            tbody.appendChild(tr);
        });
    });



   





});