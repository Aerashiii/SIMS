document.addEventListener("DOMContentLoaded", () => {
    const switchIcon = document.getElementById('switch-metrics-boxes-icon');
    const boxOne = document.querySelector('.metrics-box-container-one');
    const boxTwo = document.querySelector('.metrics-box-container-two');

    // ✅ Toggle metrics box visibility
    switchIcon?.addEventListener('click', () => {
        boxOne?.classList.toggle('active');
        boxTwo?.classList.toggle('active');
    });

    // ✅ Reusable fetch helper
    async function fetchData(url, callback) {
        try {
            const response = await fetch(url);
            const result = await response.json();
            if (result.success && result.data) {
                callback(result.data);
            } else {
                console.error(`❌ Error fetching ${url}:`, result.message);
            }
        } catch (err) {
            console.error(`⚠️ Fetch failed (${url}):`, err);
        }
    }

    // ✅ METRICS DATA
    fetchData('../handler/dashboard/retrieve-metrics-details.php', (d) => {
        const setText = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value;
        };

        setText('total-sales', `₱${d.total_sales}`);
        setText('total-value', `₱${d.total_value}`);
        setText('total-products', d.total_products);
        setText('total-rental-boxes', d.total_rental_boxes);
        setText('total-expenses', `₱${d.total_expenses}`);
        setText('total-pending-orders', d.total_pending_orders);
        setText('low-stock-items', d.low_stock_items);
        setText('occupied-rental-boxes', d.rented_quantity);
    });

    // ✅ RECENT SALES TABLE
    fetchData('../handler/dashboard/retrieve-recent-sales.php', (sales) => {
        const tbody = document.querySelector('#recent-sales-table tbody');
        if (!tbody) return;
        tbody.innerHTML = sales.length
            ? sales.map(item => `
                <tr>
                    <td>${item.date}</td>
                    <td>${item.customer_name}</td>
                    <td>${item.total_items}</td>
                    <td>₱${item.total_payment}</td>
                </tr>
              `).join('')
            : `<tr><td colspan="4">No recent sales found</td></tr>`;
    });

    // ✅ LOW STOCK ALERT TABLE
    fetchData('../handler/dashboard/retrieve-low-stock-alert.php', (stocks) => {
        const tbody = document.querySelector('#low-stock-alert-table tbody');
        if (!tbody) return;
        tbody.innerHTML = stocks.length
            ? stocks.map(item => `
                <tr>
                    <td>${item.product_name}</td>
                    <td>${item.current_stock}</td>
                    <td>${item.reorder_point}</td>
                </tr>
              `).join('')
            : `<tr><td colspan="3">No low-stock items</td></tr>`;
    });

    // ✅ RENTAL BOX SUMMARY TABLE
    fetchData('../handler/dashboard/retrieve-rental-box-summary.php', (boxes) => {
        const tbody = document.querySelector('#rental-box-summary-table tbody');
        if (!tbody) return;
        tbody.innerHTML = boxes.length
            ? boxes.map(item => `
                <tr>
                    <td>${item.box_number}</td>
                    <td>${item.renter_name}</td>
                    <td>${item.status}</td>
                    <td>${item.date}</td>
                </tr>
              `).join('')
            : `<tr><td colspan="4">No rental box activity</td></tr>`;
    });
});
