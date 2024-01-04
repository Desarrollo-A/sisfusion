<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>

        <!-- modals -->
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
        <!-- END modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte CLUB MADERAS</h3>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="mktdProspectsTable" class="table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>TIPO</th>
                                                <th>NOMBRE</th>
                                                <th>TELÉFONO</th>
                                                <th>CORREO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>MONTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>ALTA</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div><!--main-panel close-->

    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>
    <script>
        $('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            if ( i != 12) {
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value ) {
                        $('#mktdProspectsTable').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        var mktdProspectsTable
        $(document).ready(function () {
            mktdProspectsTable = $('#mktdProspectsTable').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                    }
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
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                columns: [{
                    data: function (d) {
                        if (d.tipo == 1) { // IS CLIENT
                            return '<center><span class="label" style="background:#66BB6A">Cliente</span><center>';
                        } else { // IS PROSPECT
                            return '<center><span class="label" style="background:#2E86C1">Prospecto</span><center>';
                        }
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        return d.telefono;
                    }
                },
                { 
                    data: function (d) {
                        return d.correo;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombreResidencial;
                    }
                },
                { 
                    data: function (d) {
                        return d.condominio;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombreLote;
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
                },
                { 
                    data: function (d) {
                        return d.fechaApartado;
                    }
                },
                { 
                    data: function (d) {
                        return '<button class="btn-data btn-acidGreen see-comments" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-ellipsis-h"></i></button>';
                    }
                }],
                ajax: {
                    "url": "getCMReport",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                }
            });
        });
    </script>
</body>