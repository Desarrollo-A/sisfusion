<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />


<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

<div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <h3 class="card-title center-align">Reportes de Ventas</h3>
                                <div class="toolbar">
                                

                                
                                    <!-- <form method="POST">
                                        <div class="toolbar">
                                            <div class="row">
                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="radio_container w-50">
                                                        <input class="d-none" type="radio" name="opcion" value="opcion1" id="one" onchange="this.form.submit()">
                                                        <label for="one" class="w-50">Inventario lotes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form> -->

                            
                                <div class="row aligned-row justify-end">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                        <div class=" form-group d-flex col-xs-12 col-sm-6 col-md-6 col-lg-6 align-center box-table">
                                            <input type="text" class="form-control datepicker text-center pl-1 beginDate box-table" id="beginDate" />
                                            <input type="text" class="form-control datepicker text-center pl-1 endDate box-table" id="endDate" />
                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini searchByDateRange box-table" name="searchByDateRange" id="searchByDateRange">
                                                <span class="material-icons update-dataTable">search</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="material-datatables">
                                    <table class="table-striped table-hover" id="tablaReportes" name="tablaReportes">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th><!--0-->
                                                <th>CONDOMINIO</th><!--1-->
                                                <th>LOTE</th><!--2-->
                                                <th>ID LOTE</th><!--3-->
                                                <th>REFERENCIAs</th><!--4-->
                                                <th>NOMBRE CLIENTES</th><!--5-->
                                                <th>FECHA APARTADO</th><!--6-->
                                                <th>ASESOR</th><!--7-->
                                                <th>COORDINADOR</th><!--8-->
                                                <th>GERENTE</th><!--9-->
                                                <th>SUBDIRECTOR</th><!--10-->
                                                <th>DIRECTOR REGIONAL</th><!--11-->
                                                <th>DIRECTOR REGIONAL 2</th><!--12-->
                                                <th>ESTATUS LOTE</th><!--13-->
                                                <th>ESTATUS DE CONTRATACIÓN</th><!--14-->
                                                <th>DESCRIPCION</th><!--15-->
                                                <th>COMENTARIO</th><!--16-->
                                                <th>UBICACIÓN VENTA</th><!--17-->
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
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/reporteVentas/reporteVentas.js?=v.4.4.4"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
</body>