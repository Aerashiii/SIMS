document.addEventListener('DOMContentLoaded', function() {
    // CATEGORY
    const categoryTable = document.getElementById("category-table");
   
    // FOR EDITING CATEGORY
    const editCategoryModalCon = document.querySelector('.edit-category-modal-container');
    const editCategoryExitButton = document.getElementById('category-edit-exit-button');
    const editCategorySaveButton = document.getElementById('save-edit-category-button');
     const editCategorySaveBtn = document.querySelector('.save-edit-category-button');
     const editCategoryExitBtn = document.querySelector('.category-edit-exit-button');
     const editCategoryForm = document.querySelector('.edit-category-form');


     //FOR CATEGORY DELETION  
  const deleteCategoryModal = document.querySelector('.delete-category-modal-container');
  const deleteCategoryYesButton = document.querySelector('#delete-category-yes-button');
  const cancelDeleteCategoryButton = document.querySelector('#delete-category-no-button');



   editCategoryExitBtn.addEventListener('click', function() {
    editCategoryModalCon.style.display = 'none'; // Close the modal 
    console.log("Exit button clicked");
});

// TO SAVE EDITED CATEGORY
editCategorySaveButton.addEventListener('click', saveEditedCategory);

//TO CONFIRM DELETE CATEGORY
deleteCategoryYesButton.addEventListener('click', confirmDeleteCategory);

// TO CANCEL DELETE CATEGORY
cancelDeleteCategoryButton.addEventListener('click', cancelDeleteCategory);
/*===============================| FOR ADDING CATEGORY |================================================================*/
   
    const addCategoryModalCon = document.querySelector('.add-category-modal-container');
    //const addCategorySubmitButon = document.getElementById('add-category-submit-button');
    const addCategoryForm = document.getElementById('add-category-form');
 //   const addCategoryCancelButton = document.getElementById('add-category-cancel-button');


   // Fetch categories on page load
   fetchCategoryData()

   // Handle form submission using AJAX (Prevent default form submission)
    addCategoryForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent page reload
        
        createCategory(); // Call the function to handle form data submission
    });

    // Function to handle category creation
    function createCategory() {
        const categoryName = document.getElementById('add-category-name').value.trim();
        const categoryStatus = document.getElementById('add-category-status').value.trim();
        console.log("Category name:", categoryName);
        console.log("Category status:", categoryStatus);
        // Validate form inputs
        if (!categoryName || !categoryStatus) {
            alert("Please fill in all fields.");
            return;
        }
       

        // Create FormData object to send to the server
        const formData = new FormData();
        formData.append("category_name", categoryName);
        formData.append("category_status", categoryStatus);

        // Send data to PHP script using Fetch API
        fetch("../handler/records/category/add-category.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json()) // Parse the JSON response
        .then((data) => {
            if (data.success) {
                alert("Category created successfully!");
                addCategoryModalCon.style.display = 'none'; // Close the modal on success
                location.reload(); // Reload page to update table
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while creating the category.");
        });
    }
    // DISPLAY CATEGORY
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

    // Populate category table
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

// Attach listeners to buttons
function attachCategoryActionListeners() {
    document.querySelectorAll('.category-edit-button').forEach(button =>
        button.addEventListener('click', handleEditCategory)
    );
    document.querySelectorAll('.category-delete-button').forEach(button =>
        button.addEventListener('click', handleDeleteCategory)
    );
}
/**************************| EDITING CATEGORY  |*******************************************/
 
// Handle category editing
function handleEditCategory(event) {
    const categoryId = event.currentTarget.dataset.id;
    console.log("category Id : " + categoryId);

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

    const statusDropdown = document.getElementById('edit-category-status');
    statusDropdown.value = category.status;

    editCategoryModalCon.style.display = 'flex';
}


// Form submission handler

function saveEditedCategory() {
        console.log("Save button clicked");


        const category_id = document.getElementById('edit-category-id').value;
        const category_name = document.getElementById('edit-category-name').value.trim();
        const status = document.getElementById('edit-category-status').value;

        if (!category_name) {
            alert("Please enter a category name.");
            return;
        }
         console.log("category_id", category_id, "category_name", category_name, "status", status);

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
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Category saved successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while saving.');
        });

        editCategoryModalCon.style.display = 'none';
}



  /***************************| FOR DELETE CATEGORY |*********************************** */
 

  // Handle Delete Category
  function handleDeleteCategory(event) {
    categoryId = event.currentTarget.dataset.id; // Set productId globally

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

  // DISPLAY CATEGORY NAME FOR DELETING
  function displayDeleteCategoryDetails(category) {
    deleteCategoryModal.style.display = 'flex';
    document.querySelector('#delete-category-name').textContent = category.category_name;

  }


  // Confirm delete category
  function confirmDeleteCategory() {
    if (!categoryId) {
      console.error('category ID is not defined.');
      return;
    }
    console.log("Confirm delete button clicked for category ID:", categoryId);

    fetch(`../handler/records/category/category-delete-handler.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${categoryId}` // Send the product ID as part of the body
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
}

  // Cancel delete category
function cancelDeleteCategory() {
    console.log("Cancel delete button clicked");
    deleteCategoryModal.style.display = 'none';
  }







});
