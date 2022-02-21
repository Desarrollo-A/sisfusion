
<body class="">
<div class="wrapper ">
    <?php
$dato= array(
        'home' => 0,
        'listaCliente' => 0,
        'expediente' => 0,
        'corrida' => 0,
        'documentacion' => 0,
        'historialpagos' => 0,
        'inventario' => 0,
        'estatus20' => 0,
        'estatus2' => 0,
        'estatus5' => 0,
        'estatus6' => 0,
        'estatus9' => 0,
        'estatus10' => 0,
        'estatus13' => 0,
        'estatus15' => 0,
        'enviosRL' => 0,
        'estatus12' => 1,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 0,
        'comnuevas' => 0,
        'comhistorial' => 0,
		'integracionExpediente' => 0,
		'expRevisados' => 0,
		'estatus10Report' => 0,
		'rechazoJuridico' => 0
    );
    //$this->load->view('template/contraloria/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
    ?>
    <!--Contenido de la página-->

    <style type="text/css">
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: white;
 opacity: 0.4;

  ::-moz-placeholder { /* Firefox 19+ */
  color: white;
  opacity: 0.4;
}
:-ms-input-placeholder { /* IE 10+ */
  color: white;
  opacity: 0.4;
}
:-moz-placeholder { /* Firefox 18- */
  color: white;
  opacity: 0.4;
}

}
    </style>




<div class="content">
        <div class="container-fluid">
 
            <div class="row">

                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Contrato firmado (estatus 12)</h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
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
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_12" name="tabla_ingresar_12" style="text-align:center;"> 
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CÓDIGO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">TOTAL NETO</th>
                                                <th style="font-size: .9em;">TOTAL VALIDADO</th>

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

    $("#tabla_ingresar_12").ready( function(){

    $('#tabla_ingresar_12 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
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
	  dom: 'frtip',
      width: 'auto',
"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"columns": [
	{
    "width": "3%",
    "className": 'details-control',
    "orderable": false,
    "data" : null,
    "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
"data": function( d ){
	var lblStats;

		if(d.tipo_venta==1) {
			lblStats ='<span class="label label-danger">Venta Particular</span>';
		}
		else if(d.tipo_venta==2) {
			lblStats ='<span class="label label-success">Venta normal</span>';
		}
		else if(d.tipo_venta==3) {
			lblStats ='<span class="label label-warning">Bono</span>';
		}
		else if(d.tipo_venta==4) {
			lblStats ='<span class="label label-primary">Donación</span>';
		}
		else if(d.tipo_venta==5) {
			lblStats ='<span class="label label-info">Intercambio</span>';
		}

	return lblStats;
}
},
{
	"width": "8%",
	"data": function( d ){
		return '<p style="font-size: .8em">' + d.nombreResidencial + '</p>';
	}
},
{
    "width": "10%",
    "data": function( d ){
		return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';

    }
},
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
    }
}, 
{
    "width": "10%",
    "data": function( d ){
    	var numeroContrato;

    	if(d.numContrato =="" || d.numContrato==null)
		{
			numeroContrato="<p><i>Sin número de contrato</i></p>";
		}
    	else
		{
			numeroContrato = d.numContrato;
		}
		return '<p style="font-size: .8em">'+numeroContrato+'</p>';
    }
}, 
{
	"width": "25%",
	"data": function( d ){
		return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
	}
}, 
{
	"width": "15%",
	"data": function( d ){
		return '<p style="font-size: .8em">' + formatMoney(d.totalNeto) + '</p>';
	}
},
{
	"width": "15%",
	"data": function( d ){
		return '<p style="font-size: .8em">' + formatMoney(d.totalValidado) + '</p>';
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
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});


$('#tabla_ingresar_12 tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_12.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
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

				var informacion_adicional = '<table class="table text-justify">' +
				    '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
					'<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
					'<td style="font-size: .8em"><strong>STATUS: </strong>'+ status +'</td>' +
					'</tr>' +
					'</table>';

				row.child(informacion_adicional).show();
				tr.addClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
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
