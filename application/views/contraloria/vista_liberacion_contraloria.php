<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

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
                                                        <!--<button class="btn btn-success btn-round btn-fab btn-fab-mini m-0"
                                                                title="Aplicar cambios" style="margin: 0;">
                                                            <span class="material-icons apply-changes" data-type="1">done</span>
                                                        </button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!------->
                                <div class="row pt-2 row-load ">
                                    <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">

                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-evenly">

                                        <button class="btn-rounded btn-s-blueLight hide" name="uploadFile" id="uploadFile" title="Subir plantilla" data-toggle="modal" data-target="#uploadModal">
                                            <i class="fas fa-upload"></i>
                                        </button> <!-- UPLOAD -->
                                    </div>
                                </div>



                                <div class="modal" tabindex="-1" role="dialog" id="uploadModal" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h5 class="text-center">Selección de archivo a cargar</h5>
                                                <div class="file-gph">
                                                    <input class="d-none" type="file" id="fileElm">
                                                    <input class="file-name" id="file-name"  type="text" placeholder="No has seleccionada nada aún" readonly="">
                                                    <label class="upload-btn m-0" for="fileElm">
                                                        <span>Seleccionar</span>
                                                        <i class="fas fa-folder-open"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                                                <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--modal para quitar marca-->
                                <div class="modal" tabindex="-1" role="dialog" id="uploadModalQM" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h5 class="text-center">Selección de archivo a cargar</h5>
                                                <p class="text-center">Selecciona el archivo con los lotes para quitarles la marca de forma masiva</p>
                                                <div class="file-gph">
                                                    <input class="d-none" type="file" id="fileEmQM">
                                                    <input class="file-name" id="file-nameQM"  type="text" placeholder="No has seleccionada nada aún" readonly="">
                                                    <label class="upload-btn m-0" for="fileEmQM">
                                                        <span>Seleccionar</span>
                                                        <i class="fas fa-folder-open"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                                                <button class="btn btn-primary" id="cargarArchivoQM" data-toggle="modal">Cargar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Modals -->

                                <!------->
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
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>

<script>

    let url = "<?=base_url()?>";
    $(document).ready(function () {
        getResidenciales();
    });





    $(document).on('click', '#uploadFile', function () {
        document.getElementById("fileElm").value = "";
        document.getElementById("file-name").value = "";
    });

    $(document).ready(function () {
        $("input:file").on("change", function () {
            var target = $(this);
            var relatedTarget = target.siblings(".file-name");
            var fileName = target[0].files[0].name;
            relatedTarget.val(fileName);
        });
    });
    function readFileAsync(selectedFile) {
        return new Promise((resolve, reject) => {
            let fileReader = new FileReader();
            fileReader.onload = function (event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                    type: "binary",
                    cellDates:true,


                });
                //workbook.deleteData(wb, sheet = 1, cols = LETTERS, rows = 18, gridExpand = TRUE)
                workbook.SheetNames.forEach(sheet => {
                    rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet], {defval: ''});
                    console.log(rowObject);
                    jsonProspectos = JSON.stringify(rowObject, null);
                });
                resolve(jsonProspectos);
            };
            fileReader.onerror = reject;
            fileReader.readAsArrayBuffer(selectedFile);
        })
    }
    async function processFile(selectedFile) {
        try {
            let arrayBuffer = await readFileAsync(selectedFile);
            console.log(arrayBuffer);
            return arrayBuffer;
        } catch (err) {
            console.log(err);
        }
    }
    $(document).on('click', '#cargaCoincidencias', function () {
        fileElm = document.getElementById("fileElm");
        file = fileElm.value;
        // console.log(processFile(fileElm.files[0]));

        if (file == '')
            alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
        else {
            let extension = file.substring(file.lastIndexOf("."));
            let statusValidateExtension = validateExtension(extension, ".xlsx");
            if (statusValidateExtension == true) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
                //let lotes = $("#lotes").val();
                processFile(fileElm.files[0]).then(jsonInfo => {
                    console.log(processFile(fileElm.files[0]));
                    $.ajax({
                        url: 'setData',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "jsonInfo": jsonInfo
                            //"lotes": lotes
                        },
                        success: function (response) {

                            if (response == 0) {
                                alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                                $('#uploadModal').modal('toggle');

                                $("#modalConfirmRequest").modal("hide");
                                $("#liberacionesTable").DataTable().ajax.reload();
                            } else {
                                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                            }



                        }
                    });
                });
            } else // MJ: EL ARCHIVO QUE SE INTENTA CARGAR TIENE UNA EXTENSIÓN INVÁLIDA
                alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuera seleccionar un archivo <b>.xlsx</b>.", "warning");
        }
    });
    $(document).on('click', '#cargarArchivoQM', function () {
        fileElmQM = document.getElementById("fileEmQM");
        file = fileElmQM.value;
        // console.log(processFile(fileElm.files[0]));

        if (file == '')
            alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
        else {
            let extension = file.substring(file.lastIndexOf("."));
            let statusValidateExtension = validateExtension(extension, ".xlsx");
            if (statusValidateExtension == true) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
                //let lotes = $("#lotes").val();
                processFile(fileElmQM.files[0]).then(jsonInfo => {
                    console.log(processFile(fileElmQM.files[0]));
                    $.ajax({
                        url: 'setDataQM',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "jsonInfo": jsonInfo
                            //"lotes": lotes
                        },
                        success: function (response) {

                            if (response == 0) {
                                alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                                $('#uploadModalQM').modal('toggle');

                                // $("#modalConfirmRequest").modal("hide");
                                $("#liberacionesTable").DataTable().ajax.reload();
                            } else {
                                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                            }



                        }
                    });
                });
            } else // MJ: EL ARCHIVO QUE SE INTENTA CARGAR TIENE UNA EXTENSIÓN INVÁLIDA
                alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuera seleccionar un archivo <b>.xlsx</b>.", "warning");
        }
    });

    function validateExtension(extension, allowedExtensions) {
        if (extension == allowedExtensions)
            return true;
        else
            return false;
    }




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

        var postData = "idResidencial=" + idResidencial;
        $.ajax({
            url: url + 'General/getCondominiosList',
            type: 'post',
            data:postData,
            dataType: 'html',
            success: function (response) {
                response = JSON.parse(response);
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    console.log('id:',id, ' - ', 'condominio:',name);
                    $("#selectCondominios").append($('<option>').val(id).text(name));
                }
                fillTable(idResidencial);
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
        var generalDataTable = $('#liberacionesTable').dataTable({
            dom: "Brtip",
            width: "auto",
            select: {
                style: 'single'
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: '',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-success buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'ID_LOTE';
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
                },
                {
                    extend: '',
                    title: 'Subir plantilla',
                    text: '<i class="fa fa-upload" aria-hidden="true"></i>',
                    className: 'btn buttons-azul  button-reaload subirLotes',
                    titleAttr: 'Subir plantilla',
                },
                {
                    extend: '',
                    title: 'Subir plantilla para remoción de marcas',
                    text: '<i class="fa fa-times" aria-hidden="true"></i>',
                    className: 'btn buttons-orange  button-reaload bajarLotes',
                    titleAttr: 'Subir plantilla para remoción de marcas',
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
                        if (d.estatusLiberacion == "En proceso de liberación")
                            btns += '<br><button class="btn btn-success btn-round btn-fab btn-fab-mini m-1 remove-mark" title="Remover marca" style="margin: 15px;" data-idLote="' + d.idLote + '"><span class="material-icons" data-type="1">clear</span></button>';
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
                        return '<input type="checkbox" disabled name="idT[]" style="width:20px; height:20px;" value="' + full.idLote + '">';
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

        $('#liberacionesTable').on('init.dt', function() {
            $('.subirLotes')
                .attr('data-toggle', 'modal')
                .attr('data-target', '#uploadModal');
                // .attr('title', '');
        });

        $('#liberacionesTable').on('init.dt', function() {
            $('.bajarLotes')
                .attr('data-toggle', 'modal')
                .attr('data-target', '#uploadModalQM');
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


