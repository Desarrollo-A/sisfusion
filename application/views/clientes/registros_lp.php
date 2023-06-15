<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-book fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Registro desde Landing Page</h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="registros-datatable" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID REGISTRO</th>
                                                        <th>SEDE</th>
                                                        <th>NOMBRE</th>
                                                        <th>CORREO</th>
                                                        <th>TELÉFONO</th>
                                                        <th>ORIGEN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <!-- MODAL WIZARD -->
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/report_prospects.js"></script>
    <script>
        $(document).ready(function () {
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

        $('#registros-datatable thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#registros-datatable').DataTable().column(i).search() !== this.value) {
                    $('#registros-datatable').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        function fillTable(typeTransaction, beginDate, endDate, where) {
            chatsTable = $('#registros-datatable').DataTable({
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6],
						format: {
							header: function (d, columnIdx) {
								switch (columnIdx) {
									case 0:
										return 'ID Registro';
									break;
									case 1:
										return 'Sede';
									break;
									case 2:
										return 'Nombre'
									case 3:
										return 'Correo';
									break;
									case 4:
										return 'Teléfono';
									break;
									case 5:
										return 'Origen';
									break;
                                    case 6:
										return 'Fecha';
									break;
								}
							}
						}
					},
				}],
                width: 'auto',
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "../static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    data: function (d) {
                        return d.id_registro;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre_sede;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        if (d.correo != '' || d.correo != null){
                            return d.correo;
                        }
                        else{
                            return '-';
                        }
                    }
                },
                { 
                    data: function (d) {
                        return d.telefono;
                    }
                },
                { 
                    data: function (d) {
                        if (d.origen != '' || d.origen != null){
                            return d.origen;
                        }
                        else{
                            return '-';
                        }
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                }],
                ajax: {
                    url: "registrosLP/",
                    type: "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where
                    }
                }
            });
        }

        $(document).on("click", "#searchByDateRange", function () {
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            fillTable(3, finalBeginDate, finalEndDate, 0);
        });
    </script>
</body>