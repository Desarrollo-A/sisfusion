<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_informacion" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h3 class="text-center">Detalle</h3>
                    </div>
                    <div class="modal-body">
                        <div class="material-datatables">
                            <div class="form-group">
                                <table class="table-striped table-hover" id="tabla_modal" name="tabla_modal">
                                    <thead>
                                        <tr>
                                            <th>ID PAGO</th>
                                            <th>LOTE</th>
                                            <th>MONTO</th>
                                            <th>FECHA DE APLICADO</th>
                                            <th>MONTO ANTERIOR</th>
                                            <th>ESTATUS</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <?php if ($this->session->userdata('id_rol') != 66) { ?>
                            <li class="active">
                                <a href="#solicitudesCRM" role="tab" data-toggle="tab">Historial CRM</a>
                            </li>
                            <li>
                                <a href="#solicitudesCanceladas" role="tab" data-toggle="tab">Historial canceladas</a>
                            </li>
                            <?php }?>
                            <?php if(in_array($this->session->userdata('id_rol'), array(1, 2, 3, 7, 9, 66))) { ?>
                                <li>
                                    <a href="#solicitudesSUMA" role="tab" data-toggle="tab">Historial SUMA</a>
                                </li>
                                <li>
                                    <a href="#historialDescuentos" role="tab" data-toggle="tab" onclick="consultarHistorialDescuentos()">Historial descuentos</a>
                                </li>

                                <!-- <li>
                                    <a href="#solicitudesOOAM" role="tab" data-toggle="tab">Historial OOAM</a>
                                </li> -->
                            <?php } ?>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane <?php if($this->session->userdata('id_rol') != 66){ ?> active <?php } ?>" id="solicitudesCRM">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <h3 class="card-title center-align">Historial activos</h3>
                                                    <p class="card-title pl-1">(Listado de todos los pagos aplicados, en proceso de lotes contratados y activos)
                                                        <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="toolbar"> 
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0">
                                                        <div class="form-group select-is-empty overflow-hidden">
                                                            <label class="control-label">Año</label>
                                                            <select name="ano_historial" id="ano_historial" class="selectpicker select-gral" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                for ($i = 2019; $i <= 2024; $i++) {
                                                                    $yearName  = $i;
                                                                    echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0 overflow-hidden">
                                                        <div class="form-group select-is-empty">
                                                            <label for="proyecto" class="control-label">Proyecto</label>
                                                            <select name="catalogo_historial" id="catalogo_historial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hide" id="tabla_historialGral" name="tabla_historialGral">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>REFERENCIA</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGO DEL CLIENTE</th>
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

                                        <div class="tab-pane" id="solicitudesCanceladas">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <h3 class="card-title center-align">Historial canceladas</h3>
                                                    <p class="card-title pl-1">(Listado de todos los pagos aplicados, en proceso de lotes cancelados con recisión)
                                                        <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="proyecto">Año</label>
                                                            <select name="ano_canceladas" id="ano_canceladas" class="selectpicker select-gral" data-container="body" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                for ($i = 2019; $i <= 2025; $i++) {
                                                                    $yearName  = $i;
                                                                    echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                        <div class="form-group">
                                                            <label class="control-label" for="proyecto">Proyecto</label>
                                                            <select name="catalogo_canceladas" id="catalogo_canceladas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required><option value="0">Seleccione todo</option></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hide" id="tabla_comisiones_canceladas" name="tabla_comisiones_canceladas">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>REFERENCIA1</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGO DEL CLIENTE</th>
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

                                        <?php if(in_array($this->session->userdata('id_rol'), array(1, 2, 3, 7, 9, 66))) { ?>
                                        <div class="tab-pane <?php if($this->session->userdata('id_rol') == 66){ ?> active <?php } ?>" id="solicitudesSUMA">
                                                <div class="encabezadoBox">
                                                    <h3 class="card-title center-align">Historial general SUMA
                                                        <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="toolbar">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 overflow-hidden">
                                                            <div class="form-group select-is-empty">
                                                                <label for="anio_suma" class="control-label">AÑO</label>
                                                                <select name="anio_suma" id="anio_suma" class="selectpicker select-gral" data-style="btn" data-container="body" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover hide" id="tabla_comisiones_suma" name="tabla_comisiones_suma">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>NOMBRE</th>
                                                                    <th>SEDE</th>
                                                                    <th>FORMA DE PAGO</th>
                                                                    <th>TOTAL DE LA COMISIÓN</th>
                                                                    <th>IMPUESTO</th>
                                                                    <th>% COMISÓN</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="historialDescuentos">
                                                <div class="encabezadoBox">
                                                    <div class="row">
                                                        <h3 class="card-title center-align">Historial descuentos</h3>
                                                        <p class="card-title pl-1">Este es un listado de todos los descuentos que te han aplicado.</p>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover" id="tablaHistorialDescuentos" name="tablaHistorialDescuentos">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>PROYECTO</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>PRECIO DEL LOTE</th>
                                                                    <th>TOTAL DE LA COMISIÓN</th>
                                                                    <th>MONTO DESCUENTO</th>
                                                                    <th>TIPO</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="tab-pane" id="solicitudesOOAM">
                                                <div class="encabezadoBox">
                                                    <div class="row">
                                                        <h3 class="card-title center-align">Historial OOAM</h3>
                                                        <p class="card-title pl-1">Este es un listado de todos los descuentos que te han aplicado.</p>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover" id="tablaHistorialOOAM" name="tablaHistorialOOAM">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>ID COMISION</th>
                                                                    <th>PROYECTO</th>
                                                                    <th>PRECIO LOTE </th>
                                                                    <th>COMISION TOTAL</th>
                                                                    <th>PORCENTAJE DECIMAL</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>FECHA CREACIÓN</th>
                                                                    <th>ID USUARIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>PJ</th>
                                                                    <th>FORMA PAGO</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> -->
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url()?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_colaborador.js"></script>
</body>