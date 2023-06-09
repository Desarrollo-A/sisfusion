<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar');   ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de clientes</h3>
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
                            <div class="material-datatables" id="box-masterCobranzaTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="clients_report_datatable" class="table-striped table-hover"><!--table table-bordered table-hover -->
                                            <thead>
                                            <tr>
                                                <th><center>PROYECTO</center></th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID lote</th>
                                                <th>CLIENTE</th>
                                                <th>MEDIO</th>
                                                <th>PLAZA</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>TOTAL</th>
                                                <th>ENGANCHE</th>
                                                <th>PLAN ENGANCHE</th>
                                                <th>FECHA APARTADO</th>
                                                <th>FECHA ESTATUS 9</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <?php include 'common_modals.php' ?>
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
                                            <h4 class="card-title"><b>Listado general de clientes</b></h4>
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
                                                    <table id="clients_report_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th data-toggle="tooltip" data-placement="right" title="Proyecto"><center>Proyecto</center></th>
                                                            <th data-toggle="tooltip" data-placement="right" title="Condominio"><center>Condominio</center></th>
                                                            <th data-toggle="tooltip" data-placement="right" title="Lote"><center>Lote</center></th>
                                                            <th data-toggle="tooltip" data-placement="right" title="ID lote"><center>ID lote</center></th>
                                                            <th data-toggle="tooltip" data-placement="right" title="Cliente"><center>Cliente</center></th>
                                                            <th data-toggle="tooltip" data-placement="right" title="Medio"><center>Medio</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Plaza"><center>Plaza</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Asesor"><center>Asesor</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Asesor"><center>Coordinador</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Gerente"><center>Gerente</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Total"><center>Total</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Enganche"><center>Enganche</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Plan enganche"><center>Plan enganche</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Fecha apartado"><center>Fecha apartado</center></th>
                                                            <th data-toggle="tooltip" data-placement="left" title="Fecha estatus 15"><center>Fecha estatus 9</center></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                    <?php include 'common_modals.php' ?>
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
        setInitialValues();
    });
    sp = { //  SELECT PICKER
        initFormExtendedDatetimepickers: function () {
            $('.datepicker').datetimepicker({
                format: 'DD/MM/YYYY',
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

    $('#clients_report_datatable thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#clients_report_datatable').DataTable().column(i).search() !== this.value ) {
                $('#clients_report_datatable').DataTable().column(i).search(this.value).draw();
            }
        });
    });

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

    function fillDataTable(typeTransaction, beginDate, endDate, where){
        var clients_report_datatable = $('#clients_report_datatable').dataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Listado general de clientes',
                    title:'Listado general de clientes',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'Proyecto';
                                        break;
                                    case 1:
                                        return 'Condominio';
                                        break;
                                    case 2:
                                        return 'Lote'
                                    case 3:
                                        return 'ID lote';
                                        break;
                                    case 4:
                                        return 'Medio';
                                        break;
                                    case 5:
                                        return 'Plaza';
                                        break;
                                    case 6:
                                        return 'Asesor';
                                        break;
                                    case 7:
                                        return 'Coordinador';
                                        break;
                                    case 8:
                                        return 'Gerente';
                                        break;
                                    case 9:
                                        return 'Total';
                                        break;
                                    case 10:
                                        return 'Enganche';
                                        break;
                                    case 11:
                                        return 'Plan de enganche';
                                        break;
                                    case 12:
                                        return 'Fecha apartado';
                                        break;
                                    case 13:
                                        return 'Fecha estatus 15';
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
                { data: function (d) {
                        return d.nombreResidencial;
                    }
                },
                { data: function (d) {
                        return d.nombreCondominio;
                    }
                },
                { data: function (d) {
                        return d.nombreLote;
                    }
                },
                { data: function (d) {
                        return d.idLote;
                    }
                },
                { data: function (d) {
                        return d.nombreCliente;
                    }
                },
                { data: function (d) {
                        return d.lp;
                    }
                },
                { data: function (d) {
                        return d.plaza;
                    }
                },
                { data: function (d) {
                        return d.nombreAsesor;
                    }
                },
                { data: function (d) {
                        return d.nombreCoordinador;
                    }
                },
                { data: function (d) {
                        return d.nombreGerente;
                    }
                },
                { data: function (d) {
                        return formatMoney(d.totalNeto2);
                    }
                },
                { data: function (d) {
                        return formatMoney(d.enganche);
                    }
                },
                { data: function (d) {
                        return d.planEnganche;
                    }
                },
                { data: function (d) {
                        return d.fechaApartado;
                    }
                },
                { data: function (d) {
                        return d.fechaEstatusQuince;
                    }
                }
            ],
            "ajax": {
                "url": 'getClientsReportMktd',
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

    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillDataTable(3, finalBeginDate, finalEndDate, 0);
    });

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
</html>
