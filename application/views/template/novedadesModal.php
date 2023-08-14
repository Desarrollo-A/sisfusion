<style>
    #body_modal{
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
    <div class="modal-dialog modal-lg"  id="body_modal">
        <div class="modal-body">
            <div class="container-fluid" style="background: #FFF; border-radius: 10px;">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <img src="<?=base_url()?>static/images/bell-cdm.gif" style="width: 10%"><br>
                    </div>
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 50px; ">
                        <h4><b>Aviso</b></h4>
                        <p>
                            Cambio de fecha en el corte de comisiones

                        </p>
                        <p style="text-align: justify">
                            <br>
                            Estimado comisionista. Esperamos que este mensaje le
                            encuentre bien. Queremos informarle sobre una actualización importante
                            relacionada con el corte de comisiones. Por razones estratégicas se decidió
                            realizar un cambio en la fecha del corte de comisiones. Por esta ocasión, el
                            corte de comisiones se llevará a cabo el día miércoles 9 y jueves 10 (hasta dos
                            de la tarde) del presente mes.
                            <br><br>
                            Queremos asegurarnos de que esté completamente informado
                            sobre esta modificación para evitar cualquier confusión o malentendido. Si
                            tiene alguna pregunta o inquietud con respecto a este cambio, no dude en
                            ponerse en contacto con su supervisor directo. Estamos aquí para brindarle toda
                            la información y el apoyo que necesite durante esta transición.
                            <br><br>
                            Agradecemos su comprensión y colaboración ante este cambio,
                            y confiamos en que, juntos, continuaremos fortaleciendo el éxito de nuestra
                            empresa.</p>

                        <p style="font-size: small">Recuerda actualizar cache con el comando <b>CTRL + SHIFT + R</b></p>
                        <div class="d-flex justify-center align-center mt-1">
                            <input type="checkbox" name="no_mostrar_session" id="no_mostrar_session" style="margin: -1px 0 0;line-height: normal;">
                            <label for="no_mostrar_session" style="color: #5a5a5a;font-size: 1.2rem " class="m-0"><b>No volver a mostrar aviso durante la sesión</b></label>
                        </div>
                    </div>
                </div>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-blueMaderas btn-entiendo" data-dismiss="modal" style="color: black" onclick="validaCheckSession()">Acepto</button>
                </div>
            </div>
        </div>
    </div>
</div>
