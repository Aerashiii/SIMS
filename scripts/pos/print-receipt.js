//THIS IS print0receipt.js

export function printReceipt(addedProducts, cashReceived, paymentMethod, customerName = 'Guest', customerContact = null) {
    const branchName = sessionStorage.getItem('branch_name') || 'Generals Space Rent';
    const date = new Date().toLocaleString('en-US', {
        weekday: 'short',
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    let total = 0;
    let totalItems = 0;

    let receiptHTML = `
        <div id="receipt-content" style="font-family: monospace; padding: 10px; width: 300px;">
            <h3 style="text-align: center;">${branchName}</h3>
            <p style="text-align: center;">${date}</p>
            <hr>
            <p><strong>Customer:</strong> ${customerName}</p>
            ${customerContact ? `<p><strong>Contact:</strong> ${customerContact}</p>` : ''}
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left;">Qty</th>
                        <th style="text-align:left;">Item</th>
                        <th style="text-align:right;">Price</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>`;

    addedProducts.forEach(product => {
        const lineTotal = product.quantity * product.price;
        total += lineTotal;
        totalItems += product.quantity;

        receiptHTML += `
            <tr>
                <td>${product.quantity}</td>
                <td>${product.name}</td>
                <td style="text-align:right;">${product.price.toFixed(2)}</td>
                <td style="text-align:right;">${lineTotal.toFixed(2)}</td>
            </tr>`;
    });

    const change = cashReceived - total;

    receiptHTML += `
                </tbody>
            </table>
            <hr>
            <p><strong>Total Items:</strong> ${totalItems}</p>
            <p><strong>Subtotal:</strong> ${total.toFixed(2)}</p>
            <p><strong>Cash Received:</strong> ${cashReceived.toFixed(2)}</p>
            <p><strong>Change:</strong> ${change.toFixed(2)}</p>
            <p><strong>Payment Method:</strong> ${paymentMethod}</p>
            <hr>
            <p style="text-align:center;">Thank you for your purchase!</p>
        </div>`;

    const printWindow = window.open('', '','height=600,width=500');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
