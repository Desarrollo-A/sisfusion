<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<style>
    .modal-backdrop{
        z-index:9;
    }
</style>
	<!-- estilo para los lotes de origen -->
		<style type="text/css">
            .msj{
                z-index: 9999999;
            }
        </style>
<!-- fin para los estilos de lote de origen -->

<style>
/* Button 16 */

*{
  user-select: none;
  -webkit-tap-highlight-color: transparent;
}



#app-cover {
  display: table;
  width: 600px;
  margin: 80px auto;
  counter-reset: button-counter;
}

.row {
  display: table-row;
}

.toggle-button-cover {
  display: table-cell;
  position: relative;
  width: 200px;
  height: 140px;
  box-sizing: border-box;
}

.button-cover {
  height: 100px;
  margin: 20px;
  background-color: #fff;
  box-shadow: 0 10px 20px -8px #c5d6d6;
  border-radius: 4px;
}

.button-cover:before {
  counter-increment: button-counter;
  content: counter(button-counter);
  position: absolute;
  right: 0;
  bottom: 0;
  color: #d7e3e3;
  font-size: 12px;
  line-height: 1;
  padding: 5px;
}

.button-cover,
.knobs,
.layer {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}



.button.r,
.button.r .layer {
  border-radius: 100px;
}

.button.b2 {
  border-radius: 4px;
}

.checkbox {
  position: relative;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
  opacity: 0;
  cursor: pointer;
  z-index: 3;
}

.knobs {
  z-index: 2;
}

.layer {
  width: 100%;
  background-color: #ebf7fc;
  transition: 0.3s ease all;
  z-index: 1;
}
#button-16 .knobs:before {
  content: "YES";
  position: absolute;
  top: 4px;
  left: 4px;
  width: 20px;
  height: 10px;
  color: #fff;
  font-size: 7px;
  font-weight: bold;
  text-align: center;
  line-height: 1;
  padding: 9px 4px;
  background-color: #03a9f4;
  border-radius: 30%;
  transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
}

#button-16 .checkbox:active + .knobs:before {
  width: 100px;
}

#button-16 .checkbox:checked:active + .knobs:before {
  margin-left: -26px;
}

#button-16 .checkbox:checked + .knobs:before {
  content: "NO";
  left: 100px;
  background-color: #f44336;
}

#button-16 .checkbox:checked ~ .layer {
  background-color: #fcebeb;
}

</style>


<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="content boxContent">
		<div class="card">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="card">
							<div class="card-content">
								<h3 class="card-title center-align">Enviar evidencia</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
											<div class="col-md-12">
                                            	<div class="toggle-button-cover">
													<div class="button-cover">
                                                	    <div class="button b2" id="button-16"  >
                                                	        <input type="checkbox" class="checkbox" id="checkbox"  />
                                                	        <div class="knobs"></div>
                                                	    	<div class="layer"></div>
                                                	    </div>
													</div>
												</div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
													<button type="button" class="btn-gral-data" >
														<i class="fas fa-arrow-circle-up"></i>
														Enviar evidencia
													</button>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-0 col-sm-0 col-md-0 col-lg-12 p-0" id="preview-div">
                                       			</div>
                                        </div>
											
									
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="card">
							<div class="card-content">
								<h3 class="card-title center-align">Adelantos</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                     
										
                                        <form method="post" id="formularioAdelantoNomina">
                                            <div class="form-group">

                                                <div class="col-md-5">
                                                    <label class="control-label">Monto </label>
                                                    <input class="form-control input-gral" id="montoSolicitado" type="number"  min="1" name="montoSolicitado"  required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label">Pago</label>
                                                    <input class="form-control input-gral" id="pa" type="text"   name="pagoDescuento"  required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label">Pago</label>
                                                    <input class="form-control input-gral" id="pagoDescuento23" type="text"  min="1" name="pagoDescuento"  required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Pago</label>
                                                    <input class="form-control input-gral" id="pagoDescuento34" type="text"  min="1" name="pagoDescuento"  required>
                                                </div>
										
												<div class="col-md-6">
												<label class="control-label"></label>
													<div class="input-group">
														
														<label class="input-group-btn"></label>
														<span class="btn btn-info btn-file">
															<i class="fa fa-upload"></i> Subir archivo
															<input id="file_adelanto" name="file_adelanto" required accept="application/pdf" type="file"/>
														</span>
														<p id="archivo-extranjero"></p>
													</div>
												</div>
                                        </form>
										</div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6">
						
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="card">
							<div class="card-content">
							<div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla-anticipo" name="tabla-anticipo">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
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
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>

	
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo_pago.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
</body>