<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div id="filterContainer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="prospects-datatable_dir"  class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
                                                <th>CORREO</th>
                                                <th>TELÉFONO</th>
                                                <?php
                                                    if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5){?>
                                                        <th>ACCIONES</th>
                                                        <!-- <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 103px;">
                                                            <input  type="text"
                                                                    style="width:100%; background:#143860!important; color:white; border: 0; font-weight: 500;"
                                                                    class="textoshead" 
                                                                    placeholder="ACCIONES">
                                                        </th> -->
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php include 'common_modals.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<?php
    if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
    {
?>
        <script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js"></script>
<?php
    }
?>

<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospecto_sbdir.js"></script>
</body>