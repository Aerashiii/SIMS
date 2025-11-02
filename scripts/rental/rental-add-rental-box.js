document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('rental-add-rental-box-form');
    const cancelBtn = document.getElementById('add-box-rental-cancel-button');

    const toastEl = document.getElementById('toast');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('box_number', document.getElementById('rental-add-box-number').value);
        formData.append('box_size', document.getElementById('rental-add-box-size').value);
        formData.append('width', document.getElementById('rental-add-box-width').value);
        formData.append('length', document.getElementById('rental-add-box-length').value);
        formData.append('rental_fee', document.getElementById('rental-add-box-rental-fee').value);
        formData.append('quantity', document.getElementById('rental-add-box-quantity').value);
        formData.append('status', document.getElementById('rental-add-box-status').value);

        try {
            const response = await fetch('../handler/rental/rental-box/add-rental-box.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                showToast("✅ " + result.message);
                form.reset();
            } else {
                showToast("❌ " + result.message);
            }

        } catch (error) {
            console.error('Error:', error);
            showToast('⚠️ Something went wrong while saving the box.');
        }
    });

    // Cancel button event
    cancelBtn.addEventListener('click', function() {
        window.location.href = 'rental-rental-box.php';
    });


    function showToast(message) {
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.classList.add("show");
        setTimeout(() => {
            toastEl.classList.remove("show");
            toastEl.textContent = '';
        }, 3000);
    }
});