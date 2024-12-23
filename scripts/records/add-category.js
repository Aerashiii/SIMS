document.addEventListener('DOMContentLoaded', function() {
    // CATEGORY
    const categoryTable = document.getElementById("category-table");

    // FOR ADDING CATEGORY
    const addCategoryButton = document.getElementById('add-category-button');
    const addCategoryModalCon = document.querySelector('.add-category-modal-container');
    const addCategoryCancelButton = document.getElementById('add-category-cancel-button');
    const addCategorySubmitButon = document.getElementById('add-category-submit-button');
    const addCategoryForm = document.getElementById('add-category-form');

    // FOR ADDING SUBCATEGORY
    const addSubcategoryButton = document.getElementById('add-subcategory-button');
    const addSubcategoryModalCon = document.querySelector('.add-subcategory-modal-container');
    const addSubcategoryCancelButton = document.getElementById('add-subcategory-cancel-button');

    // FOR ADDING BRAND
    const addBrandButton = document.getElementById('add-brand-button');
    const addBrandModalCon = document.querySelector('.add-brand-modal-container');
    const addBrandCancelButton = document.getElementById('add-brand-cancel-button');


    // Fetch categories on page load
    fetchCategoryData()

    /***********| FOR ADDING CATEGORY |************ */
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
        const categoryName = document.getElementById("category-name").value.trim();
        const categoryStatus = document.getElementById("category-status").value.trim();

        // Validate form inputs
        if (!categoryName || !categoryStatus) {
            alert("Please fill in all fields.");
            return;
        }
        console.log("Category name:", categoryName);
        console.log("Category status:", categoryStatus);

        // Create FormData object to send to the server
        const formData = new FormData();
        formData.append("category_name", categoryName);
        formData.append("category_status", categoryStatus);

        // Send data to PHP script using Fetch API
        fetch("../handler/records/add-category.php", {
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
   // Fetch and display category data
   function fetchCategoryData() {
        fetch('../handler/records/retrieve-category.php')
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
   // attachCategoryActionListeners();
}



   



     /***********| FOR ADDING SUBCATEGORY |************ */
     addSubcategoryButton.addEventListener('click', function() {
        addSubcategoryModalCon.style.display = 'flex'; // Fixed the typo here
    });
    addSubcategoryCancelButton.addEventListener('click', function() {
        addSubcategoryModalCon.style.display = 'none'; // Fixed the typo here
    });

     /***********| FOR ADDING BRAND |************ */
     addBrandButton.addEventListener('click', function() {
        addBrandModalCon.style.display = 'flex'; // Fixed the typo here
    });
    addBrandCancelButton.addEventListener('click', function() {
        addBrandModalCon.style.display = 'none'; // Fixed the typo here
    });

});
