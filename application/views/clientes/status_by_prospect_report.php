<body>
<div class="wrapper">

<?php $this->load->view('template/sidebar'); ?>


    <style>
        .label-inf {
            color: #333;
        }
        select:invalid {
            border: 2px dashed red;
        }

        .textoshead::placeholder { color: white; }

    </style>

    <div class="content">
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

                                                    <table id="mktdProspectsTable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                            <tr>
                                                                <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                                <th class="disabled-sorting text-right"><center>Prospecto</center></th>
                                                                <th class="disabled-sorting text-right"><center>Medio</center></th>
                                                                <th class="disabled-sorting text-right"><center>Asesor</center></th>
                                                                <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                                <th class="disabled-sorting text-right"><center>Creación</center></th>
                                                                <th class="disabled-sorting text-right"><center>Vencimiento</center></th>
                                                                <th class="disabled-sorting text-right"><center>Última modificación</center></th>
                                                                <th class="disabled-sorting text-right"><center>Acciones</center></th>
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
<script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>

<script>

    $('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {

        //  if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead text-left"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (mktdProspectsTable.column(i).search() !== this.value ) {
                mktdProspectsTable
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
        //}
    });


    var mktdProspectsTable
    $(document).ready(function () {
        mktdProspectsTable = $('#mktdProspectsTable').DataTable({
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            columnDefs: [{
                defaultContent: "Sin especificar",
                targets: "_all"
            }],
            destroy: true,
            ordering: false,
            columns: [
                { data: function (d) {
                        if(d.estatus_particular == 1) { // DESCARTADO
                            b = '<center><span class="label label-danger" style="background:#E74C3C">Descartado</span><center>';
                        } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                            b = '<center><span class="label label-danger" style="background:#B7950B">Interesado sin cita</span><center>';
                        } else if (d.estatus_particular == 3){ // CON CITA
                            b = '<center><span class="label label-danger" style="background:#27AE60">Con cita</span><center>';
                        } else if (d.estatus_particular == 5){ // PAUSADO
                            b = '<center><span class="label label-danger" style="background:#2E86C1">Pausado</span><center>';
                        } else if (d.estatus_particular == 6){ // PREVENTA
                            b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                        }

                        if (d.estatus == 1) {
                            return '<center><b>Vigente</b><center>' + b;
                        } else {
                            return '<center><b>No vigente</b><center>' + b;
                        }
                    }
                },
                { data: function (d) {
                        return d.nombre;
                    }
                },
                { data: function (d) {
                        return d.otro_lugar;
                    }
                },
                { data: function (d) {
                        return d.asesor;
                    }
                },
                { data: function (d) {
                        return d.gerente;
                    }
                },
                { data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { data: function (d) {
                        return d.fecha_vencimiento;
                    }
                },
                { data: function (d) {
                        return d.fecha_modificacion;
                    }
                },
                { data: function (d) {
                        return '<button class="btn btn-round btn-fab btn-fab-mini see-comments" data-id-prospecto="' + d.id_prospecto + '"><i class="material-icons">comment</i></button>';
                    }
                }
            ],
            "ajax": {
                "url": "getProspectsReport",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });

        yadcf.init(mktdProspectsTable,
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
                }
            ]);
    });
</script>


<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>

</html>
