<div class="bg-azul">
    <div class="text-center">
        <img alt="logo"
             class="logo"
             src="<?=base_url()?>static/images/Logo_CM_white.png">
    </div>
    <div class="contenido">
        <p id="estimado-usuario">Estimado usuario</p>

        <?= $contenido ?>
    </div>
    <div class="footer text-center">
        <p id="aviso-privacidad">
            ¡Saludos!<br>
            Este correo fue generado de manera automática, te pedimos no respondas este correo, para cualquier duda o aclaración envía un correo a soporte@ciudadmaderas.com<br>
            Al ingresar tus datos aceptas la política de privacidad, términos y condiciones las cuales pueden ser consultadas en nuestro sitio www.ciudadmaderas.com/legal
        </p>

        <h6 id="leyenda-departamento" class="text-center">
            <?=date('Y')?> | Departamento TI
        </h6>
    </div>
</div>