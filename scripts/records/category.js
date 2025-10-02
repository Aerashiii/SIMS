document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const categoryTable = document.getElementById("category-table");
    const categoryTableBody = categoryTable.querySelector('tbody');
   

    // EDIT CATEGORY
    const editModal = document.getElementById("edit-category-modal-container");
    const editCategorySaveButton = document.getElementById("save-edit-category-button");
    const editCategoryExitButton = document.querySelector(".category-edit-exit-button"); // matches HTML now

    // DELETE
    const deleteModal = document.getElementById("delete-category-modal-container");
    const deleteCategoryName = document.getElementById('delete-category-name');
    const deleteCategoryYesButton = document.getElementById('delete-category-yes-button');
    const cancelDeleteCategoryButton = document.getElementById('delete-category-no-button');

    // state
    let categoryIdToDelete = null;

    // Load categories on page load
    fetchCategoryData();

   

    // Fetch category data
    function fetchCategoryData() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                // Expect { success: true, data: [...] }
                if (!data.success) {
                    console.warn('retrieve-category returned success=false', data);
                    categoryTableBody.innerHTML = '<tr><td colspan="4">No categories found.</td></tr>';
                    return;
                }
                if (!Array.isArray(data.data) || data.data.length === 0) {
                    categoryTableBody.innerHTML = '<tr><td colspan="4">No categories found.</td></tr>';
                } else {
                    populateCategoryTable(data.data);
                }
            })
            .catch(error => {
                console.error('Error fetching category data:', error);
                categoryTableBody.innerHTML = '<tr><td colspan="4">Error loading categories.</td></tr>';
            });
    }

    // Populate category table
    function populateCategoryTable(categories) {
        categoryTableBody.innerHTML = ''; // clear tbody

        categories.forEach(category => {
            const tr = document.createElement('tr');

            // Ensure fields exist; fallbacks to empty strings
            const name = escapeHtml(category.category_name || '');
            const created = escapeHtml(category.date_created || '');
            const status = escapeHtml(category.status || '');

            tr.innerHTML = `
                <td>${name}</td>
                <td>${created}</td>
                <td>${status}</td>
                <td>
                    <button data-id="${category.category_id}" class="category-edit-button" title="Edit">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${category.category_id}" class="category-delete-button" title="Delete">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;

            categoryTableBody.appendChild(tr);
        });

        attachCategoryActionListeners();
    }

    // attach listeners to the action buttons
    function attachCategoryActionListeners() {
        document.querySelectorAll('.category-edit-button').forEach(button =>
            button.addEventListener('click', handleEditCategory)
        );
        document.querySelectorAll('.category-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteCategory)
        );
    }

    // helper: escape html
    function escapeHtml(unsafe) {
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    /** EDIT */
    function handleEditCategory(event) {
        const id = event.currentTarget.dataset.id;
        if (!id) return;
        fetch(`../handler/records/category/retrieve-category-details.php?id=${encodeURIComponent(id)}`)
            .then(res => {
                if (!res.ok) throw new Error('Failed to fetch details');
                return res.json();
            })
            .then(payload => {
                if (payload.error || !payload.category_id) {
                    console.error('Bad payload from retrieve-category-details', payload);
                    alert('Failed to load category details.');
                    return;
                }
                displayEditCategoryDetails(payload);
            })
            .catch(err => {
                console.error('Error fetching category details:', err);
            });
    }

    function displayEditCategoryDetails(category) {
        document.getElementById('edit-category-id').value = category.category_id;
        document.getElementById('edit-category-name').value = category.category_name || '';
        document.getElementById('edit-category-status').value = category.status || 'active';
        editModal.style.display = 'flex';
    }

    // Save edits
    editCategorySaveButton.addEventListener('click', function (event) {
        event.preventDefault();
        const payload = {
            category_id: document.getElementById('edit-category-id').value,
            category_name: document.getElementById('edit-category-name').value.trim(),
            status: document.getElementById('edit-category-status').value
        };

        fetch('../handler/records/category/category-edit-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
        .then(res => {
            if (!res.ok) return res.json().then(j => Promise.reject(j));
            return res.json();
        })
        .then(data => {
            if (data.success) {
                showToast('✅ Category updated');
                editModal.style.display = 'none';
                fetchCategoryData();
            } else {
                alert(data.message || 'Failed to update');
            }
        })
        .catch(err => {
            console.error('Error updating category:', err);
            alert('Error updating category');
        });
    });

    // Close edit modal
    editCategoryExitButton.addEventListener('click', function () {
        editModal.style.display = 'none';
    });

    /** DELETE */
    function handleDeleteCategory(event) {
        const id = event.currentTarget.dataset.id;
        if (!id) return;
        // fetch details so we can show name
        fetch(`../handler/records/category/retrieve-category-details.php?id=${encodeURIComponent(id)}`)
            .then(res => {
                if (!res.ok) throw new Error('Failed to fetch details');
                return res.json();
            })
            .then(payload => {
                if (payload.error || !payload.category_id) {
                    console.error('Bad payload from retrieve-category-details', payload);
                    alert('Failed to load category details.');
                    return;
                }
                categoryIdToDelete = payload.category_id;
                deleteCategoryName.textContent = payload.category_name || '';
                deleteModal.style.display = 'flex';
            })
            .catch(err => {
                console.error('Error fetching category details:', err);
            });
    }

    // Confirm delete
    deleteCategoryYesButton.addEventListener('click', function () {
        if (!categoryIdToDelete) {
            alert('No category selected');
            return;
        }

        const formBody = new URLSearchParams();
        formBody.append('id', categoryIdToDelete);

        fetch('../handler/records/category/category-delete-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formBody.toString()
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('✅ Category deleted');
                deleteModal.style.display = 'none';
                categoryIdToDelete = null;
                fetchCategoryData();
            } else {
                alert(data.error || 'Failed to delete');
            }
        })
        .catch(err => {
            console.error('Error deleting category:', err);
            alert('Error deleting category');
        });
    });

    // Cancel delete
    cancelDeleteCategoryButton.addEventListener('click', function () {
        deleteModal.style.display = 'none';
        categoryIdToDelete = null;
    });

    // close modals when clicking outside (optional UX)
    window.addEventListener('click', function(e) {
        if (e.target === editModal) editModal.style.display = 'none';
        if (e.target === deleteModal) deleteModal.style.display = 'none';
    });
});
