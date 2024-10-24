<!-- <link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"> -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>


        <style type="text/css">

            ul.timeline {
                list-style-type: none;
                position: relative;
            }

            ul.timeline:before {
                content: ' ';
                background: #d4d9df;
                display: inline-block;
                position: absolute;
                left: 29px;
                width: 2px;
                height: 80%;
                z-index: 400;
            }

            ul.timeline>li {
                margin: 20px 0;
                padding-left: 60px;
            }

            ul.timeline>li:before {
                content: ' ';
                background: white;
                display: inline-block;
                position: absolute;
                border-radius: 50%;
                border: 3px solid #22c0e8;
                left: 20px;
                width: 20px;
                height: 20px;
                z-index: 400;
            }
        </style>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Descuentos de resguardos</h3>
                                    <p class="card-title pl-1">(Descuentos aplicados a directivos, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Enviada a resguardo personal'.)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Total resguardo:</h4>
                                                <p class="category input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Ingresos extras:</h4>
                                                <p class="category input-tot pl-1" name="totalx" id="totalx">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Saldo disponible:</h4>
                                                <p class="category input-tot pl-1" name="totalpv3" id="totalp3">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Descuentos aplicados:</h4>
                                                <p class="category input-tot pl-1" name="totalpv2" id="totalp2">$0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row aligned-row mb-2">
                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                            <div class="label-floating select-is-empty">
                                                <label for="proyecto">Directivo</label>
                                                <select name="filtro33" id="filtro33"  class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                                        title="Selecciona directivo" data-size="7" title ="SELECCIONA UNA OPCIÓN" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end">   
                                        <?php if($this->session->userdata('id_rol') == "17"){ ?> 
                                                <button type="button" class="btn-gral-data" data-toggle="modal" id="aplicar_retiro">APLICAR RETIRO</button>
                                                <?php } ?>
                                            </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="table-responsive">
                                        <table id="tabla_descuentos" name="tabla_descuentos" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>USUARIO</th>
                                                        <th>$ DESCUENTO</th>
                                                        <th>MOTIVO</th>
                                                        <th>ESTATUS</th>
                                                        <th>CREADO POR</th>
                                                        <th>FECHA CAPTURA</th>
                                                        <th>OPCIONES</th>
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
        <?php $this->load->view('template/footer_legend'); ?>

        <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_espera_uno">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal-delete" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_log" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="bod"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Retiros</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles select-gral " name="roles" id="roles"  title ="SELECCIONA UNA OPCIÓN" required>
                                    <option value="2">Sub director</option>
                                    <option value="1">Director</option>
                                </select>
                            </div>
                            <div class="form-group" id="users"><label class="label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required select-gral" title ="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="div_opcion">
                                <label class="label">Opción</label>
                                <select id="opc" name="opc" class="selectpicker form-control select-gral ng-invalid ng-invalid-required" title ="SELECCIONA UNA OPCIÓN">
                                    <option value="1">RETIRO</option>
                                    <option value="2">INGRESO EXTRA</option>
                                </select>
                            </div>
                            <div class="form-group row" id="div_montos">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label" id="labelmonto1">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label" id="labelmonto2">Monto a descontar</label>
                                        <input class="form-control" type="number" min="0" step="any" id="monto1" name="monto" required>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group" id="div_motivo">
                                <label class="label" id="texto_motivo">Mótivo</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" ></textarea> 
                            </div>

                        </div>
                        <div class="modal-footer">
                                <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="modal_descuentos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?= base_url() ?>static/images/preview.gif" width="250" height="200"></center>
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
    <!--main-panel close-->
   
</body>
<?php $this->load->view('template/footer'); ?>

<script src="<?=base_url()?>dist/js/controllers/resguardos/retiros_comisiones.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

