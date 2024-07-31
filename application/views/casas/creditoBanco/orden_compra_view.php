<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    #clienteConsulta .form-group {
        margin: 0px !important;
    }

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

    #checkDS .boxChecks .checkstyleDS input:checked+span {
        transition: 0.3s;
        font-weight: 400;
        color: #0a548b;
    }

    #checkDS .boxChecks .checkstyleDS input:checked+span:before {
        font-family: FontAwesome !important;
        content: "\f00c";
        color: #0a548b;
        font-size: 18px;
        margin-right: 5px;
    }
</style>
<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-money fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Paso 4 - Orden de compra firmada</h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>
                                
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>NOMBRE LOTE</th>
                                            <th>CONDOMINIO</th>
                                            <th>PROYECTO</th>
                                            <th>NOMBRE CLIENTE</th>
                                            <th>ASESOR</th>
                                            <th>GERENTE</th>
                                            <th>TIEMPO</th>
                                            <th>MOVIMIENTO</th>
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

        <div class="modal fade" id="modalRegreso" data-backdrop="static" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
                    <form id="rechazarForm" name="rechazarForm" method="post"> 
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                <h4>Seleccione el paso al que se quiere rechazar</h4>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label">Comentario (Opcional)</label>
                                <textarea class="text-modal" id="comentarioRechazo" name="comentarioRechazo" rows="3"></textarea>
                            </div>
                            <br>
                            <div id="opcionesRechazo">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
			                        <div class="" id="checkDS">
				                        <div class="container boxChecks p-0">
					                        <label class="m-0 checkstyleDS">
						                    <input type="checkbox" class="select-checkbox" id="paso3" name="paso3" value="3" onchange="seleccionOpcion(this)"/>
						                    <span class="w-100 d-flex justify-between">
							                <p class="m-0"><b>Paso 3 - Concentración de adeudos</b></p>
						                    </span>
					                        </label>
				                        </div>
			                        </div>
		                        </div>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 mb-2">
			                        <div class="" id="checkDS">
				                        <div class="container boxChecks p-0">
					                        <label class="m-0 checkstyleDS">
						                    <input type="checkbox" class="select-checkbox" id="paso2" name="paso2" value="2" onchange="seleccionOpcion(this)"/>
						                    <span class="w-100 d-flex justify-between">
							                <p class="m-0"><b>Paso 2 - Solicitud de adeudos</b></p>
						                    </span>
					                        </label>
				                        </div>
			                        </div>
		                        </div>                        
                            </div><br>
                        </div><br>
                        <div class="modal-footer"><br><br><br>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		

        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
        
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>

    <script src="<?= base_url() ?>dist/js/controllers/casas/creditoBanco/orden_compra_firma.js?=v1"></script>
</body>