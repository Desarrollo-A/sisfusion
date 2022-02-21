
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
        'estatus14' => 0,
        'estatus7' => 0,
        'reportes' => 0,
        'estatus9' => 1,
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
            <h4 class="modal-title">REPORTE ESTATUS 9 - Contrato recibido con firma de cliente (Contraloría)</h4>
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
							REGISTRO ESTATUS <b>9</b> <span style="font-size: 10px;">(Contrato recibido con firma de cliente (Contraloría))</span>
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

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_clientes_9" name="tabla_clientes_9">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">ESTATUS</th>
                                                <th style="font-size: .9em;">DETALLES</th>
                                                <th style="font-size: .9em;">COMENTARIO</th>
                                                <th style="font-size: .9em;">TOTAL NETO</th>
                                                <th style="font-size: .9em;">TOTAL VALIDADO</th>
                                                <th style="font-size: .9em;">FECHA</th>
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



	 $("#tabla_clientes_9").ready( function(){

    $('#tabla_clientes_9 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_valores_cliente_9.column(i).search() !== this.value ) {
                tabla_valores_cliente_9
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_valores_cliente_9 = $("#tabla_clientes_9").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": "<?=base_url()?>/static/spanishLoader.json" },
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
        return '<p style="font-size: .8em">'+d.primerNombre+" "+d.segundoNombre+" "+d.apellidoMaterno+" "+d.apellidoPaterno+'</p>';
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
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.noRecibo+'</p>';
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
    "url": url2 + "registroCliente/getregistrosClientes",
	"dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});


$('#tabla_clientes_9 tbody').on('click', 'td.details-control', function(){
    var tr = $(this).closest('tr');
    var row = tabla_valores_cliente_9.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
    else {
        var informacion_adicional = '<table class="table text-justify">'+
        '<tr>GERENTE(S) <b>'+row.data().primerNombre+' '+row.data().segundoNombre+row.data().apellidoPaterno+row.data().apellidoMaterno+'</b>'+
        '<td style="font-size: .8em"><strong>ASESOR(ES): </strong>'+row.data().idCliente+'</td>'+
        '<td style="font-size: .8em"><strong>CALLE: </strong>'+row.data().idCliente+'</td>'+
        '</tr>'+
        '</table>';

        row.child( informacion_adicional ).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    }
});



   $("#tabla_clientes_9 tbody").on("click", ".mas_opciones_8", function(){
    $("#modal_estatus_8 .modal-body").html("");
    $("#modal_estatus_8 .modal-body").append('<div class="row"><div class="col-lg-12 form-group"><input class="form-control" placeholder="Comentario"></div><div class="col-lg-12 form-group"><button class="btn btn-social btn-fill btn-success"> <i class="material-icons">done</i>ACEPTAR</button></div></div>');
    $("#modal_estatus_8").modal();
});



 

}); 

  $(window).resize(function(){
        tabla_valores_cliente_9.columns.adjust();
    });



 
</script>

