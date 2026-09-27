document.addEventListener("DOMContentLoaded", function () {

    const tombolProses = document.querySelectorAll(".btn-proses");
    const tombolSelesai = document.querySelectorAll(".btn-selesai");
    const tombolTolak = document.querySelectorAll(".btn-tolak");

    tombolProses.forEach(function (button) {
        button.addEventListener("click", function () {
            alert("Pesanan sedang diproses.");
        });
    });

    tombolSelesai.forEach(function (button) {
        button.addEventListener("click", function () {
            alert("Pesanan berhasil diselesaikan.");
        });
    });

    tombolTolak.forEach(function (button) {
        button.addEventListener("click", function () {
            const konfirmasi = confirm(
                "Apakah kamu yakin ingin menolak pesanan ini?"
            );

            if (konfirmasi) {
                alert("Pesanan ditolak.");
            }
        });
    });

});