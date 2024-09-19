<!-- <style>
.details-control {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}
</style> -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }
            #modal_vc{
                z-index: 1041!important;
            }
            .beginDate, #beginDate{
                background-color: #eaeaea !important;
                border-radius: 27px 0 0 27px!important;
                background-image: initial!important;
                text-align: center!important;
            }
                
            .endDate, #endDate{
                background-color: #eaeaea !important;
                border-radius: 0!important;
                background-image: initial!important;
                text-align: center!important;
            }
            .btn-fab-mini {
                border-radius: 0 27px 27px 0 !important;
                background-color: #eaeaea !important;
                box-shadow: none !important;
                height: 45px !important;
            }
            .btn-fab-mini span {
                color: #929292;
            }
        </style>
    <?php $this->load->view('comisiones/dispersion/modal_dispersion/modales_dispersion_view'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#dispersionComer" onclick="asignarNumTabla(1)" role="tab" data-toggle="tab">Dispersión Comercialización</a></li>
                            <li ><a href="#dispersionCasas" role="tab" onclick="asignarNumTabla(2)" data-toggle="tab">Dispersión casas</a></li>
                            <!-- <li ><a href="#asimiladosOOAM" role="tab" data-toggle="tab">Asimilados lotes</a></li> -->
                        </ul>
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="dispersionComer">
                                            <div class="card-content">
                                                <div class="encabezadoBox">
                                                    <h3 class="h3 card-title center-align" >Dispersión de pago Comercialización</h3>
                                                    <p class="card-title pl-1 center-align">Lotes nuevos sin dispersar, con saldo disponible en neodata y rescisiones con la nueva venta.</p>
                                                </div>
                                                <div class="toolbar">
                                                    <div class="container-fluid p-0">
                                                    <?php $this->load->view('comisiones/dispersion/menu_superior/menu_superior_view'); ?>
                                                        <div class="material-datatables">
                                                            <div class="form-group">
                                                                <table class="table-striped table-hover" id="tabla_dispersar_comisiones" name="tabla_dispersar_comisiones">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>DETALLES</th>
                                                                            <th>PROYECTO</th>
                                                                            <th>CONDOMINIO</th>
                                                                            <th>LOTE</th>
                                                                            <th>ID LOTE</th>
                                                                            <th>CLIENTE</th>
                                                                            <th>TIPO DE VENTA</th>
                                                                            <th>MODALIDAD</th>
                                                                            <th>CONTRATACIÓN</th>
                                                                            <th>PLAN DE VENTA</th>
                                                                            <th>PRECIO FINAL LOTE</th>
                                                                            <th>% COMISION TOTAL</th>
                                                                            <th>IMPORTE COMISIÓN PAGADA</th>
                                                                            <th>IMPORTE COMISIÓN PENDIENTE</th>
                                                                            <th>DETALLES</th>
                                                                            <th>FECHA ACTUALIZACIÓN</th>
                                                                            <th>TIPO MENSUALIDAD</th>
                                                                            <th>ACCIONES</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                <!--  -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $this->load->view('comisiones/dispersion/tab_tabla_dispersion_casas_view'); ?>
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
<script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/general/generalesDispersion.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/dispersion.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/dispersion/casas/dispersion_casas.js"></script>
</body>