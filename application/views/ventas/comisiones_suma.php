<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<body>
    <div class="wrapper">
        <?php 
        $this->load->view('template/sidebar');

        $usuarioid =  $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=" . $usuarioid . "");

        $cadena = '';

        foreach ($query->result() as $row) {
            $forma_pago = $row->forma_pago;
            if ($forma_pago  == 2 ||  $forma_pago == '2') {
                if (count($opn_cumplimiento) == 0) {
                    $cadena = '<a href="https://maderascrm.gphsis.com/index.php/Usuarios/configureProfile"> <span class="label label-danger" style="background:red;">SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>';
                } else {
                    if ($opn_cumplimiento[0]['estatus'] == 1) {
                        $cadena = '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';
                    } else if ($opn_cumplimiento[0]['estatus'] == 0) {
                        $cadena = '<a href="https://maderascrm.gphsis.com/index.php/Usuarios/configureProfile"> <span class="label label-danger" style="background:orange;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>';
                    } else if ($opn_cumplimiento[0]['estatus'] == 2) {
                        $cadena = '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';
                    }
                }
            } else if ($forma_pago == 5) {
                if (count($opn_cumplimiento) == 0) {
                    $cadena = '<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>';
                } else if ($opn_cumplimiento[0]['estatus'] == 0) {
                    $cadena = '<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>';
                } else if ($opn_cumplimiento[0]['estatus'] == 1) {
                    $cadena = '<label style="background-color: #b8ae84; padding: 5px 10px; border-radius: 25px; color: #fff">
                                        <b>Documento fiscal cargado con éxito</b>
                                        <a href="#" class="verPDFExtranjero" title="Documento fiscal" data-usuario="' . $opn_cumplimiento[0]["archivo_name"] . '" style="color:#fff">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="cuestionDelete" data-toggle="modal" data-target="#deleteModal" title="Eliminar documento fiscal" data-idDocumento="' . $opn_cumplimiento[0]["id_opn"] . '" style="background-color: transparent; border:none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </label>';
                } else if ($opn_cumplimiento[0]['estatus'] == 2) {
                    $cadena = '<p style="color: #02B50C;">Documento fiscal bloqueado, hay comisiones asociadas.</p>';
                }
            }
        }
        ?>

        <div class="modal fade modal-alertas" id="addFileExtranjero" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Cargar de documento fiscal</b></h4>
                    </div>
                    <form id="EditarPerfilExtranjeroForm" name="EditarPerfilExtranjeroForm" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p style="text-align: justify; text-justify: inter-word;"><b>Nota:</b> Recuerda que tu documento fiscal debe corresponder al total exacto de las
                                        comisiones a solicitar, una vez solicitados tus pagos ya no podrás remplazar
                                        este archivo.</p>
                                    <div class="input-group">
                                        <label class="input-group-btn"></label>
                                        <span class="btn btn-info btn-file">
                                            <i class="fa fa-upload"></i> Subir archivo
                                            <input id="file-upload-extranjero" name="file-upload-extranjero" required accept="application/pdf" type="file" />
                                        </span>
                                        <p id="archivo-extranjero"></p>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <h3 id="total-comision"></h3>
                                        </div>
                                        <div class="col-lg-12" id="preview-div"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="sendFileExtranjero" class="btn btn-primary">GUARDAR</button>
                                        <button class="btn btn-danger" type="button" data-dismiss="modal">CANCELAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_multiples" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_multiples">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- inicia modal subir factura -->
        <div id="modal_formulario_solicitud_multiple" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="generar_solicitud">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- //poner modal -->
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div><br>
                                                        <span class="fileinput-new">Selecciona un archivo</span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <button class="btn btn-warning" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                            </div>
                                        </div>
                                        <form id="frmnewsol" method="post" action="#">
                                            <div class="row">
                                                <div class="col-lg-4 form-group">
                                                    <label for="emisor">Emisor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="receptor">Receptor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="total">Monto:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="formaPago">Forma de pago:</label>
                                                    <input type="text" class="form-control" placeholder="Forma de Pago" id="formaPago" name="formaPago" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="cfdi">Uso del CFDI:</label>
                                                    <input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="metodopago">Método de Pago:</label>
                                                    <input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="unidad">Unidad:</label>
                                                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 form-group">
                                                    <label for="obse">OBSERVACIONES DE LA FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br>
                                                    <textarea class="form-control" rows='1' data-min-rows='1' id="obse" name="obse" placeholder="Observaciones"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 form-group"></div>
                                                <div class="col-lg-4 form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">GUARDAR</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #ACACAC;">
                                <div id="nameLote"></div>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="deleteDocumentoExtranjero" method="post">
                        <div class="modal-header">
                            <h3 class="modal-title">Eliminar archivo seleccionado</h3>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row centered center-align">
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                        <p class="modal-title">¿Está seguro de querer eliminar definivamente este archivo?</p>
                                        <input type="text" class="fileToDelete" hidden />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <br><br>
                            <button type="submit" class="btn btn-primary">Si, borrar</button>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODALS-->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas" role="tab" data-toggle="tab">Nuevas</a>
                            </li>
                            <li>
                                <a href="#revision" role="tab" data-toggle="tab">En revisión</a>
                            </li>
                            <li>
                                <a href="#porPagar" role="tab" data-toggle="tab">Por pagar</a>
                            </li>
                            <li>
                                <a href="#pausadas" role="tab" data-toggle="tab">Pausadas</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <div class="col-md-12 pb-2">
                                                        <p class="card-title">
                                                            Comisiones nuevas disponibles para solicitar tu pago, para ver más detalles podrás consultarlo en el historial 
                                                            <a href="<?= base_url() ?>Comisiones/historial_colaborador">
                                                                <b>Da clic aquí para ir al historial</b>
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <?php if ($this->session->userdata('forma_pago') == 3) { ?>
                                                        <div class="col-md-12">
                                                            <p style="color:#0a548b;"><i class="fa fa-info-circle" aria-hidden="true"></i> Al monto mostrado habrá que descontar el <b>impuesto estatal</b> del
                                                                <?php
                                                                $sede = $this->session->userdata('id_sede');
                                                                $query = $this->db->query("SELECT * FROM sedes WHERE estatus in (1) AND id_sede = " . $sede . "");

                                                                foreach ($query->result() as $row) {
                                                                    $number = $row->impuesto;
                                                                    echo '<b>' . number_format($number, 2) . '%</b> e ISR de acuerdo a las tablas publicadas en el SAT.';
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    <?php } else if ($this->session->userdata('forma_pago') == 4) { ?>
                                                        <div class="col-md-12 m-1">
                                                            <p style="color:#0a548b;"><i class="fa fa-info-circle" aria-hidden="true"></i> La cantidad mostrada es menos las deducciones aplicables para el régimen de <b>Remanente Distribuible.</b>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($this->session->userdata('forma_pago') == 5) { ?>
                                                        <div class="col-md-6">
                                                            <p class="card-title pl-2">Comprobantes fiscales emitidos por residentes en el <b>extranjero</b>
                                                                sin establecimiento permanente en México.
                                                                <a data-toggle="modal" data-target="#info-modal" style="cursor: pointer;">
                                                                    <u>Da clic aquí para más información</u>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-6">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0">Saldo sin impuestos:</h4>
                                                                <p class="input-tot" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-6">
                                                            <div class="form-group text-center">
                                                                <h4 class="title-tot center-align m-0">Solicitar:</h4>
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
                                                                <th></th>
                                                                <th>ID DE PAGO</th>
                                                                <th>REFERENCIA</th>
                                                                <th>NOMBRE</th>
                                                                <th>SEDE</th>
                                                                <th>FORMA DE PAGO</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>IMPUESTO</th>
                                                                <th>% COMISIÓN</th>
                                                                <th>ESTATUS</th>
                                                                <th>MÁS</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="revision">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">
                                                    Comisiones enviadas a contraloría para su revisión antes de aplicar tu pago, si requieres 
                                                    ver más detalles como lo pagado y lo pendiente podrás consultarlo en el historial.
                                                    <a href="<?= base_url() ?>Comisiones/historial_colaborador">
                                                        <b>Da clic para ir al historial</b>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Solicitado sin impuestos:</h4>
                                                                <p class="input-tot pl-1" name="myText_revision" id="myText_revision">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>ID DE PAGO</th>
                                                        <th>REFERENCIA</th>
                                                        <th>NOMBRE</th>
                                                        <th>SEDE</th>
                                                        <th>FORMA DE PAGO</th>
                                                        <th>TOTAL DE LA COMISIÓN</th>
                                                        <th>IMPUESTO</th>
                                                        <th>% COMISIÓN</th>
                                                        <th>ESTATUS</th>
                                                        <th>MÁS</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="porPagar">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">Comisiones en proceso de pago por parte de INTERNOMEX. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial 
                                                <a href="<?= base_url() ?>Comisiones/historial_colaborador"><b>Da clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Por pagar sin impuestos:</h4>
                                                                <p class="input-tot pl-1" name="myText_pagadas" id="myText_pagadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>ID DE PAGO</th>
                                                        <th>REFERENCIA</th>
                                                        <th>NOMBRE</th>
                                                        <th>SEDE</th>
                                                        <th>FORMA DE PAGO</th>
                                                        <th>TOTAL DE LA COMISIÓN</th>
                                                        <th>IMPUESTO</th>
                                                        <th>% COMISIÓN</th>
                                                        <th>ESTATUS</th>
                                                        <th>MÁS</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="pausadas">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">
                                                    Comisiones pausadas, para ver el motivo da clic el botón de información. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial 
                                                    <a href="<?= base_url() ?>Comisiones/historial_colaborador">
                                                        <b>Da clic para ir al historial</b>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total pausado:</h4>
                                                                <p class="input-tot pl-1" name="myText_pausadas" id="myText_pausadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover" id="tabla_pausadas_comisiones" name="tabla_pausadas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th>ID DE PAGO</th>
                                                        <th>REFERENCIA</th>
                                                        <th>NOMBRE</th>
                                                        <th>SEDE</th>
                                                        <th>FORMA DE PAGO</th>
                                                        <th>TOTAL DE LA COMISIÓN</th>
                                                        <th>IMPUESTO</th>
                                                        <th>% COMISIÓN</th>
                                                        <th>ESTATUS</th>
                                                        <th>MÁS</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div><!-- main-panel close -->
    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/suma/comisionesSuma.js"></script>
</body>