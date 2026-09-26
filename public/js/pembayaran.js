document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ELEMENT
    ===================================================== */

    const qrisOption =
        document.getElementById('qrisOption');

    const cashOption =
        document.getElementById('cashOption');

    const qrisDetail =
        document.getElementById('qrisDetail');

    const cashDetail =
        document.getElementById('cashDetail');

    const paymentInputs =
        document.querySelectorAll(
            'input[name="payment_method"]'
        );


    const payButton =
        document.getElementById('payButton');

    const paymentModal =
        document.getElementById('paymentModal');

    const modalCancel =
        document.getElementById('modalCancel');

    const modalConfirm =
        document.getElementById('modalConfirm');

    const modalMessage =
        document.getElementById('modalMessage');


    /* =====================================================
       PILIH METODE PEMBAYARAN
    ===================================================== */

    function updatePaymentMethod(method) {

        /*
         * Reset tampilan
         */

        qrisOption.classList.remove('active');

        cashOption.classList.remove('active');


        /*
         * Sembunyikan semua detail
         */

        qrisDetail.style.display = 'none';

        cashDetail.style.display = 'none';


        /*
         * QRIS
         */

        if (method === 'qris') {

            qrisOption.classList.add('active');

            qrisDetail.style.display = 'block';

        }


        /*
         * TUNAI
         */

        if (method === 'tunai') {

            cashOption.classList.add('active');

            cashDetail.style.display = 'block';

        }

    }


    /* =====================================================
       RADIO CHANGE
    ===================================================== */

    paymentInputs.forEach(function (input) {

        input.addEventListener('change', function () {

            updatePaymentMethod(
                this.value
            );

        });

    });


    /* =====================================================
       KLIK CARD QRIS
    ===================================================== */

    qrisOption.addEventListener(
        'click',
        function () {

            const input =
                qrisOption.querySelector(
                    'input[name="payment_method"]'
                );

            input.checked = true;

            updatePaymentMethod('qris');

        }
    );


    /* =====================================================
       KLIK CARD TUNAI
    ===================================================== */

    cashOption.addEventListener(
        'click',
        function () {

            const input =
                cashOption.querySelector(
                    'input[name="payment_method"]'
                );

            input.checked = true;

            updatePaymentMethod('tunai');

        }
    );


    /* =====================================================
       TOMBOL BAYAR
    ===================================================== */

    payButton.addEventListener(
        'click',
        function () {

            const selected =
                document.querySelector(
                    'input[name="payment_method"]:checked'
                );


            if (!selected) {

                alert(
                    'Silakan pilih metode pembayaran terlebih dahulu.'
                );

                return;
            }


            /*
             * Pesan sesuai metode
             */

            if (selected.value === 'qris') {

                modalMessage.textContent =
                    'Pastikan kamu sudah melakukan pembayaran melalui QRIS sebelum melanjutkan.';

            } else {

                modalMessage.textContent =
                    'Pesanan akan diproses setelah kamu melakukan pembayaran tunai kepada kasir.';

            }


            /*
             * Tampilkan modal
             */

            paymentModal.classList.add('show');

        }
    );


    /* =====================================================
       TUTUP MODAL
    ===================================================== */

    modalCancel.addEventListener(
        'click',
        function () {

            paymentModal.classList.remove(
                'show'
            );

        }
    );


    /* =====================================================
       KLIK AREA LUAR MODAL
    ===================================================== */

    paymentModal.addEventListener(
        'click',
        function (event) {

            if (
                event.target === paymentModal
            ) {

                paymentModal.classList.remove(
                    'show'
                );

            }

        }
    );


    /* =====================================================
       KONFIRMASI
    ===================================================== */

    modalConfirm.addEventListener(
        'click',
        function () {

            const selected =
                document.querySelector(
                    'input[name="payment_method"]:checked'
                );


            if (!selected) {

                return;
            }


            /*
             * Untuk sementara tampilkan
             * konfirmasi pembayaran.
             *
             * Tahap berikutnya bisa kita
             * sambungkan ke status pesanan
             * dan database pesanan.
             */

            if (selected.value === 'qris') {

                alert(
                    'Pembayaran QRIS berhasil dikonfirmasi.'
                );

            } else {

                alert(
                    'Pembayaran tunai dipilih. Silakan lakukan pembayaran kepada kasir.'
                );

            }


            paymentModal.classList.remove(
                'show'
            );

        }
    );


    /* =====================================================
       DEFAULT
       QRIS AKTIF
    ===================================================== */

    updatePaymentMethod('qris');

});