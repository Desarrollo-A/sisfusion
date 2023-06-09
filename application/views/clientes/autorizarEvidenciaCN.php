<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
    $this->load->view('template/sidebar');
    $this->load->view('template/controversy_modals');
    ?>
    <style>
        textarea:focus, textarea.form-control:focus {

            outline: none !important;
            outline-width: 0 !important;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .textoshead::placeholder {
            color: white;
        }

        .zoom {
            transition: 1.5s ease;
            -moz-transition: 1.5s ease; /* Firefox */
            -webkit-transition: 1.5s ease; /* Chrome - Safari */
            -o-transition: 1.5s ease; /* Opera */
        }

        .zoom:hover {
            transform: scale(1.5);
            -moz-transform: scale(1.5); /* Firefox */
            -webkit-transform: scale(1.5); /* Chrome - Safari */
            -o-transform: scale(1.5); /* Opera */
            -ms-transform: scale(1.5); /* IE9 */
            z-index: 999999999999999999999999;
        }
    </style>

    <!-- modal  INSERT COMENTARIOS-->
    <div class="modal fade" id="evidenciaModalRev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="sendRespFromCB" name="sendRespFromCB">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h3 class="modal-title" id="myModalLabel"><b>Autorizar evidencia</b></h3></center>
                    </div>
                    <div class="modal-body">
                        <div id="loadAuts">
                        </div>
                        <input type="hidden" name="nombreLote" id="nombreLote" value="">
                        <input type="hidden" name="idCliente" id="idCliente" value="">
                        <input type="hidden" name="idLote" id="idLote" value="">
                        <input type="hidden" name="id_evidencia" id="id_evidencia" value="">
                        <input type="hidden" name="evidencia_file" id="evidencia_file" value="">
                        <input type="hidden" name="rowType" id="rowType" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary hide" id="button_enviar">
                            Enviar autorización
                        </button>
                        <a href="#" class="btn btn-primary" id="btnSubmit">
                            Enviar autorización
                        </a>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Autorizaciones de evidencia </h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="autorizarEvidencias"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>FECHA APARTADO</th>
                                            <th>PLAZA</th>
                                            <th>LOTE</th>
                                            <th>Cliente</th>
                                            <th>SOLICITANTE</th>
                                            <th>ESTATUS</th>
                                            <th>TIPO</th>
                                            <th>VALIDACIÓN GERENTE</th>
                                            <th>VALIDACIÓN COBRANZA</th>
                                            <th>VALIDACIÓN CONTRALORÍA</th>
                                            <th>RECHAZO COBRANZA</th>
                                            <th>RECHAZO VALIDACIÓN</th>
                                            <th>ACCIONES</th>
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
    </div>



    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Autorizaciones de evidencia</h4><br><br>
                            <div class="table-responsive">
                                <table id="autorizarEvidencias" class="table table-bordered table-hover" width="100%"
                                       style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th data-toggle="tooltip" data-placement="right" title="ID lote">ID lote</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Fecha apartado">Fecha
                                            apartado
                                        </th>
                                        <th data-toggle="tooltip" data-placement="right" title="Plaza">Plaza</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Lote">Lote</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Cliente">Cliente</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Solicitante">
                                            Solicitante
                                        </th>
                                        <th data-toggle="tooltip" data-placement="right" title="Estatus">Estatus</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Tipo">Tipo</th>
                                        <th data-toggle="tooltip" data-placement="right" title="Validación gerente">
                                            Validación gerente
                                        </th>
                                        <th data-toggle="tooltip" data-placement="right" title="Validación cobranza">
                                            Validación cobranza
                                        </th>
                                        <th data-toggle="tooltip" data-placement="right" title="Validación contraloría">
                                            Validación contraloría
                                        </th>
                                        <th data-toggle="tooltip" data-placement="left" title="Rechazo cobranza">Rechazo
                                            cobranza
                                        </th>
                                        <th data-toggle="tooltip" data-placement="left" title="Rechazo contraloría">
                                            Rechazo contraloría
                                        </th>
                                        <th data-toggle="tooltip" data-placement="left" title="Acciones">Acciones</th>
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
<script src="<?= base_url() ?>dist/js/evidencias.js"></script>

<script>
    $(document).ready(function () {
        /*agregar input de buscar al header de la tabla*/
        let titulos_intxt = [];
        $('#autorizarEvidencias thead tr:eq(0) th').each(function (i) {
            if(i!=13){
                var title = $(this).text();
                titulos_intxt.push(title);
                $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if ($('#autorizarEvidencias').DataTable().column(i).search() !== this.value) {
                        $('#autorizarEvidencias').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }

        });

        var table;
        table = $('#autorizarEvidencias').DataTable({
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Autorizaciones de evidencia',
                    title:'Autorizaciones de evidencia',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID LOTE';
                                        break;
                                    case 1:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 2:
                                        return 'PLAZA';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'SOLICITANTE';
                                        break;
                                    case 6:
                                        return 'ESTATUS';
                                        break;
                                    case 7:
                                        return 'TIPO';
                                        break;
                                    case 8:
                                        return 'VALIDACIÓN DE ENGANCHE';
                                        break;
                                    case 9:
                                        return 'VALIDACIÓN COBRANZA';
                                        break;
                                    case 10:
                                        return 'VALIDACIÓN CONTRALORÍA';
                                        break;
                                    case 11:
                                        return 'RECHAZO COBRANZA';
                                        break;
                                    case 12:
                                        return 'RECHAZO CONTRALORÍA';
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
                    titleAttr: 'Autorizaciones de evidencia',
                    title: "Autorizaciones de evidencia",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID LOTE';
                                        break;
                                    case 1:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 2:
                                        return 'PLAZA';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'SOLICITANTE';
                                        break;
                                    case 6:
                                        return 'ESTATUS';
                                        break;
                                    case 7:
                                        return 'TIPO';
                                        break;
                                    case 8:
                                        return 'VALIDACIÓN DE ENGANCHE';
                                        break;
                                    case 9:
                                        return 'VALIDACIÓN COBRANZA';
                                        break;
                                    case 10:
                                        return 'VALIDACIÓN CONTRALORÍA';
                                        break;
                                    case 11:
                                        return 'RECHAZO COBRANZA';
                                        break;
                                    case 12:
                                        return 'RECHAZO CONTRALORÍA';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            ordering: false,
            scrollX: true,
            pageLength: 10,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            ajax: "<?=base_url()?>index.php/Asesor/getAutsForContraloria/",
            columns: [
                {"data": "idLote"},
                {"data": "fechaApartado"},
                {"data": "plaza"},
                {"data": "nombreLote"},
                {"data": "cliente"},
                {"data": "solicitante"},
                {
                    "data": function (d) {
                        var labelStatus;
                        switch (d.estatus) {
                            case '1':
                                labelStatus = '<span class="label" style="background:#3498DB;">ENVIADA A COBRANZA</span>';
                                break;
                            case '10':
                                labelStatus = '<span class="label" style="background:#CD6155;">COBRANZA RECHAZÓ LA EVIDENCIA AL GERENTE</span>';
                                break;
                            case '2':
                                labelStatus = '<span class="label" style="background:#27AE60;">SIN VALIDAR</span>';
                                break;
                            case '20':
                                labelStatus = '<span class="label" style="background:#E67E22;">CONTRALORÍA RECHAZÓ LA EVIDENCIA</span>';
                                break;
                            case '3':
                                labelStatus = '<span class="label" style="background:#9B59B6;">EVIDENCIA ACEPTADA</span>';
                                break;
                            default:
                                labelStatus = '<span class="label" style="background:#808B96;">SIN ESTATUS REGISTRADO</span>';
                                break;
                        }
                        return labelStatus;
                    }

                },
                {
                    "data": function (d) {
                        if (d.rowType == 11 || d.rowType == 22) // MJ: CONTROVERSIA NORMAL / CONTROVERSIA PARA DESCUENTO
                            return "<small class='label bg-green' style='background-color: #45B39D'>Normal</small>";
                        else if (d.rowType == 33)//Implementación Venta nueva
                            return "<small class='label' style='background-color: #566573'>Venta nueva</small>";
                        else if (d.rowType == 44)// MJ: CONTROVERSIA MKTD 2022
                            return "<small class='label bg-green' style='background-color: #A569BD'>MKTD 2022</small>";
                        else if (d.rowType == 55)// MJ: CONTROVERSIA CARGA MASIVA
                            return "<small class='label bg-green' style='background-color: #5DADE2'>Carga masiva</small>"
                        else // MJ: NO ES CONTROVERSIA
                            return "<small class='label bg-green' style='background-color: #138D75'>MKTD</small>"
                    }
                },
                {"data": "fechaValidacionGerente"},
                {"data": "fechaValidacionCobranza"},
                {"data": "fechaValidacionContraloria"},
                {"data": "fechaRechazoCobranza"},
                {"data": "fechaRechazoContraloria"},
                {
                    "data": function (d) {
                        var buttons = '';
                        buttons = '<button href="#" title= "Ver comentarios" data-id_autorizacion="' + d.id_evidencia + '" ' +
                            'data-idLote="' + d.idLote + '" class="btn-data btn-blueMaderas seeAuts">' +
                            '<i class="fas fa-comments"></i></button>'
                        if (d.estatus == 2) {
                            buttons += '<button href="#" title= "Validar evidencia" data-evidencia="' + d.evidencia + '" ' +
                                'data-id_evidencia="' + d.id_evidencia + '" data-idCliente="' + d.id_cliente + '" ' +
                                'data-nombrelote="' + d.nombreLote + '" data-rowType="' + d.rowType + '" data-idLote="' + d.idLote + '" ' +
                                'class="btn-data btn-green revisarSolicitud" style="margin-left: 3px;">' +
                                '<i class="fas fa-key"></i></button>';
                        }else{
                            buttons += '';
                        }

                        return '<div style="display:inline-flex">' + buttons + '</div>';
                    }
                }
            ]
        });
    });

    $(document).on('click', '.revisarSolicitud', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var id_evidencia = $itself.attr('data-id_evidencia');
        var idCliente = $itself.attr("data-idCliente");
        var nombreLote = $itself.attr("data-nombrelote");
        var idLote = $itself.attr('data-idLote');
        var evidencia = $itself.attr('data-evidencia');
        var rowType = $itself.attr('data-rowType');
        $('#idCliente').val(idCliente);
        $('#idLote').val(idLote);
        $('#id_evidencia').val(id_evidencia);
        $('#nombreLote').val(nombreLote);
        $('#evidencia_file').val(evidencia);
        $('#rowType').val(rowType);
        var cnt;
        var path_evidences = '<?=base_url()?>static/documentos/evidencia_mktd/';
        var extension_file = evidencia.split('.').pop();

        $.post("<?=base_url()?>index.php/Asesor/getSolicitudEvidencia/" + id_evidencia, function (data) {
            $('#loadAuts').empty();

            cnt = '<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 20px 0px;">';
            cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align: right">Fecha: ' + data[0]['fecha_creacion'] + '</p></div>';
            cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">';
            // cnt += '        <img src="'+path_evidences+data[0]['evidencia']+'" class="img-responsive">';
            if (extension_file == 'png' || extension_file == 'jpg' || extension_file == 'jpeg' || extension_file == 'gif') {
                cnt += '<center><img src="' + path_evidences + data[0]['evidencia'] + '" class="img-responsive zoom"></center>';
            } else {
                cnt += '<iframe class="responsive-iframe" src="' + path_evidences + data[0]['evidencia'] + '" style="width: 100%;height: 400px;"></iframe>';
            }
            cnt += '    </div>';
            cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            cnt += '    <label>Comentario cobranza:</label><br>';
            cnt += '        <p style="text-align: justify;padding: 10px">' + data[0]['comentario_autorizacion'] + '</p>';
            cnt += '    </div>';
            cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px">';
            cnt += '        <div class="col-md-6">';
            cnt += '            <label><input type="radio" name="accion" id="rechazoGer" value="0" required> Rechazar a cobranza</label>';
            cnt += '        </div>';
            cnt += '        <div class="col-md-6">';
            cnt += '            <label><input type="radio" name="accion" id="avanzaContra" value="1" required> Aceptar</label>';
            cnt += '        </div>';
            cnt += '        <div class="col-md-12">';
            cnt += '            <label>Escribe un comentario: </label>';
            cnt += '            <textarea style="width: 100%" class="form-control" name="comentario_contra" id="comentariocontra"></textarea>';
            cnt += '        </div>';
            cnt += '    </div>';
            cnt += '</div>';


            $('#loadAuts').append(cnt);
        }, 'json');

        $('#evidenciaModalRev').modal();

    });

    $(document).on('click', '#btnSubmit', function () {
        if (document.getElementById('rechazoGer').checked == false && document.getElementById('avanzaContra').checked == false) {
            alerts.showNotification('top', 'right', 'Ingresa una acción', 'danger');
            $('#avanzaContra').focus();
            $("#btnSubmit").attr("onclick", "validaEnviarAutorizacion()");
        } else {
            $("#button_enviar").click();
        }
    });

    /*function validaEnviarAutorizacion() {
        $("#btnSubmit").attr("onclick", "").unbind("click");
        if (document.getElementById('rechazoGer').checked == false && document.getElementById('avanzaContra').checked == false) {
            console.log("entra if");
            alerts.showNotification('top', 'right', 'Ingresa una acción', 'danger');
            $('#avanzaContra').focus();
            $("#btnSubmit").attr("onclick", "validaEnviarAutorizacion()");
        } else {
            console.log("etra else");
            $('#button_enviar').click();
        }
    }*/

    $("#sendRespFromCB").on('submit', function (e) { // MJ: FUNCIÓN PARA ACTUALIZAR EL ESTATUS DE LA EVIDENCIA / CONTROVERSIA
        let rowType = $("#rowType").val();
        let id_lote = $("#idLote").val();
        let comments = $("#comentariocontra").val();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Asesor/actualizaSolEviCN',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                // Actions before send post
            },
            success: function (data) {
                if (data == 1) {
                    $('#evidenciaModalRev').modal("hide");
                    $('#autorizarEvidencias').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "La validación se ha llevado a cabo de manera correcta.", "success");
                } else {
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });

        // AQUÍ ME FALTA VALIDAR CON EL NAME ACCION == 1
        if ((rowType == 11 || rowType == 22 || rowType == 33 || rowType == 44  || rowType == 55) && document.getElementById('avanzaContra').checked == true) { // MJ: CUANDO ES UNA CONTROVERSIA SE VA A MANDAR LLAMAR LA FUNCIÓN DE ADDREMOVEMKTD PARA AGREGAR MKTD

            $.ajax({
                type: 'POST',
                url: '<?=base_url()?>index.php/Comisiones/addRemoveMktd',
                data: {
                    'type_transaction': 1,
                    'comments': comments,
                    'id_lote': id_lote
                },
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        alerts.showNotification('top', 'right', 'Se ha agregado MKTD de esta venta de manera exitosa.', 'success');
                    } else {
                        alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'warning');
                    }
                }, error: function () {
                    alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
                }
            });
        }
    });
</script>