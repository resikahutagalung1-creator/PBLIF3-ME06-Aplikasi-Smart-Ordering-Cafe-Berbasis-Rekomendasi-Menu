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
        | ANIMASI CARD
        |--------------------------------------------------------------------------
        */

        cards.forEach(
            function (card, index) {

                card.style.opacity = "0";

                card.style.transform =
                    "translateY(20px)";


                setTimeout(
                    function () {

                        card.style.transition =
                            "opacity .5s ease, transform .5s ease";

                        card.style.opacity =
                            "1";

                        card.style.transform =
                            "translateY(0)";

                    },

                    150 + (index * 120)

                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | EFEK BUTTON
        |--------------------------------------------------------------------------
        */

        const buttons =
            document.querySelectorAll(
                ".access-button"
            );


        buttons.forEach(
            function (button) {

                button.addEventListener(
                    "mouseenter",
                    function () {

                        button.style.cursor =
                            "pointer";

                    }
                );

            }
        );


    }
);