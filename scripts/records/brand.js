document.addEventListener('DOMContentLoaded', function () {
    // DOM elements
    const brandTable = document.getElementById('brand-table');
    const addBrandButton = document.getElementById('add-brand-button');
    const addBrandModalCon = document.querySelector('.add-brand-modal-container');
    const addBrandCancelButton = document.getElementById('add-brand-cancel-button');
    const addBrandForm = document.getElementById('add-brand-form');
    const editBrandModalCon = document.querySelector('.edit-brand-modal-container');
    const editBrandExitButton = document.getElementById('brand-edit-exit-button');
    const editBrandSaveButton = document.getElementById('save-edit-brand-button');

    // Show Add Brand Modal
    addBrandButton.addEventListener('click', function () {
        addBrandModalCon.style.display = 'flex';
    });

    // Hide Add Brand Modal
    addBrandCancelButton.addEventListener('click', function () {
        addBrandModalCon.style.display = 'none';
    });

    // Fetch and display brand data
    fetchBrandData();

    // Add brand submission handler
    addBrandForm.addEventListener('submit', function (event) {
        event.preventDefault();
        createBrand();
    });

    function createBrand() {
        const addBrandName = document.getElementById('add-brand-name').value.trim();
        const addBrandStatus = document.getElementById('add-brand-status').value.trim();

        if (!addBrandName || !addBrandStatus) {
            alert('Please fill in all fields.');
            return;
        }

        const formData = new FormData();
        formData.append('brand_name', addBrandName);
        formData.append('brand_status', addBrandStatus);

        fetch('../handler/records/brand/add-brand.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Brand created successfully!');
                    addBrandModalCon.style.display = 'none';
                    fetchBrandData(); // Refresh brand table
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the brand.');
            });
    }

    function fetchBrandData() {
        fetch('../handler/records/brand/retrieve-brand.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => populateBrandTable(data))
            .catch(error => console.error('Error fetching brand data:', error));
    }

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

    function attachBrandActionListeners() {
        document.querySelectorAll('.brand-edit-button').forEach(button =>
            button.addEventListener('click', handleEditBrand)
        );
        document.querySelectorAll('.brand-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteBrand)
        );
    }

    function handleEditBrand(event) {
        const brandId = event.currentTarget.dataset.id;
        fetch(`../handler/records/brand/retrieve-brand-details.php?id=${brandId}`)
            .then(response => response.json())
            .then(brand => displayEditBrandDetails(brand))
            .catch(error => console.error('Error fetching brand details:', error));
    }

    function displayEditBrandDetails(brand) {
        document.getElementById('edit-brand-id').value = brand.brand_id;
        document.getElementById('edit-brand-name').value = brand.brand_name;
        document.getElementById('edit-brand-status').value = brand.status;
        editBrandModalCon.style.display = 'flex';
    }

    editBrandSaveButton.addEventListener('click', function (event) {
        event.preventDefault();
        const brandDetails = {
            brand_id: document.getElementById('edit-brand-id').value,
            brand_name: document.getElementById('edit-brand-name').value.trim(),
            status: document.getElementById('edit-brand-status').value.trim(),
        };

        fetch('../handler/records/brand/brand-edit-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(brandDetails),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Brand updated successfully!');
                    editBrandModalCon.style.display = 'none';
                    fetchBrandData();
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => console.error('Error during fetch:', error));
    });

    editBrandExitButton.addEventListener('click', function () {
        editBrandModalCon.style.display = 'none';
    });


    /***************************| FOR DELETE BRAND |*********************************** */
  //FOR BRAND DELETION  
  const deleteBrandModal = document.querySelector('.delete-brand-modal-container');
  const deleteBrandYesButton = document.querySelector('#delete-brand-yes-button');
  const cancelDeleteBrandButton = document.querySelector('#delete-brand-no-button');

  // Handle Brand 
  function handleDeleteBrand(event) {
    brandId = event.currentTarget.dataset.id; // Set brandId globally

    fetch(`../handler/records/brand/retrieve-brand-details.php?id=${brandId}`)
      .then(response => response.json())
      .then(brand => {
        if (brand.error) {
          console.error('Error fetching brand details:', brand.error);
          return;
        }
        displayDeleteBrandDetails(brand);
      })
      .catch(error => console.error('Error fetching brand details:', error));
  }

  // DISPLAY BRAND NAME FOR DELETING
  function displayDeleteBrandDetails(brand) {
    deleteBrandModal.style.display = 'flex';
    document.querySelector('#delete-brand-name').textContent = brand.brand_name;

  }


  // Confirm delete brand
  deleteBrandYesButton.addEventListener('click', function () {
    if (!brandId) {
      console.error('brand ID is not defined.');
      return;
    }
    fetch(`../handler/records/brand/brand-delete-handler.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${brandId}` // Send the product ID as part of the body
    })
      .then(response => response.text()) // Read as text to inspect raw response
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

  // Cancel delete product
  cancelDeleteBrandButton.addEventListener('click', function () {
    deleteBrandModal.style.display = 'none';
  }); 

















});
