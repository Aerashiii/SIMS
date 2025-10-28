export function printReceipt(addedProducts, cashReceived, paymentMethod, userName, customerName = '', customerContact = '') {
    // ✅ Get user name from hidden span (inserted by PHP)
    

    const branchName = "General's Space Rent";
    const branchAddress = "PUROK 20, BLOCK 8, FATIMA GENERAL SANTOS CITY";
    const branchContact = "09757579376";

    const date = new Date().toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    let total = 0;
    let totalItems = 0;
    let itemsHTML = '';

    addedProducts.forEach(product => {
        const lineTotal = product.quantity * product.price;
        total += lineTotal;
        totalItems += product.quantity;

        itemsHTML += `
            <tr>
                <td>${product.quantity}</td>
                <td>${product.name}</td>
                <td>${lineTotal.toFixed(2)}</td>
            </tr>
        `;
    });

    const change = cashReceived - total;

    const receiptHTML = `
        <html>
        <head>
            <title>Receipt</title>
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
                th, td { padding: 2px; }
                .preview-receipt-partition { text-align: center; margin: 5px 0; }
                .preview-receipt-totals-container div {
                    display: flex;
                    justify-content: space-between;
                    margin: 2px 0;
                }
                .customer-information-container div {
                    display: flex;
                    justify-content: space-between;
                    margin: 2px 0;
                }
                .preview-receipt-footer-container p, h3 { text-align: center; font-size: 11px; }
            </style>
        </head>
        <body>
            <div class="receipt-preview-container">
                <h4>${branchName}</h4>
                <div class="store-address-and-contact-container">
                    <p>${branchAddress}</p>                 
                    <p>Contact No. ${branchContact}</p>
                </div>

                <div class="preview-receipt-partition">=======================================</div>
                <div>
                    <label>Cashier:</label>
                    <span>${userName}</span>
                </div>
                <div>
                    <label>Date:</label>
                    <span>${date}</span>
                </div>

                <div class="preview-receipt-partition">=======================================</div>
                <div class="pos-receipt-item-table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Qty.</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>${itemsHTML}</tbody>
                    </table>
                </div>

                <div class="preview-receipt-partition">=======================================</div>
                <div class="preview-receipt-totals-container">
                    <div><label>Total QTY:</label><span>${totalItems}</span></div>
                    <div><label>Amount Due:</label><span>${total.toFixed(2)}</span></div>
                    <div><label>Cash:</label><span>${cashReceived.toFixed(2)}</span></div>
                    <div><label>Change:</label><span>${change.toFixed(2)}</span></div>
                    <div><label>Payment Method:</label><span>${paymentMethod}</span></div>
                </div>

                <div class="preview-receipt-partition">=======================================</div>
                <div class="customer-information-container">
                    <h5>Customer Information: (optional)</h5>
                    <div>
                        <label>Name:</label>
                        <span>${customerName || 'N/A'}</span>
                    </div>
                    <div>
                        <label>Contact Number:</label>
                        <span>${customerContact || 'N/A'}</span>
                    </div>
                </div>

                <div class="preview-receipt-partition">=======================================</div>
                <div class="preview-receipt-footer-container">
                    <p>THIS SERVE AS OFFICIAL RECEIPT</p>
                    <p>BRING THIS RECEIPT INCASE OF EXCHANGE OF MERCHANDISE WITHIN 7 DAYS</p>
                    <p>THANK YOU AND COME AGAIN!</p>
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
