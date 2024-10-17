<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" type="text/css"/>

<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>
	<div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" data-i18n="listado-residenciales-cm">Listado de residenciales Ciudad Maderas</h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tablaResidenciales">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th id="nomeclatura" style="font-weight: normal; font-size: 10px">nomenclature</th>
                                                    <th id="nombre" style="font-weight: normal; font-size: 10px">nombre</th>
                                                    <th id="empresa" style="font-weight: normal; font-size: 10px">empresa</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/asesores/diccionarioResidenciales.js"></script>
