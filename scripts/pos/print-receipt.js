export function printReceipt(addedProducts, cashReceived, paymentMethod) {
    const branchName = sessionStorage.getItem('branch_name') || 'Unknown Branch';
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
        <div id="receipt-content" style="font-family: monospace; padding: 10px;">
            <h3>${branchName}</h3>
            <p>${date}</p>
            <hr>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Total</th>
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
                <td>${product.price.toFixed(2)}</td>
                <td>${lineTotal.toFixed(2)}</td>
            </tr>`;
    });

    const tax = total * 0.12;
    const totalDue = total + tax;
    const change = cashReceived - totalDue;

    receiptHTML += `
                </tbody>
            </table>
            <hr>
            <p><strong>Items:</strong> ${totalItems}</p>
            <p><strong>Subtotal:</strong> ${total.toFixed(2)}</p>
            <p><strong>Tax (12%):</strong> ${tax.toFixed(2)}</p>
            <p><strong>Total Due:</strong> ${totalDue.toFixed(2)}</p>
            <p><strong>Cash Received:</strong> ${cashReceived.toFixed(2)}</p>
            <p><strong>Change:</strong> ${change.toFixed(2)}</p>
            <p><strong>Payment Method:</strong> ${paymentMethod}</p>
            <hr>
            <p style="text-align:center;">Thank you for your purchase!</p>
        </div>`;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
