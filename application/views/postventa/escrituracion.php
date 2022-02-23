
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
                        <div class="card-header card-header-icon" data-background-color="gray"
                             style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                            <i class="material-icons">reorder</i>
                        </div>
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
                                <h3 class="card-title center-align">Documentación por lote</h3>
                                <div class="container-fluid" style="padding: 20px 0px;">
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

                                <div class="col-md-12">
                                    <div class="form-group label-floating is-focused">
                                        <label class="control-label ">Nombre Completo</label>
                                        <input id="nombre" name="nombre" class="form-control input-gral" type="text" disabled>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <b>Estatus del lote:</b>
                                        <br>
                                        <label class="">liquidado</label>
                                        <input id="estatus" name="estatus" value="1" type="checkbox" disabled>
                                        <label class="">Sin liquidar</label>
                                        <input id="estatus" name="estatus" value="2" type="checkbox" disabled>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" id="check" style="display: none;">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    Checklist
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="material-icons">expand_more</i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="col-md-5">
                                                        <ol class="list-none">
                                                            <li>1) Identificación oficial vigente</li>
                                                            <li>2) RFC (Cédula o constancia de situación fiscal)</li>
                                                            <li>3) Comprobante de domicilio actual luz, agua o telefonia fija(antiguedad menor a 2 meses)</li>
                                                            <li>4) Acta de nacimiento</li>
                                                            <li>5) Acta de matrimonio (en su caso). *</li>
                                                            <li>6) CURP(formato actualizado)</li>
                                                            <li>7) Formas de pago (todos los comprobantes de pago a mensialidades / estados de cuenta bancarios) **</li>
                                                            <li>8) Boleta predial al corriente y comprobante de pago retroactivo (si aplica)</li>
                                                            <li>9) Constancia no adeudo mantenimiento (si aplica)</li>
                                                            <li>10) Constancia no adeudo de agua (si aplica)</li>
                                                        </ol>
                                                    </div>
                                                    <input id="idCliente" name="idCliente" class="form-control input-gral" type="hidden">

                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Nombre Completo</label>
                                                                <input id="nombre2" name="nombre2" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Ocupación</label>
                                                                <input id="ocupacion" name="ocupacion" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Lugar de origen</label>
                                                                <input id="origen" name="origen" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Estado civil</label>
                                                                <input id="ecivil" name="ecivil" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Régimen conyugal</label>
                                                                <input id="rconyugal" name="rconyugal" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Correo electronico</label>
                                                                <input id="correo" name="correo" class="form-control input-gral" type="mail">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Domicilio fiscal</label>
                                                                <input id="direccionf" name="direccionf" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Domicilio actual</label>
                                                                <input id="direccion" name="direccion" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">RFC</label>
                                                                <input id="rfc" name="rfc" class="form-control input-gral" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Teléfono (casa)</label>
                                                                <input id="telefono" name="telefono" class="form-control input-gral" type="number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating is-focused">
                                                                <label class="control-label label-gral">Teléfono (cel)</label>
                                                                <input id="cel" name="cel" class="form-control input-gral" type="number">
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <a role="button" id="print" name="print"><i class="material-icons">print</i></a>
                                                                    <a role="button" id="email" name="email"><i class="material-icons">email</i></a>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <!-- <button type="submit" id="aportaciones" class="btn-gral-data find_doc">Solicitar aportaciones</button> -->
                                                                    <button class="btn-gral-data find_doc" id="aportaciones" type="submit">
                                                                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                                                    <span class="btn-text">Solicitar aportaciones</span>
                                                                    </button>
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

