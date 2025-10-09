document.addEventListener("DOMContentLoaded", function () {
    const addSupplierCategory = document.getElementById('add-supplier-product-category');
    const addSupplierForm = document.getElementById("add-supplier-form");
    const toastEl = document.getElementById("toast");

    // Load product categories
    fetchOptions("../handler/records/category/retrieve-category.php", addSupplierCategory, "category_id", "category_name");

    function fetchOptions(url, selectElement, valueKey, textKey) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data.success && Array.isArray(data.data)) {
                    items = data.data;
                }

                selectElement.innerHTML = ""; // clear existing options
                if (items.length === 0) {
                    selectElement.innerHTML = `<option value="">⚠ No records found</option>`;
                    return;
                }
;
                items.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item[valueKey];
                    option.textContent = item[textKey];
                    selectElement.appendChild(option);
                });
            })
            .catch(error => {
                console.error(`Error fetching ${url}:`, error);
                selectElement.innerHTML = `<option value="">⚠ Error loading data</option>`;
            });
    }

    // Handle supplier form submit
    addSupplierForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(addSupplierForm);

        fetch("../handler/records/supplier/add-supplier-handler.php", {
            method: "POST",
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast("✅ " + data.message);
                addSupplierForm.reset();
            } else {
                showToast("❌ " + data.message);
            }
        })
        .catch(err => {
            console.error("Error:", err);
            showToast("⚠️ An error occurred.");
        });
    });

    function showToast(message) {
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }
});
