document.addEventListener('DOMContentLoaded', function () {
    // CATEGORY
    const categoryTable = document.getElementById("category-table");

    // EDIT CATEGORY
    const editCategoryModalCon = document.querySelector('.edit-category-modal-container');
    const editCategoryExitBtn = document.querySelector('.category-edit-exit-button');
    const editCategorySaveButton = document.getElementById('save-edit-category-button');

    // DELETE CATEGORY
    const deleteCategoryModal = document.querySelector('.delete-category-modal-container');
    const deleteCategoryYesButton = document.querySelector('#delete-category-yes-button');
    const cancelDeleteCategoryButton = document.querySelector('#delete-category-no-button');

    // ADD CATEGORY
    const addCategoryModalCon = document.querySelector('.add-category-modal-container');
    const addCategoryForm = document.getElementById('add-category-form');

    // Exit Edit Modal
    editCategoryExitBtn.addEventListener('click', () => {
        editCategoryModalCon.style.display = 'none';
        console.log("Exit button clicked");
    });

    // Event Listeners
    editCategorySaveButton.addEventListener('click', saveEditedCategory);
    deleteCategoryYesButton.addEventListener('click', confirmDeleteCategory);
    cancelDeleteCategoryButton.addEventListener('click', cancelDeleteCategory);

    // Fetch categories on page load
    fetchCategoryData();

    // ADD CATEGORY SUBMIT
    addCategoryForm.addEventListener("submit", function (event) {
        event.preventDefault();
        createCategory();
    });

    function createCategory() {
        const categoryName = document.getElementById('add-category-name').value.trim();
        const categoryStatus = document.getElementById('add-category-status').value.trim();

        if (!categoryName || !categoryStatus) {
            alert("Please fill in all fields.");
            return;
        }

        const formData = new FormData();
        formData.append("category_name", categoryName);
        formData.append("category_status", categoryStatus);

        fetch("../handler/records/category/add-category.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Category created successfully!");
                    addCategoryModalCon.style.display = 'none';
                    location.reload();
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while creating the category.");
            });
    }

    function fetchCategoryData() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    console.warn('No category data found.');
                } else {
                    populateCategoryTable(data);
                }
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function populateCategoryTable(categories) {
        categoryTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

        categories.forEach(category => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${category.category_name}</td>
                <td>${category.date_created}</td>
                <td>${category.status}</td>
                <td>
                    <button data-id="${category.category_id}" class="category-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${category.category_id}" class="category-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            categoryTable.appendChild(row);
        });

        attachCategoryActionListeners();
    }

    function attachCategoryActionListeners() {
        document.querySelectorAll('.category-edit-button').forEach(button =>
            button.addEventListener('click', handleEditCategory)
        );
        document.querySelectorAll('.category-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteCategory)
        );
    }

    function handleEditCategory(event) {
        const categoryId = event.currentTarget.dataset.id;

        fetch(`../handler/records/category/retrieve-category-details.php?id=${categoryId}`)
            .then(response => response.json())
            .then(category => {
                if (category.error) {
                    console.error('Error fetching category details:', category.error);
                    return;
                }

                displayEditCategoryDetails(category);
            })
            .catch(error => console.error('Error fetching category details:', error));
    }

    function displayEditCategoryDetails(category) {
        document.getElementById('edit-category-id').value = category.category_id;
        document.getElementById('edit-category-name').value = category.category_name;
        document.getElementById('edit-category-status').value = category.status;

        editCategoryModalCon.style.display = 'flex';
    }

    function saveEditedCategory() {
        const category_id = document.getElementById('edit-category-id').value;
        const category_name = document.getElementById('edit-category-name').value.trim();
        const status = document.getElementById('edit-category-status').value;

        if (!category_name) {
            alert("Please enter a category name.");
            return;
        }

        const categoryDetails = {
            category_id: category_id,
            category_name: category_name,
            status: status
        };

        fetch('../handler/records/category/category-edit-handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(categoryDetails),
        })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Category saved successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred while saving.');
            });

        editCategoryModalCon.style.display = 'none';
    }

    function handleDeleteCategory(event) {
        categoryId = event.currentTarget.dataset.id;

        fetch(`../handler/records/category/retrieve-category-details.php?id=${categoryId}`)
            .then(response => response.json())
            .then(category => {
                if (category.error) {
                    console.error('Error fetching product details:', category.error);
                    return;
                }
                displayDeleteCategoryDetails(category);
            })
            .catch(error => console.error('Error fetching product details:', error));
    }

    function displayDeleteCategoryDetails(category) {
        deleteCategoryModal.style.display = 'flex';
        document.querySelector('#delete-category-name').textContent = category.category_name;
    }

    function confirmDeleteCategory() {
        if (!categoryId) {
            console.error('Category ID is not defined.');
            return;
        }

        fetch(`../handler/records/category/category-delete-handler.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${categoryId}`
        })
            .then(response => response.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert(data.success);
                        window.location.reload();
                    } else {
                        alert(data.error);
                    }
                } catch (error) {
                    console.error('Response not JSON:', text);
                    alert('Something went wrong');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function cancelDeleteCategory() {
        deleteCategoryModal.style.display = 'none';
    }

    // ====================| VALIDATION: AMOUNT RECEIVED VS SUBTOTAL |====================
    const amountReceivedInput = document.getElementById('amount-received');
    const subTotalInput = document.getElementById('sub-total');
    const saveTransactionButton = document.getElementById('save-transaction-button');

    if (saveTransactionButton) {
        saveTransactionButton.addEventListener('click', function (e) {
            const amountReceived = parseFloat(amountReceivedInput?.value);
            const subTotal = parseFloat(subTotalInput?.value);

            if (isNaN(amountReceived) || isNaN(subTotal)) {
                alert("Please enter valid amount and subtotal.");
                e.preventDefault();
                return;
            }

            if (amountReceived < subTotal) {
                e.preventDefault();
                alert("⚠️ Amount received must be greater than or equal to the subtotal.");
                amountReceivedInput.focus();
            } else {
                console.log("✅ Transaction valid, proceeding...");
                // You can now call your saveTransaction function if applicable
            }
        });
    }
});
