
document.addEventListener('DOMContentLoaded', function () {
    const copyButton = document.getElementById('copyOrderButton');
    const orderNumber = document.getElementById('orderNumber');
    const copyMessage = document.getElementById('copyMessage');

    if (copyButton && orderNumber) {
        copyButton.addEventListener('click', async function () {
            const nomor = orderNumber.textContent.trim();

            try {
                await navigator.clipboard.writeText(nomor);

                copyMessage.textContent = 'Nomor pesanan berhasil disalin.';
                copyButton.textContent = 'Tersalin';

            } catch (error) {
                copyMessage.textContent =
                    'Tidak dapat menyalin nomor pesanan. Silakan salin secara manual.';
            }
        });
    }
});