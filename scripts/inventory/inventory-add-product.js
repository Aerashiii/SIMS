document.addEventListener("DOMContentLoaded", function () {
    const selectSupplierButton = document.getElementById('add-product-select-supplier-button');
    const addProductSelectSupplier = document.getElementById('add-product-select-supplier');
    const addProductInputSupplier = document.getElementById('add-product-input-supplier');



    selectSupplierButton.addEventListener('click', function () {     
       if(selectSupplierButton.textContent === 'Select Supplier') {
            addProductSelectSupplier.style.display = 'block';
            addProductInputSupplier.style.display = 'none';
            selectSupplierButton.textContent = 'Input Supplier';
        }else {
            addProductSelectSupplier.style.display = 'none';
            addProductInputSupplier.style.display = 'block';
            selectSupplierButton.textContent = 'Select Supplier';
        }
    });
});
