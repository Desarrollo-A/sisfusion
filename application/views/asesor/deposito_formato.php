<link href="<?= base_url() ?>dist/css/depositoSeriedad.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body onload="cargarInputs()" onsubmit="guardarInputs()">

<div class="wrapper">
    <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
    ?>
    <?php
        if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752 || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 2855 || $this->session->userdata('id_usuario') == 2815 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 || $this->session->userdata('id_usuario') == 9775 AND $onlyView==0){
            $readOnly = '';
            $statsInput = '';
            $html_action = '<form method="post" class="form-horizontal" action="'.base_url().'index.php/Asesor/editar_ds/" enctype="multipart/form-data">';
            $html_action_end = '</form>';
        }
        else{
            $readOnly = 'readonly';
            $statsInput = 'disabled';
            $html_action = '';
            $html_action_end = '';
        }
        
        if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752 || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834){
            $readonlyNameToAsesor = 'readonly';
        }
        else{
            $readonlyNameToAsesor='';
        }    
    ?>
    <div class="container pt-5" id="mainBoxDS">
        <div class="card">
			<?php echo $html_action;?> 
            <div class="container-fluid p-5">
                <div class="row" id="encabezadoDS">
                    <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                        <img  class="w-100" src="<?=base_url()?>static/images/Logo_CM&TP_1.png" alt="Servicios Condominales" title="Servicios Condominales"/>
                    </div>
                    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                        <h3 class="m-0 mb-1">DEPÓSITO DE SERIEDAD
                            <i class="fas fa-info-circle fa-xs" style="cursor: pointer;" onclick="historial()"></i>
                            <?php if ($this->session->userdata('id_rol') == 17) { ?>
                                <i class="fas fa-info-circle" style="cursor: pointer;" onclick="historial()"></i>
                            <?php }?>
                        </h3>  
                        <h6 class="m-0">Última modificación: <?php echo $cliente[0]->fecha_modificacion;?></h6>
                        <h6 class="m-0">Folio: <span><?php echo $cliente[0]->clave; ?></span></h6>
                        <input type="hidden" name="clavevalor" id="clavevalor"  value="<?php echo $cliente[0]->clave; ?>">
                        <input type="hidden" name="id_cliente" id="id_cliente"  value="<?php echo $cliente[0]->id_cliente; ?>">
                    </div>
                </div>
                <!-- encabezados -->
                <div class="row pt-2" id="radioDS">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <h6 class="label-on-left mb-0">DESARROLLO</h6>
                        <div class="radio_container">
                        <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                            <?php if ($cliente[0]->desarrollo == 1 || $cliente[0]->desarrollo == 2 || $cliente[0]->desarrollo == 5 ||
                            $cliente[0]->desarrollo == 1 || $cliente[0]->desarrollo == 6 || $cliente[0]->desarrollo == 7 || $cliente[0]->desarrollo == 8 || $cliente[0]->desarrollo == 11 || $cliente[0]->desarrollo == 21 || $cliente[0]->desarrollo == 26 || $cliente[0]->desarrollo == 29 || $cliente[0]->desarrollo == 34 || $cliente[0]->desarrollo == 32 || $cliente[0]->desarrollo == 33) {echo "checked=true";} ?>  value="1"/>
                            <label for="one">QRO</label>
                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 3 || $cliente[0]->desarrollo == 13 || $cliente[0]->desarrollo == 22 || $cliente[0]->desarrollo == 31) { echo "checked=true"; } ?>  value="2"/>
                            <label for="two">LN</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 9 || $cliente[0]->desarrollo == 10) { echo "checked=true"; } ?> value="3"/>
                            <label for="three">CLY</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 4 || $cliente[0]->desarrollo == 14 || $cliente[0]->desarrollo == 28 || $cliente[0]->desarrollo == 30) { echo "checked=true"; } ?> value="4"/>
                            <label for="four">SLP</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 12 || $cliente[0]->desarrollo == 17 || $cliente[0]->desarrollo == 25) { echo "checked=true"; } ?> value="5"/>
                            <label for="five">MER</label>

                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 23) { echo "checked=true"; } ?> value="5"/>
                            <label for="six">SMA</label>
                            
                            <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?> <?php if ($cliente[0]->desarrollo == 27) { echo "checked=true"; } ?> value="5"/> 
                            <label for="seven">CNC</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <h4 class="label-on-left mb-0">TIPO LOTE</h4>
                        <div class="radio_container">
                            <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipoLote == 0) { echo "checked=true"; } ?>>
                            <label for="one1">HABITACIONAL</label>

                            <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipoLote == 1) { echo "checked=true"; } ?>>
                            <label for="two2">COMERCIAL</label>
                        </div>
                    </div>
                </div>
                <!-- radios 1 -->
                <div class="row pt-1" id="checkDS">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h4 class="label-on-left m-0">PERSONA FÍSICA</h4>
                        <div class="container boxChecks p-0">
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="idOficial_pf" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->idOficial_pf == 1) {echo "checked";}?>>
                                    <span>IDENTIFICACIÓN OFICIAL</span>
                                </label>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="idDomicilio_pf" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->idDomicilio_pf == 1) {echo "checked";}?>>
                                    <span>COMPROBANTE DE DOMICILIO</span>
                                </label>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="actaMatrimonio_pf" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->actaMatrimonio_pf == 1) {echo "checked";}?>>
                                    <span>ACTA DE MATRIMONIO</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- radios 2 -->
                <div class="row pt-1" id="checkDS">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h4 class="label-on-left m-0">PERSONA MORAL</h4>
                        <div class="container boxChecks p-0">
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="poder_pm" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->poder_pm == 1) {echo "checked";}?>>
                                    <span>CARTA PODER</span>
                                </label>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input type="checkbox" name="actaConstitutiva_pm" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->actaConstitutiva_pm == 1) {echo "checked";}?>>
                                    <span>ACTA CONSTITUTIVA</span>
                                </label>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                                <label class="m-0 checkstyleDS">
                                    <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
                                    <span>IDE. OFICIAL APODERADO</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- radios 3 -->
                <div class="row aligned-row pt-1" id="boxFactura"> 
                    <div class="col-md-1 checkbox checkbox-inline pt-0 m-0">
                        <div class="pb-1">
                            <h4 class="label-on-left m-0">FACTURA</h4>
                            <input type="checkbox" name="rfc_check" id="rfc_check" <?php echo $statsInput; ?> value="1" <?php if ($cliente[0]->rfc != '' && $cliente[0]->rfc != null) {echo "checked";}?>>
                            <label class="switch" for="rfc_check"></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group label-floating">
                            <div class="d-none" name="regimenl" id="regimenl">
                                <h4 class="label-on-left m-0">RÉGIMEN FISCAL</h4>
                                <select name="regimenFiscal" placeholder="SELECCIONA UNA OPCIÓN" id="regimenFiscal" class="selectpicker m-0 select-gral" data-live-search="true" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                    <!-- <option> SELECCIONA UNA OPCIÓN </option> -->
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <h4 class="label-on-left m-0" name="rfcl" id="rfcl" style="display:none;">RFC</h4>
                            <input type="text" pattern="[A-Za-z0-9]+" class="form-control input-gral" name="rfc" id="rfc" style="display:none;" <?php echo $readOnly; ?>
                            onKeyPress="if(this.value.length==13) return false;" value="<?php echo $cliente[0]->rfc; ?>">   
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <h4 class="label-on-left m-0" style="display:none;" name="codigol" id="codigol">CÓDIGO POSTAL</h4>
                            <input type="number" class="form-control input-gral" min="20000" max="99998" style="display:none;" name="cp_fac" id="cp_fac" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==13) return false;" value="<?php echo $cliente[0]->cp_fac; ?>">        
                        </div>
                    </div>    
                </div>
                <!-- row factura -->
                <div class="row pt-1">
                    <div class="col-sm-6 checkbox-radios" id="radioDS">
                        <h4 class="label-on-left m-0">RESIDENCIA (<small style="color: red;">*</small>)</h4>
                        <div class="radio_container">
                            <input type="radio" name="tipoNc_valor" id="tipoNc_valor1" required="true" onchange="checkResidencia()" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_nc == 0) { echo "checked=true"; } ?>>
                            <label for="tipoNc_valor1">HABITACIONAL</label>

                            <input type="radio" name="tipoNc_valor" id="tipoNc_valor2" required="true" onchange="checkResidencia()" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->tipo_nc == 1) { echo "checked=true"; } ?>> 
                            <label for="tipoNc_valor2">EXTRANJERO</label>
                        </div>
                    </div>
                    <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 boxCustomRadio <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="pagarePart">
                        <h4 class="label-on-left m-0">¿IMPRIME PAGARES?</h4>
                        <div class="d-flex">
                            <div class="w-50 mt-1">
                                <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare1" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 1) { echo "checked=true"; } ?>>
                                <label for="imprimePagare1">SÍ</label>
                            </div>
                            <div class="w-50 mt-1">
                                <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare2" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 0) { echo "checked=true"; } ?>>
                                <label for="imprimePagare2">NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="domicilioCarta">
                        <h4 class="label-on-left m-0">CARTA DOMICILIO CM (<small style="color: red;">*</small>)</h4>
                        <div class="d-flex">
                            <div class="w-50 mt-1">
                                <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante1" value="1" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 1) { echo "checked=true"; } ?>>
                                <label for="tipo_comprobante1">Sí</label>
                            </div>
                            <div class="w-50 mt-1">
                                <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante2" value="0" <?php echo $statsInput; ?> <?php if ($cliente[0]->printPagare == 0) { echo "checked=true"; } ?>>
                                <label for="tipo_comprobante2">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="text-center pt-3">DATOS DEL TITULAR</h4>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                                NOMBRE
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" name="nombre" id="nombre" type="text" required="true" <?php echo $readOnly; ?> <?php echo $readonlyNameToAsesor;?> value="<?=$cliente[0]->nombre?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                                APELLIDO PATERNO
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
                                APELLIDO MATERNO
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" name="apellido_materno" id="apellido_materno" type="text" <?php echo $readOnly; ?><?php echo $readonlyNameToAsesor;?> required="true" value="<?=$cliente[0]->apellido_materno?>"/>
                        </div>                   
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">                  
                            <label class="label-on-left m-0">
                                TELÉFONO CASA
                            </label>
                            <input class="form-control input-gral" name="telefono1" id="telefono1" type="number" step="any" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono1?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">      
                            <label class="label-on-left m-0">
                                CELULAR
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" required="true" name="telefono2" id="telefono2" type="number" step="any" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono2?>" />
                        </div>        
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group m-0">
                            <label class="label-on-left m-0">
                                CORREO ELECTRÓNICO
                                (<small style="color: red;">*</small>)
                            </label>
                            <input class="form-control input-gral" required="true" name="correo" id="correo" type="email" <?php echo $readOnly; ?> value="<?=$cliente[0]->correo?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 dateBox">
                        <label class="label-on-left m-0">FECHA NACIMIENTO(<small style="color: red;">*</small>)</label>
                        <input class="form-control input-gral m-0" required="true" name="fecha_nacimiento" id="fecha_nacimiento" type="date" <?php echo $readOnly; ?> value="<?=$cliente[0]->fecha_nacimiento?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty">
                            <label class="label-on-left m-0" style="top:-29px;">NACIONALIDAD(<small style="color: red;">*</small>)</label>
                            <select name="nacionalidad" required="true" placeholder="SELECCIONA UNA OPCIÓN" id="nacionalidad" class="selectpicker select-gral m-0" data-live-search="true" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
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
                        <label class="label-on-left m-0">ORIGINARIO DE: (<small style="color: red;">*</small>)</label>
                        <input type="text" pattern="[A-Za-z ]+" required="true" class="form-control m-0 input-gral" name="originario" id="originario" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->originario?>"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating select-is-empty">
                            <label class="label-on-left m-0">ESTADO CIVIL(<small style="color: red;">*</small>)</label>
                            <select name="estado_civil" id="estado_civil" required="true" placeholder="SELECCIONA UNA OPCIÓN" class="selectpicker select-gral m-0" data-live-search="true" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <!-- <option value=""> SELECCIONA UNA OPCIÓN </option> -->
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
                        <div class="form-group label-floating select-is-empty">
                            <label class="label-on-left m-0">RÉGIMEN MATRIMONIAL</label>
                            <select name="regimen_matrimonial" placeholder="SELECCIONA UNA OPCIÓN" id="regimen_matrimonial" class="selectpicker select-gral m-0" data-live-search="true" <?php echo $readOnly; ?> <?php echo $statsInput; ?>>
                                <!-- <option value="5"> SELECCIONA UNA OPCIÓN </option> -->
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
                            <label class="label-on-left m-0">NOMBRE DE CÓNYUGE</label>
                            <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="nombre_conyuge" id="nombre_conyuge" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->nombre_conyuge?>"/>
                        </div>
                    </div>              
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">DOMICILIO PARTICULAR(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" required="true" name="domicilio_particular" id="domicilio_particular" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->domicilio_particular?>"/>
                        </div>
                    </div>               
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">OCUPACIÓN(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" required="true" name="ocupacion" id="ocupacion" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->ocupacion?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">EMPRESA EN LA QUE TRABAJA</label>
                            <input class="form-control input-gral" name="empresa"  id="empresa" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->empresa?>"/>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">PUESTO(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="puesto" required="true" id="puesto" type="text" <?php echo $readOnly; ?> value="<?=$cliente[0]->puesto?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">ANTIGÜEDAD <small>(AÑOS)</small></label>
                            <input class="form-control input-gral" name="antiguedad" id="antiguedad" <?php echo $readOnly; ?> pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->antiguedad?>"/>
                        </div>
                    </div>                
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">DOMICILIO EMPRESA</label>
                            <input class="form-control input-gral" name="domicilio_empresa" id="domicilio_empresa" <?php echo $readOnly; ?> type="text" value="<?=$cliente[0]->domicilio_empresa?>"/>
                        </div>
                    </div>                
                </div>  

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">EDAD AL MOMENTO DE FIRMA(<small style="color: red;">*</small>) <small>(AÑOS)</small></label>
                            <input class="form-control input-gral" name="edadFirma" id="edadFirma" <?php echo $readOnly; ?> onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->edadFirma?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">TELÉFONO EMPRESA</label>
                            <input class="form-control input-gral" name="telefono_empresa" id="telefono_empresa" <?php echo $readOnly; ?> pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$cliente[0]->telefono_empresa?>"/>
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col-md-2 checkbox-radios">
                        <div class="radio"  style="color: gray;">
                            VIVE EN CASA:
                        </div>
                    </div>

                    <div class="col-md-2 checkbox-radios required">
                        <div class="radio">
                            <label style="font-size: 0.8em;">
                                <input type="radio" id="tipo_vivienda" <?php echo $statsInput; ?>
                                        name="tipo_vivienda" required <?php if ($cliente[0]->tipo_vivienda == 1) {
                                    echo "checked=true";
                                }
                                ?>  value="1" style="font-size: 0.8em;"/> PROPIA
                            </label>
                        </div>
                    </div>


                    <div class="col-md-2 checkbox-radios required">
                        <div class="radio">
                            <label style="font-size: 0.8em;">
                                <input type="radio" id="tipo_vivienda" name="tipo_vivienda" <?php echo $statsInput; ?>
                                        required <?php if ($cliente[0]->tipo_vivienda == 2) {
                                    echo "checked=true";
                                }
                                ?>  value="2" style="font-size: 0.8em;"/> RENTADA
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 checkbox-radios required">
                        <div class="radio">
                            <label style="font-size: 0.8em;">
                                <input type="radio" id="tipo_vivienda" name="tipo_vivienda" required <?php echo $statsInput; ?>
                                    <?php if ($cliente[0]->tipo_vivienda == 3) {
                                        echo "checked=true";
                                    }
                                    ?>  value="3" style="font-size: 0.8em;"/> PAGÁNDOSE
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 checkbox-radios required">
                        <div class="radio">
                            <label style="font-size: 0.8em;">
                                <input type="radio" id="tipo_vivienda" name="tipo_vivienda" required <?php echo $statsInput; ?>
                                    <?php if ($cliente[0]->tipo_vivienda == 4) {
                                        echo "checked=true";
                                    }
                                    ?>  value="4" style="font-size: 0.8em;"/> FAMILIAR
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 checkbox-radios required">
                        <div class="radio">
                            <label style="font-size: 0.8em;">
                                <input type="radio" id="tipo_vivienda" name="tipo_vivienda" required <?php echo $statsInput; ?>
                                    <?php if ($cliente[0]->tipo_vivienda == 5) {
                                        echo "checked=true";
                                    }
                                    ?>  value="5" style="font-size: 0.8em;"/> OTRO
                            </label>
                        </div>
                    </div>
                </div>

            <?php 
            $limite = $copropiedadTotal[0]->valor_propietarios;
            if($limite>0){ echo '
                <div class="container-fluid p-0" id="containerCopropietario">
                    <h4 class="text-center pt-3">COPROPIETARIO (S)</h4>';
                    for ($i = 0; $i < $limite; $i++) {
                        echo '
                    <h6 class="text-center">PROPIETARIO ' . ($i + 1) . '</h6>                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">NOMBRE</label>
                                <input readonly class="form-control input-gral" type="text" required="true" value="'.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno.'"/>
                                <input id="id_cop[]" name="id_cop[]" type="hidden" value="'.$copropiedad[$i]->id_copropietario.'">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">TELEÉFONO CASA</label>
                                <input  class="form-control input-gral" name="telefono1_cop[]" id="telefono1_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono . '" '.$statsInput.'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">CELULAR</label>
                                <input  class="form-control input-gral" name="telefono2_cop[]" id="telefono2_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono_2 . '" '.$statsInput.'/>
                            </div>
                        </div>
                    </div>

                    <div class="row"> 
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">EMAIL</label>
                                <input  class="form-control input-gral" name="email_cop[]" id="email_cop[]" type="email" value="' . $copropiedad[$i]->correo . '" '.$statsInput.'/>
                            </div>
                        </div>           
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating select-is-empty">
                                <label class="label-on-left m-0">FECHA NACIMIENTO</label>
                                <input  class="form-control input-gral" name="fnacimiento_cop[]" id="fnacimiento_cop[]" type="date" value="' . $copropiedad[$i]->fecha_nacimiento . '" '.$statsInput.'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating select-is-empty">
                                <label class="label-on-left m-0">NACIONALIDAD</label> 
                                <select class="selectpicker select-gral m-0" data-live-search="true" name="nacionalidad_cop[]" id="nacionalidad_cop[]" '.$statsInput.'>
                                <!--$nacionalidades-->';

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
                                <label class="label-on-left m-0">DOMICILIO PARTICULAR</label>
                                <input  class="form-control input-gral" name="id_particular_cop[]" id="id_particular_cop[]" type="text" value="' . $copropiedad[$i]->domicilio_particular . '" style="font-size: 0.9em;" '.$statsInput.'/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0"> ORIGINARIO DE</label>
                                <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="originario_cop[]" id="originario_cop[]" type="text" value="' . $copropiedad[$i]->originario_de . '" style="font-size: 0.9em;" '.$statsInput.'/>
                            </div>
                        </div>        
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating select-is-empty">
                                <label class="label-on-left m-0">ESTADO CIVIL</label>
                                <select class="selectpicker select-gral m-0" data-live-search="true" name="ecivil_cop[]" id="ecivil_cop[]" '.$statsInput.'>
                                        
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
                            <div class="form-group label-floating select-is-empty">
                                <label class="label-on-left m-0">RÉGIMEN</label>
                                <select name="r_matrimonial_cop[]" data-live-search="true" id="r_matrimonial_cop[]" class="selectpicker select-gral m-0" '.$statsInput.'>';
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
                                <label class="label-on-left m-0">NOMBRE DE CÓNYUGE</label>
                                <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="conyuge_cop[]" id="conyuge_cop[]" type="text" value="' . $copropiedad[$i]->conyuge . '" '.$statsInput.'/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">OCUPACIÓN</label>
                                <input  class="form-control input-gral" name="ocupacion_cop[]" id="ocupacion_cop[]" type="text" value="' . $copropiedad[$i]->ocupacion . '" '.$statsInput.'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">PUESTO</label>
                                <input  class="form-control input-gral" name="puesto_cop[]" id="puesto_cop[]" type="text" value="' . $copropiedad[$i]->posicion . '" '.$statsInput.'/>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">ANTIGÜEDAD <small style="font-size: 0.5em;"> (AÑOS)</small></label>
                                <input  class="form-control input-gral" name="antiguedad_cop[]" id="antiguedad_cop[]" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->antiguedad . '" '.$statsInput.'/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">EDAD FIRMA<small style="font-size: 0.5em;">(AÑOS)</small></label>
                                <input  class="form-control input-gral" name="edadFirma_cop[]" id="edadFirma_cop[]" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->edadFirma . '" '.$statsInput.'/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">EMPRESA LABORA</label>
                                <input  class="form-control input-gral" name="empresa_cop[]" id="empresa_cop[]" type="text" value="' . $copropiedad[$i]->empresa . '" '.$statsInput.'/>
                            </div>
                        </div>	
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">DOMICILIO EMPRESA</label>
                                <input  class="form-control input-gral" name="dom_emp_cop[]" id="dom_emp_cop[]" type="text" value="' . $copropiedad[$i]->direccion . '" '.$statsInput.'/>
                            </div>
                        </div>
                    </div>

                    <div class="row pb-3" id="viviendaDS">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10"> 
                            <label class="label-on-left m-0">VIVE EN CASA</label>
                                <div class="radio_container">
                                    <input type="radio" id="tipo_vivienda_cop'.$i.'[]" name="tipo_vivienda_cop'.$i.'"'; if ($copropiedad[$i]->tipo_vivienda == 1) { echo "checked=true"; } echo '  value="1" '.$statsInput.'/> 
                                    <label>PROPIA</label>
                                        
                                    <input type="radio" id="tipo_vivienda_cop'.$i.'[]" name="tipo_vivienda_cop'.$i.'"';if ($copropiedad[$i]->tipo_vivienda == 2) { echo "checked=true"; } echo '  value="2" '.$statsInput.'/>
                                    <label>RENTADA</label>
                        
                                    <input type="radio" id="tipo_vivienda_cop'.$i.'[]" name="tipo_vivienda_cop'.$i.'"';if ($copropiedad[$i]->tipo_vivienda == 3) { echo "checked=true"; } echo '  value="3" '.$statsInput.'/>
                                    <label>PAGÁNDOSE</label>
                        
                                    <input type="radio" id="tipo_vivienda_cop'.$i.'[]" name="tipo_vivienda_cop'.$i.'"';if ($copropiedad[$i]->tipo_vivienda == 4) { echo "checked=true"; } echo '  value="4" '.$statsInput.'/>
                                    <label>FAMILIAR</label>
                        
                                    <input type="radio" id="tipo_vivienda_cop'.$i.'[]" name="tipo_vivienda_cop'.$i.'"';if ($copropiedad[$i]->tipo_vivienda == 5) { echo "checked=true"; } echo '  value="5" '.$statsInput.'/>
                                    <label>OTRO</label>
                                </div>
                            </div>  
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                <label class="label-on-left m-0">RFC</label>
                                <input class="form-control input-gral" name="rfc_cop[]" id="rfc_cop[]" type="text" $readOnly value="'; echo $copropiedad[$i]->rfc; echo ' '.$statsInput.'"/>
                                <input type="hidden" value="'.$limite.'" name="numOfCoprops">
                            </div>
                    </div>';
                    }
                echo '</div>';
                }
                else{
                echo 
                `<center>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <b><label style="color:#0A548B;">SIN DATOS A MOSTRAR<br></label></b>
                    </div>

                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <button class="btn btn-primary btn-round btn-fab btn-fab-mini to-comment agregar_propietario hide" title="Agregar nuevo propietario" style="color:white;"><i class="material-icons">supervisor_account</i></button>
                    </div>
                </center>`;
                }
                ?>
                <h4 class="text-center pt-3 m-0">DATOS GENERALES</h4>
                <h6 class="m-0 text-center"><small>LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO</small></h6>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">EL SR(A):(<small style="color: red;">*</small>)</label>
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
                            <label class="label-on-left m-0">SE COMPROMETE A ADQUIRIR EL LOTE No.</label>
                            <input class="form-control input-gral" name="nombreLote" id="nombreLote" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->nombreLote?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">EN EL CLÚSTER</label>
                            <input class="form-control input-gral" name="nombreCondominio" id="nombreCondominio" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->nombreCondominio?>" readonly="readonly"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">SUPERFICIE</label>
                            <input class="form-control input-gral" name="sup" id="sup" type="text" required="true" <?php echo $readOnly; ?> value="<?=$cliente[0]->sup?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">REFERENCIA</label>
                            <input class="form-control input-gral" name="referencia" id="referencia" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->referencia?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">COSTO POR M<sup>2</sup> LISTA </label>
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
                            <label class="label-on-left m-0">COSTO POR M<sup>2</sup> FINAL (<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="costom2f" id="costom2f" oninput="this.value = formatearNumero(this.value)"  <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->costom2f?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">UNA VEZ QUE SEA AUTORIZADO EL PROYECTO(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="proyecto" id="proyecto" type="text" <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->nombreResidencial?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">EN EL MUNICIPIO DE:(<small style="color: red;">*</small>)</label>
                            <input type="text" pattern="[A-Za-z ]+" required="true" class="form-control input-gral" name="municipioDS" id="municipioDS" type="text" <?php echo $readOnly; ?> required="true" value="<?=$cliente[0]->municipioDS?>"/>
                        </div>
                    </div>            
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">IMPORTE DE LA OFERTA(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="importOferta" id="importOferta" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?> step="any" required="true" value="$<?=$cliente[0]->importOferta?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">IMPORTE EN LETRA(<small style="color: red;">*</small>)</label>
                            <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="letraImport" id="letraImport" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->letraImport?>"/>
                        </div>
                    </div>
                </div>
                <div class="row pb-3 pt-3" id="ofertanteInput">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                        <label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $ (<b><span style="color: red;">*</span></b>)
                            <input class="form-control p-0" name="cantidad" id="cantidad" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?> type="text" required="true" value="<?=$cliente[0]->cantidad?>"/>

                            (<input class="form-control p-0" name="letraCantidad" <?php echo $readOnly; ?> id="letraCantidad" type="text" required="true" value="<?=$cliente[0]->letraCantidad?>"/>),
                            misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo. El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma.
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">SALDO DE DEPÓSITO(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="saldoDeposito" id="saldoDeposito" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?> step="any" required="true" value="<?=$cliente[0]->saldoDeposito?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">APORTACIÓN MENSUAL(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="aportMensualOfer" <?php echo $readOnly; ?> id="aportMensualOfer" type="number" step="any" required="true" value="<?=$cliente[0]->aportMensualOfer?>" step="any"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">FECHA 1° APORTACIÓN(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="fecha1erAport" <?php echo $readOnly; ?> id="fecha1erAport" type="date" required="true" value="<?=$cliente[0]->fecha1erAport?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">PLAZO(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="plazo" id="plazo" <?php echo $readOnly; ?> type="number" step="any" required="true" value="<?=$cliente[0]->plazo?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">FECHA LIQUIDACIÓN DE DEPÓSITO(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" required="true" name="fechaLiquidaDepo" <?php echo $readOnly; ?> id="fechaLiquidaDepo" type="date"  value="<?=$cliente[0]->fechaLiquidaDepo?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group label-floating">
                            <label class="label-on-left m-0">FECHA 2° APORTACIÓN(<small style="color: red;">*</small>)</label>
                            <input class="form-control input-gral" name="fecha2daAport" id="fecha2daAport" <?php echo $readOnly; ?>type="date" required="true" value="<?=$cliente[0]->fecha2daAport?>"/>
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
                        <label style="font-size: 0.7em;">
                            Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.<BR>Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.
                        </label>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row form-inline">
                            <div class="col">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
                                    <label class="label-on-left m-0">En el Municipio de
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control" required="true" name="municipio2" id="municipio2"
                                            <?php echo $readOnly; ?>
                                                type="text" required="true" value="<?=$cliente[0]->municipio2?>" style="text-align: center;"/>, a
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control" name="dia" id="dia" <?php echo $readOnly; ?>
                                                type="number" required="true" value="<?=$cliente[0]->dia?>" style="text-align: center;"/>, del mes de
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control" name="mes" id="mes" <?php echo $readOnly; ?>
                                                type="text" required="true" value="<?=$cliente[0]->mes?>" style="text-align: center;"/>, del año
                                        (<small style="color: red;">*</small>)
                                        <input class="form-control" name="anio" id="anio" <?php echo $readOnly; ?>
                                                type="number" required="true" value="<?=$cliente[0]->anio?>" style="text-align: center;"/>
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
                            <input class="form-control" id="inpPropCoprpNs" type="text" required="true" <?php echo $readOnly; ?>
                                    readonly value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?> <?php echo $copropsNames;?>" style="font-size: 0.9em; text-align: center;"/>
                        </div>
                        <div class="text-center" style="line-height:12px">
                            <label class="label-on-left m-0">Nombre y Firma <b> Ofertante (*)</b></label>
                            <br>
                            <label class="label-on-left m-0">Acepto que se realice una verificación de mis datos, en los teléfonos y correos que proporciono para el otorgamiento del crédito.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="containerReferencia">
                    <h4 class="text-center pt-3">REFERENCIAS PERSONALES</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">NOMBRE(<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" required="true" name="nombre1" <?php echo $readOnly; ?> id="nombre1" type="text" value="<?= ($referencias == 0) ? '' : $referencias[0]->nombre?>"/>
                                <input name="id_referencia1" required="true" <?php echo $readOnly; ?>id="id_referencia1" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[0]->id_referencia?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">PARENTESCO(<small style="color: red;">*</small>)</label>
                                <select name="parentesco1" required="true" placeholder="SELECCIONA UNA OPCIÓN" id="parentesco1" <?php echo $readOnly; ?> class="selectpicker select-gral m-0" <?php echo $statsInput; ?>>
                                    <!-- <option value=""> SELECCIONA UNA OPCIÓN </option> -->
                                    <?php
                                    for($p=0; $p < count($parentescos) ; $p++)
                                    {
                                        if($parentescos[$p]['id_opcion'] == $referencias[0]->parentesco)
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
                                <label class="label-on-left m-0">TELÉFONO(<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" <?php echo $readOnly; ?> name="telefono_referencia1" required="true" id="telefono_referencia1" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[0]->telefono?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating">
                                <label class="label-on-left m-0">NOMBRE(<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" required="true" name="nombre2" <?php echo $readOnly; ?>
                                        id="nombre2" type="text" value="<?= ($referencias == 0) ? '' : $referencias[1]->nombre?>"/>
                                <input name="id_referencia2" required="true" <?php echo $readOnly; ?>
                                        id="id_referencia2" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[1]->id_referencia?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group label-floating select-is-empty">
                                <label class="label-on-left m-0">PARENTESCO(<small style="color: red;">*</small>)</label>
                                <select name="parentesco2" required="true" placeholder="SELECCIONA UNA OPCIÓN" <?php echo $readOnly; ?>id="parentesco2" class="selectpicker select-gral m-0" <?php echo $statsInput; ?>>
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
                                <label class="label-on-left m-0">TELÉFONO(<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" <?php echo $readOnly; ?> name="telefono_referencia2" required="true" id="telefono_referencia2" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[1]->telefono?>"/>
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
                            $gerente 	 = ($asesor2[0]->nombreGerente ==  ''  )?'':$gerenteFinal;

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
                            <label class="label-on-left m-0">OBSERVACIONES(<small style="color: red;">*</small>)</label>
                            <textarea class="form-control pr-2 pl-2" <?php echo $readOnly; ?> id="observacion" name="observacion" required><?php echo $cliente[0]->observacion; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class ="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <label class="label-on-left m-0">EMAIL ASESOR</label>
                        <input name="correo_asesor" <?php echo $readOnly; ?> id="correo_asesor" type="text" class="form-control input-gral" value="<?=$asesor[0]->correo?>" >
                    </div>
                    <div class ="col-xs-12 col-sm-4 col-md-4 col-lg-4" align="center">
                        <div class="input-group">
                            <section>
                                <div>
                                    <div class="togglebutton">
                                        <label>
                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_usuario') == 2752  || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 AND $onlyView==0){?>
                                            <label class="label-on-left m-0">ENVIAR A CLIENTE VÍA EMAIL</label>
                                            <br>
                                            <input id="pdfOK" name="pdfOK" type="checkbox"/>
                                        <?php } ?>
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="row pt-5 mt-5 firmas">
                    <h4 class="text-center">FIRMAS</h4>
                    <div class ="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center">
                        <div class="form-group label-floating">
                            <input class="form-control text-center" <?php echo $readOnly; ?> name="asesor_datos" id="asesor_datos" type="text" required="true" value="<?=$asesor[0]->nombreAsesor?><?=$asesoresVC?>"/>
                        </div>
                        <label class="label-on-left m-0">Nombre y Firma <b> Asesor (*)</b></label>
                    </div>
                    <div class ="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center">      
                        <div class="form-group label-floating">
                            <input class="form-control text-center" <?php echo $readOnly; ?> type="text" name="gerente_datos" id="gerente_datos" required="true" value="<?=$asesor[0]->nombreCoordinador?>, <?=$asesor[0]->nombreGerente?> <?=$coordGerVC?>"/>
                        </div>
                        <label class="label-on-left m-0">Nombre y Firma <b> Autorización de operación (*)</b></label>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class ="col-md-6">
                        <div class="col-sm-12 checkbox-radios" style="text-align: left;padding: 0px;visibility: hidden">
                            <div class="col-md-4 checkbox-radios required">
                                <div class="radio">
                                    <label style="font-size: 0.9em;">
                                        <input type="radio" id="especificar"  name="especificar"  <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->lugar_prospeccion == 6 ) { echo "checked=true"; } ?>  value="6" style="font-size: 0.9em;"/> Marketing Digital
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4 checkbox-radios required">
                                <div class="radio">
                                    <label style="font-size: 0.9em;">
                                        <input type="radio" id="especificar"  name="especificar"  <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->lugar_prospeccion == 12 ) {echo "checked=true";} ?>  value="12" style="font-size: 0.9em;"/> Club Maderas
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row pt-2">
                    <div class="text-center">
                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 ||
                            $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752 ||
                            $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 2855 || $this->session->userdata('id_usuario') == 2815 ||
                            $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 || $this->session->userdata('id_usuario') == 9775 AND $onlyView==0){?>
                            <button type="submit" name="guardarC" class="btn btn-primary" onclick="validaTipoVivienda()">GUARDAR CAMBIOS</button>
                        <?php } else{?>

                            <a href="<?=base_url()?>index.php/Asesor/imprimir_ds/<?=$cliente[0]->id_cliente?>" target="_blank" class="btn btn-primary">IMPRIMIR DEPOSITO SERIEDAD</a>
                        <?php }?>
                    </div>  
                </div>
            </div> 
            <?php echo $html_action_end;?>          
        </div>
    </div>
</div>

    <!-- <?php $this->load->view('template/footer_legend');?> -->

</div>
<div id="mensaje"></div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!-- Modal general -->
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>

<script>
    $(document).ready(function() {
        const e = new Event("change");
        const element = document.querySelector('#rfc_check')
        element.dispatchEvent(e);
    });

    const cliente = "<?=$cliente[0]->id_cliente?>";
    function validaTipoVivienda()
    {
        if (!$("input[name='tipo_vivienda']").is(':checked')) {
            alerts.showNotification('top', 'right', 'Debes seleccionar un tipo de vivienda', 'danger');
        }
        else {
            if (!$("input[name='tipoNc_valor']").is(':checked')) {
                alerts.showNotification('top', 'right', 'Debes seleccionar el tipo de residencia', 'danger');
                $('#tipoNc_valor').focus();
                $('#label1').addClass('hover_focus');
                $('#label2').addClass('hover_focus');
                setTimeout(()=>{
                    $('#label1').removeClass('hover_focus');
                    $('#label2').removeClass('hover_focus');
                },1500)
            }
            else{
                if(!$("input[name='imprimePagare']").is(':checked')  && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
                    alerts.showNotification('top', 'right', 'Debes seleccionar la opción de pagares', 'danger');
                    $('.imprimePagare').focus();
                    $('#labelSi1').addClass('hover_focus');
                    $('#labelNo1').addClass('hover_focus');
                    setTimeout(() => {
                        $('#labelSi1').removeClass('hover_focus');
                        $('#labelNo1').removeClass('hover_focus');
                    }, 1500)
                }
                else{
                    if(!$("input[name='tipo_comprobante']").is(':checked') && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
                        alerts.showNotification('top', 'right', 'Debes seleccionar si requieres la carta de domicilio', 'danger');
                        $('.tipo_comprobante').focus();
                        $('#labelSi2').addClass('hover_focus');
                        $('#labelNo2').addClass('hover_focus');
                        setTimeout(() => {
                            $('#labelSi2').removeClass('hover_focus');
                            $('#labelNo2').removeClass('hover_focus');
                        }, 1500)
                    }
                    else{
                        console.log('continuar...');
                        console.log("$('input[name=tipoNc_valor]:checked').val()", $('input[name=tipoNc_valor]:checked').val());
                    }
                }
            }
        }
    }

    function resizeInput() {
    $(this).attr('size', $(this).val().length);
    }

    $('input[name="letraCantidad"]')
        .keyup(resizeInput)
        .each(resizeInput);

    function checkResidencia(){
        let valor = document.querySelector('input[name="tipoNc_valor"]:checked').value;
        console.log('valor', valor);
        if(valor == 1){
            //si es de residencia extranjera se debe de preguntar si imprime pagares
            $('#pagarePart').removeClass('hide');
            $('#domicilioCarta').removeClass('hide');
            document.getElementsByName("imprimePagare")[0].setAttribute('required', true);
            document.getElementsByName("tipo_comprobante")[0].setAttribute('required', true);
        }else{
            //se vuelve a quitar el apartado de pagares
            $('#pagarePart').addClass('hide');
            $('#domicilioCarta').addClass('hide');
            document.getElementsByName("imprimePagare")[0].removeAttribute('required');
            document.getElementsByName("tipo_comprobante")[0].removeAttribute('required');

        }
    }

    function historial() {
        $.get(`${url}Asesor/getHistorialDS/${cliente}`, function (data) {
            const info = JSON.parse(data);
            if (info.length === 0) {
                alerts.showNotification('top', 'right', 'No hay registro de movimientos', 'warning');
                return;
            }
            changeSizeModal('modal-lg');
            appendBodyModal(historialCampoHtml(info));
            appendFooterModal(`<button type="button" class="btn btn-danger" onclick="hideModal()">Cerrar</button>`);
            showModal();
        });
    }

    function formatearNumero(numero) {
    return numero.toString().replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
    }

    function cargarInputs() {
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].name === "cantidad") {
                inputs[i].value = formatearNumero(inputs[i].value);
            }else if (inputs[i].name === "costom2f") {
                inputs[i].value = formatearNumero(inputs[i].value);
            }else if (inputs[i].name === "costoM2") {
                inputs[i].value = formatearNumero(inputs[i].value);
            }else if (inputs[i].name === "sup"){
                inputs[i].value = formatearNumero(inputs[i].value);
            }else if (inputs[i].name === "importOferta"){
                inputs[i].value = formatearNumero(inputs[i].value);
            }else if (inputs[i].name === "saldoDeposito"){
                inputs[i].value = formatearNumero(inputs[i].value);
            }
        }
    }

    function guardarInputs() {
      var button = document.getElementsByTagName("button");
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {
        if (button[i].type === "submit") {
            inputs[i].value = inputs[i].value.replace(/\,/g, "");
        }
      }
    }

    function historialCampoHtml(data) {
        let html = '<h3>Historial de movimientos</h3>';
        data.forEach(columna => {
            let dataTable = '';
            columna.detalle.forEach(cambio => {
                dataTable += `
                <tr>
				  <td>${(cambio.usuario) ? cambio.usuario : ''}</td>
                  <td>${cambio.fecha}</td>
                  <td>${cambio.anterior}</td>
                  <td>${cambio.nuevo}</td>
                </tr>`;
            });

            html += `
                <div class="row">
                    <div class="col-lg-12">
                        <h4><b>Campo: ${columna.columna}</b></h4>
                    </div>
                    <div class="col-lg-12">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Usuario</th>
                              <th scope="col">Modificación</th>
                              <th scope="col">Valor Anterior</th>
                              <th scope="col">Valor Nuevo</th>
                            </tr>
                          </thead>
                          <tbody>
                            ${dataTable}
                          </tbody>
                        </table>
                    </div>
                </div>
            `;
        });

        return html;
    }

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var urlimg = "<?=base_url()?>img/";

</script>
<?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_usuario') == 2752 || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 AND $onlyView==0){?>
    <script>
        $("#nacionalidad").change(function(){
            var valor_nacionalidad = $('select[name="nacionalidad"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="nac_select" id="nac_select" value="'+valor_nacionalidad+'">');
        });

        $("#estado_civil").change(function(){
            var valor_estado_civil = $('select[name="estado_civil"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+valor_estado_civil+'">');
        });


        $("#regimen_matrimonial").change(function(){
            var valor_regimen = $('select[name="regimen_matrimonial"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="regimen_select" id="regimen_select" value="'+valor_regimen+'">');
        });

        $("#parentezco").change(function(){
            var valor_parentezco = $('select[name="parentezco"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="parentezco_select1" id="parentezco_select1" value="'+valor_parentezco+'">');
        });

        $("#parentezco").change(function(){
            var valor_parentezco = $('select[name="parentezco"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="parentezco_select2" id="parentezco_select2" value="'+valor_parentezco+'">');
        });

        const checkbox = document.getElementById("rfc_check");
        const campo1 = document.getElementById("rfc");
        const campo2 = document.getElementById("rfcl");
        const campo3 = document.getElementById("regimenl");
        const campo5 = document.getElementById("codigol");
        const campo6 = document.getElementById("cp_fac");
    
        checkbox.addEventListener("change", function() {

            if (checkbox.checked) {
                campo1.style.display = "block";
                campo2.style.display = "block";
                campo3.classList.remove("d-none");
                campo5.style.display = "block";
                campo6.style.display = "block";
            } else {
                campo1.style.display = "none";
                campo2.style.display = "none";
                campo3.classList.add("d-none");
                campo5.style.display = "none";
                campo6.style.display = "none";
            }
        });


        $(document).on('click', '.eliminar_propietario', function(e) {

            e.preventDefault();

            var id_copropietario = $(this).val();
            var nombre = $(this).attr("data-value");

            id_valor_copropietario = id_copropietario;

            $("#modal_eliminar .modal-body").html("");
            $("#modal_eliminar .modal-footer").html("");
            $("#modal_eliminar .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de eliminar al propietario <b>'+nombre+'</b>?</p></div></div>');
            $("#modal_eliminar .modal-footer").append('<div class="btn-group"><button type="submit" class="btn btn-success" style="margin-right: 20px;">ACEPTAR</button><button type="button" class="btn btn-danger" onclick="close_eliminar()">CANCELAR</button></div>');
            $("#modal_eliminar").modal();

        });


        $(document).on('click', '.agregar_propietario', function(e) {

            e.preventDefault();


            $.post("<?=base_url()?>index.php/Asesor/getMatrimonialRegime", function(data) {
                var len = data.length;
                for(var i = 0; i<len; i++){
                    var id = data[i]['id_opcion'];
                    var name = data[i]['nombre'];
                    $('#regimen_nuevo').append($('<option>').val(id).text(name.toUpperCase()));
                }
            }, 'json');

            //nacionalidad_nuevo
            /**/$.post("<?=base_url()?>index.php/Asesor/getNationality", function(data) {
                var len = data.length;
                for(var i = 0; i<len; i++){
                    var id = data[i]['id_opcion'];
                    var name = data[i]['nombre'];
                    //nacionalidad_nuevo
                    $('#nacionalidad_nuevo').append($('<option>').val(id).text(name.toUpperCase()));
                }
                $(".select-is-empty").removeClass("is-empty");
                $("#nacionalidad_nuevo").select('refresh');
            }, 'json');

            //estadocivil_nuevo
            /**/$.post("<?=base_url()?>index.php/Asesor/getCivilStatus", function(data) {
                var len = data.length;
                for(var i = 0; i<len; i++){
                    var id = data[i]['id_opcion'];
                    var name = data[i]['nombre'];

                    $('#estadocivil_nuevo').append($('<option>').val(id).text(name.toUpperCase()));
                }
                $(".select-is-empty").removeClass("is-empty"); $("#estadocivil_nuevo").select('refresh');
            }, 'json');




            $("#modal_agregar .modal-body").html("");
            $("#modal_agregar .modal-footer").html("");

            $("#modal_agregar .modal-body").append('<input class="form-control" name="idd" id="idd" type="hidden" value="<?=$cliente[0]->id_cliente?>">');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;">  NOMBRE (<small style="color: red;">*</small>) </label> <input class="form-control" name="nombre_nuevo" id="nombre_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;">  APELLIDO PATERNO (<small style="color: red;">*</small>) </label> <input class="form-control" name="apellidop_nuevo" id="apellidop_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating"> <label class="control-label" style="font-size: 0.8em;"> APELLIDO MATERNO (<small style="color: red;">*</small>) </label> <input class="form-control" name="apellidom_nuevo" id="apellidom_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> EMAIL (<small style="color: red;">*</small>) </label> <input class="form-control" name="correo_nuevo" id="correo_nuevo" type="email" value=""/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> TELEÉFONO CASA</label><input class="form-control" name="telefono1_nuevo" id="telefono1_nuevo" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value=""/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> CELULAR (<small style="color: red;">*</small>)</label><input class="form-control" name="telefono2_nuevo" id="telefono2_nuevo" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value=""/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> FECHA NACIMIENTO (<small style="color: red;">*</small>)</label><input class="form-control" name="fnacimiento_nuevo" id="fnacimiento_nuevo" type="date" value=""/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> NACIONALIDAD (<small style="color: red;">*</small>)</label><select name="nacionalidad_nuevo" id="nacionalidad_nuevo" placeholder="SELECCIONA UNA OPCIÓN" class="form-control"></select></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> ORIGINARIO DE (<small style="color: red;">*</small>) </label> <input class="form-control" name="originario_nuevo" id="originario_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> DOMICILIO PARTICULAR (<small style="color: red;">*</small>) </label> <input class="form-control" name="domicilio_particular_nuevo" id="domicilio_particular_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> ESTADO CIVIL (<small style="color: red;">*</small>)</label><select name="estadocivil_nuevo" id="estadocivil_nuevo" placeholder="SELECCIONA UNA OPCIÓN" class="form-control"></select></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> RÉGIMEN </label><select name="regimen_nuevo" id="regimen_nuevo" placeholder="SELECCIONA UNA OPCIÓN" class="form-control"></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> NOMBRE DE CÓNYUGE (<small style="color: red;">*</small>) </label> <input class="form-control" name="conyuge_nuevo" id="conyuge_nuevo" type="text" required value=""/> </div> </div>');


            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> OCUPACIÓN (<small style="color: red;">*</small>) </label> <input class="form-control" name="ocupacion_nuevo" id="ocupacion_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> PUESTO (<small style="color: red;">*</small>) </label> <input class="form-control" name="puesto_nuevo" id="puesto_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> EMPRESA EN LA QUE TRABAJA (<small style="color: red;">*</small>) </label> <input class="form-control" name="empresa_nuevo" id="empresa_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> ANTIGÜEDAD (<small style="color: red;">*</small>) </label> <input class="form-control" name="antiguedad_nuevo" id="antiguedad_nuevo" type="number" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> EDAD AL MOMENTO DE FIRMA (<small style="color: red;">*</small>) </label> <input class="form-control" name="edad_firma_nuevo" id="edad_firma_nuevo" type="number" required value=""/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> DOMICILIO EMPRESA (<small style="color: red;">*</small>) </label> <input class="form-control" name="domempresa_nuevo" id="domempresa_nuevo" type="text" required value=""/> </div> </div>');

            $("#modal_agregar .modal-footer").append('<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="btn-group"><button type="submit" class="btn btn-success" style="margin-right: 20px;">GUARDAR</button><button type="button" class="btn btn-danger" onclick="close_agregar()">CANCELAR</button></div></div></div>');
            $("#modal_agregar").modal();

        });

        var id_valor_copropietario;
        $("#formulario_eliminar").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {

                var data = new FormData( $(form)[0] );
                data.append("id_copropietario", id_valor_copropietario);

                $.ajax({
                    url: url + "Asesor/eliminar_propietario",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST',
                    success: function(data){
                        if(data.resultado){
                            $("#modal_eliminar").modal('toggle' );
                            location.reload();
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        // var id_valor_copropietario;
        $("#formulario_agregar").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                $.ajax({
                    url: url + "Asesor/agregar_propietario",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST',
                    success: function(data){
                        if(data.resultado){
                            $("#modal_agregar").modal('toggle' );
                            location.reload();
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function close_eliminar(){
            $("#modal_eliminar").modal('toggle');
        }


        function close_agregar(){
            $("#modal_agregar").modal('toggle');
        }
    </script>
<?php } ?>

<script>
    $(document).ready(function () {
        <?php
        if($this->session->userdata('success_coprop')==777 && ($onlyView==1 || $onlyView==0))
        {
        ?>
        alerts.showNotification('top', 'right', 'Se guardaron correctamente los datos', 'success');
        <?php
        $this->session->unset_userdata('success_coprop');
        }
        elseif($this->session->userdata('success_coprop')== -1)
        {?>
        alerts.showNotification('top', 'right', 'Hubo un error al guardar los datos intentalo nuevamente', 'danger');
        <?php
        $this->session->unset_userdata('success_coprop');
        }
        ?>
    });
</script>
</html>
