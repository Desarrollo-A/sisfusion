<body>
<div class="wrapper">
	<?php
if ($this->session->userdata('id_rol') == "16")
//CONTRATACION
{
    $dato = array(
        'home'                 => 0,
        'listaCliente'         => 0,
        'contrato'             => 0,
        'documentacion'        => 0,
        'corrida'              => 0,
        'inventario'           => 1,
        'inventarioDisponible' => 0,
        'status8'              => 0,
        'status14'             => 0,
        'lotesContratados'     => 0,
        'ultimoStatus'         => 0,
        'lotes45dias'          => 0,
        'consulta9Status'      => 0,
        'consulta12Status'     => 0,
        'gerentesAsistentes'   => 0,
		'expedientesIngresados'	=>	0,
		'corridasElaboradas'	=>	0
    );
    //$this->load->view('template/contratacion/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
} else if ($this->session->userdata('id_rol') == "6")
//ASISTENTE GERENTE
{
    $dato = array(
        'home'             => 0,
        'listaCliente'     => 0,
        'corridaF'         => 0,
        'documentacion'    => 0,
        'autorizacion'     => 0,
        'contrato'         => 0,
        'inventario'       => 1,
        'estatus8'         => 0,
        'estatus14'        => 0,
        'estatus7'         => 0,
        'reportes'         => 0,
        'estatus9'         => 0,
        'disponibles'      => 0,
        'asesores'         => 0,
        'nuevasComisiones' => 0,
        'histComisiones'   => 0,
		'prospectos' => 0,
		'prospectosAlta' => 0

    );
    //$this->load->view('template/ventas/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
} elseif ($this->session->userdata('id_rol') == "13")
//CONTRALORIA
{
    $dato = array(
        'home'           => 0,
        'listaCliente'   => 0,
        'expediente'     => 0,
        'corrida'        => 0,
        'documentacion'  => 0,
        'historialpagos' => 0,
        'inventario'     => 1,
        'estatus20'      => 0,
        'estatus2'       => 0,
        'estatus5'       => 0,
        'estatus6'       => 0,
        'estatus9'       => 0,
        'estatus10'      => 0,
        'estatus13'      => 0,
        'estatus15'      => 0,
        'enviosRL'       => 0,
        'estatus12'      => 0,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 0,
        'comnuevas'      => 0,
        'comhistorial'   => 0,
		'integracionExpediente' => 0,
		'expRevisados' => 0,
		'estatus10Report' => 0,
		'rechazoJuridico' => 0
    );
//    $this->load->view('template/contraloria/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
} elseif ($this->session->userdata('id_rol') == "7")
//ASESOR
{
     $dato= array(
                    'home' => 0,
                    'listaCliente' => 0,
                    'corridaF' => 0,
                    'inventario' => 1,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'statistic' => 0,
                    'comisiones' => 0,
                    'DS'    => 0,
                    'DSConsult' => 0,
                    'documentacion' => 0,
                    'inventarioDisponible'  =>  0,
                    'manual'    =>  0,
                    'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'references' => 0,
		 			'autoriza' =>	0,
		 			'clientsList' => 0
                );
    //$this->load->view('template/asesor/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
} elseif ($this->session->userdata('id_rol') == "2")
//ASESOR
    {
        $dato= array(
            'home' => 0,
            'usuarios' => 0,
            'statistics' => 0,
            'manual' => 0,
            'aparta' => 0,
            'prospectos' => 0,
            'prospectosAlta' => 0,
            'statistics' => 0,
            'corridaF' => 0,
            'inventario' => 1,
            'inventarioDisponible' => 0,
			'prospectosMktd' => 0,
			'bulkload' => 0,
			'autorizaciones' =>	0,
			'nuevasComisiones' => 0,
			'histComisiones' => 0
        );
        //$this->load->view('template/asesor/sidebar', $dato);
        $this->load->view('template/sidebar', $dato);
    }
	elseif ($this->session->userdata('id_rol') == "11") //ADMINISTRACION
	{
		$dato = array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
			'inventario' => 1,
			'status11' => 0,
		);
		//$this->load->view('template/administracion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif ($this->session->userdata('id_rol') == "12") //CAJA
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
			'cambiarAsesor' => 0,
			'historialPagos' => 0,
			'pagosCancelados' => 0,
			'altaCluster' => 0,
			'altaLote' => 0,
			'inventario' => 1,
			'actualizaPrecio' => 0,
			'actualizaReferencia' => 0,
			'liberacion' => 0
		);
		//$this->load->view('template/administracion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif ($this->session->userdata('id_rol') == "15") //JURIDICO
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
			'contrato' => 0,
			'inventario' => 1,
			'status3' => 0,
			'status7' => 0,
			'lotesContratados' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/juridico/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="28")//MKT
	{
		$dato= array(
			'home'	=> 0,
			'prospectos' => 0,
			'prospectosMktd' => 0,
			'prospectosAlta' => 0,
			'statistics' => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'references' => 0,
			'bulkload' => 0,
			'listaAsesores' => 0,
			'manual'	=>	0,
			'aparta' => 0,
			'mkt_digital' => 0,
			'prospectPlace' => 0,
			'documentacionMKT' => 0,
			'inventarioMKT' => 1
		);
		$this->load->view('template/sidebar', $dato);
	}
	else {
    echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
}

?>

<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Consulta de historial</h4>
			</div>

			<div class="modal-body">
				<div role="tabpanel">
					<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
						<li role="presentation" class="active"><a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab" data-toggle="tab">Proceso de contratación</a>
						</li>
						<li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Liberación</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="changeprocesTab">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-plain">
										<div class="card-content">
											<ul class="timeline timeline-simple" id="changeproces"></ul>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div role="tabpanel" class="tab-pane" id="changelogTab">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-plain">
										<div class="card-content">
											<ul class="timeline timeline-simple" id="changelog"></ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
			</div>
		</div>
	</div>
</div>



<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="block full">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                        <i class="material-icons">list</i>
                                    </div>

                                    <div class="card-content">
                                    	<div class="row">
                                    		<h4 class="card-title"><B>Inventario</B> Lotes</h4>
                                    		<div class="container-fluid" style="padding: 20px 20px;">
                                    			<div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio" id="condominio" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="estatus">Estatus: </label>
										<select name="estatus" id="estatus" class="selectpicker" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA ESTATUS -</option></select>
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

<div class="row">
	<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="card">
			<div class="card-content" style="padding: 10px 20px;">
				<h4 class="card-title"></h4>
				<div class="material-datatables">
					<div class="form-group">
						<div class="table-responsive">
							<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">

								<thead>
									<tr>
										<th style="font-size: .9em;">PROYECTO</th>
                                        <th style="font-size: .9em;">CONDOMINIO</th>
                                        <th style="font-size: .9em;">LOTE</th>
                                        <th style="font-size: .9em;">CLIENTE</th>
                                        <th style="font-size: .9em;">NOM. DOCUMENTO</th>
                                        <th style="font-size: .9em;">HORA/FECHA</th>
                                        <th style="font-size: .9em;">DOCUMENTO</th>
                                        <th style="font-size: .9em;">ELITE</th>
                                        <th style="font-size: .9em;">UBICACIÓN</th>
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
var url2 = "<?=base_url()?>/index.php/";
var urlimg = "<?=base_url()?>/img/";

$(document).ready(function(){
	$.post(url + "Contratacion/lista_proyecto", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['idResidencial'];
			var name = data[i]['descripcion'];
			$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
		}

		$("#proyecto").selectpicker('refresh');
	}, 'json');

	$.post(url + "Contratacion/lista_estatus", function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['idStatusLote'];
			var name = data[i]['nombre'];
			$("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#estatus").selectpicker('refresh');
	}, 'json');
});


$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
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


$(document).on('change','#proyecto, #condominio, #estatus', function() {
	ix_proyecto = $("#proyecto").val();
   	ix_condominio = $("#condominio").val();
   	ix_estatus = $("#estatus").val();

   	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
   		destroy: true,
   		"ajax":
   		{
   			"url": '<?=base_url()?>index.php/Contratacion/get_inventario/'+ix_estatus+"/"+ix_condominio+"/"+ix_proyecto,
   			"dataSrc": ""
   		},

   		"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
		"processing": false,
		"pageLength": 10,
		"bAutoWidth": false,
		"bLengthChange": false,
		"scrollX": true,
		"bInfo": false,
		"searching": true,
		"paging": true,
		"ordering": false,
		"fixedColumns": true,
		"ordering": false,
		"columns":
		[{
			"width": "10%",
			data: 'nombreResidencial'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
			}
		},
		{
			"width": "14%",
			data: 'nombreLote'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+d.superficie+'<b> m<sup>2</sup></b></p>';
			}
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>$ '+formatMoney(d.total)+'</p>';
			}
		},
		{
			"width": "10%",
			data: 'referencia'
		},
		{
			"width": "12%",
			"data": function(d){
				return '<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span><center>';
			}
		},
		{
			"width": "16%",
			"data": function(d){
				if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
					return ' - ';
				}
				else
				{
					return '<p>'+d.comentario+'</p>';
				}
			}
		},
		{
			"width": "8%",
			"data": function( d ){
				return '<center><button class="btn btn-black btn-round btn-fab btn-fab-mini to-comment ver_historial" value="' + d.idLote +'" style="margin-right: 10px;color:#00B4CC;background-color:#fff;"><i class="material-icons">subject</i></button></center>';
			}
		}
		]
	});

	$("#tabla_inventario_contraloria tbody").on("click", ".ver_historial", function(){
		var tr = $(this).closest('tr');
		var row = tabla_inventario.row( tr );
		idLote = $(this).val();

		$("#seeInformationModal").modal();
		$.getJSON(url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
			$.each( data, function(i, v){
				fillLiberacion(v);
			});
		});

        $.getJSON(url+"Contratacion/obtener_proceso/"+idLote).done( function( data ){
            $.each( data, function(i, v){
                fillProceso(v);
            });
        });
    });


    $(window).resize(function(){
    tabla_inventario.columns.adjust();
});
});


function fillLiberacion (v) {
	$("#changelog").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge success"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
        '<b>ID:</b> '+v.idLiberacion+'\n' +
        '<br>\n' +
        '<b>Estatus:</b> '+v.estatus_actual+'\n' +
        '<br>\n' +
        '<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

function fillProceso (v) {
	$("#changeproces").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge info"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>PROCESO - </b>'+v.nombreLote+'</h5></label><br>\n' +
        '<b>ID:</b> '+v.idHistorialLote+'\n' +
        '<br>\n' +
        '<b>Estatus:</b> '+v.stlt+'\n' +
        '<br>\n' +
        '<b>Area:</b> '+v.perfil+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+'  - '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');

	 // comentario, perfil, modificado,
}


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

