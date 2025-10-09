document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const supplierTable = document.getElementById('supplier-information-table');
    const editSupplierModalCon = document.querySelector('.edit-supplier-modal-container');
    const editSupplierExitButton = document.getElementById('supplier-edit-exit-button');
    const editSupplierSaveButton = document.getElementById('save-edit-supplier-button');
    const editSupplierCategory = document.getElementById('edit-supplier-product-category');

    const deleteSupplierModal = document.querySelector('.delete-supplier-modal-container');
    const deleteSupplierYesButton = document.querySelector('#delete-supplier-yes-button');
    const cancelDeleteSupplierButton = document.querySelector('#delete-supplier-no-button');

    let currentSupplierId = null;

    const toastEl = document.getElementById("toast");

    // Initialize the page
    fetchOptions("../handler/records/category/retrieve-category.php", editSupplierCategory, "category_id", "category_name");
    fetchSupplierData();
    setupEventListeners();

    // -------------------- Event Listeners --------------------
    function setupEventListeners() {
        editSupplierExitButton.addEventListener('click', () => {
            editSupplierModalCon.style.display = 'none';
            console.log('Edit Supplier modal closed');
        });

        editSupplierSaveButton.addEventListener('click', handleEditSupplierSave);
        deleteSupplierYesButton.addEventListener('click', confirmDeleteSupplier);
        cancelDeleteSupplierButton.addEventListener('click', () => {
            deleteSupplierModal.style.display = 'none';
        });
    }

    // -------------------- Fetch Options --------------------
    function fetchOptions(url, selectElement, valueKey, textKey) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let items = Array.isArray(data) ? data : (data.success && Array.isArray(data.data) ? data.data : []);
                selectElement.innerHTML = "";

                if (items.length === 0) {
                    selectElement.innerHTML = `<option value="">⚠ No records found</option>`;
                    return;
                }

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

    // -------------------- Supplier Fetch --------------------
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

    // -------------------- Populate Table --------------------
    function populateSupplierTable(suppliers) {
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

    // -------------------- Edit Supplier --------------------
    function handleEditSupplier(event) {
        currentSupplierId = event.currentTarget.dataset.id;
        fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${currentSupplierId}`)
            .then(handleResponse)
            .then(supplier => displayEditSupplierDetails(supplier))
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
                showToast("✅ " + data.message);
                editSupplierModalCon.style.display = 'none';
                fetchSupplierData();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error('Error during fetch:', error));
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

        editSupplierModalCon.style.display = 'flex';
    }

    // -------------------- Delete Supplier --------------------
    function handleDeleteSupplier(event) {
        currentSupplierId = event.currentTarget.dataset.id;
        fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${currentSupplierId}`)
            .then(handleResponse)
            .then(supplier => {
                document.querySelector('#delete-supplier-name').textContent = supplier.supplier_name;
                deleteSupplierModal.style.display = 'flex';
            })
            .catch(error => console.error('Error fetching supplier details:', error));
    }

    function confirmDeleteSupplier() {
        if (!currentSupplierId) return;

        fetch('../handler/records/supplier/supplier-delete-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${currentSupplierId}`
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                showToast("✅ Supplier deleted successfully");
                deleteSupplierModal.style.display = 'none';
                fetchSupplierData();
            } else {
                 showToast("❌ " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // -------------------- Helper Functions --------------------
    function handleResponse(response) {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
    }

    function attachSupplierActionListeners() {
        document.querySelectorAll('.supplier-edit-button').forEach(button => {
            button.addEventListener('click', handleEditSupplier);
        });

        document.querySelectorAll('.supplier-delete-button').forEach(button => {
            button.addEventListener('click', handleDeleteSupplier);
        });
    }

    function showToast(message) {
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }
});
