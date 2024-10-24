<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="modalPausarBono" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="formPausarBono">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="miModal_casas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Descuentos</h4>
                </div>
                <form method="post" id="form_descuentos_casas">
                    <div class="modal-body">
                        <div class="form-group overflow-hidden" id="users_casas">
                            <label class="control-label">Usuario</label>
                            <select id="usuarioid_casas" name="usuarioid_casas" class="selectpicker select-gral m-0 directorSelect" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7"  data-live-search="true" data-container="body" required></select>
                        </div>
                        <div class="form-group mt-0" id="loteorigen_casas">
                            <label class="control-label">Lote origen (<span class="isRequired">*</span>)</label>
                            <select id="idloteorigen_casas"  name="idloteorigen_casas[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                        </div>
                        <b id="msj2" style="color: red;"></b>
                        <div class="form-group row mt-0">
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label class="control-label">Monto disponible</label>
                                    <input class="form-control input-gral" type="text" id="idmontodisponible_casas" readonly name="idmontodisponible_casas" value="">
                                </div>
                                <div id="montodisponible"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Monto a descontar</label>
                                    <input class="form-control input-gral" type="text" id="monto_casas" name="monto_casas" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-0">
                            <label class="control-label">Mótivo de descuento (<span class="isRequired">*</span>)</label>
                            <textarea id="comentario_casas" name="comentario_casas" class="text-modal" rows="3" required></textarea>
                        </div>
                        <div class="form-group d-flex justify-end">
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_abonar_casas" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="seeInformationModal_casas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons" onclick="cleanComments_casas()">clear</i></button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <div id="nameLote_casas" class="text-center"></div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab_casas">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="comments-list_casas"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments_casas()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="myModalEnviadas_casas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card no-shadow m-0">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="tab-pane active" id="nuevas-1_casas">
                                        <div class="encabezadoBox">
                                            <h3 class="card-title center-align" >Comisiones nuevas <b>Casas</b></h3>
                                            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago para el área de CASAS)</p>
                                        </div>
                                        <div class="toolbar">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group d-flex justify-center align-center m-0">
                                                            <h4 class="title-tot center-align m-0">Disponible sin impuesto:</h4>
                                                            <p class="input-tot pl-1" name="myText_nuevas_casas" id="myText_nuevas_casas">$0.00</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group d-flex justify-center align-center m-0">
                                                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                            <p class="input-tot pl-1" name="autorizar_intmex" id="autorizar_intmex">$0.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_plaza_1_casas" name="tabla_plaza_1_casas">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>ID USUARIO</th>
                                                                <th>USUARIO</th>
                                                                <th>SEDE DEL USUARIO</th>
                                                                <th>EMPRESA</th>
                                                                <th>IMPUESTO %</th>
                                                                <th>ABONO DISPERSADO</th>
                                                                <th>DESCUENTO</th>
                                                                <th>A PAGAR</th>
                                                                <th>FORMA DE PAGO</th>
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
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/pagos/casas/casas_bonos.js"></script>
</body>