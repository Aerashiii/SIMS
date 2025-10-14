document.addEventListener('DOMContentLoaded', () => {
  const editBtn = document.getElementById('edit-business-button');
  const saveBtn = document.getElementById('save-business-changes-button');
  const inputs = document.querySelectorAll('#business-details-form input:not([type="checkbox"]), #business-details-form textarea');
  const checks = document.querySelectorAll('#business-details-form input[type="checkbox"]');

  editBtn.addEventListener('click', () => {
    inputs.forEach(i => i.disabled = false);
    checks.forEach(c => c.disabled = false);
    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline-block';
  });

  document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('change', () => {
      if (input.value < 0) input.value = 0;
    });
  });
});
