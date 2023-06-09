<style type="text/css">
    .input-group .bootstrap-select.form-control {
        z-index: inherit;
    }
</style>
<body>

<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>


    <div class="content">
        <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                        <i class="material-icons">list</i>
                    </div>

                    <form method="post" class="form-horizontal" action="<?=base_url()?>index.php/registroCliente/editar_ds_ea/" target="_blank" enctype="multipart/form-data">
                    	    <input type="hidden" name="idCliente" value="<?=$cliente->idCliente?>" />
                        <div class="card-content">
                            <h4 class="card-title"><B>Depósito de seriedad</B> - Formato (versión anterior)</h4>
								<h4 align="right"> <label>Fecha última modificación: <?php echo $cliente->fecha_modificacion;?></label> </h4> 


                            <div class="row">
                                <div class="col-lg-12">
                                    <p align="right"><label for="clave">FOLIO: <label style="color: red;"><?php echo $cliente->clave ?></label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                    <input type="hidden" name="clavevalor" id="clavevalor"  value="<?php echo $cliente->clave ?>">
                                    <input type="hidden" name="id_cliente" id="id_cliente"  value="<?php echo $cliente->clave ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <img src="<?=base_url()?>static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width:100%;align-self: center;"/>
                                </div>

                                <div class="col-md-9">
                                    <label class="col-sm-2 label-on-left">DESARROLLO:</label>
                                    <div class="col-sm-10 checkbox-radios">
                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="1" <?php if($cliente->desarrollo=='1') echo "checked=true"?>> Querétaro
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="2" <?php if($cliente->desarrollo=='2') echo "checked=true"?>> León
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="3" <?php if($cliente->desarrollo=='3') echo "checked=true"?>> Celaya
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="4" <?php if($cliente->desarrollo=='4' OR $cliente->idResidencial=='14') echo "checked=true"?>> San Luis Potosí
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="5" <?php if($cliente->desarrollo=='5') echo "checked=true"?>> Mérida
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <label class="col-sm-2 label-on-left">TIPO LOTE:</label>
                                    <div class="col-sm-10 checkbox-radios">
                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="CAMPO04" name="CAMPO04" onclick="return false;" value="0" <?php if($cliente->tipo_lote=='0') echo "checked=true"?>> Lote
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-3 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="CAMPO04" name="CAMPO04" onclick="return false;" value="1" <?php if($cliente->tipo_lote=='1') echo "checked=true"?>> Lote Comercial
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 label-on-left">DOCUMENTACIÓN:</label>

                                <div class="col-sm-10 checkbox-radios">
                                    <div class="col-md-2 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <b>Persona física</b>
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO05" name="CAMPO05" value="1" <?php if($cliente->idOficial_pf == 1){echo "checked";}  ?>> Identificación&nbsp;Oficial
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO06" name="CAMPO06" value="1" <?php if($cliente->idDomicilio_pf == 1){echo "checked";}  ?>> Comprobante&nbsp;de&nbsp;Domicilio
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO07" name="CAMPO07" value="1" <?php if($cliente->actaMatrimonio_pf == 1){echo "checked";}  ?>> Acta&nbsp;de&nbsp;Matrimonio
                                        </label>
                                    </div>
                                </div>


                                <div class="col-sm-10 checkbox-radios">

                                    <div class="col-md-2 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <b>Persona Moral</b>
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO09"  name="CAMPO09" value="1" <?php if($cliente->poder_pm == 1){echo "checked";}  ?>> Poder
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO08"  name="CAMPO08" value="1" <?php if($cliente->actaConstitutiva_pm == 1){echo "checked";}  ?>> Acta&nbsp;Constitutiva
                                        </label>
                                    </div>

                                    <div class="col-md-3 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            <input type="checkbox" id="CAMPO10" name="CAMPO10" value="1" <?php if($cliente->idOficialApoderado_pm == 1){echo "checked";}  ?>> Identificación&nbsp;Oficial&nbsp;Apoderado
                                        </label>
                                    </div>
                                </div>

                                <label class="col-sm-2 label-on-left"></label>
                                <div class="col-sm-10 checkbox-radios">
                                    <div class="col-md-2 checkbox checkbox-inline">
                                    </div>

                                    <div class="col-md-1 checkbox checkbox-inline">
                                        <label style="font-size: 0.9em;">
                                            RFC
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="rfc" id="rfc" onKeyPress="if(this.value.length==13) return false;" style="font-size: 0.9em;" value="<?php echo $cliente->rfc; ?>">
                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            NOMBRE
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input name="nombre" id="nombre" type="text" class="form-control" style="font-size: 0.9em;" value="<?=$cliente->nombrecliente?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            TELÉFONO CASA
                                        </label>
                                        <input type="text" class="form-control" id="telefono1" style="font-size: 0.9em;" name="telefono1" value="<?=$cliente->telefono1?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            CELULAR
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="telefono2" style="font-size: 0.9em;" name="telefono2" value="<?=$cliente->telefono2?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            EMAIL
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="correo" name="correo" value="<?=$cliente->correo?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            FECHA  NACIMIENTO
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?=$cliente->fechaNacimiento?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            NACIONALIDAD
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO21" name="CAMPO21" value="<?=$cliente->nacionalidad?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            ORIGINARIO DE
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input class="form-control" id="CAMPO22" name="CAMPO22" value=" <?php echo $cliente->originario; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            ESTADO CIVIL
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <select id="CAMPO23" name="CAMPO23" class="form-control"  style="width: 90%; heigt: 28px;display: none">
                                            <option value="CASADO" <?php if($cliente->estadoCivil=='CASADO') echo " SELECTED"?>>CASADO</option>
                                            <option value="SOLTERO" <?php if($cliente->estadoCivil=='SOLTERO') echo " SELECTED"?>>SOLTERO</option>
                                            <option value="VIUDO O DIVORCIADO" <?php if($cliente->estadoCivil=='VIUDO O DIVORCIADO') echo " SELECTED"?>>VIUDO O DIVORCIADO</option>
                                        </select>
                                        <input  id="CAMPO23" class="form-control" name="CAMPO23" value="<?php echo $cliente->estadoCivil;?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            RÉGIMEN MATRIMONIAL
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class=form-control id="CAMPO25" name="CAMPO25" value="<?=$cliente->regimen?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            NOMBRE DEL CÓNYUGE
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO24" name="CAMPO24" value="<?=$cliente->nombreConyuge?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            DOMICILIO PARTICULAR
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input name="domicilio_particular" id="domicilio_particular" type="text" class="form-control" value="<?=$cliente->domicilio_particular?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            OCUPACIÓN
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO27" name="CAMPO27" value="<?=$cliente->ocupacion?>">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            EMPRESA EN LA QUE TRABAJA
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO28" name="CAMPO28" value="<?=$cliente->empresaLabora?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            PUESTO
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO29" name="CAMPO29" value="<?=$cliente->puesto?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            ANTIGÜEDAD (AÑOS)
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO30" name="CAMPO30" value="<?=$cliente->antigueda?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            EDAD AL MOMENTO DE LA FIRMA
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO31" name="CAMPO31" required="required" value="<?=$cliente->edadFirma?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            DOMICILIO EMPRESA
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO32" name="CAMPO32" value="<?=$cliente->domicilioEmpresa?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            TELÉFONO EMPRESA
                                        </label>
                                        <input type="text" class="form-control" id="CAMPO34" name="CAMPO34" value="<?=$cliente->telefonoEmp?>">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            VIVE EN CASA:
                                        </label>
                                        <div class="checkbox-radios">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" id="CAMPO35" name="CAMPO35" value="1" <?php if($cliente->casa=='1') echo "checked=true"?>> PROPIA
                                                </label>
                                                <label>
                                                    <input type="radio" id="CAMPO35" name="CAMPO35"  value="2" <?php if($cliente->casa=='2') echo "checked=true"?>> RENTADA
                                                </label>
                                                <label>
                                                    <input type="radio" id="CAMPO35" name="CAMPO35" value="3" <?php if($cliente->casa=='3') echo "checked=true"?>> PAGÁNDOSE
                                                </label>
                                                <label>
                                                    <input type="radio" id="CAMPO35" name="CAMPO35" value="4" <?php if($cliente->casa=='4') echo "checked=true"?>> FAMILIAR
                                                </label>
                                                <label>
                                                    <input type="radio" id="CAMPO35" name="CAMPO35"  value="5" <?php if($cliente->casa=='5') echo "checked=true"?>> OTRO
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            El Sr.(a) (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input name="nombre" style="font-size: 0.9em;" id="nombre" type="text" class="form-control"  value="<?=$cliente->nombrecliente?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                    $proyecto = str_replace(' ', '',$cliente->nombreResidencial);
                                    $condominio = strtoupper($cliente->nombreCondominio);
                                    $numeroLote = preg_replace('/[^0-9]/','',$cliente->nombreLote);
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            SE COMPROMETE A ADQUIRIR EL LOTE NO. (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="numeroLote" name="numeroLote"  onkeypress="return valida(event)" value="<?=$numeroLote?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            EN EL CLÚSTER (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO38" name="CAMPO38" value="<?=$condominio?>" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            DE SUP. APROX. (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO39" name="CAMPO39" onkeypress="return valida(event)" value="<?=$cliente->sup?>" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            NO. DE REF. DE PAGO (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO40" name="CAMPO40" value="<?=$cliente->referencia?>" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            COSTO POR M<sup>2</sup> LISTA (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO41" name="CAMPO41" onkeypress="return valida(event)" value="<?=$cliente->precio?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            COSTO POR M<sup>2</sup> FINAL (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO41_1"  name="CAMPO41_1" onkeypress="return valida(event)" value="<?=$cliente->costom2f?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            UNA VEZ QUE SEA AUTORIZADO EL PROYECTO (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO42"  name="CAMPO42" value="<?=$cliente->proyecto?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            EN EL MUNICIPIO DE (<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO43" name="CAMPO43" value="<?=$cliente->municipioDS?>"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            IMPORTE DE LA OFERTA $(<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-control" id="CAMPO44" name="CAMPO44" onkeypress="return valida(event)" value="<?=$cliente->importOferta?>">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            IMPORTE DE LA OFERTA (LETRA)(<b><span style="color: red;">*</span></b>)
                                        </label>
                                        <input type="text" style="font-size: 0.9em;" class="form-cont" style="width: 88%;" id="CAMPO45" name="CAMPO45" value="<?=$cliente->letraImport?>"> 00/100 M.N.)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class ="col-md-12">
                                    <div class="row form-inline">
                                        <div class="col">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de <b>$</b>
                                                    (<b><span style="color: red;">*</span></b>)
                                                    <input type="text"   class="form-control" id="CAMPO46" name="CAMPO46" onkeypress="return valida(event)" value="<?=$cliente->cantidad?>">
                                                    (<input type="text" class="form-control" id="CAMPO47" name="CAMPO47" value="<?=$cliente->letraCantidad?>">)
                                                    , misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo. El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><BR></div>


                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            SALDO DE DEPÓSITO
                                        </label>
                                        <input type="text" class="form-control" style="font-size: 0.9em;" id="CAMPO48" name="CAMPO48"   onkeypress="return valida(event)" value="<?=$cliente->saldoDeposito?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            APORTACIÓN MENSUAL
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control" style="font-size: 0.9em;" id="CAMPO49" name="CAMPO49"  onkeypress="return valida(event)" value="<?=$cliente->aportMensualOfer?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            FECHA 1° APORTACIÓN
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="date" class="form-control" style="font-size: 0.9em;" id="CAMPO50" name="CAMPO50"  value="<?=$cliente->fecha1erAport?>">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            PLAZO
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="text" class="form-control"  style="font-size: 0.9em;" id="CAMPO51" name="CAMPO51" onkeypress="return valida(event)" value="<?=$cliente->plazo?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            FECHA LIQUIDACIÓN DE DEPÓSITO
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="date" class="form-control" style="font-size: 0.9em;" id="CAMPO52" name="CAMPO52" value="<?=$cliente->fechaLiquidaDepo?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            FECHA 2° APORTACIÓN
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <input type="date" class="form-control" style="font-size: 0.9em;" id="CAMPO53" name="CAMPO53" value="<?=$cliente->fecha2daAport?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br></div>

                            <div class="row">
                                <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row form-inline">
                                        <div class="col">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
                                                <label style="font-size: 0.7em;">
                                                    Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.<BR>Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br></div>

                            <div class="row">
                                <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row form-inline">
                                        <div class="col">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
                                                <label style="font-size: 0.9em;">En el Municipio de
                                                    (<small style="color: red;">*</small>)
                                                    <input type="text" class="form-control" id="CAMPO54" name="CAMPO54" value="<?=$cliente->municipio2?>">, a
                                                    (<small style="color: red;">*</small>)
                                                    <input type="text" class="form-control" id="CAMPO55" readonly name="CAMPO55" onkeypress="return valida(event)" value="<?=$cliente->dia?>">, del mes de
                                                    (<small style="color: red;">*</small>)
                                                    <input type="text" class="form-control" id="CAMPO56" name="CAMPO56" readonly value="<?=$cliente->mes?>">, del año
                                                    (<small style="color: red;">*</small>)
                                                    <input type="text" readonly class="form-control" id="CAMPO57" name="CAMPO57" onkeypress="return valida(event)" value="<?=$cliente->año?>">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br></div><hr>


                            <div class="row">
                                <div class ="col-md-6">
                                    <div class="col-md-10" align="center">
                                        <div class="form-group label-floating">
                                            <br><br><br>

                                            <input type="text" class="form-control" style="width: 60%;" id="CAMPO58" name="CAMPO58" value="<?=$cliente->nombrecliente?>">
                                        </div>
                                        <label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Ofertante (*)</b></label><label style="font-size: 0.6em;">Acepto que se realice una verificación de mis datos, en los teléfonos y correos que proporciono para el otorgamiento del crédito.
                                        </label>
                                    </div>
                                </div>

                                <div class ="col-md-6">
                                    <div class="col-md-10" align="center">
                                        <label class="control-label" style="font-size: 0.8em;"><b>REFERENCIAS PERSONALES</b></label>
                                    </div>

                                    <div class="col-md-2"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><BR></div>

                                    <div class="col-xs-12 col-sm-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12" style="background: #C9D0E5;">
                                        <div class="col">
                                            <div class="card" style="margin: 10px 0;">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ><br>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    NOMBRE
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="referencia1" name="referencia1" value="<?= $cliente->referencia1 ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    PARENTESCO
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="CAMPO61" name="CAMPO61" value="<?= $cliente->parentescoReferen ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    TELÉFONO
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="telreferencia1" name="telreferencia1" onkeypress="return valida(event)" value="<?= $cliente->telreferencia1 ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ><br>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    NOMBRE
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="referencia2" name="referencia2" value="<?=$cliente->referencia2?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    PARENTESCO
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="CAMPO64" name="CAMPO64" value="<?=$cliente->parentescoReferen2?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" style="font-size: 0.7em;">
                                                                    TELÉFONO
                                                                    (<small style="color: red;">*</small>)
                                                                </label>
                                                                <input type="text" class="form-control" id="telreferencia2" name="telreferencia2" onkeypress="return valida(event)" value="<?=$cliente->telreferencia2?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br></div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em;">
                                            OBSERVACIONES
                                            (<small style="color: red;">*</small>)
                                        </label>
                                        <textarea id="CAMPO59" name="CAMPO59" class="form-control" rows="5"><?php echo $cliente->observacion; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br><br></div>

                            <div class="row">
                                <div class ="col-md-6">
                                    <div class="col-md-10" align="center">
                                        <div class="form-group label-floating">
                                            <input type="text" class="form-control" id="CAMPO66" readonly name="CAMPO66" value="<?=$cliente->asesor?> / <?=$cliente->asesor2?> / <?=$cliente->asesor3?>">
                                        </div>
                                        <label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Asesor (*)</b></label>
                                    </div>
                                </div>
                                <div class ="col-md-6">
                                    <div class="col-md-10" align="center">
                                        <div class="form-group label-floating">
                                            <input type="text" class="form-control" id="CAMPO67" readonly name="CAMPO67" value="<?=$cliente->gerente1?> / <?=$cliente->gerente2?> / <?=$cliente->gerente3?>">
                                        </div>
                                        <label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Autorización de operación (*)</b></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class ="col-md-6">
                                    <div class="col-md-10" align="center">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><label>Email Asesor: </label></span>
                                            <input type="email" class="form-control" id="CAMPO68" name="CAMPO68" value="<?=$cliente->email2?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

						    <div class="row">
								<div class ="col-md-6">
									<div class="col-md-10" align="left">
										<div class="input-group"><br>
											<section>
												<div>
													<div class="togglebutton">
														<label>
															<input id="pdfOK" name="pdfOK" type="checkbox" class="pdfok"/><b style="color: #0A548B">ENVIAR A CLIENTE VÍA EMAIL</b>
														</label>
													</div>
												</div>
											</section>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class ="col-md-6">
									<!--<div class="col-md-10" align="left">
										<div class="togglebutton">
											<label>
												<input id="especificar" name="especificar" type="checkbox" <?php if ($cliente->especificar == 12) { echo "checked"; } ?>/> <b style="color: #0A548B">CLUB MADERAS</b>
											</label>
										</div>
									</div>-->
                                    <div class="col-sm-12 checkbox-radios" style="text-align: left;padding: 0px;visibility: hidden;">
                                        <div class="col-md-4 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="especificar"  name="especificar"
                                                        <?php if ($cliente->especificar == 6 ) { echo "checked=true"; } ?>  value="6" style="font-size: 0.9em;"/> Marketing Digital
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="especificar"  name="especificar"
                                                        <?php if ($cliente->especificar == 12 ) {echo "checked=true";} ?>  value="12" style="font-size: 0.9em;"/> Club Maderas
                                                </label>
                                            </div>
                                        </div>

                                        
                                    </div>
								</div>
							</div>

							
                        </div>


                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-fill">GUARDAR CAMBIOS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('template/footer_legend');?>

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

</html>
