<div class="encabezadoBox">
    <div>
        <h3 class="card-title center-align" >Descuentos de comisiones</h3>
        <p class="card-title">(Descuentos aplicados a usuarios, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Nueva, sin solicitar')</p>
    </div>
</div>
<div class="toolbar">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div class="form-group text-center">
                    <h4 class="title-tot center-align m-0">Total descuentos sin aplicar:</h4>
                    <i class="fas fa-money-bill fa-2x " style=" color: #0067d4; padding-top:20px;"></i>
                    <p class="input-tot pl-1" style=" padding-top:20px;" name="totalpv" id="totalp">$0.00</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-4 " style="padding-top:35px; margin-bottom:2px"></div>
            <div class="col-xl-4 col-md-4 mb-4 " style="padding-top:35px; margin-bottom:2px"></div>
            <?php if($this->session->userdata('id_rol') != 63){?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Descuento de  pagos nuevos sin solicitar</button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group d-flex justify-center align-center">
                    <!-- <button ype="button" class="btn-data-gral" data-toggle="modal" data-target="#miModal2"></button> -->
                    <buttons Type="button"  data-toggle="modal" data-target="#miModal2"><i class="fas fa-plus"></i> Descuento de  pagos en revisión contraloria</buttons>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>