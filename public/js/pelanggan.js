/*
|--------------------------------------------------------------------------
| SMART CAFE
| HALAMAN PELANGGAN
| Vanilla JavaScript
|--------------------------------------------------------------------------
*/


document.addEventListener(
    "DOMContentLoaded",
    function () {


        const form =
            document.getElementById(
                "customerForm"
            );


        const button =
            document.getElementById(
                "orderButton"
            );


        const namaInput =
            document.getElementById(
                "nama"
            );


        const mejaSelect =
            document.getElementById(
                "nomor_meja"
            );


        /*
        |--------------------------------------------------------------------------
        | CEK ELEMENT
        |--------------------------------------------------------------------------
        */

        if (
            !form ||
            !button ||
            !namaInput ||
            !mejaSelect
        ) {

            return;

        }



        /*
        |--------------------------------------------------------------------------
        | SUBMIT FORM
        |--------------------------------------------------------------------------
        */

        form.addEventListener(
            "submit",
            function (event) {


                const nama =
                    namaInput.value.trim();


                const nomorMeja =
                    mejaSelect.value;


                /*
                |--------------------------------------------------------------------------
                | VALIDASI NAMA
                |--------------------------------------------------------------------------
                */

                if (nama === "") {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | VALIDASI MEJA
                |--------------------------------------------------------------------------
                */

                if (nomorMeja === "") {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | UBAH BUTTON
                |--------------------------------------------------------------------------
                */

                button.disabled = true;


                button.innerHTML = `
                    <span>Menyimpan...</span>
                `;

            }
        );


    }
);