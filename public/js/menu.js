document.addEventListener('DOMContentLoaded', function () {

    const orderButtons = document.querySelectorAll('.order-button');
    const cartCount = document.getElementById('cartCount');
    const cartButton = document.getElementById('cartButton');

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    let jumlahKeranjang = parseInt(
        cartCount?.textContent || '0',
        10
    );

    // =====================================================
    // TAMBAH MENU KE KERANJANG
    // =====================================================

    orderButtons.forEach(function (button) {

        button.addEventListener('click', async function (event) {

            // Jangan sampai klik tombol ikut membuka detail
            event.preventDefault();
            event.stopPropagation();

            const menuId = this.dataset.menuId;

            if (!menuId) {
                alert('Menu tidak ditemukan.');
                return;
            }

            if (!csrfToken) {
                alert('Token keamanan tidak ditemukan.');
                return;
            }

            const originalContent = this.innerHTML;

            this.disabled = true;

            try {

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

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ||
                        'Menu gagal ditambahkan ke keranjang.'
                    );
                }

                jumlahKeranjang = data.jumlah;

                if (cartCount) {
                    cartCount.textContent = jumlahKeranjang;
                }

                this.innerHTML = `
                    <span>✓</span>
                    <span>Ditambahkan</span>
                `;

                setTimeout(function () {

                    button.innerHTML = originalContent;
                    button.disabled = false;

                }, 800);

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

            window.location.href =
                '/ringkasan-pesanan';
        });

    }

});