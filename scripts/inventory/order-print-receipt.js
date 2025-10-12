// order-print-receipt.js
export function printReceipt({ products, orderDate, processedBy, supplier, total }) {
    const branchName = sessionStorage.getItem('branch_name') || 'Generals Space Rent';

    let receiptHTML = `
        <div style="font-family: monospace; padding: 10px; width: 320px;">
            <h2 style="text-align:center;">${branchName}</h2>
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
            <p style="text-align:center;">Thank you!</p>
        </div>
    `;

    const printWindow = window.open('', '', 'height=700,width=500');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
