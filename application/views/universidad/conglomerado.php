<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body class="">
    <div class="wrapper">
    <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }
            #modal_vc{
                z-index: 1041!important;
            }
            .fechaIncial, #fechaIncial{
                background-color: #eaeaea !important;
                border-radius: 27px 27px 27px  27px!important;
                background-image: initial!important;
                text-align: center!important;
            }
                
            .endDate, #endDate{
                background-color: #eaeaea !important;
                border-radius: 0!important;
                background-image: initial!important;
                text-align: center!important;
            }
            .btn-fab-mini {
                border-radius: 0 27px 27px 0 !important;
                background-color: #eaeaea !important;
                box-shadow: none !important;
                height: 45px !important;
            }
            .btn-fab-mini span {
                color: #929292;
            }
        </style>

    <style>
		.bkIcon{
			background-repeat: no-repeat;
			background-size: auto 70%;
			background-position-x: 100%;
			background-position-y: bottom;
		}
		.iconUno{
			background-image: url(../dist/img/iconos_comisiones/prestamos/total_dinero.png);
		}

		.iconDos{
			background-image: url(../dist/img/iconos_comisiones/prestamos/cajero.png);
		}
        .iconCuatro{
			background-image: url(../dist/img/iconos_comisiones/prestamos/billetera.png);
		}
		.iconTres{
			background-image: url(../dist/img/iconos_comisiones/prestamos/calculadora.png);
		}
		</style>


        <?php $this->load->view('template/sidebar'); ?>
        <?php $this->load->view('universidad/complementos_universidad/modales_universidad'); ?>

 
        
    <div class="content boxContent">
    <?php $this->load->view('universidad/conglomerado_cards_view'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h2 class="card-title center-align"><p>Descuentos Universidad</p></h2>
                            </div>
                            <div class="toolbar">
                                <div class="container-fluid">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                        <div class="form-group is-empty">
                                            <label for="proyecto">Tipo descuento:</label>
                                            <select name="tipo_descuento" id="tipo_descuento" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona el tipo de descuento" data-size="7" required onChange="checkTypeOfDesc()">
                                                <option value="1" selected>Activos</option>
                                                <option value="3">Liquidados</option>
                                                <option value="2">Baja</option>
                                                <option value="5">Detenidos</option>
                                                <option value="4">Conglomerado</option>
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla-general" name="tabla-general">
                                        <thead>
                                            <tr>
                                                <th>ID DESCUENTO</th>
                                                <th>ID USUARIO</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
                                                <th>SALDO COMISIONES</th>
                                                <th>TOTAL</th>
                                                <th>DESCONTADO</th>
                                                <th>PAGADO CAJA</th>
                                                <th>PENDIENTE</th>
                                                <th>MONTO POR MES</th>
                                                <th>ESTATUS</th>
                                                <th>DESCUENTO DISPONIBLE</th>
                                                <th>FECHA PRIMERA DESCUENTO</th>
                                                <th>FECHA DE CREACIÓN</th>
                                                <th>ESTATUS CERTIFICACIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <!-- <script src="http://momentjs.com/downloads/moment.min.js"></script> -->
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/universidad/conglomerado.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
		var fechaServer = '<?php echo date('Y-m-d H:i:s')?>';

		$(".scrollCharts").scroll(function() {
			var scrollDiv = $(".scrollCharts").scrollLeft();

			if (scrollDiv > 0){
				$(".gradientLeft").removeClass("d-none");
				$(".gradientLeft").addClass("fading");
			}
			else{
				$(".gradientLeft").addClass("d-none");
			}
		});
	</script>
	
</body>


