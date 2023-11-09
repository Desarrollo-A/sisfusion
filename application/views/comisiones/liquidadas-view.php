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
        </style>
        <div class="modal fade modal-alertas" id="detenciones-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row" id="detenidos-form" autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" name="id_pagoc" id="id-lote-detenido">
                            <input type="hidden" name="statusLote" id="statusLote">
                            <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <input id="motivo" name="motivo" type="text" class="form-control input-gral" placeholder="Escriba un motivo corto." minlength="3" maxlength="50" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group label-floating">
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Escriba detalles de la controversia." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="detenerLote" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                        <div class="modal-header bg-red">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                        </div>
                        <div class="modal-body" style="text-align: center;"></div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="updateBandera" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detalle-plan-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div id="detalle-tabla-div"class="container-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                        <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos lotes</a></li>
                        <li><a href="#proceso-1" role="tab" data-toggle="tab">Pagos ooam</a></li>
                    </ul>
                    <div class="card no-shadow m-0 border-conntent__tabs">
                    <div class="nav-tabs-custom">
                        <div class="tab-content p-2">
                            <div class="tab-pane active" id="nuevas-1">
                                <div class="card-content">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Comisiones liquidadas</h3>
                                        <p class="card-title pl-1">Lotes que cubrieron el monto total de comisones.</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="container-fluid">
                                            <div class="row aligned-row">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_comisiones_liquidadas" name="tabla_comisiones_liquidadas">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>ID LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO DE VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>CONTRATACIÓN</th>
                                                        <th>PLAN DE VENTA</th>
                                                        <th>TOTAL</th>
                                                        <!-- <th>TOTAL</th> -->
                                                        <th>PORCENTAJE</th>
                                                        <th>PENDIENTE</th>
                                                        <th>DETALLES</th>
                                                        <th>FECHA ACTUALIZACIÓN</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="proceso-1">
                                <div class="card-content">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Comisiones liquidadas ooam</h3>
                                        <p class="card-title pl-1">Lotes que cubrieron el monto total de comisones.</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="container-fluid">
                                            <div class="row aligned-row">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_comisiones_liquidadas_ooam" name="tabla_comisiones_liquidadas_ooam">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>ID LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO DE VENTA</th>
                                                        <!-- <th>MODALIDAD</th> -->
                                                        <th>CONTRATACIÓN</th>
                                                        <th>PLAN DE VENTA</th>
                                                        <th>DETALLES</th>
                                                        <th>FECHA ACTUALIZACIÓN</th>
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
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/liquidadas.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/liquidadas_ooam.js"></script>
</body>