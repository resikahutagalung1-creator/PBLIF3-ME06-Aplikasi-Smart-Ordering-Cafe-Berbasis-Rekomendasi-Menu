document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('customerForm');
    const button = document.getElementById('orderButton');

    if (!form || !button) return;

    form.addEventListener('submit', function () {
        const nama = document.getElementById('nama').value.trim();

        if (nama === '') {
            return;
        }

        button.disabled = true;
        button.innerHTML = '<span>Menyimpan...</span>';
    });
});