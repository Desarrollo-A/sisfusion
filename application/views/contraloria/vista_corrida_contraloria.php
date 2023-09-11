
<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>
 
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

    <div class="modal fade modal-alertas" id="modal_ingresar_corrida" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subir archivo de corrida financiera.</h4>
                </div>
				<form method="post" id="form_corrida_add" enctype="multipart/form-data">
                    <div class="modal-body" style="text-align: center">
						<input type="hidden" name="idCliente" id="idCliente" value="" />
						<input type="hidden" name="idClienteHistorial" id="idClienteHistorial" value="" />
						<input type="hidden" name="idLoteHistorial" id="idLoteHistorial" value="" />
						<input type="hidden" name="idUser" id="idUser" value="<?= $this->session->userdata('id_usuario');?>" />
						<input type="hidden" name="idCondominio" id="idCondominio" value="" />

						<input type="hidden" name="nombreResidencial" id="nombreResidencial" value="" />
						<input type="hidden" name="nombreCondominio" id="nombreCondominio" value="" />
						<input type="hidden" name="nombreLote" id="nombreLote" value="" />

						<legend>Selecciona tu archivo:</legend>
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail">
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail"></div>
							<div>
								<span class="btn btn-primary btn-round btn-file">
									<span class="fileinput-new">Selecciona archivo</span>
									<span class="fileinput-exists">Cambiar</span>
									<input type="file" name="expediente"/>
								</span>
								<a href="#" class="btn btn-danger btn-round fileinput-exists" id="removeFileBtn" data-dismiss="fileinput"><i class="fa fa-times"></i> Cancelar</a>
							</div>
						</div>

						<br><br><br>
						<button class="btn btn-primary"><i class="material-icons">send</i> SUBIR</button>
                    </div>
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
                            <h4 class="card-title center-align">Ingresar corrida</h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables"> 

								<div class="form-group">
									<div class="table-responsive">
									<!--Registro de todos los clientes con y sin expediente.  -->

										<table class="table table-responsive table-bordered table-striped table-hover " id="tabla_ingresar_corrida" name="tabla_ingresar_corrida"
										style="text-align: center">
                                        <thead style="text-align: center">
                                            <tr>
                                                <!--<th></th>-->
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;"></th>
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


	var url = "<?=base_url()?>index.php/";
var url2 = "<?=base_url()?>index.php/";



	$("#tabla_ingresar_corrida").ready( function(){

    $('#tabla_ingresar_corrida thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
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
 

    tabla_corrida = $("#tabla_ingresar_corrida").DataTable({
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
/*{
    "width": "3%",
	"className": 'details-control',
	"orderable": false,
	"data" : null,
	"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},*/

{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
    }
}, 
 
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
}, 
{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
}, 
{ 
    "width": "10%",
    "orderable": false,
    "data": function( data ){

        opciones = '<div class="btn-group" role="group">';
        opciones += '<a class="btn btn-just-icon btn-round btn-linkedin agregar_corrida" data-id_cliente="'+data.id_cliente+'" data-id_condominio="'+data.idCondominio+'"' +
			' data-idLote="'+data.idLote+'" data-nomResidencial="'+data.nombreResidencial+'"' +
			'data-nomCondominio="'+data.nombreCondominio+'" data-nomLote="'+data.nombreLote+'" style="background:green;"><i class="fa fa-file-excel-o"> </i></a>';
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
    "url": url2 + "Contraloria/getCorridasContraloria",
	"dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 $('#tabla_ingresar_corrida tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_corrida.row( tr );

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

    $("#tabla_ingresar_corrida tbody").on("click", ".agregar_corrida", function(){
		var $itself = $(this);

		$('#idCliente').val($itself.attr('data-id_cliente'));
		$('#idClienteHistorial').val($itself.attr('data-id_cliente'));
		$('#idLoteHistorial').val($itself.attr('data-idLote'));
		$('#idCondominio').val($itself.attr('data-id_condominio'));

		$('#nombreResidencial').val($itself.attr('data-nomResidencial'));
		$('#nombreCondominio').val($itself.attr('data-nomCondominio'));
		$('#nombreLote').val($itself.attr('data-nomLote'));
		/*$("#modal_ingresar_corrida .modal-body").html("");
		/*$("#dal_ingresar_corrida .modal-body").append('<div class="row"><div class="col-lg-12"><input type="file" name="autorizacion" id="autorizacion"></div></div>');
		$("#modal_ingresar_corrida .modal-body").append('<div class="row"><div class="col-lg-12"><br></div><div class="col-lg-4"></div><div class="col-lg-4"><button class="btn btn-social btn-fill btn-info"><i class="fa fa-google-square"></i>SUBIR</button></div></div>');*/
        $("#modal_ingresar_corrida").modal();
});

 
});

	$('#form_corrida_add').on('submit', function(e) {
		var $itself = $(this);
		e.preventDefault();
		var formData = new FormData(this);
		if($itself.valid()) {
			$.ajax({
				url:   '<?=base_url()?>index.php/registroCliente/editar_registro_cliente_corrida_contraloria/',
				type: 'post',
				dataType: 'json',
				// data: $itself.serialize(),
				data:  formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					if(data == 1) {
						console.log(data);
						$('#modal_ingresar_corrida').modal('hide');
						// $itself.trigger('reset');
						$itself.find('#idAsesor').val('0');
						$('#removeFileBtn').click();
						$('#tabla_ingresar_corrida').DataTable().ajax.reload();
						alerts.showNotification('top', 'right', 'Expediente añadido exitosamenlte', 'success');
					} else {
						console.log(data.message);
						console.log('fail');
					}
				},
				error: function(xhr, object, message) {
					// console.log(formData);
					console.log(message);
					alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado, intentalo nuevamente', 'danger');
				}
			});
		}
	});



  $(window).resize(function(){
        tabla_corrida.columns.adjust();
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

