document.addEventListener('DOMContentLoaded', function(){
    // FOR DISPLAYING BRAND
    const brandTable = document.getElementById('brand-table');

    // FOR ADDING BRAND
    const addBrandButton = document.getElementById('add-brand-button');
    const addBrandModalCon = document.querySelector('.add-brand-modal-container');
    const addBrandCancelButton = document.getElementById('add-brand-cancel-button');
    const addBrandForm = document.getElementById('add-brand-form');

    // FOR EDITING BRAND
    const editBrandModalCon = document.querySelector('.edit-brand-modal-container');
    const editBrandExitButton = document.getElementById('brand-edit-exit-button');
    const editBrandSaveButton = document.getElementById('save-edit-brand-button');
    
     /***********| FOR ADDING BRAND |************ */
     addBrandButton.addEventListener('click', function() {
        addBrandModalCon.style.display = 'flex'; // Fixed the typo here
    });
    addBrandCancelButton.addEventListener('click', function() {
        addBrandModalCon.style.display = 'none'; // Fixed the typo here
    });
/*==================================| FOR ADDING BRAND |======================================================================= */
    fetchBrandData();

    // Handle form submission using AJAX (Prevent default form submission)
    addBrandForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent page reload
        createBrand(); // Call the function to handle form data submission
    });

    // Function to handle category creation
    function createBrand() {
        const addBrandName = document.getElementById("add-brand-name").value.trim();
        const addBrandStatus = document.getElementById("add-brand-status").value.trim();

        // Validate form inputs
        if (!addBrandName || !addBrandStatus) {
            alert("Please fill in all fields.");
            return;
        }
        console.log("Brand name:", addBrandName);
        console.log("Brand status:", addBrandStatus);

        // Create FormData object to send to the server
        const formData = new FormData();
        formData.append("brand_name", addBrandName);
        formData.append("brand_status", addBrandStatus);

        // Send data to PHP script using Fetch API
        fetch("../handler/records/brand/add-brand.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json()) // Parse the JSON response
        .then((data) => {
            if (data.success) {
                alert("Brand created successfully!");
                addBrandModalCon.style.display = 'none'; // Close the modal on success
                location.reload(); // Reload page to update table
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while creating the brand.");
        });
    }
    // DISPLAY brand
   function fetchBrandData() {
        fetch('../handler/records/brand/retrieve-brand.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    console.warn('No brand data found.');
                } else {
                    populateBrandTable(data);
                }
            })
            .catch(error => console.error('Error fetching brand data:', error));
    }

    // Populate category table
    function populateBrandTable(brands) {
        brandTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

        brands.forEach(brand => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${brand.brand_name}</td>
                <td>${brand.date_created}</td>
                <td>${brand.status}</td>
                <td>
                    <button data-id="${brand.brand_id}" class="brand-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${brand.brand_id}" class="brand-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            brandTable.appendChild(row);
        });
        attachBrandActionListeners();
    }
    // Attach listeners to buttons
    function attachBrandActionListeners() {
        document.querySelectorAll('.brand-edit-button').forEach(button =>
            button.addEventListener('click', handleEditBrand)
        );
        document.querySelectorAll('.brand-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteBrand)
        );
    }

    /**************************| EDITING BRAND  |*******************************************/
    // Handle brand editing
    function handleEditBrand(event) {
        const brandId = event.currentTarget.dataset.id;
        console.log("brand Id : "+brandId)
        
    
        fetch(`../handler/records/brand/retrieve-brand-details.php?id=${brandId}`)
            .then(response => response.json())
            .then(brand => {
            if (brand.error) {
                console.error('Error fetching brand details:', branderror);
                return;
            }
            
            displayEditBrandDetails(brand);
            })
            .catch(error => console.error('Error fetching Brand details:', error));
        }
    
        function displayEditBrandDetails(brand) {
        
        document.getElementById('edit-brand-id').value = brand.brand_id; // Set product_id
        document.getElementById('edit-brand-name').value = brand.brand_name;
    
        // Ensure status is properly set in the dropdown
            const statusDropdown = document.getElementById('edit-brand-status');
            statusDropdown.value = brand.status; // This will set the selected option based on the category status
    
        
        editBrandModalCon.style.display = 'flex';
        }
    
        // FOR SAVING EDITED BRAND DETAILS
        editBrandSaveButton.addEventListener('click', saveEditBrandDetails)
    
        // Function to send product data to the server
        function saveEditBrandDetails(event) {
            event.preventDefault(); // Prevent default form submission behavior
    
            console.log( document.getElementById('edit-brand-status').value);
    
            editBrandModalCon.style.display ='none';
            const brandDetails = {
                brand_id: document.getElementById('edit-brand-id').value,
                brand_name: document.getElementById('edit-brand-name').value.trim(),
                brand: document.getElementById('edit-brand-status').value.trim()           
            };
            console.log(brandDetails);
    
            fetch('../handler/records/brand/brand-edit-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(brandDetails),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        alert('Brand saved successfully!');
                        window.location.reload();
                    } else {
                        console.error('Error saving Brand:', data.message);
                        alert(`Error: ${data.message}`);
                    }
                })
                .catch((error) => {
                    console.error('Error during fetch:', error);
                    alert('An error occurred while saving the Brand.');
                });
        } 
    
        editBrandExitButton.addEventListener('click', function(){
        editBrandModalCon.style.display = 'none';
    
        })













});