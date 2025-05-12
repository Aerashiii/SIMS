document.addEventListener("DOMContentLoaded", function () {
    fetchSalesTransactions();


function fetchSalesTransactions() {
    fetch('../handler/reports/retrieve-sales-transaction.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector("#report-sales-table tbody");
            tbody.innerHTML = "";

            if (data.error) {
                console.error(data.error);
                return;
            }

            data.forEach((transaction, index) => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${transaction.date}</td>
                    <td>${transaction.transact_ID}</td>
                    <td>${transaction.total_items}</td>
                    <td>₱${transaction.total_payment.toLocaleString()}</td>
                    <td>${transaction.payment_method}</td>
                    <td>${transaction.customer_name}</td>
                    <td>${transaction.contact_number}</td>
                `;

                tbody.appendChild(tr);
            });
        })
        .catch(error => console.error("Error fetching sales transactions:", error));
}

/*===============================| EXPORT SALES TRANSACTION TO PDF |======================================== */
    document.getElementById("report-sales-pdf-button").addEventListener("click", function() {
        // Use the correct jsPDF initialization
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.getElementById("report-sales-table");
        
        // Check if table exists
        if (!table) {
            console.error("Table not found");
            return;
        }
        
        const rows = table.querySelectorAll("tr");

        // Set title for the PDF
        doc.setFontSize(18);
        doc.text("Sales Transaction Report", 14, 20);

        // Generate table content for PDF
        const tableData = [];
        for (let i = 1; i < rows.length; i++) { // Skip the header
            const rowData = [];
            const cols = rows[i].querySelectorAll("td");
            for (let j = 0; j < cols.length; j++) {
                rowData.push(cols[j].innerText);
            }
            tableData.push(rowData);
        }

        // Check if autoTable is available
        if (doc.autoTable) {
            doc.autoTable({
                head: [['No.', 'Date of Sale', 'Sales ID', 'Quantity Sold', 'Total Sale Amount', 'Payment Method', 'Customer Name', 'Contact Number']],
                body: tableData,
                startY: 30,
                styles: {
                    fontSize: 8,
                    cellPadding: 2
                },
                headStyles: {
                    fillColor: [22, 160, 133],
                    textColor: 255,
                    fontSize: 9
                }
            });

            doc.save("sales_transaction_report.pdf");
        } else {
            console.error("autoTable is not available in jsPDF instance");
            alert("PDF export feature is not available. Please try again later.");
        }
    });

/*===============================| EXPORT SALES TRANSACTION TO EXCEL |======================================== */
document.getElementById("report-sales-excel-button").addEventListener("click", function() {
    const table = document.getElementById('report-sales-table');
    const rows = table.getElementsByTagName("tr");

    const tableData = [];
    for (let i = 0; i < rows.length; i++) {
        const rowData = [];
        const cols = rows[i].getElementsByTagName(i === 0 ? "th" : "td");
        for (let j = 0; j < cols.length; j++) {
            rowData.push(cols[j].innerText);
        }
        tableData.push(rowData);
    }

    const ws = XLSX.utils.aoa_to_sheet(tableData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sales Transactions");

    XLSX.writeFile(wb, "sales_transaction_report.xlsx");
});



});