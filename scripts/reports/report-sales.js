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
                        <td>${transaction.date}</td>
                        <td>${transaction.user_name}</td>
                        <td>${transaction.transact_id}</td>
                        <td>${transaction.total_items}</td>
                        <td>₱${Number(transaction.total_payment).toLocaleString()}</td>
                        <td>${transaction.customer_name}</td>
                        <td>${transaction.contact_number}</td>
                    `;

                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error("Error fetching sales transactions:", error));
    }

    /*==================| EXPORT TO PDF |==================*/
    document.getElementById("report-sales-pdf-button").addEventListener("click", function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Sales Transaction Report", 14, 20);

        const table = document.getElementById("report-sales-table");
        const rows = table.querySelectorAll("tr");
        const tableData = [];

        for (let i = 1; i < rows.length; i++) {
            const rowData = [];
            const cols = rows[i].querySelectorAll("td");
            cols.forEach(col => rowData.push(col.innerText));
            tableData.push(rowData);
        }

        doc.autoTable({
            head: [[ 'Date of Sale', 'Made By', 'Sales ID', 'Quantity Sold', 'Total Sale Amount', 'Customer Name', 'Contact Number']],
            body: tableData,
            startY: 30,
            styles: { fontSize: 8, cellPadding: 2 },
            headStyles: { fillColor: [22, 160, 133], textColor: 255, fontSize: 9 }
        });

        doc.save("sales_transaction_report.pdf");
    });

    /*==================| EXPORT TO EXCEL |==================*/
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