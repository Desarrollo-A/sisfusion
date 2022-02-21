<style>
    #body_modal
    {
        width: 60%;
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
</style>
<div class="modal fade" id="avisoNovedades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-backdrop="static" >
    <div class="modal-dialog "  id="body_modal">
        <div class="modal-content" style="
            /*background-image: url('<?=base_url()?>dist/img/58064.jpg');
            background-size: cover*/
            ">
            <div class="container-fluid" style="min-height: 200px;background: #96843D">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 center-align">
                    <br>
                    <center><img src="<?=base_url()?>static/images/ciudadmaderas_white_2.png" class="img-responsive img-modal-aviso"></center>

                </div>
            </div>
            <div class="modal-header" style="background: #ddd">
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
<!--                    <i class="material-icons">clear</i>-->
<!--                </button>-->
                <h2 class="modal-title"></h2>

            </div>
            <div class="modal-body" style="background: #ddd">
                <div class="container-fluid" style="margin-top: -131px;background: #FFF;">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h2 class="center-block center-align" style="color:#333"></h2><br>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-8 hide">
                            <img src="<?=base_url()?>static/images/CMOF.png" class="img-responsive center-block" width="50%"><br>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p style="font-size: 1.5em;text-align: justify;line-height: 25px;padding: 0px 15px">
                                <b>Aviso importante</b>.<br>
                                <!--Aquí te indicamos la forma de hacerlo dependiendo del navegador en el que estés trabajando.<br>-->
                            </p>
                            <table width="100%" id="modal_table">
                                <tr>
                                    <td>
                                        <p style="text-align: justify;padding: 5px;font-size: 1.2em">
                                            Estamos realizando actualizaciones para ti, por favor, <b>no olvides</b>
                                            actualizar el caché del navegador con la siguiente conbinación de teclas <b>Ctrl + Shift + R</b>,
                                            esto con la finalidad de que puedas visualizar los cambios realizados, agradecemos tu comprensión, gracias.

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer" style="background: #ddd;">
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
