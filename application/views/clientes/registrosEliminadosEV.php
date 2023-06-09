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
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Lotes eliminados en la lista de evidencias</h3>
                                <div class="table-responsive">
                                    <table id="autorizarEvidencias" class="table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>COMENTARIO</th>
                                            <th>CLIENTE</th>
                                            <th>USUARIO</th>
                                            <th>FECHA</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
    <script>
        $(document).ready (function() {

            /*agregar input de buscar al header de la tabla*/
            let titulos_intxt = [];
            $('#autorizarEvidencias thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                titulos_intxt.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#autorizarEvidencias').DataTable().column(i).search() !== this.value ) {
                        $('#autorizarEvidencias').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table;
            table = $('#autorizarEvidencias').DataTable( {
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                header:  function (d, columnIdx) {
                                    return ' '+titulos_intxt[columnIdx] +' ';
                                }
                            }
                        }
                    },
                ],
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                ajax: "<?=base_url()?>index.php/Asesor/getDeletedLotesEV/",
                columns: [
                    { "data": "nombreLote" },
                    { "data": "idLote" },
                    { 
                        "data": function( d )
                        {
                            return '<p class="m-0"><i> "'+d.observacion+'"</i></p>';
                        }
                    },
                    { "data": "nombreCliente" },
                    { "data": "nombreSolicitante" },
                    { "data": "fecha_creacion" },
                ],
                columnDefs: [{
                    visible: false,
                    searchable: false
                }],
            });
        });
    </script>
</body>