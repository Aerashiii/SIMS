document.addEventListener("DOMContentLoaded", function() {
    const switchIcon = document.getElementById('switch-metrics-boxes-icon');
    const boxOne = document.querySelector('.metrics-box-container-one');
    const boxTwo = document.querySelector('.metrics-box-container-two');
    
    // Add click event listener
    switchIcon.addEventListener('click', () => {
        // Toggle 'active' class
        boxOne.classList.toggle('active');
        boxTwo.classList.toggle('active');
    });

    // Fetch dashboard metrics
    fetch('../handler/dashboard/retrieve-metrics-details.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('total-sales').textContent = '₱' + data.data.total_sales;
                document.getElementById('total-products').textContent = data.data.total_products;
                document.getElementById('low-stock-items').textContent = data.data.low_stock_items;
                document.getElementById('occupied-rental-boxes').textContent = data.data.rented_quantity;
                document.getElementById('total-expenses').textContent = '₱' + data.data.total_expenses;
                document.getElementById('total-value').textContent = '₱' + data.data.total_value;
                document.getElementById('total-pending-orders').textContent = data.data.total_pending_orders;
                document.getElementById('total-rental-boxes').textContent = data.data.total_rental_boxes;
                
                if (data.errors && data.errors.length > 0) {
                    console.warn('Dashboard metrics partial errors:', data.errors);
                }
            } else {
                console.error('Failed to load dashboard metrics:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching dashboard metrics:', error);
        });

    // Fetch recent sales
    fetch('../handler/dashboard/retrieve-recent-sales.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('recent-sales-table').querySelector('tbody');
            tbody.innerHTML = ''; // Clear previous rows
            if (data.success) {
                data.data.forEach(item => {
                    const row = document.createElement('tr'); 
                    row.innerHTML = `
                        <td>${item.date}</td>
                        <td>${item.customer_name}</td>
                        <td>${item.total_items}</td>
                        <td>₱${item.total_payment}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error fetching recent sales:', error));

    // Fetch low stock alerts
    fetch('../handler/dashboard/retrieve-low-stock-alert.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#low-stock-alert-table tbody');
            tbody.innerHTML = ''; // Clear previous rows
            if (data.success) {
                data.data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_name}</td>
                        <td>${item.current_stock}</td>
                        <td>${item.reorder_point}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error fetching low stock alerts:', error));

    // Fetch rental box summary
    fetch('../handler/dashboard/retrieve-rental-box-summary.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#rental-box-summary-table tbody');
            tbody.innerHTML = ''; // Clear previous rows
            if (data.success) {
                data.data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.box_number}</td>
                        <td>${item.renter_name}</td>
                        <td>${item.status}</td>
                        <td>${item.date}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error fetching rental box summary:', error));
});
