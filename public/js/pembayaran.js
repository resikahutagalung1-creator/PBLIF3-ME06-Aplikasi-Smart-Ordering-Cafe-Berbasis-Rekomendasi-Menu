
document.addEventListener('DOMContentLoaded', function () {
    const paymentInputs = document.querySelectorAll(
        'input[name="payment_method"]'
    );

    const qrisOption = document.getElementById('qrisOption');
    const cashOption = document.getElementById('cashOption');

    const qrisDetail = document.getElementById('qrisDetail');
    const cashDetail = document.getElementById('cashDetail');

    const qrisImageContainer = document.getElementById('qrisImageContainer');
    const qrisPaymentStatus = document.getElementById('qrisPaymentStatus');

    const payButton = document.getElementById('payButton');
    const paymentModal = document.getElementById('paymentModal');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    const modalMessage = document.getElementById('modalMessage');

    let selectedPaymentMethod = null;
    let paymentIsProcessing = false;

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

    // Membuka modal konfirmasi
    if (payButton) {
        payButton.addEventListener('click', function () {
            if (paymentIsProcessing) {
                return;
            }

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
                        ? 'Apakah kamu yakin ingin melanjutkan pembayaran menggunakan QRIS?'
                        : 'Apakah kamu yakin ingin melanjutkan pembayaran secara tunai?';
            }

            if (paymentModal) {
                paymentModal.style.display = 'flex';
            }
        });
    }

    // Menutup modal
    if (modalCancel) {
        modalCancel.addEventListener('click', function () {
            if (paymentModal && !paymentIsProcessing) {
                paymentModal.style.display = 'none';
            }
        });
    }

    // Mengirim pesanan ke Laravel
    if (modalConfirm) {
        modalConfirm.addEventListener('click', async function () {
            if (!selectedPaymentMethod || paymentIsProcessing) {
                return;
            }

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]'
            );

            if (!csrfToken) {
                alert('Token keamanan tidak ditemukan. Silakan muat ulang halaman.');
                return;
            }

            paymentIsProcessing = true;
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
                        data.message || 'Pesanan gagal diproses.'
                    );
                }

                // Pembayaran QRIS melalui Midtrans
                if (selectedPaymentMethod === 'qris') {
                    if (!data.qr_url) {
                        throw new Error(
                            'QRIS belum berhasil dibuat. Periksa status pesanan sebelum mencoba kembali.'
                        );
                    }

                    if (!qrisImageContainer) {
                        throw new Error(
                            'Tempat menampilkan QRIS tidak ditemukan pada halaman.'
                        );
                    }

                    const qrImage = document.createElement('img');

                    qrImage.src = data.qr_url;
                    qrImage.alt = 'QRIS Pembayaran Smart Cafe';
                    qrImage.style.maxWidth = '100%';
                    qrImage.style.height = 'auto';

                    qrisImageContainer.replaceChildren(qrImage);

                    if (qrisPaymentStatus) {
                        const orderNumber = data.order_number
                            ? 'Nomor pesanan: ' + data.order_number + '. '
                            : '';

                        qrisPaymentStatus.textContent =
                            orderNumber +
                            'Silakan scan QR Code menggunakan aplikasi pembayaran yang mendukung QRIS. Pesanan masih menunggu pembayaran.';

                        qrisPaymentStatus.style.display = 'block';
                    }

                    // Mulai mengecek status pembayaran QRIS
                    mulaiCekStatusPembayaran(data.pesanan_id);

                    if (paymentModal) {
                        paymentModal.style.display = 'none';
                    }

                    modalConfirm.textContent = 'QRIS Dibuat';

                    if (payButton) {
                        payButton.disabled = true;
                    }

                    return;
                }

                // Pembayaran tunai
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                throw new Error(
                    'Alamat halaman rincian pesanan tidak ditemukan.'
                );

            } catch (error) {
                alert(
                    error.message ||
                    'Terjadi kesalahan saat memproses pembayaran.'
                );

                paymentIsProcessing = false;
                modalConfirm.disabled = false;
                modalConfirm.textContent = 'Ya, Bayar';
            }
        });
    }

    // Mengecek status pembayaran QRIS secara otomatis
    function mulaiCekStatusPembayaran(pesananId) {
        async function cekStatus() {
            try {
                const response = await fetch(
                    `/pesanan/${encodeURIComponent(pesananId)}/cek-status`,
                    {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal mengambil status pembayaran.');
                }

                const data = await response.json();

                // Jika pembayaran berhasil
                if (data.payment_status === 'Berhasil') {
                    if (qrisPaymentStatus) {
                        qrisPaymentStatus.textContent =
                            'Pembayaran berhasil! Mengalihkan ke halaman status pesanan...';
                    }

                    // Arahkan pelanggan ke halaman status pesanan
                    window.location.href =
                        `/status-pesanan/${encodeURIComponent(pesananId)}`;

                    return;
                }

                // Jika pembayaran gagal
                if (data.payment_status === 'Gagal') {
                    if (qrisPaymentStatus) {
                        qrisPaymentStatus.textContent =
                            data.message || 'Pembayaran gagal atau kedaluwarsa.';
                    }

                    return;
                }

                if (qrisPaymentStatus) {
                    qrisPaymentStatus.textContent =
                        'Menunggu pembayaran QRIS...';
                }

            } catch (error) {
                console.error(
                    'Gagal memeriksa status pembayaran:',
                    error
                );
            }

            // Cek kembali setelah 4 detik
            setTimeout(cekStatus, 4000);
        }

        cekStatus();
    }
});