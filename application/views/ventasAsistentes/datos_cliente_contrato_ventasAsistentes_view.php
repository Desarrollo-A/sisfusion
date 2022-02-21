<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
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

	<div class="modal fade" id="fileViewer">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal body -->
				<div class="modal-body">
					<a style="position: absolute;top:3%;right:3%; cursor:pointer;" data-dismiss="modal">
						<span class="material-icons">
							close
						</span>
					</a>
					<div id="cnt-file">
					</div>
				</div>
			</div>
		</div>
	</div>



    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Contrato</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" required>
                                                <option disabled selected>Selecciona proyecto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select name="condominio" id="condominio" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona condominio" data-size="7" required>
                                                <option disabled selected>Selecciona condominio</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select name="lote" id="lote"  class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona lote" data-size="7" required>
                                                <option disabled selected>Selecciona lote</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover" id="tabla_contrato_ventas" name="tabla_contrato_ventas">
                                            <thead>
                                            <tr>
                                                <th>LOTE</th>
                                                <th>CONDOMINIO</th>
                                                <th>PROYECTO</th>
                                                <th>CLIENTE</th>
                                                <th>NOMBRE CONTRATO</th>
                                                <th>CONTRATO</th>
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


	<!--Contenido de la página-->
	<div class="content hide">
		<div class="container-fluid">
			 
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h4>CONTRATO</h4>
					</center>
					<div class="card">
						<div class="container-fluid" style="padding: 50px 50px;">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								 
								 <div class="row">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn"data-show-subtext="true"
                                                data-live-search="true"  title="" data-size="7" required>
                                            <option disabled selected>- SELECCIONA PROYECTO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio" id="condominio" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="lote">Lote: </label>
										<select name="lote" id="lote" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA LOTE -</option></select>
									</div>
								</div>
						</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_contrato_ventas" name="tabla_contrato_ventas">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th>LOTE</th>
                                                <th>CONDOMINIO</th>
                                                <th>PROYECTO</th>
                                                <th>CLIENTE</th>
                                                <th>NOMBRE CONTRATO</th>
                                                <th>CONTRATO</th>
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
var urlimg = "<?=base_url()?>img/";
 

$(document).ready(function(){
		$.post(url + "Asistente_gerente/lista_proyecto", function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idResidencial'];
				var name = data[i]['descripcion'];
				$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#proyecto").selectpicker('refresh');
		}, 'json');
	});

   $('#proyecto').change( function() {
   	index_proyecto = $(this).val();
   	$("#condominio").html("");
   	$(document).ready(function(){
		$.post(url + "Asistente_gerente/lista_condominio/"+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
 
   });


     $('#condominio').change( function() {
   	index_condominio = $(this).val();
   	$("#lote").html("");
   	$(document).ready(function(){
		$.post(url + "Asistente_gerente/lista_lote/"+index_condominio, function(data) {
			var len = data.length;
			$("#lote").append($('<option disabled selected>- SELECCIONA LOTE -</option>'));
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idLote'];
				var name = data[i]['nombreLote'];
				$("#lote").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#lote").selectpicker('refresh');
		}, 'json');

	});
 
   });

     var tabla_contrato;
$('#lote').change( function() {
   	index_lote = $(this).val();
 
   					   // $('#tabla_contrato_ventas').DataTable({
tabla_contrato = $("#tabla_contrato_ventas").DataTable({
                width: 'auto',
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
				"ajax":
					{
						"url": '<?=base_url()?>index.php/Asistente_gerente/get_lote_contrato/'+index_lote,
						"dataSrc": ""
					},
                destroy:true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Contrato',
                        title:'Contrato',
                        exportOptions: {
                            columns: [0,1,2,3, 4],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'LOTE';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'PROYECTO'
                                        case 3:
                                            return 'CLIENTE';
                                            break;
                                        case 4:
                                            return 'NOMBRE CONTRATO';
                                            break;
                                    }
                                }
                            }
                        },

                    }
                ],
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                processing: true,
                pageLength: 10,
                bAutoWidth: false,
                bLengthChange: false,
                scrollX: true,
                bInfo: true,
                searching: true,
                ordering: false,
                fixedColumns: true,

				"columns":
				[
					{data: 'nombreLote'},
					{data: 'condominio'},
					{data: 'nombreResidencial'},
					
					{
						data: null,
						render: function ( data, type, row )
						{
							return data.nombre+' ' +data.apellido_paterno+' '+data.apellido_materno;
						},
					},
					{
						// data: 'contratoArchivo'
						data:function (data)
						{
							return myFunctions.validateEmptyField(data.contratoArchivo);
						}
					},
					{ 
						"orderable": false,
						"data": function( data ){
							// opciones = '<div class="btn-group" role="group">';
							// opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-just-icon btn-info ver_contrato"><i class="material-icons">open_in_browser</i></button></div>';
							// return opciones + '</div>';

							$('#cnt-file').html('<h3 style="font-weight:100">Visualizando <b>'+ myFunctions.validateEmptyField(data.contratoArchivo)+'</b></h3><embed src="<?=base_url()?>static/documentos/cliente/contrato/'+data.contratoArchivo+'" frameborder="0" width="100%" height="500" style="height: 60vh;"></embed >');
								var myLinkConst = '<center><a type="button" data-toggle="modal" data-target="#fileViewer" class="btn-data btn-blueMaderas"><center><i class="fas fa-eye" style="cursor: pointer"></i></center></a></center>'
								return myLinkConst;


						} 
					}
				]

		});

        //



 $("#tabla_contrato_ventas tbody").on("click", ".ver_contrato", function(){

    var tr = $(this).closest('tr');
    var row = tabla_contrato.row( tr );

    idautopago = $(this).val();

    $("#modal_contrato .modal-body").html("");
    $("#modal_contrato .modal-body").append('<div class="row"><div class="col-lg-12"><input type="file" name="autorizacion" id="autorizacion"></div></div>');
    $("#modal_contrato .modal-body").append('<div class="row"><div class="col-lg-12"><br></div><div class="col-lg-4"></div><div class="col-lg-4"><button class="btn btn-social btn-fill btn-info"><i class="fa fa-google-square"></i>SUBIR</button></div></div>');
    $("#modal_contrato").modal();
});

});


$('#tabla_contrato_ventas thead tr:eq(0) th').each(function (i) {
    if (i != 5) {
        var title = $(this).text();
        $(this).html('<input class="textoshead" type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (tabla_contrato.column(i).search() !== this.value) {
                tabla_contrato
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
});

let titulos = [];
$('#tabla_contrato_ventas thead tr:eq(0) th').each(function (i) {
    if (i != 0 && i != 13) {
        var title = $(this).text();

        titulos.push(title);
    }
});


$(window).resize(function(){
    tabla_contrato.columns.adjust();
});
</script>

