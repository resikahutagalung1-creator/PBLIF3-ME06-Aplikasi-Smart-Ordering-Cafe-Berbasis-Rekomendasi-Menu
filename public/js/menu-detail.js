document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // JUMLAH MENU
    // =====================================================

    const minusButton =
        document.getElementById('minusButton');

    const plusButton =
        document.getElementById('plusButton');

    const quantityElement =
        document.getElementById('quantity');

    let quantity = 1;


    // KURANG
    if (minusButton) {

        minusButton.addEventListener('click', function () {

            if (quantity > 1) {

                quantity--;

                quantityElement.textContent =
                    quantity;
            }

        });

    }


    // TAMBAH
    if (plusButton) {

        plusButton.addEventListener('click', function () {

            quantity++;

            quantityElement.textContent =
                quantity;
        });

    }



    // =====================================================
    // PILIHAN RASA
    // =====================================================

    const tasteOptions =
        document.querySelectorAll('.taste-option');

    tasteOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            tasteOptions.forEach(function (item) {

                item.classList.remove('active');

            });

            this.classList.add('active');

        });

    });



    // =====================================================
    // TAMBAH KE KERANJANG
    // =====================================================

    const orderButton =
        document.getElementById('detailOrderButton');

    const cartCount =
        document.getElementById('cartCount');

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');


    if (orderButton) {

        orderButton.addEventListener(
            'click',
            async function () {

                const menuId =
                    this.dataset.menuId;

                if (!menuId) {

                    alert(
                        'Menu tidak ditemukan.'
                    );

                    return;
                }


                if (!csrfToken) {

                    alert(
                        'Token keamanan tidak ditemukan.'
                    );

                    return;
                }


                const originalContent =
                    this.innerHTML;


                this.disabled = true;


                try {

                    /*
                     * Tambahkan menu sebanyak quantity
                     */
                    for (
                        let i = 0;
                        i < quantity;
                        i++
                    ) {

                        const response =
                            await fetch(
                                '/keranjang/tambah',
                                {
                                    method: 'POST',

                                    headers: {
                                        'Content-Type':
                                            'application/json',

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            csrfToken
                                    },

                                    body: JSON.stringify({
                                        menu_id: menuId
                                    })
                                }
                            );


                        const data =
                            await response.json();


                        if (
                            !response.ok ||
                            !data.success
                        ) {

                            throw new Error(
                                data.message ||
                                'Menu gagal ditambahkan ke keranjang.'
                            );
                        }


                        if (cartCount) {

                            cartCount.textContent =
                                data.jumlah;

                        }

                    }


                    // TAMPILAN BERHASIL

                    this.innerHTML = `
                        <span>✓</span>
                        <span>
                            Berhasil Ditambahkan
                        </span>
                    `;

                    this.classList.add('added');


                    setTimeout(() => {

                        this.innerHTML =
                            originalContent;

                        this.classList.remove(
                            'added'
                        );

                        this.disabled = false;

                    }, 1000);


                } catch (error) {

                    console.error(
                        'Error keranjang:',
                        error
                    );


                    alert(
                        error.message ||
                        'Menu gagal ditambahkan ke keranjang.'
                    );


                    this.disabled = false;

                }

            }
        );

    }



    // =====================================================
    // KERANJANG
    // =====================================================

    const cartButton =
        document.getElementById('cartButton');


    if (cartButton) {

        cartButton.addEventListener(
            'click',
            function () {

                const jumlah =
                    parseInt(
                        cartCount?.textContent || '0',
                        10
                    );


                if (jumlah <= 0) {

                    alert(
                        'Keranjang masih kosong.'
                    );

                    return;
                }


                window.location.href =
                    '/ringkasan-pesanan';

            }
        );

    }

});