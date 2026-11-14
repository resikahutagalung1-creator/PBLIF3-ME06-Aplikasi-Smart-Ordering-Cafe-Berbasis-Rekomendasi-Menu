
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

        button.addEventListener('click', async function () {

            const menuId = button.dataset.menuId;

            if (!menuId) {
                alert('Menu tidak ditemukan.');
                return;
            }

            if (!csrfToken) {
                alert('Token keamanan tidak ditemukan.');
                return;
            }

            const originalContent = button.innerHTML;

            button.disabled = true;

            button.innerHTML = `
                <span class="button-loading"></span>
                <span>Menambahkan...</span>
            `;

            try {

                // REQUEST KE SERVER

                const response = await fetch('/keranjang/tambah', {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },

                    body: JSON.stringify({
                        menu_id: menuId
                    })
                });


                // BACA RESPONSE

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ||
                        'Menu gagal ditambahkan ke keranjang.'
                    );
                }


                // UPDATE JUMLAH KERANJANG

                jumlahKeranjang = data.jumlah;

                if (cartCount) {
                    cartCount.textContent = jumlahKeranjang;
                }


                // FEEDBACK BERHASIL

                button.innerHTML = `
                    <span class="button-success-icon">✓</span>
                    <span>Ditambahkan</span>
                `;

                button.classList.add('added');


                // KEMBALIKAN TOMBOL

                setTimeout(function () {

                    button.innerHTML = originalContent;

                    button.disabled = false;

                    button.classList.remove('added');

                }, 900);


            } catch (error) {

                console.error('Error keranjang:', error);

                alert(
                    error.message ||
                    'Menu gagal ditambahkan ke keranjang.'
                );

                button.innerHTML = originalContent;

                button.disabled = false;

            }

        });

    });


    // =====================================================
    // TOMBOL KERANJANG
    // =====================================================

    if (cartButton) {

        cartButton.addEventListener('click', function () {

            if (jumlahKeranjang <= 0) {

                alert(
                    'Keranjang masih kosong. Silakan pilih menu terlebih dahulu.'
                );

                return;
            }

            window.location.href = '/ringkasan-pesanan';

        });

    }

});