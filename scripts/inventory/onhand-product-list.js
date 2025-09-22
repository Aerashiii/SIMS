import { handleEditProduct, handleDeleteProduct } from './edit-and-delete-product.js';

document.addEventListener('DOMContentLoaded', function () {
    const onhandProductListTable  = document.getElementById('onhand-inventory-table').querySelector('tbody');
    const onhandProductSearchInput = document.getElementById('inventory-onhand-products-search-input');
    const SelectCategoryOnSubcategoryTable = document.getElementById('select-product-by-category');

    let currentSearchQuery = '';
    let currentSelectedCategory = '';

    // Initial load
    fetchCategoryDataForSelectCategory();
    fetchProductData();

    /** Fetch products */
    function fetchProductData(query = '', categoryId = '') {
        const formData = new URLSearchParams();
        formData.append('query', query);
        formData.append('category_id', categoryId);

        fetch('../handler/inventory/onhand-product/retrieve-products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductTable(data.data);
            } else {
                onhandProductListTable.innerHTML = '<tr><td colspan="10">No products found</td></tr>';
            }
        })
        .catch(err => console.error('Failed to load products:', err));
    }

    /** Populate product table */
    function populateProductTable(products) {
        onhandProductListTable.innerHTML = '';

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.description || 'N/A'}</td>
                <td>${product.category_name || 'N/A'}</td>
                <td>${product.subcategory_name || 'N/A'}</td>
                <td>${product.brand_name || 'N/A'}</td>
                <td>${product.quantity}</td>
                <td>${product.reorder_point}</td>
                <td>${Number(product.original_price).toFixed(2)}</td>
                <td>${Number(product.selling_price).toFixed(2)}</td>
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

    /** Attach edit/delete */
    function attachProductActionListeners() {
        document.querySelectorAll('.product-edit-button').forEach(button =>
            button.addEventListener('click', handleEditProduct)
        );
        document.querySelectorAll('.product-delete-button').forEach(button =>
            button.addEventListener('click', handleDeleteProduct)
        );
    }

    /** Fetch categories for filter */
    function fetchCategoryDataForSelectCategory() {
        fetch('../handler/records/category/retrieve-category.php')
            .then(response => response.json())
            .then(data => {
                populateSelectCategoryOnSubcategoryTable(data);
            })
            .catch(error => console.error('Error fetching category data:', error));
    }

    function populateSelectCategoryOnSubcategoryTable(categories) {
        SelectCategoryOnSubcategoryTable.innerHTML = '';
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

    /** Event: filter by category */
    SelectCategoryOnSubcategoryTable.addEventListener('change', function () {
        currentSelectedCategory = this.value;
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    });

    /** Event: search as you type */
    onhandProductSearchInput.addEventListener('input', () => {
        currentSearchQuery = onhandProductSearchInput.value.trim();
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    });

    /** Event: enter key */
    onhandProductSearchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            currentSearchQuery = onhandProductSearchInput.value.trim();
            fetchProductData(currentSearchQuery, currentSelectedCategory);
        }
    });
});
