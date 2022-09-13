<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
/*-------------------------------------------------------*/
    $datos = array();
	$datos = $datos4;
	$datos = $datos2;
	$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/

    ?>
    <!--Contenido de la página-->


    <div class="content boxContent ">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Envío contrato a RL </h3>
                                <p class="card-title pl-1">(estatus 10)</p>
                            </div>
                            
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 pb-5">
                                        <button class="btn-gral-data sendCont">Enviar contratos <i class="fas fa-paper-plane pl-1"></i></button>
                                    </div>
                                </div>
                            </div>


                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_envio_RL" name="tabla_envio_RL" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>TIPO VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>CÓDIGO</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- modal para rechazar estatus-->
                            <div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content" >
                                        <div class="modal-body">
                                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label>Ingresa los códigos de los contratos a enviar: </label>
                                                <textarea name="txt" id="contratos" onkeydown="saltoLinea(value);
														return true;" class="form-control" style="text-transform:uppercase;
														min-height: 400px;width: 100%"></textarea><br><br>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btn_show" class="btn btn-success"><span class="material-icons">send</span> </i> Enviar Contratos</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                            <br>
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


    <div class="content hide">
        <div class="container-fluid">
 
            <div class="row">

                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Envío contrato a RL (estatus 10)</h4>
                            <div class="material-datatables">
                                <div class="form-group">
									<div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
										<div class="modal-dialog modal-md">
											<div class="modal-content" >
												<div class="modal-body">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<label>Ingresa los códigos de los contratos a enviar: </label>
														<textarea name="txt" id="contratos" onkeydown="saltoLinea(value);
														return true;" class="form-control" style="text-transform:uppercase;
														min-height: 400px;width: 100%"></textarea><br><br>
													</div>
												</div>
												<div class="modal-footer">												
													<button type="button" id="btn_show" class="btn btn-success"><span class="material-icons">send</span> </i> Enviar Contratos</button>
					                            	<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
													<br>
												</div>
											</div>
										</div>
									</div>


                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button class="btn btn-primary sendCont">Enviar contratos <span class="material-icons">chevron_right</span></button>
                                        <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="tabla_envio_RL" name="tabla_envio_RL" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th></th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">CÓDIGO</th>
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
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

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
<script>


    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";

    $("#tabla_envio_RL").ready( function(){

    $('#tabla_envio_RL thead tr:eq(0) th').each( function (i) {

       if(i != 0){
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_corrida.column(i).search() !== this.value ) {
                tabla_corrida
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});


        tabla_corrida = $("#tabla_envio_RL").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Envío contrato a RL',
                    title:"Envío contrato a RL",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'TIPO VENTA';
                                        break;
                                    case 1:
                                        return 'PROYECTO'
                                    case 2:
                                        return 'CONDOMINIO';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'CÓDIGO';
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Envío contrato a RL',
                    title: "Envío contrato a RL",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'TIPO VENTA';
                                        break;
                                    case 1:
                                        return 'PROYECTO'
                                    case 2:
                                        return 'CONDOMINIO';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'CÓDIGO';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [
                {
                    "width": "10%",
                    "data": function (d) {
                        var lblStats;

                        if (d.tipo_venta == 1) {
                            lblStats = '<span class="label label-danger">Venta Particular</span>';
                        } else if (d.tipo_venta == 2) {
                            lblStats = '<span class="label label-success">Venta normal</span>';
                        } else if (d.tipo_venta == 3) {
                            lblStats = '<span class="label label-warning">Bono</span>';
                        } else if (d.tipo_venta == 4) {
                            lblStats = '<span class="label label-primary">Donación</span>';
                        } else if (d.tipo_venta == 5) {
                            lblStats = '<span class="label label-info">Intercambio</span>';
                        }

                        return lblStats;
                    }
                },
                {
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    "width": "25%",
                    "data": function (d) {
                        return '<p class="m-0">' + (d.nombreCondominio).toUpperCase();
                        +'</p>';

                    }
                },
                {
                    "width": "20%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';
                    }
                },
                {
                    "width": "20%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreCliente + '</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function (d) {
                        var numeroContrato;

                        if (d.vl == '1') {
                            numeroContrato = 'En proceso de Liberación';

                        } else {

                            if (d.numContrato == "" || d.numContrato == null) {
                                numeroContrato = "<p><i>Sin número de contrato</i></p>";
                            } else {
                                numeroContrato = d.numContrato;
                            }

                        }
                        return numeroContrato;
                    }
                },
            ],

            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },

            ],

            "ajax": {
                "url": url2 + "Contraloria/getrecepcionContratos",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            },
            "order": [[1, 'asc']]

        });
}); 

	var num=1;
	function saltoLinea(value) {
		if(value.length >= 13 * num) {
			document.getElementById('contratos').value=value;
			++num;
		}
	}






	$(document).on('click', '.sendCont', function () {
	$('#enviarContratos').modal();
    });
	$(document).ready(function(){
		$("#btn_show").click(function () {

			var validaCont = $('#contratos').val();


			if (validaCont.length <= 0) {

                alerts.showNotification('top', 'right', 'Ingresa los contratos.', 'danger')

            } else {

			$('#btn_show').prop('disabled', true);

     		var arr = $('#contratos').val().split('\n');

			var arr2= new Array();
			ini = 0;
			fin = 1;
			indice = 0;
			for( var i = 0; i < arr.length; i+=1) {
				arr2[indice++] = arr.slice(ini,fin);
				ini+=1;
				fin+=1;
			}

			/////////////////////////////////////////////////////////

			var descartaVacios2 = function(obj){
				return Object
					.keys(obj).map( el => obj[el] )
					.filter( el => el.length )
					.length;
			}



			var filtrado2 = arr.filter(descartaVacios2);


			function multiDimensionalUnique2(arr) {
				var uniques = [];
				var itemsFound = {};
				for(var i = 0, l = filtrado2.length; i < l; i++) {
					var stringified = JSON.stringify(filtrado2[i]);
					if(itemsFound[stringified]) { continue; }
					uniques.push(filtrado2[i]);
					itemsFound[stringified] = true;
				}
				return uniques;
			}



			var duplicadosEliminados2 = multiDimensionalUnique2(filtrado2);

			///////////////////ARREGLO IMPORTANTE ////////////////////////
			var descartaVacios = function(obj){
				return Object
					.keys(obj).map( el => obj[el] )
					.filter( el => el.length )
					.length;
			}



			var filtrado = arr2.filter(descartaVacios);

			function multiDimensionalUnique(arr) {
				var uniques = [];
				var itemsFound = {};
				for(var i = 0, l = filtrado.length; i < l; i++) {
					var stringified = JSON.stringify(filtrado[i]);
					if(itemsFound[stringified]) { continue; }
					uniques.push(filtrado[i]);
					itemsFound[stringified] = true;
				}
				return uniques;
			}


			var duplicadosEliminados = multiDimensionalUnique(filtrado);
			arrw = JSON.stringify(duplicadosEliminados);
			fLen = duplicadosEliminados2.length;
			text = "<ul>";
			for (i = 0; i < fLen; i++) {
				var hey = text += "<li>" + duplicadosEliminados2[i] + "</li>";
			}

			text += "</ul>";
			$.ajax({
				data:  "datos=" + arrw,
				url:   '<?=base_url()?>index.php/Contraloria/registro_lote_contraloria_proceceso10/',
				type:  'post',
			  success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Contratos enviado.", "success");
                } else if(response.message == 'VOID'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "No hay contratos por registrar.", "danger");
                } else if(response.message == 'ERROR'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                } else if(response.message == 'NODETECTED'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "No se encontro el número de contrato.", "danger");
                }
              },
              error: function( data ){
				$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }

			});

		  }

		});

	});


// jQuery(document).ready(function(){

	// jQuery('#enviarContratos').on('hidden.bs.modal', function (e) {
	// jQuery(this).removeData('bs.modal');    
	// jQuery(this).find('#contratos').val('');
	// })

// })



</script>

