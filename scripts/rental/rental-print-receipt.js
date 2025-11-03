export function printReceipt(rentalBoxes, userName, customerName, customerContact, rentalStartDate, rentalEndDate, totalAmount) {
    const branchName = "General's Space Rent";
    const branchAddress = "PUROK 00, BLOCK 00, GENERAL SANTOS CITY";
    const branchContact = "0999999999";

    const date = new Date().toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    let itemsHTML = '';
    let totalQty = 0;

    rentalBoxes.forEach(box => {
        const lineTotal = box.quantity * box.fee;
        totalQty += box.quantity;
        itemsHTML += `
            <tr>
                <td>${box.number}</td>
                <td>${box.size}</td>
                <td>${box.quantity}</td>
                <td>₱${box.fee.toFixed(2)}</td>
                <td>₱${lineTotal.toFixed(2)}</td>
            </tr>
        `;
    });

    const receiptHTML = `
        <html>
        <head>
            <title>Rental Transaction Receipt</title>
            <style>
                body {
                    font-family: monospace;
                    font-size: 13px;
                    width: 300px;
                    margin: 0 auto;
                    padding: 10px;
                }
                h4, h5, h3, p { margin: 0; padding: 2px 0; text-align: center; }
                table { width: 100%; border-collapse: collapse; text-align: center; }
                th, td { padding: 3px; }
                .receipt-divider { text-align: center; margin: 6px 0; }
                .totals div {
                    display: flex;
                    justify-content: space-between;
                    margin: 2px 0;
                }
                .customer-info div {
                    display: flex;
                    justify-content: space-between;
                    margin: 2px 0;
                }
                .footer p, .footer h3 { text-align: center; font-size: 11px; }
            </style>
        </head>
        <body>
            <div class="receipt-preview-container">
                <h4>${branchName}</h4>
                <div>
                    <p>${branchAddress}</p>                 
                    <p>Contact No. ${branchContact}</p>
                </div>

                <div class="receipt-divider">=======================================</div>
                <div>
                    <label>Processed By:</label>
                    <span>${userName}</span>
                </div>
                <div>
                    <label>Date:</label>
                    <span>${date}</span>
                </div>

                <div class="receipt-divider">=======================================</div>
                <h5>Rental Box Details</h5>
                <table>
                    <thead>
                        <tr>
                            <th>Box #</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>${itemsHTML}</tbody>
                </table>

                <div class="receipt-divider">=======================================</div>
                <div class="totals">
                    <div><label>Total Boxes:</label><span>${totalQty}</span></div>
                    <div><label>Total Amount:</label><span>₱${totalAmount.toFixed(2)}</span></div>
                </div>

                <div class="receipt-divider">=======================================</div>
                <div class="rental-period">
                    <div><label>Rental Start:</label><span>${rentalStartDate}</span></div>
                    <div><label>Rental End:</label><span>${rentalEndDate}</span></div>
                </div>

                <div class="receipt-divider">=======================================</div>
                <div class="customer-info">
                    <h5>Customer Information</h5>
                    <div><label>Name:</label><span>${customerName || 'N/A'}</span></div>
                    <div><label>Contact:</label><span>${customerContact || 'N/A'}</span></div>
                </div>

                <div class="receipt-divider">=======================================</div>
                <div class="footer">
                    <p>THIS SERVES AS OFFICIAL RENTAL RECEIPT</p>
                    <p>PLEASE KEEP THIS RECEIPT FOR VERIFICATION</p>
                    <p>THANK YOU FOR RENTING WITH US!</p>
                    <h3>THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAX.</h3>
                </div>
            </div>
        </body>
        </html>
    `;

    // ✅ Open print window
    const printWindow = window.open('', '', 'height=600,width=500');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
