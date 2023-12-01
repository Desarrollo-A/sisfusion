<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
    
        <div class="wrapper">
            <?php $this->load->view('template/sidebar'); ?>
            <!-- Modal general para cambios -->
            <div class="modal fade" id="modalGeneral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title">Titulo</h4>
                        </div>
                        
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 mb-1' id="contenidoTip">
                            <label class="control-label"><p> Tipo de liberación: (<span class="isRequired">*</span>)</p></label>
                            <select class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" id="selLib" data-live-search="true"></select>
                        </div>

                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 mb-1' id="contenidoMot">
                            <label class="control-label"><p> Motivo de liberación: (<span class="isRequired">*</span>)</p></label>
                            <select class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" id="motLib" data-live-search="true"></select>
                        </div> 
                        
                        <div class="modal-body" id="contenido">
                            
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="cambioPrecio">
                            <label class="control-label"> Actualizar precio: (<span class="isRequired">*</span>)</label>
                            <input class="form-control input-gral" placeholder="$" name="costoM2" id="costoM2" data-type="currency" step="any">
                            <input type="hidden" class="form-control input-gral" placeholder="$" name="cost" id="cost" data-type="currency" step="any">
                        </div>
                     
                        <input type="hidden" id="accion"> 
                        <input type="hidden" id="idlote">
                        <input type="hidden" id="idLiberacion">
                        <input type="hidden" id="idCondominio">
                        <input type="hidden" id="idProyecto">
                        <input type="hidden" id="nombreLote">
                        <input type="hidden" id="precio">
                        <input type="hidden" id="tipo_lote">
                        <input type="hidden" id="clausulas">
                        
                        <div class="modal-footer d-flex justify-end">
                            <button type="button" class="btn btn-danger btn-simple" onclick="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="acceptModalButton">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Bitácora de cambios</h4>
                        </div>
                        <div class="modal-body">                      
                            <div class="container-fluid" id="changelogTab">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="changelog">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content boxContent">
	    		<div class="container-fluid">
	    			<div class="row">
	    				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    					<div class="card">
	    						<div class="card-header card-header-icon" data-background-color="goldMaderas">
	    							<i class="fas fa-history fa-2x"></i>
	    						</div>
	    						<div class="card-content">
	    							<div class="encabezadoBox">
	    								<h3 id="nomT" class="card-title center-align">Historial de Liberaciones</h3>
	    							</div>
                                    <div class="material-datatables" id="box-historialLib">
                                        <div class="form-group">
                                            <table class="table-striped table-hover hide" id="historialLib" name="historialLib">
                                                <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>ID LOTE</th> 
                                                    <th>NOMBRE</th> 
                                                    <th>PRECIO M2</th>
                                                    <th>CLIENTE</th>
                                                    <th>FECHA DE MODIFICACIÓN</th>
                                                    <th>JUSIFICACIÓN</th>
                                                    <th>ESTATUS DE PROCESO</th>
                                                    <th>TIPO DE LIBERACIÓN</th>
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
	    	</div>
            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </body>
    <?php $this->load->view('template/footer'); ?>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/contraloria/historialLiberaciones.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/documentacion/documentacion.js?=1.1.2"></script>
</html>