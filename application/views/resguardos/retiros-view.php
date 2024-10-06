<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <style>        
            #modal_nuevas{
                z-index: 1041!important;
            }

            #modal_vc{
                z-index: 1041!important;
            }
        </style>

        <div class="modal fade modal-alertas" id="autorizar-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row" id="autorizar_form" autocomplete="off">
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align " data-i18n="descuento-resguardo">Descuentos a resguardo.</h3>
                                    <p class="card-title pl-1" data-i18n="descuento-resguardo-descripcion"> Listado de los descuentos aplicados al saldo de Resguardo personal.</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0" data-i18n="total-resguardo">Total resguardo:</h4>
                                                    <p class="input-tot pl-1" name="totalResguardo" id="totalResguardo">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0" data-i18n="ingresos-extra" >Ingresos extras:</h4>
                                                    <p class="input-tot pl-1" name="totalExtras" id="totalExtras">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0" data-i18n="saldo-disponible" >Saldo disponible:</h4>
                                                    <p class="input-tot pl-1" name="totalDisponible" id="totalDisponible">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0" data-i18n="descuentos-aplicados">Descuentos aplicados:</h4>
                                                    <p class="input-tot pl-1" name="totalAplicados" id="totalAplicados">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_retiros_resguardo" name="tabla_retiros_resguardo">
                                        <thead>
                                            <tr>
                                                <th>id-descuento</th>
                                                <th>usuario</th>
                                                <th>descuento</th>
                                                <th>motivo</th>
                                                <th>estatus</th>
                                                <th>creado-por</th>
                                                <th>fecha-aplicado</th>
                                                <th>acciones</th>
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
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/resguardos/retiros.js"></script>
</body>