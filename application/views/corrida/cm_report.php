<body>
<div class="wrapper">

<?php $this->load->view('template/sidebar'); ?>


    <style>
        .label-inf {
            color: #333;
        }
        /*.modal-body-scroll{
            height: 100px;
            width: 100%;
            overflow-y: auto;
        }*/
        select:invalid {
            border: 2px dashed red;
        }

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
                                            <h4 class="card-title">Reporte CLUB MADERAS</h4>
                                            <div class="table-responsive">
                                                <div class="material-datatables">
                                                    <table id="mktdProspectsTable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="disabled-sorting text-right"><center>Tipo</center></th>
                                                            <th class="disabled-sorting text-right"><center>Nombre</center></th>
                                                            <th class="disabled-sorting text-right"><center>Teléfono</center></th>
                                                            <th class="disabled-sorting text-right"><center>Correo</center></th>
                                                            <th class="disabled-sorting text-right"><center>Proyecto</center></th>
                                                            <th class="disabled-sorting text-right"><center>Condominio</center></th>
                                                            <th class="disabled-sorting text-right"><center>Lote</center></th>
                                                            <th class="disabled-sorting text-right"><center>Monto</center></th>
                                                            <th class="disabled-sorting text-right"><center>Asesor</center></th>
                                                            <th class="disabled-sorting text-right"><center>Coordinador</center></th>
                                                            <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                            <th class="disabled-sorting text-right"><center>Alta</center></th>
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>

<script>
    var mktdProspectsTable
    $(document).ready(function () {
        mktdProspectsTable = $('#mktdProspectsTable').DataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: "Excel",
                    titleAttr: "Excel"
                }
            ],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            columnDefs: [{
                defaultContent: "",
                targets: "_all"
            }],
            destroy: true,
            ordering: false,
            columns: [
                { data: function (d) {
                        if (d.tipo == 1) { // IS CLIENT
                            return '<center><span class="label" style="background:#66BB6A">Cliente</span><center>';
                        } else { // IS PROSPECT
                            return '<center><span class="label" style="background:#2E86C1">Prospecto</span><center>';
                        }
                    }
                },
                { data: function (d) {
                        return d.nombre;
                    }
                },
                { data: function (d) {
                        return d.telefono;
                    }
                },
                { data: function (d) {
                        return d.correo;
                    }
                },
                { data: function (d) {
                        return d.nombreResidencial;
                    }
                },
                { data: function (d) {
                        return d.condominio;
                    }
                },
                { data: function (d) {
                        return d.nombreLote;
                    }
                },
                { data: function (d) {
                        if (d.totalNeto2 == 'null' || d.totalNeto2 == '' || d.totalNeto2 == '0.00' || d.totalNeto2 == null || d.totalNeto2 == '.00') {
                            return '$0.00';
                        } else {
                            return '$' + d.totalNeto2;
                        }
                    }
                },
                { data: function (d) {
                        return d.asesor;
                    }
                },
                { data: function (d) {
                        return d.coordinador;
                    }
                },
                { data: function (d) {
                        return d.gerente;
                    }
                },
                { data: function (d) {
                        return d.fechaApartado;
                    }
                },
                { data: function (d) {
                        return '<button class="btn btn-round btn-fab btn-fab-mini see-comments" data-id-prospecto="' + d.id_prospecto + '" style="color:#AFB42B"><i class="material-icons">comment</i></button>';
                    }
                }
            ],
            "ajax": {
                "url": "getCMReport",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });
    });
</script>

</html>
