export function printReceipt(addedBoxes, payment, customerName , customerContact , rentalStart, rentalEnd) {
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
            <p><strong>Rental Duration:</strong></p>
            <p>From: ${rentalStart}</p>
            <p>To: ${rentalEnd}</p>
            <hr>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left;">Qty</th>
                        <th style="text-align:left;">Box</th>
                        <th style="text-align:right;">Price</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>`;

    addedBoxes.forEach(box => {
        const lineTotal = box.quantity * box.price;
        total += lineTotal;
        totalItems += box.quantity;

        receiptHTML += `
            <tr>
                <td>${box.quantity}</td>
                <td>${box.number}<br><small>${box.size}</small></td>
                <td style="text-align:right;">${box.price.toFixed(2)}</td>
                <td style="text-align:right;">${lineTotal.toFixed(2)}</td>
            </tr>`;
    });

    receiptHTML += `
                </tbody>
            </table>
            <hr>
            <p><strong>Total Boxes:</strong> ${totalItems}</p>
            <p><strong>Total Payment:</strong> ₱${payment}</p>
            <p><strong>Payment Method:</strong> Cash</p>
            <hr>
            <p style="text-align:center;">Thank you for renting with us!</p>
        </div>`;

    const printWindow = window.open('', '', 'height=600,width=500');
    printWindow.document.write(receiptHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
