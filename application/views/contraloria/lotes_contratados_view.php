<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
    
        <div class="wrapper">
            <?php $this->load->view('template/sidebar'); ?>
        
            <div class="modal fade" id="modalGeneral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title" style="text-align: center;">Prórroga</h4>
                        </div>
                    
                        <div class="modal-body" id="contenido">
                        </div>
                        </br>
                        <input type="hidden" id="idlote">
                        <input type="hidden" id="idCondominio">
                        <input type="hidden" id="idProyecto">
                        <input type="hidden" id="nombreLote">
                        </br>
                        <div class="modal-footer">
                            </br>
                            </br>
                            <button type="button" class="btn btn-danger btn-simple" onclick="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="acceptModalButton">Aceptar</button>
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
	    								<h3 class="card-title center-align">Lotes Apartados</h3>
	    							</div>
                                    <div class="material-datatables" id="box-loteCont">
                                        <div class="form-group">
                                            <table class="table-striped table-hover hide" id="loteCont" name="loteCont">
                                                <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>ID LOTE</th> 
                                                    <th>NOMBRE</th> 
                                                    <th>CLIENTE</th>
                                                    <th>DÍAS HÁBILES</th>
                                                    <th>PRÓRROGA</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/contraloria/lotesCont.js"></script>
</html>