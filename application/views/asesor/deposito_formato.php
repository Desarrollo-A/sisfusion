
<link href="<?= base_url() ?>dist/css/depositoSeriedad.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    div.dropdown-menu.open{
        max-height: 314px !important;
        overflow: hidden;
    }
    ul.dropdown-menu.inner{
        max-height: 260px !important;
        overflow-y: auto;
    }
</style>

<body>
<div class="wrapper">
    <?php
        if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 6, 2)) || in_array($this->session->userdata('id_usuario'), array(2752, 2826, 2810, 2855, 2815, 5957, 6390, 4857, 2834, 9775, 12377, 2799, 10088, 2827, 6012, 12931, 14342, 13334, 11532, 11655, 16679, 17043)) AND $onlyView==0){
            $readOnly = '';
            $statsInput = '';
            $html_action = '<form id="deposito-seriedad-form">';
            $html_action_end = '</form>';
        }
        else{
            $readOnly = 'readonly';
            $statsInput = 'disabled';
            $html_action = '';
            $html_action_end = '';
        }

        if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || in_array($this->session->userdata('id_usuario'), [2752, 2826, 2810, 5957, 6390, 4857, 2834, 11655])){
            $readonlyNameToAsesor = 'readonly';
        }
        else{
            $readonlyNameToAsesor='';
        }
    ?>
    <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                    Este proceso puede demorar algunos segundos
                </div>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="mainBoxDS">
        <div class="card">
            <?php echo $html_action;?> 
            <?php if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 6, 2)) || in_array($this->session->userdata('id_usuario'), array(2752, 2826, 2810, 2855, 2815, 5957, 6390, 4857, 2834, 9775, 12377, 2799, 10088, 2827, 6012, 12931, 14342, 13334, 11532, 11655, 16679, 17043)) AND $onlyView==0){?>
                <section id="sectionBtns">
                    <button data-i18n="guardar-cambios" type="submit" id="depositoSeriedadGuardar" name="guardarC" class="btn btnAction" onclick="validaTipoVivienda();">GUARDAR CAMBIOS</button>
                </section>
            <?php } else { ?>
                <section id="sectionBtns">
                    <a href="<?=base_url()?>index.php/Asesor/imprimir_ds/<?=$cliente[0]->id_cliente?>" target="_blank" class="btn btnAction">IMPRIMIR DEPÓSITO</a>
                </section>
            <?php }?>
            <div class="container-fluid" id="mainContainer">
                <div class="row" id="encabezadoDS">
                    <div class="col-12 col-sm-6 col-md-5 col-lg-5">
                        <img  class="w-100" src="<?=base_url()?>static/images/Logo_CM&TP_1.png" alt="Servicios Condominales" title="Servicios Condominales"/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-7 col-lg-7">
                        <h3 class="m-0 mb-1" data-i18n="deposito-seriedad">DEPÓSITO DE SERIEDAD<i class="fas fa-info-circle" style="cursor: pointer;" onclick="historial()"></i></h3>
                        <h6 class="m-0"><span data-i18n="modificacion">Modificación</span>: <?php echo $cliente[0]->fecha_modificacion;?></h6>
                        <h6 class="m-0"><span data-i18n="folio">Folio</span>: <span><?php echo $cliente[0]->clave; ?></span></h6>
                        <input type="hidden" name="clavevalor" id="clavevalor"  value="<?php echo $cliente[0]->clave; ?>">
                        <input type="hidden" name="id_cliente" id="id_cliente"  value="<?php echo $cliente[0]->id_cliente; ?>">
                        <input type="hidden" name="proceso" id="proceso"  value="<?php echo $cliente[0]->proceso; ?>">
                    </div>
                </div>
                <!-- encabezados -->
                <div class="row pt-2" id="radioDS">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <h6 class="label-on-left mb-0" data-i18n="desarrollo">DESARROLLO </h6>
                        <div class="radio_container">
                            <?php
                            $inputRender = '';
                            foreach ($desarrollos as $elemento){
                                $statusEnabled = '';
                                if($cliente[0]->sede_residencial == $elemento['id_sede']){
                                    $statusEnabled = ' checked=true ';
                                }
                                $inputRender .= '<input type="radio" id="desarrollo'.$elemento['abreviacion'].'" 
                                onclick="return false;" name="desarrollo" required '.$statsInput.' '.$statusEnabled.' 
                                value="'.$elemento['id_sede'].'"/> <label for="desarrollo'.$elemento['abreviacion'].'">'.$elemento['abreviacion'].'</label>';
                            }

                            print_r($inputRender);
                            ?>

                        </div>
                        <br>
                        <!--<div class="radio_container">
                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                            <?php if ($cliente[0]->desarrollo == 1 || $cliente[0]->desarrollo == 2 || $cliente[0]->desarrollo == 5 || $cliente[0]->desarrollo == 6 || $cliente[0]->desarrollo == 7 || $cliente[0]->desarrollo == 8 || $cliente[0]->desarrollo == 11 || $cliente[0]->desarrollo == 21 || $cliente[0]->desarrollo == 26 || $cliente[0]->desarrollo == 29 || $cliente[0]->desarrollo == 34 || $cliente[0]->desarrollo == 33 || $cliente[0]->desarrollo == 36 || $cliente[0]->desarrollo == 35 || $cliente[0]->desarrollo == 37) {echo "checked=true";} ?>  value="1"/>
                            <label for="one">QRO</label>
                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 3 || $cliente[0]->desarrollo == 13 || $cliente[0]->desarrollo == 22 || $cliente[0]->desarrollo == 31 || $cliente[0]->desarrollo == 38) { echo "checked=true"; } ?>  value="2"/>
                            <label for="two">LN</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 9 || $cliente[0]->desarrollo == 10) { echo "checked=true"; } ?> value="3"/>
                            <label for="three">CLY</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 4 || $cliente[0]->desarrollo == 14 || $cliente[0]->desarrollo == 28 || $cliente[0]->desarrollo == 30) { echo "checked=true"; } ?> value="4"/>
                            <label for="four">SLP</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 12 || $cliente[0]->desarrollo == 17 || $cliente[0]->desarrollo == 25 || $cliente[0]->desarrollo == 39) { echo "checked=true"; } ?> value="5"/>
                            <label for="five">MER</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 23) { echo "checked=true"; } ?> value="5"/>
                            <label for="six">SMA</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 27 || $cliente[0]->desarrollo == 32) { echo "checked=true"; } ?> value="5"/>
                            <label for="seven">CNC</label>
                        </div>-->
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <h4 class="label-on-left mb-0" data-i18n="tipo-lote">TIPO LOTE</h4>
                        <div class="radio_container">
                            <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipoLote == 0) { echo "checked=true"; } ?>>
                            <label for="one1" data-i18n="habitacional">HABITACIONAL</label>

                            <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipoLote == 1) { echo "checked=true"; } ?>>
                            <label for="two2" data-i18n="comercial">COMERCIAL</label>
                        </div>
                    </div>
                </div>
                <!-- radios 1 -->
                <div class="row pt-1 persona-fisica-div" id="checkDS">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h4 class="label-on-left m-0" data-i18n="persona-fisica">PERSONA FÍSICA</h4>
                        <div class="container boxChecks p-0">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="idOficial_pf" id="idOficial_pf" value="1" onchange="personaFisicaMoralOnChange()" <?php echo $statsInput; ?> <?php if ($cliente[0]->idOficial_pf == 1) {echo "checked";}?>>
                                    <span data-i18n="identificacion-oficial">IDENTIFICACIÓN OFICIAL</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="idDomicilio_pf" id="idDomicilio_pf" value="1" onchange="personaFisicaMoralOnChange()" <?php echo $statsInput; ?> <?php if ($cliente[0]->idDomicilio_pf == 1) {echo "checked";}?>>
                                    <span data-i18n="comprobante-domicilio">COMPROBANTE DE DOMICILIO</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1" onchange="personaFisicaMoralOnChange()" <?php echo $statsInput; ?> <?php if ($cliente[0]->actaMatrimonio_pf == 1) {echo "checked";}?>>
                                    <span data-i18n="acta-matriminio">ACTA DE MATRIMONIO</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- radios 2 -->
                <div class="row pt-1 persona-moral-div" id="checkDS">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h4 class="label-on-left m-0" data-i18n="persona-moral">PERSONA MORAL</h4>
                        <div class="container boxChecks p-0">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="poder_pm" id="poder_pm" value="1" onchange="personaFisicaMoralOnChange()" <?php echo $statsInput; ?> <?php if ($cliente[0]->poder_pm == 1) {echo "checked";}?>>
                                    <span data-i18n="carta-poder">CARTA PODER</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="actaConstitutiva_pm" id="actaConstitutiva_pm" onchange="personaFisicaMoralOnChange()" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->actaConstitutiva_pm == 1) {echo "checked";}?>>
                                    <span data-i18n="acta-constitutiva">ACTA CONSTITUTIVA</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input  type="checkbox" class="nombre" name="checks" id="checks" onchange="personaFisicaMoralOnChange()" value="apellido_materno">
                                    <span data-i18n="id-oficial">IDE. OFICIAL APODERADO</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- radios 3 -->
                <div class="row pt-1" id="boxFactura"> 
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                        <div class="pb-1">
                            <h4 class="label-on-left m-0" data-i18n="factura">FACTURA</h4>
                            <input type="checkbox" name="rfc_check" id="rfc_check" <?php echo $statsInput; ?> value="1" <?php if ($cliente[0]->rfc != '' && $cliente[0]->rfc != null) {echo "checked";}?>>
                            <label class="switch" for="rfc_check"></label>
                        </div>
                    </div>
                    

                    <div class="col-10 col-sm-10 col-md-7 col-lg-7">
                        <div class="form-group label-floating overflow-hidden">
                            <div class="d-none" name="regimenl" id="regimenl">
                                <h4 class="label-on-left m-0" data-i18n="regimen-fiscal">RÉGIMEN FISCAL</h4>
                                <select name="regimenFiscal" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN" id="regimenFiscal" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                    <?php
                                    for($n=0; $n < count($regFis) ; $n++){
                                        if($regFis[$n]['id_opcion'] == $cliente[0]->regimen_fac){
                                            echo '<option value="'.$regFis[$n]['id_opcion'].'" selected>'.$regFis[$n]['nombre'].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$regFis[$n]['id_opcion'].'">'.$regFis[$n]['nombre'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-sm-10 col-md-2 col-lg-2">
                        <div class="form-group">
                            <h4 class="label-on-left m-0" name="rfcl" id="rfcl" style="display:none;">RFC</h4>
                            <input type="text"  pattern="[A-Za-z0-9]+" onblur="validarRFC(this)" class="form-control input-gral" oninput="this.value = this.value.toUpperCase()" name="rfc" id="rfc" style="display:none;" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==13) return false;" value="<?php echo $cliente[0]->rfc; ?>">   
                        </div>
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            <h4 class="label-on-left m-0" style="display:none;" name="codigol" id="codigol" data-i18n="codigo-postal">CÓDIGO POSTAL</h4>
                            <input class="form-control input-gral" onblur="validarCodigoPostal(this)"  style="display:none;" name="cp_fac" id="cp_fac" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==5) return false;" value="<?php echo $cliente[0]->cp_fac; ?>">        
                        </div>
                    </div>    
                </div>
                <!-- row factura -->
                <!-- radios 3 -->
                <!-- row especialista escuadron -->
                <div class="row pt-1">
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                        <div class="pb-1">
                            <h4 class="label-on-left m-0">ESCUADRON RESCATE</h4>
                            <input type="checkbox" name="escuadronRescate" id="escuadronRescate" <?php echo $statsInput; ?>  <?php if ($cliente[0]->especialistaEscuadron != '' && $cliente[0]->especialistaEscuadron != null) {echo "checked value='1'";}?>>
                            <label class="switch" for="escuadronRescate"></label>
                        </div>
                    </div>
                    <div class="col col-xs-12 col-sm-3 col-md-6 col-lg-6 <?php echo ($cliente[0]->especialistaEscuadron == 1) ?  '':  'd-none'; ?>" id="liderEscuadronDiv">
                        <h4 class="label-on-left m-0">LIDER ESCUADRON RESCATE</h4>
                        <select id="liderEscuadronSelect" name="liderEscuadron" title="SELECCIONA UNA OPCIÓN"  class=" selectpicker m-0 select-gral"
                                data-size="7" <?php echo $readOnly; ?> <?php echo $statsInput; ?>
                                data-live-search="true" data-container="body" data-width="100%">
                            <?php
                            for($n=0; $n < count($lideresRescateLista) ; $n++){
                                if($lideresRescateLista[$n]['id_usuario'] == $cliente[0]->liderEscuadron){
                                    echo '<option value="'.$lideresRescateLista[$n]['id_usuario'].'" selected data-coodRescate="'.$lideresRescateLista[$n]['id_lider'].'">'.$lideresRescateLista[$n]['nombre'].' '.$lideresRescateLista[$n]['apellido_paterno'].' '.$lideresRescateLista[$n]['apellido_materno'].'</option>';
                                }
                                else{
                                    echo '<option value="'.$lideresRescateLista[$n]['id_usuario'].'" data-coodRescate="'.$lideresRescateLista[$n]['id_lider'].'">'.$lideresRescateLista[$n]['nombre'].' '.$lideresRescateLista[$n]['apellido_paterno'].' '.$lideresRescateLista[$n]['apellido_materno'].'</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="idCoordinadorEscuadron" id="idCoordinadorEscuadron">
                    </div>

                    <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                        <h4 class="label-on-left mb-0">IDIOMA</h4>
                        <div class="radio_container">
                            <input type="radio" name="idiomaValor"  id="idiomaValor1" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->idioma == 1) { echo "checked=true"; } ?>>
                            <label for="idiomaValor1">ESPAÑOL</label>

                            <input type="radio" name="idiomaValor"  id="idiomaValor2" value="2" <?php echo $statsInput; ?> <?php if ($cliente[0]->idioma == 2) { echo "checked=true"; } ?>>
                            <label for="idiomaValor2">INGLÉS</label>

                        </div>
                    </div>
                </div>

                <!-- fin especialista escuadron -->
                <div class="row pt-1">
                    <div class="col-sm-6 checkbox-radios" id="radioDS">
                        <h4 class="label-on-left m-0" data-i18n="residencia">RESIDENCIA (<small style="color: red;">*</small>)</h4>
                        <div class="radio_container">
                            <input type="radio" name="tipoNc_valor" id="tipoNc_valor1" onchange="checkResidencia()" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_nc == 0) { echo "checked=true"; } ?>>
                            <label for="tipoNc_valor1" data-i18n="nacional">NACIONAL</label>

                            <input type="radio" name="tipoNc_valor" id="tipoNc_valor2" onchange="checkResidencia()" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_nc == 1) { echo "checked=true"; } ?>>
                            <label for="tipoNc_valor2" data-i18n="extranjero">EXTRANJERO</label>
                        </div>
                    </div>
                    <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 boxCustomRadio <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="pagarePart">
                        <h4 class="label-on-left m-0" data-i18n="imprime-pagares">¿IMPRIME PAGARES?</h4>
                        <div class="d-flex">
                            <div class="w-50 mt-1">
                                    <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare1" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 1) { echo "checked=true"; } ?>>
                                <label for="imprimePagare1" data-i18n="si">SÍ</label>
                            </div>
                            <div class="w-50 mt-1">
                                <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare2" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 0) { echo "checked=true"; } ?>>
                                <label for="imprimePagare2">NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="domicilioCarta">
                        <h4 class="label-on-left m-0" data-i18n="carta-domicilio-cm">CARTA DOMICILIO CM (<small style="color: red;">*</small>)</h4>
                        <div class="d-flex">
                            <div class="w-50 mt-1">
                                <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante1" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 1) { echo "checked=true"; } ?>>
                                <label for="tipo_comprobante1" data-i18n="si">SÍ</label>
                            </div>
                            <div class="w-50 mt-1">
                                <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante2" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 0) { echo "checked=true"; } ?>>
                                <label for="tipo_comprobante2">NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                        <div class="pb-1">
                            <h4 class="label-on-left m-0" data-i18n="venta-extranjero">VENTA EXTRANJERO</h4>
                            <input type="checkbox" name="venta_check" id="venta_check" <?php echo $statsInput; ?><?php if ($cliente[0]->venta_extranjero == 2) {echo "checked";}?>>
                            <label class="switch" for="venta_check"></label>
                        </div>
                    </div>
                </div>
                
                <h4 class="text-center pt-3" data-i18n="datos-titular">DATOS DEL TITULAR</h4>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                               <span data-i18n="nombre">NOMBRE</span> 
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" name="nombre" id="nombre" type="text" required="true" <?php echo $readOnly; ?> <?php echo $readonlyNameToAsesor;?> value="<?=$cliente[0]->nombre?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                                <span data-i18n="ap-paterno-m">APELLIDO PATERNO</span>
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" name="apellido_paterno" id="apellido_paterno" type="text" <?php echo $readOnly; ?> <?php echo $readonlyNameToAsesor;?> required="true" value="<?=$cliente[0]->apellido_paterno?>"/>
                        </div>
                    </div>                               
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">    
                            <label class="label-on-left m-0">
                                <span data-i18n="ap-materno-m">APELLIDO MATERNO</span> 
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" name="apellido_materno" id="apellido_materno" type="text" <?php echo $readOnly; ?><?php echo $readonlyNameToAsesor;?> required="true" value="<?=$cliente[0]->apellido_materno?>"/>
                        </div>                   
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group ">
                                    <label class="label-on-left m-0">
                                        <span data-i18n="lada-m">LADA</span>
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <select id="ladaTelN" name="ladaTel1" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN"  class=" m-0 select-gral ladaSelect" data-size="7" data-live-search="true" data-container="body" data-width="100%" <?php echo $statsInput; ?> required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                <div class="form-group m-0">
                                    <label class="label-on-left m-0">
                                      <span data-i18n="telefono-casa">TELÉFONO CASA</span>  
                                    </label>
                                    <input class="form-control input-gral" name="telefono1" id="telefono1" type="number" step="any" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono1?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group ">
                                    <label class="label-on-left m-0">
                                    <span data-i18n="lada-m">LADA</span>
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <select id="ladaTel2" name="ladaTel2" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN"  class=" m-0 select-gral ladaSelect"
                                            data-size="7" <?php echo $readOnly; ?>
                                            data-live-search="true" data-container="body" data-width="100%" required>
                                    </select>
                                </div>
                            </div>

                            <!--No tocar este es el original-->
                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                <div class="form-group m-0">
                                    <label class="label-on-left m-0">
                                        <span data-i18n="celular">CELULAR</span>
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" required="true" name="telefono2" id="telefono2" type="number" step="any" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono2?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                                <span data-i18n="correo-electronico">CORREO ELECTRÓNICO</span>
                                (<small style="color: red;">*</small>)
                                <small class="pl-1" id="result"></small>
                            </label>
                            <input class="form-control input-gral" required="true" name="correo" id="correo" type="email" oninput="this.value = this.value.toUpperCase()" <?php echo $readOnly; ?> value="<?=$cliente[0]->correo?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="pais">PAÍS</span>(<small style="color: red;">*</small>)</label>
                        <select data-i18n-label="selecciona-una-opcion" name="pais" id="pais" required="true" title="SELECCIONA UNA OPCIÓN" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <?php

                                for($n=0; $n < count($paises) ; $n++){
                                    if($paises[$n]['id_opcion'] == $cliente[0]->pais){
                                        echo '<option value="'.$paises[$n]['id_opcion'].'" selected>'.$paises[$n]['nombre'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$paises[$n]['id_opcion'].'">'.$paises[$n]['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty overflow-hidden">
                            <label class="label-on-left m-0">
                                <span data-i18n="estado">ESTADO</span>  (<small style="color: red;">*</small>)</label>
                            <select data-i18n-label="selecciona-una-opcion" name="estado" id="estado" required="true" title="SELECCIONA UNA OPCIÓN" class="selectpicker select-gral m-0" data-live-search="true" data-container="body">
                                <?php
                                    for($n=0; $n < count($estados) ; $n++){
                                        if($estados[$n]['id_opcion'] == $cliente[0]->estado){
                                            echo '<option value="'.$estados[$n]['id_opcion'].'" selected>'.$estados[$n]['nombre'].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$estados[$n]['id_opcion'].'">'.$estados[$n]['nombre'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="ciudad">CIUDAD</span>(<small style="color: red;">*</small>)</label>
                        <input type="text" required="true" class="form-control m-0 input-gral letrasCaracteres"  name="ciudad" id="ciudad" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->ciudad?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="municipio">MUNICIPIO</span>(<small style="color: red;">*</small>)</label>
                        <input type="text" required="true" class="form-control m-0 input-gral letrasCaracteres"  name="municipio" id="municipio" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->municipio?>"/>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="colonia">COLONIA</span>(<small style="color: red;">*</small>)</label>
                        <input type="text" required="true" class="form-control m-0 input-gral letrasCaracteres"  name="colonia" id="colonia" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->colonia?>"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="localidad">LOCALIDAD</span>
                            (<small style="color: red;">*</small>)
                        </label>
                        <input type="text" class="form-control m-0 input-gral letrasCaracteres"  name="localidad" id="localidad" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->localidad?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="calle">CALLE</span>
                            (<small style="color: red;">*</small>)
                        </label>
                        <input type="text"  class="form-control m-0 input-gral letrasCaracteres"  name="calle" id="calle" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->calle?>"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-on-left m-0">
                                        <span data-i18n="genero">GÉNERO</span>
                                        (<small style="color:red;">*</small>)
                                    </label>
                                    <select data-i18n-label="selecciona-una-opcion" name="genero"  title="SELECCIONA UNA OPCIÓN" id="genero" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                                        <?php for($i = 0; $i < count($generos); $i++) {
                                            if($generos[$i]['id_opcion'] == $cliente[0]->genero) {
                                                echo '<option value="'.$generos[$i]['id_opcion'].'" selected>'.$generos[$i]['nombre'].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$generos[$i]['id_opcion'].'">'.$generos[$i]['nombre'].'</option>';
                                            }
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group m-0">
                                    <label class="label-on-left m-0">
                                        <span data-i18n="tipo-moneda">TIPO DE MONEDA</span>
                                        (<small style="color:red;">*</small>)
                                    </label>
                                    <select data-i18n-label="selecciona-una-opcion" name="tipoMoneda" title="SELECCIONA UNA OPCIÓN" id="tipoMoneda" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" data-width="100%">
                                        <?php 
                                            for($i = 0; $i < count($tipoMoneda); $i++){
                                                if($tipoMoneda[$i]['id_opcion'] == $cliente[0]->tipoMoneda) {
                                                    echo '<option value="'.$tipoMoneda[$i]['id_opcion'].'" selected>'.$tipoMoneda[$i]['nombre'].'</option>';
                                                }
                                                else {
                                                    echo '<option value="'.$tipoMoneda[$i]['id_opcion'].'">'.$tipoMoneda[$i]['nombre'].'</option>';
                                                }
                                            }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <label class="label-on-left m-0">
                                    <span data-i18n="codigo-postal">CÓDIGO POSTAL</span>(<small style="color: red;">*</small>)</label>
                                   <select data-i18n-label="selecciona-una-opcion" name="cp" required="true" title="SELECCIONA UNA OPCIÓN" id="cp" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" data-cp="<?=$cliente[0]->cp ?>" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                            <?php 
                                                for($i = 0; $i < count($cp); $i++) {
                                                    if($cp[$i]['codigo_postal'] == $cliente[0]->cp){
                                                        echo '<option value="'.$cp[$i]['codigo_postal'].'" selected>'.$cp[$i]['codigo_postal'].'</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'.$cp[$i]['codigo_postal'].'">'.$cp[$i]['codigo_postal'].'</option>';
                                                    }
                                                }
                                            ?>
                                </select>    
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <label class="label-on-left m-0">#INTERIOR(<small style="color: red;">*</small>)</label>
                                <input type="text"  class="form-control m-0 input-gral"  name="interior" id="interior" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->interior?>"/>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <label class="label-on-left m-0">#EXTERIOR(<small style="color: red;">*</small>)</label>
                                <input type="text" class="form-control m-0 input-gral"  name="exterior" id="exterior" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->exterior?>"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 dateBox">
                        <label class="label-on-left m-0">
                            <span data-i18n="fecha-nacimiento">FECHA DE NACIMIENTO</span> (<small style="color: red;">*</small>)</label>
                        <input class="form-control input-gral m-0" required="true" name="fecha_nacimiento" id="fecha_nacimiento" onkeydown="return false" type="date" <?php echo $readOnly; ?> value="<?=$cliente[0]->fecha_nacimiento?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty overflow-hidden">
                            <label class="label-on-left m-0" style="top:-29px;">
                                <span data-i18n="nacionalidad">NACIONALIDAD</span> (<small style="color: red;">*</small>)</label>
                            <select data-i18n-label="selecciona-una-opcion" name="nacionalidad" required="true" title="SELECCIONA UNA OPCIÓN" id="nacionalidad" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <?php
                                                                for($p=0; $p < count($nacionalidades) ; $p++){
                                    if($nacionalidades[$p]['id_opcion'] == $cliente[0]->nacionalidad){
                                        echo '<option value="'.$nacionalidades[$p]['id_opcion'].'" selected>'.$nacionalidades[$p]['nombre'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$nacionalidades[$p]['id_opcion'].'">'.$nacionalidades[$p]['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="label-on-left m-0">
                            <span data-i18n="originario-de">ORIGINARIO DE</span> (<small style="color: red;">*</small>)</label>
                        <input type="text" required="true" class="form-control m-0 input-gral letrasCaracteres"  name="originario" id="originario" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->originario?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty overflow-hidden">
                            <label class="label-on-left m-0">
                                <span data-i18n="estado-civil">ESTADO CIVIL</span> 
                                (<small style="color: red;">*</small>)</label>
                            <select data-i18n-label="selecciona-una-opcion" name="estado_civil" id="estado_civil" required="true" title="SELECCIONA UNA OPCIÓN" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <?php

                                for($n=0; $n < count($edoCivil) ; $n++){
                                    if($edoCivil[$n]['id_opcion'] == $cliente[0]->estado_civil){
                                        echo '<option value="'.$edoCivil[$n]['id_opcion'].'" selected>'.$edoCivil[$n]['nombre'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$edoCivil[$n]['id_opcion'].'">'.$edoCivil[$n]['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty overflow-hidden">
                            <label class="label-on-left m-0">
                                <span data-i18n="regimen-matrimonial">
                                    RÉGIMEN MATRIMONIAL
                                </span></label>
                            <select data-i18n-label="selecciona-una-opcion" name="regimen_matrimonial" title="SELECCIONA UNA OPCIÓN" id="regimen_matrimonial" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <?php
                                for($n=0; $n < count($regMat) ; $n++){
                                    if($regMat[$n]['id_opcion'] == $cliente[0]->regimen_matrimonial){
                                        echo '<option value="'.$regMat[$n]['id_opcion'].'" selected>'.$regMat[$n]['nombre'].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$regMat[$n]['id_opcion'].'">'.$regMat[$n]['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0" data-i18n="nombre-conyuge">NOMBRE DE CÓNYUGE</label>
                            <input type="text"  class="form-control input-gral letrasCaracteres"  name="nombre_conyuge" id="nombre_conyuge" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->nombre_conyuge?>"/>
                        </div>
                    </div>              
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="domicilio-particular">DOMICILIO PARTICULAR</span> (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" required="true" name="domicilio_particular" id="domicilio_particular" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->domicilio_particular?>"/>
                        </div>
                    </div>               
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="ocupacion">OCUPACIÓN</span> (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral letrasCaracteres" required="true" name="ocupacion" id="ocupacion" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->ocupacion?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="empresa-en-la-que-trabaja">EMPRESA EN LA QUE TRABAJA</span>
                            </label>
                            <input class="form-control input-gral letrasCaracteres" name="empresa"  id="empresa" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->empresa?>"/>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="puesto">PUESTO</span> (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral letrasCaracteres" name="puesto" required="true" id="puesto" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->puesto?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="antiguedad">ANTIGÜEDAD (AÑOS)</span>
                            </label>
                            <input class="form-control input-gral" name="antiguedad" id="antiguedad" <?php echo $readOnly; ?> pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->antiguedad?>"/>
                        </div>
                    </div>                
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="domicilio-empresa">DOMICILIO EMPRESA</span>
                            </label>
                            <input class="form-control input-gral" name="domicilio_empresa" id="domicilio_empresa" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->domicilio_empresa?>"/>
                        </div>
                    </div>                
                </div>  

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="edad-al-momento">EDAD AL MOMENTO DE FIRMA</span>
                                 (<small style="color: red;">*</small>) (AÑOS)</label>
                            <input class="form-control input-gral" name="edadFirma" id="edadFirma" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->edadFirma?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="telefono-empresa">TELÉFONO EMPRESA</span>
                            </label>
                            <input class="form-control input-gral" name="telefono_empresa" id="telefono_empresa" <?php echo $readOnly; ?> pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$cliente[0]->telefono_empresa?>"/>
                        </div>
                    </div>            
                </div>

                <div class="row" id="viviendaDSP">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label class="label-on-left m-0">
                            <span data-i18n="vive-en-casa">VIVE EN CASA</span>
                             (<small style="color: red;">*</small>)</label>
                        <div class="radio_container">
                            <input type="radio" id="tipo_vivienda_1" <?php echo $statsInput; ?> name="tipo_vivienda" <?php if ($cliente[0]->tipo_vivienda == 1) { echo "checked=true"; } ?>  value="1"/>
                            <label for="tipo_vivienda_1" data-i18n="propia">PROPIA</label>

                            <input type="radio" id="tipo_vivienda_2" name="tipo_vivienda" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_vivienda == 2) { echo "checked=true"; } ?>  value="2"/>
                            <label for="tipo_vivienda_2" data-i18n="rentada">RENTADA</label>

                            <input type="radio" id="tipo_vivienda_3" name="tipo_vivienda" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_vivienda == 3) { echo "checked=true"; } ?>  value="3"/>
                            <label for="tipo_vivienda_3" data-i18n="pagandose">PAGÁNDOSE</label>

                            <input type="radio" id="tipo_vivienda_4" name="tipo_vivienda" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_vivienda == 4) { echo "checked=true"; } ?>  value="4"/>
                            <label for="tipo_vivienda_4" data-i18n="familiar">FAMILIAR</label>

                            <input type="radio" id="tipo_vivienda_5" name="tipo_vivienda" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_vivienda == 5) { echo "checked=true"; } ?>  value="5"/>
                            <label for="tipo_vivienda_5" data-i18n="otro"> OTRO </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion">
                            <div class="card" id="divCopropietario">
                                <div class="card-header collapsed cursor-point" id="copropietario-collapse" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 text-center">
                                                <span class="fs-2" data-i18n="copropietario">COPROPIETARIO (S)</span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right">
                                                <span class="fs-2"><i id="copropietario-icono" class="fa fa-arrow-down"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="copropietario-collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        $limite = $copropiedadTotal[0]->valor_propietarios;
                                        if ($limite > 0) {
                                            echo '<div class="container-fluid p-0" id="containerCopropietario">';

                                            for ($i = 0; $i < $limite; $i++) {
                                                echo '
                                                    <h6 class="text-center"><span data-i18n="propietario">PROPIETARIO</span> ' . ($i + 1) . '</h6>                    
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                    <span data-i18n="nombre">NOMBRE</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input readonly class="form-control input-gral" type="text" required="true" value="'.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno.'"/>
                                                                <input id="id_cop[]" name="id_cop[]" type="hidden" value="'.$copropiedad[$i]->id_copropietario.'">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                                                    <div class="form-group ">
                                                                        <label class="label-on-left m-0" data-i18n="lada-tel-casa">
                                                                            LADA TÉLEFONO CASA
                                                                        </label>
                                                                        <select data-i18n-label="selecciona-una-opcion" name="ladaTelCop[]" id="ladaTel'.$i.'" title="SELECCIONA UNA OPCIÓN"  
                                                                        class=" m-0 select-gral ladaSelect" data-live-search="true" data-container="body"
                                                                        data-size="7" 
                                                                         data-width="100%">
                                                                        </select>
                                                                    </div>
                                                                </div>                                                            
                                                                <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                                                    <div class="form-group label-floating">
                                                                        <label class="label-on-left m-0" data-i18n="telefono-casa">TELÉFONO CASA</label>
                                                                        <input  class="form-control input-gral" name="telefono1_cop[]" id="telefono1_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono . '" ' . $statsInput . '/>
                                                                    </div>
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                                                    <div class="form-group ">
                                                                        <label class="label-on-left m-0">
                                                                            <span data-i18n="lada-cel">LADA CELULAR</span>
                                                                            (<small style="color: red;">*</small>)
                                                                        </label>
                                                                        <select data-i18n-label="selecciona-una-opcion" name="ladaCelCop[]" id="ladaCel'.$i.'" title="SELECCIONA UNA OPCIÓN"  
                                                                        class=" m-0 select-gral ladaSelect copSelect" data-live-search="true" 
                                                                        data-size="7"
                                                                        data-container="body" data-width="100%" required>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-4 col-md-7 col-lg-7">
                                                                    <div class="form-group label-floating">
                                                                        <label class="label-on-left m-0">CELULAR (<small style="color: red;">*</small>)</label>
                                                                        <input  class="form-control input-gral" name="telefono2_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono_2 . '" '.$statsInput.'/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="row"> 
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="correo-electronico">CORREO ELECTRÓNICO</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input  class="form-control input-gral" name="email_cop[]" type="email" value="' . $copropiedad[$i]->correo . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>           
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="fecha-nacimiento">FECHA DE NACIMIENTO</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input  class="form-control input-gral" name="fnacimiento_cop[]" onkeydown="return false" type="date" value="' . $copropiedad[$i]->fecha_nacimiento . '" '.$statsInput.' required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty overflow-hidden">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="nacionalidad">NACIONALIDAD</span>
                                                                (<small style="color: red;">*</small>)</label> 
                                                                <select data-i18n-label="selecciona-una-opcion" class="selectpicker select-gral m-0" data-live-search="true" data-container="body" name="nacionalidad_cop[]" id="nacionalidad_cop[]" '.$statsInput.' required>';

                                                                    for($n=0; $n < count($nacionalidades) ; $n++){
                                                                        if($nacionalidades[$n]['id_opcion'] == $copropiedad[$i]->nacionalidad_valor){
                                                                            echo '<option value="'.$nacionalidades[$n]['id_opcion'].'" selected>'.$nacionalidades[$n]['nombre'].'</option>';
                                                                        }
                                                                        else{
                                                                            echo '<option value="'.$nacionalidades[$n]['id_opcion'].'">'.$nacionalidades[$n]['nombre'].'</option>';
                                                                        }
                                                                    }
                                                                    echo'
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>    

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="domicilio-particular">DOMICILIO PARTICULAR</span> 
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input  class="form-control input-gral letrasNumeros" name="id_particular_cop[]" type="text" value="' . $copropiedad[$i]->domicilio_particular . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0"> 
                                                                <span data-i18n="originario-de">ORIGINARIO DE</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input type="text" class="form-control input-gral letrasCaracteres" name="originario_cop[]" type="text" value="' . $copropiedad[$i]->originario_de . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                            </div>
                                                        </div>        
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty overflow-hidden">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="estado-civil">ESTADO CIVIL</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <select data-i18n-label="selecciona-una-opcion" class="selectpicker select-gral m-0" data-container="body" data-live-search="true" name="ecivil_cop[]" id="ecivil_cop[]" '.$statsInput.' required>
                                                                        
                                                                ';
                                                                    for($n=0; $n < count($edoCivil) ; $n++)
                                                                    {
                                                                        if($edoCivil[$n]['id_opcion'] == $copropiedad[$i]->estado_valor)
                                                                        {
                                                                            echo '<option value="'.$edoCivil[$n]['id_opcion'].'" selected>'.$edoCivil[$n]['nombre'].'</option>';
                                                                        }
                                                                        else{
                                                                            echo '<option value="'.$edoCivil[$n]['id_opcion'].'">'.$edoCivil[$n]['nombre'].'</option>';
                                                                        }
                                                                    }
                                                                    echo'
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty overflow-hidden">
                                                                <label class="label-on-left m-0" data-i18n="regimen-matrimonial">RÉGIMEN MATRIMONIAL</label>
                                                                <select data-i18n-label="selecciona-una-opcion" name="r_matrimonial_cop[]" data-live-search="true" data-container="body" id="r_matrimonial_cop[]" class="selectpicker select-gral m-0" '.$statsInput.'>';
                                                                    for($n=0; $n < count($regMat) ; $n++){
                                                                        if($regMat[$n]['id_opcion'] == $copropiedad[$i]->regimen_valor){
                                                                            echo '<option value="'.$regMat[$n]['id_opcion'].'" selected>'.$regMat[$n]['nombre'].'</option>';
                                                                        }
                                                                        else{
                                                                            echo '<option value="'.$regMat[$n]['id_opcion'].'">'.$regMat[$n]['nombre'].'</option>';
                                                                        }
                                                                    }
                                                                    echo'
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0" data-i18n="nombre-conyuge">NOMBRE DE CÓNYUGE</label>
                                                                <input type="text" class="form-control input-gral letrasCaracteres" name="conyuge_cop[]" id="conyuge_cop[]" type="text" value="' . $copropiedad[$i]->conyuge . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>
                                
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="ocupacion">OCUPACIÓN</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input  class="form-control input-gral letrasCaracteres" name="ocupacion_cop[]" type="text" value="' . $copropiedad[$i]->ocupacion . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="puesto">PUESTO</span>
                                                                (<small style="color: red;">*</small>)</label>
                                                                <input  class="form-control input-gral letrasCaracteres" name="puesto_cop[]" type="text" value="' . $copropiedad[$i]->posicion . '" '.$statsInput.'/>
                                                            </div>
                                                        </div> 
                                                    </div>
                    
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0" data-i18n="antiguedad">ANTIGÜEDAD (AÑOS)</label>
                                                                <input  class="form-control input-gral" name="antiguedad_cop[]" id="antiguedad_cop[]" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->antiguedad . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>
                                
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0">
                                                                <span data-i18n="edad-firma">EDAD FIRMA (AÑOS)</span>
                                                                (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input  class="form-control input-gral" name="edadFirma_cop[]" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->edadFirma . '" '.$statsInput.'/>
                                                            </div> 
                                                        </div>
                                
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0" data-i18n="empresa-en-la-que-trabaja">EMPRESA EN LA QUE TRABAJA</label>
                                                                <input  class="form-control input-gral letrasCaracteres" name="empresa_cop[]" id="empresa_cop[]" type="text" value="' . $copropiedad[$i]->empresa . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>  
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group label-floating">
                                                                <label class="label-on-left m-0" data-i18n="domicilio-empresa">DOMICILIO EMPRESA</label>
                                                                <input  class="form-control input-gral letrasNumeros" name="dom_emp_cop[]" id="dom_emp_cop[]" type="text" value="' . $copropiedad[$i]->direccion . '" '.$statsInput.'/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row pb-3" id="viviendaDS">
                                                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9"> 
                                                            <label class="label-on-left m-0" data-i18n="vive-en-casa">VIVE EN CASA</label>
                                                                <div class="radio_container">
                                                                    <input type="radio" id="tipo_vivienda_1_cop'.$i.'" name="tipo_vivienda_cop'.$i.'[]"'; if ($copropiedad[$i]->tipo_vivienda == 1) { echo "checked=true"; } echo ' value="1" '.$statsInput.'/>
                                                                    <label for="tipo_vivienda_1_cop'.$i.'" data-i18n="propia">PROPIA</label>

                                                                    <input type="radio" id="tipo_vivienda_2_cop'.$i.'" name="tipo_vivienda_cop'.$i.'[]"';if ($copropiedad[$i]->tipo_vivienda == 2) { echo "checked=true"; } echo ' value="2" '.$statsInput.'/>
                                                                    <label for="tipo_vivienda_2_cop'.$i.'" data-i18n="rentada">RENTADA</label>

                                                                    <input type="radio" id="tipo_vivienda_3_cop'.$i.'" name="tipo_vivienda_cop'.$i.'[]"';if ($copropiedad[$i]->tipo_vivienda == 3) { echo "checked=true"; } echo ' value="3" '.$statsInput.'/>
                                                                    <label for="tipo_vivienda_3_cop'.$i.'" data-i18n="pagandose">PAGÁNDOSE</label>
                                                                    
                                                                    <input type="radio" id="tipo_vivienda_4_cop'.$i.'" name="tipo_vivienda_cop'.$i.'[]"';if ($copropiedad[$i]->tipo_vivienda == 4) { echo "checked=true"; } echo ' value="4" '.$statsInput.'/>
                                                                    <label for="tipo_vivienda_4_cop'.$i.'" data-i18n="familiar">FAMILIAR</label>
                                                                    
                                                                    <input type="radio" id="tipo_vivienda_5_cop'.$i.'" name="tipo_vivienda_cop'.$i.'[]"';if ($copropiedad[$i]->tipo_vivienda == 5) { echo "checked=true"; } echo ' value="5" '.$statsInput.'/>
                                                                    <label for="tipo_vivienda_5_cop'.$i.'" data-i18n="otro">OTRO</label>
                                                                </div>
                                                            </div>  
                                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                                <label class="label-on-left m-0">RFC</label>
                                                                <input class="form-control input-gral" onblur="validarRFC(this)" name="rfc_cop[]" id="rfc_cop[]" type="text" $readOnly value="'; echo $copropiedad[$i]->rfc; echo ' '.$statsInput.'"/>
                                                                <input type="hidden" value="'.$limite.'" name="numOfCoprops">
                                                            </div>
                                                    </div>
                                                    ';
                                            }

                                            echo '</div>';
                                        } else {
                                            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><b><label style="color:#0A548B;" data-i18n="sin-datos-mostrar">SIN DATOS A MOSTRAR<br></label></b></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="text-center m-0" data-i18n="datos-generales">DATOS GENERALES</h4>
                <h6 class="m-0 text-center" data-i18n="ubicacion-lote"><small>LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO</small></h6>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="sr"></span>EL SR(A) 
                                (<small style="color: red;">*</small>)</label>
                            <?php

                            $limite = $copropiedadTotal[0]->valor_propietarios;
                            if($limite>0){
                                $copropsNames = '';
                                for ($i = 0; $i < $limite; $i++) {
                                    $copropsNames .= ' / '.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno;
                                }
                            }
                            else{
                                $copropsNames = '';
                            }
                            ?>
                            <input class="form-control input-gral" name="" id="" type="text" readonly required="true" <?php echo $readOnly; ?> value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?> <?=$copropsNames?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0" data-i18n="adquirir-lote">SE COMPROMETE A ADQUIRIR EL LOTE No.</label>
                            <input class="form-control input-gral" name="nombreLote" id="nombreLote" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->nombreLote?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0" data-i18n="en-el-cluster">EN EL CLÚSTER</label>
                            <input class="form-control input-gral" name="nombreCondominio" id="nombreCondominio" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->nombreCondominio?>" readonly="readonly"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0" data-i18n="superficie">SUPERFICIE</label>
                            <input class="form-control input-gral" name="sup" id="sup" type="text" required="true" <?php echo $readOnly; ?> value="<?=$cliente[0]->sup?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0" data-i18n="referencia">REFERENCIA</label>
                            <input class="form-control input-gral" name="referencia" id="referencia" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->referencia?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0"><span data-i18n="costo-por">COSTO POR</span> M<sup>2</sup> <span data-i18n="lista">LISTA</span> </label>
                            <?php
                            $read='';
                            $valor='';
                            $des_val='';
                            if($cliente[0]->desarrollo == 17){$read=''; $valor=$cliente[0]->costoM2_casas;$des_val=1;}
                            else{$read ='readonly="readonly"';$valor=$cliente[0]->precio;$des_val=0;}
                            ?>
                            <input class="form-control input-gral" name="costoM2" id="costoM2" type="text" <?php echo $readOnly; ?> required="true" value="<?php echo $valor;?>" <?php echo $read;?>/>
                            <input type="hidden" name="des_hide" value="<?php echo $des_val;?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0"><span data-i18n="costo-por">COSTO POR</span>M<sup>2</sup> FINAL (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="costom2f" id="costom2f" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->costom2f?>"/>
                            <input type="hidden" name="tipo_venta" id="tipo_venta" value="<?php echo $tipo_venta;?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="data-i18n="autorizado-proyecto">UNA VEZ QUE SEA AUTORIZADO EL PROYECTO</span>
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral espaciosOff" name="proyecto" id="proyecto" type="text" <?php echo $readOnly; ?> step="any" required="true"  value="<?=$cliente[0]->nombreResidencial?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                               <span data-i18n="municipio-de">EN EL MUNICIPIO DE </span> 
                                (<small style="color: red;">*</small>)</label>
                            <input type="text" class="form-control input-gral letrasCaracteres" name="municipioDS" id="municipioDS" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->municipioDS?>"/>
                        </div>
                    </div>            
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="importe-de-la-oferta">IMPORTE DE LA OFERTA</span> 
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="importOferta" id="importOferta" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->importOferta?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="importe-en-letra">IMPORTE EN LETRA</span>
                                (<small style="color: red;">*</small>)</label>
                            <input type="text" class="form-control input-gral letrasNumeros" name="letraImport" id="letraImport" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->letraImport?>"/>
                        </div>
                    </div>
                </div>
                <div class="row pb-3 pt-3" id="ofertanteInput">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                        <label>
                            <span data-i18n="ofertante">
                            El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $ 
                            </span>
                            (<b><span style="color: red;">*</span></b>)
                            <input class="form-control p-0" name="cantidad" id="cantidad" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->cantidad?>"/>

                            (<input class="form-control p-0 letrasNumeros" name="letraCantidad" <?php echo $readOnly; ?> id="letraCantidad" oninput="this.value = this.value.toUpperCase()" type="text" required="true" value="<?=$cliente[0]->letraCantidad?>"/>),
                            <span data-i18n="cuenta-precio"> misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo. El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma.</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="saldo-deposito">SALDO DE DEPÓSITO</span> 
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="saldoDeposito" id="saldoDeposito" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->saldoDeposito?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="aportacion-mensual">APORTACIÓN MENSUAL</span>
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="aportMensualOfer" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" <?php echo $readOnly; ?> id="aportMensualOfer" step="any" required="true" value="<?=$cliente[0]->aportMensualOfer?>" step="any"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="fecha-1-aportacion">FECHA 1° APORTACIÓN </span>
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="fecha1erAport" <?php echo $readOnly; ?> id="fecha1erAport" onkeydown="return false" type="date" required="true" value="<?=$cliente[0]->fecha1erAport?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0"> 
                            <span data-i18n="plazo">PLAZO </span>
                            (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="plazo" id="plazo" <?php echo $readOnly; ?> type="number" step="any" required="true" value="<?=$cliente[0]->plazo?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="fecha-liquidacion">FECHA LIQUIDACIÓN DE DEPÓSITO</span>
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" required="true" name="fechaLiquidaDepo" <?php echo $readOnly; ?> id="fechaLiquidaDepo" type="date" onkeydown="return false" value="<?=$cliente[0]->fechaLiquidaDepo?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="fecha-2-aportacion">FECHA 2° APORTACIÓN </span>
                                (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="fecha2daAport" id="fecha2daAport" <?php echo $readOnly; ?>type="date" onkeydown="return false" required="true" value="<?=$cliente[0]->fecha2daAport?>"/>
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
                        <label style="font-size: 0.7em;" >
                            <span data-i18n="oferta-vigencia">
                                Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. 
                            </span>
                            <span data-i18n="oferta-vigencia2">
                                En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. 
                            </span>
                            <span data-i18n="oferta-vigencia3">
                                En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, 
                            </span>
                            <span data-i18n="oferta-vigencia4">
                                la empresa cobrará al ofertante únicamente $10,000.00
                            </span>
                            <span data-i18n="oferta-vigencia5">
                                $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación.
                            </span>
                            <span data-i18n="oferta-vigencia6">
                                Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, 
                            </span>
                            <span data-i18n="oferta-vigencia7">
                                medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.
                            </span>
                            <br>
                            <span data-i18n="oferta-vigencia8">
                                Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente.
                            </span>
                            <span data-i18n="oferta-vigencia9">
                                Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. 
                            </span>
                            <span data-i18n="oferta-vigencia10">
                                De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. 
                            </span>
                            <span data-i18n="oferta-vigencia11">
                                Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.
                            </span>
                        </label>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row form-inline">
                            <div class="col">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
                                    <label class="label-on-left m-0">
                                        <span data-i18n="municipio-de">En el Municipio de</span>
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control letrasCaracteres" required="true" name="municipio2" id="municipio2"
                                            <?php echo $readOnly; ?>
                                                type="text" required="true" value="<?=$cliente[0]->municipio2?>" style="text-align: center;"/>, 
                                                <span data-i18n="a">a</span>
                                        (<small style="color: red;">*</small>)
                                        <input min="1" max="31" class="form-control" oninput="validarDia(this)" name="dia" id="dia" <?php echo $readOnly; ?>
                                                 required="true" value="<?=$cliente[0]->dia?>" style="text-align: center;"/>, 
                                                 <span data-i18n="del-mes-de">del mes de</span>
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control letrasCaracteres" name="mes" min="1" max="12" id="mes" <?php echo $readOnly; ?>
                                                type="text" required="true" value="<?=$cliente[0]->mes?>" style="text-align: center;"/>, 
                                                <span data-i18n="del-anu">del año</span>
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control" name="anio" id="anio" min="2015" max="2023"<?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->anio?>" style="text-align: center;"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2 pb-2">
                    <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <?php
                            $limite = $copropiedadTotal[0]->valor_propietarios;
                            if($limite>0){
                                $copropsNames = '';
                                for ($i = 0; $i < $limite; $i++) {
                                    $copropsNames .= ' / '.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno;
                                }
                            }
                            else{
                                $copropsNames = '';
                            }
                            ?>
                            <style>
                                #inpPropCoprpNs
                                {
                                    text-transform: uppercase;
                                }
                            </style>
                            <input class="form-control text-center" id="inpPropCoprpNs" type="text" required="true" <?php echo $readOnly; ?>
                                    readonly value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?> <?php echo $copropsNames;?>" style="font-size: 0.9em;"/>
                        </div>
                        <div class="text-center" style="line-height:12px">
                            <label class="label-on-left m-0"><span data-i18n="nombre-firma">Nombre y Firma</span> <b data-i18n="ofer"> Ofertante (*)</b></label>
                            <br>
                            <label class="label-on-left m-0" data-i18n="verificacion-datos">
                                Acepto que se realice una verificación de mis datos, en los teléfonos y correos que proporciono para el otorgamiento del crédito.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="containerReferencia">
                    <h4 class="text-center pt-3" data-i18n="referencias-personales">REFERENCIAS PERSONALES</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0" data-i18n="nombre">NOMBRE</label>
                                <input class="form-control input-gral letrasCaracteres" name="nombre1" <?php echo $readOnly; ?> id="nombre1" type="text" value="<?= ($referencias == 0) ? '' : $referencias[0]->nombre?>"/>
                                <input name="id_referencia1" <?php echo $readOnly; ?>id="id_referencia1" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[0]->id_referencia?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating overflow-hidden">
                                <label class="label-on-left m-0" data-i18n="parentesco">PARENTESCO</label>
                                <select data-i18n-label="selecciona-una-opcion" name="parentesco1" title="SELECCIONA UNA OPCIÓN" data-live-search="true" data-container="body" id="parentesco1" <?php echo $readOnly; ?> class="selectpicker select-gral m-0" <?php echo $statsInput; ?>>
                                    <?php
                                    
                                    for($p=0; $p < count($parentescos) ; $p++)
                                    {
                                        if($parentescos[$p]['id_opcion'] == $referencias[0]->parentesco)
                                        {
                                            echo $parentescos[$p]['id_opcion'];
                                            echo '<option value="'.$parentescos[$p]['id_opcion'].'" selected>'.$parentescos[$p]['nombre'].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$parentescos[$p]['id_opcion'].'">'.$parentescos[$p]['nombre'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0" data-i18n="telefono">TELÉFONO</label>
                                <input class="form-control input-gral" <?php echo $readOnly; ?> name="telefono_referencia1" id="telefono_referencia1" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[0]->telefono?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0" data-i18n="nombre">NOMBRE</label>
                                <input class="form-control input-gral letrasCaracteres" name="nombre2" <?php echo $readOnly; ?>
                                        id="nombre2" type="text" value="<?= ($referencias == 0) ? '' : $referencias[1]->nombre?>"/>
                                <input name="id_referencia2" <?php echo $readOnly; ?>
                                        id="id_referencia2" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[1]->id_referencia?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating select-is-empty overflow-hidden">
                                <label class="label-on-left m-0" data-i18n="parentesco">PARENTESCO</label>
                                <select data-i18n-label="selecciona-una-opcion" name="parentesco2" title="SELECCIONA UNA OPCIÓN" data-live-search="true" data-container="body" <?php echo $readOnly; ?>id="parentesco2" class="selectpicker select-gral m-0" <?php echo $statsInput; ?>>
                                    <?php
                                    for($p=0; $p < count($parentescos) ; $p++)
                                    {
                                        if($parentescos[$p]['id_opcion'] == $referencias[1]->parentesco)
                                        {
                                            echo '<option value="'.$parentescos[$p]['id_opcion'].'" selected>'.$parentescos[$p]['nombre'].'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$parentescos[$p]['id_opcion'].'">'.$parentescos[$p]['nombre'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0" data-i18n="telefono">TELÉFONO</label>
                                <input class="form-control input-gral" <?php echo $readOnly; ?> name="telefono_referencia2" id="telefono_referencia2" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[1]->telefono?>"/>
                            </div>
                        </div>
                    </div>           
                </div>
                <div class="row">
                <?php
                if(count($asesor2) > 0){
                    $asesoresVC = '';
                    $coordGerVC = '';
                    for($vc = 0; $vc < count($asesor2); $vc++)
                    {
                        if($asesor2[0]->id_usuario=='' || $asesor[0]->id_usuario == null)
                        {
                            $asesoresVC = '';
                            $coordGerVC = '';
                        }
                        else
                        {
                            $coordFinal =($asesor[0]->nombreCoordinador == $asesor2[0]->nombreCoordinador) ? '':$asesor2[0]->nombreCoordinador;
                            $gerenteFinal = ($asesor[0]->nombreGerente == $asesor2[0]->nombreGerente)?'':$asesor2[0]->nombreGerente;

                            $coordinador = ($asesor2[0]->nombreCoordinador =='')?'':' - '.$coordFinal.', ';
                            $gerente     = ($asesor2[0]->nombreGerente ==  ''  )?'':$gerenteFinal;

                            ($asesor2[0]->nombreAsesor=='') ? $asesoresVC .='' : $asesoresVC .= ' - '.$asesor2[$vc]->nombreAsesor;

                            ($asesor2[0]->nombreCoordinador=='' AND $asesor2[0]->nombreGerente=='') ? $coordGerVC .= '' : $coordGerVC .= $coordinador.$gerente;
                        }
                    }

                }
                else{
                    $asesoresVC = '';
                    $coordGerVC = '';
                }

                /*coord gerente asesor normal*/
                $coordGerenteVN = '';
                if($asesor[0]->nombreCoordinador==' '){
                    $coordinadorVN = '';
                }
                else{
                    $coordinadorVN = '- '.$asesor[0]->nombreCoordinador.', ';
                }
                if($asesor[0]->nombreGerente==''){
                    $gerenteVN = '';
                }
                else{
                    $gerenteVN = $asesor[0]->nombreGerente;
                }
                $coordGerenteVN = $coordinadorVN.$gerenteVN;
                ?>
                </div>
                <div class="row pt-3" id="observaciones">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">
                                <span data-i18n="observaciones">OBSERVACIONES</span>
                                (<small style="color: red;">*</small>)</label>
                            <textarea class="form-control pr-2 pl-2 espaciosOff scroll-styles" <?php echo $readOnly; ?> id="observacion" name="observacion" rows="10" required><?php echo $cliente[0]->observacion; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row aligned-row">
                    <div class ="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <label class="label-on-left m-0" data-i18n="correo-asesor">CORREO ELECTRÓNICO ASESOR</label>
                        <input name="correo_asesor" <?php echo $readOnly; ?> id="correo_asesor" type="text" class="form-control input-gral" value="<?=$asesor[0]->correo?>" >
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1 checkbox checkbox-inline pt-0 m-0" style="padding-left:15px!important">

                        
                            <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || in_array($this->session->userdata('id_usuario'), [2752, 2826, 2810, 5957, 6390, 4857, 2834, 11655]) AND $onlyView==0){?>
                                <h4 class="label-on-left mb-0" data-i18n="enviar-ds">ENVIAR DS AL CLIENTE</h4>
                                <input id="pdfOK" name="pdfOK" type="checkbox">
                                <label class="switch" for="pdfOK"></label>
                            <?php } ?>
                        
                    </div>
                    
                </div>
                <br><br>
                <div class="row pt-5 mt-5 firmas">
                    <div class ="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center">
                        <div class="form-group label-floating">
                            <input class="form-control text-center" <?php echo $readOnly; ?> name="asesor_datos" id="asesor_datos" type="text" required="true" value="<?=$asesor[0]->nombreAsesor?><?=$asesoresVC?>"/>
                        </div>
                        <label class="label-on-left m-0">
                            <span data-i18n="nombre-firma">.
                            Nombre y Firma <b> Asesor 
                            </span>
                        (*)</b></label>
                    </div>
                    <div class ="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center">      
                        <div class="form-group label-floating">
                            <input class="form-control text-center" <?php echo $readOnly; ?> type="text" name="gerente_datos" id="gerente_datos" required="true" value="<?=$asesor[0]->nombreCoordinador?>, <?=$asesor[0]->nombreGerente?> <?=$coordGerVC?>"/>
                        </div>
                        <label class="label-on-left m-0">
                            <span data-i18n="nombre-firma">Nombre y Firma</span> 
                            <b data-i18n="autorizacion-operacion"> Autorización de operación (*)</b></label>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="text-center">
                    </div>  
                </div>
            </div> 
            <?php echo $html_action_end;?>          
        </div>
    </div>
</div>

</div>
</div>
<div id="mensaje"></div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script>
    var cliente = "<?=$cliente[0]->id_cliente?>";
    const onlyView = <?=$onlyView?>;
    let idDesarrollo = <?=$cliente[0]->desarrollo?>;
</script>
<script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/asesores/depositoFormato.js"></script>
<script src="<?=base_url()?>dist/js/controllers/asesores/ladasTels.js"></script>
<script>
    $('#ladaTelN #ladaTel2').ready(()=>{
        $('#ladaTelN').val('<?=$cliente[0]->ladaTel1?>');
        $('#ladaTel2').val('<?=$cliente[0]->ladaTel2?>');

        $('.selectpicker').selectpicker('refresh');
    });


    <?php
        for($i=0; $i<$copropiedadTotal[0]->valor_propietarios; $i++){?>
            $("#ladaCel<?=$i;?>").ready(() => {
                $("#ladaCel<?=$i;?>").val("<?=$copropiedad[$i]->ladaCel?>");
                $("#ladaCel<?=$i;?>").selectpicker("refresh");
            });

            $("#ladaTel<?=$i;?>").ready(() => {
                $("#ladaTel<?=$i;?>").val("<?=$copropiedad[$i]->ladaTel?>");
                $("#ladaTel<?=$i;?>").selectpicker("refresh");
            });
    <?php
        }
    ?>




</script>