
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
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

    <div class="modal fade modal-alertas" id="modal_ingresar_2_0" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h4 class="modal-title">RECEPCIÓN DE EXPEDIENTE.</h4>
                </div>
                <form method="post" id="form_interes">
					<input type="hidden" name="idLote" id="idLote">
					<input type="hidden" name="nombreLote" id="nombreLote">
                    <div class="modal-body"></div>
					<div class="row">
						<div class="col-lg-2">&nbsp;</div>
						<div class="col-lg-8">
							<center>
								<button class="btn btn-social btn-fill btn-info boton_aceptar" id="boton_aceptar" style="background:green;
								margin-right: 10px;" value="'+IDLote+'">ACEPTAR</button>
								<button class="btn btn-social btn-fill btn-danger" data-dismiss="modal" >CANCELAR</button>
                            </center>
						</div>
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
                            <h4 class="card-title">Registros estatus <b>2.0</b> (recepción de expediente)</h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_2_0" name="tabla_ingresar_2_0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
												<th style="font-size: .9em;">LOTE</th>
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<script>


    var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";



     $("#tabla_ingresar_2_0").ready( function(){

    $('#tabla_ingresar_2_0 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_2_0.column(i).search() !== this.value ) {
                tabla_2_0
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});

    tabla_2_0 = $("#tabla_ingresar_2_0").DataTable({
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
		"width": "20%",
		"data": function( d ){
			return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
		}
	},

	{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
}, 
 
{ 
    "width": "12%",
    "orderable": false,
    "data": function( data ){

        opciones = '<div class="btn-group" role="group">';
        opciones += '<button class="btn btn-just-icon btn-round btn-linkedin agregar_estatus_2_0" title="Registrar ingreso de expediente" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#0FC6C6;"><i class="material-icons">beenhere</i></button>';
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
    "url": url2 + "contraloria/getStatus2_0",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 

 $('#tabla_ingresar_2_0 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_2_0.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
    else {
		var status;
		if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==31)
		{
			status = 'Status 1 listo (Caja)';
		}
		else if(row.data().idStatusContratacion == 2 && row.data().idMovimiento==85)
		{
			status = 'Rechazo Contraloria 2 a 2.0';
		}
        var informacion_adicional = '<table class="table text-justify">'+
        '<tr><b>STATUS</b>:'+ status +
        '<td style="font-size: .8em"><strong>COMENTARIO: </strong>'+row.data().comentario+'</td>'+
        '<td style="font-size: .8em"><strong>FECHA VENCIMIENTO: </strong>'+row.data().fechaVenc+'</td>'+
		'<td style="font-size: .8em"><strong>FECHA REALIZADO: </strong>'+row.data().modificado+'</td>'+
        '</tr>'+
        '</table>';

        row.child( informacion_adicional ).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    }
});



     

    $("#tabla_ingresar_2_0 tbody").on("click", ".agregar_estatus_2_0", function(){

        nombreLote = $(this).val();
        IDLote =  $(this).attr("data-value");
        $('#idLote').val($(this).attr("data-value"));
		$('#nombreLote').val($(this).val());


        $("#modal_ingresar_2_0 .modal-body").html("");

        $("#modal_ingresar_2_0 .modal-body").append('<div class="row"><div class="col-lg-12"><label><h4>¿Está seguro de registrar el ingreso de <b>'+nombreLote+'</b>?</h4></label></div></div>');

        // $("#modal_ingresar_2_0 .modal-body").append('<div class="row"><div class="col-lg-2">&nbsp;</div><div class="col-lg-8"><center><button class="btn btn-social btn-fill btn-info boton_aceptar" style="background:green;margin-right: 10px;" value="'+IDLote+'">ACEPTAR</button><button class="btn btn-social btn-fill btn-danger" data-dismiss="modal" >CANCELAR</button></center></div></div>');
        $("#modal_ingresar_2_0").modal();
});

 
});

	$("#boton_aceptar").click(function (){
		parametros = {
			"idLote" : $('#idLote').val(),
			"nombreLote" : $('#nombreLote').val()
		};
		console.log(parametros);

		$('#boton_aceptar').prop('disabled', true);
		$.ajax({
			url : '<?=base_url()?>index.php/contraloria/sendMailRecepExp/',
			type: 'POST',
			data : parametros,
			success: function (data, textStatus, jqXHR) {
				if(data == 1)
				{
					$("#modal_ingresar_2_0").modal('hide');
					// toastr.success('Expediente registrado exitosamente');
					alerts.showNotification('top', 'right', 'Expediente registrado exitosamente', 'success')
					$('#boton_aceptar').prop('disabled', false);
					// location.reload();
					$('#tabla_ingresar_2_0').DataTable().ajax.reload();
				}
				else if(data==0)
				{
					alerts.showNotification('top', 'right', 'No se realizó la operación alv :(', 'danger');
				}

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alerts.showNotification('top', 'right', textStatus+' '+errorThrown+' '+ jqXHR, 'danger')
			}
		});
	});

// $(document).on("click", ".boton_aceptar", function(){
//     indexLote = $(this).val();
//
//     alert(indexLote);
//
//     // $.getJSON(url2 + "Contraloria/registrar_estatus_2_0/"+indexLote).done(function( data ){
//     //      if(data){
//
//     //         alert("todo chido");
//     //      }
//     //         else{
//
//     //             alert("nel baby");
//
//     //         }
//
//     // });
// 	// MANTENER ESTE CODIGO Y ADECUARLO AL QUERY CORRESPONDIENTE AL TENER LA BASE DE DATOS
// });


    



 
  $(window).resize(function(){
        tabla_2_0.columns.adjust();
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

