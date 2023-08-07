<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php
    if($this->session->userdata('id_rol')=="17")//contraloría
    {
        $this->load->view('template/sidebar');
    }
    else
    {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>
 <style>
     .col-lg-6 select:required + label {
            display: block;
            color: red;
        }
</style> 
    <!-- Modals -->
    <div class="modal fade " id="modalConfirmRegExp" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <h3>¿Estás seguro que desea regresar el expediente <b id="loteName"></b> ?</h3>
                        <p><small>El cambio no podrá ser revertido.</small></p>
                        <input type="hidden" value="" id="tempIDC" name="tempIDC">
                        <input type="hidden" value="" id="idLote" name="idLote">
                        <input type="hidden" value="" id="tipoV" name="tipoV">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary acepta_regreso">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="modalEditExp" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="formEdit">
                    <div class="modal-body">
                        <div class="modal-body text-center p-0">
                            <h5>¿Estás seguro que desea editar el expediente <b id="loteName"></b> ?</h5>
                            <p><small>El cambio no podrá ser revertido.</small></p>
                        </div>
                        <input type="hidden" name="idCliente" id="idCliente">
                        <div id="camposEditar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Regresar expediente</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label">Proyecto</label>
                                            <select name="residencial" id="residencial"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un proyecto" data-size="7"
                                                    data-container="body" 
                                                    required>
                                            </select>
                                            <input type="hidden" name="accion" id="accion" value="0">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label">Condominio</label>
                                            <select id="condominio" name="condominio"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un condominio" data-size="7" 
                                                    data-container="body"
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label">Lote</label>
                                            <select id="lotes" name="lotes"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un lote" data-size="7" 
                                                    data-container="body"
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                        <table id="tableClient"
                                               class="table-striped table-hover hide">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>ID LOTE</th>
                                                <th>LOTE</th>
                                                <th>ID ESTATUS LOTE</th>
                                                <th>TOTAL NETO</th>
                                                <th>TOTAL NETO 2</th>
                                                <th>TOTAL VALIDADO</th>
                                                <th>ESTATUS 8</th>
                                                <th>VALIDACIÓN ENGANCHE</th>
                                                <th>TIPO VENTA</th>
                                                <th>REGISTRO COMISIÓN</th>
                                                <th>GERENTE</th>
                                                <th>COORDINADOR</th>
                                                <th>ASESOR</th>
                                                <th>CLIENTE</th>
                                                <th>APARTADO</th>
                                                <th>CLIENTE ESTATUS</th>
                                                <th>LOTE ESTATUS</th>
                                                <th>LUGAR PROSPECCIÓN</th>
                                                <th>ACCIÓN</th>
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
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/js/funciones-generales.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/js/controllers/contraloria/checarExpediente.js"></script>


