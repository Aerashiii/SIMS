document.addEventListener('DOMContentLoaded', function () {
    let subcategoryId = null;

    //FOR EDITING SUBCATEGORY
    const editSubcategoryModalCon = document.querySelector('.edit-subcategory-modal-container');
    const editSubcategoryExitButton = document.getElementById('subcategory-edit-exit-button');
    const editSubcategorySaveButton = document.getElementById('save-edit-subcategory-button');
    const editSubcategorySelectCategory = document.getElementById('edit-subcategory-select-category');

    // FOR DELETING SUBCATEGORY
    const deleteSubcategoryModal = document.querySelector('.delete-subcategory-modal-container');
    const deleteSubcategoryYesButton = document.getElementById('delete-subcategory-yes-button');
    const cancelDeleteSubcategoryButton = document.getElementById('delete-subcategory-no-button');
   

    // FOR ADDING SUBCATEGORY
    const addSubcategoryButton = document.getElementById('add-subcategory-button');
    const addSubcategoryModalCon = document.querySelector('.add-subcategory-modal-container');
    const addSubcategoryCancelButton = document.querySelector('.add-subcategory-cancel-button');
    const addSubcategorySelectCategory = document.getElementById('add-subcategory-select-category');
    const addSubcategoryForm = document.getElementById('add-subcategory-form');

    const SelectCategoryOnSubcategoryTable = document.getElementById('subcategory-select-category');

    fetchCategoryDataForSelectCategory();
    fetchSubcategoryData();
    fetchCategoryDataForSubcategory();
  

    // Event Listeners
    editSubcategorySaveButton.addEventListener('click', saveEditSubcategoryDetails);
    editSubcategoryExitButton.addEventListener('click', closeEditSubcategoryModal);
    addSubcategoryCancelButton.addEventListener('click', closeAddSubcategoryModal);
    cancelDeleteSubcategoryButton.addEventListener('click', closeDeleteSubcategoryModal);
    deleteSubcategoryYesButton.addEventListener('click', confirmDeleteSubcategory);

    addSubcategoryForm.addEventListener("submit", function (event) {
        event.preventDefault();
        createSubcategory();
    });

    SelectCategoryOnSubcategoryTable.addEventListener('change', function () {
        fetchSubcategoryData(this.value);
    });

    // FETCH CATEGORY FOR ADD & EDIT
    function fetchCategoryDataForSubcategory() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(res => res.json())
            .then(data => populateSelectCategory(data))
            .catch(err => console.error('Error fetching category data:', err));
    }

  

    function fetchCategoryDataForSelectCategory() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(res => res.json())
            .then(data => populateSelectCategoryOnSubcategoryTable(data))
            .catch(err => console.error('Error fetching category data:', err));
    }

    function populateSelectCategory(categories) {
        addSubcategorySelectCategory.innerHTML = '<option value="">-select category-</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.category_id;
            option.textContent = category.category_name;
            addSubcategorySelectCategory.appendChild(option);
        });
    }

    function populateSelectCategoryOnSubcategoryTable(categories) {
        SelectCategoryOnSubcategoryTable.innerHTML = '<option value="">All Categories</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.category_id;
            option.textContent = category.category_name;
            SelectCategoryOnSubcategoryTable.appendChild(option);
        });
    }

    // 
     // ✅ Fetch categories for editing subcategory select category
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
            editSubcategorySelectCategory.appendChild(option);
        });
    }

    function closeAddSubcategoryModal() {
        console.log("Add subcategory modal closed");
        addSubcategoryModalCon.style.display = 'none';
        window.location.reload();
    }

    function createSubcategory() {
        const categoryId = addSubcategorySelectCategory.value.trim();
        const subcategoryName = document.getElementById("add-subcategory-name").value.trim();
        const subcategoryStatus = document.getElementById("add-subcategory-status").value.trim();

        if (!categoryId || !subcategoryName) {
            alert("Please fill in all fields.");
            return;
        }

        const formData = new FormData();
        formData.append("category_id", categoryId);
        formData.append("subcategory_name", subcategoryName);
        formData.append("subcategory_status", subcategoryStatus);

        fetch("../handler/records/category/add-subcategory.php", {
            method: "POST",
            body: formData,
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Subcategory created!");
                    fetchSubcategoryData();
                } else {
                    alert(data.message || "Error occurred.");
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert("Error occurred while creating subcategory.");
            });
    }

    function fetchSubcategoryData(categoryId = null) {
        const url = categoryId
            ? `../handler/records/category/retrieve-subcategory.php?category_id=${categoryId}`
            : '../handler/records/category/retrieve-subcategory.php';

        fetch(url)
            .then(res => res.json())
            .then(data => populateSubcategoryTable(data))
            .catch(err => console.error('Error fetching subcategories:', err));
    }

    function populateSubcategoryTable(subcategories) {
        const subcategoryTable = document.getElementById('subcategory-table');
        subcategoryTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

        subcategories.forEach(sub => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sub.category_name}</td>
                <td>${sub.subcategory_name}</td>
                <td>${sub.date_created}</td>
                <td>${sub.status}</td>
                <td>
                    <button data-id="${sub.subcategory_id}" class="subcategory-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${sub.subcategory_id}" class="subcategory-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            subcategoryTable.appendChild(row);
        });

        attachSubcategoryActionListeners();
    }

    function attachSubcategoryActionListeners() {
        document.querySelectorAll('.subcategory-edit-button').forEach(btn =>
            btn.addEventListener('click', handleEditSubcategory)
        );
        document.querySelectorAll('.subcategory-delete-button').forEach(btn =>
            btn.addEventListener('click', handleDeleteSubcategory)
        );
    }

    function handleEditSubcategory(event) {
        const id = event.currentTarget.dataset.id;
        fetch(`../handler/records/category/retrieve-subcategory-details.php?id=${id}`)
            .then(res => res.json())
            .then(sub => {
                if (sub.error) throw new Error(sub.error);
                document.getElementById('edit-subcategory-id').value = sub.subcategory_id;
                document.getElementById('edit-subcategory-name').value = sub.subcategory_name;
                document.getElementById('edit-subcategory-status').value = sub.status;
                document.getElementById('edit-subcategory-select-category').value = sub.category_id;
                editSubcategoryModalCon.style.display = 'flex';
            })
            .catch(err => console.error('Edit error:', err));
    }

    function saveEditSubcategoryDetails() {
        const data = {
            subcategory_id: document.getElementById('edit-subcategory-id').value,
            category_id: document.getElementById('edit-subcategory-select-category').value,
            subcategory_name: document.getElementById('edit-subcategory-name').value.trim(),
            status: document.getElementById('edit-subcategory-status').value.trim(),
        };

        fetch('../handler/records/category/subcategory-edit-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    alert('Subcategory updated!');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(err => {
                console.error('Save error:', err);
                alert('Error updating subcategory.');
            });
    }

    function closeEditSubcategoryModal() {
        editSubcategoryModalCon.style.display = 'none';
    }

    function handleDeleteSubcategory(event) {
        subcategoryId = event.currentTarget.dataset.id;
        fetch(`../handler/records/category/retrieve-subcategory-details.php?id=${subcategoryId}`)
            .then(res => res.json())
            .then(sub => {
                if (sub.error) throw new Error(sub.error);
                document.querySelector('#delete-subcategory-name').textContent = sub.subcategory_name;
                deleteSubcategoryModal.style.display = 'flex';
            })
            .catch(err => console.error('Delete error:', err));
    }

    function confirmDeleteSubcategory() {
        if (!subcategoryId) {
            alert("Subcategory ID missing.");
            return;
        }

        fetch('../handler/records/category/subcategory-delete-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${subcategoryId}`
        })
            .then(res => res.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert(data.success);
                        window.location.reload();
                    } else {
                        alert(data.error);
                    }
                } catch {
                    console.error('Delete response error:', text);
                    alert('Error during deletion.');
                }
            })
            .catch(err => console.error('Delete error:', err));
    }

    function closeDeleteSubcategoryModal() {
        deleteSubcategoryModal.style.display = 'none';
    }
});
