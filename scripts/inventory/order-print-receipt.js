// order-print-receipt.js
export function printReceipt({ products, orderDate, processedBy, supplier, total }) {
    const branchName = sessionStorage.getItem('branch_name') || 'Generals Space Rent';

    const branchAddress = "PUROK 00, BLOCK 00,  GENERAL SANTOS CITY";
    const branchContact = "0999999999";

    let receiptHTML = `
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
                    h4, h5, h3{ margin: 0; padding: 2px 0; text-align: center; }
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
        <div style="font-family: monospace; padding: 10px; width: 320px;">
            <h2 style="text-align:center;">${branchName}</h2>
            <div class="store-address-and-contact-container">
                <p>${branchAddress}</p>                 
                <p>Contact No. ${branchContact}</p>
            </div>
            <div class="preview-receipt-partition">=======================================</div>
            <p style="text-align:center;">Purchase Order Receipt</p>
            <p><strong>Date:</strong> ${orderDate}</p>
            <p><strong>Processed By:</strong> ${processedBy}</p>
            <p><strong>Supplier:</strong> ${supplier}</p>
            <hr>
            <table style="width:100%; font-size:14px;">
                <thead>
                    <tr>
                        <th style="text-align:left;">Qty</th>
                        <th style="text-align:left;">Item</th>
                        <th style="text-align:right;">Price</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>`;

    products.forEach(p => {
        receiptHTML += `
            <tr>
                <td>${p.quantity}</td>
                <td>${p.description}</td>
                <td style="text-align:right;">${p.price.toFixed(2)}</td>
                <td style="text-align:right;">${p.total.toFixed(2)}</td>
            </tr>`;
    });

    receiptHTML += `
                </tbody>
            </table>
            <hr>
            <p style="text-align:right;"><strong>Grand Total:</strong> ₱${parseFloat(total).toFixed(2)}</p>
            <hr>
          
        </div>
        <div class="preview-receipt-partition">=======================================</div>
                <div class="preview-receipt-footer-container">
                    <p>THIS SERVE AS OFFICIAL RECEIPT</p>
                    <p>BRING THIS RECEIPT INCASE OF EXCHANGE OF MERCHANDISE WITHIN 7 DAYS</p>
                    <p>THANK YOU AND COME AGAIN!</p>
                    <h3>THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAX.</h3>
        </div>
          <p style="text-align:center;">Thank you!</p>
    `;

    const printWindow = window.open('', '', 'height=700,width=500');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
