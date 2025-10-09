document.addEventListener('DOMContentLoaded', function () {
    const recordsProductListTable = document.getElementById('product-list-table')?.querySelector('tbody');
    const recordsProductSearchInput = document.getElementById('inventory-onhand-products-search-input');
    const selectCategoryDropdown = document.getElementById('select-product-by-category');

    // ✅ Exit if required elements are missing
    if (!recordsProductListTable || !recordsProductSearchInput || !selectCategoryDropdown) {
        console.error("❌ Required DOM elements not found.");
        return;
    }

    let currentSearchQuery = '';
    let currentSelectedCategory = '';

    // Initial load
    fetchProductData();
    fetchOptions("../handler/records/category/retrieve-category.php", selectCategoryDropdown, "category_id", "category_name");

    /** Load category options into dropdown */
    function fetchOptions(url, dropdown, valueKey, textKey) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data.success && Array.isArray(data.data)) {
                    items = data.data;
                }

                dropdown.innerHTML = ""; // clear existing options
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "All Categories";
                dropdown.appendChild(defaultOption);

                if (items.length === 0) {
                    dropdown.innerHTML += `<option value="">⚠ No records found</option>`;
                    return;
                }

                items.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item[valueKey];
                    option.textContent = item[textKey];
                    dropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error(`❌ Error fetching categories:`, error);
                dropdown.innerHTML = `<option value="">⚠ Error loading categories</option>`;
            });
    }

    /** Fetch products from server */
    function fetchProductData(query = '', categoryId = '') {
        recordsProductListTable.innerHTML = `<tr><td colspan="11">⏳ Loading...</td></tr>`;

        const formData = new URLSearchParams();
        formData.append('query', query);
        formData.append('category_id', categoryId);

        fetch('../handler/inventory/onhand-product/retrieve-products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                populateProductTable(data.data);
            } else {
                recordsProductListTable.innerHTML = '<tr><td colspan="11">⚠ No products found</td></tr>';
            }
        })
        .catch(err => {
            console.error('❌ Failed to load products:', err);
            recordsProductListTable.innerHTML = '<tr><td colspan="11">⚠ Error loading products</td></tr>';
        });
    }

    /** Populate product table */
    function populateProductTable(products) {
        recordsProductListTable.innerHTML = '';

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.product_name || 'N/A'}</td>
                <td>${product.description || 'N/A'}</td>
                <td>${product.category_name || 'N/A'}</td>
                <td>${product.subcategory_name || 'N/A'}</td>
                <td>${product.brand_name || 'N/A'}</td>
                <td>${product.barcode || 'N/A'}</td>
                <td>${product.quantity ?? 0}</td>
                <td>${product.reorder_point ?? 0}</td>
                <td>${product.original_price ? Number(product.original_price).toFixed(2) : '0.00'}</td>
                <td>${product.selling_price ? Number(product.selling_price).toFixed(2) : '0.00'}</td>
                <td>${product.supplier_name || 'N/A'}</td>
            `;
            recordsProductListTable.appendChild(row);
        });
    }

    /** Event: filter by category */
    selectCategoryDropdown.addEventListener('change', function () {
        currentSelectedCategory = this.value;
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    });

    /** Event: live search */
    recordsProductSearchInput.addEventListener('input', () => {
        currentSearchQuery = recordsProductSearchInput.value.trim();
        fetchProductData(currentSearchQuery, currentSelectedCategory);
    });

    /** Event: enter key search */
    recordsProductSearchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            currentSearchQuery = recordsProductSearchInput.value.trim();
            fetchProductData(currentSearchQuery, currentSelectedCategory);
        }
    });
});
