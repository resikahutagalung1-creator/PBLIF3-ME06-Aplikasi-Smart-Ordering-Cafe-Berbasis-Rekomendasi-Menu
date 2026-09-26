document.addEventListener('DOMContentLoaded', function () {


    /* ================= PAYMENT ================= */

    const paymentOptions =
        document.querySelectorAll('.payment-option');


    paymentOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            paymentOptions.forEach(function (item) {

                item.classList.remove('selected');

            });


            this.classList.add('selected');


            const radio =
                this.querySelector('input[type="radio"]');


            if (radio) {

                radio.checked = true;

            }

        });

    });



    /* ================= DELETE ALL ================= */

    const deleteAll =
        document.getElementById('deleteAll');


    if (deleteAll) {

        deleteAll.addEventListener('click', function () {

            const yakin =
                confirm(
                    'Apakah kamu yakin ingin menghapus semua pesanan?'
                );


            if (!yakin) {

                return;

            }


            fetch('/pesanan/keranjang/kosongkan', {

                method: 'POST',

                headers: {

                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .getAttribute('content'),

                    'Accept':
                        'application/json',

                    'Content-Type':
                        'application/json'

                }

            })

            .then(function (response) {

                return response.json();

            })

            .then(function (data) {

                if (data.success) {

                    window.location.reload();

                }

            })

            .catch(function (error) {

                console.error(error);

            });

        });

    }



    /* ================= QUANTITY ================= */

    const minusButtons =
        document.querySelectorAll('.quantity-button.minus');


    const plusButtons =
        document.querySelectorAll('.quantity-button.plus');


    minusButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            updateQuantity(
                this.dataset.index,
                'minus'
            );

        });

    });


    plusButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            updateQuantity(
                this.dataset.index,
                'plus'
            );

        });

    });



    function updateQuantity(index, action) {

        fetch('/pesanan/keranjang/update', {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN':
                    document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        .getAttribute('content'),

                'Accept':
                    'application/json',

                'Content-Type':
                    'application/json'

            },

            body: JSON.stringify({

                index: index,

                action: action

            })

        })

        .then(function (response) {

            return response.json();

        })

        .then(function (data) {

            if (data.success) {

                window.location.reload();

            }

        })

        .catch(function (error) {

            console.error(error);

        });

    }



    /* ================= BAYAR ================= */

    const payButton =
        document.getElementById('payButton');


    if (payButton) {

        payButton.addEventListener('click', function () {


            const selectedPayment =
                document.querySelector(
                    'input[name="payment"]:checked'
                );


            if (!selectedPayment) {

                alert(
                    'Silakan pilih metode pembayaran terlebih dahulu.'
                );

                return;

            }


            const metode =
                selectedPayment.value;


            if (metode === 'qris') {

                alert(
                    'Pembayaran QRIS dipilih.'
                );

            } else {

                alert(
                    'Pembayaran tunai dipilih. Silakan lakukan pembayaran di kasir.'
                );

            }

        });

    }

});