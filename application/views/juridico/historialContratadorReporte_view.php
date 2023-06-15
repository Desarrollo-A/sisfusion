<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>



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
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="Jtabla" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>LOTE</th>
                                                    <th>GERENTE(S)</th>
                                                    <th>ASESOR(ES)</th>
                                                    <th>ESTATUS</th>
                                                    <th>DETALLES</th>
                                                    <th>COMENTARIO</th>
                                                    <th>FECHA</th>
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


	<!--Contenido de la página-->
	<div class="content hide">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!--Eltitulo se carga por un servicio-->
					<div id="showDate"></div>
					<hr>
					<br>
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
										<div id="external_filter_container18"><B> Busqueda de Lotes por Fecha de Contratación </B></div>
										<br>
										<div id="external_filter_container7"></div>
										<br>
										<table id="Jtabla" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th style="text-align: center;">
													Lote
												</th>
												<th>
													<center> Gerente(s)</center>
												</th>
												<th>
													<center>Asesor(es)</center>
												</th>
												<th>
													<center> Status</center>
												</th>
												<th>
													<center> Detalles</center>
												</th>
												<th>
													<center> Comentario</center>
												</th>
												<th>
													<center>Fecha</center>
												</th>
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
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

<script>
    $('#Jtabla thead tr:eq(0) th').each(function (i) {

        if (i != 0 && i != 9) {
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
        }
    });




	$(document).ready(function()
	{
		$.ajax(
			{
				post: "POST",
				url: "<?=site_url().'/registroLote/getDateToday/'?>"
			}).done(function(data)
				{
					$('#showDate').text('Lotes contratados al: '+data);

				}).fail(function()
				{
					// $('#showDate').append('<center><h3>Lotes contratados al: '+new Date().getDay()+new Date().getMonth()+new Date().getFullYear()'</h3></center>');
				});



        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();

	});

    sp = { //  SELECT PICKER
        initFormExtendedDatetimepickers: function () {
            $('.datepicker').datetimepicker({
                format: 'MM/DD/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove',
                    inline: true
                }
            });
        }
    }

    function setInitialValues() {
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
        finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
        // console.log('Fecha inicio: ', finalBeginDate);
        // console.log('Fecha final: ', finalEndDate);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        fillTable(1, finalBeginDate, finalEndDate, 0);
    }


    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);
    });

    var table
    function fillTable(typeTransaction, beginDate, endDate, where) {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;

        table = $('#Jtabla').dataTable( {
            "ajax":
                {
                    "url": '<?=base_url()?>index.php/registroLote/getReportData',
                    "type": "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where
                    }
                },
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Lotes contratados al ' + dateTime ,
                title: 'Lotes contratados al ' + dateTime ,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'LOTE';
                                    break;
                                case 1:
                                    return 'GERENTE';
                                    break;
                                case 2:
                                    return 'ASESOR';
                                case 3:
                                    return 'STATUS';
                                    break;
                                case 4:
                                    return 'DETALLES';
                                    break;
                                case 5:
                                    return 'COMENTARIO';
                                    break;
                                case 6:
                                    return 'FECHA';
                                    break;
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
            columnDefs: [{
                defaultContent: "Sin especificar",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            destroy: true,
            ordering: false,
            "columns":
                [
                    {data: 'nombreLote'},
                    {
                        data: function (data)
                        {
                            var ge1, ge2, ge3, ge4, ge5;
                            if(data.gerente == undefined){ge1="";}else{ge1=data.gerente;};
                            if(data.gerente2 == undefined){ge2="";}else{ge2=data.gerente2;};
                            if(data.gerente3 == undefined){ge3="";}else{ge3=data.gerente3;};
                            if(data.gerente4 == undefined){ge4="";}else{ge4=data.gerente4;};
                            if(data.gerente5 == undefined){ ge5=""; }else{ge5=data.gerente5;};

                            return ge1 ;

                        }
                    },
                    {
                        data: function (data)
                        {
                            var as1, as2, as3, as4, as5;
                            if(data.asesor == undefined){as1="";}else{as1=data.asesor};
                            if(data.asesor2 == undefined){as2="";}else{as2=data.asesor2;};
                            if(data.asesor3 == undefined){as3="";}else{as3=data.asesor3};
                            if(data.asesor4 == undefined){as4="";}else{ as4=data.asesor4;};
                            if(data.asesor5 == undefined){as5="";}else{ as5=data.asesor5;};
                            return as1 ;
                        }
                    },
                    {
                        data: function (data)
                        {
                            //idStatusContratacion
                            var status;
                            if(data.idStatusContratacion==15){status="Lote Contratado"}else{status="Status no definido [303]"}
                            return status;
                        }
                    },
                    {
                        data: function (data)
                        {
                            //idStatusContratacion
                            var details;
                            if(data.idStatusContratacion==15 && data.idMovimiento==45){details="15. Acuse entregado (Contraloría)"}
                            return details;
                        }
                    },
                    {data: 'comentario'},
                    {data: 'fechaVenc'},
                ]
        } );
    }

</script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
