<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="movimiento-modal" tabindex="-1" role="dialog" aria-labelledby="movimientoModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h3 class="modal-title">Cambio de estatus <small id="total-pagos"></small></h3>
                    </div>
                    <form method="post" class="row" id="estatus-form" autocomplete="off">
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="div-options" class="radio_container w-100"></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group is-empty">
                                    <textarea class="text-modal" name="comentario" id="comentario" rows="3" placeholder="Escriba el comentario..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial <b>general estatus</b></h3>
                                    <p class="card-title pl-1">(Listado de todos los pagos por proyecto y estatus)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group overflow-hidden">
                                                    <label class="m-0" for="tipo_general">Tipo  (<span class="isRequired">*</span>)</label>
                                                    <select class="selectpicker select-gral" id="tipo_general" name="tipo_general[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group overflow-hidden">
                                                    <label class="m-0" for="proyecto">Proyecto (<span class="isRequired">*</span>)</label>
                                                    <select name="catalogo_general" id="catalogo_general" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                    <?php
                                                    if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="0"> 
                                                        <?php 
                                                    }
                                                    else{
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="1">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group overflow-hidden">
                                                    <label class="m-0" for="estatus_general">Estatus (<span class="isRequired">*</span>)</label>
                                                    <select class="selectpicker select-gral" id="estatus_general" name="estatus[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0" for="puesto_general"> Puesto</label>
                                                    <select class="selectpicker select-gral" id="puesto_general" name="puesto_general" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3  hidden" id="add_gerente">
                                                <div class="form-group ">
                                                    <label class="m-0" for="elegir_gerente"> Gerente</label>
                                                    <select class="selectpicker select-gral seleccionar_puesto" id="elegir_gerente" name="elegir_gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3  hidden" id="add_asesor">
                                                <div class="form-group ">
                                                    <label class="m-0" for="elegir_asesor"> Asesor</label>
                                                    <select class="selectpicker select-gral seleccionar_puesto" id="elegir_asesor" name="elegir_asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3  hidden" id="add_coordinador">
                                                <div class="form-group ">
                                                    <label class="m-0" for="elegir_coordinador"> Coordinador</label>
                                                    <select class="selectpicker select-gral seleccionar_puesto" id="elegir_coordinador" name="elegir_coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>

                                            




                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO LOTE</th>
                                                    <th>TOTAL COMISIÓN</th>
                                                    <th>PAGO CLIENTE</th>
                                                    <th>DISPERSADO</th>
                                                    <th>PAGADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>DETALLE</th>
                                                    <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend');?>
        </div>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_estatus.js"></script>
</body>