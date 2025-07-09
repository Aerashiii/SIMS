document.addEventListener('DOMContentLoaded', function() {
 
    //FOR EDITING SUBCATEGORY
    const editSubcategoryModalCon = document.querySelector('.edit-subcategory-modal-container');
    const editSubcategoryExitButton = document.getElementById('subcategory-edit-exit-button');
    const editSubcategorySaveButton = document.getElementById('save-edit-subcategory-button');
    const editSubcategorySelectCategory = document.getElementById('edit-subcategory-select-category');




/*========================| FOR SUBCATEGORY |=================================================================================== */
// FOR SUBCATEGORY TABLE
const SelectCategoryOnSubcategoryTable = document.getElementById('subcategory-select-category');

// FOR ADDING SUBCATEGORY
const addSubcategoryButton = document.getElementById('add-subcategory-button');
const addSubcategoryModalCon = document.querySelector('.add-subcategory-modal-container');
const addSubcategoryCancelButton = document.getElementById('add-subcategory-cancel-button');
const addSubcategorySelectCategory = document.getElementById('add-subcategory-select-category');
const addSubcategoryForm = document.getElementById('add-subcategory-form');

fetchCategoryDataForSelectCategory();
fetchSubcategoryData();
fetchCategoryDataForSubcategory();

// FOR DISPLAYING ADD SUBCATEGORY MODAL
addSubcategoryButton.addEventListener('click', function() {
    addSubcategoryModalCon.style.display = 'flex';
});

// FOR HIDING ADD SUBCATEGORY MODAL
addSubcategoryCancelButton.addEventListener('click', function() {
    addSubcategoryModalCon.style.display = 'none';
});

// DISPLAY CATEGORY
function fetchCategoryDataForSubcategory() {
    fetch('../handler/records/category/retrieve-category.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                console.warn('No category data found.');
            } else {
                populateSelectCategory(data);
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
}

// Populate select category for adding subcategory
function populateSelectCategory(categories) {
    // Clear existing options first
    addSubcategorySelectCategory.innerHTML = '<option value="">-select category-</option>';
    
    categories.forEach(category => {
        const option = document.createElement('option');
        option.textContent = category.category_name;
        option.value = category.category_id;
        addSubcategorySelectCategory.appendChild(option);
    });
}

// SUBMISSION OF ADD SUBCATEGORY FORM
addSubcategoryForm.addEventListener("submit", function(event) {
    event.preventDefault();
    createSubcategory(); // Fixed function name (was createSubategory)
});

// Function to handle subcategory creation
function createSubcategory() {
    const categoryId = addSubcategorySelectCategory.value.trim();
    const subcategoryName = document.getElementById("add-subcategory-name").value.trim();
    const subcategoryStatus = document.getElementById("add-subcategory-status").value.trim();

    // Validate form inputs
    if (categoryId === "") {
        alert("Please select a category.");
        return;
    }
    if (!subcategoryName) {
        alert("Please enter a subcategory name.");
        return;
    }

    // Create FormData object
    const formData = new FormData();
    formData.append("category_id", categoryId);
    formData.append("subcategory_name", subcategoryName);
    formData.append("subcategory_status", subcategoryStatus);

    // Send data to PHP script
    fetch("../handler/records/category/add-subcategory.php", {
        method: "POST",
        body: formData,
    })
    .then(async (response) => {
        // First try to parse as JSON
        try {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Server error');
            }
            return data;
        } catch (e) {
            // If JSON parsing fails, get the raw text
            const text = await response.text();
            throw new Error(text || 'Invalid server response');
        }
    })
    .then((data) => {
        if (data.success) {
            alert("Subcategory created successfully!");
            addSubcategoryModalCon.style.display = 'none';
            document.getElementById("add-subcategory-name").value = "";
            fetchSubcategoryData();
        } else {
            alert(data.message || "Error creating subcategory");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert(error.message || "An error occurred while creating the subcategory.");
    });
}

// DISPLAY SUBCATEGORY
function fetchSubcategoryData(categoryId = null) {
    const url = categoryId
        ? `../handler/records/category/retrieve-subcategory.php?category_id=${categoryId}`
        : '../handler/records/category/retrieve-subcategory.php';

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch subcategory data');
            return response.json();
        })
        .then(data => {
            if (data.length > 0) {
                populateSubcategoryTable(data);
            } else {
                console.error('Error:', 'No subcategories found');
            }
        })
        .catch(error => console.error('Error fetching subcategory data:', error));
}

// Populate subcategory table
function populateSubcategoryTable(subcategories) {
    const subcategoryTable = document.getElementById('subcategory-table');

    // Clear existing rows (except the header)
    subcategoryTable.querySelectorAll('tr:not(:first-child)').forEach(row => row.remove());

    subcategories.forEach(subcategory => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${subcategory.category_name}</td>
            <td>${subcategory.subcategory_name}</td>
            <td>${subcategory.date_created}</td>
            <td>${subcategory.status}</td>
            <td>
                <button data-id="${subcategory.subcategory_id}" class="subcategory-edit-button">
                    <img src="../assets/images/icons/edit.png" alt="Edit">
                </button>
                <button data-id="${subcategory.subcategory_id}" class="subcategory-delete-button">
                    <img src="../assets/images/icons/delete1.png" alt="Delete">
                </button>
            </td>
        `;
        subcategoryTable.appendChild(row);
    });

    attachSubcategoryActionListeners();
}

// Fetch category data
function fetchCategoryDataForSelectCategory() {
    fetch('../handler/records/category/retrieve-category.php')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                console.warn('No category data found.');
            } else {
                populateSelectCategoryOnSubcategoryTable(data);
            }
        })
        .catch(error => console.error('Error fetching category data:', error));
}

// Populate select category for adding subcategory
function populateSelectCategoryOnSubcategoryTable(categories) {
    categories.forEach(category => {
        const option2 = document.createElement('option');
         option2.innerHTML = category.category_name;
         option2.value = category.category_id;
         SelectCategoryOnSubcategoryTable.appendChild(option2);
    });
}

// Attach change listener to dropdown
document.getElementById('subcategory-select-category').addEventListener('change', function () {
    const selectedCategoryId = this.value; // Get the selected category ID
    fetchSubcategoryData(selectedCategoryId); // Fetch and display subcategories for the selected category
});

// Initialize data on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchCategoryDataForSelectCategory();
    fetchSubcategoryData();
});







// Attach listeners to buttons
function attachSubcategoryActionListeners() {
    document.querySelectorAll('.subcategory-edit-button').forEach(button =>
        button.addEventListener('click', handleEditSubcategory)
    );
    document.querySelectorAll('.subcategory-delete-button').forEach(button =>
        button.addEventListener('click', handleDeleteSubcategory)
    );
}

/**************************| EDITING SUBCATEGORY  |*******************************************/
    fetchCategoryForSelectCategory();

    // DISPLAY SELECT CATEGORY IN EDIT SUBCATEGORY 
    function fetchCategoryForSelectCategory() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    console.warn('No category data found.');
                } else {
                    populateEditSubcategorySelectCategory(data);
                }
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    // Populate select category for editing subcategory
    function populateEditSubcategorySelectCategory(categories) {
        categories.forEach(category => {
            const option1 = document.createElement('option');
            option1.innerHTML = category.category_name;
            option1.value = category.category_id;
            editSubcategorySelectCategory.appendChild(option1);
        });
    }




    // Handle category editing
    function handleEditSubcategory(event) {
        const subcategoryId = event.currentTarget.dataset.id;
        console.log("subcategory Id : "+subcategoryId)
        

        fetch(`../handler/records/category/retrieve-subcategory-details.php?id=${subcategoryId}`)
            .then(response => response.json())
            .then(subcategory => {
            if (subcategory.error) {
                console.error('Error fetching category details:', subcategory.error);
                return;
            }
            
            displayEditSubcategoryDetails(subcategory);
            })
            .catch(error => console.error('Error fetching category1 details:', error));
    }

    function displayEditSubcategoryDetails(subcategory) { 
        document.getElementById('edit-subcategory-select-category').value = subcategory.category_id;
        document.getElementById('edit-subcategory-id').value = subcategory.subcategory_id; // Set product_id
        document.getElementById('edit-subcategory-name').value = subcategory.subcategory_name;

        // Ensure status is properly set in the dropdown
        const statusDropdown = document.getElementById('edit-subcategory-status');
        statusDropdown.value = subcategory.status; // This will set the selected option based on the category status
     
        editSubcategoryModalCon.style.display = 'flex';
    }

    // FOR SAVING EDITED CATEGORY DETAILS
    editSubcategorySaveButton.addEventListener('click', saveEditSubcategoryDetails)

    // Function to send product data to the server
    function saveEditSubcategoryDetails(event) {
        event.preventDefault(); // Prevent default form submission behavior

        console.log( document.getElementById('edit-subcategory-status').value);

        editSubcategoryModalCon.style.display ='none';
        const categoryDetails = {
            subcategory_id: document.getElementById('edit-subcategory-id').value,
            category_id: document.getElementById('edit-subcategory-select-category').value,
            subcategory_name: document.getElementById('edit-subcategory-name').value.trim(),
            status: document.getElementById('edit-subcategory-status').value.trim()           
        };

        fetch('../handler/records/category/subcategory-edit-handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(categoryDetails),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    alert('Subcategory saved successfully!');
                    window.location.reload();
                } else {
                    console.error('Error saving category:', data.message);
                    alert(`Error: ${data.message}`);
                }
            })
            .catch((error) => {
                console.error('Error during fetch:', error);
                alert('An error occurred while saving the category.');
            });
    } 

    editSubcategoryExitButton.addEventListener('click', function(){
    editSubcategoryModalCon.style.display = 'none';

    })

  /***************************| FOR DELETE SUBCATEGORY |*********************************** */
  //FOR SUBCATEGORY DELETION  
  const deleteSubcategoryModal = document.querySelector('.delete-subcategory-modal-container');
  const deleteSubcategoryYesButton = document.querySelector('#delete-subcategory-yes-button');
  const cancelDeleteSubcategoryButton = document.querySelector('#delete-subcategory-no-button');

  // Handle Delete Category
  function handleDeleteSubcategory(event) {
    subcategoryId = event.currentTarget.dataset.id; // Set productId globally

    fetch(`../handler/records/category/retrieve-subcategory-details.php?id=${subcategoryId}`)
      .then(response => response.json())
      .then(subcategory => {
        if (subcategory.error) {
          console.error('Error fetching product details:', subcategory.error);
          return;
        }
        displayDeleteSubcategoryDetails(subcategory);
      })
      .catch(error => console.error('Error fetching product details:', error));
  }

  // DISPLAY CATEGORY NAME FOR DELETING
  function displayDeleteSubcategoryDetails(subcategory) {
    deleteSubcategoryModal.style.display = 'flex';
    document.querySelector('#delete-subcategory-name').textContent = subcategory.subcategory_name;

  }


  // Confirm delete category
  deleteSubcategoryYesButton.addEventListener('click', function () {
    if (!subcategoryId) {
      console.error('category ID is not defined.');
      return;
    }
    console.log("subcategory ID :",subcategoryId)
    fetch(`../handler/records/category/subcategory-delete-handler.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${subcategoryId}` // Send the product ID as part of the body
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
  cancelDeleteSubcategoryButton.addEventListener('click', function () {
    deleteSubcategoryModal.style.display = 'none';
  }); 







});
