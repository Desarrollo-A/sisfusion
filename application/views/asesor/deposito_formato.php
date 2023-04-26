<link href="<?= base_url() ?>dist/css/depositoSeriedad.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body onload="cargarInputs()" onsubmit="guardarInputs()">

<div class="wrapper">
    <?php
    //echo $onlyView;
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    // $this->load->view('template/sidebar', $datos);

    ?>


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

<div class="container pt-5">
    <div class="card">
        <div class="container-fluid p-5">
            <div class="row" id="encabezadoDS">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <img src="<?=base_url()?>static/images/Logo_CM&TP_1.png" alt="Servicios Condominales" title="Servicios Condominales" style="width:100%;align-self: center;"/>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h3 class="m-0 mb-2">DEPÓSITO DE SERIEDAD
                        <i class="fas fa-info-circle fa-xs" style="cursor: pointer;" onclick="historial()"></i>
                        <?php if ($this->session->userdata('id_rol') == 17) { ?>
                            <i class="fas fa-info-circle" style="cursor: pointer;" onclick="historial()"></i>
                        <?php }?>
                    </h3>  
                    <h6 class="m-0">Fecha última modificación: <?php echo $cliente[0]->fecha_modificacion;?> </h6>
                    <h6 class="m-0">Folio: <?php echo $cliente[0]->clave; ?></h6>
                        <input type="hidden" name="clavevalor" id="clavevalor"  value="<?php echo $cliente[0]->clave; ?>">
                    <input type="hidden" name="id_cliente" id="id_cliente"  value="<?php echo $cliente[0]->id_cliente; ?>">
                </div>
            </div>
            <div class="row pt-3" id="radioDS">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h4 class="label-on-left">DESARROLLO</h4>
                    <div class="container">
                        <div class="radio_container">
                            <input type="radio" name="radio" id="one" checked>
                            <label for="one">QRO</label>
                            <input type="radio" name="radio" id="two">
                            <label for="two">LN</label>
                            <input type="radio" name="radio" id="three">
                            <label for="three">CLY</label>
                            <input type="radio" name="radio" id="four">
                            <label for="four">SLP</label>
                            <input type="radio" name="radio" id="five">
                            <label for="five">MER</label>
                            <input type="radio" name="radio" id="six">
                            <label for="six">SMA</SMAll></label>
                            <input type="radio" name="radio" id="seven">
                            <label for="seven">CNC</label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h4 class="label-on-left">TIPO LOTE</h4>
                    <div class="container">
                        <div class="radio_container">
                            <input type="radio" name="lotHab" id="lotHab" checked>
                            <label for="one1">HABITACIONAL</label>
                            <input type="radio" name="lotCom" id="lotCom">
                            <label for="two2">COMERCIAL</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3" id="checkDS">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class="label-on-left">PERSONA FÍSICA</h4>
                    <div class="container boxChecks p-0">
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input  type="checkbox" class="nombre" name="checks" value="nombre">
                                <span>IDENTIFICACIÓN OFICIAL</span>
                            </label>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input  type="checkbox" class="nombre" name="checks" value="apellido_paterno">
                                <span>COMPROBANTE DE DOMICILIO</span>
                            </label>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
                                <span>ACTA DE MATRIMONIO</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3" id="checkDS">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class="label-on-left">PERSONA MORAL</h4>
                    <div class="container boxChecks p-0">
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
                                <span>PODER</span>
                            </label>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 p-0">
                            <label class="m-0 checkstyleDS">
                                <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
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


            <div class="row pt-3" id="boxFactura"> 
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





                /**/if(!$("input[name='imprimePagare']").is(':checked')  && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
                    alerts.showNotification('top', 'right', 'Debes seleccionar la opción de pagares', 'danger');
                    $('#imprimePagare').focus();
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
                        $('#tipo_comprobante').focus();
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

//     $("#cantidad").on({
//   "focus": function(event) {
//     $(event.target).select();
//   },
//   "keyup": function(event) {
//     $(event.target).val(function(index, value) {
//       return value.replace(/\D/g, "")
//         .replace(/([0-9])([0-9]{2})$/, '$1.$2')
//         .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
//     });
//   }
// });

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

    //$(document).ready(function()
    //{
    /*<?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_usuario') == 2752 || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 AND $onlyView==0){?>
		console.log(<?php print_r($cliente[0]->nacionalidad ); ?>);*/



    //$.post("<?=base_url()?>index.php/Asesor/getNationality", function(data) {
    //var len = data.length;

    //for(var i = 0; i<len; i++){
    //var id = data[i]['id_opcion'];
    //var name = data[i]['nombre'];
    /*var nat = "<?php $cliente[0]->nacionalidad ?>";*/
    //var nat = "<?php ($cliente[0]->nacionalidad=="" || $cliente[0]->nacionalidad ==null) ? 0:  $cliente[0]->nacionalidad;?>";
    // }
    //$(".select-is-empty").removeClass("is-empty");
    //$("#nacionalidad").select('refresh');
    //}, 'json');


    /*$.post("<?=base_url()?>index.php/Asesor/getCivilStatus", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++){
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			var edoCivil =  "<?php ($cliente[0]->estado_civil=="" || $cliente[0]->estado_civil ==null) ? 0:  $cliente[0]->estado_civil;?>";

			if(edoCivil==id){
				$("#estado_civil").append($('<option selected=true>').val(id).text(name.toUpperCase()));
				$(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+name+'">');
			}
			else{
				$("#estado_civil").append($('<option>').val(id).text(name.toUpperCase()));
			}
		}
		$(".select-is-empty").removeClass("is-empty"); $("#estado_civil").select('refresh');
	}, 'json');*/


    //$.post("<?=base_url()?>index.php/Asesor/getMatrimonialRegime", function(data) {
    //var len = data.length;
    //for(var i = 0; i<len; i++){
    //var id = data[i]['id_opcion'];
    //var name = data[i]['nombre'];
    /*var reg = "<?php ($cliente[0]->regimen_matrimonial=="" || $cliente[0]->regimen_matrimonial ==null) ? 0:  $cliente[0]->regimen_matrimonial;?>";
				if(reg==id){
					$("#regimen_matrimonial").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					$('#regimen_nuevo').append($('<option selected=true>').val(id).text(name.toUpperCase()));
					$(".datos_select").append('<input type="hidden" name="regimen_select" id="regimen_select" value="'+name+'">');
				}
				else{
					$("#regimen_matrimonial").append($('<option>').val(id).text(name.toUpperCase()));
				}*/
    //}
    //$(".select-is-empty").removeClass("is-empty"); $("#regimen_matrimonial").select('refresh');
    //}, 'json');




    //$.post("<?=base_url()?>index.php/Asesor/getParentesco", function(data) {
    //var len = data.length;
    //for(var i = 0; i<len; i++){
    //var id = data[i]['id_opcion'];
    //var name = data[i]['nombre'];
    //var parent = "";

    /*if(parent==id){
        $("#parentesco2").append($('<option selected=true>').val(id).text(name.toUpperCase()));
        $("#parentesco1").append($('<option selected=true>').val(id).text(name.toUpperCase()));
        $(".datos_select").append('<input type="hidden" name="parentezco_select2" id="parentezco_select2" value="'+name+'">');

    }
    else{
        $("#parentesco2").append($('<option>').val(id).text(name.toUpperCase()));
        $("#parentesco1").append($('<option>').val(id).text(name.toUpperCase()));
    }*/
    //}
    //$(".select-is-empty").removeClass("is-empty"); $("#parentesco2").select('refresh');
    //}, 'json');



    /*
<?php } ?>
	});
*/

</script>
<!--script of the page-->
<?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_usuario') == 2752 || $this->session->userdata('id_usuario') == 2826 || $this->session->userdata('id_usuario') == 2810 || $this->session->userdata('id_usuario') == 5957 || $this->session->userdata('id_usuario') == 6390 || $this->session->userdata('id_usuario') == 4857 || $this->session->userdata('id_usuario') == 2834 AND $onlyView==0){?>
    <script>



        $(document).ready(function(){

            /*$.post("<?=base_url()?>index.php/Asesor/getNationality", function(data) {
					var len = data.length;

					for(var i = 0; i<len; i++){
						var id = data[i]['id_opcion'];
						var name = data[i]['nombre'];
						var nat = "<?php $cliente[0]->nacionalidad ?>";



						if(nat==id){
							$("#nacionalidad").append($('<option selected=true>').val(id).text(name.toUpperCase()));
							$(".datos_select").append('<input type="hidden" name="nac_select" id="nac_select" value="'+name+'">');
						}
						else{
							$("#nacionalidad").append($('<option>').val(id).text(name.toUpperCase()));
						}
					}
					$(".select-is-empty").removeClass("is-empty"); $("#nacionalidad").select('refresh');
				}, 'json');*/



            /*$.post(url + "Asesor/getCivilStatus", function(data) {
                var len = data.length;
                for(var i = 0; i<len; i++){
                    var id = data[i]['id_opcion'];
                    var name = data[i]['nombre'];
                    var nat = <?=$cliente[0]->estado_civil?>;

						if(nat==id){
							$("#estado_civil").append($('<option selected=true>').val(id).text(name.toUpperCase()));
							$(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+name+'">');
						}
						else{
							$("#estado_civil").append($('<option>').val(id).text(name.toUpperCase()));
						}
					}
					$(".select-is-empty").removeClass("is-empty"); $("#estado_civil").select('refresh');
				}, 'json');*/
        });






        $("#nacionalidad").change(function(){
            var valor_nacionalidad = $('select[name="nacionalidad"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="nac_select" id="nac_select" value="'+valor_nacionalidad+'">');
        });

        $("#estado_civil").change(function(){
            var valor_estado_civil = $('select[name="estado_civil"] option:selected').text();
            $(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+valor_estado_civil+'">');
        });

        // $("#regimenFiscal").change(function(){
        //     var valor_regimen_fiscal_civil = $('select[name="regimen_fiscal"] option:selected').text();
        //     $(".datos_select").append('<input type="hidden" name="regimen_select" id="regimen_select" value="'+valor_regimen_fiscal+'">');
        // });

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
        const campo4 = document.getElementById("regimenFiscal");
        const campo5 = document.getElementById("codigol");
        const campo6 = document.getElementById("cp_fac");
    
        checkbox.addEventListener("change", function() {

            if (checkbox.checked) {
                campo1.style.display = "block";
                campo2.style.display = "block";
                campo3.style.display = "block";
                campo4.style.display = "block";
                campo5.style.display = "block";
                campo6.style.display = "block";
            } else {
                campo1.style.display = "none";
                campo2.style.display = "none";
                campo3.style.display = "none";
                campo4.style.display = "none";
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

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;">  NOMBRE (<small style="color: red;">*</small>) </label> <input class="form-control" name="nombre_nuevo" id="nombre_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;">  APELLIDO PATERNO (<small style="color: red;">*</small>) </label> <input class="form-control" name="apellidop_nuevo" id="apellidop_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating"> <label class="control-label" style="font-size: 0.8em;"> APELLIDO MATERNO (<small style="color: red;">*</small>) </label> <input class="form-control" name="apellidom_nuevo" id="apellidom_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> EMAIL (<small style="color: red;">*</small>) </label> <input class="form-control" name="correo_nuevo" id="correo_nuevo" type="email" value="" style="font-size: 0.9em;"/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> TELEÉFONO CASA</label><input class="form-control" name="telefono1_nuevo" id="telefono1_nuevo" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="" style="font-size: 0.9em;"/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating"><label class="control-label" style="font-size: 0.8em;"> CELULAR (<small style="color: red;">*</small>)</label><input class="form-control" name="telefono2_nuevo" id="telefono2_nuevo" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="" style="font-size: 0.9em;"/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> FECHA NACIMIENTO (<small style="color: red;">*</small>)</label><input class="form-control" name="fnacimiento_nuevo" id="fnacimiento_nuevo" type="date" value="" style="font-size: 0.9em;"/></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> NACIONALIDAD (<small style="color: red;">*</small>)</label><select name="nacionalidad_nuevo" id="nacionalidad_nuevo" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> ORIGINARIO DE (<small style="color: red;">*</small>) </label> <input class="form-control" name="originario_nuevo" id="originario_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> DOMICILIO PARTICULAR (<small style="color: red;">*</small>) </label> <input class="form-control" name="domicilio_particular_nuevo" id="domicilio_particular_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> ESTADO CIVIL (<small style="color: red;">*</small>)</label><select name="estadocivil_nuevo" id="estadocivil_nuevo" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group label-floating select-is-empty"><label class="control-label" style="font-size: 0.8em;"> RÉGIMEN </label><select name="regimen_nuevo" id="regimen_nuevo" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select></div></div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> NOMBRE DE CÓNYUGE (<small style="color: red;">*</small>) </label> <input class="form-control" name="conyuge_nuevo" id="conyuge_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');


            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> OCUPACIÓN (<small style="color: red;">*</small>) </label> <input class="form-control" name="ocupacion_nuevo" id="ocupacion_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> PUESTO (<small style="color: red;">*</small>) </label> <input class="form-control" name="puesto_nuevo" id="puesto_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> EMPRESA EN LA QUE TRABAJA (<small style="color: red;">*</small>) </label> <input class="form-control" name="empresa_nuevo" id="empresa_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> ANTIGÜEDAD (<small style="color: red;">*</small>) </label> <input class="form-control" name="antiguedad_nuevo" id="antiguedad_nuevo" type="number" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> EDAD AL MOMENTO DE FIRMA (<small style="color: red;">*</small>) </label> <input class="form-control" name="edad_firma_nuevo" id="edad_firma_nuevo" type="number" required value="" style="font-size: 0.9em;"/> </div> </div>');

            $("#modal_agregar .modal-body").append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="form-group label-floating">  <label class="control-label" style="font-size: 0.8em;"> DOMICILIO EMPRESA (<small style="color: red;">*</small>) </label> <input class="form-control" name="domempresa_nuevo" id="domempresa_nuevo" type="text" required value="" style="font-size: 0.9em;"/> </div> </div>');

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
                // data.append("id_copropietario", id_valor_copropietario);
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








        function close_eliminar()
        {
            $("#modal_eliminar").modal('toggle');
        }


        function close_agregar()
        {
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


        $('#details_section').attr('open', '');
    });


</script>
</html>
