<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .open{
        max-width: -webkit-fill-available;
    }
</style>
<body>

<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
    <?php include 'Modales/registrarPago.php' ?>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row" id="card1">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h3 class="card-title center-align">Pagos</h3>
                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idResidencial">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus">Lote</label>
                                                    <select name="idLote" id="idLote" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Cliente</label>
                                                <input id="nombreCliente" name="nombreCliente"
                                                       class="form-control input-gral " readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table class="table-striped table-hover hide" id="tablaPlanPagos" name="tablaPlanPagos">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>PLAN DE PAGO</th>
                                                <th>PLAZO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="row hide" id="card2">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align">Descargar inventario de lotes por sede</h3>
                                        <p class="card-title pl-1"></p>
                                    </div>
                                    <div  class="toolbar">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-md-4 form-group">
                                                    <div class="form-group select-is-empty">
                                                        <label class="control-label">Sedes por proyecto</label>
                                                        <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                                data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN"
                                                                data-size="7" data-live-search="true" required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="tabla_inventario_contraloria" name="tabla_inventario_contraloria" class="table-striped table-hover hide">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>PRECIO DE LISTA</th>
                                                <th>TOTAL CON DESCUENTOS</th>
                                                <th>M2</th>
                                                <th>REFERENCIA</th>
                                                <th>MESES SIN INTERESES</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>ESTATUS</th>
                                                <th>ESTATUS DE CONTRATACION</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>COMENTARIO</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>FECHA DE VALIDACIÓN DEL ENGANCHE</th>
                                                <th>FECHA DE APERTURA</th>
                                                <th>CANTIDAD DEL ENGANCHE PAGADO</th>
                                                <th>CLIENTE</th>
                                                <th>COMENTARIO DE NEODATA</th>
                                                <th>FECHA APERTURA</th>
                                                <th>APARTADO DE REUBICACIÓN</th>
                                                <th>FECHA ALTA</th>
                                                <th>VENTA COMPARTIDA</th>
                                                <th>UBICACIÓN DE LA VENTA</th>
                                                <th>TIPO PROCESO</th>
                                                <th>REUBICACIÓN</th>
                                                <th>FECHA DE REUBICACIÓN</th>
                                                <th>SEDE</th>
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
    <?php $this->load->view('template/footer_legend');?>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/planesPagos/pagos.js"></script>

</body>