
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
  
<div class="wrapper ">
    
	<?php
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
        $this->load->view('template/sidebar', $datos);  
	?>
	<!--Contenido de la página-->

	<div class="content boxContent">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
                        <div class="card-header card-header-icon" data-background-color="gray">
                            <i class="material-icons">reorder</i>
                        </div>
						<div class="card-content">
							<h4 class="card-title"></h4>
							<div class="toolbar">
                                <h3 class="card-title center-align">Escrituración</h3>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Proyecto</label>
                                                <select name="proyecto" id="proyecto"
                                                        class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona un proyecto" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Condominio</label>
                                                <select id="condominio" name="condominio"
                                                        class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona un condominio" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Lote</label>
                                                <select id="lotes" name="lotes"
                                                        class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona un lote" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="formEscrituracion">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group label-floating is-focused">
                                                    <label class="control-label ">Nombre Completo</label>
                                                    <input id="nombre" name="nombre" class="form-control input-gral" type="text" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating is-focused">
                                                    <label class="control-label">Estatus del Lote</label>
                                                    <div class="radio_container w-100">
                                                        <input class="d-none d-none generate btn-check" type="radio" name="estatus" value = 8 id="estatusL" value="" autocomplete="off" disabled>
                                                        <label class="btn btn-secondary w-50" for = "estatusL">Liquidado</label>

                                                        <input class="d-none find-results btn-check" type="radio" name="estatus" value = 37 id="estatusSL" value="" autocomplete="off" disabled>
                                                        <label class="btn btn-secondary w-50" for = "estatusSL">Sin liquidar</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid d-none mt-3 mb-3" id="check" style="border: 1px solid #eaeaea; padding: 20px 30px; border-radius: 10px">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <ol class="list-none">
                                                        <h4 class="card-title">Documentos para Escrituración</h4>
                                                        <li><b>1)</b> Identificación Oficial Vigente</li>
                                                        <li><b>2)</b> RFC (Cédula o constancia de situación fiscal)</li>
                                                        <li><b>3)</b> Comprobante de domicilio actual luz, agua o telefonía fija(antigüedad menor a 2 meses)</li>
                                                        <li><b>4)</b> Acta de Nacimiento</li>
                                                        <li><b>5)</b> Acta de Matrimonio (en su caso). *</li>
                                                        <li><b>6)</b> CURP(formato actualizado)</li>
                                                        <li><b>7)</b> Formas de pago (todos los comprobantes de pago a mensualidades / estados de cuenta bancarios) **</li>
                                                        <li><b>8)</b> Boleta predial al corriente y comprobante de pago retroactivo (si aplica)</li>
                                                        <li><b>9)</b> Constancia no adeudo de mantenimiento (si aplica)</li>
                                                        <li><b>10)</b> Constancia no adeudo de agua (si aplica)</li>
                                                    </ol>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <!-- CAMPOS PARA LA CAPTURA DEL NOMBRE Y APELLIDOS POR SEPARADO -->
                                                        <div class="col-md-12 pl-0" id = "nom2_cli">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Nombre Completo</label>
                                                                <input id="nombre2" name="nombre2" class="form-control input-gral" type="text" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0" id = "ape1_cli">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Apellido Paterno</label>
                                                                <input id="ape1" name="ape1" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0" id = "ape2_cli">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Apellido Materno</label>
                                                                <input id="ape2" name="ape2" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <!--------------------------------------------------------------->
                                                        <div class="col-md-4 pl-0">
                                                            <div class="cont_ocu form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Ocupación</label>
                                                                <input id="ocupacion" name="ocupacion" class="form-control input-gral" type="text" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Lugar de Origen</label>
                                                                <input id="origen" name="origen" class="form-control input-gral" type="text" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused" id="EdoCiv">
                                                                <label class="control-label label-gral">Estado Civil</label>
                                                                <select id="ecivil" name="ecivil" class="selectpicker select-gral m-0" title="" data-size="7" required></select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused" id="RegCon">
                                                                <label class="control-label label-gral">Régimen Conyugal</label>
                                                                <select id="rconyugal" name="rconyugal" class="selectpicker select-gral m-0" title="" data-size="7" required></select>
                                                                <!--<input id="rconyugal" name="rconyugal" class="form-control input-gral" type="text" disabled>-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Correo Electrónico</label>
                                                                <input id="correo" name="correo" class="form-control input-gral" type="mail" placeholder="UserExample@dominioExample.com" pattern="^[a-zA-Z0-9.!#$%&’*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Domicilio Actual</label>
                                                                <input id="direccion" name="direccion" class="form-control input-gral" type="text" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Calle fiscal</label>
                                                                <input id="calleF" name="calleF" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Número exterior</label>
                                                                <input id="numExtF" name="numExtF" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Número interior</label>
                                                                <input id="numIntF" name="numIntF" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Colonia</label>
                                                                <input id="coloniaf" name="coloniaf" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Municipio</label>
                                                                <input id="municipiof" name="municipiof" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Estado</label>
                                                                <input id="estadof" name="estadof" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Código postal</label>
                                                                <input id="cpf" name="cpf" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">RFC *</label>
                                                                <input id="rfc" name="rfc" class="form-control input-gral" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Teléfono (casa)</label>
                                                                <input id="telefono" name="telefono" class="form-control input-gral" type="number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 pl-0">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Teléfono (cel)</label>
                                                                <input id="cel" name="cel" class="form-control input-gral" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input id="idCliente" name="idCliente" class="form-control input-gral d-none">
                                                <input id="idPostventa" name="idPostventa" class="form-control input-gral d-none">
                                                <input id="referencia" name="referencia" class="form-control input-gral d-none">
                                                <input id="empresa" name="empresa" class="form-control input-gral d-none">
                                                <input id="personalidad" name="personalidad" class="form-control input-gral d-none">
                                            </div>
                                            <div class="row d-flex align-center mt-3">
                                                <div class="col-md-5">
                                                    <a role="button" id="print" name="print">
                                                        <i class="material-icons">print</i>
                                                    </a>
                                                    <!-- <a role="button" id="email" name="email">
                                                        <i class="material-icons">email</i>
                                                    </a> -->
                                                </div>
                                                <div class="col-md-7 d-flex justify-end">
                                                    <div class="cont-button_apl w-50">
                                                        <button class="btn-gral-data find_doc" id="aportaciones" type="submit">
                                                        <i class="fas fa-spinner fa-spin" style="display: none"></i>
                                                        <span class="btn-text">Iniciar Proceso.</span>
                                                        </button>
                                                    </div>
                                                </div>
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
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script>userType = <?= $this->session->userdata('id_rol') ?>;</script>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/postventa/escrituracion.js"></script>

