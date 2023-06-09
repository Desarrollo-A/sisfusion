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
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Listado general de prospectos asignados</h3>
                                    <p class="card-title pl-1">(Marketing Digital)</p>
                                </div>

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
                                            <table id="prospects_assigned_datatable" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th data-toggle="tooltip" data-placement="right" title="ID prospecto">ID PROSPECTO</th>
                                                        <th data-toggle="tooltip" data-placement="right" title="Nombre">NOMBRE</th>
                                                        <th data-toggle="tooltip" data-placement="right" title="Sede">SEDE</th>
                                                        <th data-toggle="tooltip" data-placement="right" title="Valor anterior">VALOR ANTERIOR</th>
                                                        <th data-toggle="tooltip" data-placement="left" title="Valor nuevo">VALOR NUEVO</th>
                                                        <th data-toggle="tooltip" data-placement="left" title="Usuario que modifica">USUARIO QUE MODIFICA</th>
                                                        <th data-toggle="tooltip" data-placement="left" title="Fecha alta">FECHA ALTA</th>
                                                        <th data-toggle="tooltip" data-placement="left" title="Fecha asignación">FECHA ASIGANACIÓN</th>
                                                        <th data-toggle="tooltip" data-placement="left" title="Medio">MEDIO</th>
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

        <div class="content hide">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Listado general de prospectos asignados <b>marketing digital</b></h4>
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <label id="external_filter_container18">Búsqueda por fecha</label>
                                                            <br>
                                                        <div id="external_filter_container7"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <div class="material-datatables">
                                                        <table id="prospects_assigned_datatable" class="table table-striped table-no-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th data-toggle="tooltip" data-placement="right">ID prospecto</th>
                                                                    <th data-toggle="tooltip" data-placement="right" title="Nombre">Nombre</th>
                                                                    <th data-toggle="tooltip" data-placement="right" title="Sede">Sede</th>
                                                                    <th data-toggle="tooltip" data-placement="right" title="Valor anterior">Valor anterior</th>
                                                                    <th data-toggle="tooltip" data-placement="left" title="Valor nuevo">Valor nuevo</th>
                                                                    <th data-toggle="tooltip" data-placement="left" title="Usuario que modifica">Usuario que modifica</th>
                                                                    <th data-toggle="tooltip" data-placement="left" title="Fecha alta">Fecha alta</th>
                                                                    <th data-toggle="tooltip" data-placement="left" title="Fecha asignación">Fecha asignación</th>
                                                                    <th data-toggle="tooltip" data-placement="left" title="Medio">Medio</th>
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
        $(document).ready(function () {
            //$('[data-toggle="tooltip"]').tooltip();
            sp.initFormExtendedDatetimepickers();
            $('.datepicker').datetimepicker({locale: 'es'});
            // fillDataTable();
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

        $('#prospects_assigned_datatable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#prospects_assigned_datatable').DataTable().column(i).search() !== this.value ) {
                    $('#prospects_assigned_datatable').DataTable().column(i).search(this.value).draw();
                }
            });
        });

        $(document).on("click", "#searchByDateRange", function () {
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            fillDataTable(3, finalBeginDate, finalEndDate, 0);
        });

        function fillDataTable(typeTransaction, beginDate, endDate, where){
            var prospects_assigned_datatable = $('#prospects_assigned_datatable').dataTable({
                dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Listado general de prospectos asignados',
                        title: 'Listado general de prospectos asignados',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'ID PROSPECTO';
                                            break;
                                        case 1:
                                            return 'NOMBRE';
                                            break;
                                        case 2:
                                            return 'SEDE';
                                        case 3:
                                            return 'VALOR ANTERIOR';
                                            break;
                                        case 4:
                                            return 'VALOR NUEVO';
                                            break;
                                        case 5:
                                            return 'USUARIO QUE MODIFICA';
                                            break;
                                        case 6:
                                            return 'FECHA ALTA';
                                            break;
                                        case 7:
                                            return 'FECHA ASIGNACIÓN';
                                            break;
                                        case 8:
                                            return 'MEDIO';
                                            break;
                                    }
                                }
                            }
                        },

                    }
                ],
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
                destroy: true,
                ordering: false,
                columns: [
                    {
                        data: function (d) {
                            return d.id_prospecto;
                        }
                    },
                    {
                        data: function (d) {
                            return d.nombreProspecto;
                        }
                    },
                    {
                        data: function (d) {
                            return d.sede;
                        }
                    },
                    {
                        data: function (d) {
                            return d.valorAnterior;
                        }
                    },
                    {
                        data: function (d) {
                            return d.valorNuevo;
                        }
                    },
                    {
                        data: function (d) {
                            return d.nombreUsuarioModifica;
                        }
                    },
                    {
                        data: function (d) {
                            return d.fecha_creacion;
                        }
                    },
                    {
                        data: function (d) {
                            return d.fecha_asignacion;
                        }
                    },
                    {
                        data: function (d) {
                            if (d.otro_lugar == 'Contacto web') { // MJ: Contacto web
                                return "<small class='label bg-green' style='background-color: #E74C3C'>Contacto web</small>";
                            } else if (d.otro_lugar == 'Facebook') { // MJ: Facebook
                                return "<small class='label bg-green' style='background-color: #2E86C1'>Facebook</small>";
                            } else if (d.otro_lugar == 'Recomendado') { // MJ: Recomendado
                                return "<small class='label bg-green' style='background-color: #D35400'>Recomendado</small>";
                            } else if (d.otro_lugar == '01 800') { // MJ: 01 800
                                return "<small class='label bg-green' style='background-color: #45B39D'>01 800</small>";
                            } else if (d.otro_lugar == 'Chat') { // MJ: Chat
                                return "<small class='label bg-green' style='background-color: #F1C40F'>Chat</small>";
                            } else if (d.otro_lugar == 'Referido personal') { // MJ: Referido personal
                                return "<small class='label bg-green' style='background-color: #A569BD'>Referido personal</small>";
                            } else if (d.otro_lugar == 'WhatsApp') { // MJ: WhatsApp
                                return "<small class='label bg-green' style='background-color: #28B463'>WhatsApp</small>";
                            } else { // MJ: Otro
                                return "<small class='label bg-green' style='background-color: #808B96'></small>";
                            }
                        }
                    }
                ],
                "ajax": {
                    "url": 'getProspectsAssignedList',
                    "type": "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where
                    }
                }
            })
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
            fillDataTable(1, finalBeginDate, finalEndDate, 0);
        }

        function formatMoney( n ){
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

    </script>
</body>