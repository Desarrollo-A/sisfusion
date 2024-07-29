<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<body>
    <style>
		.bs-searchbox .form-group{
			padding-bottom: 0!important;
    		margin: 0!important;
		}
	</style>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); 
            header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        ?>
        <style>
            .abc {
                z-index: 9999999;
            }
        </style>

        <div class="modal fade bd-example-modal-sm" id="ModalEnviar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body"></div>
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

        <div id="modal_formulario_solicitud_multiple" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="generar_solicitud">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div><br>
                                                        <span class="fileinput-new">Selecciona archivo</span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 d-flex justify-center">
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
                                                    <label for="formaPago">Forma Pago:</label>
                                                    <input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value="">
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
                                                    <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br>
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

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas-1" role="tab"  data-toggle="tab">Nuevas</a>
                            </li>
                            <li>
                                <a href="#resguardo-1" role="tab" data-toggle="tab">RESGUARDO</a>
                            </li>
                            <li>
                                <a href="#proceso-1" role="tab"  data-toggle="tab">EN REVISIÓN</a>
                            </li>
                            <li>
                                <a href="#proceso-2" role="tab"  data-toggle="tab">Por pagar</a>
                            </li>
                            <li>
                                <a href="#otras-1" role="tab"  data-toggle="tab">Pausadas</a>
                            </li>
                            <li>
                                <a href="#sin_pago_neodata" role="tab" data-toggle="tab">Sin pago en NEODATA</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-2">Comisiones nuevas disponibles para solicitar tu pago, para ver más detalles podrás consultarlo en el historial. <a href="<?=base_url()?>Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                                <p style="color:#0a548b;" id="leyendaImpts">                                                
                                                </p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1" id="sumPagosNuevas">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="total_disponible" id="total_disponible">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Solicitar:</h4>
                                                                <p class="input-tot pl-1" name="total_solicitar" id="total_solicitar">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="proyectosNueva">Proyecto</label>
                                                                <select name="proyectosNueva" id="proyectosNueva" class="selectpicker select-gral proyecto" data-estatus="1" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="condominioNuevas">Condominio</label>
                                                                <select name="condominioNuevas" id="condominioNuevas" class="selectpicker select-gral condominio" data-estatus="1" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="opinion">                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover hide tablaPagos" data-id="nuevas" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID PAGO</th>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>PAGADO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>SALDO A COBRAR</th>
                                                        <th>PORCENTAJE COMISIÓN</th>
                                                        <th>DETALLE</th>
                                                        <th>ESTATUS</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones enviadas a contraloría para su revisión antes de aplicar tu pago, si requieres ver más detalles como lo pagado y lo pendiente podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1" id="sumPagosRevision">
                                                                </p>
                                                        </div>
                                                    </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total solicitado:</h4>
                                                                <p class="input-tot pl-1" name="total_solicitado" id="total_solicitado">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                            <label class="control-label" for="catalogo_revision">Proyecto</label>
                                                            <select name="catalogo_revision" id="catalogo_revision" class="selectpicker select-gral proyecto" data-estatus="4" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <label class="control-label" for="condominio_revision">Condominio</label>
                                                            <select name="condominio_revision" id="condominio_revision" class="selectpicker select-gral condominio" data-estatus="4" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover hide tablaPagos" data-id="revision" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID PAGO</th>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>PAGADO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>SALDO A COBRAR</th>
                                                        <th>PORCENTAJE COMISIÓN</th>
                                                        <th>DETALLE</th>
                                                        <th>ESTATUS</th>
                                                        <th>ACCIONES</th>
                                                    </tr>                 
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="resguardo-1">
                                            <div class="encabezadoBox">
                                        
                                            <p class="card-title pl-1">Comisiones en resguardo, si requieres ver más detalles como lo pagado y lo pendiente podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>

                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1" id="sumPagosResguardo">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total:</h4>
                                                                <p class="input-tot pl-1" name="myText_resguardo" id="myText_resguardo">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                            <div class="form-group">
                                                                <label class="control-label" for="catalogo_resguardo">Proyecto</label>
                                                                <select name="catalogo_resguardo" id="catalogo_resguardo" class="selectpicker select-gral proyecto" data-estatus="3" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="condominio_resguardo">Condominio</label>
                                                                <select name="condominio_resguardo" id="condominio_resguardo" class="selectpicker select-gral condominio" data-estatus="3" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                       
                                            <table class="table-striped table-hover hide tablaPagos" id="tabla_resguardo_comisiones" name="tabla_resguardo_comisiones">
                                                <thead>
                                                    <tr>
                                                    <th></th>
                                                        <th>ID PAGO</th>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>PAGADO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>SALDO A COBRAR</th>
                                                        <th>PORCENTAJE COMISIÓN</th>
                                                        <th>DETALLE</th>
                                                        <th>ESTATUS</th>
                                                        <th>ACCIONES</th>
                                                    </tr>                
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="proceso-2">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones en proceso de pago por parte de INTERNOMEX. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1" id="sumPagosIntmex">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total:</h4>
                                                                <p class="input-tot pl-1" name="total_pagar" id="total_pagar">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">                      
                                                            <label class="control-label" for="catalogo_pagar">Proyecto</label>
                                                            <select name="catalogo_pagar" id="catalogo_pagar" class="selectpicker select-gral proyecto" data-estatus="8" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <label class="control-label" for="condominio_pagar">Condominio</label>
                                                            <select name="condominio_pagar" id="condominio_pagar" class="selectpicker select-gral condominio" data-estatus="8" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <table class="table-striped table-hover hide tablaPagos" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                    <thead>
                                                        <tr>
                                                        <th></th>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>TOTAL COMISIÓN</th>
                                                            <th>PAGADO CLIENTE</th>
                                                            <th>DISPERSADO</th>
                                                            <th>SALDO A COBRAR</th>
                                                            <th>PORCENTAJE COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>ACCIONES</th>
                                                        </tr>                            
                                                    </thead>
                                                </table>
                                            </div>

                                        <div class="tab-pane" id="otras-1">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones pausadas, para ver el motivo da clic el botón de información. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1" id="sumPagosPausadas">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total pausado:</h4>
                                                                <p class="input-tot pl-1" name="total_otras" id="total_otras">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                            <label class="control-label" for="catalogo_otras">Proyecto</label>
                                                            <select name="catalogo_otras" id="catalogo_otras" class="selectpicker select-gral proyecto" data-estatus="6" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <label class="control-label" for="condominio_otras">Condominio</label>
                                                            <select name="condominio_otras" id="condominio_otras" class="selectpicker select-gral condominio" data-estatus="6" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table-striped table-hover hide tablaPagos" data-id="otras" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                <thead>
                                                    <tr>
                                                    <th></th>
                                                        <th>ID PAGO</th>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>PAGADO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>SALDO A COBRAR</th>
                                                        <th>PORCENTAJE COMISIÓN</th>
                                                        <th>DETALLE</th>
                                                        <th>ESTATUS</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="sin_pago_neodata">
                                            <?php $this->load->view('comisiones/complementos/sin_pago_neodata_tabla_comple'); ?>
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
    <script>
        var forma_pago = <?= $this->session->userdata('forma_pago') ?>;
        var tipo_usuario = <?= $this->session->userdata('tipo') ?>;
        var fechaServer = '<?php echo date('Y-m-d H:i:s')?>';
    </script>
    
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>                                                        
    <script src="<?=base_url()?>dist/js/controllers/casas_comisiones/casas_colaboradorRigel.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/ventas/filtrosProCond.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/ventas/sinPagoNeodata.js"></script>

</body>