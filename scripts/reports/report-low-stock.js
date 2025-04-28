document.addEventListener('DOMContentLoaded', function () {

    const lowStockProductListTable  = document.getElementById('report-low-stock-inventory-table').querySelector('tbody');
    const lowStockSelectCategory = document.getElementById('report-select-low-stock-product-by-category');

    // Initial data fetch
    fetchCategoryDataForSelectCategory();
    fetchProductData();

// Add global state for current filters
let lowStockCurrentSearchQuery = '';
let lowStockCurrentSelectedCategory = '';
// Fetch products (all or filtered)
function fetchProductData(query = '', categoryId = '') {
    const formData = new URLSearchParams();
    formData.append('query', query);
    formData.append('category_id', categoryId);

    fetch('../../handler/inventory/low-stock-product/retrieve-low-stock-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateProductTable(data.data);
        } else {
            lowStockProductListTable.innerHTML = '<tr><td colspan="12">No products found</td></tr>';
        }
    })
    .catch(err => console.error('Failed to load products:', err));
}

    function populateProductTable(products) {
        lowStockProductListTable.innerHTML = '';

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                    <td>${product.barcode}</td>
                   <td>${product.product_name}</td>
                   <td>${product.category_name}</td>
                   <td>${product.quantity}</td>
                   <td>${product.reorder_point}</td>
                   <td>₱ ${product.original_price}</td>
                   <td>₱ ${product.selling_price}</td>
                    <td>₱ ${product.selling_price * product.quantity}</td>
                   <td><img src="../../assets/images/icons/crisis.png"> Low Stock</td>
              
            `;
            lowStockProductListTable.appendChild(row);
        });

        attachProductActionListeners();
    }

    function attachProductActionListeners() {
        document.querySelectorAll('.product-edit-button').forEach(button =>
            button.addEventListener('click', handleEditProduct)
        );
        document.querySelectorAll('.product-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteProduct)
        );
    }

    function fetchCategoryDataForSelectCategory() {
        fetch('../../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    console.warn('No category data found.');
                } else {
                    populateSelectCategoryOnSubcategoryTable(data);
                }
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function populateSelectCategoryOnSubcategoryTable(categories) {
        lowStockSelectCategory.innerHTML = ''; // Clear previous options
        const defaultOption = document.createElement('option');
        defaultOption.text = 'All Categories';
        defaultOption.value = '';
        lowStockSelectCategory.appendChild(defaultOption);

        categories.forEach(category => {
            const option = document.createElement('option');
            option.text = category.category_name;
            option.value = category.category_id;
            lowStockSelectCategory.appendChild(option);
        });
    }


/****************| FOR SEARCHING PRODUCT ON ONHAND PRODUCT TABLE |********************* */
// Update category filter
lowStockSelectCategory.addEventListener('change', function () {
    lowStockCurrentSelectedCategory = this.value;
    fetchProductData(lowStockCurrentSearchQuery, lowStockCurrentSelectedCategory);
});

/*===============================| FOR EXPORTING PRODUCT TO PDF AND EXCEL |======================================== */

// Ensure that the jsPDF and AutoTable libraries are loaded first
document.getElementById("report-inventory-low-stock-pdf-button").addEventListener("click", function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const table = document.getElementById("report-low-stock-inventory-table");
    const rows = table.getElementsByTagName("tr");

    // Set title for the PDF
    doc.setFontSize(10);
    doc.text("Low Stock Inventory List", 14, 20);

    // Generate table content for PDF
    const tableData = [];
    for (let i = 1; i < rows.length; i++) { // Skipping the header row
        const rowData = [];
        const cols = rows[i].getElementsByTagName("td");
        for (let j = 0; j < cols.length; j++) {
            rowData.push(cols[j].innerText);
        }
        tableData.push(rowData);
    }

    // Ensure autoTable method exists
    if (doc.autoTable) {
        doc.autoTable({
            head: [['Barcode', 'Product Name', 'Category', 'Stock Quantity', 'Reorder Point', 'Cost Price', 'Selling Price', 'Total Stock Value']],
            body: tableData,
            startY: 30, // Start drawing the table after the title
            styles: {
                fontSize: 6,
                cellPadding: 2
            },
            headStyles: {
                fillColor: [22, 160, 133],
                textColor: 255,
                fontSize: 9
            }
        });

        // Save the generated PDF
        doc.save("low-stock_inventory_report.pdf");
    } else {
        console.error("autoTable is not available in jsPDF instance");
    }
});


// Function to export the table data to Excel
document.getElementById("report-inventory-low-stock-excel-button").addEventListener("click", function() {
    const table = document.getElementById("report-low-stock-inventory-table");
    const rows = table.getElementsByTagName("tr");

    // Prepare data for Excel
    const tableData = [];
    for (let i = 0; i < rows.length; i++) {
        const rowData = [];
        const cols = rows[i].getElementsByTagName(i === 0 ? "th" : "td"); // For header and body rows
        for (let j = 0; j < cols.length; j++) {
            rowData.push(cols[j].innerText);
        }
        tableData.push(rowData);
    }

    // Create a workbook and add the table data to it
    const ws = XLSX.utils.aoa_to_sheet(tableData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "On Hand Inventory");

    // Export to Excel file
    XLSX.writeFile(wb, "low_stock_inventory_report.xlsx");
});








});
