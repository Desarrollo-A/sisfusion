

--------------------------------------------------Viejo diseño ---------------------------------------------------------

<div class="modal fade modal-alertas" id="modal_eliminar" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-olive"  >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ELIMINAR PROPIETARIO</h4>
                </div>
                <form method="post" id="formulario_eliminar">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>


    <!-- <div class="modal fade modal-alertas" id="modal_agregar" role="dialog"> -->
    <!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_agregar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
            <div class="modal-header bg-olive"  >
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AGREGAR PROPIETARIO</h4>
            </div>
            <form method="post" id="formulario_agregar">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
    </div> -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal_agregar" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-olive"  >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">AGREGAR PROPIETARIO</h4>
                </div>
                <form method="post" id="formulario_agregar">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>


    <?php
    if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752
        || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 2855 ||
        $this->session->userdata('id_usuario') == 2815 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 ||
        $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 || $this->session->userdata('id_usuario') == 9775 AND $onlyView==0)
    {
        $readOnly = '';
        $statsInput = '';
        $html_action = '<form method="post" class="form-horizontal" action="'.base_url().'index.php/Asesor/editar_ds/" target="_blank" enctype="multipart/form-data">';
        $html_action_end = '</form>';
    }
    else
    {
        $readOnly = 'readonly';
        $statsInput = 'disabled';
        $html_action = '';
        $html_action_end = '';

    }
    if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752
        || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834)
    {
        $readonlyNameToAsesor = 'readonly';
    }
    else
    {
        $readonlyNameToAsesor='';
    }
    /*print_r($cliente)*/
    ?>
    
    <div class="content">
        <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <?php echo $html_action;?>
                    <div class="card-content">
                        <div class="container-fluid">
                            <div class="row">    
                                <div class="col-sm-6">
                                    <img src="<?=base_url()?>static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width:100%;align-self: center;"/>
                                </div>
                                    <div class="col-sm-6">
                                        <h4>Depósito de seriedad
                                        <?php if ($this->session->userdata('id_rol') == 17) { ?>
                                            <span class="material-icons cursor-point" style="cursor: pointer;" onclick="historial()">info</span>
                                        <?php }?>
                                        </h4>
                                        <h4 align="lefth"> <label>Fecha última modificación: <?php echo $cliente[0]->fecha_modificacion;?></label> </h4>

                                        <p align="lefth"><label for="clave" style="padding: 1%;">FOLIO: <label style="color: red;"><?php echo $cliente[0]->clave; ?></label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                            <input type="hidden" name="clavevalor" id="clavevalor"  value="<?php echo $cliente[0]->clave; ?>">
                                        <input type="hidden" name="id_cliente" id="id_cliente"  value="<?php echo $cliente[0]->id_cliente; ?>">
                                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 label-on-left">DESARROLLO:</label>                  
                    </div>
                    <div class="row">
                                <div class="col-sm-12 checkbox-radios">
                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 1 || $cliente[0]->desarrollo == 2 || $cliente[0]->desarrollo == 5 ||
                                                        $cliente[0]->desarrollo == 1 || $cliente[0]->desarrollo == 6 || $cliente[0]->desarrollo == 7 || $cliente[0]->desarrollo == 8 || $cliente[0]->desarrollo == 11 || $cliente[0]->desarrollo == 21 || $cliente[0]->desarrollo == 26 || $cliente[0]->desarrollo == 29 || $cliente[0]->desarrollo == 34 || $cliente[0]->desarrollo == 32 || $cliente[0]->desarrollo == 33) {echo "checked=true";} ?>  value="1" style="font-size: 0.9em;"/> Querétaro
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 3 || $cliente[0]->desarrollo == 13 || $cliente[0]->desarrollo == 22 || $cliente[0]->desarrollo == 31) {
                                                        echo "checked=true";
                                                    }
                                                    ?>  value="2" style="font-size: 0.9em;"/> León
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 9 || $cliente[0]->desarrollo == 10) {
                                                        echo "checked=true";
                                                    }
                                                    ?>  value="3" style="font-size: 0.9em;"/> Celaya
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 4 || $cliente[0]->desarrollo == 14 || $cliente[0]->desarrollo == 28 || $cliente[0]->desarrollo == 30) {
                                                        echo "checked=true";
                                                    }
                                                    ?>  value="4" style="font-size: 0.9em;"/> San Luis Potosí
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 12 || $cliente[0]->desarrollo == 17 || $cliente[0]->desarrollo == 25) {
                                                        echo "checked=true";
                                                    }
                                                    ?>  value="5" style="font-size: 0.9em;"/> Mérida
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->desarrollo == 23) {
                                                        echo "checked=true";
                                                    }
                                                    ?>  value="5" style="font-size: 0.9em;"/> SMA
                                            </label>
                                        </div>
                                    </div>
                                        <div class="col-md-2 checkbox-radios required">
                                            <div class="radio">
                                                <label style="font-size: 0.9em;">
                                                    <input type="radio" id="desarrollo" onclick="return false;" name="desarrollo" required <?php echo $statsInput; ?>
                                                        <?php if ($cliente[0]->desarrollo == 27) {
                                                            echo "checked=true";
                                                        }
                                                        ?>  value="5" style="font-size: 0.9em;"/> Cancún
                                                </label>
                                            </div>
                                        </div>
                                    
                            </div>
                    </div>

                        <div class="row">
                            <div class="col-md-9">
                                <label class="col-sm-2 label-on-left">TIPO LOTE:</label>
                                <div class="col-sm-10 checkbox-radios">
                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="0" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipoLote == 0) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> LOTE
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" name="tipoLote_valor" onclick="return false;" id="tipoLote_valor" value="1" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipoLote == 1) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> LOTE COMERCIAL
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>




                        <!--                             <div class="row">
                                <label class="col-sm-2 label-on-left" style="font-weight: bold;color:#545454">DESCUENTO MARTHA DEBAYLE:</label>
                                <div class="col-sm-10 checkbox-radios">
                                    <div class="col-md-2 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" name="descuento_mdb"  id="descuento_mdb" value="1" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->descuento_mdb == 1  && $cliente[0]->descuento_mdb!=NULL) {
                            echo "checked=true";
                        }
                        ?>
                                                    <?php if ($cliente[0]->lugar_prospeccion == 26  || $cliente[0]->lugar_prospeccion == 29 ||
                            $cliente[0]->lugar_prospeccion==32) {
                            echo "disabled";
                        }
                        ?>
                                                    > SÍ
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3 checkbox-radios required">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" name="descuento_mdb"  id="descuento_mdb" value="0" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->descuento_mdb == 0  && $cliente[0]->descuento_mdb!=NULL) {
                            echo "checked=true";
                        }
                        ?>
                                                    <?php if ($cliente[0]->lugar_prospeccion == 26  || $cliente[0]->lugar_prospeccion == 29 ||
                            $cliente[0]->lugar_prospeccion==32) {
                            echo "disabled";
                        }
                        ?>
                                                    > NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        <div class="row">
                            <label class="col-sm-2 label-on-left">DOCUMENTACIÓN:</label>

                            <div class="col-sm-10 checkbox-radios">
                                <div class="col-md-2 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <b>Persona Física</b>
                                    </label>
                                </div>

                                <div class="col-md-3 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="idOficial_pf" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->idOficial_pf == 1) {echo "checked";}?>>Identificación Oficial
                                    </label>
                                </div>

                                <div class="col-md-3 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="idDomicilio_pf" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->idDomicilio_pf == 1) {echo "checked";}?>>Comprobante de Domicilio
                                    </label>
                                </div>

                                <div class="col-md-3 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="actaMatrimonio_pf" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->actaMatrimonio_pf == 1) {echo "checked";}?>>Acta de Matrimonio
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
                                        <input type="checkbox" name="poder_pm" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->poder_pm == 1) {echo "checked";}?>>Poder
                                    </label>
                                </div>

                                <div class="col-md-3 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="actaConstitutiva_pm" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->actaConstitutiva_pm == 1) {echo "checked";}?>>Acta Constitutiva
                                    </label>
                                </div>

                                <div class="col-md-3 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="idOficialApoderado_pm" value="1" <?php echo $statsInput; ?>
                                            <?php if ($cliente[0]->idOficialApoderado_pm == 1) {echo "checked";}?>>Ide. Oficial Apoderado
                                    </label>
                                </div>
                            </div>

                            <label class="col-sm-2 label-on-left"></label>
                            <div class="col-sm-10 checkbox-radios">

                                <div class="col-md-2 checkbox checkbox-inline">
                                    <label style="font-size: 0.9em;">
                                        <input type="checkbox" name="rfc_check" id="rfc_check" <?php echo $statsInput; ?> value="1" <?php if ($cliente[0]->rfc != '' && $cliente[0]->rfc != null) {echo "checked";}?>>FACTURA
                                    </label>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                            <label class="control-label" name="rfcl" id="rfcl" style="font-size: 0.8em; display:none;"> 
                                                RFC
                                            </label>
                                            <input type="text" pattern="[A-Za-z0-9]+" class="form-control" name="rfc" id="rfc" style="display:none;" <?php echo $readOnly; ?>
                                                onKeyPress="if(this.value.length==13) return false;" style="font-size: 0.9em;" value="<?php echo $cliente[0]->rfc; ?>">           
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em; display:none;" name="regimenl" id="regimenl">
                                            RÉGIMEN FISCAL
                                        </label>
                                        <!-- <div id="boxRegimenF"> -->
                                            <select name="regimenFiscal" id="regimenFiscal" class="selectpicker select-gral" <?php echo $readOnly; ?> <?php echo $statsInput; ?>
                                                style="font-size: 0.9em;">
                                                <option value=""> SELECCIONA UNA OPCIÓN </option>
                                                <?php
                                                for($n=0; $n < count($regFis) ; $n++)
                                                {
                                                    if($regFis[$n]['id_opcion'] == $cliente[0]->regimen_fac)
                                                    {
                                                        echo '<option value="'.$regFis[$n]['id_opcion'].'" selected>'.$regFis[$n]['nombre'].'</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'.$regFis[$n]['id_opcion'].'">'.$regFis[$n]['nombre'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        <!-- </div>        -->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 0.8em; display:none;" name="codigol" id="codigol">
                                            CÓDIGO POSTAL
                                        </label>
                                        <input type="number" class="form-control" min="20000" max="99998" style="display:none;" name="cp_fac" id="cp_fac" <?php echo $readOnly; ?>
                                               onKeyPress="if(this.value.length==13) return false;" style="font-size: 0.9em;" value="<?php echo $cliente[0]->cp_fac; ?>">        
                                    </div>
                  
                                </div>
                        </div>

                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <label class="col-sm-2 label-on-left">RESIDENCIA(<small style="color: red;">*</small>):</label>
                                <div class="col-sm-10 checkbox-radios">
                                    <div class="col-md-6 checkbox-radios required">
                                        <div class="radio text-right">
                                            <label style="  font-size: 0.9em;" id="label1">
                                                <input type="radio" name="tipoNc_valor" id="tipoNc_valor1" required="true" onchange="checkResidencia()" value="0" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipo_nc == 0) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> NACIONAL
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 checkbox-radios required">
                                        <div class="radio text-left">
                                            <label style="font-size: 0.9em;" id="label2">
                                                <input type="radio" name="tipoNc_valor" id="tipoNc_valor2" required="true" onchange="checkResidencia()" value="1" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipo_nc == 1) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> EXTRANJERO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="pagarePart">
                                <label class="col-sm-4 label-on-left">¿IMPRIME PAGARES?:</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="col-md-3 checkbox-radios required">
                                        <div class="radio text-left">
                                            <label style="  font-size: 0.9em;">
                                                <input type="radio" name="imprimePagare" id="imprimePagare" value="1" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->printPagare == 1) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> SÍ
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 checkbox-radios required">
                                        <div class="radio text-left">
                                            <label style="font-size: 0.9em;">
                                                <input type="radio" name="imprimePagare" id="imprimePagare" value="0" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->printPagare == 0) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-offset-6 col-md-6 col-lg-offset-6 col-lg-6 <?php echo ($cliente[0]->tipo_nc == 1) ?  '':  'hide'; ?>" id="domicilioCarta">
                                <label class="col-sm-4 label-on-left">CARTA DOMICILIO CM (<small style="color: red;">*</small>):</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="col-md-3 checkbox-radios required">
                                        <div class="radio text-left">
                                            <label style="  font-size: 0.9em;" id="labelSi2">
                                                <input type="radio" name="tipo_comprobante" id="tipo_comprobante1"  value="1" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipo_comprobanteD == 1) {
                                                        echo "checked=true";
                                                    }
                                                    ?>>SÍ
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 checkbox-radios required">
                                        <div class="radio text-left">
                                            <label style="font-size: 0.9em;" id="labelNo2">
                                                <input type="radio" name="tipo_comprobante" id="tipo_comprobante2" value="2" <?php echo $statsInput; ?>
                                                    <?php if ($cliente[0]->tipo_comprobanteD == 2) {
                                                        echo "checked=true";
                                                    }
                                                    ?>> NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group label-floating">
                                    <label class="control-label label-gral" style="font-size: 0.8em;">
                                        NOMBRE
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="nombre" id="nombre" type="text" required="true" <?php echo $readOnly; ?>
                                        <?php echo $readonlyNameToAsesor;?>
                                           value="<?=$cliente[0]->nombre?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        APELLIDO PATERNO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="apellido_paterno" id="apellido_paterno" type="text" <?php echo $readOnly; ?>
                                        <?php echo $readonlyNameToAsesor;?>
                                           required="true" value="<?=$cliente[0]->apellido_paterno?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        APELLIDO MATERNO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="apellido_materno" id="apellido_materno" type="text" <?php echo $readOnly; ?>
                                        <?php echo $readonlyNameToAsesor;?>
                                           required="true" value="<?=$cliente[0]->apellido_materno?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        TELEÉFONO CASA
                                    </label>
                                    <input class="form-control input-gral" name="telefono1" id="telefono1" type="number" step="any" <?php echo $readOnly; ?>
                                           onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono1?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        CELULAR
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="telefono2" id="telefono2" type="number" step="any" <?php echo $readOnly; ?>
                                           onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono2?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EMAIL
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="correo" id="correo" type="email" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->correo?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group label-floating select-is-empty">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        FECHA NACIMIENTO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="fecha_nacimiento" id="fecha_nacimiento" type="date" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->fecha_nacimiento?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group label-floating select-is-empty">
                                    <label class="control-label" style="font-size: 0.8em; top:-29px;">
                                        NACIONALIDAD
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <select name="nacionalidad" id="nacionalidad" class="selectpicker select-gral" style="font-size: 0.9em;"
                                        <?php echo $readOnly; ?> <?php echo $statsInput; ?>><option value=""> SELECCIONA UNA OPCIÓN </option>
                                        <?php
                                        for($p=0; $p < count($nacionalidades) ; $p++)
                                        {
                                            if($nacionalidades[$p]['id_opcion'] == $cliente[0]->nacionalidad)
                                            {
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

                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        ORIGINARIO DE:
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="originario" id="originario" type="text" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->originario?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group label-floating select-is-empty">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        ESTADO CIVIL
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <select name="estado_civil" id="estado_civil" class="selectpicker select-gral" <?php echo $readOnly; ?> <?php echo $statsInput; ?>
                                            style="font-size: 0.9em;">
                                        <option value=""> SELECCIONA UNA OPCIÓN </option>
                                        <?php
                                        for($n=0; $n < count($edoCivil) ; $n++)
                                        {
                                            if($edoCivil[$n]['id_opcion'] == $cliente[0]->estado_civil)
                                            {
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

                            <div class="col-md-4">
                                <div class="form-group label-floating select-is-empty">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        RÉGIMEN
                                    </label>
                                    <select name="regimen_matrimonial" id="regimen_matrimonial" class="selectpicker select-gral" <?php echo $readOnly; ?> <?php echo $statsInput; ?>
                                            style="font-size: 0.9em;">
                                        <option value="5"> SELECCIONA UNA OPCIÓN </option>
                                        <?php
                                        for($n=0; $n < count($regMat) ; $n++)
                                        {
                                            if($regMat[$n]['id_opcion'] == $cliente[0]->regimen_matrimonial)
                                            {
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

                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        NOMBRE DE CÓNYUGE
                                    </label>
                                    <input type="text" pattern="[A-Za-z ]+" class="form-control input-gral" name="nombre_conyuge" id="nombre_conyuge" <?php echo $readOnly; ?>
                                           type="text" value="<?=$cliente[0]->nombre_conyuge?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        DOMICILIO PARTICULAR
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="domicilio_particular" id="domicilio_particular" <?php echo $readOnly; ?>
                                           type="text" value="<?=$cliente[0]->domicilio_particular?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        OCUPACIÓN
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="ocupacion" id="ocupacion" type="text" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->ocupacion?>" style="font-size: 0.9em;"/>
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EMPRESA EN LA QUE TRABAJA
                                    </label>
                                    <input class="form-control input-gral" name="empresa" id="empresa" type="text" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->empresa?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        PUESTO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="puesto" id="puesto" type="text" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->puesto?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        ANTIGÜEDAD <small style="font-size: 0.7em;">(AÑOS)</small>
                                    </label>
                                    <input class="form-control input-gral" name="antiguedad" id="antiguedad" <?php echo $readOnly; ?>
                                           pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->antiguedad?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EDAD AL MOMENTO DE FIRMA
                                        (<small style="color: red;">*</small>) <small style="font-size: 0.7em;">(AÑOS)</small>
                                    </label>
                                    <input class="form-control input-gral" name="edadFirma" id="edadFirma" <?php echo $readOnly; ?>
                                           onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->edadFirma?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>


                            <div class="col-md-7">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        DOMICILIO EMPRESA
                                    </label>
                                    <input class="form-control input-gral" name="domicilio_empresa" id="domicilio_empresa" <?php echo $readOnly; ?>
                                           type="text" value="<?=$cliente[0]->domicilio_empresa?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        TELÉFONO EMPRESA
                                    </label>
                                    <input class="form-control input-gral" name="telefono_empresa" id="telefono_empresa" <?php echo $readOnly; ?>
                                           pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$cliente[0]->telefono_empresa?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>

                        <div class="row"><br></div>


                        <div class="row">
                            <div class="col-md-12 checkbox-radios">
                                <details id="details_section">
                                    <summary><b>COPROPIETARIO(S):</b></summary>
                                    <!-- <p>
                                        <input type="checkbox" name="enviarofertas" checked> Enviar ofertas y promociones a mi dirección de e-mail.</p> -->

                                    <div class="col-xs-12 col-sm-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12" style="background: #C9D0E5;">
                                        <div class="col">
                                            <div class="card-content">

                                                <!-- /////////////////////////////////////////////////////////////////-->

                                                <?php

                                                $limite = $copropiedadTotal[0]->valor_propietarios;

                                                /*print_r($limite);*/
                                                if($limite>0){

                                                    /*print_r($copropiedad);*/
                                                    /*echo '<br>';
                                                    print_r($regMat);*/
                                                    for ($i = 0; $i < $limite; $i++) {
                                                        echo '<center>
                                							<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                							<b><label style="font-size: 1em; color:#0A548B;">PROPIETARIO ' . ($i + 1) . '<br></label></b>
                                							</div>

                                 							</center>

                                							<div class="row">
                                							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div></div>
                                							<style>
                                								#container_coprops input
		                                							{
		                                								border-bottom:1px solid #8a969a;
		                                							}
                                							</style>
                                							<div class="row" id="container_coprops">
                                								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                									<div class="form-group label-floating">
                                										<label class="control-label" style="font-size: 0.8em;">
                                											NOMBRE
                                											</label>
                                											<input readonly class="form-control" type="text" required="true" 
                                											value="'.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno.'" style="font-size: 0.9em;"/>

                                										<input id="id_cop[]" name="id_cop[]" type="hidden" value="'.$copropiedad[$i]->id_copropietario.'">
                                									</div>
                                								</div>
 

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            EMAIL
                                                                        </label>
                                                                        <input  class="form-control" name="email_cop[]" id="email_cop[]" type="email" value="' . $copropiedad[$i]->correo . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            TELEÉFONO CASA
                                                                        </label>
                                                                        <input  class="form-control" name="telefono1_cop[]" id="telefono1_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            CELULAR
                                                                        </label>
                                                                        <input  class="form-control" name="telefono2_cop[]" id="telefono2_cop[]" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="' . $copropiedad[$i]->telefono_2 . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating select-is-empty">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            FECHA NACIMIENTO
                                                                        </label>
                                                                        <input  class="form-control" name="fnacimiento_cop[]" id="fnacimiento_cop[]" type="date" value="' . $copropiedad[$i]->fecha_nacimiento . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating select-is-empty">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            NACIONALIDAD
                                                                            
                                                                        </label> 

                                                                        
                                                                        <select class="form-control" name="nacionalidad_cop[]" id="nacionalidad_cop[]" '.$statsInput.'>
                                                                        <!--$nacionalidades-->
                                                                      
                                                                        ';

                                                        for($n=0; $n < count($nacionalidades) ; $n++)
                                                        {
                                                            if($nacionalidades[$n]['id_opcion'] == $copropiedad[$i]->nacionalidad_valor)
                                                            {
                                                                echo '<option value="'.$nacionalidades[$n]['id_opcion'].'" selected>'.$nacionalidades[$n]['nombre'].'</option>';
                                                            }
                                                            else{
                                                                echo '<option value="'.$nacionalidades[$n]['id_opcion'].'">'.$nacionalidades[$n]['nombre'].'</option>';
                                                            }
                                                        }
                                                        echo '
																		</select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            ORIGINARIO DE:
                                                                            </label>
                                                                        <input type="text" pattern="[A-Za-z ]+" class="form-control" name="originario_cop[]" id="originario_cop[]" type="text" value="' . $copropiedad[$i]->originario_de . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>



                                                                 <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            DOMICILIO PARTICULAR
                                                                        </label>
                                                                        <input  class="form-control" name="id_particular_cop[]" id="id_particular_cop[]" type="text" value="' . $copropiedad[$i]->domicilio_particular . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>



                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating select-is-empty">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            ESTADO CIVIL
                                                                        </label>
                                                                        <select class="form-control" name="ecivil_cop[]" id="ecivil_cop[]" '.$statsInput.'>
                                                                        		
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

                                                                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating select-is-empty">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            RÉGIMEN
                                                                        </label>
                                                                        <select name="r_matrimonial_cop[]" id="r_matrimonial_cop[]" class="form-control" style="font-size: 0.9em;" '.$statsInput.'>
                                                                       
                                                                        	';
                                                        /*$regMat*/
                                                        for($n=0; $n < count($regMat) ; $n++)
                                                        {
                                                            if($regMat[$n]['id_opcion'] == $copropiedad[$i]->regimen_valor)
                                                            {
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

                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            NOMBRE DE CÓNYUGE
                                                                        </label>
                                                                        <input type="text" pattern="[A-Za-z ]+" class="form-control" name="conyuge_cop[]" id="conyuge_cop[]" type="text" value="' . $copropiedad[$i]->conyuge . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>


                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            OCUPACIÓN
                                                                            </label>
                                                                        <input  class="form-control" name="ocupacion_cop[]" id="ocupacion_cop[]" type="text" value="' . $copropiedad[$i]->ocupacion . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>



                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            PUESTO
                                                                            </label>
                                                                        <input  class="form-control" name="puesto_cop[]" id="puesto_cop[]" type="text" value="' . $copropiedad[$i]->posicion . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>



                                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            EMPRESA LABORA
                                                                        </label>
                                                                        <input  class="form-control" name="empresa_cop[]" id="empresa_cop[]" type="text" value="' . $copropiedad[$i]->empresa . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>


                                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            ANTIGÜEDAD <small style="font-size: 0.7em;">(AÑOS)</small>
                                                                        </label>
                                                                        <input  class="form-control" name="antiguedad_cop[]" id="antiguedad_cop[]" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->antiguedad . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            EDAD FIRMA
                                                                             <small style="font-size: 0.7em;">(AÑOS)</small>
                                                                        </label>
                                                                        <input  class="form-control" name="edadFirma_cop[]" id="edadFirma_cop[]" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="' . $copropiedad[$i]->edadFirma . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>


                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                                    <div class="form-group label-floating">
                                                                        <label class="control-label" style="font-size: 0.8em;">
                                                                            DOMICILIO EMPRESA
                                                                        </label>
                                                                        <input  class="form-control" name="dom_emp_cop[]" id="dom_emp_cop[]" type="text" value="' . $copropiedad[$i]->direccion . '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                    </div>
                                                                </div>

                                                                <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                                	<label class="control-label" style="font-size: 0.8em;">
                                                                            VIVE EN CASA
                                                                     </label>
                                                                     <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                     	<div class="col-md-2 checkbox-radios">
																			<div class="radio">
																				<label style="font-size: 0.8em;">
																					<input type="radio" id="tipo_vivienda_cop'.$i.'[]" 
																						   name="tipo_vivienda_cop'.$i.'" 
																						   ';
                                                        if ($copropiedad[$i]->tipo_vivienda == 1) {
                                                            echo "checked=true";
                                                        }
                                                        echo '  value="1" style="font-size: 0.8em;" '.$statsInput.'/> PROPIA
																				</label>
																			</div>
																		</div>
																		<div class="col-md-2 checkbox-radios">
																			<div class="radio">
																				<label style="font-size: 0.8em;">
																					<input type="radio" id="tipo_vivienda_cop'.$i.'[]" 
																						   name="tipo_vivienda_cop'.$i.'" 
																						   ';
                                                        if ($copropiedad[$i]->tipo_vivienda == 2) {
                                                            echo "checked=true";
                                                        }
                                                        echo '  value="2" style="font-size: 0.8em;" '.$statsInput.'/> RENTADA
																				</label>
																			</div>
																		</div>
																		<div class="col-md-2 checkbox-radios">
																			<div class="radio">
																				<label style="font-size: 0.8em;">
																					<input type="radio" id="tipo_vivienda_cop'.$i.'[]" 
																						   name="tipo_vivienda_cop'.$i.'" 
																						   ';
                                                        if ($copropiedad[$i]->tipo_vivienda == 3) {
                                                            echo "checked=true";
                                                        }
                                                        echo '  value="3" style="font-size: 0.8em;" '.$statsInput.'/> PAGÁNDOSE
																				</label>
																			</div>
																		</div>
																		<div class="col-md-2 checkbox-radios">
																			<div class="radio">
																				<label style="font-size: 0.8em;">
																					<input type="radio" id="tipo_vivienda_cop'.$i.'[]" 
																						   name="tipo_vivienda_cop'.$i.'" 
																						   ';
                                                        if ($copropiedad[$i]->tipo_vivienda == 4) {
                                                            echo "checked=true";
                                                        }
                                                        echo '  value="4" style="font-size: 0.8em;" '.$statsInput.'/> FAMILIAR
																				</label>
																			</div>
																		</div>
																		<div class="col-md-2 checkbox-radios">
																			<div class="radio">
																				<label style="font-size: 0.8em;">
																					<input type="radio" id="tipo_vivienda_cop'.$i.'[]" 
																						   name="tipo_vivienda_cop'.$i.'" 
																						   ';
                                                        if ($copropiedad[$i]->tipo_vivienda == 5) {
                                                            echo "checked=true";
                                                        }
                                                        echo '  value="5" style="font-size: 0.8em;" '.$statsInput.'/> OTRO
																				</label>
																			</div>
																		</div>
                                                                     </div>
                                                                </div>
                                                                <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                                	<label class="control-label" style="font-size: 0.8em;">
                                                                            RFC
                                                                     </label>
                                                                     <input class="form-control" name="rfc_cop[]" id="rfc_cop[]" type="text" $readOnly
                                                                      value="'; echo $copropiedad[$i]->rfc; echo '" style="font-size: 0.9em;" '.$statsInput.'/>
                                                                      <input type="hidden" value="'.$limite.'" name="numOfCoprops">
                                                                </div>

                                                            </div>
                                                            <hr>';
                                                    }


                                                }
                                                else{

                                                    echo '<center>
                                							<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                							<b><label style="font-size: 1em; color:#0A548B;">SIN DATOS A MOSTRAR<br></label></b>
                                							</div>

                                							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

                                							<button class="btn btn-primary btn-round btn-fab btn-fab-mini to-comment agregar_propietario hide" title="Agregar nuevo propietario" style="color:white;"><i class="material-icons">supervisor_account</i></button>
                                							</div>

                                							</center>
                                							<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div></div>';




                                                }


                                                ?>

                                                <!-- /////////////////////////////////////////////////////////////////-->

                                            </div>
                                        </div>
                                    </div>
                                </details>
                            </div>
                        </div>


                        <div class="row"><br></div>


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



                        <div class="row"><br></div>



                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EL SR(A):
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <?php

                                    $limite = $copropiedadTotal[0]->valor_propietarios;

                                    /*print_r($limite);*/
                                    if($limite>0){

                                        /*print_r($copropiedad);*/
                                        /*echo '<br>';
                                        print_r($regMat);*/
                                        $copropsNames = '';
                                        for ($i = 0; $i < $limite; $i++) {
                                            $copropsNames .= ' / '.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno;
                                        }
                                    }
                                    else
                                    {
                                        $copropsNames = '';
                                    }
                                    ?>
                                    <input class="form-control" name="" id="" type="text" readonly required="true" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?> <?=$copropsNames?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        SE COMPROMETE A ADQUIRIR EL LOTE No.
                                        <!-- 													(<small style="color: red;">*</small>)
                                         -->												</label>
                                    <input class="form-control" name="nombreLote" id="nombreLote" type="text" <?php echo $readOnly; ?>
                                           required="true" value="<?=$cliente[0]->nombreLote?>" readonly="readonly" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EN EL CLÚSTER
                                        <!-- (<small style="color: red;">*</small>) -->
                                    </label>
                                    <input class="form-control" name="nombreCondominio" id="nombreCondominio" <?php echo $readOnly; ?>
                                           type="text" required="true" value="<?=$cliente[0]->nombreCondominio?>" readonly="readonly" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        DE SUP. APROXIMADA
                                        <!-- (<small style="color: red;">*</small>) -->
                                    </label>
                                    <input class="form-control" name="sup" id="sup" type="text" required="true" <?php echo $readOnly; ?>
                                           value="<?=$cliente[0]->sup?>" readonly="readonly" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        No. REFERENCIA DE PAGO
                                        <!-- (<small style="color: red;">*</small>) -->
                                    </label>
                                    <input class="form-control" name="referencia" id="referencia" type="text" <?php echo $readOnly; ?>
                                           required="true" value="<?=$cliente[0]->referencia?>" readonly="readonly" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        COSTO POR M<sup>2</sup> LISTA
                                        <!-- (<small style="color: red;">*</small>) -->
                                    </label>
                                    <?php
                                    $read='';
                                    $valor='';
                                    $des_val='';
                                    if($cliente[0]->desarrollo == 17){$read=''; $valor=$cliente[0]->costoM2_casas;$des_val=1;}
                                    else{$read ='readonly="readonly"';$valor=$cliente[0]->precio;$des_val=0;}
                                    ?>
                                    <input class="form-control" name="costoM2" id="costoM2" type="text" <?php echo $readOnly; ?>
                                           required="true" value="<?php echo $valor;?>" <?php echo $read;?> style="font-size: 0.9em;"/>
                                    <input type="hidden" name="des_hide" value="<?php echo $des_val;?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        COSTO POR M<sup>2</sup> FINAL
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="costom2f" id="costom2f" oninput="this.value = formatearNumero(this.value)"  <?php echo $readOnly; ?>
                                           step="any" required="true" value="<?=$cliente[0]->costom2f?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        UNA VEZ QUE SEA AUTORIZADO EL PROYECTO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="proyecto" id="proyecto" type="text" <?php echo $readOnly; ?>
                                           step="any" required="true" value="<?=$cliente[0]->nombreResidencial?>"  style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        EN EL MUNICIPIO DE:
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input type="text" pattern="[A-Za-z ]+" class="form-control" name="municipioDS" id="municipioDS" type="text" <?php echo $readOnly; ?>
                                           required="true" value="<?=$cliente[0]->municipioDS?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>


                        <div class="row"></div>


                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.7em;">
                                        <br> LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        IMPORTE DE LA OFERTA
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="importOferta" id="importOferta" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?>
                                         step="any" required="true" value="<?=$cliente[0]->importOferta?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        IMPORTE EN LETRA
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input type="text" pattern="[A-Za-z ]+" class="form-control" name="letraImport" id="letraImport" <?php echo $readOnly; ?>
                                           type="text" required="true" value="<?=$cliente[0]->letraImport?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row form-inline">
                                    <div class="col">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de <b>$</b>
                                                (<b><span style="color: red;">*</span></b>)
                                                <input class="form-control" name="cantidad" id="cantidad" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?>
                                                       type="text" required="true" value="<?=$cliente[0]->cantidad?>" style="font-size: 0.9em; text-align: center;"/>
                                                (<input class="form-control" name="letraCantidad" <?php echo $readOnly; ?>
                                                        id="letraCantidad" type="text" required="true" value="<?=$cliente[0]->letraCantidad?>" style="font-size: 0.9em; text-align: center;"/>)
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
                                    <input class="form-control" name="saldoDeposito" id="saldoDeposito" oninput="this.value = formatearNumero(this.value)" <?php echo $readOnly; ?>
                                        step="any" required="true" value="<?=$cliente[0]->saldoDeposito?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        APORTACIÓN MENSUAL
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="aportMensualOfer" <?php echo $readOnly; ?>
                                           id="aportMensualOfer" type="number" step="any" required="true" value="<?=$cliente[0]->aportMensualOfer?>" step="any" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        FECHA 1° APORTACIÓN
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="fecha1erAport" <?php echo $readOnly; ?>
                                           id="fecha1erAport" type="date" required="true" value="<?=$cliente[0]->fecha1erAport?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        PLAZO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="plazo" id="plazo" <?php echo $readOnly; ?>
                                           type="number" step="any" required="true" value="<?=$cliente[0]->plazo?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        FECHA LIQUIDACIÓN DE DEPÓSITO
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="fechaLiquidaDepo" <?php echo $readOnly; ?>
                                           id="fechaLiquidaDepo" type="date"  value="<?=$cliente[0]->fechaLiquidaDepo?>" style="font-size: 0.9em;"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" style="font-size: 0.8em;">
                                        FECHA 2° APORTACIÓN
                                        (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control" name="fecha2daAport" id="fecha2daAport" <?php echo $readOnly; ?>
                                           type="date" required="true" value="<?=$cliente[0]->fecha2daAport?>" style="font-size: 0.9em;"/>
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
                                                <input class="form-control" name="municipio2" id="municipio2"
                                                    <?php echo $readOnly; ?>
                                                       type="text" required="true" value="<?=$cliente[0]->municipio2?>" style="font-size: 0.9em; text-align: center;"/>, a
                                                (<small style="color: red;">*</small>)
                                                <input class="form-control" name="dia" id="dia" <?php echo $readOnly; ?>
                                                       type="number" required="true" value="<?=$cliente[0]->dia?>" style="font-size: 0.9em; text-align: center;"/>, del mes de
                                                (<small style="color: red;">*</small>)
                                                <input class="form-control" name="mes" id="mes" <?php echo $readOnly; ?>
                                                       type="text" required="true" value="<?=$cliente[0]->mes?>" style="font-size: 0.9em; text-align: center;"/>, del año
                                                (<small style="color: red;">*</small>)
                                                <input class="form-control" name="anio" id="anio" <?php echo $readOnly; ?>
                                                       type="number" required="true" value="<?=$cliente[0]->anio?>" style="font-size: 0.9em; text-align: center;"/>
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
                                        <?php

                                        $limite = $copropiedadTotal[0]->valor_propietarios;

                                        /*print_r($limite);*/
                                        if($limite>0){

                                            /*print_r($copropiedad);*/
                                            /*echo '<br>';
                                            print_r($regMat);*/
                                            $copropsNames = '';
                                            for ($i = 0; $i < $limite; $i++) {
                                                $copropsNames .= ' / '.$copropiedad[$i]->nombre_cop.' '.$copropiedad[$i]->apellido_paterno.' '.$copropiedad[$i]->apellido_materno;
                                            }
                                        }
                                        else
                                        {
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
                                    <label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Ofertante (*)</b></label><label style="font-size: 0.6em;">Acepto que se realice una verificación de mis datos, en los teléfonos y correos que proporciono para el otorgamiento del crédito.
                                    </label>
                                </div>
                            </div>

                            <div class ="col-md-6">
                                <div class="col-md-10" align="center">
                                    <label class="control-label" style="font-size: 0.8em;"><b>REFERENCIAS PERSONALES</b></label>
                                    <?php #print_r($parentescos);
                                    echo '<br><br>';
                                    #print_r($referencias[0]->parentesco);?>
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
                                                            <input class="form-control" name="nombre1" <?php echo $readOnly; ?>
                                                                   id="nombre1" type="text" value="<?= ($referencias == 0) ? '' : $referencias[0]->nombre?>" style="font-size: 0.7em;"/>
                                                            <input name="id_referencia1" <?php echo $readOnly; ?>
                                                                   id="id_referencia1" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[0]->id_referencia?>" style="font-size: 0.7em;"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating select-is-empty">
                                                            <label class="control-label" style="font-size: 0.7em; top: -20px;">
                                                                PARENTESCO
                                                                (<small style="color: red;">*</small>)
                                                            </label>
                                                            <select name="parentesco1" id="parentesco1" <?php echo $readOnly; ?>
                                                                    class="selectpicker select-gral" style="font-size: 0.9em;" <?php echo $statsInput; ?>>
                                                                <option value=""> SELECCIONA UNA OPCIÓN </option>
                                                                <?php
                                                                //print_r($parentescos);
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

                                                    <div class="col-md-3">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" style="font-size: 0.7em;">
                                                                TELÉFONO
                                                                (<small style="color: red;">*</small>)
                                                            </label>
                                                            <input class="form-control" <?php echo $readOnly; ?>
                                                                   name="telefono_referencia1" id="telefono_referencia1" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[0]->telefono?>" style="font-size: 0.7em;"/>
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
                                                            <input class="form-control" name="nombre2" <?php echo $readOnly; ?>
                                                                   id="nombre2" type="text" value="<?= ($referencias == 0) ? '' : $referencias[1]->nombre?>" style="font-size: 0.7em;"/>
                                                            <input name="id_referencia2" <?php echo $readOnly; ?>
                                                                   id="id_referencia2" type="hidden" value="<?= ($referencias == 0) ? '' : $referencias[1]->id_referencia?>" style="font-size: 0.7em;"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating select-is-empty">
                                                            <label class="control-label" style="font-size: 0.7em; top: -20px;">
                                                                PARENTESCO
                                                                (<small style="color: red;">*</small>)
                                                            </label>
                                                            <select name="parentesco2" <?php echo $readOnly; ?>
                                                                    id="parentesco2" class="selectpicker select-gral" style="font-size: 0.9em;" <?php echo $statsInput; ?>>
                                                                <option value=""> SELECCIONA UNA OPCIÓN </option>
                                                                <?php
                                                                //print_r($parentescos);
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

                                                    <div class="col-md-3">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label" style="font-size: 0.7em;">
                                                                TELÉFONO
                                                                (<small style="color: red;">*</small>)
                                                            </label>
                                                            <input class="form-control" <?php echo $readOnly; ?>
                                                                   name="telefono_referencia2" id="telefono_referencia2" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?= ($referencias == 0) ? '' : $referencias[1]->telefono?>" style="font-size: 0.7em;"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                                <!-- termina div 12 -->
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
                                    <textarea class="form-control" <?php echo $readOnly; ?>
														  id="observacion" name="observacion"><?php echo $cliente[0]->observacion; ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row"><br><br></div>
                        <?php /*print_r($asesor2)*/ ;


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
                        else
                        {
                            $asesoresVC = '';
                            $coordGerVC = '';
                        }


                        /*coord gerente asesor normal*/
                        $coordGerenteVN = '';
                        if($asesor[0]->nombreCoordinador==' ')
                        {

                            $coordinadorVN = '';
                        }
                        else
                        {
                            $coordinadorVN = '- '.$asesor[0]->nombreCoordinador.', ';
                        }
                        if($asesor[0]->nombreGerente=='')
                        {
                            $gerenteVN = '';
                        }
                        else
                        {
                            $gerenteVN = $asesor[0]->nombreGerente;
                        }
                        $coordGerenteVN = $coordinadorVN.$gerenteVN;

                        ?>
                        <?php
                        /*echo '<script> console.log("'.$asesor[0]->nombreCoordinador.'");</script>';
                        echo '<script> console.log("'.$coordGerenteVN.'");</script>'; ;?>
                        <?php print_r($asesor) ;*/?>

                        <div class="row">
                            <div class ="col-md-6">
                                <div class="col-md-10" align="center">
                                    <div class="form-group label-floating">
                                        <input class="form-control" <?php echo $readOnly; ?>
                                               name="asesor_datos" id="asesor_datos" type="text" required="true" value="<?=$asesor[0]->nombreAsesor?> <?=$asesoresVC?>" style="font-size: 0.7em; text-align: center;"/>
                                    </div>
                                    <label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Asesor (*)</b></label>
                                </div>

                            </div>

                            <div class ="col-md-6">
                                <div class="col-md-10" align="center">
                                    <div class="form-group label-floating">
                                        <input class="form-control" <?php echo $readOnly; ?>
                                               type="text" name="gerente_datos" id="gerente_datos" required="true"
                                               value="<?=$asesor[0]->nombreCoordinador?>, <?=$asesor[0]->nombreGerente?> <?=$coordGerVC?>" style="font-size: 0.7em; text-align: center;"/>
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
                                        <input name="correo_asesor" <?php echo $readOnly; ?>
                                               id="correo_asesor" type="text" style="font-size: 0.8em;" class="form-control" width="auto" value="<?=$asesor[0]->correo?>" >
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
                                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_usuario') == 2752  || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 AND $onlyView==0){?>
                                                            <input id="pdfOK" name="pdfOK" type="checkbox"/><b style="color: #0A548B">ENVIAR A CLIENTE VÍA EMAIL</b>
                                                        <?php } ?>
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
												<input id="especificar" name="especificar"
													   type="checkbox" <?php if ($cliente[0]->lugar_prospeccion == 12) {
                                    echo "checked";
                                } ?> <?php echo $statsInput; ?>/> <b style="color: #0A548B">CLUB MADERAS</b>
											</label>
										</div>
									</div>-->
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
                        </div>







                    </div>

                    <div class="datos_select"></div>

                    <div class="card-footer text-center">
                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 ||
                            $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 2752 ||
                            $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 2855 || $this->session->userdata('id_usuario') == 2815 ||
                            $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 || $this->session->userdata('id_usuario') == 9775 AND $onlyView==0){?>
                            <button type="submit" name="guardarC" class="btn btn-primary btn-fill" onclick="validaTipoVivienda()">GUARDAR CAMBIOS</button>
                        <?php } else{?>

                            <a href="<?=base_url()?>index.php/Asesor/imprimir_ds/<?=$cliente[0]->id_cliente?>" target="_blank" class="btn btn-primary">IMPRIMIR DEPOSITO SERIEDAD</a>
                        <?php }?>
                    </div>
                    <!--</form>-->
                    <?php echo $html_action_end;?>
                </div>
            </div>
        </div>
    </div>