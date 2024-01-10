<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade scroll-styles" id="modalDevolucionUM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Aplicar devolución</h3>
                    <div class="col-lg-12 form-group m-1" id="mensajeConfirmacion" name="mensajeConfirmacion"></div>
                    <div class="col-lg-12 form-group m-1" id="montosDescuento" name="montosDescuento"></div>
                </div>
                <div class="modal-body">
                    <form id="form_devolucion" name="form_devolucion" method="post">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 form-group m-0">
                                <label class="label-gral m-0">Mótivo</label>
                                <textarea class="text-modal" type="text" name="comentarioDevolucion" id="comentarioDevolucion" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                            </div>
                            <input class="form-control" type="hidden" id="pagoDevolver" name="pagoDevolver" value="">
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="btn_devolucion" class="btn btn-primary"> Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" >Reporte mensual de descuentos <b>Universidad Maderas</b></h3>
                            </div>
                            <div class="toolbar">
                                <div class="container-fluid">
                                    <div class="row aligned-row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <h4 class="title-tot center-align m-0">
                                                Total
                                                <p class="category input-tot pl-1" id="totalGeneral"></p>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group is-empty">
                                        <label class="control-label" for="anio">Año (<span class="isRequired">*</span>)</label>
                                        <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                    </div>
                                </div>
                                    <div class="col-lg-6">
                                        <div class="form-group is-empty">
                                        <label class="control-label" for="mes">Mes</label>
                                        <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"  required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla-historial" name="tabla-historial">
                                        <thead>
                                            <tr>
                                                <th>ID PAGO</th>
                                                <th>LOTE</th>  
                                                <th>EMPRESA</th>          
                                                <th>ID USUARIO</th>
                                                <th>NOMBRE</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
                                                <th>MONTO DESCUENTO</th>
                                                <th>CREADO POR</th>
                                                <th>FECHA DESCUENTO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/universidad/reporte_mensual.js"></script>
</body>
