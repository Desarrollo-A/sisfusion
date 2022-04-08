<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar', ""); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>

                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Comisiones detenidas</h3>
                                    <p class="card-title pl-1">
                                        (Comisiones sin saldo disponible en NEODATA, ya dispersadas con anterioridad)
                                    </p>
                                </div>

                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                   id="comisiones-detenidas-table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID LOTE</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>TIPO VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>EST. CONTRATACIÓN</th>
                                                        <th>MOTIVO</th>
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

    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        const baseUrl = '<?=base_url()?>';
        const urlIndex = `${baseUrl}index.php/`;

        $('#comisiones-detenidas-table').ready(function () {
            let titulos = [];

            $('#comisiones-detenidas-table thead tr:eq(0) th').each(function (i) {
                if (i !== 0 && i !== 9) {
                    const title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (comisionesDetenidasTabla.column(i).search() !== this.value) {
                            comisionesDetenidasTabla.column(i).search(this.value).draw();
                        }
                    });
                }
            });

            let comisionesDetenidasTabla = $('#comisiones-detenidas-table').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: "<i class='fa fa-file-excel-o' aria-hidden='true'></i>",
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header: function (d, columnIdx) {
                                if (columnIdx === 0) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx === 10) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx !== 10 && columnIdx !== 0) {
                                    if (columnIdx === 11) {
                                        return 'SEDE ';
                                    }
                                    if (columnIdx === 12) {
                                        return 'TIPO'
                                    } else {
                                        return ' ' + titulos[columnIdx - 1] + ' ';
                                    }
                                }
                            }
                        }
                    }
                }],
                pagingType: 'full_numbers',
                fixedHeader: true,
                language: {
                    url: baseUrl+'/static/spanishLoader_v2.json',
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [
                    {
                        'width': '3%',
                        'className': 'details-control',
                        'orderable': false,
                        'data' : null,
                        'defaultContent': `
                            <div class='toggle-subTable'>
                                <i class='animacion fas fa-chevron-down fa-lg'></i>
                            </div>
                        `
                    },
                    {
                        'width': '8%',
                        'data': function( d ) {
                            return '<p class="m-0"><b>'+d.idLote+'</b></p>';
                        }
                    },
                    {
                        'width': '9%',
                        'data': function( d ){
                            return '<p class="m-0">'+d.nombreResidencial+'</p>';
                        }
                    },
                    {
                        "width": "10%",
                        "data": function( d ){
                            return '<p class="m-0">'+(d.nombreCondominio).toUpperCase()+'</p>';
                        }
                    },
                    {
                        'width': '15%',
                        'data': function( d ){
                            return '<p class="m-0">'+d.nombreLote+'</p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            if (d.tipo_venta === 1) {
                                return '<span class="label label-danger">Venta Particular</span>';
                            }else if (d.tipo_venta === 2) {
                                return '<span class="label label-success">Venta normal</span>';
                            } else if (d.tipo_venta === 7) {
                                return '<span class="label label-warning">Venta especial</span>';
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        'width': '8%',
                        'data': function( d ){
                            if (d.compartida === null) {
                                return '<span class="label label-warning" style="background:#E5D141;">Individual</span>';
                            } else {
                                return '<span class="label label-warning">Compartida</span>';
                            }
                        }
                    },
                    {
                        'width': '8%',
                        'data': function( d ){
                            if (d.idStatusContratacion === 15) {
                                return '<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';
                            } else {
                                return '<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
                            }
                        }
                    },
                    {
                        'width': '15%',
                        'orderable': false,
                        'data': function (d) {
                            return '<p class="m-0"><b>'+d.motivo+'</b></p>';
                        }
                    }
                ],
                columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                ajax: {
                    'url': urlIndex+'Comisiones/getStoppedCommissions',
                    'dataSrc': '',
                    'type': 'GET',
                    cache: false,
                    'data': function (d) {}
                },
            });

            $('#comisiones-detenidas-table tbody').on('click', 'td.details-control', function () {
                const tr = $(this).closest('tr');
                const row = comisionesDetenidasTabla.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } else {
                    row.child(`
                        <div class="container subBoxDetail">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-sm-12 col-lg-12"
                                    style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                                    <label><b>Descripción</b></label>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12"
                                    style="padding: 10px 30px 0 30px;">
                                    <label>` + row.data().comentario + `</label>
                                </div>
                            </div>
                        </div>
                    `).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                }
            });
        });
    </script>

</body>
