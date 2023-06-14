<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<body>
    <div class="wrapper">
        <?php
        if (in_array($this->session->userdata('id_rol'), array(1,2))){
            $this->load->view('template/sidebar');
        }
        else{
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>

        <style>
            .abc {
                z-index: 9999999;
            }
        </style>

        <!-- Modals --> 
        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #B2B2B2;">
                                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

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
 
        <!-- inicia modal subir factura -->
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
                                            <div class="col-lg-7">
                                                <center>
                                                    <button class="btn btn-warning" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                                </center>
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
                                <a href="#otras-1" role="tab"  data-toggle="tab">Otras</a>
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
                                            <p class="card-title pl-2">Comisiones nuevas disponibles para solicitar tu pago, para ver más detalles podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                                                                
                                                <?php
                                                if($this->session->userdata('forma_pago') == 3){

                                                ?>
                                                <p style="color:#0a548b;"><i class="fa fa-info-circle" aria-hidden="true"></i> Recuerda que el <b>impuesto estatal</b> sobre tu pago de comisiones es de 
                                                <?php
                                                switch($this->session->userdata('id_usuario')){
                                                    case 2:
                                                    case 3:
                                                    case 1980:
                                                    case 1981:
                                                    case 1982:
                                                        $sede = 2;
                                                        break;
                                                    case 4:
                                                        $sede = 5;
                                                        break;
                                                    case 5:
                                                        $sede = 3;
                                                        break;
                                                    case 607:
                                                        $sede = 1;
                                                        break;
                                                default:
                                                $sede = $this->session->userdata('id_sede');
                                                        break;
                                                    }
                                                $query = $this->db->query("SELECT * FROM sedes WHERE estatus in (1) AND id_sede = ".$sede."");

                                                foreach ($query->result() as $row)
                                                {
                                                    $number = $row->impuesto;
                                                    echo '<b>' .number_format($number,2).'%</b> (PARA USUARIOS ASIMILADOS) y el impuesto varia segun el Estado en que te encuentres laborando.';
                                                }
                                                ?>
                                                </p>
                                                <?php

                                                }
                                                ?>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1">
                                                                    <?php
                                                                        $query = $this->db->query("SELECT Coalesce(SUM (abono_neodata),0) nuevo_general FROM pago_comision_ind WHERE estatus in (1) AND id_comision IN (select id_comision from comisiones) AND id_usuario = ".$this->session->userdata('id_usuario')."");

                                                                        foreach ($query->result() as $row)
                                                                        {
                                                                            $number = $row->nuevo_general;
                                                                            echo ''. number_format($number, 3).'';
                                                                        }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Solicitar:</h4>
                                                                <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label  class="m-0" for="proyecto1">Proyecto</label>
                                                                <select name="proyecto1" id="proyecto1" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                    <option value="0">Selecciona una opción</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="condominio1">Condominio</label>
                                                                <select name="condominio1" id="condominio1" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                    <option disabled selected>Selecciona una opción</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">                    
                                                            <?php
                                                            
                                                            $query = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario = ".$this->session->userdata('id_usuario')."");

                                                            foreach ($query->result() as $row)
                                                            {
                                                            $forma_pago = $row->forma_pago;

                                                            if( $forma_pago  == 2 ||  $forma_pago == '2'){
                                                                if(count($opn_cumplimiento) == 0){

                                                            echo '<a href="https://maderascrm.gphsis.com/index.php/Usuarios/configureProfile"> <span class="label label-danger" style="background:red;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA ></span> </a>';
                                                            } else{

                                                                if($opn_cumplimiento[0]['estatus'] == 1){

                                                                    echo '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';

                                                                }else if($opn_cumplimiento[0]['estatus'] == 0){
                                                                    echo '<a href="https://maderascrm.gphsis.com/index.php/Usuarios/configureProfile"> <span class="label label-danger" style="background:orange;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>';

                                                                }else if($opn_cumplimiento[0]['estatus'] == 2){
                                                                    echo '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';

                                                                }
                                                            }

                                                                }
                                                                else{
                                                                    echo '';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones"><thead>
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
                                                            <th>% COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>MÁS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones enviadas a contraloría para su revisión antes de aplicar tu pago, si requieres ver más detalles como lo pagado y lo pendiente podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1">
                                                                    <?php
                                                                    $query = $this->db->query("SELECT Coalesce(SUM (abono_neodata),0) nuevo_general FROM pago_comision_ind WHERE estatus in (4) AND id_comision IN (select id_comision from comisiones) AND id_usuario = ".$this->session->userdata('id_usuario')."");

                                                                    foreach ($query->result() as $row)
                                                                    {
                                                                        $number = $row->nuevo_general;
                                                                        echo '' . number_format($number, 3).'';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total solicitado:</h4>
                                                                <p class="input-tot pl-1" name="myText_proceso" id="myText_proceso">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <label class="m-0" for="proyecto2">Proyecto</label>
                                                            <select name="proyecto2" id="proyecto2" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                <option value="0">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <label class="m-0" for="condominio2">Condominio</label>
                                                            <select name="condominio2" id="condominio2" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                <option disabled selected>Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>TOTAL COMISIÓN</th>
                                                            <th>PAGADO CLIENTE</th>
                                                            <th>DISPERSADO</th>
                                                            <th>SALDO A COBRAR</th>
                                                            <th>% COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>MÁS</th>
                                                        </tr>                 
                                                    </thead>
                                                </table>
                                            </div>
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
                                                                <p class="input-tot pl-1">
                                                                    <?php
                                                                    $query = $this->db->query("SELECT Coalesce(SUM (abono_neodata),0) nuevo_general FROM pago_comision_ind WHERE estatus in (3) AND id_comision IN (select id_comision from comisiones) AND id_usuario = ".$this->session->userdata('id_usuario')."");

                                                                    foreach ($query->result() as $row)
                                                                    {
                                                                        $number = $row->nuevo_general;
                                                                        echo '' . number_format($number, 3).'';
                                                                    }
                                                                    ?>
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
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label class="m-0" for="proyecto28">Proyecto</label>
                                                                <select name="proyecto28" id="proyecto28" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                    <option value="0">Selecciona una opción</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label class="m-0" for="condominio28">Condominio</label>
                                                                <select name="condominio28" id="condominio28" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                    <option disabled selected>Selecciona una opción</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                       
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_resguardo_comisiones" name="tabla_resguardo_comisiones">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>TOTAL COMISIÓN</th>
                                                            <th>PAGADO CLIENTE</th>
                                                            <th>DISPERSADO</th>
                                                            <th>SALDO A COBRAR</th>
                                                            <th>% COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>MÁS</th>
                                                        </tr>                
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-2">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones en proceso de pago por parte de INTERNOMEX. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1">
                                                                    <?php
                                                                    $query = $this->db->query("SELECT Coalesce(SUM (abono_neodata),0) nuevo_general FROM pago_comision_ind WHERE estatus in (8) AND id_comision IN (select id_comision from comisiones) AND id_usuario = ".$this->session->userdata('id_usuario')."");

                                                                    foreach ($query->result() as $row)
                                                                    {
                                                                        $number = $row->nuevo_general;
                                                                        echo '' . number_format($number, 3).'';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total:</h4>
                                                                <p class="input-tot pl-1" name="myText_pagadas" id="myText_pagadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">                      
                                                            <label class="m-0" for="proyecto3">Proyecto</label>
                                                            <select name="proyecto3" id="proyecto3" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                <option value="0">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <label class="m-0" for="condominio3">Condominio</label>
                                                            <select name="condominio3" id="condominio3" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                <option disabled selected>Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>TOTAL COMISIÓN</th>
                                                            <th>PAGADO CLIENTE</th>
                                                            <th>DISPERSADO</th>
                                                            <th>SALDO A COBRAR</th>
                                                            <th>% COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>MÁS</th>
                                                        </tr>                            
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /////////////// -->
                                        <div class="tab-pane" id="otras-1">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones pausadas, para ver el motivo da clic el botón de información. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el historial. <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador"><b>clic para ir al historial</b></a>.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Saldo total:</h4>
                                                                <p class="input-tot pl-1">
                                                                <?php
                                                                    $query = $this->db->query("SELECT Coalesce(SUM (abono_neodata),0) nuevo_general FROM pago_comision_ind WHERE estatus in (6) AND id_comision IN (select id_comision from comisiones) AND id_usuario = ".$this->session->userdata('id_usuario')."");

                                                                    foreach ($query->result() as $row)
                                                                    {
                                                                        $number = $row->nuevo_general;
                                                                        echo '' . number_format($number, 3).'';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total pausado:</h4>
                                                                <p class="input-tot pl-1" name="myText_otras" id="myText_otras">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <label class="m-0" for="proyecto4">Proyecto</label>
                                                            <select name="proyecto4" id="proyecto4" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                <option value="0">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                            <label class="m-0" for="condominio4">Condominio</label>
                                                            <select name="condominio4" id="condominio4" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                <option disabled selected>Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>TOTAL COMISIÓN</th>
                                                            <th>PAGADO CLIENTE</th>
                                                            <th>DISPERSADO</th>
                                                            <th>SALDO A COBRAR</th>
                                                            <th>% COMISIÓN</th>
                                                            <th>DETALLE</th>
                                                            <th>ESTATUS</th>
                                                            <th>MÁS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="sin_pago_neodata">
                                            <div class="encabezadoBox">
                                            <p class="card-title pl-1">Comisiones sin pago reflejado en NEODATA y que por ello no se han dispersado ciertos lotes con tus comisiones.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <?php ?>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="m-0" for="proyecto">Proyecto</label>
                                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                                        <option value="0">Selecciona una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="m-0" for="condominio">Condominio</label>
                                                                    <select name="condominio" id="condominio" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                                        <option disabled selected>Selecciona una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php  ?> 
                                                </div>
                                            </div>
                                            <div class="table-responsive">
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
    <!--main-panel close-->
    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        userType = <?= $this->session->userdata('id_rol') ?> ;
        userID = <?= $this->session->userdata('id_usuario') ?> ;
        $(document).ready(function() {
            $.post(url + "Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
                    $("#proyecto28").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#proyecto").selectpicker('refresh');
                $("#proyecto28").selectpicker('refresh');
            }, 'json');

            for (let index = 1; index <= 4; index++) {
                    $.post(url + "Contratacion/lista_proyecto", function (data) {
                    var len = data.length;
                    for (var i = 0; i < len; i++) {
                        var id = data[i]['idResidencial'];
                        var name = data[i]['descripcion'];
                        $('#proyecto'+index).append($('<option>').val(id).text(name.toUpperCase()));
                        $('#proyecto28'+index).append($('<option>').val(id).text(name.toUpperCase()));
                    }

                    $('#proyecto'+index).selectpicker('refresh');
                    $('#proyecto28'+index).selectpicker('refresh');
                }, 'json');
            }
        });

        $('#proyecto').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $("#condominio").html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $("#condominio").append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++){
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#condominio").selectpicker('refresh');
                }, 'json');
            });
            if (userType != 2 && userType != 3 && userType != 13 && userType != 32 && userType != 17) { // SÓLO MANDA LA PETICIÓN SINO ES SUBDIRECTOR O GERENTE
                fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
            }
        });

        $('#condominio').change( function(){
            index_proyecto = $('#proyecto').val();
            index_condominio = $(this).val();
            fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
        });


        $('#proyecto28').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $("#condominio28").html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $("#condominio28").append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++){
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $("#condominio28").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#condominio28").selectpicker('refresh');
                }, 'json');
            });

            fillCommissionTableRESGUARDO(index_proyecto, index_condominio);
        });
        
        $('#condominio28').change( function(){
            index_proyecto = $('#proyecto28').val();
            index_condominio = $(this).val();
            fillCommissionTableRESGUARDO(index_proyecto, index_condominio);
        });

        $('#proyecto1').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $('#condominio1').html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $('#condominio1').append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++){
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $('#condominio1').append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $('#condominio1').selectpicker('refresh');
                }, 'json');
            });
            fillCommissionTableNUEVAS(index_proyecto, 0);
        });

        $('#condominio1').change( function(){
            index_proyecto = $('#proyecto1').val();
            index_condominio = $(this).val();
            fillCommissionTableNUEVAS(index_proyecto, index_condominio);
        });

        $('#proyecto2').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $('#condominio2').html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $('#condominio2').append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++){
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $('#condominio2').append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $('#condominio2').selectpicker('refresh');
                }, 'json');
            });
            fillCommissionTableREVISION(index_proyecto, 0);
        });

        $('#condominio2').change( function(){
            index_proyecto = $('#proyecto2').val();
            index_condominio = $(this).val();
            fillCommissionTableREVISION(index_proyecto, index_condominio);
        });
        
        /**--------------------------------------------------------------------------- */
        $('#proyecto3').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $('#condominio3').html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $('#condominio3').append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++)
                    {
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $('#condominio3').append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $('#condominio3').selectpicker('refresh');
                }, 'json');
            });
            fillCommissionTablePAGADAS(index_proyecto, 0);
        });

        $('#condominio3').change( function(){
            index_proyecto = $('#proyecto3').val();
            index_condominio = $(this).val();
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            fillCommissionTablePAGADAS(index_proyecto, index_condominio);
        });
        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totaPen = 0;
        var tr;

        $('#proyecto4').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $('#condominio4').html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $('#condominio4').append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++){
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $('#condominio4').append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $('#condominio4').selectpicker('refresh');
                }, 'json');
            });
            
            fillCommissionTableOTRAS(index_proyecto, 0);
        });

        $('#condominio4').change( function(){
            index_proyecto = $('#proyecto4').val();
            index_condominio = $(this).val();
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            fillCommissionTableOTRAS(index_proyecto, index_condominio);
        });

        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var totalLeon = 0;
        var totalQro = 0;
        var totalSlp = 0;
        var totalMerida = 0;
        var totalCdmx = 0;
        var totalCancun = 0;
        var tr;
        var tableDinamicMKTD2 ;
        var totaPen = 0;
        let titulos = [];
        $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_nuevas.column(i).search() !== this.value) {
                        tabla_nuevas
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_nuevas.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_nuevas.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_nuevas").textContent = formatMoney(total);
                    }
                });
            }
            else {
                $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
            }
        });

        function fillCommissionTableNUEVAS(proyecto,condominio){
            $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas").textContent = '$' + to;
            });
    
            $("#tabla_nuevas_comisiones").prop("hidden", false);
            tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [
                <?php if($this->session->userdata('forma_pago') != 2 ){?> {
                    text: '<i class="fas fa-paper-plane"></i>SOLICITAR PAGO',
                    action: function() {
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth()+1;
                        var anio = hoy.getFullYear();
                        var hora = hoy.getHours();
                        var minuto = hoy.getMinutes();

                        if (
                        ((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                        ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                        ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13))){

                            if ($('input[name="idT[]"]:checked').length > 0) {
                                $('#spiner-loader').removeClass('hide');
                                var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                    return this.value;
                                }).get();

                                var com2 = new FormData();
                                com2.append("idcomision", idcomision); 

                                $.ajax({
                                    url : url2 + 'Comisiones/acepto_comisiones_user/',
                                    data: com2,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    type: 'POST', 
                                    success: function(data){
                                        response = JSON.parse(data);
                                        if(data == 1) {
                                            $('#spiner-loader').addClass('hide');
                                            $("#totpagarPen").html(formatMoney(0));
                                            $("#all").prop('checked', false);
                                            var fecha = new Date();

                                            alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");

                                            tabla_nuevas.ajax.reload();
                                            tabla_revision.ajax.reload();
                                        }else if(data == 2) {
                                            $('#spiner-loader').addClass('hide');
                                            $("#all").prop('checked', false);
                                            var fecha = new Date();

                                            alerts.showNotification("top", "right", "ESTÁS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES.", "warning");
                                        }
                                        else {
                                            $('#spiner-loader').addClass('hide');
                                            alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                        }
                                    },
                                    error: function( data ){
                                        $('#spiner-loader').addClass('hide');
                                        alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                    }
                                });
                            }
                        }
                        else{
                            $('#spiner-loader').addClass('hide');
                            alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al lunes y martes de la semana de corte", "warning");      
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                    }
                },
                <?php } ?>
                {
                    text: '<i class="fa fa-share" aria-hidden="true"></i> ENVIAR A RESGUARDO',
                    action: function() {
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth()+1;
                        var anio = hoy.getFullYear();
                        var hora = hoy.getHours();
                        var minuto = hoy.getMinutes();

                         if (
                        ((mes == 10 && dia == 12) || (mes == 10 && dia == 13 && hora <= 13)) ||
                        ((mes == 11 && dia == 9) || (mes == 11 && dia == 10 && hora <= 13)) ||
                        ((mes == 12 && dia == 14) || (mes == 12 && dia == 15 && hora <= 13))){

                            if ($('input[name="idT[]"]:checked').length > 0) {
                                $('#spiner-loader').removeClass('hide');
                                var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                    return this.value;
                                }).get();

                                var com2 = new FormData();
                                com2.append("idcomision", idcomision); 

                                $.ajax({
                                    url : url2 + 'Comisiones/acepto_comisiones_resguardo/',
                                    data: com2,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    type: 'POST', 
                                    success: function(data){
                                        response = JSON.parse(data);
                                        if(data == 1) {
                                            $('#spiner-loader').addClass('hide');
                                            $("#totpagarPen").html(formatMoney(0));
                                            $("#all").prop('checked', false);
                                            var fecha = new Date();

                                            alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Resguardo.", "success");

                                            tabla_nuevas.ajax.reload();
                                            tabla_revision.ajax.reload();
                                        } else {
                                            $('#spiner-loader').addClass('hide');
                                            alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                        }
                                    },
                                    error: function( data ){
                                            $('#spiner-loader').addClass('hide');
                                            alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                    }
                                });  
                            }
                        }
                        else {
                            $('#spiner-loader').addClass('hide');
                            alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al miercoles y jueves de la semana de corte", "warning"); 
                        }
                    },
                    attr: {
                        class: 'btn buttons-pdf',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES NUEVAS',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'ID PAGO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'LOTE';
                                }else if(columnIdx == 4){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 5){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 6){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 7){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 8){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 9){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 10){
                                    return 'DETALLE';
                                }else if(columnIdx == 11){
                                    return 'ESTATUS NUEVAS';
                                }else if(columnIdx != 12 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    }
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%"
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_i + '</p>';
                    }
                },

                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
            
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },

                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        switch (d.forma_pago) {
                            case '1': //SIN DEFINIR
                            case 1: //SIN DEFINIr
                                return '<p class="m-0"><span class="label" style="background:#B3B4B4;">SIN DEFINIR FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                            break;

                            case '2': //FACTURA
                            case 2: //FACTURA
                                return '<p class="m-0"><span class="label" style="background:#806AB7;">FACTURA</span></p><p style="font-size: .5em"><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';
                            break;

                            case '3': //ASIMILADOS
                            case 3: //ASIMILADOS
                                return '<p class="m-0"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                            break;

                            case '4': //RD
                            case 4: //RD
                                return '<p class="m-0"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                            break;

                            default:
                                return '<p class="m-0"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                            break;
                        }
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_nuevas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center',
                    render: function(d, type, full, meta) {
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth()+1;
                        var anio = hoy.getFullYear();
                        var hora = hoy.getHours();
                        var minuto = hoy.getMinutes();

                        if (

                        ((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                        ((mes == 10 && dia == 12) || (mes == 10 && dia == 13 && hora <= 13)) ||

                        ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                        ((mes == 11 && dia == 9) || (mes == 11 && dia == 10 && hora <= 13)) ||

                        ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)) ||
                        ((mes == 12 && dia == 14) || (mes == 12 && dia == 15 && hora <= 13))

                        )
                        {
                            switch (full.forma_pago) {
                                case '1': //SIN DEFINIR
                                case 1: //SIN DEFINIR
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                break;
                                case '2': //FACTURA
                                case 2: //FACTURA
                                case '3': //ASIMILADOS
                                case 3: //ASIMILADOS
                                case '4': //RD
                                case 4: //RD
                                default:
                                    return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                                break;
                            }
                        } 
                        else {
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        }
                    },
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+1,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });

            $('#tabla_nuevas_comisiones').on('click', 'input', function () {
                tr = $(this).closest('tr');
                var row = tabla_nuevas.row(tr).data();
                if (row.pa == 0) {
                    row.pa = row.pago_cliente;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                }
                else {
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }
                $("#totpagarPen").html(formatMoney(totaPen));
            });
    
            $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_nuevas", function(){
                id_pago = $(this).val();
                user = $(this).attr("data-usuario");

                $("#seeInformationModalAsimilados").modal();
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b><br><i style="color:gray;">'+v.comentario+'</i></p><br></div>');
                    });
                });
            });
        }
        //FIN TABLA NUEVA

        // INICIO TABLA RESGUARDO
        $('#tabla_resguardo_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 11 ){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_resguardo.column(i).search() !== this.value) {
                        tabla_resguardo
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_resguardo.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_resguardo.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_resguardo").textContent = formatMoney(total);
                    }
                });
            }
        });

        function fillCommissionTableRESGUARDO(proyecto,condominio){
            $('#tabla_resguardo_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_resguardo").textContent = '$' + to;
            });
        
            $("#tabla_resguardo_comisiones").prop("hidden", false);
            tabla_resguardo = $("#tabla_resguardo_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES EN RESGUARDO',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS RESGUARDO';
                                }else if(columnIdx != 11 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="m-0"><span class="label" style="background:#22CB99;">RESGUARDO PERSONAL</span></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_resguardo" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+3,

                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
    
            $("#tabla_resguardo_comisiones tbody").on("click", ".consultar_logs_resguardo", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#22CB99; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:22CB99;">'+v.comentario+'</i><br><b style="color:#22CB99">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }
        // FIN TABLA RESFUARDO

        // INICIO TABLA EN REVISION
        $('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 11 ){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_revision.column(i).search() !== this.value) {
                        tabla_revision
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_revision.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_revision.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_proceso").textContent = formatMoney(total);
                    }
                });
            }
        });

        function fillCommissionTableREVISION(proyecto,condominio){
            $('#tabla_revision_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_proceso").textContent = '$' + to;
            });
        
            $("#tabla_revision_comisiones").prop("hidden", false);
            tabla_revision = $("#tabla_revision_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES EN REVISION',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS REVISION';
                                }else if(columnIdx != 11 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="m-0"><span class="label" style="background:#2242CB;">REVISIÓN CONTRALORÍA</span></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_revision" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+4,

                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });

            $("#tabla_revision_comisiones tbody").on("click", ".consultar_logs_revision", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#2242CB; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:2242CB;">'+v.comentario+'</i><br><b style="color:#2242CB">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }
        // FIN TABLA PROCESO

        // INICIO TABLA EN PAGADAS
        $('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 11 ){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_pagadas.column(i).search() !== this.value) {
                        tabla_pagadas
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_pagadas.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_pagadas.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_pagadas").textContent = formatMoney(total);
                    }
                });
            }
        });

        function fillCommissionTablePAGADAS(proyecto,condominio){
            $('#tabla_pagadas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_pagadas").textContent = '$' + to;
            });
        
            $("#tabla_pagadas_comisiones").prop("hidden", false);
            tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES POR PAGAR',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS POR PAGA';
                                }else if(columnIdx != 11 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
            
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {

                        return '<p class="m-0"><span class="label" style="background:#9321B6;">REVISIÓN INTERNOMEX</span></p>';
                        
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {

                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini consultar_logs_pagadas" style="background: #9321B6;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;&nbsp;';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+8,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });

            $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_logs_pagadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#9321B6; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');

                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:9321B6;">'+v.comentario+'</i><br><b style="color:#9321B6">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }
        // FIN TABLA PAGADAS

        // INICIO TABLA OTRAS
        $('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 11 ){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_otras.column(i).search() !== this.value) {
                        tabla_otras
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_otras.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_otras.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_otras").textContent = formatMoney(total);
                    }
                });
            }
        });

        function fillCommissionTableOTRAS(proyecto,condominio){
            $('#tabla_otras_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_otras").textContent = '$' + to;
            });
        
            $("#tabla_otras_comisiones").prop("hidden", false);
            tabla_otras = $("#tabla_otras_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE DE COMISIONES PAUSADAS POR CONTRALORÍA',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 5){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 6){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 7){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 8){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 9){
                                    return 'DETALLE';
                                }else if(columnIdx == 10){
                                    return 'ESTATUS PAUSADAS';
                                }else if(columnIdx != 11 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){

                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;">Penalización + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="m-0"><span class="label" style="background:#CB7922;">EN PAUSA</span></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pausadas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+6,

                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
    
            $("#tabla_otras_comisiones tbody").on("click", ".consultar_logs_pausadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#CB7922; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:CB7922;">'+v.comentario+'</i><br><b style="color:#CB7922">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }
        // FIN TABLA OTRAS

        //INICIO SIN PAGO EN NEODATA
        $('#tabla_comisiones_sin_pago thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value) {
                    $('#tabla_comisiones_sin_pago').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        function fillCommissionTableWithoutPayment (proyecto, condominio) {
            tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
                dom: "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'><'col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-end p-0'l>rt><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    data: function(d) {
                        return '<p class="m-0">' + d.idLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCondominio + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCliente + ' </p>';
                    }
                },

                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreAsesor + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCoordinador + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreGerente + '</p>';
                    }
                },
                {
                    data: function(d) {
                        switch (d.reason) {
                            case '0':
                                return '<p class="m-0"><b>En espera de próximo abono en NEODATA </b></p>';
                            break;
                            case '1':
                                return '<p class="m-0"><b>No hay saldo a favor. Esperar próxima aplicación de pago. </b></p>';
                            break;
                            case '2':
                                return '<p class="m-0"><b>No se encontró esta referencia </b></p>';
                            break;
                            case '3':
                                return '<p class="m-0"><b>No tiene vivienda, si hay referencia </b></p>';
                            break;
                            case '4':
                                return '<p class="m-0"><b>No hay pagos aplicados a esta referencia </b></p>';
                            break;
                            case '5':
                                return '<p class="m-0"><b>Referencia duplicada </b></p>';
                            break;
                            default:
                                return '<p class="m-0"><b>Sin localizar </b></p>';
                            break;
                        }
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "ComisionesNeo/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
        };

        $(window).resize(function() {
            tabla_nuevas.columns.adjust();
            tabla_revision.columns.adjust();
            tabla_pagadas.columns.adjust();
            tabla_otras.columns.adjust();
        });

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $(document).on("click", ".subir_factura", function() {
            resear_formulario();
            id_comision = $(this).val();
            total = $(this).attr("data-total");
            link_post = "Comisiones/guardar_solicitud/" + id_comision;
            $("#modal_formulario_solicitud").modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modal_formulario_solicitud .modal-body #frmnewsol").append(`<div id="inputhidden"><input type="hidden" id="comision_xml" name="comision_xml" value="${ id_comision}">
            <input type="hidden" id="pago_cliente" name="pago_cliente" value="${ parseFloat(total).toFixed(2) }"></div>`);
        });

        let c = 0;

        function saveX() {
            document.getElementById('btng').disabled=true;
            save2();
        }

        function EnviarDesarrollos() {
            document.getElementById('btn_EnviarM').disabled=true;
            var formData = new FormData(document.getElementById("selectDesa"));
            formData.append("dato", "valor");
            $.ajax({
                url: url + 'Comisiones/EnviarDesarrollos',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {

                    if (data == 1) {
                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente.", "success");
                        document.getElementById('btn_EnviarM').disabled=false;
                        location.reload();
                        $("#ModalEnviar").modal("hide");
                    } else {
                        alerts.showNotification("top", "right", "No se ha podido completar la solicitud.", "warning");
                    }
                },
                error: function() {
                    document.getElementById('btn_EnviarM').disabled=false;
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
 

        /** -----------------------------------------*/
 

        function todos(){
            if($(".checkdata1:checked").length == 0){
                $(".checkdata1").prop("checked", true);
                sumCheck();
            }
            else if($(".checkdata1:checked").length < $(".checkdata1").length){
                $(".checkdata1").prop("checked", true);
                sumCheck();
            
            }
            else if($(".checkdata1:checked").length == $(".checkdata1").length){
                $(".checkdata1").prop("checked", false);
                sumCheck();
            }
        }


        $(document).on("click", ".subir_factura_multiple", function() {  
            var hoy = new Date();
            var dia = hoy.getDate();
            var mes = hoy.getMonth()+1;
            var anio = hoy.getFullYear();
            var hora = hoy.getHours();
            var minuto = hoy.getMinutes();

            if (
                        ((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                        ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                        ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)))
            {
            
                    $("#modal_multiples .modal-body").html("");
                    $("#modal_multiples .modal-header").html("");
                    $("#modal_multiples .modal-header").append(`<div class="row">
                    <div class="col-md-12 text-right">
                    <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:40px;">&times;</span>
                    </button>
                    </div>
                    <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);


                    $.post('getDesarrolloSelect', function(data) {
                        c = 0;
                        if(data == 3){
                            $("#desarrolloSelect").append('<option selected="selected" disabled>ESTÁS FUERA DE TIEMPO</option>');
                        }
                        else{
                            $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                            var len = data.length;
                            for (var i = 0; i < len; i++) {
                                var id = data[i]['id_usuario'];
                                var name = data[i]['name_user'];
                                $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if (len <= 0) {
                                $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            }
                            $("#desarrolloSelect").val(0);
                            $("#desarrolloSelect").selectpicker('refresh');
                        }}, 'json');

                $('#desarrolloSelect').change(function() {
                    c=0;

                    var valorSeleccionado = $(this).val();
                    $("#modal_multiples .modal-body").html("");
                    $.getJSON(url + "Comisiones/getDatosProyecto/" + valorSeleccionado).done(function(data) {
                        let sumaComision = 0;
                        if (!data) {
                            $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');

                        } 
                        else {
                            if(data.length > 0){
                                $("#modal_multiples .modal-body").append(`<div class="row">
                                <div class="col-md-1"><input type="checkbox" class="form-control" onclick="todos();" id="btn_all"></div><div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b></div>`);
                            }

                            $.each(data, function(i, v) {
                                c++;
                                abono_asesor = (v.abono_neodata);
                                $("#modal_multiples .modal-body").append('<div class="row">'+
                                '<div class="col-md-1"><input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult' + i + '" name="comisiones_facura_mult"></div><div class="col-md-4"><input id="data1' + i + '" name="data1' + i + '" value="' + v.nombreLote + '" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%"></div><div class="col-md-4"><input type="hidden" id="idpago-' + i + '" name="idpago-' + i + '" value="' + v.id_pago_i + '"><input id="data2' + i + '" name="data2' + i + '" value="' + "" + abono_asesor + '" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%"></div></div>');
                            });

                            $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12 text-left"><b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b></div><div class="col-lg-5"><div class="fileinput fileinput-new text-center" data-provides="fileinput"><div><br><span class="fileinput-new">Selecciona archivo</span><input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml"></div></div></div><div class="col-lg-7"><center><button class="btn btn-warning" type="button" onclick="xml2()" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center></div></div>');

                            $("#modal_multiples .modal-body").append('<p id="cantidadSeleccionada"></p>');
                            $("#modal_multiples .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                            $("#modal_multiples .modal-body").append('<form id="frmnewsol2" method="post">' +
                                '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                                '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                                '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                                '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                                '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                                '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                                '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                                '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                                '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                                ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"><button type="button" id="btng" onclick="saveX();" disabled class="btn btn-primary btn-block">GUARDAR</button></div><div class="col-md-4"></div><div class="col-md-4"> <button type="button" data-dismiss="modal"  class="btn btn-danger btn-block close_modal_xml">CANCELAR</button></div></div></form>');
                        }
                    });
                });

                $("#modal_multiples").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
            else{
                alert("NO PUEDES SUBIR FACTURAS HASTA EL PRÓXIMO CORTE.");
            }
        });

        //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
        function resear_formulario() {
            $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
            $("#modal_formulario_solicitud textarea").html('');

            $("#modal_formulario_solicitud #obse").val('');

            var validator = $("#frmnewsol").validate();
            validator.resetForm();
            $("#frmnewsol div").removeClass("has-error");
        }

        $("#cargar_xml").click(function() {
            subir_xml($("#xmlfile"));
        });

        function xml2() {
            subir_xml2($("#xmlfile2"));
        }

        var justificacion_globla = "";

        function subir_xml(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;
            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    } else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }

        function subir_xml2(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);

            resear_formulario();

            $.ajax({
                url: url + "Comisiones/cargaxml2",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml2(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    }
                    else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }
 
        function closeModalEng(){
            document.getElementById("frmnewsol").reset();
            document.getElementById("xmlfile").value = "";
            document.getElementById("totalxml").innerHTML = '';

            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);
        
            $("#modal_formulario_solicitud").modal('toggle');
        }

        function cargar_info_xml(informacion_factura) {
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let pago_cliente = $('#pago_cliente').val();
            let pago1 = parseFloat(pago_cliente) + .05;
            let pago2 = parseFloat(pago_cliente ) - .05;

            if (parseFloat(pago1).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= parseFloat(pago2).toFixed(2)) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btnIndi').disabled = false;
                console.log("Cantidad correcta");
                document.getElementById("totalxml").innerHTML = '';
                disabled();
            } else {
                document.getElementById("totalxml").innerHTML = 'Cantidad incorrecta:'+ cantidadXml;
                let elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btnIndi').disabled = true;
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
                console.log("cantidad incorrecta");
            }

            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }

        let pagos = [];

        function cargar_info_xml2(informacion_factura) {
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;
                }
            }
            
            var myCommentsList = document.getElementById('cantidadSeleccionada');
            myCommentsList.innerHTML = '';
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let cantidadXml2 = Number.parseFloat(informacion_factura.total[0]);
            var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
            myCommentsList.setAttribute('style', 'color:green;');
            myCommentsList.innerHTML = 'Cantidad correcta';
            if ((suma + .10).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .10).toFixed(2)) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btng').disabled = false;
                disabled()
            }
            else {
                var elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btng').disabled = true;
                var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
                myCommentsList.setAttribute('style', 'color:red;');
                myCommentsList.innerHTML = 'Cantidad incorrecta';
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
            }

            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }

        function sumCheck(){
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;
                }
            }
            var myCommentsList = document.getElementById('sumacheck');
            myCommentsList.innerHTML = 'Suma seleccionada: $ ' + formatMoney(suma.toFixed(3));
        }

        function disabled(){
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
                    document.getElementById("comisiones_facura_mult" + index).disabled = true;
                    document.getElementById("btn_all").disabled = true;
                }
            }
        } 

        function save2() {
            var formData = new FormData(document.getElementById("frmnewsol2"));
            formData.append("dato", "valor");
            formData.append("xmlfile", documento_xml);
            formData.append("pagos",pagos);
            $.ajax({
                url: url + 'Comisiones/guardar_solicitud2',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    document.getElementById('btng').disabled=false;
                    if (data.resultado) {
                        alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");
                    } else if(data.resultado == 3){
                        alert("ESTAS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES");
                        $('#loader').addClass('hidden');
                        $("#modal_multiples").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");

                    }
                    else {
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },
                error: function() {
                    document.getElementById('btng').disabled=false;
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }

        $("#frmnewsol").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        $("#frmnewsol2").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                alert(data);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function calcularMontoParcialidad() {
            $precioFinal = parseFloat($('#value_pago_cliente').val());
            $precioNuevo = parseFloat($('#new_value_parcial').val());

            if ($precioNuevo >= $precioFinal) {
                $('#label_estado').append('<label>MONTO NO VALIDO</label>');
            } 
            else if ($precioNuevo < $precioFinal) {
                $('#label_estado').append('<label>MONTO VALIDO</label>');
            }
        }

        function preview_info(archivo) {
            $("#documento_preview .modal-dialog").html("");
            $("#documento_preview").css('z-index', 9999);
            archivo = url + "dist/documentos/" + archivo + "";
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(archivo)[1];
            elemento = "";
            if (ext == 'pdf') {
                elemento += '<iframe src="' + archivo + '" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
                elemento += '</iframe>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'jpg' || ext == 'jpeg') {
                elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
                elemento += '<img src="' + archivo + '" style="overflow:hidden; width: 40%;">';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'xlsx') {
                elemento += '<div class="modal-content">';
                elemento += '<iframe src="' + archivo + '"></iframe>';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
            }
        }

        function cleanComments() {
            var myCommentsList = document.getElementById('comments-list-factura');
            myCommentsList.innerHTML = '';
            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }

        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            myCommentsList.innerHTML = '';
        }
 
        function selectAll(e) {
            tota2 = 0;
            $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
                if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    tota2 += parseFloat(tabla_nuevas.row($(this).closest('tr')).data().pago_cliente);
                } else {
                    $(this).prop("checked", false);
                }
                $("#totpagarPen").html(formatMoney(tota2));
            });
        }
    </script>
</body>