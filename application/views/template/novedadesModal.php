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
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0 50px">
                        <h4><b>Aviso</b></h4>
                        <p>
                        Estimado colaborador el día de hoy, 14 de junio, estaremos aplicando una mejora en nuestro sistema. Esta actualización tiene como objetivo optimizar el rendimiento y la eficiencia de algunas operaciones.
<br>
Será necesario realizar una breve interrupción del servicio. Dicha interrupción está programada para comenzar a las <b>8:00 p.m.</b> y se espera que tenga una duración de aproximadamente una hora.<br><br> Durante este período, será posible que se vean intermitencias en el sistema, agradeceremos tu apoyo y comprensión en el transcurso de la implementación. 
                        </p>
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
