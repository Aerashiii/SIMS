document.addEventListener('DOMContentLoaded', function () {
    const addCategoryForm = document.getElementById('add-category-form');
    const toastEl = document.getElementById('toast');

     // Add Category form submit (if present)
    if (addCategoryForm) {
        addCategoryForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(addCategoryForm);

            fetch("../handler/records/category/add-category.php", {
                method: "POST",
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast("✅ " + data.message);
                    setTimeout(() => fetchCategoryData(), 700);
                } else {
                    showToast("❌ " + data.message);
                }
            })
            .catch(err => {
                console.error("Error:", err);
                showToast("⚠️ An error occurred.");
            });
        });
    }

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