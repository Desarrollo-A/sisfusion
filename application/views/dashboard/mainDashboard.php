<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);

        ?>
        
        <!-- Modals -->
        <div class="modal fade " id="generalChartModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">General</h2>
                    </div>
                    <div class="modal-body">
                        <canvas id="myLineChart"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <span class="material-icons">trending_up</span>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" >Consolidado</h3>
                                <input class="hidden" id="inputId">
                                <div class="container-fluid encabezado-totales">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-md-12"
                                                    style="">
                                                    <h4 class="text-center">TOTAL</h4>
                                                    <p class="text-center"><i
                                                                class="fa fa-usd" aria-hidden="true"></i></p>
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="percentageGrandTotal" style="font-size:30px">
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="grandTotal">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row d-flex justify-center">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">APARTADO</h4>
                                                    <p class="text-center"><i
                                                                class="fa fa-hand-pointer-o" aria-hidden="true"></i></p>
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="percentageApartadoTotal"
                                                        style="font-size:30px">
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="apartadoTotal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row d-flex justify-center">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">CONTRATADO</h4>
                                                    <p class="text-center"><i class="fa fa-handshake-o" aria-hidden="true"></i></p>
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="percentageContratadoTotal"
                                                        style="font-size:30px">
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="contratadoTotal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row d-flex justify-end">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">CANCELADO</h4>
                                                    <p class="text-center">
                                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                                    </p>
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="percentageCanceladoTotal"
                                                        style="font-size:30px">
                                                    <input class="styles-tot" disabled="disabled" readonly="readonly"
                                                        type="text" id="canceladoTotal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="row d-flex align-end">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 pr-0">
                                            <select class="selectpicker select-gral" data-style="btn btn-primary btn-round"
                                                    title="Selecciona el tipo de venta" data-size="7" id="saleType">
                                                <option disabled selected>Selecciona una opción</option>
                                                <option value="1">Ventas área comercial</option>
                                                <option value="2">Marketing digital</option>
                                                <option value="3">Todo</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex justify-end">
                                            <div class="form-group d-flex">
                                                <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2022" />
                                                <input type="text" class="form-control datepicker" id="endDate" value="01/01/2022" />
                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                    <span class="material-icons update-dataTable">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="generalTable" name="generalTable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="encabezado">PLAZA</th>
                                                        <th>TOTAL</th>
                                                        <th># LOTES</th>
                                                        <th>APARTADO</th>
                                                        <th># LOTES APARTADOS</th>
                                                        <th>% APARTADOS</th>
                                                        <th>CONTRATADOS</th>
                                                        <th># LOTES CONTRATADOS</th>
                                                        <th>% CONTRATADOS</th>
                                                        <th>CANCELADOS</th>
                                                        <th># LOTES CANCELADOS</th>
                                                        <th>ACCIONES</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="material-datatables d-none" id="box-managerTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="managerTable" name="managerTable">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="encabezado">GERENTE</th>
                                                    <th>TOTAL</th>
                                                    <th># LOTES</th>
                                                    <th>APARTADO</th>
                                                    <th># LOTES APARTADOS</th>
                                                    <th>% APARTADOS</th>
                                                    <th>CONTRATADOS</th>
                                                    <th># LOTES CONTRATADOS</th>
                                                    <th>% CONTRATADOS</th>
                                                    <th>CANCELADOS</th>
                                                    <th># LOTES CANCELADOS</th>
                                                    <th>ACCIONES</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="material-datatables d-none" id="box-coordinatorTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-bordered table-striped"
                                                id="coordinatorTable" name="coordinatorTable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="encabezado">COORDINADOR</th>
                                                        <th>TOTAL</th>
                                                        <th># LOTES</th>
                                                        <th>APARTADO</th>
                                                        <th># LOTES APARTADOS</th>
                                                        <th>% APARTADOS</th>
                                                        <th>CONTRATADOS</th>
                                                        <th># LOTES CONTRATADOS</th>
                                                        <th>% CONTRATADOS</th>
                                                        <th>CANCELADOS</th>
                                                        <th># LOTES CANCELADOS</th>
                                                        <th>ACCIONES</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="material-datatables d-none" id="box-adviserTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="adviserTable" name="adviserTable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="encabezado">ASESOR</th>
                                                        <th>TOTAL</th>
                                                        <th># LOTES</th>
                                                        <th>APARTADO</th>
                                                        <th># LOTES APARTADOS</th>
                                                        <th>% APARTADOS</th>
                                                        <th>CONTRATADOS</th>
                                                        <th># LOTES CONTRATADOS</th>
                                                        <th>% CONTRATADOS</th>
                                                        <th>CANCELADOS</th>
                                                        <th># LOTES CANCELADOS</th>
                                                        <th>ACCIONES</th>
                                                        <th></th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>

    </div><!--main-panel close-->
    </body>
    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
    <script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <!-- Sliders Plugin -->
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <!--  Full Calendar Plugin    -->
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

    <script>

        $("#generalTable").ready(function () {
            $('#generalTable').on('xhr.dt', function (e, settings, json, xhr) {
                let total = 0;
                let apartado = 0;
                let contratado = 0;
                let cancelado = 0;
                $.each(json.data, function (i, v) {
                    total += parseFloat(v.total);
                    apartado += parseFloat(v.apartado);
                    contratado += parseFloat(v.contratado);
                    cancelado += parseFloat(v.cancelado);
                });
                document.getElementById("grandTotal").value = "$" + formatMoney(total);
                document.getElementById("apartadoTotal").value = "$" + formatMoney(apartado);
                document.getElementById("contratadoTotal").value = "$" + formatMoney(contratado);
                document.getElementById("canceladoTotal").value = "$" + formatMoney(cancelado);

                document.getElementById("percentageGrandTotal").value = (total * 100 / total).toFixed(2) + "%";
                document.getElementById("percentageApartadoTotal").value = (apartado * 100 / total).toFixed(2) + "%";
                document.getElementById("percentageContratadoTotal").value = (contratado * 100 / total).toFixed(2) + "%";
                document.getElementById("percentageCanceladoTotal").value = (cancelado * 100 / total).toFixed(2) + "%";
            });
        });

        $(document).ready(function () {
            fillTable(1, 'NA', 'NA', '#generalTable', 'NA', 1); // MJ: SEND THREE PARAMS; TYPE TRANSACTION -> 1 (FIRST TIME DATATABLE LOADING), BEGIN DATE -> NA & END DATE -> NA
            sp.initFormExtendedDatetimepickers();
            $('.datepicker').datetimepicker({locale: 'es'});
        });

        $('#generalTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#generalTable").DataTable().column(i).search() !== this.value) {
                    $("#generalTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#managerTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#managerTable").DataTable().column(i).search() !== this.value) {
                    $("#managerTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#coordinatorTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#coordinatorTable").DataTable().column(i).search() !== this.value) {
                    $("#coordinatorTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#adviserTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#adviserTable").DataTable().column(i).search() !== this.value) {
                    $("#adviserTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        sp = { // MJ: SELECT PICKER
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

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        function setFilters(table) { // MJ: COLOCA LOS FILTROS EN EL ENCABEZADO DE CADA TABLA, RECIBE COMO PARÁMETRO EL ID DE LA TABLA
            $('table thead tr:eq(0) th').each(function (i) {
                const title = $(this).text();
                $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if ($(table).DataTable().column(i).search() !== this.value) {
                        $(table).DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });
        }

        $(document).on('click', '.update-dataTable', function () {
            const type = $(this).attr("data-type");
            const beginDate = $("#beginDate").val();
            const endDate = $("#endDate").val();
            const saleType = $("#saleType").val();
            const where = $(this).val();
            let typeTransaction = 0;
            $("#inputId").val(where);

            if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
                typeTransaction = 1;
            else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
                typeTransaction = 2;
            else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
                typeTransaction = 3;
            else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
                typeTransaction = 4;

            if (type == 1) { // MJ: #generalTable
                const table = "#generalTable";
                fillTable(typeTransaction, beginDate, endDate, table, 0, 1);
                $("#box-managerTable").addClass('d-none');
            } else if (type == 2) { // MJ: #managerTable
                const table = "#managerTable";
                $("#box-managerTable").removeClass('d-none');
                $("#box-coordinatorTable").addClass('d-none');
                $("#box-adviserTable").addClass('d-none');
                fillTable(typeTransaction, beginDate, endDate, table, where, 2);
            } else if (type == 3) { // MJ: #coordinatorTable
                const table = "#coordinatorTable";
                $("#box-coordinatorTable").removeClass('d-none');
                $("#box-adviserTable").addClass('d-none');
                fillTable(typeTransaction, beginDate, endDate, table, where, 3);
            } else if (type == 4) { // MJ: #adviserTable
                const table = "#adviserTable";
                $("#box-adviserTable").removeClass('d-none');
                fillTable(typeTransaction, beginDate, endDate, table, where, 4);
            }
        });

        let generalDataTable;

        function fillTable(typeTransaction, beginDate, endDate, table, where, type) {
            let encabezado = (document.querySelector(table +' .encabezado .textoshead').placeholder).toUpperCase();
            generalDataTable = $(table).dataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                select: {
                    style: 'single'
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn btn-success buttons-excel',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 1:
                                            return encabezado;
                                            break;
                                        case 2:
                                            return 'TOTAL';
                                            break;
                                        case 3:
                                            return 'NO. LOTES'
                                        case 4:
                                            return 'APARTADO';
                                            break;
                                        case 5:
                                            return 'NO. LOTES APARTADOS';
                                            break;
                                        case 6:
                                            return '% APARTADOS';
                                            break;
                                        case 7:
                                            return 'CONTRATADOS';
                                            break;
                                        case 8:
                                            return 'NO. LOTES CONTRATADOS';
                                            break;
                                        case 9:
                                            return '% CONTRATADO';
                                            break;
                                        case 10:
                                            return 'CANCELADOS';
                                            break;
                                        case 11:
                                            return 'NO. LOTES CANCELADOS';
                                            break;
                                    }
                                }
                            }
                        }
                    },
                    {
                        text: "<i class='fa fa-bar-chart' aria-hidden='true'></i>",
                        className: "btn btn-azure build-general-chart",
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
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                    },
                    {
                        data: function (d) {
                            return d.nombre;
                        }
                    },
                    {
                        data: function (d) {
                            return "$" + formatMoney(d.total);
                        }
                    },
                    {
                        data: function (d) {
                            return d.totalLotes;
                        }
                    },
                    {
                        data: function (d) {
                            return "$" + formatMoney(d.apartado);
                        }
                    },
                    {
                        data: function (d) {
                            return d.totalApartados;
                        }
                    },
                    {
                        data: function (d) {
                            return d.porcentajeApartado + "%";
                        }
                    },
                    {
                        data: function (d) {
                            return "$" + formatMoney(d.contratado);
                        }
                    },
                    {
                        data: function (d) {
                            return d.totalContratados;
                        }
                    },
                    {
                        data: function (d) {
                            return d.porcentajeContratado + "%";
                        }
                    },
                    {
                        data: function (d) {
                            return "$" + formatMoney(d.cancelado);
                        }
                    },
                    {
                        data: function (d) {
                            return d.totalCancelados;
                        }
                    },
                    {
                        data: function (d) {
                            return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas update-dataTable" data-type="' + d.type + '" value="' + d.id + '"><i class="fas fa-sign-in-alt"></i></button></div>';
                        }
                    },
                    {
                        data: function (d) {
                            return d.id;
                        }
                    }
                ],
                columnDefs: [{
                    targets: [13],
                    visible: false,
                    searchable: false
                }],
                ajax: {
                    url: 'getInformation',
                    type: "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where,
                        "type": type,
                        "saleType": $("#saleType").val()
                    }
                }
            });

            // GENERAL TABLE ROWS DETAIL
            $('#generalTable tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = $("#generalTable").DataTable().row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } else {
                    if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                        let typeTransaction = 0;
                        let beginDate = $("#beginDate").val();
                        let endDate = $("#endDate").val();
                        const saleType = $("#saleType").val();
                        if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
                            typeTransaction = 1;
                        else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
                            typeTransaction = 2;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
                            typeTransaction = 3;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
                            typeTransaction = 4;
                        $.post("getDetails", {
                            "typeTransaction": typeTransaction,
                            "beginDate": beginDate,
                            "endDate": endDate,
                            "id": row.data().id,
                            "type": 1,
                            "saleType": $("#saleType").val()
                        }).done(function (data) {
                            row.data().solicitudes = JSON.parse(data);
                            $("#generalTable").DataTable().row(tr).data(row.data());
                            row = $("#generalTable").DataTable().row(tr);
                            row.child(buildTableDetail(row.data().solicitudes)).show();
                            tr.addClass('shown');
                            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");


                        });
                    } else {
                        row.child(buildTableDetail(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                    }

                }
            });

            // MANAGER TABLE ROWS DETAIL
            $('#managerTable tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = $("#managerTable").DataTable().row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } else {
                    if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                        let typeTransaction = 0;
                        let beginDate = $("#beginDate").val();
                        let endDate = $("#endDate").val();
                        const saleType = $("#saleType").val();
                        if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
                            typeTransaction = 1;
                        else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
                            typeTransaction = 2;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
                            typeTransaction = 3;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
                            typeTransaction = 4;
                        $.post("getDetails", {
                            "typeTransaction": typeTransaction,
                            "beginDate": beginDate,
                            "endDate": endDate,
                            "id": row.data().id,
                            "type": 2,
                            "saleType": $("#saleType").val()
                        }).done(function (data) {
                            row.data().solicitudes = JSON.parse(data);
                            $("#managerTable").DataTable().row(tr).data(row.data());
                            row = $("#managerTable").DataTable().row(tr);
                            row.child(buildTableDetail(row.data().solicitudes)).show();
                            tr.addClass('shown');
                            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                        });
                    } else {
                        row.child(buildTableDetail(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                    }

                }
            });

            // COORDINATOR TABLE ROWS DETAIL
            $('#coordinatorTable tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = $("#coordinatorTable").DataTable().row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } else {
                    if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                        let typeTransaction = 0;
                        let beginDate = $("#beginDate").val();
                        let endDate = $("#endDate").val();
                        let inputId = $("#inputId").val();
                        const saleType = $("#saleType").val();
                        if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
                            typeTransaction = 1;
                        else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
                            typeTransaction = 2;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
                            typeTransaction = 3;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
                            typeTransaction = 4;
                        $.post("getDetails", {
                            "typeTransaction": typeTransaction,
                            "beginDate": beginDate,
                            "endDate": endDate,
                            "id": row.data().id,
                            "idTwo": inputId,
                            "type": 3,
                            "saleType": $("#saleType").val()
                        }).done(function (data) {
                            row.data().solicitudes = JSON.parse(data);
                            $("#coordinatorTable").DataTable().row(tr).data(row.data());
                            row = $("#coordinatorTable").DataTable().row(tr);
                            row.child(buildTableDetail(row.data().solicitudes)).show();
                            tr.addClass('shown');
                           $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                        });
                    } else {
                        row.child(buildTableDetail(row.data().solicitudes)).show();
                        tr.addClass('shown');
                       $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                    }

                }
            });

            // ADVISER TABLE ROWS DETAIL
            $('#adviserTable tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = $("#adviserTable").DataTable().row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } else {
                    if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                        let typeTransaction = 0;
                        let beginDate = $("#beginDate").val();
                        let endDate = $("#endDate").val();
                        const saleType = $("#saleType").val();
                        if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
                            typeTransaction = 1;
                        else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
                            typeTransaction = 2;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
                            typeTransaction = 3;
                        else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
                            typeTransaction = 4;
                        $.post("getDetails", {
                            "typeTransaction": typeTransaction,
                            "beginDate": beginDate,
                            "endDate": endDate,
                            "id": row.data().id,
                            "type": 4,
                            "saleType": $("#saleType").val()
                        }).done(function (data) {
                            row.data().solicitudes = JSON.parse(data);
                            $("#adviserTable").DataTable().row(tr).data(row.data());
                            row = $("#adviserTable").DataTable().row(tr);
                            row.child(buildTableDetail(row.data().solicitudes)).show();
                            tr.addClass('shown');
                            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                        });
                    } else {
                        row.child(buildTableDetail(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                    }

                }
            });

            function buildTableDetail(data) {
                var solicitudes = '<table class="table subBoxDetail">';
                solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
                solicitudes += '<td>' + '<b>' + 'PLAZA ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + 'APARTADO ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + '# LOTES ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + 'CONTRATADO ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + '# LOTES ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + 'CANCELADO ' + '</b></td>';
                solicitudes += '<td>' + '<b>' + '# LOTES ' + '</b></td>';
                solicitudes += '</tr>';
                $.each(data, function (i, v) {
                    //i es el indice y v son los valores de cada fila
                    solicitudes += '<tr>';
                    solicitudes += '<td> ' + v.nombre + ' </td>';
                    solicitudes += '<td> $' + formatMoney(v.apartado) + ' </td>';
                    solicitudes += '<td> ' + v.totalApartados + ' </td>';
                    solicitudes += '<td> $' + formatMoney(v.contratado) + ' </td>';
                    solicitudes += '<td> ' + v.totalContratados + ' </td>';
                    solicitudes += '<td> $' + formatMoney(v.cancelado) + ' </td>';
                    solicitudes += '<td> ' + v.totalCancelados + ' </td>';
                    solicitudes += '</tr>';

                });
                return solicitudes += '</table>';
            }

        }

        let totalGeneral = 0
        let totalApartado = 0
        let totalContratado = 0
        let totalGeneralCancelado = 0

        $('#generalTable').on('click', 'input', function () {
            tr = $(this).closest('tr');
            var row = $("#generalTable").DataTable().row(tr).data();
            if (row.pa == 0) {
                row.pa = row.total;
                row.pa2 = row.apartado;
                row.pa3 = row.contratado;
                row.pa4 = row.cancelado;
                totalGeneral += parseFloat(row.pa);
                totalApartado += parseFloat(row.pa2);
                totalContratado += parseFloat(row.pa3);
                totalGeneralCancelado += parseFloat(row.pa4);

                tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
            } else {
                totalGeneral -= parseFloat(row.pa);
                totalApartado -= parseFloat(row.pa2);
                totalContratado -= parseFloat(row.pa3);
                totalGeneralCancelado -= parseFloat(row.pa4);
                row.pa = 0;
                row.pa2 = 0;
                row.pa3 = 0;
                row.pa4 = 0;
            }
            document.getElementById("grandTotal").value = "$" + formatMoney(totalGeneral);
            document.getElementById("apartadoTotal").value = "$" + formatMoney(totalApartado);
            document.getElementById("contratadoTotal").value = "$" + formatMoney(totalContratado);
            document.getElementById("canceladoTotal").value = "$" + formatMoney(totalGeneralCancelado);

            document.getElementById("percentageGrandTotal").value = "%" + (totalGeneral * 100 / totalGeneral).toFixed(2);
            document.getElementById("percentageApartadoTotal").value = "%" + (totalApartado * 100 / totalGeneral).toFixed(2);
            document.getElementById("percentageContratadoTotal").value = "%" + (totalContratado * 100 / totalGeneral).toFixed(2);
            document.getElementById("percentageCanceladoTotal").value = "%" + (totalGeneralCancelado * 100 / totalGeneral).toFixed(2);
        });

        $(document).on('click', '.build-general-chart', function () {
            const beginDate = $("#beginDate").val();
            const endDate = $("#endDate").val();
            let typeTransaction = 0;
            if (beginDate == '01/01/2022' && endDate == '01/01/2022')
                typeTransaction = 1;
            else
                typeTransaction = 2;
            buildGeneralGraph(typeTransaction, beginDate, endDate, 0, 1);
            $('#generalChartModal').modal();
        });

        function buildGeneralGraph(typeTransaction, beginDate, endDate, where, type) {
            $.ajax({
                type: 'POST',
                url: 'getInformation',
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where,
                    "type": type
                },
                dataType: 'json',
                success: function (dataReceived) {
                    const nombre = dataReceived.data.map(function (data1) {
                        return data1.nombre;
                    });
                    const total = dataReceived.data.map(function (data2) {
                        return data2.total;
                    });
                    const apartado = dataReceived.data.map(function (data3) {
                        return data3.apartado;
                    });
                    const cancelado = dataReceived.data.map(function (data4) {
                        return data4.cancelado;
                    });
                    const contratado = dataReceived.data.map(function (data5) {
                        return data5.contratado;
                    });

                    const finalTotal = total.map(Number);
                    const finalTotalApartado = apartado.map(Number);
                    const finalTotalCancelado = cancelado.map(Number);
                    const finalTotalContratado = contratado.map(Number);

                    fillTotalChart(nombre, finalTotal, finalTotalApartado, finalTotalCancelado, finalTotalContratado);

                    console.log(nombre);
                    console.log(finalTotal);
                    console.log(finalTotalApartado);
                    console.log(finalTotalCancelado);
                    console.log(finalTotalContratado);

                }, error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        function fillTotalChart(nombre, finalTotal, finalTotalApartado, finalTotalCancelado, finalTotalContratado) {
            const finalData = {
                labels: nombre,
                datasets: [
                    {
                        data: finalTotalApartado,
                        label: "Apartados",
                        backgroundColor: [
                            'rgba(17, 120, 100, 0.2)'
                        ],
                        borderColor: [
                            'rgb(17, 120, 100)',
                        ],
                        borderWidth: 1,
                        fill: false
                    }, {
                        data: finalTotalContratado,
                        label: "Contratados",
                        backgroundColor: [
                            'rgba(46, 204, 113 , 0.2)'
                        ],
                        borderColor: [
                            'rgb(46, 204, 113)',
                        ],
                        borderWidth: 1,
                        fill: false
                    }, {
                        data: finalTotalCancelado,
                        label: "Cancelados",
                        backgroundColor: [
                            'rgba(46, 134, 193 , 0.2)'
                        ],
                        borderColor: [
                            'rgb(46, 134, 193)',
                        ],
                        borderWidth: 1,
                        fill: false
                    }
                ]
            };

            const ctx = document.getElementById("myLineChart").getContext("2d");
            let myLineChart = new Chart(ctx, {
                type: 'line',
                data: finalData,
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });
        }
    </script>