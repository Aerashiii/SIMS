// purchase-order.js
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#purchase-order-inventory-table tbody");
    const searchInput = document.getElementById("inventory-purchase-order-search-input");
    const searchButton = document.getElementById("inventory-purchase-order-search-submit-button");

    // ✅ Load all transactions on page load
    fetchTransactions();

    // ✅ Search button click
    searchButton.addEventListener("click", () => {
        fetchTransactions(searchInput.value.trim());
    });

    // ✅ Press Enter to search
    searchInput.addEventListener("keyup", (e) => {
        if (e.key === "Enter") {
            fetchTransactions(searchInput.value.trim());
        }
    });

    // ✅ Fetch transactions from backend
    async function fetchTransactions(searchTerm = "") {
        const formData = new FormData();
        formData.append("search", searchTerm);

        try {
            const response = await fetch("../handler/inventory/purchase-order/retrieve-purchase-transaction.php", {
                method: "POST",
                body: formData,
            });

            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Server did not return JSON. Check PHP for errors.");
            }

            const data = await response.json();

            if (data.success && Array.isArray(data.data)) {
                renderTable(data.data);
            } else {
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;">${data.message || "No transactions found"}</td></tr>`;
            }
        } catch (error) {
            console.error("❌ Fetch error:", error);
            tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Error loading transactions</td></tr>`;
        }
    }

    // ✅ Render transaction table
    function renderTable(transactions) {
        tableBody.innerHTML = "";

        transactions.forEach((t) => {
            const date = new Date(t.date);
            const formattedDate = date.toLocaleDateString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric"
            });

            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${t.id}</td>
                <td>${t.username || t.name || "N/A"}</td>
                <td>${t.total_product}</td>
                <td>
                    <span class="status-badge ${t.status ? t.status.toLowerCase() : ""}">
                        ${t.status || "N/A"}
                    </span>
                </td>
                <td>${formattedDate}</td>
                <td>
                    <button class="view-transaction-btn" data-id="${t.id}">View</button>
                </td>
            `;

            tableBody.appendChild(row);
        });

        // ✅ View button click
        document.querySelectorAll(".view-transaction-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = btn.dataset.id;
                window.location.href = `inventory-view-purchase-order.php?id=${id}`;
            });
        });
    }
});
