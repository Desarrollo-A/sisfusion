<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
            .msj{
                z-index: 9999999;
            }
        </style>

        <!-- Modals -->
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
                <div class="modal-content" >
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas " id="modal_nuevas" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content text-center">
                    <div class="modal-header bg-red">
                        <img src="<?=base_url()?>static/images/preview.gif"  width="250" height="200">
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body d-flex"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles" name="roles" id="roles" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 

                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj2" style="color: red;"></b>
                            <b id="sumaReal"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                
                                    <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos2">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles2" name="roles2" id="roles2" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="loteorigen2">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible2" readonly name="idmontodisponible2" value="">
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto2" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                
                                    <button type="submit" id="btn_abonar2" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                            <img src="<?=base_url()?>static/images/preview.gif" width="250" height="200">
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END MODALS-->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">money_off</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div>
                                        <h3 class="card-title center-align" >Descuentos de comisiones</h3>
                                        <p class="card-title">(Descuentos aplicados a usuarios, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Nueva, sin solicitar')</p>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Total descuentos sin aplicar:</h4>
                                                    <p class="input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                                </div>
                                            </div>
                                            <?php if($this->session->userdata('id_rol') != 63){?>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Descuento de  pagos nuevos sin solicitar</button>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <button ype="button" class="btn-data-gral" data-toggle="modal" data-target="#miModal2">Descuento de  pagos en revisión contraloria</button>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>USUARIO</th>
                                                    <th>DESCUENTO</th>
                                                    <th>LOTE</th>
                                                    <th>MOTIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th>CREADO POR</th>
                                                    <th>FECHA DE CAPTURA</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div><!--main-panel close--> 
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>dist/js/funciones-generales.js"></script>
	<script src="<?=base_url()?>dist/js/controllers/comisiones/descuentos.js"></script>
</body>