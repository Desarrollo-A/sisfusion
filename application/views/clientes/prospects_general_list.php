<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/><body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>
	<style>
		.label-inf {
			color: #333;
		}

		select:invalid {
			border: 2px dashed red;
		}

        .textoshead::placeholder { color: white; }

        /*th { background: #003D82; }*/
.yadcf-filter-wrapper {
    display: inline-block;
    white-space: nowrap;
    margin-left: 2px;
}

.yadcf-filter-range-date {
    width: 80px;
    border: 0px;
    border-bottom: 1px solid #003d82;
}
.yadcf-filter-reset-button {
    display: inline-block;
    margin-left: 14px;
    background: transparent;
    border: 0px;
}
.yadcf-filter-wrapper-inner {
    display: inline-block;
    border: 0px solid #ABADB3;
}
.yadcf-filter-range-date-seperator {
    margin-left: 10px;
    margin-right: 10px;
}
	</style>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="container-fluid">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 box-w-division  pb-5">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Listado general de prospectos</h3>
                                        <p class="card-title pl-1">(Marketing digital)</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="row">
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table id="prospects_mktd_datatable" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PROSPECTO</th>
                                                            <th>NOMBRE</th>
                                                            <th>APELLIDO PATERNO</th>
                                                            <th>APELLIDO MATERNO</th>
                                                            <th>TELÉFONO</th>
                                                            <th>CORREO</th>
                                                            <th>PLAZA</th>
                                                            <th>FECHA CREACIÓN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Listado general de prospectos</h3>
                                        <p class="card-title pl-1">(Área comercial)</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="row">
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table id="prospects_comercial_datatable" class="table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>ID PROSPECTO</th>
                                                        <th>NOMBRE</th>
                                                        <th>APELLIDO PATERNO</th>
                                                        <th>APELLIDO MATERNO</th>
                                                        <th>TELÉFONO</th>
                                                        <th>CORREO</th>
                                                        <th>PLAZA</th>
                                                        <th>FECHA CREACIÓN</th>
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
    </div>


	<div class="content hide">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block full">
						<div class="row">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">people</i>
									</div>
									<div class="card-content">
										<div class="row">
											<h4 class="card-title">Listado general de prospectos <b>marketing digital</b></h4>
										</div>
										<div class="row">
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="prospects_mktd_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
														<thead>
														<tr>
															<th title="ID prospecto"><center>ID prospecto</center></th>
															<th title="Nombre"><center>Nombre</center></th>
                                                            <th title="Sede"><center>Apellido paterno</center></th>
                                                            <th title="Valor anterior"><center>Apellido materno</center></th>
															<th title="Valor nuevo"><center>Teléfono</center></th>
															<th title="Usuario que modifica"><center>Correo</center></th>
															<th title="Fecha alta"><center>Plaza</center></th>
															<th title="Fecha asignación"><center>Fecha creación</center></th>
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

						<div class="row">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">people</i>
									</div>
									<div class="card-content">
										<div class="row">
											<h4 class="card-title">Listado general de prospectos <b>área comercial</b></h4>
										</div>
										<div class="row">
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="prospects_comercial_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
														<thead>
														<tr>
															<th title="ID prospecto"><center>ID prospecto</center></th>
															<th title="Nombre"><center>Nombre</center></th>
                                                            <th title="Sede"><center>Apellido paterno</center></th>
                                                            <th title="Valor anterior"><center>Apellido materno</center></th>
															<th title="Valor nuevo"><center>Teléfono</center></th>
															<th title="Usuario que modifica"><center>Correo</center></th>
															<th title="Fecha alta"><center>Plaza</center></th>
															<th title="Fecha asignación"><center>Fecha creación</center></th>
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
			</div>
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
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

	$(document).ready(function () {
		fillDataTable('#prospects_mktd_datatable', '1');
		fillDataTable('#prospects_comercial_datatable', '2');
	});

	$('#prospects_mktd_datatable thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#prospects_mktd_datatable').DataTable().column(i).search() !== this.value ) {
                $('#prospects_mktd_datatable').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#prospects_comercial_datatable thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#prospects_comercial_datatable').DataTable().column(i).search() !== this.value ) {
                $('#prospects_comercial_datatable').DataTable().column(i).search(this.value).draw();
            }
        });
    });


	function fillDataTable(table, typeTransaction)
	{

		var prospects_assigned_datatable = $(table).dataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Listado general de clientes',
                    title:'Listado general de clientes' ,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header:  function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID PROSPECTO';
                                        break;
                                    case 1:
                                        return 'NOMBRE';
                                        break;
                                    case 2:
                                        return 'APELLIDO PATERNO';
                                        break;
                                    case 3:
                                        return 'APELLIDO MATERNO';
                                        break;
                                    case 4:
                                        return 'TELÉFONO';
                                        break;
                                    case 5:
                                        return 'CORREO';
                                        break;
                                    case 6:
                                        return 'PLAZA';
                                        break;
                                    case 7:
                                        return 'FECHA CREACIÓN';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true
            }],
            scrollX: true,
            fixedHeader: true,
            pageLength: 10,
            width: '100%',
            pagingType: "full_numbers",
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering:true,
			columns: [
                { data: function (d) {
						return d.id_prospecto;
					}
				},
				{ data: function (d) {
						return d.nombre;
					}
				},
				{ data: function (d) {
						return d.apellido_paterno;
					}
				},
				{ data: function (d) {
						return d.apellido_materno;
					}
				},
				{ data: function (d) {
						return d.telefono;
					}
				},
				{ data: function (d) {
						return d.correo;
					}
				},
				{ data: function (d) {
						return d.plaza;
					}
				},
				{ data: function (d) {
						return d.fecha_creacion;
					}
				}
			],
			ajax: {
				url: 'getGeneralProspectsListInformation',
				type: "POST",
				cache: false,
				data:{
					"typeTransaction": typeTransaction,
				}
			}
		})		
	}

</script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
