<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>  
        <div class="modal fade" id="capturaTraspasoModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center" id="mainLabelTextTraspaso"></h5>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label>Comentario</label>
                            <textarea class="text-modal" id="comentarioTraspaso" rows="3"></textarea>
                        </div>
                        <input type="text" class="hide" id="idLoteOrigen">
                        <input type="text" class="hide" id="idLoteDestino">
                        <input type="text" class="hide" id="nombreLoteDestino">
                        <input type="text" class="hide" id="idClienteDestino">
                        <input type="text" class="hide" id="idCondominioDestino">
                        <input type="text" class="hide" id="tipo">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label id="tvLbl">Cantidad traspasada</label>
                            <input pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" class="form-control input-gral" name="cantidadTraspaso" id="cantidadTraspaso" oncopy="return false" onpaste="return false" onkeypress="return soloNumeros(event)" placeholder="$0.00">
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="guardarTraspaso" class="btn btn-primary"> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'historialMovimientos.php' ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte de estatus por lote</h3>
                                </div>
                                <div class="material-datatables">
                                    <table id="tablaTraspasoAportaciones" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE PROCESO</th>
                                                <th>MOVIMIENTO</th>
                                                <th>PROYECTO ORIGEN</th>
                                                <th>CONDOMINIO ORIGEN</th>
                                                <th>LOTE ORIGEN</th>
                                                <th>REFERENCIA ORIGEN</th>                                                
                                                <th>ID LOTE ORIGEN</th>
                                                <th>PROYECTO DESTINO</th>
                                                <th>CONDOMINIO DESTINO</th>
                                                <th>LOTE DESTINO</th>
                                                <th>REFERENCIA DESTINO</th>                                                
                                                <th>ID LOTE DESTINO</th>                                                
                                                <th>ESTATUS PROCESO</th>
                                                <th>ESTATUS ADMINISTRACIÓN</th>
                                                <th>FECHA ÚLTIMO MOVIMIENTO</th>
                                                <th>FECHA ESTATUS 2</th>
                                                <th>ASESOR</th>
                                                <th>GERENTE</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/reestructura/reporteEstatus.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/historialMovimientos.js"></script>
