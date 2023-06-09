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
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de estatus por prospecto</h3>
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
                                            <table id="mktdProspectsTable" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ESTADO</th>
                                                        <th>ETAPA</th>
                                                        <th>PROSPECTO</th>
                                                        <th>MEDIO</th>
                                                        <th>ASESOR</th>
                                                        <th>GERENTE</th>
                                                        <th>CREACIÓN</th>
                                                        <th>VENCIMIENTO</th>
                                                        <th>ÚLTIMA MODIFICACIÓN</th>
                                                        <th>ACCIONES</th>
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


        <div class="content hide">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Reporte de estatus por prospecto</h4>
                                                <div class="table-responsive">
                                                    <div class="material-datatables">

                                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div id="external_filter_container18"><b> Búsqueda por fecha </b></div>
                                                            <br>
                                                            <div id="external_filter_container7"></div>
                                                            <br><br>
                                                        </div>

                                                        <table id="mktdProspectsTable" class="table table-striped table-no-bordered table-hover" style="text-align:center;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Estado</th>
                                                                    <th>Etapa</th>
                                                                    <th>Prospecto</th>
                                                                    <th>Medio</th>
                                                                    <th>Asesor</th>
                                                                    <th>Gerente</th>
                                                                    <th>Creación</th>
                                                                    <th>Vencimiento</th>
                                                                    <th>Última modificación</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>

                                                        <div class="modal fade" id="seeCommentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                            <i class="material-icons" onclick="cleanComments()">clear</i>
                                                                        </button>
                                                                        <h4 class="modal-title">Consulta información</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div role="tabpanel">
                                                                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                                                                <li role="presentation" class="active"><a href="#commentsTab" aria-controls="commentsTab" role="tab" data-toggle="tab">Comentarios</a></li>
                                                                                <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                                                                            </ul>
                                                                            <div class="tab-content">

                                                                                <div role="tabpanel" class="tab-pane active" id="commentsTab">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="card card-plain">
                                                                                                <div class="card-content">
                                                                                                    <ul class="timeline timeline-simple" id="comments-list"></ul>
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
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
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
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
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
<script src="<?= base_url() ?>dist/js/controllers/mktd-1.1.0.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

<script>
    $('#mktdProspectsTable thead tr:eq(0) th').each(function (i) {

        if (i != 0 && i != 9) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value) {
                    $('#mktdProspectsTable').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    // let titulos = [];
    // $('#mktdProspectsTable thead tr:eq(0) th').each(function(i) {
    //     if (i != 0 && i != 13) {
    //         var title = $(this).text();

    //         titulos.push(title);
    //     }
    // });

    $(document).ready(function(){
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
        // $("#beginDate").val(finalBeginDate);
        // $("#endDate").val(finalEndDate);
        fillTable(1, finalBeginDate, finalEndDate, 0);
    }

    // $('#mktdProspectsTable thead tr:eq(0) th').each(function (i) {
    //         // const title = $(this).text();
    //         if (i != 0 && i != 7) {
    //             var title = $(this).text();
    //             //
    //             // titulos.push(title);
    //             $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
    //             $('input', this).on('keyup change', function () {
    //                 if ($("#mktdProspectsTable").DataTable().column(i).search() !== this.value) {
    //                     $("#mktdProspectsTable").DataTable()
    //                         .column(i)
    //                         .search(this.value)
    //                         .draw();
    //                 }
    //             });
    //         }
    //
    //
    //     });
    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);
    });

    var mktdProspectsTable
    function fillTable(typeTransaction, beginDate, endDate, where) {
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);
        mktdProspectsTable = $('#mktdProspectsTable').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reporte de estatus por prospecto',
                title:'Reporte de estatus por prospecto',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'ESTADO';
                                    break;
                                case 1:
                                    return 'ETAPA';
                                    break;
                                case 2:
                                    return 'PROSPECTO';
                                case 3:
                                    return 'MEDIO';
                                    break;
                                case 4:
                                    return 'ASESOR';
                                    break;
                                case 5:
                                    return 'GERENTE';
                                    break;
                                case 6:
                                    return 'CREACIÓN';
                                    break;
                                case 7:
                                    return 'VENCIMIENTO';
                                    break;
                                case 8:
                                    return 'ÚLT. MODIFICACIÓN';
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
            columns:
                [
                    {
                        data: function(d) {
                            if (d.estatus == 1) {
                                return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                            } else {
                                return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                            }
                        }
                    },
                    {
                        data: function(d) {
                            if (d.estatus_particular == 1) { // DESCARTADO
                                b = '<center><span class="label label-danger" style="background:#E74C3C">Descartado</span><center>';
                            } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                                b = '<center><span class="label label-danger" style="background:#B7950B">Interesado sin cita</span><center>';
                            } else if (d.estatus_particular == 3) { // CON CITA
                                b = '<center><span class="label label-danger" style="background:#27AE60">Con cita</span><center>';
                            } else if (d.estatus_particular == 5) { // PAUSADO
                                b = '<center><span class="label label-danger" style="background:#2E86C1">Pausado</span><center>';
                            } else if (d.estatus_particular == 6) { // PREVENTA
                                b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                            }
                            return b;
                        }
                    },
                    {
                        data: function(d) {
                            return d.nombre;
                        }
                    },
                    {
                        data: function(d) {
                            return d.otro_lugar;
                        }
                    },
                    {
                        data: function(d) {
                            return d.asesor;
                        }
                    },
                    {
                        data: function(d) {
                            return d.gerente;
                        }
                    },
                    {
                        data: function(d) {
                            return d.fecha_creacion;
                        }
                    },
                    {
                        data: function(d) {
                            return d.fecha_vencimiento;
                        }
                    },
                    {
                        data: function(d) {
                            return d.fecha_modificacion;
                        }
                    },
                    {
                        data: function(d) {
                            return '<center><button class="btn-data btn-details-grey see-comments" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-ellipsis-h"></i></button></center>';
                        }
                    }
                ],
            "ajax": {
                // "url": "getProspectsReport",
                "url" : "getProspectsReport",
                "type": "POST",
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


    // $(document).ready(function() {
        //mktdProspectsTable = $('#mktdProspectsTable').DataTable({
        //    dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        //    buttons: [{
        //        extend: 'excelHtml5',
        //        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        //        className: 'btn buttons-excel',
        //        titleAttr: 'Reporte de estatus por prospecto',
        //        title:'Reporte de estatus por prospecto',
        //        exportOptions: {
        //            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        //            format: {
        //                header: function (d, columnIdx) {
        //                    switch (columnIdx) {
        //                        case 0:
        //                            return 'ESTADO';
        //                            break;
        //                        case 1:
        //                            return 'ETAPA';
        //                            break;
        //                        case 2:
        //                            return 'PROSPECTO';
        //                        case 3:
        //                            return 'MEDIO';
        //                            break;
        //                        case 4:
        //                            return 'ASESOR';
        //                            break;
        //                        case 5:
        //                            return 'GERENTE';
        //                            break;
        //                        case 6:
        //                            return 'CREACIÓN';
        //                            break;
        //                        case 7:
        //                            return 'VENCIMIENTO';
        //                            break;
        //                        case 8:
        //                            return 'ÚLT. MODIFICACIÓN';
        //                            break;
        //                    }
        //                }
        //            }
        //        }
        //    }],
        //    pagingType: "full_numbers",
        //    lengthMenu: [
        //        [10, 25, 50, -1],
        //        [10, 25, 50, "Todos"]
        //    ],
        //    language: {
        //        url: "<?//=base_url()?>///static/spanishLoader_v2.json",
        //        paginate: {
        //            previous: "<i class='fa fa-angle-left'>",
        //            next: "<i class='fa fa-angle-right'>"
        //        }
        //    },
        //    columnDefs: [{
        //        defaultContent: "Sin especificar",
        //        targets: "_all",
        //        searchable: true,
        //        orderable: false
        //    }],
        //    destroy: true,
        //    ordering: false,
        //    columns:
        //    [
        //        {
        //            data: function(d) {
        //                if (d.estatus == 1) {
        //                    return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
        //                } else {
        //                    return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
        //                }
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                if (d.estatus_particular == 1) { // DESCARTADO
        //                    b = '<center><span class="label label-danger" style="background:#E74C3C">Descartado</span><center>';
        //                } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
        //                    b = '<center><span class="label label-danger" style="background:#B7950B">Interesado sin cita</span><center>';
        //                } else if (d.estatus_particular == 3) { // CON CITA
        //                    b = '<center><span class="label label-danger" style="background:#27AE60">Con cita</span><center>';
        //                } else if (d.estatus_particular == 5) { // PAUSADO
        //                    b = '<center><span class="label label-danger" style="background:#2E86C1">Pausado</span><center>';
        //                } else if (d.estatus_particular == 6) { // PREVENTA
        //                    b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
        //                }
        //                return b;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.nombre;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.otro_lugar;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.asesor;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.gerente;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.fecha_creacion;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.fecha_vencimiento;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return d.fecha_modificacion;
        //            }
        //        },
        //        {
        //            data: function(d) {
        //                return '<button class="btn-data btn-details-grey see-comments" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-ellipsis-h"></i></button>';
        //            }
        //        }
        //    ],
        //    "ajax": {
        //        // "url": "getProspectsReport",
        //        "url" : "getProspectsReportv2"
        //        "type": "POST",
        //        cache: false,
        //        "data": function(d) {}
        //    }
        //});

        /*.yadcf(
            [
                {
                    column_number: 6,
                    filter_container_id: 'external_filter_container7',
                    filter_type: 'range_date',
                    datepicker_type: 'bootstrap-datetimepicker',
                    filter_default_label: ['Desde', 'Hasta'],
                    date_format: 'YYYY-MM-DD',
                    filter_plugin_options: {
                        format: 'YYYY-MM-DD',
                        showClear: true,
                    }
                },
            ]
        )*/
        // yadcf.init(mktdProspectsTable,
        //     [{
        //         column_number: 6,
        //         filter_container_id: 'external_filter_container7',
        //         filter_type: 'range_date',
        //         datepicker_type: 'bootstrap-datetimepicker',
        //         filter_default_label: ['Desde', 'Hasta'],
        //         date_format: 'YYYY-MM-DD',
        //         filter_plugin_options: {
        //             format: 'YYYY-MM-DD',
        //             showClear: true,
        //         }
        //     }]);
    // });
</script>


<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>

</html>