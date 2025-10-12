// inventory-view-purchase-order.js
import { printReceipt } from './order-print-receipt.js';

document.addEventListener("DOMContentLoaded", async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get("id");

    const orderDate = document.getElementById("order-date");
    const processedBy = document.getElementById("processed-by");
    const supplierName = document.getElementById("supplier-name");
    const tbody = document.getElementById("purchase-order-inventory-tbody");
    const totalAmount = document.getElementById("purchase-order-total-amount");
    const markCompleteBtn = document.getElementById("mark-as-complete-btn");
    const printBtn = document.getElementById("print-purchase-order-btn");
    const toastEl = document.getElementById('toast');

    let orderProducts = []; // ✅ store loaded products
    let currentOrder = null;

    if (!orderId) {
        alert("No purchase order ID found!");
        return;
    }

    try {
        const response = await fetch(`../handler/inventory/purchase-order/retrieve-specific-order.php?id=${orderId}`);
        const contentType = response.headers.get("content-type");

        if (!contentType || !contentType.includes("application/json")) {
            throw new Error("Invalid JSON response. Check PHP errors in the console.");
        }

        const data = await response.json();

        if (!data.success) {
            alert(data.message || "Failed to load order details.");
            return;
        }

        currentOrder = data.transaction;

        // ✅ Display order info
        orderDate.textContent = new Date(currentOrder.date).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
        processedBy.textContent = currentOrder.processed_by || "N/A";
        supplierName.textContent = currentOrder.supplier_name || "N/A";

        // ✅ Render ordered products
        tbody.innerHTML = "";
        let grandTotal = 0;

        orderProducts = data.products.map(prod => ({
            description: prod.product_name,
            quantity: parseInt(prod.quantity),
            price: parseFloat(prod.price),
            total: parseFloat(prod.total)
        }));

        orderProducts.forEach(prod => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${prod.description}</td>
                <td>${prod.quantity}</td>
                <td>${prod.price.toFixed(2)}</td>
                <td>${prod.total.toFixed(2)}</td>
            `;
            tbody.appendChild(row);
            grandTotal += prod.total;
        });

        totalAmount.textContent = grandTotal.toFixed(2);
    } catch (err) {
        console.error("❌ Error fetching order details:", err);
        alert("Error fetching order details. Check the console for more info.");
    }

    /****** 🖨️ PRINT RECEIPT BUTTON ******/
    printBtn.addEventListener("click", () => {
        if (!currentOrder || orderProducts.length === 0) {
            alert("No order data available to print.");
            return;
        }

        printReceipt({
            products: orderProducts,
            orderDate: orderDate.textContent,
            processedBy: processedBy.textContent,
            supplier: supplierName.textContent,
            total: totalAmount.textContent
        });
    });

    /****** ✅ MARK AS COMPLETE BUTTON ******/
    markCompleteBtn.addEventListener("click", async () => {
        if (!orderId) {
            alert("Order ID not found.");
            return;
        }

        if (!confirm("Are you sure you want to mark this order as complete?")) return;

        try {
            const response = await fetch("../handler/inventory/purchase-order/update-status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `order_id=${orderId}`
            });

            const result = await response.json();

            if (result.success) {
                showToast("✅ " + result.message);
            } else {
                showToast("❌ " + result.message);
            }
        } catch (err) {
            console.error("Error:", err);
            showToast("Error marking order as complete.");
        }
    });

    function showToast(message) {
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }
});
