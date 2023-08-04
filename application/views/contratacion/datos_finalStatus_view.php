<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas"><i class="fas fa-bookmark fa-2x"></i></div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte último estatus </h3>
                                <div  class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row ">
                                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 overflow-hidden">
                                                <label class="control-label">Sedes por proyecto</label>
                                                <select name="sedes" id="sedes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div> 
                                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 overflow-hidden hide" id="div_proyectos">
                                                <label class="control-label">Proyecto</label>
                                                <select name="residenciales" id="residenciales" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" ></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables hide" id="JTH">
                                    <div class="form-group">
                                        <table id="Jtabla"  class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>SEDE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>SUPERFICIE</th>
                                                    <th>ASESOR(ES)</th>
                                                    <th>GERENTE</th>
                                                    <th>PROCESO DE CONTRATACIÓN</th>
                                                    <th>ESTATUS</th>
                                                    <th>COMENTARIO</th>
                                                    <th>FECHA DE VENCIMIENTO</th>
                                                    <th>DÍAS RESTANTES</th>
                                                    <th>DÍAS VENCIDOS</th>
                                                    <th>ESTATUS DE FECHA</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>CLIENTE</th>
                                                    <th>LIBERACIÓN</th>
                                                    <th>ÚLTIMO MOVIMIENTO</th>
                                                    <th>ESTATUS DEL LOTE</th>
                                                    <th>REUBICACIÓN</th>
                                                    <th>FECHA DE REUBICACIÓN</th>
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
<?php $this->load->view('template/footer');?>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/contratacion/datos_finalStatus.js"></script>
</body>
