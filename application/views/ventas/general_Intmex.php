<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones solicitadeas</h3>
                                    <p class="card-title pl-1">(Comisiones solicitadas para proceder a pago)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totalDisponible" id="totalDisponible">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="comisiones_solicitadas" name="comisiones_solicitadas">
                                            <thead>
                                                <tr>
                                                    <th>ID PAGO</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>NOMBRE DEL LOTE </th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>EMPRESA</th>
                                                    <th>IMPUESTO</th>
                                                    <th>DESCUENTO</th>
                                                    <th>TOTAL A PAGAR</th>
                                                    <th>COMISIONISTA</th>
                                                    <th>PUESTO</th>
                                                    <th>SEDE</th>
                                                    <th>RFC</th>
                                                    <th>FORMA DE PAGO</th>
                                                    <th>FECHA DE ENVÍO</th>
                                                    <th>ESTATUS</th> 
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
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/general_Intmex.js"></script>
</body>
