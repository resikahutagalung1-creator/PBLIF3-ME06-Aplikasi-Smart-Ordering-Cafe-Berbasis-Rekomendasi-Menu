
document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // ELEMEN STATUS PESANAN
    // =====================================

    const orderTracking = document.getElementById('orderTracking');

    if (!orderTracking) return;

    const pesananId = orderTracking.dataset.pesananId;

    const orderStatus = document.getElementById('orderStatus');

    const orderStatusMessage =
        document.getElementById('orderStatusMessage');

    const timelineItems =
        document.querySelectorAll('.timeline-item');

    const cookingCaption =
        document.getElementById('cookingCaption');

    const cookingScene =
        document.getElementById('cookingScene');

    const cancelledMessage =
        document.getElementById('cancelledMessage');

    const finishedMessage =
        document.getElementById('finishedMessage');


    if (!pesananId) return;


    // =====================================
    // PESAN UNTUK SETIAP STATUS
    // =====================================

    const statusMessages = {

        'Menunggu':
            'Pesanan sedang menunggu konfirmasi kasir.',

        'Diproses':
            'Pesanan telah diterima dan sedang disiapkan oleh koki.',

        'Hampir Siap':
            'Pesanan hampir selesai disiapkan.',

        'Siap Disajikan':
            'Pesanan siap disajikan kepada Anda.',

        'Selesai':
            'Pesanan telah selesai. Silakan menikmati pesanan Anda.',

        'Dibatalkan':
            'Pesanan Anda telah dibatalkan.'

    };


    const cookingMessages = {

        'Menunggu':
            'Pesanan Anda sedang menunggu konfirmasi kasir.',

        'Diproses':
            'Koki sedang memasak pesanan Anda.',

        'Hampir Siap':
            'Sedikit lagi! Pesanan Anda hampir siap.',

        'Siap Disajikan':
            'Pesanan siap diberikan kepada Anda.',

        'Selesai':
            'Pesanan selesai. Selamat menikmati!',

        'Dibatalkan':
            'Pesanan tidak dilanjutkan karena telah dibatalkan.'

    };


    // =====================================
    // UPDATE TIMELINE
    // =====================================

    function updateTimeline(status) {

        /*
         * Menunggu       = 0
         * Diproses       = 2
         * Hampir Siap    = 3
         * Siap Disajikan = 4
         * Selesai        = 5
         */

        const progress = {

            'Menunggu': 0,

            'Diproses': 2,

            'Hampir Siap': 3,

            'Siap Disajikan': 4,

            'Selesai': 5,

            'Dibatalkan': 0

        };

        const currentStep = progress[status] ?? 0;


        timelineItems.forEach(function (item) {

            const step = Number(item.dataset.step);

            const circle =
                item.querySelector('.timeline-circle');

            item.classList.remove('completed', 'active');


            // Tahap yang sudah dilewati
            if (step <= currentStep) {

                item.classList.add('completed');

                circle.textContent = '✓';

            } else {

                circle.textContent = step;

            }


            // Tahap yang sedang berjalan
            if (
                step === currentStep &&
                status !== 'Selesai'
            ) {

                item.classList.add('active');

            }

        });


        // Pesan ilustrasi
        if (cookingCaption) {

            cookingCaption.textContent =
                cookingMessages[status] ??
                'Memperbarui status pesanan...';

        }


        // Pesan utama
        if (orderStatusMessage) {

            orderStatusMessage.textContent =
                statusMessages[status] ?? 'Status pesanan diperbarui.';

        }


        // Status pesanan
        if (orderStatus) {

            orderStatus.textContent = status;

        }


        // Tampilkan atau sembunyikan ilustrasi
        if (cookingScene) {

            cookingScene.hidden =
                status === 'Dibatalkan';

        }


        // Pesan pembatalan
        if (cancelledMessage) {

            cancelledMessage.hidden =
                status !== 'Dibatalkan';

        }


        // Pesan selesai
        if (finishedMessage) {

            finishedMessage.hidden =
                status !== 'Selesai';

        }

    }


    // =====================================
    // CEK STATUS PESANAN DARI DATABASE
    // =====================================

    async function cekStatusPesanan() {

        try {

            const response = await fetch(
                `/pesanan/${encodeURIComponent(pesananId)}/status`,
                {
                    method: 'GET',

                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );


            if (!response.ok) {

                console.error(
                    'Gagal mengambil status pesanan.'
                );

                return;

            }


            const data = await response.json();


            if (!data.success) return;


            const status = data.status;


            // Perbarui seluruh tampilan
            updateTimeline(status);


            // Hentikan polling jika sudah selesai
            // atau dibatalkan
            if (
                status === 'Selesai' ||
                status === 'Dibatalkan'
            ) {

                if (intervalStatus) {

                    clearInterval(intervalStatus);

                }

            }

        } catch (error) {

            console.error(
                'Gagal mengecek status pesanan:',
                error
            );

        }

    }


    // =====================================
    // TAMPILKAN STATUS AWAL
    // =====================================

    updateTimeline(orderTracking.dataset.status);


    // =====================================
    // PERBARUI OTOMATIS SETIAP 4 DETIK
    // =====================================

    let intervalStatus = setInterval(
        cekStatusPesanan,
        4000
    );


    // Cek langsung ketika halaman dibuka
    cekStatusPesanan();

});