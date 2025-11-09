document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#report-rental-table tbody');
    if (!table) {
        console.error('Table body not found!');
        return;
    }

    fetch('../handler/reports/retrieve-rental-transaction.php')
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';

            if (data.error) {
                console.error(data.error);
                table.innerHTML = `<tr><td colspan="7">Error loading data.</td></tr>`;
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                table.innerHTML = `<tr><td colspan="7">No rental transactions found.</td></tr>`;
                return;
            }

            data.forEach(report => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${report.rental_id}</td>
                    <td>${report.renter_name}</td>
                    <td>${report.rented_quantity}</td>
                    <td>₱${parseFloat(report.payment).toLocaleString()}</td>
                    <td>${report.rental_start_date}</td>
                    <td>${report.rental_end_date}</td>
                    <td>${report.status}</td>
                `;
                table.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Error fetching rental reports:', error);
            table.innerHTML = `<tr><td colspan="7">Error fetching data.</td></tr>`;
        });

    // PDF export
    const pdfBtn = document.getElementById('report-rental-pdf-button');
    if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const tableEl = document.getElementById("report-rental-table");

            doc.setFontSize(18);
            doc.text("Rental Transaction Report", 14, 20);

            const rows = [];
            tableEl.querySelectorAll("tbody tr").forEach(tr => {
                const row = Array.from(tr.children).map(td => td.innerText);
                rows.push(row);
            });

            doc.autoTable({
                head: [['Rental ID', 'Renter Name', 'Quantity', 'Total Fee', 'Date Rented', 'Due Date', 'Status']],
                body: rows,
                startY: 30,
                styles: { fontSize: 8, cellPadding: 2 },
                headStyles: { fillColor: [22, 160, 133], textColor: 255 }
            });

            doc.save("rental_transaction_report.pdf");
        });
    }

    // Excel export
    const excelBtn = document.getElementById('report-rental-excel-button');
    if (excelBtn) {
        excelBtn.addEventListener('click', function() {
            const tableEl = document.getElementById('report-rental-table');
            const ws = XLSX.utils.table_to_sheet(tableEl);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Rental Transactions");
            XLSX.writeFile(wb, "rental_transaction_report.xlsx");
        });
    }
});
