/*
|--------------------------------------------------------------------------
| SMART CAFE
| Vanilla JavaScript
|--------------------------------------------------------------------------
*/


document.addEventListener(
    "DOMContentLoaded",
    function () {


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA CARD
        |--------------------------------------------------------------------------
        */

        const cards =
            document.querySelectorAll(
                ".access-card"
            );


        /*
        |--------------------------------------------------------------------------
        | ANIMASI CARD SAAT HALAMAN DIBUKA
        |--------------------------------------------------------------------------
        */

        cards.forEach(
            function (card, index) {

                card.style.opacity = "0";

                card.style.transform =
                    "translateY(15px)";


                setTimeout(
                    function () {

                        card.style.transition =
                            "opacity 0.45s ease, transform 0.45s ease";

                        card.style.opacity =
                            "1";

                        card.style.transform =
                            "translateY(0)";

                    },

                    120 + (index * 100)

                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        const buttons =
            document.querySelectorAll(
                ".access-button"
            );


        buttons.forEach(
            function (button) {


                /*
                |------------------------------------------------------------------
                | CURSOR
                |------------------------------------------------------------------
                */

                button.style.cursor =
                    "pointer";


                /*
                |------------------------------------------------------------------
                | EFEK KLIK
                |------------------------------------------------------------------
                */

                button.addEventListener(
                    "click",
                    function () {

                        button.classList.add(
                            "button-clicked"
                        );


                        setTimeout(
                            function () {

                                button.classList.remove(
                                    "button-clicked"
                                );

                            },

                            200
                        );

                    }
                );

            }
        );

    }
);