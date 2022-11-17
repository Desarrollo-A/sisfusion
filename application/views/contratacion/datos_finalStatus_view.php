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

	?>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align " id="showDate"> </h3>
							<div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Sedes por proyecto</label>
                                                <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona una sede"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="Jtabla"  class="table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>SEDE</th>
                                                <th>REFERENCIA</th>
                                                <th>SUP</th>
                                                <th>GERENTE</th>
                                                <th>ASESOR(ES)</th>
                                                <th>PROCESO CONTRATACIÓN</th>
                                                <th>ESTATUS</th>
                                                <th>COMENTARIO</th>
                                                <th>FECHA VENCIMIENTO</th>
                                                <th>DÍAS RESTANTES</th>
                                                <th>DÍAS VENCIDOS</th>
                                                <th>ESTATUS FECHA</th>
                                                <th>FECHA APARTADO</th>
												<th>CLIENTE</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
    $('#Jtabla thead tr:eq(0) th').each(function (i) {

        // if (i != 0 && i != 9) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#Jtabla').DataTable().column(i).search() !== this.value) {
                    $('#Jtabla').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        // }
    });



	$(document).ready(function() {
		$.post(`${general_base_url}Contratacion/sedesPorDesarrollos`, function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['id_sede'];
			var name = data[i]['nombre'];
			$("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#sedes").selectpicker('refresh');
		}, 'json');
		const [date, dateTime] = getFinalDate();
		const hoy = new Date();
		const options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
		$('#showDate').append('Estatus actual del terreno al ' + hoy.toLocaleDateString('es-ES', options));
	});

	$(document).on('change', "#sedes", function () {
		fillTable($(this).val());
	});

	function getFinalDate(){
		var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + ' ' + time;
		return [date, dateTime];
	}

	function fillTable(sede) {
		const [date, dateTime] = getFinalDate();
		$('#Jtabla').DataTable({
			ajax: {
				url: '<?=base_url()?>index.php/registroLote/getFinalStatus/',
				type: "POST",
				cache: false,
				data: {
					"id_sede": sede
				}
			},
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Estatus actuales de terrenos al: ' + dateTime ,
                title: 'Estatus actuales de terrenos al:  ' + dateTime ,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,16],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'PROYECTO';
                                case 1:
                                    return 'CONDOMINIO';
                                case 2:
                                    return 'LOTE';
                                case 3:
                                    return 'SEDE';
                                case 4:
                                    return 'REFERENCIA';
                                case 5:
                                    return 'SUP';
                                case 6:
                                    return 'GERENTE';
                                case 7:
                                    return 'ASESOR(ES)';
                                case 8:
                                    return 'PROCESO CONTRATACIÓN';
                                case 9:
                                    return 'ESTATUS';
                                case 10:
                                    return 'COMENTARIO';
                                case 11:
                                    return 'FECHA VENCIMIENTO';
                                case 12:
                                    return 'DÍAS RESTANTES';
                                case 13:
                                    return 'DÍAS VENCIDOS';
                                case 14:
                                    return 'ESTATUS';
                                case 15:
                                    return 'FECHA APARTADO';
								case 16: 
									return 'CLIENTE';
							
                            }
                        }
                    }
                }
            }],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
			scrollX: true,
            columnDefs: [{
                defaultContent: "Sin especificar",
                targets: "_all",
                searchable: true,
                orderable: true
            }],
            destroy: true,
            ordering: true,
			columns: [
				{data: 'nombreResidencial'},
				{data: 'nombreCondominio'},
				{data: 'nombreLote'},
                { data: 'nombreSede' },
				{data: 'referencia'},
				{data: 'sup'},
				{
					// data: 'gerente1'
					data: function(data)
					{
						var ge1, ge2, ge3, ge4, ge5;
						if(data.gerente!="" && data.gerente!=null){ge1="- "+data.gerente}else{ge1="";}
						if(data.gerente2!="" && data.gerente2!=null){ge2="- "+data.gerente2}else{ge2="";}
						if(data.gerente3!="" && data.gerente3!=null){ge3="- "+data.gerente3}else{ge3="";}
						if(data.gerente4!="" && data.gerente4!=null){ge4="- "+data.gerente4}else{ge4="";}
						if(data.gerente5!="" && data.gerente5!=null){ge5="- "+data.gerente5}else{ge5="";}
						return ge1;
					}
				},
				{
					// data: 'asesor'
					data: function(data)
					{
						var as1, as2, as3, as4, as5;
						if(data.asesor!="" && data.asesor!=null){as1="- "+data.asesor}else{as1="";}
						if(data.asesor2!="" && data.asesor2!=null){as2="- "+data.asesor2}else{as2="";}
						if(data.asesor3!="" && data.asesor3!=null){as3="- "+data.asesor3}else{as3="";}
						if(data.asesor4!="" && data.asesor4!=null){as4="- "+data.asesor4}else{as4="";}
						if(data.asesor5!="" && data.asesor5!=null){as5="- "+data.asesor5}else{as5="";}
						return as1;
					}
				},
				{
					width:'5%',
					data: 'procesoContratacion',
					defaultContent: '<i>Not set</i>'

				},
				{
					// data: 'status'
					data : function(data)
					{
						if(data.descripcion==null || data.descripcion=="")
						{
							return "N/A";
						}
						else
						{
							return data.descripcion;
						}
					}
				},
				{data: 'comentario'},
				{
					// data: 'fechaVencimiento'
					width:'15%',
					data : function(data)
					{
						if(data.fechaVencimiento==null || data.fechaVencimiento=="")
						{
							return "N/A";
						}
						else
						{
							return data.fechaVencimiento;
						}
					}
				},//fechaVencimiento
				{
					// data: 'diasRest'
					data : function(data)
					{
						if(data.diasRest !=null)
						{
							return data.diasRest;
						}
						else
						{
							return "N/A";
						}
					}
				},//diasRestantes
				{
					// data: 'diasVenc'
					data : function(data)
					{
						if(data.diasVenc !=null)
						{
							return data.diasVenc;
						}
						else
						{
							return "N/A";
						}
					}
				},//diasVencidos
				{
					// data: 'statusFecha'
					data : function(data)
					{
						if(data.statusFecha !=null)
						{
							return data.statusFecha;
						}
						else
						{
							return "N/A";
						}
					}
				},//statusFecha
				{data: 'fechaApartado'},
				{data: 'nombreCliente'},

			]
		});
	}
</script>
