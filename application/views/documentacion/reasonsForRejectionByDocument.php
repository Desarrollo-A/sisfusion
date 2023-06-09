<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>


    <div class="modal" tabindex="-1" role="dialog" id="notification">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="p-0 text-center" id="mainLabelText">Asegúrate que el campo <b>Documentos</b> tenga al
                        menos un valor seleccionado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="addRejectReasonModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body text-center boxContent p-0">
                        <div class="card no-shadow p-0">
                            <div class="card-content p-0">
                                <h3 class="card-title center-align">Ingresa el motivo de rechazo que asociarás a <b><p
                                                id="documentName"></p></b></h3>
                                <div class="toolbar">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-group label-floating is-empty" id="main_div">
                                            <label class="control-label estiloEsc label-gral">Motivo de rechazo
                                                (requerido)</label>
                                            <input id="rejectReason" name="rejectReason" type="text"
                                                   class="form-control input-gral" required autocomplete="off">
                                            <input id="id_documento" name="id_documento" class="hide">
                                            <input id="id_motivo" name="id_motivo" class="hide">
                                            <input id="action" name="action" class="hide">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input id="idLote" class="hide">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_save" class="btn btn-primary" onclick="saveRejectReason()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-file fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Adminstrador - motivos de rechazo por documento y solicitud</h3>
                                <div class="container-fluid">
                                    <div class="row aligned-row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 overflow-hidden">
                                                <label class="label-gral">Documentos</label>
                                                <select id="documentos" name="documentos" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body" data-live-search="true" title="Selecciona un documento" data-size="7">
                                                </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-2 d-flex align-end">
                                            <button class="btn-rounded btn-s-greenLight apply-action" data-action="0" id="addOption" name="addOption" title="Agregar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                              </div>
                            </div>

                            <br>
                            <div class="material-datatables" id="box-reasonsForRejectionTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="reasonsForRejectionTable" name="reasonsForRejectionTable">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>DOCUMENTO</th>
                                                <th>MOTIVO</th>
                                                <th>ESTATUS</th>
                                                <th></th>
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

<script> 
    $(document).ready(function () {
    $("#documentos").empty().selectpicker('refresh');
    $.ajax({
        url: url + 'Documentacion/getCatalogOptions',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#documentos").append($('<option>').val(response[i]['id_opcion']).attr('data-catalogo', response[i]['id_catalogo']).text(response[i]['nombre']));
            }
            $("#documentos").append($('<option>').val(0).attr('data-catalogo', 0).text('POR SOLICITUD'));
            $("#documentos").selectpicker('refresh');
        }
    });

    });
    var url = "<?=base_url()?>";

    $('#reasonsForRejectionTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        if (i != 4) {
            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#reasonsForRejectionTable").DataTable().column(i).search() !== this.value) {
                    $("#reasonsForRejectionTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    function fillTable(id_documento) {
        generalDataTable = $('#reasonsForRejectionTable').dataTable({
            dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
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
            columns: [
                {
                    data: function (d) {
                        return d.id_motivo;
                    }
                },
                {
                    data: function (d) {
                        return d.motivo;
                    }
                },
                {
                    data: function (d) {
                        return d.estatus_motivo;
                    }
                },
                {
                    data: function (d) {
                        let btns = '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas apply-action" data-action="1" data-id-motivo="' + d.id_motivo + '" data-nombre-documento="' + d.nombre_documento + '" data-motivo="' + d.motivo + '" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fas fa-pen"></i></button>';
                        btns += `<button class="btn-data btn-${d.estatus == 1 ? 'warning' : 'green'} apply-action" data-action="${d.estatus == 1 ? 2 : 3}" data-id-motivo="${d.id_motivo}" data-nombre-documento="${d.nombre_documento}" data-motivo="${d.motivo}"  data-toggle="tooltip" data-placement="left" title="${d.estatus == 1 ? 'Desactivar' : 'Activar'}"><i class="fas fa-${d.estatus == 1 ? 'lock' : 'unlock'}"></i></button>`;
                        btns += '</div>';
                        $('[data-toggle="tooltip"]').tooltip();
                        return btns;
                    }
                }
            ],
            columnDefs: [{
                visible: false
            }],
            ajax: {
                url: 'getReasonsForRejectionByDocument',
                type: "POST",
                cache: false,
                data: {
                    "id_documento": id_documento,
                    "tipo_proceso": id_documento == 0 ? 3 : 2
                }
            }
        });

    }

    $(document).on("change", "#documentos", function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        fillTable($("#documentos").val());
    });

    function saveRejectReason() {
        $('#btn_save').prop('disabled', true);
        $('#spiner-loader').removeClass('hidden');
        let id_documento = $("#id_documento").val();
        let id_motivo = $("#id_motivo").val();
        let action = $("#action").val();
        let reject_reason = $("#rejectReason").val();
        let documentName = $("#documentos option:selected").text();
        if ((action == 0 && (reject_reason == '' || id_documento == '')) || (action == 1 && (reject_reason == '' || id_motivo == ''))){
            alerts.showNotification("top", "right", "Asegúrate de ingresar un motivo de rechazo para el documento <b>" + documentName + "</b>.", "warning");
            $('#btn_save').prop('disabled', false);
            $('#spiner-loader').addClass('hidden');
        }else {
            $.ajax({
                type: 'POST',
                url: url + 'Documentacion/saveRejectReason',
                data: {
                    "id_documento": id_documento,
                    "reject_reason": reject_reason,
                    "id_motivo": id_motivo,
                    "action": action
                },
                dataType: 'json',
                success: function (response) {
                    alerts.showNotification("top", "right", response["message"], response["status"] == 200 ? "success" : response["status"] == 400 ? "warning" : "error");
                    if (response["status"] == 200) {
                        $("#reasonsForRejectionTable").DataTable().ajax.reload(null, false);
                        $("#addRejectReasonModal").modal("hide");
                    }
                    $('#btn_save').prop('disabled', false);
                    $('#spiner-loader').addClass('hidden');
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#btn_save').prop('disabled', false);
                    $('#spiner-loader').addClass('hidden');
                }
            });
        }
    }

    $(document).on("click", ".apply-action", function () {
        let action = $(this).data("action");
        if (action == 0) {
            let id_documento = $("#documentos").val();
            if (id_documento == '')
                $("#notification").modal("show");
            else {
                $("#rejectReason").val("");
                $("#id_documento").val(id_documento);
                $("#action").val(0);
                document.getElementById("documentName").innerHTML = $("#documentos option:selected").text();
                $("#addRejectReasonModal").modal();
            }
        } else if (action == 1) {
            $("#main_div").addClass("clasecss");
            document.getElementById("documentName").innerHTML = $(this).attr("data-nombre-documento");
            $("#rejectReason").val($(this).attr("data-motivo"));
            $("#id_documento").val(id_documento);
            $("#id_motivo").val($(this).attr("data-id-motivo"));
            $("#action").val(action);
            $("#addRejectReasonModal").modal();
        } else if (action == 2 || action == 3)
            updateStatus(action, $(this).attr("data-id-motivo"));
    });

    function updateStatus(action, id_motivo) {
        $.ajax({
            type: 'POST',
            url: url + 'Documentacion/changeStatus',
            data: {"action": action, "id_motivo": id_motivo},
            dataType: 'json',
            success: function (response) {
                alerts.showNotification("top", "right", response["message"], response["status"] == 200 ? "success" : response["status"] == 400 ? "warning" : "error");
                if (response["status"] == 200)
                    $("#reasonsForRejectionTable").DataTable().ajax.reload(null, false);
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

</script>
</body>