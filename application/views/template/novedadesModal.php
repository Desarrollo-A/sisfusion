<style>
    .modal .modal-dialog {
         margin-top: 0px !important;
    }
    #body_modal
    {
        /*width: 60%;*/
        text-align: center;
    }
    .img-modal-aviso
    {
        width: 40%;
    }
    #modal_table td:nth-child(1)
    {
        text-align: right;
        width: 5%;
    }
    #modal_table td:nth-child(2)
    {
        width: 60%;
    }
    #modal_table td img
    {
        width: 50px;
        height: 50px;
        padding: 5px;
    }
    #modal_table tr
    {
        padding-bottom: 10px;
        width: 100%;
    }
    #modal_table p
    {
        padding-top: 10px;
        text-align: center;
    }
    .btn-entiendo{
        border-radius: 25px;
        background: #FFF;
        color: #0b3e6f;
        animation-duration: 0.3s;
    }

    .btn-entiendo:hover{
        background: #0b3e6f;
        color: #FFF!important; ;
        animation-duration: 0.3s;
    }

    @media (max-width: 600px) {
        #body_modal
        {
            width: 90%;
        }
        .img-modal-aviso
        {
            width: 100%;
        }
        #modal_table td img
        {
            width: 50px;
            height: 50px;
            padding: 5px;
        }
        #modal_table td:nth-child(1)
        {
            text-align: right;
            width: 25%;
        }
        #modal_table td:nth-child(2)
        {
            width: 75%;
        }
    }

    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
</style>
<div class="modal fade" id="avisoNovedades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-backdrop="static" >
    <div class="modal-dialog"  id="body_modal">
        <div class="modal-content " style="
            /*background-image: url('<?=base_url()?>dist/img/58064.jpg');
            background-size: cover*/
            ">
            <div class="container-fluid hide" style="min-height: 180px;background: #96843D">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 center-align">
                    <br>
                    <center><img src="<?=base_url()?>static/images/ciudadmaderas_white_2.png" class="img-responsive img-modal-aviso"></center>

                </div>
            </div>
            <div class="modal-header hide" style="background: transparent">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h2 class="modal-title"></h2>

            </div>
            <div class="modal-body" style="background: transparent">
                <div class="container-fluid" style="background: #FFF;">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
                            <h2 class="center-block center-align" style="color:#333"></h2><br>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="text-align: center">
                            <img src="<?=base_url()?>static/images/bell-cdm.gif" style="width: 28%"><br>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <p style="font-size: 1.5em;line-height: 25px;padding: 0px 15px">
                                <b>Estimado usuario</b><br>
                                <!--Aquí te indicamos la forma de hacerlo dependiendo del navegador en el que estés trabajando.<br>-->
                            </p>
                            <table width="100%" id="modal_table">
                                <tr>
                                    <td>
                                        <p style="padding: 5px;font-size: 1.2em">
<!--                                            Estamos realizando actualizaciones para ti, por favor, <b>no olvides</b>-->
<!--                                            actualizar el caché del navegador con la siguiente conbinación de teclas <b>Ctrl + Shift + R</b>,-->
<!--                                            esto con la finalidad de que puedas visualizar los cambios realizados, agradecemos tu comprensión, gracias.-->

                                            En el área de T.I. creemos firmemente en la mejora continua, es por ello que a partir
                                            del próximo <b>lunes 3 de octubre</b> se homologará la información de nuestros Proyectos,
                                            Condominios y Lotes tomando como base las nomenclaturas que ya se manejan en el resto de
                                            nuestros Sistemas, esto ayudará a seguir haciendo mejoras en las herramientas actuales y ofrecerte
                                            un servicio más innovador y de la más alta calidad.
                                            <br><br><br>
                                            De antemano, agradecemos tu apoyo.<br>
                                            <div style="align-items: center;display:flex;justify-content: center">
                                                <input type="checkbox" name="no_mostrar_session" id="no_mostrar_session" style="margin: -1px 0 0;line-height: normal;">
                                                <label for="no_mostrar_session" style="color: #5a5a5a;font-size: 1.2rem" class="m-0"><b> &nbsp;&nbsp;No volver a mostrar aviso durante la sesión</b></label>
                                            </div>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>


                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 hide" style="text-align: left;padding-top: 15px;">
                                <input type="checkbox" name="no_mostrar_session" id="no_mostrar_session">
                                <label for="no_mostrar_session" style="color: #5a5a5a;font-size: 0.5em"><b>No volver a mostrar aviso durante la sesión</b></label>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                                <button type="button" class="btn btn-blueMaderas btn-entiendo" data-dismiss="modal" style="color: black" onclick="validaCheckSession()">Entiendo</button>
                            </div>







                </div>
            </div>
            <div class="modal-footer hide" style="background: #ddd;">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-6" style="text-align: left;">
                    <input type="checkbox" name="no_mostrar_session" id="no_mostrar_session">
                    <label for="no_mostrar_session" style="color: #5a5a5a">No volver a mostrar aviso durante la sesión</label>
                </div>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-6" style="text-align: right;">
                    <button type="button" class="btn btn-simple  btn-success" data-dismiss="modal" style="color: black" onclick="validaCheckSession()">Entiendo</button>
                </div>
                <!--<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Close</button>-->
            </div>
        </div>
    </div>
</div>
