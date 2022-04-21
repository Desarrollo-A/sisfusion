<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<style>
    #reviewTokenEvidence .close{
        padding: 7px 10px;
        background-color: #333333a1;
        color: #eaeaea;
        border-radius: 20px;
    }
</style>

<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar', ""); ?>

    <div class="modal fade in" id="reviewTokenEvidence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="col-md-12">
                        <div id="img_actual">
                        </div>
                    </div>
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
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Revisar evidencia de token</h3>
                            </div>
                            <div class="table-responsive box-table">
                                <input class="hide" id="generatedToken"/>
                                <table id="reviewTokenEvidenceTable" name="reviewTokenEvidenceTable"
                                       class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>GENERADO PARA</th>
                                        <th>FECHA ALTA</th>
                                        <th>CREADO POR</th>
                                        <th>ESTATUS</th>
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
    <?php $this->load->view('template/footer_legend'); ?>
</div>
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
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script src="<?= base_url() ?>dist/js/controllers/apartado/generateToken.js"></script>

<script>

    let id_gerente = "<?=$this->session->userdata('id_usuario')?>";
    $(document).ready(function () {
        fillTokensTable();
    });

    $(document).ready(function () {
        $("input:file").on("change", function () {
            var target = $(this);
            var relatedTarget = target.siblings(".file-name");
            var fileName = target[0].files[0].name;
            relatedTarget.val(fileName);
        });
    });

    $('#reviewTokenEvidenceTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#reviewTokenEvidenceTable").DataTable().column(i).search() !== this.value) {
                $("#reviewTokenEvidenceTable").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    function fillTokensTable() {
        reviewTokenEvidenceTable = $('#reviewTokenEvidenceTable').dataTable({
            dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
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
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return "ID";
                                        break;
                                    case 1:
                                        return "GENERADO PARA"
                                    case 2:
                                        return "FECHA ALTA";
                                        break;
                                    case 3:
                                        return "CREADO POR";
                                        break;
                                    case 4:
                                        return "ESTATUS";
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "../static/spanishLoader_v2.json",
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
                        return d.id_token;
                    }
                },
                {
                    data: function (d) {
                        return d.generado_para;
                    }
                },
                {
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                {
                    data: function (d) {
                        return d.creado_por;
                    }
                },
                {
                    data: function (d) {
                        return d.estatus;
                    }
                },
                {
                    data: function (d) {
                        let btns = '<div class="d-flex align-center justify-center">' +
                            '<button class="btn-data btn-gray reviewEvidenceToken" data-nombre-archivo="' + d.nombre_archivo +'" title="Ver evidencia"></body><i class="fas fa-eye"></i></button>' +
                            '<button class="btn-data btn-green setToken" data-token-name="' + d.token +'" title="Copiar token"><i class="fas fa-copy"></i></button>';
                            if(d.estatus == 1)
                               btns += '<button class="btn-data btn-warning validateToken" data-action="2" data-token-id="' + d.id_token + '" title="Rechazar token"><i class="fas fa-minus"></i></button>';
                            if(d.estatus == 2 || d.estatus == 0)
                                btns += '<button class="btn-data btn-green validateToken" data-action="1" data-token-id="' + d.id_token + '" title="Validar token"><i class="fas fa-check"></i></button>';
                        btns += '</div>';
                        return btns;
                    }
                }
            ],
            columnDefs: [
                {
                    visible: false,
                    searchable: false
                }
            ],
            ajax: {
                url: "getTokensInformation",
                type: "POST",
                cache: false,
            }
        });
    }

    $(document).on('click', '.reviewEvidenceToken', function () {
        $("#img_actual").empty();
        let path = general_base_url + "static/documentos/evidence_token/" + $(this).attr("data-nombre-archivo");
        let img_cnt = '<img src="' + path + '" class="img-responsive zoom m-auto">';
        $("#token_name").text($(this).attr("data-token-name"));
        $("#img_actual").append(img_cnt);
        $("#reviewTokenEvidence").modal()
    });

    $(document).on('click', '.setToken', function () {
        $("#generatedToken").val($(this).attr("data-token-name"));
        copyToClipBoard();
    });

    $(document).on('click', '.validateToken', function () {
        let action = $(this).attr("data-action");
        $.ajax({
            type: 'POST',
            url: 'validarToken',
            data: {
                'action': action,
                'id': $(this).attr("data-token-id")
            },
            dataType: 'json',
            success: function (data) {
                $("#reviewTokenEvidenceTable").DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", action == 2 ? "El token ha sido marcado como rechazado." : "El token ha sido marcado como aprobado.", "success");
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

</script>

</body>