<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper ">
    <?php
    $this->load->view('template/sidebar');
    $this->load->view('template/controversy_modals');
    ?>
    <style type="text/css">
        .textoshead::placeholder {
            color: white;
        }

        .center-items {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px !important;
        }
        #sol_aut, #checkEvidencia{
            border:none;
        }
        .table-striped>tbody>tr:nth-of-type(odd){
            border:none;
        }
        table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
            border:none;
        }
    </style>

    <!-- insertar autorización modal 1-5-->
    <div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="subir_evidencia_form" name="subir_evidencia_form" method="post">
                    <div class="modal-header">
                        <div class="card-header d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="mx-3">
                                    <h4 class="modal-title">Subir evidencia</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label>Sube tu archivo:</label><br>
                        <div class="input-group"><label class="input-group-btn">
                                <span class="btn btn-primary btn-file">Seleccionar archivo&hellip;
                                    <input type="file" name="docArchivo1" id="expediente1" style="visibility: hidden"
                                           accept="image/x-png,image/gif,image/jpeg, image/jpg">
                                </span></label><input type="text" class="form-control" id="txtexp1" readonly></div>
                        <label>Observaciones : </label>
                        <textarea class="form-control" id="comentario_0" name="comentario_0" rows="3"
                                  style="width:100%;"
                                  placeholder="Ingresa tu comentario" maxlength="100"
                                  oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        <input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
                        <input type="hidden" name="idCliente" id="idCliente">
                        <input type="hidden" name="idLote" id="idLote">
                        <input type="hidden" name="id_sol" id="id_sol">
                        <input type="hidden" name="nombreLote" id="nombreLote">
                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit">
                            Enviar autorización
                        </a>

                        <button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización
                        </button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- editar autorización modal 1-5-->
    <div class="modal fade" id="editarAutorizacionEvidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="subir_evidencia_formE" name="subir_evidencia_formE" method="post">
                    <div class="modal-header">
                        <center><h4 class="modal-title" id="textoLote"></h4></center>
                    </div>
                    <div class="modal-body">
                        <div id="img_actual">

                        </div>
                        <label>Sube tu archivo:</label><br>
                        <div class="input-group"><label class="input-group-btn">
                                <span class="btn btn-primary btn-file">Seleccionar archivo&hellip;
                                    <input type="file" name="evidenciaE" id="evidenciaE" style="visibility: hidden"
                                           accept="image/x-png,image/gif,image/jpeg, image/jpg">
                                </span></label><input type="text" class="form-control" readonly></div>
                        <h5><b>Comentario cobranza:</b> <i id="lastComment"></i></h5>
                        <label>Observaciones : </label>
                        <textarea class="form-control" id="comentario_E" name="comentario_E" rows="3"
                                  style="width:100%;"
                                  placeholder="Ingresa tu comentario" maxlength="1000"
                                  oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        <input type="hidden" id="tamanocerE" name="tamanocerE" value="1" style="color: black">
                        <input type="hidden" name="id_evidenciaE" id="id_evidenciaE">
                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" onclick="return validateEmptyFieldsE()" id="btnSubmitE">
                            Enviar autorización
                        </a>

                        <button type="submit" id="btnSubmitEnviarE" class="btn btn-success hide"> Enviar autorización
                        </button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="preguntaDeleteMktd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cleanComments()"><i
                                class="material-icons">clear</i></button>
                </div>
                <div class="modal-body text-center">
                    <h5>¿Estás seguro de hacer este movimiento?</h5>
                    <p style="font-size: 0.8em">Eliminarás a MARKETING DIGITAL de esta venta.</p>
                    <textarea class="form-control" id="comentario_delete_mktd" name="comentario_delete_mktd" rows="3"
                              style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100"
                              oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-simple" data-dismiss="modal" onclick="cleanComments()">Cancelar
                        <div class="ripple-container">
                            <div class="ripple ripple-on ripple-out"
                                 style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div>
                        </div>
                    </button>
                    <button type="button" class="btn btn-success btn-simple" id="btn_delete_mktd">Sí</button>
                </div>
            </div>
        </div>
    </div>



    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm">
                        <li class="active"><a href="#soli" data-toggle="tab" onclick="javascript:$('#sol_aut').DataTable().ajax.reload();">SOLICITAR</a></li>
                        <li><a href="#aut" data-toggle="tab" onclick="javascript:$('#checkEvidencia').DataTable().ajax.reload();">AUTORIZACIONES DE EVIDENCIAS</a></li>
                    </ul>
                    <div class="card no-shadow m-0">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="active tab-pane" id="soli">
                                        <h3 class="card-title center-align">Solicitar</h3>
                                        <div class="table-responsive">
                                            <table id="sol_aut" class="table-striped table-hover"
                                                   style="text-align:center;width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>LOTE</th>
                                                    <th>ASESOR</th>
                                                    <!--<th>Plaza</th>-->
                                                    <th>FECHA APARTADO</th>
                                                    <th>TIPO</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="aut">
                                        <h3 class="card-title center-align">Autorizaciones de evidencia</h3>
                                        <div class="table-responsive">
                                            <table id="checkEvidencia"
                                                   class="table-striped table-hover"
                                                   style="text-align:center;width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>PLAZA</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>SOLICITANTE</th>
                                                    <th>ESTATUS</th>
                                                    <th>TIPO</th>
                                                    <th>VALIDACIÓN GERENTE</th>
                                                    <th>VALIDACIÓN COBRANZA</th>
                                                    <th>VALIDACIÓN CONTRALORÍA</th>
                                                    <th>RECHAZO COBRANZA</th>
                                                    <th>RECHAZO CONTRALORÍA</th>
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
        </div>
    </div>


    <div class="content hide">
        <div class="container-fluid">
            <!--            <h5 style="text-align: center">REGISTRO ESTATUS 6 (Corrida elaborada)</h5>-->
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Agregar evidencias</h4><br><br>
                            <div class="toolbar">
                            </div>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#soli" data-toggle="tab" onclick="javascript:$('#sol_aut').DataTable().ajax.reload();">SOLICITAR</a></li>
                                    <li><a href="#aut" data-toggle="tab" onclick="javascript:$('#checkEvidencia').DataTable().ajax.reload();">Autorizaciones de evidencias</a></li>
                                    <!--        <li><a href="#history" data-toggle="tab">Hitorial de Autorizaciones</a></li>-->
                                </ul>

                                <div class="tab-content">

                                    <div class="active tab-pane" id="soli">
                                        <div class="post">
                                            <div class="user-block">
                                                <table id="sol_aut" class="table table-bordered table-hover table-striped"
                                                       style="text-align:center;width: 100%">
                                                    <thead>
                                                    <tr>
                                                        <th>ID lote</th>
                                                        <th>Cliente</th>
                                                        <th>Teléfono</th>
                                                        <th>Lote</th>
                                                        <th>Asesor</th>
                                                        <!--<th>Plaza</th>-->
                                                        <th>Fecha apartado</th>
                                                        <th>Tipo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="aut">
                                        <div class="post">
                                            <div class="user-block">
                                                <div class="table-responsive">
                                                    <table id="checkEvidencia"
                                                           class="table display table-bordered table-hover table-striped"
                                                           style="text-align:center;width: 100%">
                                                        <thead>
                                                        <tr>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="ID lote">ID lote
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Fecha apartado">Fecha apartado
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Plaza">Plaza
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Lote">Lote
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Cliente">Cliente
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Solicitante">Solicitante
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Estatus">Estatus
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Estatus">Tipo
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Validación gerente">Validación gerente
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Validación cobranza">Validación cobranza
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="right"
                                                                title="Validación contraloría">Validación contraloría
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="left"
                                                                title="Rechazo cobranza">Rechazo cobranza
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="left"
                                                                title="Rechazo contraloría">Rechazo contraloría
                                                            </th>
                                                            <th data-toggle="tooltip" data-placement="left"
                                                                title="Acciones">Acciones
                                                            </th>
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
<script src="<?=base_url()?>dist/js/evidencias.js"></script>

<script>
    /*$(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });*/
    function validateEmptyFieldsBackup() {
        var miArray = [];
        // console.log("entró a la function "+ $("#tamanocer").val());
        for (i = 0; i < $("#tamanocer").val(); i++) {
            if ($("#comentario_" + i).val() == "") {
                $("#comentario_" + i).focus();
                // console.log("no tiene nada ---- "+ $("#comentario_"+i).val());
                alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
                miArray.push(0);
                return false;


            } else {
                console.log("lo que sea" + $("#comentario_" + i).val());
                miArray.push(1);
                console.log($('#txtexp1').val());
                //$('#btnSubmitEnviar').click();
                if ($('#expediente1')[0].files.length === 0) {
                    alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
                    return false;
                } else {
                    $('#btnSubmitEnviar').click();
                }
            }
        }
    }

    function validateEmptyFields() {
        var miArray = [];
        // console.log("entró a la function "+ $("#tamanocer").val());
        $("#btnSubmit").attr("onclick", "").unbind("click");
        for (i = 0; i < $("#tamanocer").val(); i++) {
            if ($('#expediente1')[0].files.length === 0) {
                alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
                $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
                return false;
            } else {
                $('#btnSubmitEnviar').click();
            }
        }
    }


    function validateEmptyFieldsEBackup() {
        var miArray = [];
        // console.log("entró a la function "+ $("#tamanocer").val());
        for (i = 0; i < $("#tamanocerE").val(); i++) {
            if ($("#comentario_E").val() == "") {
                $("#comentario_E").focus();
                // console.log("no tiene nada ---- "+ $("#comentario_"+i).val());
                alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
                miArray.push(0);
                return false;


            } else {
                console.log("lo que sea" + $("#comentario_E").val());
                miArray.push(1);
                //$('#btnSubmitEnviar').click();
                if ($('#evidenciaE')[0].files.length === 0) {
                    alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
                    return false;
                } else {
                    $('#btnSubmitEnviarE').click();
                }
            }
        }
    }

    function validateEmptyFieldsE() {
        var miArray = [];
        // console.log("entró a la function "+ $("#tamanocer").val());
        $("#btnSubmitE").attr("onclick", "").unbind("click");
        for (i = 0; i < $("#tamanocerE").val(); i++) {
            if ($('#evidenciaE')[0].files.length === 0) {
                alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
                $("#btnSubmitE").attr("onclick", "return validateEmptyFieldsE()");
                return false;
            } else {
                $('#btnSubmitEnviarE').click();
            }

        }
    }


    $(document).ready(function () {
        $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
            var input = $(this).closest('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        console.log('triggered');
    });


    /*agregar input de buscar al header de la tabla*/
    let titulos_intxt = [];
    $('#sol_aut thead tr:eq(0) th').each( function (i) {
        if( i!=7){
            $(this).css('text-align', 'center');
            var title = $(this).text();
            titulos_intxt.push(title);
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#sol_aut').DataTable().column(i).search() !== this.value ) {
                    $('#sol_aut').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }

    });
    /*Tabla donde se dan de alta las evidencias*/
    $(document).ready(function () {
        var table2;
        // let titulo_2 = [];
        // $('#sol_aut thead tr:eq(0) th').each(function (i) {
        //     if (i != 0 && i != 13) {
        //         var title = $(this).text();
        //         titulo_2.push(title);
        //     }
        // });
        table2 = $('#sol_aut').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "ordering": true,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Evidencias a solicitar ' ,
                    title:'Evidencias a solicitar ' ,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID LOTE';
                                        break;
                                    case 1:
                                        return 'CLIENTE';
                                        break;
                                    case 2:
                                        return 'TELÉFONO';
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'ASESOR';
                                        break;
                                    case 5:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 6:
                                        return 'TIPO';
                                        break;
                                }
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
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            columns: [
                {"data": "idLote"},
                {"data": "nombreCliente"},
                {"data": "telefono1"},
                {"data": "nombreLote"},
                {"data": "nombreAsesor"},
                //{"data": "plaza"},
                {"data": "fechaApartado"},
                {
                    "data": function (d) {
                        if (d.rowType == 1) { // MJ: EVIDENCA NATURAL: SIEMPRE HA SIDO MKTD
                            return "<small class='label bg-green' style='background-color: #2ECC71'>MKTD</small>";
                        } else if (d.rowType == 11) {// MJ: EVIDENCIA DE UNA CONTROVERSIA (NORMAL): NO ES VENTA
                            return "<small class='label bg-green' style='background-color: #F1C40F'>CONTROVERSIA (NORMAL)</small>"
                        } else if (d.rowType == 22) {// MJ: EVIDENCIA DE UNA CONTROVERSIA (PARA DESCUENTO): NO ES VENTA MKTD
                            return "<small class='label bg-green' style='background-color: #E67E22'>CONTROVERSIA (PARA DESCUENTO)</small>"
                        }
                    }
                },
                {
                    "data": function (d) {
                        var cntActions = '';

                        cntActions += '<center><button href="#" title= "Subir evidencia" data-nombreLote="' + d.nombreLote + '" data-idCliente="' + d.id_cliente + '"  data-idLote="' + d.idLote + '" class="btn-data btn-blueMaderas addEvidenciaClient"><span class="fas fa-cloud-upload-alt"></span></button></center>';

                        cntActions += '<button href="#" title= "Eliminar MKTD de esta venta" data-idLote="' + d.idLote + '" class="btn-data btn-gray delete_mktd"><span class="fas fa-trash"></span></button>';
                        return  '<div>'+cntActions+'</div>';
                    }
                }
            ],
            ajax: {
                url: "<?=base_url()?>index.php/asesor/getClientsByMKTDG/",
                type: "POST",
                cache: false
            },
        });
    });

    /*tabla donde se ven las evidencias y su estado actual*/

    /*agregar input de buscar al header de la tabla*/
    let titulos_intxt2 = [];
    $('#checkEvidencia thead tr:eq(0) th').each( function (i) {
        if( i!=13){
            $(this).css('text-align', 'center');
            var title = $(this).text();
            titulos_intxt2.push(title);
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#checkEvidencia').DataTable().column(i).search() !== this.value ) {
                    $('#checkEvidencia').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }

    });
    $(document).ready(function () {
        var table;
        table = $('#checkEvidencia').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "ordering": true,
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            },
            buttons: [
                {

                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Autorizaciones de evidencia',
                    title:'Autorizaciones de evidencia' ,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                        format: {
                            header:  function (d, columnIdx) {
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
                                            return 'VALIDACIÓN GERENTE';
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

                }/*,
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    className: 'btn btn-danger',
                    titleAttr: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                          format: {
                             header:  function (d, columnIdx) {
                                    switch (columnIdx) {
                                       case 0:
                                        return 'ID lote';
                                        break;
                                        case 1:
                                            return 'Fecha apartado';
                                        break;
                                        case 2:
                                            return 'Plaza';
                                        break;
                                        case 3:
                                            return 'Lote';
                                        break;
                                        case 4:
                                            return 'Cliente';
                                        break;
                                        case 5:
                                            return 'Solicitante';
                                        break;
                                        case 6:
                                            return 'Estatus';
                                        break;
                                        case 7:
                                            return 'Tipo';
                                        break;
                                        case 8:
                                            return 'Validación gerente';
                                        break;
                                        case 9:
                                            return 'Validación cobranza';
                                        break;
                                        case 10:
                                            return 'Validación contraloría';
                                        break;
                                        case 11:
                                            return 'Rechazo cobranza';
                                        break;
                                        case 12:
                                            return 'Rechazo contraloría';
                                        break;
                                    }
                                }
                            }
                    }
                }*/

            ],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true
            }],
            scrollX: true,
            fixedHeader: true,
            pageLength: 10,
            width: '100%',
            pagingType: "full_numbers",
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
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
                                labelStatus = '<span class="label" style="background:#27AE60;">ENVIADA A CONTRALORÍA</span>';
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
                        if (d.rowType == 1) { // MJ: EVIDENCA NATURAL: SIEMPRE HA SIDO MKTD
                            return "<small class='label bg-green' style='background-color: #2ECC71'>MKTD</small>";
                        } else if (d.rowType == 11) {// MJ: EVIDENCIA DE UNA CONTROVERSIA (NORMAL): NO ES VENTA
                            return "<small class='label bg-green' style='background-color: #F1C40F'>CONTROVERSIA (NORMAL)</small>"
                        } else if (d.rowType == 22) {// MJ: EVIDENCIA DE UNA CONTROVERSIA (PARA DESCUENTO): NO ES VENTA MKTD
                            return "<small class='label bg-green' style='background-color: #E67E22'>CONTROVERSIA (PARA DESCUENTO)</small>"
                        }
                    }
                },
                {"data": "fechaValidacionGerente"},
                {"data": "fechaValidacionCobranza"},
                {"data": "fechaValidacionContraloria"},
                {"data": "fechaRechazoCobranza"},
                {"data": "fechaRechazoContraloria"},
                {
                    // "data": "fecha_creacion"
                    "data": function (d) {
                        var cntActions = '';

                        cntActions += '<button href="#" title= "Ver comentarios" data-id_autorizacion="' + d.id_evidencia + '" data-idLote="' + d.idLote + '" class="btn-data btn-blueMaderas seeAuts" style="margin-right:5px"><span class="fas fa-comment-alt"></span></button>';
                        if (d.estatus == 10) {
                            /*cntActions += '<button href="#" title= "Reemplazar evidencia" data-evidencia="' + d.evidencia + '" data-nombreLote="' + d.nombreLote + '" data-id_evidencia="' + d.id_evidencia + '" class="btn btn-warning btn-round btn-fab btn-fab-mini change_evidence" style="margin-right:5px"><span class="material-icons">update</span></button>';*/
                            cntActions += `<button href="#" title= "Reemplazar evidencia" data-evidencia="${d.evidencia}" data-nombreLote="${d.nombreLote}" data-id_evidencia="${d.id_evidencia}" data-comment="${d.lastComment}" class="btn-data btn-warning change_evidence" style="margin-right:5px"><i class="fas fa-undo"></i></button>`;
                        }

                        if (d.estatus != 3) {
                            cntActions += '<button href="#" title= "Eliminar MKTD de esta venta" data-idLote="' + d.idLote + '" class="btn-data btn-gray delete_mktd" ><i class="fas fa-trash"></i></button>';
                        }
                        return '<div style="display:flex;">'+cntActions+'</div>';
                    }
                }
            ],

            "ajax": {
                "url": "<?=base_url()?>index.php/asesor/getEvidenciaGte/",
                "type": "POST",
                cache: false
            },
        });


    });

    $(document).on('click', '.delete_mktd', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var idLote = $itself.attr('data-idLote');
        $('#btn_delete_mktd').attr("data-idLote", idLote);
        $('#preguntaDeleteMktd').modal();
    });

    $(document).on('click', '#btn_delete_mktd', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var idLote = $itself.attr('data-idLote');
        var comentario_delete_mktd = $("#comentario_delete_mktd").val();
        var data = new FormData();
        data.append("id_lote", idLote);
        data.append("comments", comentario_delete_mktd);
        data.append("type_transaction", 2);
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Comisiones/addRemoveMktd',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {

            },
            success: function (data) {
                if (data == 1) {
                    $('#preguntaDeleteMktd').modal("hide");
                    $('#checkEvidencia').DataTable().ajax.reload();
                    $('#sol_aut').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'Se ha eliminado MKTD de esta venta de manera exitosa.', 'success');
                } else {
                    alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
                }
            },
            error: function () {
                alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
            }
        });
    });

    $(document).on('click', '.addEvidenciaClient', function () {
        var $itself = $(this);
        var id_cliente = $itself.attr('data-idcliente');
        var id_lote = $itself.attr('data-idlote');
        var nombreLote = $itself.attr('data-nombrelote');
        console.log("id_cliente: " + id_cliente);
        console.log("id_lote: " + id_lote);

        $('#idCliente').val(id_cliente);
        $('#idLote').val(id_lote);
        $('#nombreLote').val(nombreLote);
        $('#id_sol').val(<?=$this->session->userdata('id_usuario');?>);
        $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
        $('#solicitarAutorizacion').modal();
    });

    $("#subir_evidencia_form").on('submit', function (e) {
        e.preventDefault();
        console.log(this);
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Asesor/addEvidenceToCobranza',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSubmit').attr("disabled", "disabled");
                $('#btnSubmit').css("opacity", ".5");
                $("#btnSubmit").attr("onclick", "").unbind("click");

            },
            success: function (data) {
                if (data == 1) {
                    $('#btnSubmit').removeAttr("disabled");
                    $('#btnSubmit').css("opacity", "1");
                    $('#solicitarAutorizacion').modal("hide");
                    //toastr.success("Se enviaron las autorizaciones correctamente");
                    $('#subir_evidencia_form').trigger("reset");
                    $('#checkEvidencia').DataTable().ajax.reload();
                    $('#sol_aut').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'Se enviaron las autorizaciones correctamente', 'success');
                } else {
                    $('#btnSubmit').removeAttr("disabled");
                    $('#btnSubmit').css("opacity", "1");
                    //toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
                    alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
                    $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
                }
            },
            error: function () {
                $('#btnSubmit').removeAttr("disabled");
                $('#btnSubmit').css("opacity", "1");
                $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
                //toastr.error("ops, algo salió mal.");
                alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
            }
        });
    });

    $(document).on('click', '.change_evidence', function () {
        $('#img_actual').html('');
        var $itself = $(this);
        var id_evidencia = $itself.attr('data-id_evidencia');
        var evidencia = $itself.attr('data-evidencia');
        var nombreLote = $itself.attr('data-nombreLote');
        var dataComment = $itself.attr('data-comment');
        var img_cnt;
        var directory = '<?=base_url()?>static/documentos/evidencia_mktd/';
        var extension_file = evidencia.split('.').pop();


        img_cnt = '<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">';
        img_cnt += '    <h5>Evidencia actual: </h5>';
        if (extension_file == 'png' || extension_file == 'jpg' || extension_file == 'jpeg' || extension_file == 'gif') {
            img_cnt += '<center><img src="' + directory + evidencia + '" class="img-responsive"></center><br><br>';
        } else {
            img_cnt += '<iframe class="responsive-iframe" src="' + directory + evidencia + '" style="width: 100%;height: 400px;"></iframe><br><br>';
        }
        // img_cnt += '    <img class="img-responsive" src="'+directory+evidencia+'"><br><br>';
        img_cnt += '    <input value="' + evidencia + '" name="previousImg" type="hidden">';
        img_cnt += '</div>';
        $('#textoLote').text(nombreLote);
        $('#lastComment').text(dataComment);

        $('#img_actual').append(img_cnt);
        $('#id_evidenciaE').val(id_evidencia);
        $("#btnSubmitE").attr("onclick", "return validateEmptyFieldsE()");
        $('#editarAutorizacionEvidencia').modal();
    });


    $('#subir_evidencia_formE').on('submit', function (e) {

        /**modificar está parte**/
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/asesor/updateEvidenceChat',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                $('#btnSubmitE').attr("disabled", true);
                $('#btnSubmitE').css("opacity", ".5");
            },
            success: function (data) {
                console.log(data);
                if (data['exe'] == 1) {
                    $('#btnSubmitE').removeAttr("disabled");
                    $('#btnSubmitE').css("opacity", "1");
                    $('#editarAutorizacionEvidencia').modal("hide");
                    //toastr.success("Se enviaron las autorizaciones correctamente");
                    $('#subir_evidencia_formE').trigger("reset");
                    $('#checkEvidencia').DataTable().ajax.reload();
                    $('#sol_aut').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'Se enviaron las autorizaciones correctamente', 'success');
                } else {
                    $('#btnSubmitE').removeAttr("disabled");
                    $('#btnSubmitE').css("opacity", "1");
                    $("#btnSubmitE").attr("onclick", "return validateEmptyFieldsE()");
                    //toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
                    alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
                }
            },
            error: function () {
                $('#btnSubmitE').removeAttr("disabled");
                $('#btnSubmitE').css("opacity", "1");
                $("#btnSubmitE").attr("onclick", "return validateEmptyFieldsE()");
                //toastr.error("ops, algo salió mal.");
                alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
            }
        });
    });

    function cleanComments () {
            $("#comentario_delete_mktd").val("");
    }

</script>
