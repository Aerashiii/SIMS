document.addEventListener('DOMContentLoaded', function () {
   const addSubcategoryForm = document.getElementById('add-subcategory-form');
    const toastEl = document.getElementById('toast');
    const addSubcategorySelectCategory = document.getElementById('add-subcategory-select-category');

    // ✅ Fetch categories
    fetch('../handler/records/category/retrieve-category.php')
    .then(res => res.json())
    .then(data => {
        console.log("Categories fetched:", data); // debug
        if (data.success && Array.isArray(data.data)) {
            populateSelectCategory(data.data); // 👈 use data.data
        } else {
            console.error("Error:", data.message);
            showToast("⚠️ " + (data.message || "Failed to load categories"));
        }
    })
    .catch(err => {
        console.error('Error fetching category data:', err);
        showToast("⚠️ Could not load categories.");
    });

    function populateSelectCategory(categories) {
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.category_id;
            option.textContent = category.category_name;
            addSubcategorySelectCategory.appendChild(option);
        });
    }

    // ✅ Handle form submit
    addSubcategoryForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(addSubcategoryForm);

        fetch("../handler/records/category/add-subcategory.php", {
            method: "POST",
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast("✅ " + data.message);
                addSubcategoryForm.reset(); // clear form
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
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }

    // ✅ Cancel button
    document.getElementById('add-subcategory-cancel-button').addEventListener('click', () => {
        window.location.href = "records-subcategory.php";
    });
});