<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="modal-delete" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" >
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="miModalBonos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="card-title"><b>Agregar bono</b></h4>
                </div>
                <form method="post" id="form_bonos">
                    <div class="modal-body">
                        <div class="form-group overflow-hidden m-0">
                            <label class="control-label">Puesto del usuario</label>
                            <select class="selectpicker select-gral m-0" name="roles" id="roles" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                <option value="7">Asesor</option>
                                <option value="9">Coordinador</option>
                                <option value="3">Gerente</option>
                                <option value="2">Sub director</option> 
                                <option value="20">Marketing</option>      
                            </select>
                            </div>
                            <div class="form-group m-0 overflow-hidden" id="users"></div>
                            <div class="form-group row m-0">
                            <div class="col-md-4">
                                <label class="control-label">Monto bono</label>
                                <input class="form-control input-gral monto" type="text" id="monto" onblur="verificar();" name="monto" maxlength="10" autocomplete="off" value="" onkeypress="return filterFloat(event,this);"/>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Meses a pagar</label>
                                <select class="selectpicker select-gral m-0" name="numeroP" id="numeroP" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Pago</label>
                                <input class="form-control input-gral" id="pago" type="text" name="pago" readonly>
                            </div>
                        </div>
                        <div class="form-group m-0">
                            <label class="control-label">Comentarios</label>
                            <textarea id="comentario" name="comentario" class="text-modal" rows="3" placeholder="Describa el motivo o detalle del bono." required="required"></textarea>
                        </div>
                        <div class="form-group m-0 d-flex justify-end">
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_bonos" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" id="form_bonos">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_abono">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
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
                            <i class="fas fa-gift fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Bonos<b> activos</b></h3>
                                <p class="card-title pl-1">(Bonos con pagos pendientes, una vez liquidados podrás consultarlos en el Historial de bonos)</p>
                            </div>
                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group d-flex justify-center align-center">
                                                <h4 class="title-tot center-align m-0">Total bonos aplicados:</h4>
                                                <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla_bonos" name="tabla_bonos">
                                        <thead>
                                            <tr>
                                                <th>ID BONO</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>MONTO BONO</th>
                                                <th>ABONADO</th>
                                                <th>PENDIENTE</th>
                                                <th>TOTAL PAGOS</th>
                                                <th>MONTO INDIVIDUAL</th>
                                                <th>IMPUESTO</th>
                                                <th>TOTAL A PAGAR</th>
                                                <th>FECHA DE REGISTRO</th>
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
</div>
</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/ventas/bonos.js"></script>
</body>