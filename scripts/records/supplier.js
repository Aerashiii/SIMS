document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const supplierTable = document.getElementById('supplier-information-table');
    const addSupplierModalCon = document.querySelector('.add-supplier-modal-container');
    const addSupplierButton = document.getElementById('add-supplier-button');
    const addSupplierCancelButton = document.getElementById('add-supplier-cancel-button');
    const addSupplierSelectProductCategory = document.getElementById('add-supplier-product-category');
    const addSupplierForm = document.getElementById('add-supplier-form');
    
    const editSupplierModalCon = document.querySelector('.edit-supplier-modal-container');
    const editSupplierExitButton = document.getElementById('supplier-edit-exit-button');
    const editSupplierSaveButton = document.getElementById('save-edit-supplier-button');
    
    const deleteSupplierModal = document.querySelector('.delete-supplier-modal-container');
    const deleteSupplierYesButton = document.querySelector('#delete-supplier-yes-button');
    const cancelDeleteSupplierButton = document.querySelector('#delete-supplier-no-button');

    let currentSupplierId = null;

    // Initialize the page

    fetchSelectCategoryAddSupplier();
    fetchSelectPaymentAddSupplier();
    fetchSupplierData();
    setupEventListeners();
    

    // Set up all event listeners
    function setupEventListeners() {
        // Add Supplier
        addSupplierButton.addEventListener('click', showAddSupplierModal);
        addSupplierCancelButton.addEventListener('click', hideAddSupplierModal);
     

 
        editSupplierSaveButton.addEventListener('click', handleEditSupplierSave);

        // Delete Supplier
        deleteSupplierYesButton.addEventListener('click', confirmDeleteSupplier);
        cancelDeleteSupplierButton.addEventListener('click', hideDeleteSupplierModal);
    }

    // Modal Visibility Functions
    function showAddSupplierModal() {
        addSupplierModalCon.style.display = 'flex';
        console.log('Add Supplier modal shown');
    }

    function hideAddSupplierModal() {
        addSupplierModalCon.style.display = 'none';
    }

    function showEditSupplierModal() {
        editSupplierModalCon.style.display = 'flex';
    }

    function showDeleteSupplierModal() {
        deleteSupplierModal.style.display = 'flex';
    }

    function hideDeleteSupplierModal() {
        deleteSupplierModal.style.display = 'none';
    }

    // Data Fetching Functions
    function fetchSelectCategoryAddSupplier() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(handleResponse)
            .then(data => {
                if (data.length === 0) {
                    console.warn('No category data found.');
                } else {
                    populateSelectCategoryAddSupplier(data);
                    populateSelectCategoryEditSupplier(data);
                }
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function fetchSelectPaymentAddSupplier() {
        // Implement if needed
    }

    function fetchSupplierData() {
        fetch('../handler/records/supplier/retrieve-supplier.php')
            .then(handleResponse)
            .then(data => {
                if (!data.success || data.data.length === 0) {
                    console.warn('No supplier data found.');
                } else {
                    populateSupplierTable(data.data);
                }
            })
            .catch(error => console.error('Error fetching supplier data:', error));
    }

    // Data Population Functions
    function populateSelectCategoryAddSupplier(categories) {
        addSupplierSelectProductCategory.innerHTML = '<option value="">--Select Category--</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.textContent = category.category_name;
            option.value = category.category_id;
            addSupplierSelectProductCategory.appendChild(option);
        });
    }

    function populateSelectCategoryEditSupplier(categories) {
        const editSelect = document.getElementById('edit-supplier-product-category');
        editSelect.innerHTML = '<option value="">--Select Category--</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.textContent = category.category_name;
            option.value = category.category_id;
            editSelect.appendChild(option);
        });
    }

    function populateSupplierTable(suppliers) {
        // Clear existing rows (keeping header)
        while (supplierTable.rows.length > 1) {
            supplierTable.deleteRow(1);
        }

        suppliers.forEach(supplier => {
            const row = supplierTable.insertRow();
            row.innerHTML = `
                <td>${supplier.supplier_name}</td>
                <td>${supplier.contact_person}</td>
                <td>${supplier.contact_number}</td>
                <td>${supplier.address}</td>
                <td>${supplier.supplier_type}</td>
                <td>${supplier.product_category_name || 'N/A'}</td>
                <td>${supplier.payment_terms || 'N/A'}</td>
                <td>${supplier.note}</td>
                <td>
                    <button data-id="${supplier.supplier_id}" class="supplier-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${supplier.supplier_id}" class="supplier-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
        });

        attachSupplierActionListeners();
    }

/****************| EDIT SUPPLIER |**************************** */
editSupplierExitButton.addEventListener('click', function(){
    editSupplierModalCon.style.display = 'none';
    console.log('Edit Supplier modal closed');
});

    function handleEditSupplier(event) {
        currentSupplierId = event.currentTarget.dataset.id;
        fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${currentSupplierId}`)
            .then(handleResponse)
            .then(supplier => displayEditSupplierDetails(supplier))
            .catch(error => console.error('Error fetching supplier details:', error));
    }

    function handleDeleteSupplier(event) {
        currentSupplierId = event.currentTarget.dataset.id;
        fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${currentSupplierId}`)
            .then(handleResponse)
            .then(supplier => displayDeleteSupplierDetails(supplier))
            .catch(error => console.error('Error fetching supplier details:', error));
    }

    function handleEditSupplierSave(event) {
        event.preventDefault();
        
        const supplierDetails = {
            supplier_id: document.getElementById('edit-supplier-id').value,
            supplier_name: document.getElementById('edit-supplier-name').value.trim(),
            contact_person: document.getElementById('edit-supplier-contact-person').value.trim(),
            contact_number: document.getElementById('edit-supplier-contact-number').value.trim(),
            address: document.getElementById('edit-supplier-address').value.trim(),
            supplier_type: document.getElementById('edit-supplier-type').value.trim(),
            product_category_id: document.getElementById('edit-supplier-product-category').value.trim(),
            payment_terms: document.getElementById('edit-supplier-payment-terms').value.trim(),
            note: document.getElementById('edit-supplier-note').value.trim()
        };

        fetch('../handler/records/supplier/supplier-edit-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(supplierDetails),
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                alert('Supplier updated successfully!');
                editSupplierModalCon.style.display = 'none';
                
                fetchSupplierData();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error('Error during fetch:', error));
    }

    // Helper Functions
    function handleResponse(response) {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    }

    function displayEditSupplierDetails(supplier) {
        document.getElementById('edit-supplier-id').value = supplier.supplier_id;
        document.getElementById('edit-supplier-name').value = supplier.supplier_name;
        document.getElementById('edit-supplier-contact-person').value = supplier.contact_person;
        document.getElementById('edit-supplier-contact-number').value = supplier.contact_number;
        document.getElementById('edit-supplier-address').value = supplier.address;
        document.getElementById('edit-supplier-type').value = supplier.supplier_type;
        document.getElementById('edit-supplier-product-category').value = supplier.product_category_id;
        document.getElementById('edit-supplier-payment-terms').value = supplier.payment_terms;
        document.getElementById('edit-supplier-note').value = supplier.note;
        showEditSupplierModal();
    }

    function displayDeleteSupplierDetails(supplier) {
        document.querySelector('#delete-supplier-name').textContent = supplier.supplier_name;
        showDeleteSupplierModal();
    }

    function confirmDeleteSupplier() {
        if (!currentSupplierId) {
            console.error('Supplier ID is not defined.');
            return;
        }

        fetch('../handler/records/supplier/supplier-delete-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${currentSupplierId}`
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                alert(data.success);
                hideDeleteSupplierModal();
                fetchSupplierData();
            } else {
                alert(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function attachSupplierActionListeners() {
        document.querySelectorAll('.supplier-edit-button').forEach(button => {
            button.addEventListener('click', handleEditSupplier);
        });
        
        document.querySelectorAll('.supplier-delete-button').forEach(button => {
            button.addEventListener('click', handleDeleteSupplier);
        });
    }

    /******************| ADD SUPPLIER |**************************** */
    // SUBMISSION OF ADD SUBCATEGORY FORM
    addSupplierForm.addEventListener("submit", function(event) {
        event.preventDefault();
        addSupplier(); // Fixed function name (was createSubategory)
    });

    // Supplier Creation Function
    function addSupplier() {


        const addSupplierName = document.getElementById("add-supplier-name").value.trim();
        const addSupplierContactPerson = document.getElementById("add-supplier-contact-person").value.trim();
        const addSupplierPhoneNumber = document.getElementById("add-supplier-phone-number").value.trim();
        const addSupplierAddress = document.getElementById("add-supplier-address").value.trim();
        const addSupplierType = document.getElementById("add-supplier-type").value.trim();
        const addSupplierProductCategory = document.getElementById("add-supplier-product-category").value.trim();
        const addSupplierPaymentTerms = document.getElementById("add-supplier-payment-terms").value.trim();
        const addSupplierNote = document.getElementById("add-supplier-note").value.trim();

        console.log(addSupplierProductCategory);

    
        
        // Create FormData object to send to the server
        const formData = new FormData();
        formData.append("supplier_name", addSupplierName);
        formData.append("contact_person", addSupplierContactPerson);
        formData.append("phone_number", addSupplierPhoneNumber);
        formData.append("address", addSupplierAddress);
        formData.append("supplier_type", addSupplierType);
        formData.append("product_category_id", addSupplierProductCategory);
        formData.append("payment_terms", addSupplierPaymentTerms);
        formData.append("note", addSupplierNote);

        console.log("FormData:", formData);
        
       

        fetch("../handler/records/supplier/add-supplier-handler.php", {
            method: "POST",
            body: formData,
        })
        .then(async response => {
            const text = await response.text();
            try {
                return JSON.parse(text);
            } catch {
                throw new Error(text || 'Invalid server response');
            }
        })
        .then(data => {
            if (data.success) {
                alert("Supplier created successfully!");
                hideAddSupplierModal();
                addSupplierForm.reset();
                fetchSupplierData();
            } else {
                throw new Error(data.message || "Unknown error occurred");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert(`Error: ${error.message}`);
        });
    }


});