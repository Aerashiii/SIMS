document.addEventListener('DOMContentLoaded', function(){
    // FOR ADDING SUPPLIER
   const addSupplierModalCon = document.querySelector('.add-supplier-modal-container');
   const addSupplierButton = document.getElementById('add-supplier-button');
   const addSupplierCancelButton = document.getElementById('add-supplier-cancel-button');
   const addSupplierSelectProductCategory = document.getElementById('add-supplier-product-category');
   const addSupplierSelectPaymentTerm = document.getElementById('add-supplier-payment-terms');
   const addSupplierForm = document.getElementById('add-supplier-form');

   // FOR DISPLAYING CATEGORY
   const supplierTable =document.getElementById('supplier-information-table');

   // FOR EDITING SUPPLIER
   const editSupplierModalCon = document.querySelector('.edit-supplier-modal-container');
   const editSupplierExitButton = document.getElementById('supplier-edit-exit-button');
   const editSupplierSaveButton = document.getElementById('save-edit-supplier-button');


   // FOR DISPLAYING ADD SUPPLIER FORM
   addSupplierButton.addEventListener('click', function(){
        addSupplierModalCon.style.display = 'flex';
       
   })
   // FOR HIDING ADD SUPPLIER FORM
   addSupplierCancelButton.addEventListener('click', function(){
    addSupplierModalCon.style.display = 'none';
   })



    /***| RETRIEVE CATEGORY FOR ADD SUPPLIER SELECT CATEGORY |* */
    fetchSelectCategoryAddSupplier() ;
    fetchSelectPaymentAddSupplier();
    fetchSupplierData() ;
     // DISPLAY CATEGORY
     function fetchSelectCategoryAddSupplier() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
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
    
        // Populate select category for adding product
        function populateSelectCategoryAddSupplier(categories) {
            categories.forEach(category => {
                const categoryOption = document.createElement('option');
                categoryOption.innerHTML = category.category_name;
                categoryOption.value = category.category_id;
                addSupplierSelectProductCategory.appendChild(categoryOption);
            });
        }
        function populateSelectCategoryEditSupplier(categories) {
            const editSupplierProducCategory = document.getElementById('edit-supplier-product-category');
            categories.forEach(category => {
                const categoryOption = document.createElement('option');
                categoryOption.innerHTML = category.category_name;
                categoryOption.value = category.category_id;
                editSupplierProducCategory.appendChild(categoryOption);
            });
        }
// RETRIEVE PAYMENT TYPE
        function fetchSelectPaymentAddSupplier() {
            fetch('../handler/records/supplier/retrieve-payment.php')
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        console.warn('No Payment data found.');
                    } else {
                        populateSelectPaymentAddSupplier(data);
                        populateSelectPaymenteEditSupplier(data);
                    }
                })
                .catch(error => console.error('Error fetching Payment data:', error));
            }
        
            // Populate select category for adding product
            function populateSelectPaymentAddSupplier(payments) {
                payments.forEach(payment => {
                    const paymentOption = document.createElement('option');
                    paymentOption.innerHTML = payment.payment_type;
                    paymentOption.value = payment.payment_id;
                    addSupplierSelectPaymentTerm.appendChild(paymentOption);
                });
            }
            // Populate select category for adding product
            function populateSelectPaymenteEditSupplier(payments) {
                const editSupplierPaymentTerms = document.getElementById('edit-supplier-payment-terms');
                payments.forEach(payment => {
                    const paymentOption = document.createElement('option');
                    paymentOption.innerHTML = payment.payment_type;
                    paymentOption.value = payment.payment_id;
                    editSupplierPaymentTerms.appendChild(paymentOption);
                });
            }
    
/**======================| FOR ADD AUPPLIER |=============================== */
    addSupplierForm .addEventListener('submit', function (event) {
        event.preventDefault();
        addSupplier();
    });
  // Function to handle category creation
  function addSupplier() {
    const addSupplierName = document.getElementById("add-supplier-name").value.trim();
    const addSupplierContactPerson = document.getElementById("add-supplier-contact-person").value.trim();
    const addSupplierPhoneNumber = document.getElementById("add-supplier-phone-number").value.trim();
    const addSupplierAddress = document.getElementById("add-supplier-address").value.trim();
    const addSupplierType = document.getElementById("add-supplier-type").value.trim();
    const addSupplierProductCategory = document.getElementById("add-supplier-product-category").value.trim();
    const addSupplierPaymentTerms = document.getElementById("add-supplier-payment-terms").value.trim();
    const addSupplierNote = document.getElementById("add-supplier-note").value.trim();
   
    // Validate form inputs
    if (!addSupplierName || !addSupplierContactPerson || !addSupplierPhoneNumber || !addSupplierAddress || !addSupplierType || !addSupplierProductCategory || !addSupplierPaymentTerms || !addSupplierNote) {
        alert("Please fill in all fields."  );
        return;
    }

    
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


    // Send data to PHP script using Fetch API
    fetch("../handler/records/supplier/add-supplier-handler.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                return response.text().then((text) => {
                    throw new Error(`Server responded with status ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                alert("Supplier created successfully!");
                addSupplierModalCon.style.display = 'none'; // Close the modal
                location.reload(); // Reload page to update table
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while creating the supplier.");
        });
    
    }


    // DISPLAY SUPPLIER
     function fetchSupplierData() {
        fetch('../handler/records/supplier/retrieve-supplier.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (!data.success || data.data.length === 0) {
                    console.warn('No supplier data found.');
                } else {
                    populateSupplierTable(data.data);
                }
            })
            .catch(error => console.error('Error fetching supplier data:', error));
    }
    
    // Populate supplier table
    function populateSupplierTable(suppliers) {
        supplierTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());
    
        suppliers.forEach(supplier => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${supplier.supplier_name}</td>
                <td>${supplier.contact_person}</td>
                <td>${supplier.contact_number}</td>
                <td>${supplier.address}</td>
                <td>${supplier.supplier_type}</td>
                <td>${supplier.product_category_name || 'N/A'}</td>
                <td>${supplier.payment_type || 'N/A'}</td>
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
            supplierTable.appendChild(row);
        });
        attachSupplierActionListeners();
    }

     function attachSupplierActionListeners() {
        document.querySelectorAll('.supplier-edit-button').forEach(button =>
            button.addEventListener('click', handleEditSupplier)
        );
        document.querySelectorAll('.supplier-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteSupplier)
    
        );
    }

    // FOR EDITING SUPPLIER
    function handleEditSupplier(event) {
        const supplierId = event.currentTarget.dataset.id;
        fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${supplierId}`)
            .then(response => response.json())
            .then(supplier => displayEditSupplierDetails(supplier))
            .catch(error => console.error('Error fetching supplier details:', error));
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

   // Listen for save button click to save the edited supplier
editSupplierSaveButton.addEventListener('click', function (event) {
    event.preventDefault();

    // Gather all the input field values into an object
    const supplierDetails = {
        supplier_id: document.getElementById('edit-supplier-id').value,
        supplier_name: document.getElementById('edit-supplier-name').value.trim(),
        contact_person: document.getElementById('edit-supplier-contact-person').value.trim(),
        contact_number: document.getElementById('edit-supplier-contact-number').value,
        address: document.getElementById('edit-supplier-address').value.trim(),
        supplier_type: document.getElementById('edit-supplier-type').value.trim(),
        product_category_id: document.getElementById('edit-supplier-product-category').value.trim(),
        payment_terms: document.getElementById('edit-supplier-payment-terms').value.trim(),
        note: document.getElementById('edit-supplier-note').value
    };

    // Send a POST request to the PHP handler to save the data
    fetch('../handler/records/supplier/supplier-edit-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(supplierDetails),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Supplier updated successfully!');
            editSupplierModalCon.style.display = 'none';
            fetchSupplierData(); // Assuming this function fetches and updates the supplier data
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => console.error('Error during fetch:', error));
});

// Listen for exit button to close the modal
editSupplierExitButton.addEventListener('click', function () {
    editSupplierModalCon.style.display = 'none';
});


 /***************************| FOR DELETE SUPPLIER |*********************************** */
const deleteSupplierModal = document.querySelector('.delete-supplier-modal-container');
const deleteSupplierYesButton = document.querySelector('#delete-supplier-yes-button');
const cancelDeleteSupplierButton = document.querySelector('#delete-supplier-no-button');

let supplierId = null;  // Define supplierId globally for the delete process

// Handle supplier deletion
function handleDeleteSupplier(event) {
  supplierId = event.currentTarget.dataset.id;  // Get the supplier ID from the button's data-id attribute
  console.log(supplierId);

  fetch(`../handler/records/supplier/retrieve-supplier-details.php?id=${supplierId}`)
    .then(response => response.json())
    .then(supplier => {
      if (supplier.error) {
        console.error('Error fetching supplier details:', supplier.error);
        return;
      }
      displayDeleteSupplierDetails(supplier);
    })
    .catch(error => console.error('Error fetching supplier details:', error));
}

// Display supplier details for deletion
function displayDeleteSupplierDetails(supplier) {
  deleteSupplierModal.style.display = 'flex';
  document.querySelector('#delete-supplier-name').textContent = supplier.supplier_name;
}

// Confirm delete supplier
deleteSupplierYesButton.addEventListener('click', function () {
  console.log(supplierId);
  if (!supplierId) {
    console.error('Supplier ID is not defined.');
    return;
  }

  fetch('../handler/records/supplier/supplier-delete-handler.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `id=${supplierId}`  // Send the supplier ID as part of the body
  })
    .then(response => response.text())  // Read as text to inspect raw response
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
});

// Cancel delete supplier
cancelDeleteSupplierButton.addEventListener('click', function () {
  deleteSupplierModal.style.display = 'none';  // Correct the reference to deleteSupplierModal
});


    





});