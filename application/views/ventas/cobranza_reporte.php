<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_mktd">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Plaza 1</label>
                                    <select name="plaza1" id="plaza1"  class="selectpicker m-0 select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Plaza 2</label>
                                    <select name="plaza2" id="plaza2"  class="selectpicker m-0 select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_precio" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red"></div>
                    <form method="post" id="form_precio">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-bar fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Reporte mktd</h3>
                                    <p class="card-title pl-1">(Listado de lotes con apartado en MKTD)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label" for="proyecto">Mes</label>
                                                <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            $monthNum  = $i;
                                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                            $monthName = strftime('%B', $dateObj->getTimestamp());
                                                            echo '<option value="' . $i . '">' . $monthName . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Año</label>
                                                <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 2019; $i <= 2022; $i++) {
                                                            $yearName  = $i;
                                                            echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                        }
                                                    ?>
                                                </select>
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
                                                    <th>PRECIO LOTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>MES</th>
                                                    <th>CLIENTE</th>
                                                    <th>PLAZA</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>ESTATUS</th>
                                                    <th>EVIDENCIA</th>
                                                    <th>COMISION</th>
                                                    <th>ABONADO</th>
                                                    <th>PAGADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>ESTADO COMISION</th>
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
            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/cobranza_reporte.js"></script>
</body>