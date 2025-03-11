document.addEventListener('DOMContentLoaded', function(){
    // FOR RENTER LIST TABLE
    const renterListTable = document.getElementById('renter-list-table');

    // FOR ADD RENTER LIST
    const addRentalModalCon = document.querySelector('.add-rental-modal-container');
    const addRentalButton = document.getElementById('add-rental-button');
    const addRentalCancelButton =document.getElementById('add-rental-cancel-button');
    const addRentalForm = document.getElementById('add-rental-form');


    // FOR EDIT RENTER LIST
    const editRenterExitButton = document.getElementById('renter-edit-exit-button');
    const editRenterModalCon = document.querySelector('.edit-renter-modal-container');
    const editRenterSaveButton = document.getElementById('save-edit-renter-button');
   

    addRentalButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'flex';      
    })
    addRentalCancelButton.addEventListener('click', function(){
        addRentalModalCon.style.display = 'none';
    })
/*=====================================| FOR ADD RENTAL |========================================================================== */
// Fetch categories on page load
fetchCategoryData()

addCategoryButton.addEventListener('click', function() {
    addCategoryModalCon.style.display = 'flex'; // Fixed the typo here
});
addCategoryCancelButton.addEventListener('click', function() {
    addCategoryModalCon.style.display = 'none'; // Fixed the typo here
});
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
console.log("category Id : "+categoryId)


fetch(`../handler/records/category/retrieve-category-details.php?id=${categoryId}`)
    .then(response => response.json())
    .then(category => {
    if (category.error) {
        console.error('Error fetching category details:', category.error);
        return;
    }
    
    displayEditCategoryDetails(category);
    })
    .catch(error => console.error('Error fetching category1 details:', error));
}

function displayEditCategoryDetails(category) {

document.getElementById('edit-category-id').value = category.category_id; // Set product_id
document.getElementById('edit-category-name').value = category.category_name;

// Ensure status is properly set in the dropdown
    const statusDropdown = document.getElementById('edit-category-status');
    statusDropdown.value = category.status; // This will set the selected option based on the category status


editCategoryModalCon.style.display = 'flex';
}

// FOR SAVING EDITED CATEGORY DETAILS
editCategorySaveButton.addEventListener('click', saveEditCategoryDetails)

// Function to send product data to the server
function saveEditCategoryDetails(event) {
    event.preventDefault(); // Prevent default form submission behavior

    console.log( document.getElementById('edit-category-status').value);

    editCategoryModalCon.style.display ='none';
    const categoryDetails = {
        category_id: document.getElementById('edit-category-id').value,
        category_name: document.getElementById('edit-category-name').value.trim(),
        status: document.getElementById('edit-category-status').value.trim()           
    };

    fetch('../handler/records/category/category-edit-handler.php', {
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
                alert('Category saved successfully!');
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

editCategoryExitButton.addEventListener('click', function(){
editCategoryModalCon.style.display = 'none';

})

/***************************| FOR DELETE CATEGORY |*********************************** */
//FOR CATEGORY DELETION  
const deleteCategoryModal = document.querySelector('.delete-category-modal-container');
const deleteCategoryYesButton = document.querySelector('#delete-category-yes-button');
const cancelDeleteCategoryButton = document.querySelector('#delete-category-no-button');

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
deleteCategoryYesButton.addEventListener('click', function () {
if (!categoryId) {
  console.error('category ID is not defined.');
  return;
}
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
});

// Cancel delete product
cancelDeleteCategoryButton.addEventListener('click', function () {
deleteCategoryModal.style.display = 'none';
}); 

});