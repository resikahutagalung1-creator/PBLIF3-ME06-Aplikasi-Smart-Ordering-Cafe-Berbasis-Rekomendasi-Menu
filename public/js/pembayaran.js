
document.addEventListener('DOMContentLoaded', function () {
    const paymentInputs = document.querySelectorAll(
        'input[name="payment_method"]'
    );

    const qrisOption = document.getElementById('qrisOption');
    const cashOption = document.getElementById('cashOption');

    const qrisDetail = document.getElementById('qrisDetail');
    const cashDetail = document.getElementById('cashDetail');

    const payButton = document.getElementById('payButton');
    const paymentModal = document.getElementById('paymentModal');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    const modalMessage = document.getElementById('modalMessage');

    let selectedPaymentMethod = null;

    // Mengatur tampilan metode pembayaran
    function updatePaymentDisplay() {
        const selected = document.querySelector(
            'input[name="payment_method"]:checked'
        );

        selectedPaymentMethod = selected ? selected.value : null;

        if (qrisOption) {
            qrisOption.classList.toggle(
                'active',
                selectedPaymentMethod === 'qris'
            );
        }

        if (cashOption) {
            cashOption.classList.toggle(
                'active',
                selectedPaymentMethod === 'tunai'
            );
        }

        if (qrisDetail) {
            qrisDetail.style.display =
                selectedPaymentMethod === 'qris' ? 'block' : 'none';
        }

        if (cashDetail) {
            cashDetail.style.display =
                selectedPaymentMethod === 'tunai' ? 'block' : 'none';
        }
    }

    paymentInputs.forEach(function (input) {
        input.addEventListener('change', updatePaymentDisplay);
    });

    updatePaymentDisplay();

    // Membuka konfirmasi pembayaran
    if (payButton) {
        payButton.addEventListener('click', function () {
            const selected = document.querySelector(
                'input[name="payment_method"]:checked'
            );

            if (!selected) {
                alert('Silakan pilih metode pembayaran terlebih dahulu.');
                return;
            }

            selectedPaymentMethod = selected.value;

            if (modalMessage) {
                modalMessage.textContent =
                    selectedPaymentMethod === 'qris'
                        ? 'Apakah Anda yakin ingin melanjutkan pembayaran menggunakan QRIS?'
                        : 'Apakah Anda yakin ingin melanjutkan pembayaran secara tunai?';
            }

            if (paymentModal) {
                paymentModal.style.display = 'flex';
            }
        });
    }

    // Menutup modal
    if (modalCancel) {
        modalCancel.addEventListener('click', function () {
            if (paymentModal) {
                paymentModal.style.display = 'none';
            }
        });
    }

    // Mengirim konfirmasi ke Laravel dan menyimpan pesanan
    if (modalConfirm) {
        modalConfirm.addEventListener('click', async function () {
            if (!selectedPaymentMethod) {
                alert('Silakan pilih metode pembayaran.');
                return;
            }

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]'
            );

            if (!csrfToken) {
                alert('Token keamanan tidak ditemukan. Silakan muat ulang halaman.');
                return;
            }

            modalConfirm.disabled = true;
            modalConfirm.textContent = 'Memproses...';

            try {
                const response = await fetch('/pesanan/konfirmasi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method: selectedPaymentMethod
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message || 'Pesanan gagal disimpan.'
                    );
                }

                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                throw new Error('Alamat halaman rincian pesanan tidak ditemukan.');

            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat memproses pesanan.');

                modalConfirm.disabled = false;
                modalConfirm.textContent = 'Ya, Bayar';
            }
        });
    }
});