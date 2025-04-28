document.addEventListener('DOMContentLoaded', function(){
    // Fetch rental reports data
    fetch('../../handler/reports/retrieve-rental-transaction.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#report-rental-table tbody');
            tableBody.innerHTML = ''; // clear existing rows

            data.forEach(report => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${report.rental_id}</td>
                    <td>${report.renter_name}</td>
                    <td>${report.item_rented}</td>
                    <td>${report.quantity}</td>
                    <td>₱${report.rental_fee * report.quantity}</td>
                    <td>${report.rental_start_date}</td>
                    <td>${report.rental_end_date}</td>
                    <td>${report.status}</td>
                `;

                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching rental reports:', error);
        });

    /*===============================| EXPORT RENTAL TRANSACTION TO PDF |======================================== */
    document.getElementById("report-rental-pdf-button").addEventListener("click", function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.getElementById("report-rental-table");
        
        if (!table) {
            console.error("Table not found");
            return;
        }
        
        const rows = table.querySelectorAll("tr");

        doc.setFontSize(18);
        doc.text("Rental Transaction Report", 14, 20); // <-- Updated title

        const tableData = [];
        for (let i = 1; i < rows.length; i++) { // Skip header
            const rowData = [];
            const cols = rows[i].querySelectorAll("td");
            for (let j = 0; j < cols.length; j++) {
                rowData.push(cols[j].innerText);
            }
            tableData.push(rowData);
        }

        if (doc.autoTable) {
            doc.autoTable({
                head: [['Rental ID', 'Renter Name', 'Item Rented', 'Quantity', 'Rental Fee', 'Date Rented', 'Due Date', 'Status']], // <-- Corrected headers
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

            doc.save("rental_transaction_report.pdf"); // <-- Corrected filename
        } else {
            console.error("autoTable is not available in jsPDF instance");
            alert("PDF export feature is not available. Please try again later.");
        }
    });

    /*===============================| EXPORT RENTAL TRANSACTION TO EXCEL |======================================== */
    document.getElementById("report-rental-excel-button").addEventListener("click", function() {
        const table = document.getElementById('report-rental-table');
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
        XLSX.utils.book_append_sheet(wb, ws, "Rental Transactions");

        XLSX.writeFile(wb, "rental_transaction_report.xlsx"); // <-- Corrected filename
    });
});
