<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>

    <div class="wrapper">
        
        <?php 
        $this->load->view('template/sidebar'); 
       // $this->load->view('comisiones/complementos/comisiones_colaborador_comple'); 
        //echo($complementos[0]);
        $usuarioid =  $this->session->userdata('id_usuario');
        ?>

        <div class="content boxContent">
        <!--  -->
       
        <!--  -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a class="nuevas1" href="#nuevas-1" id='nuevas1' role="tab" data-toggle="tab">Nuevas</a>
                            </li>
                            <li>
                                <a class="proceso2" href="#proceso-1" id='proceso2'  role="tab"  data-toggle="tab">En revisión</a>
                            </li>
                            <li>
                                <a class="preceso3" href="#proceso-2" id='preceso3'  data-toggle="tab">Por pagar</a>
                            </li>
                            <li>
                                <a class="preceso4" href="#otras-1" id='preceso4' role="tab"  data-toggle="tab">Pausadas</a>
                            </li>
                            <li>
                                <a class="preceso5" href="#sin_pago_neodata" id='preceso5' role="tab" data-toggle="tab">Sin pago en Neodata</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-2">Comisiones nuevas disponibles para solicitar tu pago, para ver más detalles podrás consultarlo en el historial<a href="<?=base_url()?>Comisiones/historial_colaborador"><b>Da clic aquí para ir al historial</b></a></p>
                                                <?php
                                                    if($this->session->userdata('forma_pago') == 3){
                                                ?>
                                                <p style="color:#0a548b; margin-left: 1rem"><i class="fa fa-info-circle" aria-hidden="true"></i>Al monto mostrado habrá que descontar el <b>impuesto estatal</b> del
                                                <?php
                                                $sede = $this->session->userdata('id_sede');
                                                $query = $this->db->query("SELECT * FROM sedes WHERE estatus in (1) AND id_sede = ".$sede."");
                                                foreach ($query->result() as $row){
                                                    $number = $row->impuesto;
                                                    echo '<b>' .number_format($number,2).'%</b> e ISR de acuerdo a las tablas publicadas en el SAT.';
                                                }
                                                ?>
                                                </p>
                                                <?php
                                                }else if($this->session->userdata('forma_pago') == 4){
                                                    ?>
                                                <p style="color:#0a548b;"><i class="fa fa-info-circle" aria-hidden="true"></i> La cantidad mostrada es menos las deducciones aplicables para el régimen de <b>Remanente Distribuible.</b>
                                                <?php }?>
                                                <?php if ($this->session->userdata('forma_pago') == 5) { ?>
                                                    <p class="card-title pl-2">Comprobantes fiscales emitidos por residentes en el <b>extranjero</b> sin establecimiento permanente en México.
                                                        <a data-toggle="modal" data-target="#info-modal" style="cursor: pointer;">
                                                            <u>Clic aquí para más información</u>
                                                        </a>
                                                    </p>
                                                <?php } ?>

                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0">Saldo sin impuestos:</h4>
                                                                <p class="input-tot" name="myText_nuevas" id="myText_nuevas">0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0">Solicitar:</h4>
                                                                <p class="input-tot" id="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-left mt-1 encabezado" id="encabezado">
                                                    <!-- <?= $cadena ?> -->
                                                    
                                                </div>
                             
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>ID PAGO</th>
                                                                <th>PROYECTO</th>
                                                                <th>LOTE</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGADO DEL CLIENTE</th>
                                                                <th>DISPERSADO</th>
                                                                <th>SALDO A COBRAR</th>
                                                                <th>% COMISIÓN</th>
                                                                <th>DETALLE</th>
                                                                <th>ESTATUS</th>
                                                                <th>ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="tab-pane" id="sin_pago_neodata">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">Comisiones sin pago reflejado en NEODATA y que por ello no se han dispersado ciertos lotes con tus comisiones.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="proyecto">Proyecto</label>
                                                                <select name="proyecto_wp" id="proyecto_wp" class="selectpicker select-gral" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="proyecto">Condominio</label>
                                                                <select name="condominio_wp" id="condominio_wp" class="selectpicker select-gral" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required><option disabled selected>Selecciona una opción</option></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables hide" id="boxTablaComisionesSinPago">
                                                <table class="table-striped table-hover" id="tabla_comisiones_sin_pago" name="tabla_comisiones_sin_pago">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>CLIENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>COORDINADOR</th>
                                                            <th>GERENTE</th>
                                                            <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <!-- <script src="<?= base_url()?>dist/js/funciones-generales.js"></script> -->
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script>
        Shadowbox.init();
        var forma_pago = <?= $this->session->userdata('forma_pago') ?>;
        var tipo_usuario = <?= $this->session->userdata('tipo') ?>;
        var userSede = <?= $this->session->userdata('id_sede') ?>;
        var fechaServer = '<?php echo date('Y-m-d H:i:s')?>';
    </script>
    <script src="<?=base_url()?>dist/js/controllers/comisiones/colaborador/comisiones_colaborador.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/comisiones/colaborador/comisiones_colaborador_factura.js"></script>

</body>