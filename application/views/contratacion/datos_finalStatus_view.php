<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
	<?php
	    $this->load->view('template/sidebar', "");
	?>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align " id="showDate"> </h3>
							<div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Sedes por proyecto</label>
                                                <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona una sede"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-4 form-group hide" id="div_proyectos">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Proyectos</label>
                                                <select name="residenciales" id="residenciales" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona una empresa"
                                                        data-size="7" data-live-search="true">
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="Jtabla"  class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>SEDE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>SUP</th>
                                                    <th>GERENTE</th>
                                                    <th>ASESOR(ES)</th>
                                                    <th>PROCESO CONTRATACIÓN</th>
                                                    <th>ESTATUS</th>
                                                    <th>COMENTARIO</th>
                                                    <th>FECHA VENCIMIENTO</th>
                                                    <th>DÍAS RESTANTES</th>
                                                    <th>DÍAS VENCIDOS</th>
                                                    <th>ESTATUS FECHA</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>CLIENTE</th>
                                                    <th>LIBERACIÓN</th>
                                                    <th>ÚLT. MOVIMIENTO</th>
                                                    <th>ESTATUS LOTE</th>
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
</div>

<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/contratacion/datos_finalStatus.js"></script>
</body>
