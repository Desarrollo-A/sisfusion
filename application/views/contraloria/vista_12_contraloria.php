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
                                <h3 class="card-title center-align">Contrato firmado </h3>
                                <p class="card-title pl-1">(estatus 12)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 pb-5">
                                        <button class="btn-gral-data sendCont">Enviar contratos<i class="fas fa-paper-plane pl-1"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_ingresar_12" name="tabla_ingresar_12"
                                           class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CÓDIGO</th>
                                                <th>CLIENTE</th>
                                                <th>TOTAL NETO</th>
                                                <th>TOTAL VALIDADO</th>

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
                                                <label>Ingresa los códigos de los contratos firmados: </label>
                                                <textarea name="txt" id="contratos" onkeydown="saltoLinea(value);
														return true;" class="form-control" style="text-transform:uppercase;
														min-height: 400px;width: 100%"></textarea><br><br>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                            <button type="button" id="btn_show" class="btn btn-primary">Enviar Contratos</button>
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

    $("#tabla_ingresar_12").ready( function(){

    $('#tabla_ingresar_12 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 1){
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_12.column(i).search() !== this.value ) {
                tabla_12
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});


        tabla_12 = $("#tabla_ingresar_12").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Contrato firmado (estatus10)',
                    title:"Contrato firmado (estatus10)",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'TIPO VENTA';
                                        break;
                                    case 2:
                                        return 'PROYECTO'
                                    case 3:
                                        return 'CONDOMINIO';
                                        break;
                                    case 4:
                                        return 'LOTE';
                                        break;
                                    case 5:
                                        return 'CÓDIGO';
                                        break;
                                    case 6:
                                        return 'CLIENTE';
                                        break;
                                    case 7:
                                        return 'TOTAL NETO';
                                        break;
                                    case 8:
                                        return 'TOTAL VALIDADO';
                                        break;

                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            columnDefs: [{
                ordering: false,
                className: '',
                targets: 0,
                searchable: false,
            }],
            width: 'auto',
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [
                {
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
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
                        } else {
                            lblStats = '<span class="label" style="background: #808B96">Sin especificar</span>';
                        }

                        return lblStats;
                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + (d.nombreCondominio).toUpperCase();
                        +'</p>';

                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';
                    }
                },
                {
                    "width": "10%",
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
                        return '<p class="m-0">' + numeroContrato + '</p>';
                    }
                },
                {
                    "width": "25%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function (d) {
                        var a = (d.totalNeto == null || d.totalNeto == .00) ? formatMoney(0) : formatMoney(d.totalNeto);
                        return '<p class="m-0">' + a + '</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function (d) {
                        var b = (d.totalValidado == null || d.totalValidado == .00) ? formatMoney(0) : formatMoney(d.totalValidado);
                        return '<p class="m-0">' + b + '</p>';
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
                "url": url2 + "Contraloria/registroStatus12ContratacionRepresentante",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            },
            "order": [[1, 'asc']]

        });


$('#tabla_ingresar_12 tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_12.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");

            } else {
				var status;
				var fechaVenc;
				if (row.data().idStatusContratacion == 10 && row.data().idMovimiento == 40 ||
					row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66 ||
					row.data().idStatusContratacion == 8 && row.data().idMovimiento == 67 ||
					row.data().idStatusContratacion == 11 && row.data().idMovimiento == 41) {
					status = 'Status 10 listo para firma de RL';
				}
				else
				{
					status='N/A';
				}

				if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
					row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
					fechaVenc = row.data().fechaVenc;
				}
				else
				{
					fechaVenc='N/A';
				}

				var informacion_adicional2 = '<table class="table text-justify">' +
				    '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
					'<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
					'<td style="font-size: .8em"><strong>STATUS: </strong>'+ status +'</td>' +
					'</tr>' +
					'</table>';
                var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '  <div class="row">';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '          <label><b>Información adicional</b></label>';
                informacion_adicional += '      </div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b> ' + status + '</label></div>';
                informacion_adicional += '  </div>';
                informacion_adicional += '</div>';

				row.child(informacion_adicional).show();
				tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");

            }
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
				url:   '<?=base_url()?>index.php/Contraloria/insertContratosFirmados/',
				type:  'post',
			  success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_ingresar_12').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Contratos enviado.", "success");
                } else if(response.message == 'VOID'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_ingresar_12').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "No hay contratos por registrar.", "danger");
                } else if(response.message == 'ERROR'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_ingresar_12').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                } else if(response.message == 'NODETECTED'){
					$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_ingresar_12').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "No se encontro el número de contrato.", "danger");
                }
              },
              error: function( data ){
				$('#btn_show').prop('disabled', false);
					$('#enviarContratos').modal('hide');
                    $('#tabla_ingresar_12').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }

			});

		  }

		});

	});


jQuery(document).ready(function(){

	jQuery('#enviarContratos').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#contratos').val('');
	})

})

function formatMoney(number) {
    return '$'+ number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


</script>
