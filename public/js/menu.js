document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // ELEMENT
    // =====================================================

    const orderButtons = document.querySelectorAll('.order-button');
    const cartCount = document.getElementById('cartCount');
    const cartButton = document.getElementById('cartButton');

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');


    // =====================================================
    // JUMLAH KERANJANG AWAL
    // =====================================================

    let jumlahKeranjang = parseInt(
        cartCount?.textContent || '0',
        10
    );


    // =====================================================
    // TAMBAH MENU KE KERANJANG
    // =====================================================

    orderButtons.forEach(function (button) {

        button.addEventListener('click', async function (event) {

            /*
             * Mencegah klik tombol ikut membuka
             * detail menu.
             */
            event.preventDefault();
            event.stopPropagation();


            // -------------------------------------------------
            // AMBIL ID MENU
            // -------------------------------------------------

            const menuId = button.dataset.menuId;

            if (!menuId) {

                alert('Menu tidak ditemukan.');

                return;
            }


            // -------------------------------------------------
            // CEK CSRF TOKEN
            // -------------------------------------------------

            if (!csrfToken) {

                alert('Token keamanan tidak ditemukan.');

                return;
            }


            // -------------------------------------------------
            // SIMPAN TAMPILAN TOMBOL AWAL
            // -------------------------------------------------

            const originalContent = button.innerHTML;


            // -------------------------------------------------
            // NONAKTIFKAN TOMBOL SEMENTARA
            // -------------------------------------------------

            button.disabled = true;

            button.innerHTML = `
                <span class="button-loading"></span>
                <span>Menambahkan...</span>
            `;


            try {

                // =================================================
                // REQUEST KE SERVER
                // =================================================

                const response = await fetch(
                    '/keranjang/tambah',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },

                        body: JSON.stringify({
                            menu_id: menuId
                        })
                    }
                );


                // =================================================
                // BACA RESPONSE
                // =================================================

                const data = await response.json();


                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message ||
                        'Menu gagal ditambahkan ke keranjang.'
                    );
                }


                // =================================================
                // UPDATE JUMLAH KERANJANG
                // =================================================

                jumlahKeranjang = data.jumlah;


                if (cartCount) {

                    cartCount.textContent =
                        jumlahKeranjang;

                }


                // =================================================
                // FEEDBACK BERHASIL
                // =================================================

                button.innerHTML = `
                    <span class="button-success-icon">✓</span>
                    <span>Ditambahkan</span>
                `;


                button.classList.add('added');


                // =================================================
                // KEMBALIKAN TOMBOL
                // =================================================

                setTimeout(function () {

                    button.innerHTML =
                        originalContent;

                    button.disabled = false;

                    button.classList.remove('added');

                }, 900);


            } catch (error) {

                // =================================================
                // ERROR
                // =================================================

                console.error(
                    'Error keranjang:',
                    error
                );


                alert(
                    error.message ||
                    'Menu gagal ditambahkan ke keranjang.'
                );


                // =================================================
                // KEMBALIKAN TOMBOL
                // =================================================

                button.innerHTML =
                    originalContent;

                button.disabled = false;

            }

        });

    });


    // =====================================================
    // TOMBOL KERANJANG
    // =====================================================

    if (cartButton) {

        cartButton.addEventListener(
            'click',
            function () {


                // -------------------------------------------------
                // KERANJANG KOSONG
                // -------------------------------------------------

                if (jumlahKeranjang <= 0) {

                    alert(
                        'Keranjang masih kosong. Silakan pilih menu terlebih dahulu.'
                    );

                    return;
                }


                // -------------------------------------------------
                // MENUJU RINGKASAN PESANAN
                // -------------------------------------------------

                window.location.href =
                    '/ringkasan-pesanan';

            }
        );

    }

});