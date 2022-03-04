<body class="" id="mainBody">
<div class="wrapper ">

    <!-- MJ: HAY QUE VALIDAR LOS ROLES QUE TENDRÁN ACCESO A LA VISTA -->

    <?php
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    ?>

    <link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>dist/assets/css/documentation-styles.css" rel="stylesheet"/>

    <style>
        #documentFile {
            max-width: 100%;
            max-height: 100%;
            width: 100%;
            height: 700px;
        }
    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">content_copy</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="text-align: center">Documentación</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

<script>
    /*console.log("EL CHIDO EN CRM - " + "9eUyqm6wIMhTqelyemaxVQ==");
    let Sha256 = CryptoJS.AES;
    let Hex = CryptoJS.enc.Hex;
    let Utf8 = CryptoJS.enc.Utf8;
    let Base64 = CryptoJS.enc.Base64;
    let AES = CryptoJS.AES;

    let secret_key = 'S1ST3MA_6E5T0R_RH_C1UD4D_MAD3RA5';
    let secret_iv  = '8102cdmqsd0912vs';

    let key = Sha256(secret_key).toString(Hex).substr(0,32); // Use the first 32 bytes (see 2.)
    let iv = Sha256(secret_iv).toString(Hex).substr(0,16);

    // Encryption
    let output = AES.encrypt("yanoesesta", Utf8.parse(key), {
        iv: Utf8.parse(iv),
    }).toString(); // First Base64 encoding, by default (see 1.)

    var output2ndB64 = Utf8.parse(output).toString(Base64); // Second Base64 encoding (see 1.)
    console.log("EL QUE ME REGRESÓ - " + output2ndB64); // MWNjdVlVL1hBWGN2UFlpMG9yMGZBUT09

    // Decryption
    var decrypted = AES.decrypt(output, Utf8.parse(key), {
        iv: Utf8.parse(iv),
    }).toString(Utf8);
    console.log(decrypted); // test
     */

    const CryptoJS = require ('crypto-js'); // Código fuente AES de referencia js

    const key = CryptoJS.enc.Utf8.parse ("1234123412ABCDEF"); // número hexadecimal de 16 dígitos como clave
    const iv = CryptoJS.enc.Utf8.parse ('ABCDEF1234123412'); // Número hexadecimal como desplazamiento de clave

    // Método de descifrado
    function Decrypt(word) {
        let encryptedHexStr = CryptoJS.enc.Hex.parse(word);
        let srcs = CryptoJS.enc.Base64.stringify(encryptedHexStr);
        let decrypt = CryptoJS.AES.decrypt(srcs, key, { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 });
        let decryptedStr = decrypt.toString(CryptoJS.enc.Utf8);
        return decryptedStr.toString();
    }

    // Método de cifrado
    function Encrypt(word) {
        let srcs = CryptoJS.enc.Utf8.parse(word);
        let encrypted = CryptoJS.AES.encrypt(srcs, key, { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 });
        return encrypted.ciphertext.toString().toUpperCase();
    }

    export default {
        Decrypt ,
        Encrypt
    }
</script>


