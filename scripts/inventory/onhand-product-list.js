// onhand-product-list.js
import { handleEditProduct, handleDeleteProduct } from './edit-and-delete-product.js';

document.addEventListener('DOMContentLoaded', function () {

    const onhandProductListTable  = document.getElementById('onhand-inventory-table').querySelector('tbody');
    const onhandProductSearchInput = document.getElementById('inventory-onhand-products-search-input');
    const SelectCategoryOnSubcategoryTable = document.getElementById('select-product-by-category');

    // Initial data fetch
    fetchCategoryDataForSelectCategory();
    fetchProductData();

// Add global state for current filters
let currentSearchQuery = '';
let currentSelectedCategory = '';
// Fetch products (all or filtered)

function fetchProductData(query = '', categoryId = '') {
    const formData = new URLSearchParams();
    formData.append('query', query);
    formData.append('category_id', categoryId);

    fetch('../handler/inventory/onhand-product/retrieve-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateProductTable(data.data);
        } else {
            onhandProductListTable.innerHTML = '<tr><td colspan="12">No products found</td></tr>';
        }
    })
    .catch(err => console.error('Failed to load products:', err));
}


    function populateProductTable(products) {
        onhandProductListTable.innerHTML = '';

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.barcode}</td>
                <td>${product.product_name}</td>
                <td>${product.category_name}</td>
                <td>${product.subcategory_name}</td>
                <td>${product.brand_name}</td>
                <td>${product.quantity}</td>
                <td>${product.reorder_point}</td>
                <td>${product.original_price}</td>
                <td>${product.selling_price}</td>
                <td>${product.supplier}</td>
                <td>${product.status}</td>
                <td>
                    <button data-id="${product.id}" class="product-edit-button">
                        <img src="../assets/images/icons/edit.png" alt="Edit">
                    </button>
                    <button data-id="${product.id}" class="product-delete-button">
                        <img src="../assets/images/icons/delete1.png" alt="Delete">
                    </button>
                </td>
            `;
            onhandProductListTable.appendChild(row);
        });

        attachProductActionListeners();
    }

    function attachProductActionListeners() {
        document.querySelectorAll('.product-edit-button').forEach(button =>
            button.addEventListener('click', handleEditProduct)
        );
        document.querySelectorAll('.product-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteProduct)
        );
    }

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

    function populateSelectCategoryOnSubcategoryTable(categories) {
        SelectCategoryOnSubcategoryTable.innerHTML = ''; // Clear previous options
        const defaultOption = document.createElement('option');
        defaultOption.text = 'All Categories';
        defaultOption.value = '';
        SelectCategoryOnSubcategoryTable.appendChild(defaultOption);

        categories.forEach(category => {
            const option = document.createElement('option');
            option.text = category.category_name;
            option.value = category.category_id;
            SelectCategoryOnSubcategoryTable.appendChild(option);
        });
    }


/****************| FOR SEARCHING PRODUCT ON ONHAND PRODUCT TABLE |********************* */
// Update category filter
SelectCategoryOnSubcategoryTable.addEventListener('change', function () {
    currentSelectedCategory = this.value;
    fetchProductData(currentSearchQuery, currentSelectedCategory);
});

// Update search filter
onhandProductSearchInput.addEventListener('input', () => {
    currentSearchQuery = onhandProductSearchInput.value.trim();
    fetchProductData(currentSearchQuery, currentSelectedCategory);
});
// Event: Search as you type
onhandProductSearchInput.addEventListener('input', () => {
    const query = onhandProductSearchInput.value.trim();

    fetch('../handler/inventory/onhand-product/retrieve-products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'query=' + encodeURIComponent(query)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductTable(data.data);
            } else {
                onhandProductListTable.innerHTML = '<tr><td colspan="4">No products found.</td></tr>';
            }
        })
        .catch(err => console.error('Search failed:', err));
});

// Enter key trigger search
onhandProductSearchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        currentSearchQuery = onhandProductSearchInput.value.trim();
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    }
});




});


