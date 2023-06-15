<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
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
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Prospectos recomendados</h3>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="mktdProspectsTable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ESTADO</th>
                                                    <th>PROSPECTO</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>RECOMENDADO POR</th>
                                                    <th>MEDIO</th>
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
    <script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>
    <script>

        $('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            if ( i != 9) {
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (prospectsTable.column(i).search() !== this.value ) {
                        prospectsTable
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                } );
            }
        });
        let titulos = [];
        $('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {
            if( i!=0 && i!=13){
                var title = $(this).text();
                titulos.push(title);    
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
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8],
                            format: {
                                header:  function (d, columnIdx) {
                                    if(columnIdx == 0){
                                        return ' '+d +' ';
                                    }
                                        return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
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
                    defaultContent: "Sin especificar",
                    targets: "_all"
                }],
                columns: [{
                    data: function (d) {
                        var  b = '';
                        if(d.estatus_particular == 1) { // DESCARTADO
                            b = '<center><span class="label label-danger" style="background:#E74C3C">Descartado</span><center>';
                        } 
                        else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                            b = '<center><span class="label label-danger" style="background:#B7950B">Interesado sin cita</span><center>';
                        } 
                        else if (d.estatus_particular == 3){ // CON CITA
                            b = '<center><span class="label label-danger" style="background:#27AE60">Con cita</span><center>';
                        } 
                        else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                            b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                        } 
                        else if (d.estatus_particular == 5){ // PAUSADO
                            b = '<center><span class="label label-danger" style="background:#2E86C1">Pausado</span><center>';
                        } 
                        else if (d.estatus_particular == 6){ // PREVENTA
                            b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                        }
                        if (d.estatus == 1) {
                            return '<center><b>Vigente</b><center>' + b;
                        } 
                        else {
                            return '<center><b>No vigente</b><center>' + b;
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
                        return d.asesor;
                    }
                },
                { 
                    data: function (d) {
                        return d.gerente;
                    }
                },
                {
                        data: function (d) {
                        var  b = '';
                        if(d.tipo_recomendado == 0) { // PROSPECT
                            b = '<button class="btn btn-round btn-fab btn-fab-mini btn-xs" style="height: 20px; min-width: 20px; width: 20px; padding: 4px 0px; background-color:#2ECC71;">P</button>';
                        }
                        else if(d.tipo_recomendado == 1) { // CLIENT
                            b = '<button class="btn btn-round btn-fab btn-fab-mini btn-xs" style="height: 20px; min-width: 20px; width: 20px; padding: 4px 0px; background-color:#8E44AD;">C</button>';
                        }
                        return d.recomendado_por + '<br>' + b;
                    }
                },
                { 
                    data: function (d) {
                        return d.especificacion;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_vencimiento;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_modificacion;
                    }
                },
                { 
                    data: function (d) {
                        return '<button class="btn-data btn-acidGreen see-comments" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-ellipsis-h"></i></button>';
                    }
                }
                ],
                ajax: {
                    "url": "getRecommendedReport",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                }
            });
        });
    </script>
</body>
</html>
