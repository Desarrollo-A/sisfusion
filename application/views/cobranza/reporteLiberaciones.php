<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper ">

    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-trash fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Reporte de liberaciones</h3>
                            <br>
                            <div class="material-datatables" id="box-reporteLiberacionesTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="reporteLiberacionesTable" name="reporteLiberacionesTable">
                                            <thead>
                                            <tr>
                                            <th>ID LOTE</th>
                                            <th>LOTE</th>
                                            <th>FECHA A. OLD</th>
                                            <th>ID CLIENTE</th>
                                            <th>CLIENTE OLD</th>
                                            <th>LP OLD</th>
                                            <th>ASESOR OLD</th>
                                            <th>SEDE OLD</th>
                                            <th>ÚLTIMO ESTATUS</th>
                                            <th>ÚLTIMA LIBERACIÓN</th>
                                            <th>MOTIVO LIBERACIÓN</th>
                                            <th>ESTATUS ACTUAL LOTE</th>
                                            <th>FECHA A. ACTUAL</th>
                                            <th>ESTATUS ACTUAL CONTRATACIÓN</th>
                                            <th>CLIENTE ACTUAL</th>
                                            <th>LP ACTUAL</th>
                                            <th>ASESOR ACTUAL</th>
                                            <th>SEDE ACTUAL</th>
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
</div><!--main-panel close-->

<?php $this->load->view('template/footer'); ?>
<script>
    $(document).ready(function () {
        fillTable();
    });

    $('#reporteLiberacionesTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        if (i != 14) {
            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#reporteLiberacionesTable").DataTable().column(i).search() !== this.value) {
                    $("#reporteLiberacionesTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    function fillTable(typeTransaction, beginDate, endDate, where) {
        generalDataTable = $('#reporteLiberacionesTable').dataTable({
            dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID LOTE';
                                        break;
                                    case 1:
                                        return 'LOTE';
                                        break;
                                    case 2:
                                        return 'FECHA A.OLD';
                                        break;
                                    case 3:
                                        return 'ID CLIENTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE OLD'
                                    case 5:
                                        return 'LP OLD';
                                        break;
                                    case 6:
                                        return 'ASESOR OLD';
                                        break;
                                    case 7:
                                        return 'SEDE OLD';
                                        break;
                                    case 8:
                                        return 'ÚLTIMO ESTATUS';
                                        break;
                                    case 9:
                                        return 'ÚLTIMA LIBERACIÓN';
                                        break;
                                    case 10:
                                        return 'MOTIVO LIBERACIÓN';
                                        break;
                                    case 11:
                                        return 'ESTATUS ACTUAL LOTE';
                                        break;
                                    case 12:
                                        return 'FECHA A. ACTUAL';
                                        break;
                                    case 13:
                                        return 'ESTATUS ACTUAL CONTRATACIÓN';
                                        break;
                                    case 14:
                                        return 'CLIENTE ACTUAL';
                                        break;
                                    case 15:
                                        return 'LP ACTUAL';
                                        break;
                                    case 16:
                                        return 'ASESOR ACTUAL';
                                        break;
                                    case 17:
                                        return 'SEDE ACTUAL';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
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
                        return d.idLote;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreLote;
                    }
                },
                {
                    data: function (d) {
                        return d.fechaApartadoOld;
                    }
                },
                {
                    data: function (d) {
                        return d.id_cliente;
                    }
                },
                {
                    data: function (d) {
                        return d.nombre_cliente_old;
                    }
                },
                {
                    data: function (d) {
                        return d.lugar_prospeccion_old;
                    }
                },
                {
                    data: function (d) {
                        return d.nombre_asesor_old;
                    }
                },
                {
                    data: function (d) {
                        return d.sede_old;
                    }
                },
                {
                    data: function (d) {
                        return d.ultimoEstatusContratacion;
                    }
                },
                {
                    data: function (d) {
                        return d.fecha_liberacion;
                    }
                },
                {
                    data: function (d) {
                        return d.motivo_liberacion;
                    }
                },
                {
                    data: function (d) {
                        return d.estatusActualLote;
                    }
                },
                {
                    data: function (d) {
                        return d.fechaApartadoNew;
                    }
                },
                {
                    data: function (d) {
                        return d.estatusActualContratacion;
                    }
                },
                {
                    data: function (d) {
                        return d.nombre_cliente_new;
                    }
                },
                {
                    data: function (d) {
                        return d.lugar_prospeccion_new;
                    }
                },
                {
                    data: function (d) {
                        return d.nombre_asesor_new;
                    }
                },
                {
                    data: function (d) {
                        return d.sede_new;
                    }
                },
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: 'getReporteLiberaciones',
                type: "POST",
                cache: false
            }
        });
    }
</script>
</body>