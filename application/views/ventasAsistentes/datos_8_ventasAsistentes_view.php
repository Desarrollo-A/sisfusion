
<body class="">
<div class="wrapper ">
	<?php
    $dato= array(
        'home' => 0,
        'listaCliente' => 0,
        'corridaF' => 0,
        'documentacion' => 0,
        'autorizacion' => 0,
        'contrato' => 0,
        'inventario' => 0,
        'estatus8' => 1,
        'estatus14' => 0,
        'estatus7' => 0,
        'reportes' => 0,
        'estatus9' => 0,
        'disponibles' => 0,
        'asesores' => 0,
        'asignarVentas' => 0,
        'nuevasComisiones' => 0,
        'altaUsuarios' => 0,
        'listaUsuarios' => 0,
        'histComisiones' => 0,
        'prospectos' => 0,
        'prospectosAlta' => 0

    );
	$this->load->view('template/ventas/sidebar', $dato);
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

    <div class="modal fade modal-alertas" id="modal_estatus_8" role="dialog">
    <div class="modal-dialog">
       <div class="modal-content">
        <div class="modal-header bg-red"  >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">SELECCIONA ESTATUS</h4>
        </div>  
        <form method="post" id="form_interes">
            <div class="modal-body"></div>
        </form>
    </div>
</div>
</div>



	<div class="content">
		<div class="container-fluid">
 
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
 						</div>
						<div class="card-content">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
								<b>REGISTRO ESTATUS 8</b> (Contrato entregado al asesor para firma del cliente)
							</div>
							<div class="material-datatables"> 

								<div class="form-group">
									<div class="table-responsive">
									<!-- 	 Registro de todos los clientes con y sin expediente.  -->

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_clientes_8" name="tabla_clientes_8">
                                        <thead>
                                            <tr>
												<!--<th></th>-->
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">ESTATUS</th>
                                                <th style="font-size: .9em;">COMENTARIO</th>
                                                <th style="font-size: .9em;">FECHA VENCIMIENTO</th>
                                                <th style="font-size: .9em;">FECHA REALIZADO</th>
                                                <th style="font-size: .9em;">ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>

 
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- modal -->
					<div class="modal fade" id="contraloriaSend">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<!-- Modal body -->
								<div class="modal-body">
									<a style="position: absolute;top:3%;right:3%; cursor:pointer;" data-dismiss="modal">
										<span class="material-icons">
											close
										</span>
									</a>
									<div id="cnt-contraloria-modal">
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



	 $("#tabla_clientes_8").ready( function(){

    $('#tabla_clientes_8 thead tr:eq(0) th').each( function (i) {

       if(i != 10 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_valores_cliente_8.column(i).search() !== this.value ) {
                tabla_valores_cliente_8
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_valores_cliente_8 = $("#tabla_clientes_8").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": "<?=base_url()?>/static/spanishLoader.json" },
"processing": true,
"pageLength": 10,
"bAutoWidth": false,
"bLengthChange": false,
"scrollX": true,
"bInfo": true,
"searching": true,
"ordering": false,
"fixedColumns": true,
"ordering": false,

"columns": [
// {
// 	  "width": "3%",
// 	  "className": 'details-control',
// 	"orderable": false,
// 	"data" : null,
// 	"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
// },
 
{
    "width": "8%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},
{
    "width": "8%",
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
    "width": "14%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_materno+" "+d.apellido_paterno+'</p>';
    }
}, 
 
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.status+'</p>';
    }
}, 


{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.comentario+'</p>';
    }
}, 

{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.fechaVenc+'</p>';
    }
},
 
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.modificado+'</p>';
    }
},


{ 
    "width": "6%",
    "orderable": false,
    "data": function( data ){

        opciones = '<div class="btn-group" role="group">';
        opciones += '<button class="btn btn-just-icon btn-round btn-info mas_opciones_8"><i class="material-icons">add_circle</i></button>';
        return opciones + '</div>';
} 
}



],

columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
"ajax": {
    "url": url2 + "registroLote/getStatus8ContratacionAsistentes",/*registroCliente/getregistrosClientes*/
	"dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 
/*
 $('#tabla_clientes_8 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_valores_cliente_8.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
    else {

        var informacion_adicional = '<table class="table text-justify">'+
			'<tr>INFORMACIÓN: <b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b>'+
			'<td style="font-size: .8em"><strong>CORREO: </strong>'+myFunctions.validateEmptyField(row.data().correo)+'</td>'+
			'<td style="font-size: .8em"><strong>TELEFONO: </strong>'+myFunctions.validateEmptyField(row.data().telefono1)+'</td>'+
			'<td style="font-size: .8em"><strong>RFC: </strong>'+myFunctions.validateEmptyField(row.data().rfc)+'</td>'+
			'<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</td>'+
			'</tr>'+
			'<tr>'+
			'<td style="font-size: .8em"><b>CALLE:</b> '+myFunctions.validateEmptyField(row.data().calle)+'</td>'+
			'<td style="font-size: .8em"><b>COLONIA:</b> '+myFunctions.validateEmptyField(row.data().colonia)+'</td>'+
			'<td style="font-size: .8em"><b>MUNICIPIO:</b> '+myFunctions.validateEmptyField(row.data().municipio)+'</td>'+
			'<td style="font-size: .8em"><b>ESTADO:</b> '+myFunctions.validateEmptyField(row.data().estado)+'</td>'+
			'<td style="font-size: .8em"><b>ENTERADO:</b> '+myFunctions.validateEmptyField(row.data().enterado)+'</td>'+
			'</tr>'+
			'<tr>'+
			'<td style="font-size: .8em"><b>REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().referencia1)+'</td>'+
			'<td style="font-size: .8em"><b>TEL. REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().telreferencia1)+'</td>'+
			'<td style="font-size: .8em"><b>REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().referencia2)+'</td>'+
			'<td style="font-size: .8em"><b>TEL. REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().telreferencia2)+'</td>'+
			'<td style="font-size: .8em"><b>PRIMER CONTACTO:</b> '+myFunctions.validateEmptyField(row.data().primerContacto)+'</td>'+
			'</tr>'+
			'<tr>'+
			'<td style="font-size: .8em"><b>GERENTE :</b> '+myFunctions.validateEmptyField(row.data().gerente)+'</td>'+
			'<td style="font-size: .8em"><b>ASESOR I:</b> '+myFunctions.validateEmptyField(row.data().asesor)+'</td>'+
			'<td style="font-size: .8em"><b>ASESOR II:</b> '+myFunctions.validateEmptyField(row.data().asesor2)+'</td>'+
			'<td style="font-size: .8em"></td>'+
			'</tr>' +
        '</table>';

        row.child( informacion_adicional ).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    }
});*/



   $("#tabla_clientes_8 tbody").on("click", ".mas_opciones_8", function(){

    // var tr = $(this).closest('tr');
    // var row = tabla_valores_cliente_8.row( tr );
    // row_transferencia = $(this).closest('tr');


    // idautopago = $(this).val();

	   var tr = $(this).closest('tr');
	   var row = tabla_valores_cliente_8.row( tr );
    $("#modal_estatus_8 .modal-body").html("");
    // $("#modal_estatus_8 .modal-body").append('<div class="row"><div class="col-lg-12"><p><b>Cantidad:</b> $'+formatMoney(row.().cantidad)+'</p></div></div>');
    $("#modal_estatus_8 .modal-body").append('' +
		'<div class="row">' +
		'	<div class="col-lg-4 form-group">' +
		'		<a class="btn btn-social btn-fill btn-success cnt-contraloria" style="background: green" data-lote="'+ row.data().idLote  +'"> ' +
		'			<i class="material-icons">chevron_right</i> Contraloria (9)</a>' +
		'	</div>' +
		'	<div class="col-lg-4 form-group">' +
		'		<button class="btn btn-social btn-fill btn-google" data-lote="'+ row.data().idLote  +'"> ' +
		'		<i class="material-icons">reply</i> Juridico (7)</button>' +
			'</div>' +
		'	<div class="col-lg-4 form-group">' +
		'		<button class="btn btn-social btn-fill btn-pinterest" data-lote="'+ row.data().idLote  +'"> ' +
		'		<i class="material-icons">reply</i> Elite (2)</button>' +
		'	</div>' +
		'</div>');
    //  
    $("#modal_estatus_8").modal();
});


   $(".cnt-contraloria").on('click', function () {
	   console.log('se deberá abrir el modal de contraloria');
	   $('#contraloriaSend').modal();
   });


 

}); 

  $(window).resize(function(){
        tabla_valores_cliente_8.columns.adjust();
    });



 


</script>

