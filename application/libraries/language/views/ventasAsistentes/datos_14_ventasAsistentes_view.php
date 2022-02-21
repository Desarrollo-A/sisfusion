
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
        'estatus8' => 0,
        'estatus14' => 1,
        'estatus7' => 0,
        'reportes' => 0,
        'estatus9' => 0,
        'disponibles' => 0,
        'asesores' => 0,
        'nuevasComisiones' => 0,
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
            <h4 class="modal-title">REGISTRAR ESTATUS 14 - Firma acuse cliente (Asistentes Gerentes)</h4>
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
						<div class="card-header card-header-icon" data-background-color="blue">
							REGISTRO ESTATUS <b>14</b> <span style="font-size: 10px;">(El cliente firma el acuse)</span>
 						</div>
						<div class="card-content">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables"> 

								<div class="form-group">
									<div class="table-responsive">
									<!-- 	 Registro de todos los clientes con y sin expediente.  -->

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_clientes_14" name="tabla_clientes_14">
                                        <thead>
                                            <tr>
                                                <th></th>
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



	 $("#tabla_clientes_14").ready( function(){

    $('#tabla_clientes_14 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_valores_cliente_14.column(i).search() !== this.value ) {
                tabla_valores_cliente_14
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_valores_cliente_14 = $("#tabla_clientes_14").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
"processing": true,
"pageLength": 10,
"bAutoWidth": false,
"bLengthChange": false,
"scrollX": true,
"bInfo": false,
"searching": true,
"ordering": false,
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
        return '<p style="font-size: .8em">'+d.noRecibo+'</p>';
    }
}, 


{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.tipo+'</p>';
    }
}, 

{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.fechaApartado+'</p>';
    }
},
 
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.fechaEnganche+'</p>';
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

columnDefs: [
{
 "searchable": false,
 "orderable": false,
 "targets": 0
},
 
],

"ajax": {
    "url": url2 + "registroLote/getStatCont14",/*registroCliente/getregistrosClientes*/
	"dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 

 $('#tabla_clientes_14 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_valores_cliente_14.row( tr );

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
});



   $("#tabla_clientes_14 tbody").on("click", ".mas_opciones_8", function(){

    // var tr = $(this).closest('tr');
    // var row = tabla_valores_cliente_14.row( tr );
    // row_transferencia = $(this).closest('tr');


    // idautopago = $(this).val();<button class="btn btn-social btn-fill btn-pinterest"> <i class="material-icons">reply</i> Elite (2)</button>

    $("#modal_estatus_8 .modal-body").html("");
    // $("#modal_estatus_8 .modal-body").append('<div class="row"><div class="col-lg-12"><p><b>Cantidad:</b> $'+formatMoney(row.().cantidad)+'</p></div></div>');
    $("#modal_estatus_8 .modal-body").append('<div class="row"><div class="col-lg-12 form-group"><input class="form-control" placeholder="Comentario"></div><div class="col-lg-12 form-group"><button class="btn btn-social btn-fill btn-success"> <i class="material-icons">done</i>ACEPTAR</button></div></div>');

    //  
    $("#modal_estatus_8").modal();
});



 

}); 

  $(window).resize(function(){
        tabla_valores_cliente_14.columns.adjust();
    });



    function formatMoney( n ) {
      var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
 


</script>

