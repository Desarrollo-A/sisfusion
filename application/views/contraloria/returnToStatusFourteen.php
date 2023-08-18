<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Registro estatus 14</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto:</label>
                                            <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio:</label>
                                            <select id="filtro4" name="filtro4" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona condominio" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tableStatus15Clients"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="modal fade " id="returnStatus15" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <center><h4 class="modal-title"><label>Agrega tus comentarios</b></label>
                                                </h4></center>
                                        </div>
                                        <form id="returnEditaStatus15" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label id="tvLbl">Lote</label>
                                                    <input type="text" class="form-control" id="nombreLote" name="nombreLote" readonly>
                                                    <input type="hidden" class="form-control" id="idLote" name="idLote">
                                                    <input type="hidden" class="form-control" id="idCondominio" name="idCondominio">
                                                    <input type="hidden" class="form-control" id="idCliente" name="idCliente">
                                                </div>
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label>Comentario</label>
                                                    <textarea class="form-control" rows="2" id="comentario" name="comentario" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="save" class="btn btn-success"><span class="material-icons">send</span> </i> Guardar </button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar </button>
                                            </div>
                                        </form>
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
                    <center>
                        <!--                        <h3>DOCUMENTACIÓN</h3>-->
                    </center>
                    <hr>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title" style="text-align: center">Regreso estatus 14</h4>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Proyecto:</label><br>
                                    <select name="filtro3" id="filtro3" class="selectpicker" data-style="btn btn-second"
                                            data-show-subtext="true" data-live-search="true" title="Selecciona proyecto"
                                            data-size="7" required></select>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Condominio:</label><br>
                                    <select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true"
                                            data-live-search="true" data-style="btn" title="Selecciona condominio"
                                            data-size="7"></select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content" style="padding: 50px 20px;">
                            <div class="material-datatables">
                                <table id="tableStatus15Clients" class="table table-bordered table-hover" width="100%"
                                       style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th style="font-size: .9em;" class="text-center">Proyecto</th>
                                        <th style="font-size: .9em;" class="text-center">Condominio</th>
                                        <th style="font-size: .9em;" class="text-center">Lote</th>
                                        <th style="font-size: .9em;" class="text-center"></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="modal fade " id="returnStatus15" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <center><h4 class="modal-title"><label>Agrega tus comentarios</b></label>
                                                </h4></center>
                                        </div>
                                        <form id="returnEditaStatus15" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label id="tvLbl">Lote</label>
                                                    <input type="text" class="form-control" id="nombreLote" name="nombreLote" readonly>
                                                    <input type="hidden" class="form-control" id="idLote" name="idLote">
                                                    <input type="hidden" class="form-control" id="idCondominio" name="idCondominio">
                                                    <input type="hidden" class="form-control" id="idCliente" name="idCliente">
                                                </div>
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label>Comentario</label>
                                                    <textarea class="form-control" rows="2" id="comentario" name="comentario" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="save" class="btn btn-success"><span class="material-icons">send</span> </i> Guardar </button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar </button>
                                            </div>
                                        </form>
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
</div><!--main-panel close-->
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

<script type="text/javascript">
    var url = "<?=base_url()?>";
</script>

<script>

    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        var idLote = $('#idLote').val();
        var comentario = $('#comentario').val();
        var idCondominio = $('#idCondominio').val();
        var nombreLote = $('#nombreLote').val();
        var idCliente = $('#idCliente').val();
        if (comentario == '')
        {
            alerts.showNotification("top", "right", "Asegúrate de haber ingresado un comentario.", "warning");
        }
        else {
            $.post('updateReturnStatus15', {
                idLote: idLote, comentario: comentario, idCondominio: idCondominio, nombreLote: nombreLote,
                idCliente: idCliente
            }, function (data) {
                if (data == 1) {
                    $('#returnStatus15').modal("hide");
                    $('#tableStatus15Clients').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El cambio de estatus se ha llevado a cabo correctamente.", "success");
                } else {
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            });
        }
    });

    $(document).on('click', '.addComent', function (e) {
        e.preventDefault();
        var $itself = $(this);
        $.post('getInfoReturnStatus15', {idLote: $itself.attr('data-idLote')}, function (data) {
            var $form = $('#returnEditaStatus15');
            $form.find('#idLote').val(data.idLote);
            $form.find('#idCondominio').val(data.idCondominio);
            $form.find('#nombreLote').val(data.nombreLote);
            $form.find('#idCliente').val(data.idCliente);
            $('#returnStatus15').modal('show');
        }, 'json');
    });

    $('#tableStatus15Clients thead tr:eq(0) th').each(function (i) {
        if(i!=3){
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tableStatus15Clients').DataTable().column(i).search() !== this.value) {
                    $('#tableStatus15Clients').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }

    });

    $(document).ready(function () {
        $.post(url + "Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
            }

            $("#filtro3").selectpicker('refresh');
        }, 'json');


        $('#filtro3').change(function () {
            var valorSeleccionado = $(this).val();
            $("#filtro4").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>registroCliente/getCondominios/' + valorSeleccionado,
                type: 'post',
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');

                }
            });
        });

        $('#filtro4').change(function () {
            var valorSeleccionado = $(this).val();
            $('#tableStatus15Clients').DataTable({
                destroy: true,
                lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
                ajax:
                    {
                        "url": '<?=base_url()?>index.php/Contraloria/getClientsInStatusFifteen/' + valorSeleccionado,
                        "data": function (d) {
                        }
                    },
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Registro estatus 14',
                        title:'Registro estatus 14',
                        exportOptions: {
                            columns: [0, 1, 2],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'LOTE';
                                            break;
                                    }
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                        className: 'btn buttons-pdf',
                        titleAttr: 'Registro estatus 14',
                        title:'Registro estatus 14',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'LOTE';
                                            break;
                                    }
                                }
                            }
                        }
                    }
                ],
                columns:
                    [
                        {
                            "data": function (d) {
                                return '<p style="font-size: .8em">' + d.nombreResidencial + '</p>';
                            }
                        },

                        {
                            "data": function (d) {
                                return '<p style="font-size: .8em">' + d.nombreCondominio + '</p>';
                            }
                        },
                        {
                            "data": function (d) {
                                return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                            }
                        },
                        {
                            "data": function (d) {
                                return '<button class="btn btn btn-round btn-fab btn-fab-mini addComent" data-idlote="' + d.idLote + '" style="background-color:#28B463;border-color:#28B463" rel="tooltip" data-placement="left" title="Regresar estatatus ' + d.nombreLote + '"><i class="material-icons">update</i></button>';
                            }
                        }
                    ]
            });
        });


    });/*document Ready*/

</script>

