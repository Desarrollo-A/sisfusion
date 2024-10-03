<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); 
        $usuarioid =  $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=".$usuarioid."");
        $cadena ='';
        foreach ($query->result() as $row){
            $forma_pago = $row->forma_pago;
            if( $forma_pago  == 2 ||  $forma_pago == '2'){
                if(count($opn_cumplimiento) == 0){
                    $cadena = '<a href="'.base_url().'Usuarios/configureProfile"> <span class="label label-danger" style="background:red;" data-i18n="sin-opinion">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA ></span> </a>';
                } 
                else{
                    if($opn_cumplimiento[0]['estatus'] == 1){
                        $cadena = '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';
                    }
                    else if($opn_cumplimiento[0]['estatus'] == 0){
                        $cadena ='<a href="'.base_url().'Usuarios/configureProfile"> <span class="label label-danger" style="background:orange;" data-i18n="sin-opinion">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>';
                    }
                    else if($opn_cumplimiento[0]['estatus'] == 2){
                        $cadena = '<button type="button" class="btn btn-info subir_factura_multiple" ><span data-i18n="subir-fact">SUBIR FACTURAS</span></button>';
                    }
                }
            } else if ($forma_pago == 5) {
                if(count($opn_cumplimiento) == 0){
                    $cadena = '<button type="button" class="btn btn-info subir-archivo" ><span data-i18n="doc-fiscal">SUBIR DOCUMENTO FISCAL</span></button>';
                } else if($opn_cumplimiento[0]['estatus'] == 0) {
                    $cadena = '<button type="button" class="btn btn-info subir-archivo"><span data-i18n="doc-fiscal">SUBIR DOCUMENTO FISCAL</span></button>';
                } else if ($opn_cumplimiento[0]['estatus'] == 1) {
                    $cadena = '<p><b>Documento fiscal cargado con éxito</b>
                                <a href="#" class="verPDFExtranjero" title="Documento fiscal" data-usuario="'.$opn_cumplimiento[0]["archivo_name"].'" style="cursor: pointer;"><u data-i18n="ver-doc">Ver documento</u></a>
                            </p>';
                } else if($opn_cumplimiento[0]['estatus'] == 2) {
                    $cadena = '<p style="color: #02B50C;" data-i18n="doc-bloqueado">Documento fiscal bloqueado, hay comisiones asociadas.</p>';
                }
            }
        }
        ?>
    <?php $this->load->view('ventas/comisiones_colaborador_modales/comisiones_colaborador_modales_comple'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas-1" role="tab" data-toggle="tab" data-i18n="nuevas">Nuevas</a>
                            </li>
                            <li>
                                <a href="#proceso-1" role="tab"  data-toggle="tab" data-i18n="revision">En revisión</a>
                            </li>
                            <li>
                                <a href="#proceso-2" role="tab"  data-toggle="tab" data-i18n="x-pagar">Por pagar</a>
                            </li>
                            <li>
                                <a href="#otras-1" role="tab"  data-toggle="tab" data-i18n="pausadas">Pausadas</a>
                            </li>
                            <li>
                                <a href="#sin_pago_neodata" role="tab" data-toggle="tab" data-i18n="sin-neodata">Sin pago en Neodata</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-2"><span data-i18n="texto-colaborador">Comisiones nuevas disponibles para solicitar tu pago, para ver más detalles podrás consultarlo en el historial </span><a href="<?=base_url()?>Comisiones/historial_colaborador"><b><span data-i18n="texto-clic-historial"> Da clic aquí para ir al historial </span></b></a></p>
                                                <?php
                                                    if($this->session->userdata('forma_pago') == 3){
                                                ?>
                                                <p style="color:#0a548b; margin-left: 1rem"><i class="fa fa-info-circle" aria-hidden="true"></i><span data-i18n="texto-impuesto">Al monto mostrado habrá que descontar el   </span><b><span data-i18n="impuesto-estatal"> impuesto estatal </span></b><span data-i18n="sat"> del </span>
                                                <?php
                                                $sede = $this->session->userdata('id_sede');
                                                $query = $this->db->query("SELECT * FROM sedes WHERE estatus in (1) AND id_sede = ".$sede."");
                                                foreach ($query->result() as $row){
                                                    $number = $row->impuesto;
                                                    echo '<b>' .number_format($number,2).'%</b> <span data-i18n="isr"> e ISR de acuerdo a las tablas publicadas en el SAT. </span>';
                                                }
                                                ?>
                                                </p>
                                                <?php
                                                }else if($this->session->userdata('forma_pago') == 4){
                                                    ?>
                                                <p style="color:#0a548b;"><i class="fa fa-info-circle" aria-hidden="true"></i> <span data-i18n="text-remanente"> La cantidad mostrada es menos las deducciones aplicables para el régimen de </span> <b data-i18n="remanente">Remanente Distribuible.</b>
                                                <?php }?>
                                                <?php if ($this->session->userdata('forma_pago') == 5) { ?>
                                                    <p class="card-title pl-2"><span data-i18n="comprobante-fis">Comprobantes fiscales emitidos por residentes en el <b data-i18n="estranjero">extranjero</b> <span data-i18n="establecimiento-mex">sin establecimiento permanente en México.</span>
                                                        <a data-toggle="modal" data-target="#info-modal" style="cursor: pointer;">
                                                            <u data-i18n="clic-mas-info">Clic aquí para más información</u>
                                                        </a>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0" data-i18n="saldo-sn-impuesto">Saldo sin impuestos:</h4>
                                                                <p class="input-tot" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0" data-i18n="solicitar">Solicitar:</h4>
                                                                <p class="input-tot" id="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-left mt-1">
                                                    <?= $cadena ?>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                        <thead>
                                                            <tr>
                                                                <th>checkComisionesNuevas</th>
                                                                <th>id-pago</th>
                                                                <th>proyectos</th>
                                                                <th>lote</th>
                                                                <th>precio-del-lote</th>
                                                                <th>total-comision</th>
                                                                <th>pago-cliente</th>
                                                                <th>dispersado</th>
                                                                <th>saldo-cobrar</th>
                                                                <th>porc-comision</th>
                                                                <th>detalles</th>
                                                                <th>estatus</th>
                                                                <th>id-arcus</th>
                                                                <th>nom-cliente</th>
                                                                <th>acciones</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1"><span data-i18n="comisiones-enviadas-contraloria">Comisiones enviadas a contraloría para su revisión antes de aplicar tu pago, si requieres ver más detalles como lo pagado y lo pendiente podrás consultarlo en el historial</span> <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b><span data-i18n="texto-clic-historial">Da clic aquí para ir al historial</span></b></a></p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0"><span data-i18n="soliciado-sin-impuesto">Solicitado sin impuestos:</span></h4>
                                                                <p class="input-tot pl-1" name="myText_revision" id="myText_revision">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>id-pago</th>
                                                        <th>proyectos</th>
                                                        <th>lote</th>
                                                        <th>precio-del-lote</th>
                                                        <th>total-comision</th>
                                                        <th>pago-cliente</th>
                                                        <th>dispersado</th>
                                                        <th>saldo-cobrar</th>
                                                        <th>porc-comision</th>
                                                        <th>detalles</th>
                                                        <th>estatus</th>
                                                        <th>acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="proceso-2">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1"><span data-i18n="comisiones-proceso-pago">Comisiones en proceso de pago por parte de INTERNOMEX. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial </span><a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b><span data-i18n="texto-clic-historial">Da clic aquí para ir al historial</span></b></a></p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0"><span data-i18n="por-pagar-sin-impuesto">Por pagar sin impuestos:</span></h4>
                                                                <p class="input-tot pl-1" name="myText_pagadas" id="myText_pagadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>id-pago</th>
                                                        <th>proyectos</th>
                                                        <th>lote</th>
                                                        <th>precio-del-lote</th>
                                                        <th>total-comision</th>
                                                        <th>pago-cliente</th>
                                                        <th>dispersado</th>
                                                        <th>saldo-cobrar</th>
                                                        <th>porc-comision</th>
                                                        <th>detalles</th>
                                                        <th>estatus</th>
                                                        <th>acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="otras-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1"><span data-i18n="comisiones-pausadas">Comisiones pausadas, para ver el motivo da clic el botón de información. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial </span><a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b><span data-i18n="texto-clic-historial">Da clic aquí para ir al historial</span></b></a></p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0"><span data-i18n="total-pausado">Total pausado:</span></h4>
                                                                <p class="input-tot pl-1" name="myText_pausadas" id="myText_pausadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>id-pago</th>
                                                        <th>proyectos</th>
                                                        <th>lote</th>
                                                        <th>precio-del-lote</th>
                                                        <th>total-comision</th>
                                                        <th>pago-cliente</th>
                                                        <th>dispersado</th>
                                                        <th>saldo-cobrar</th>
                                                        <th>porc-comision</th>
                                                        <th>detalles</th>
                                                        <th>estatus</th>
                                                        <th>acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="sin_pago_neodata">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1"><span data-i18n="sin-pago-neodata">Comisiones sin pago reflejado en NEODATA y que por ello no se han dispersado ciertos lotes con tus comisiones.</span></p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="proyecto"><span data-i18n="proyecto">Proyecto</span></label>
                                                                <select name="proyecto_wp" id="proyecto_wp" class="selectpicker select-gral" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="proyecto"><span data-i18n="condominio">Condominio</span></label>
                                                                <select name="condominio_wp" id="condominio_wp" class="selectpicker select-gral" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" data-size="7" required></select>
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
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script>
      
               /* var b = document.getElementsByClassName("select-gral");
b.removeAttribute("title");
b.setAttribute("title", _("select-predeterminado"));*/
        Shadowbox.init();
        var forma_pago = <?= $this->session->userdata('forma_pago') ?>;
        var tipo_usuario = <?= $this->session->userdata('tipo') ?>;
        var userSede = <?= $this->session->userdata('id_sede') ?>;
        var fechaServer = '<?php echo date('Y-m-d H:i:s')?>';

    </script>
    <script src="<?=base_url()?>dist/js/controllers/ventas/comisiones_colaborador.js"></script>
</body>