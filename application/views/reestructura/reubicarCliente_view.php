<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <style>
        #checkDS .boxChecks {
  background-color: #eeeeee;
  width: 100%;
  border-radius: 27px;
  box-shadow: none;
  padding: 5px !important;
}
#checkDS .boxChecks .checkstyleDS {
  cursor: pointer;
  user-select: none;
  display: block;
}
#checkDS .boxChecks .checkstyleDS span {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 31px;
  border-radius: 9999px;
  overflow: hidden;
  transition: linear 0.3s;
  margin: 0;
  font-weight: 100;
}
#checkDS .boxChecks .checkstyleDS span:nth-child(2) {
  margin: 0 3px;
}
#checkDS .boxChecks .checkstyleDS span:hover {
  box-shadow: none;
}
#checkDS .boxChecks .checkstyleDS input {
  pointer-events: none;
  display: none;
}
#checkDS .boxChecks .checkstyleDS input:checked + span {
  transition: 0.3s;
  font-weight: 400;
  color: #0a548b;
}
#checkDS .boxChecks .checkstyleDS input:checked + span:before {
  font-family: FontAwesome !important;
  content: "\f00c";
  color: #0a548b;
  font-size: 18px;
  margin-right: 5px;
}
    </style>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="archivosReestructura" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5>Selecciona los archivos para asociarlos al lote </h5>
                        <b><h5 id="mainLabelText" class="bold"></h5></b><hr>
                        <div id="formularioArchivos"></div>
                    </div>
                    <div class="modal-footer mt-2">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="clienteConsulta" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" > 
					<div class="modal-header">
						<h4 class="modal-title text-center">Corrobora la información del cliente</h4>
					</div>	
					<div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">NOMBRE (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="nombreCli" id="nombreCli" type="text" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">APELLIDO PATERNO (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="apellidopCli" id="apellidopCli" type="text" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">APELLIDO MATERNO (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="apellidomCli" id="apellidomCli" type="text" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">TELEFONO (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="telefonoCli" id="telefonoCli" type="number" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">CORREO (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="correoCli" id="correoCli" type="text" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">DOMICILIO (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="domicilioCli" id="domicilioCli" type="text" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                                <label class="control-label">ESTADO CIVIL (<small style="color: red;">*</small>)</label>
                                <select name="estadoCli" title="SELECCIONA UNA OPCIÓN" id="estadoCli" class="selectpicker m-0 select-gral" data-container="body" data-width="100%" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m-0">
                                <label class="control-label">INE (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="ineCLi" id="ineCLi" type="text" required/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 m.0">
                                <label class="control-label">OCUPACIÓN (<small style="color: red;">*</small>)</label>
                                <input class="form-control input-gral" name="ocupacionCli" id="ocupacionCli" type="text" required/>
                            </div>
                        </div>        
                        <input type="hidden" name="idCliente" id="idCliente">
                        <input type="hidden" name="idLote" id="idLote">
					</div>
					<div class="modal-footer">
						<button type="button" id="cancelarValidacion" class="btn btn-danger btn-simple cancelarValidacion" data-dismiss="modal">Cancelar</button>
						<button type="button" id="guardarCliente" name="guardarCliente" class="btn btn-primary guardarValidacion">GUARDAR</button>
					</div>
				</div>
			</div>
		</div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reubicación de clientes existentes</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="reubicacionClientes" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>SUPERFICIE</th>
                                                <th>COSTO M2 FINAL</th>
                                                <th>TOTAL</th>
                                                <th>ESTATUS</th>
                                                <th>ASIGNADO A</th>
                                                <th>ACCIONES</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<!--<script src="--><?//=base_url()?><!--dist/js/core/modal-general.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/reubicacionClientes.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/subirArchivosReestructura.js"></script>