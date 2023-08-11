<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php
        if($this->session->userdata('id_rol')=="28" ||$this->session->userdata('id_rol')=="18"||$this->session->userdata('id_rol')=="19"){
            $this->load->view('template/sidebar');
        } else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>

        <!-- Modals -->
        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_mktd">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Plaza 1</label>
                                    <select name="plaza1" id="plaza1" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Plaza 2</label>
                                    <select name="plaza2" id="plaza2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
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
                    <div class="modal-header bg-red">
                        <center><img src="<?= base_url() ?>static/images/cob_mktd.gif" width="150" height="150"></center>
                    </div>
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
                    <div class="modal-header bg-red">
                    </div>
                    <form method="post" id="form_precio">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationMarketing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsData()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: orange;">
                                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsData()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte MKTD</h3>
                                    <p class="card-title pl-1">(Listado de lotes con apartado en MKTD)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">Mes</label>
                                                <select name="mes" id="mes"class="selectpicker select-gral m-0"data-style="btn" data-show-subtext="true"data-live-search="true"title="SELECCIONA UNA OPCIÓN" data-size="7" required>
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
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">Año</label>
                                                <select name="anio" id="anio"class="selectpicker select-gral m-0"data-style="btn" data-show-subtext="true"data-live-search="true"title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                    <?php
                                                    setlocale(LC_ALL, 'es_ES');
                                                    for ($i = 2019; $i <= 2023; $i++) {
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
                                        <table class="table-striped table-hover hide" id="tabla_historialGral" name="tabla_historialGral">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>MES</th>
                                                    <th>CLIENTE</th>
                                                    <th>PLAZA</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>ESTATUS</th>
                                                    <th>EVIDENCIA</th>
                                                    <th>COMISIÓN TOTAL</th>
                                                    <th>ABONADO</th>
                                                    <th>PAGADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>ESTATUS DE LA COMISIÓN</th>
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
    <?php $this->load->view('template/footer'); ?>
    <script src="<?=base_url()?>dist/js/controllers/ventas/cobranzaRanking.js"></script>

</body>