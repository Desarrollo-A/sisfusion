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
                                <h3 class="card-title center-align" id="showDate"></h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="mktdProspectsTable"
                                                class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>RESIDENCIAL</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>SUPERFICIE</th>
                                                        <th>PRECIO m<sup>2</sup></th>
                                                        <th>COSTO TOTAL</th>
                                                        <th>REFERENCIA</th>
                                                        <th>ASESOR</th>
                                                        <th>COORDINADOR</th>
                                                        <th>GERENTE</th>
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
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/mktd-1.1.0.js"></script>

    <script>
        $(document).ready(function () {
            $.ajax({
                post: "POST",
                url: "<?=site_url() . '/registroLote/getDateToday/'?>"
            }).done(function (data) {
                $('#showDate').append('Reporte general de clientes al día de hoy: ' + data);
            }).fail(function () {});
        });

        let titulos = [];
        $('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');

            $( 'input', this ).on('keyup change', function () {
                if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value ) {
                    $('#mktdProspectsTable').DataTable().column(i).search(this.value).draw();
                }
            });
        });
        var mktdProspectsTable

        $(document).ready(function () {
            mktdProspectsTable = $('#mktdProspectsTable').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        format: {
                            header:  function (d, columnIdx) {
                                return ' '+titulos[columnIdx] +' ';
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Descargar archivo PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        format: {
                            header:  function (d, columnIdx) {
                                return ' '+titulos[columnIdx] +' ';
                            }
                        }
                    }
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                }],
                columns: [{
                    data: function (d) {
                        return d.nombreResidencial;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreCondominio;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreLote;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreCliente;
                    }
                },
                {
                    data: function (d) {
                        return d.sup;
                    }
                },
                {
                    data: function (d) {
                        return d.precio;
                    }
                },
                {
                    data: function (d) {
                        if (d.totalNeto2 == 'null' || d.totalNeto2 == '' || d.totalNeto2 == '0.00' || d.totalNeto2 == null || d.totalNeto2 == '.00') {
                            return '$0.00';
                        } else {
                            return '$' + d.totalNeto2;
                        }
                    }
                },
                {
                    data: function (d) {
                        return d.referencia;
                    }
                },
                {
                    data: function (d) {
                        return d.asesor;
                    }
                },
                {
                    data: function (d) {
                        return d.coordinador;
                    }
                },
                {
                    data: function (d) {
                        return d.gerente;
                    }
                }],
                ajax: {
                    url: "getGeneralClientsReport",
                    type: "POST",
                    cache: false,
                    data: function (d) {
                    }
                }
            });
        });
    </script>
</body>