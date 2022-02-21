<body class="">
<div class="wrapper ">
    <?php
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    ?>
    <link href="<?= base_url() ?>dist/css/liberaciones-styles.css" rel="stylesheet"/>

    <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <h5>¿Estás segura de hacer este movimiento? </h5>
                        <p style="font-size: 0.8em">Los lotes serán marcados para continuar con el proceso de
                            liberación.</p>
                    </div>
                    <input id="idLote" class="hide">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="updateLotesStatusLiberacion()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!--Contenido de la página-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">settings</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="text-align: center">Liberaciones</h3>
                            <div class="toolbar">
                                <div class="row d-flex align-end">
                                    <div class="col-12 col-sm-12 col-md-5 col-lg-5 pr-0">
                                        <select class="selectpicker" data-style="btn btn-primary btn-round"
                                                title="Selecciona un proyecto" data-size="7" id="selectResidenciales"
                                                data-live-search="true"></select>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5 col-lg-5 pr-0">
                                        <select class="selectpicker" data-style="btn btn-primary btn-round"
                                                title="Selecciona un condominio" data-size="7" id="selectCondominios"
                                                data-live-search="true"></select>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-end">
                                        <div class="container m-0" style="width: 70%">
                                            <div class="row d-flex align-end">
                                                <div class="col-md-12 p-0" style="padding: 0;">
                                                    <div class="form-group d-flex justify-end" style="justify-content: flex-end;">
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini m-0"
                                                                title="Aplicar cambios" style="margin: 0;">
                                                            <span class="material-icons apply-changes" data-type="1">done</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables" id="box-liberacionesTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="liberacionesTable" name="liberacionesTable"
                                               style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th title="ID LOTE" class="encabezado">ID LOTE</th>
                                                <th title="NOMBRE">NOMBRE</th>
                                                <th title="PLAZA">REFERENCIA</th>
                                                <th title="MONTO TOTAL">CLIENTE</th>
                                                <th title="FECHA APARTADO">FECHA APARTADO</th>
                                                <th title="ESTATUS CONTRATACIÓN">ESTATUS CONTRATACIÓN</th>
                                                <th title="ESTATUS VENTA">ESTATUS LIBERACIÓN</th>
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

<script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>

<script>

    let url = "<?=base_url()?>";
    $(document).ready(function () {
        getResidenciales();
    });

    function getResidenciales() {
        $("#selectResidenciales").empty().selectpicker('refresh');
        $.ajax({
            url: url + 'General/getResidencialesList',
            type: 'post',
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idResidencial'];
                    var name = response[i]['descripcion'];
                    $("#selectResidenciales").append($('<option>').val(id).text(name));
                }
                $("#selectResidenciales").selectpicker('refresh');
            }
        });
    }

    $('#selectResidenciales').change(function () {
        let idResidencial = $(this).val();
        $("#selectCondominios").empty().selectpicker('refresh');
        $.ajax({
            url: url + 'General/getCondominiosList/' + idResidencial,
            type: 'post',
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#selectCondominios").append($('<option>').val(id).text(name));
                }
                $("#selectCondominios").selectpicker('refresh');
            }
        });
    });

    $('#selectCondominios').change(function () {
        let idCondominio = $(this).val();
        fillTable(idCondominio);
    });

    $('#liberacionesTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#103f75; color:white; border: 0; font-weight: 100; font-size: 10px; text-align: center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#liberacionesTable").DataTable().column(i).search() !== this.value) {
                $("#liberacionesTable").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    function fillTable(idCondominio) {
        let encabezado = (document.querySelector('#liberacionesTable .encabezado .textoshead').placeholder).toUpperCase();
        generalDataTable = $('#liberacionesTable').dataTable({
            dom: "Brtip",
            width: "auto",
            select: {
                style: 'single'
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-success buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'ID LOTE';
                                        break;
                                    case 2:
                                        return 'NOMBRE'
                                    case 3:
                                        return 'REFERENCIA';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 6:
                                        return 'ESTATUS CONTRATACIÓN';
                                        break;
                                    case 7:
                                        return 'ESTATUS LIBERACIÓN';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
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
                {},
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
                        return d.referencia;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreCliente;
                    }
                },
                {
                    data: function (d) {
                        return d.fechaApartado;
                    }
                },
                {
                    data: function (d) {
                        return '<span class="label" style="background:#' + d.colorEstatusContratacion + ';">' + d.estatusContratacion + '</span>';
                    }
                },
                {
                    data: function (d) {
                        btns = '';
                        btns += '<span class="label" style="background:#' + d.colorEstatusLiberacion + ';">' + d.estatusLiberacion + '</span>';
                        if(d.estatusLiberacion == "En proceso de liberación")
                            btns += '<br><button class="btn btn-success btn-round btn-fab btn-fab-mini m-1 remove-mark" title="Remover marca" style="margin: 0;" data-idLote="'+d.idLote+'"><span class="material-icons" data-type="1">clear</span></button>';
                        return btns;
                    }
                }
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox dt-body-center',
                targets: 0,
                searchable: false,
                render: function (d, type, full, meta) {
                    if (full.estatusLiberacion == "En proceso de liberación") {
                        return '';
                    } else {
                        return '<input type="checkbox" name="idT[]" style="width:20px; height:20px;" value="' + full.idLote + '">';
                    }
                },
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
            }],
            ajax: {
                url: url + 'Contraloria/getLiberacionesInformation',
                type: "POST",
                cache: false,
                data: {
                    "idCondominio": idCondominio
                }
            }
        });
    }

    $(document).on('click', '.apply-changes', function () {
        if ($('input[name="idT[]"]:checked').length > 0) {
            $("#modalConfirmRequest").modal();
        } else {
            alerts.showNotification("top", "right", "Asegúrate de al menos haber seleccionado una opción.", "warning");
        }
    });

    function updateLotesStatusLiberacion(e) {
        let idLote = $(generalDataTable.$('input[name="idT[]"]:checked')).map(function () {
            return this.value;
        }).get();
        $.ajax({
            type: 'POST',
            url: url + 'Contraloria/updateLotesStatusLiberacion',
            data: {
                'idLote': idLote
            },
            dataType: 'json',
            success: function (data) {
                if (data == 0) {
                    alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                    $("#modalConfirmRequest").modal("hide");
                    $("#liberacionesTable").DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                }
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

    $(document).on('click', '.remove-mark', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
        $.ajax({
            type: 'POST',
            url: url + 'Contraloria/removeMark',
            data: {
                'idLote': $(this).attr("data-idLote")
            },
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                    $("#liberacionesTable").DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                }
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

</script>


