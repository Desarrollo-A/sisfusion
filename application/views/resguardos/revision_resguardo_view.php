<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#comisiones_resguardo" role="tab" data-toggle="tab">Resguardo Comisión</a>
                            </li>
                            <li>
                                <a href="#resguardo_casas" role="tab"  data-toggle="tab">Resguardo Casas</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="comisiones_resguardo">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align" >Comisiones resguardo</h3>
                                                <p class="card-title pl-1">(Comisiones solictadas por colaboradores de sudirección y dirección de ventas)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="totpagarremanente" id="totpagarremanente">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                                <p class="input-tot pl-1" id="totpagarPen" name="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="directivo_resguardo">Directivo</label>
                                                                <select name="directivo_resguardo" id="directivo_resguardo" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="anio">Año</label>
                                                                <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="mes">Mes</label>
                                                                <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group select-gral overflow-hidden">
                                                                <label className="m-0" for="catalogo_resguardo">Proyecto</label>
                                                                <select class="selectpicker" id="catalogo_resguardo" name="catalogo_resguardo[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_resguardo" name="tabla_resguardo">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>EMPRESA</th>
                                                                <th>REFERENCIA</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGO DEL CLIENTE</th>
                                                                <th>DISPERSADO</th>
                                                                <th>PAGADO</th>
                                                                <th>PENDIENTE</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>DETALLE</th>
                                                                <th>ESTATUS</th>
                                                                <th>ACCIONES</th>
                                                                <th>FECHA DE ENVÍO</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="tab-pane" id="resguardo_casas">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align" >Resguardo casas</h3>
                                                <p class="card-title pl-1">(Comisiones solictadas por colaboradores de sudirección y dirección de ventas)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="totpagarremanente_casas" id="totpagarremanente_casas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                                <p class="input-tot pl-1" id="totpagarPen_casas" name="totpagarPen_casas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="directivo_resguardo_casas">Directivo</label>
                                                                <select name="directivo_resguardo_casas" id="directivo_resguardo_casas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="anio_casas">Año</label>
                                                                <select name="anio_casas" id="anio_casas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                            <div class="form-group overflow-hidden">
                                                                <label className="m-0" for="mes_casas">Mes</label>
                                                                <select name="mes_casas" id="mes_casas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group select-gral overflow-hidden">
                                                                <label className="m-0" for="catalogo_resguardo_casas">Proyecto</label>
                                                                <select class="selectpicker" id="catalogo_resguardo_casas" name="catalogo_resguardo_casas[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_resguardo_casas" name="tabla_resguardo_casas">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>EMPRESA</th>
                                                                <th>REFERENCIA</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGO DEL CLIENTE</th>
                                                                <th>DISPERSADO</th>
                                                                <th>PAGADO</th>
                                                                <th>PENDIENTE</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>DETALLE</th>
                                                                <th>ESTATUS</th>
                                                                <th>ACCIONES</th>
                                                                <th>FECHA DE ENVÍO</th>
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
            </div>
        </div>

    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/resguardos/revision_resguardos.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/casas_comisiones/revision_resguardo_casas.js"></script>

</body>
