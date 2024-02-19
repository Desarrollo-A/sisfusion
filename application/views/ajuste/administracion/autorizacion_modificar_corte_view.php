<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<style>
    .modal-backdrop{
        z-index:9;
    }
</style>
                <!-- estilo para los lotes de origen -->
            <style type="text/css">
                    * {
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            }

    
            #app-cover {
            display: table;
            width: 600px;
            margin: 800px auto;
            counter-reset: button-counter;
            }


            .toggle-button-cover {
            display: table-cell;
            position: relative;
            width: 10px;
            height: 110px;
            box-sizing: border-box;
            }

            .button-cover {
            height: 100px;
            margin: 200px;
            background-color: #fff;
            box-shadow: 0 50px 70px -8px #c5d6d6;
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

            .button {
            position: relative;
            top: 50%;
            width: 74px;
            height: 36px;
            margin: -20px auto 0 auto;
            overflow: hidden;
            }

            .button.r,
            .button.r .layer {
            border-radius: 100px;
            }

            .button.b2 {
            border-radius: 8px;
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

         
                            
       /* Button 3 */
            #button-3 .knobs:before {
            content: "";
            position: absolute;
            top: 4px;
            left: 4px;
            width: 20px;
            height: 10px;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            line-height: 1;
            padding: 9px 4px;
            background-color: #03a9f4;
            border-radius: 50%;
            transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
            }

            #button-3 .checkbox:active + .knobs:before {
            width: 46px;
            border-radius: 100px;
            }

            #button-3 .checkbox:checked:active + .knobs:before {
            margin-left: -26px;
            }

            #button-3 .checkbox:checked + .knobs:before {
            content: "";
            left: 42px;
            background-color: #f44336;
            }

            #button-3 .checkbox:checked ~ .layer {
            background-color: #fcebeb;
            }
     
        </style>
<!-- fin para los estilos de lote de origen -->



<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="content boxContent">
	
			    <div class="container-fluid">
				<div class="row">
					
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-content">
								<h3 class="card-title center-align">autorización fechas</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                            <div class="form-group autorizaciones" id="autorizaciones"></div>
                                            
                                            
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				</div>
		</div>
	
	</div>

	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/ajuste/administracion/autorizacion_modificar_corte.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
</body>