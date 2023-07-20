let titulosAu = [];
let titulosAutCliente = [];
let tablaAut = null;
let tablaAutClientes = null;

const TIPO_AUTORIZACION = Object.freeze({
    NORMAL: 1,
    CORREO: 2,
    SMS: 3
});

$(document).ready(function() {
    $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
        let input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });
});

function changeName(e){
    const fileName = e.files[0].name;
    let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
    relatedTarget[0].value = fileName;
}

$(document).on('change', '.btn-file :file', function() {
    let input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$('#addExp thead tr:eq(0) th').each( function (i) {
    const title = $(this).text();
    titulosAu.push(title);

    $(this).html('<input  class="textoshead" placeholder="'+title+'" data-toggle="tooltip" data-placement="top" title="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#addExp').DataTable().column(i).search() !== this.value ) {
            $('#addExp').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#aut-verificacion thead tr:eq(0) th').each( function (i) {
    const title = $(this).text();
    titulosAutCliente.push(title);

    $(this).html('<input  class="textoshead" placeholder="'+title+'" data-toggle="tooltip" data-placement="top" title="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#aut-verificacion').DataTable().column(i).search() !== this.value ) {
            $('#aut-verificacion').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready (function() {
    const funcionToGetData = (id_rol_general == 1) ? 'autsByDC' : 'tableAut';

    tablaAut = $('#addExp').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Tus autorizaciones',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: {
                        header: function (d, columnIdx) {
                            if (columnIdx <= 4) {
                                return ' ' + titulosAu[columnIdx] + ' ';
                            }
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Descargar archivo PDF',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title:'Tus autorizaciones',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: {
                        header: function (d, columnIdx) {
                            if (columnIdx <= 4) {
                                return ' ' + titulosAu[columnIdx] + ' ';
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        scrollX: true,
        ajax: `${general_base_url}index.php/registroCliente/${funcionToGetData}/`,
        columns: [
            { "data": "nombreResidencial" },
            { "data": "nombreLote" },
            {
                "data": function( d ){
                    return (d.cliente == null) ? "" : d.cliente;
                }
            },
            {
                "data": function( d ){
                    return (d.asesor == null) ? "" : d.asesor + '<br>';
                }
            },
            {
                "data": function( d ){
                    return (d.gerente == null) ? "" : d.gerente;
                }
            },
            {
                "data": function( d ){
                    return `
                        <div class="d-flex justify-center">
                            <a href="" class="btn-data btn-blueMaderas getInfo" data-id_autorizacion="${d.id_autorizacion}" data-idCliente="${d.id_cliente}" data-nombreResidencial="${d.nombreResidencial}" data-nombreCondominio="${d.nombreCondominio}" data-nombreLote="${d.nombreLote}" data-idCondominio="${d.idCondominio}" data-idLote="${d.idLote}"data-toggle="tooltip" data-placement="top" title="VER AUTORIZACIONES">
                            <i class="fas fa-key"></i>
                            </a>
                        </div>
                    `;
                }
            }]
    });

    $('#addExp').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    tablaAutClientes = $('#aut-verificacion').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Tus autorizaciones de verificación',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: {
                        header: function (d, columnIdx) {
                            if (columnIdx <= 4) {
                                return ' ' + titulosAutCliente[columnIdx] + ' ';
                            }
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Descargar archivo PDF',
                title: 'Tus autorizaciones de verificación',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: {
                        header: function (d, columnIdx) {
                            if (columnIdx <= 4) {
                                return ' ' + titulosAutCliente[columnIdx] + ' ';
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        scrollX: true,
        ajax: `${general_base_url}index.php/registroCliente/autorizacionesClienteCodigo`,
        columns: [
            { "data": "nombreResidencial" },
            { "data": "nombreLote" },
            {
                "data": function( d ){
                    return (d.cliente == null) ? "" : d.cliente;
                }
            },
            {
                "data": function( d ){
                    return (d.asesor == null) ? "" : d.asesor + '<br>';
                }
            },
            {
                "data": function( d ){
                    return (d.gerente == null) ? "" : d.gerente;
                }
            },
            {
                "data": function( d ){
                    return `
                        <div class="d-flex justify-center">
                            <a href="" class="btn-data btn-blueMaderas infoAut" data-id_autorizacion="${d.id_autorizacion}" data-idCliente="${d.id_cliente}" data-nombreResidencial="${d.nombreResidencial}" data-nombreCondominio="${d.nombreCondominio}" data-nombreLote="${d.nombreLote}" data-idCondominio="${d.idCondominio}" data-idLote="${d.idLote}"data-toggle="tooltip" data-placement="top" title="VER AUTORIZACIONES">
                            <i class="fas fa-key"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#aut-verificacion').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#addExp tbody").on("click", ".getInfo", function(e){
        e.preventDefault();

        const $itself = $(this);
        const idCliente = $itself.attr("data-idCliente");
        const nombreResidencial=$itself.attr('data-nombreresidencial');
        const nombreCondominio=$itself.attr('data-nombrecondominio');
        const idCondominio = $itself.attr("data-idCondominio");
        const nombreLote = $itself.attr("data-nombrelote");
        const idLote=$itself.attr('data-idLote');
        const id_aut = $itself.attr('data-id_autorizacion');

        $('#idCliente').val(idCliente);
        $('#idCondominio').val(idCondominio);
        $('#idLote').val(idLote);
        $('#id_autorizacion').val(id_aut);
        $('#nombreResidencial').val(nombreResidencial);
        $('#nombreCondominio').val(nombreCondominio);
        $('#nombreLote').val(nombreLote);

        $('#spiner-loader').removeClass('hide');

        $.post( `${general_base_url}index.php/registroLote/get_auts_by_lote_directivos/${idLote}`, function( data ) {
            $('#loadAuts').empty();
            let ctn;
            let p = 0;
            let opcionDenegado;
            $.each(JSON.parse(data), function(i, item) {
                opcionDenegado = (id_rol_general == 1)
                    ? ''
                    : `<p class="radioOption-Item m-0 pl-1">
                        <input type="radio" name="accion${i}" id="send${i}" value="3" class="d-none" aria-invalid="false">
                        <label for="send${i}" class="cursor-point m-0">
                            <i class="fas fa-paper-plane iSend" style="font-size:15px" data-toggle="tooltip" data-placement="top" title="ENVIAR A DC"></i>
                        </label>
                    </p>`;

                ctn = `
                    <div class="boxContent" style="margin-bottom:20px; padding: 10px; background: #f7f7f7; border-radius:15px">
                        <div class="d-flex">
                            <div class="w-80">
                                <small>
                                    <label class="m-0" style="font-size: 11px; font-weight: 100;">
                                        Solicitud asesor ( ${ item['fecha_creacion'].substr(0,10) })
                                    </label>
                                </small>
                            </div>
                            <div class="w-20">
                                <div class="radio-with-icon-autorizacones d-flex justify-end">
                                    <p class="radioOption-Item m-0">
                                        <input type="radio" name="accion${i}" id="accept${i}" value="0" class="d-none" aria-invalid="false">
                                        <label for="accept${i}" class="cursor-point m-0">
                                            <i class="fas fa-thumbs-up iAccepted" style="font-size:15px" data-toggle="tooltip" data-placement="top" title="ACEPTAR"></i>
                                        </label>
                                    </p>
                                    <p class="radioOption-Item m-0 pl-1">
                                        <input type="radio" name="accion${i}" id="denied${i}" value="2" class="d-none" aria-invalid="false">
                                        <label for="denied${i}" class="cursor-point m-0">
                                            <i class="fas fa-thumbs-down iDenied" style="font-size:15px" data-toggle="tooltip" 
                                                data-placement="top" title="RECHAZAR"></i>
                                        </label>
                                    </p>
                                    ${opcionDenegado}
                                </div>
                            </div>
                        </div>
                        <label>${ item['autorizacion'] }</label>
                        <div class="file-gph">
                            <input class="d-none" type="file" id="expediente${i}" name="docArchivo${i}" onchange="changeName(this)">
                            <input class="file-name" type="text" placeholder="No has seleccionada nada aún" >
                            <label class="upload-btn m-0" for="expediente${i}">
                                <span>Buscar</span>
                                <i class="fas fa-search"></i>
                            </label>
                        </div>
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Comentario</label>
                            <input type="text" name="observaciones${i}" class="form-control" style="border-radius:27px; border: 1px solid #cdcdcd; background-image: none; padding: 0 20px;">
                        </div>
                        <input type="hidden" name="idAutorizacion${i}"  value="${item['id_autorizacion']}">
                    </div>
                `;
                $('#loadAuts').append(ctn);
                p++;
            });

            introJs().start();

            $(".items").text(p);
            $('#numeroDeRow').val(p);
            $('#addFile').modal('show');
            $('#spiner-loader').addClass('hide');
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    });


    $("#aut-verificacion tbody").on("click", ".infoAut", function(e) {
        e.preventDefault();

        const $itself = $(this);
        const idCliente = $itself.attr("data-idCliente");
        const nombreResidencial=$itself.attr('data-nombreresidencial');
        const nombreCondominio=$itself.attr('data-nombrecondominio');
        const idCondominio = $itself.attr("data-idCondominio");
        const nombreLote = $itself.attr("data-nombrelote");
        const idLote=$itself.attr('data-idLote');
        const id_aut = $itself.attr('data-id_autorizacion');

        $('#idClienteAut').val(idCliente);
        $('#idCondominioAut').val(idCondominio);
        $('#idLoteAut').val(idLote);
        $('#id_autorizacion_aut').val(id_aut);
        $('#nombreResidencialAut').val(nombreResidencial);
        $('#nombreCondominioAut').val(nombreCondominio);
        $('#nombreLoteAut').val(nombreLote);
        $('#autorizacionesCliente').val(true);

        $('#spiner-loader').removeClass('hide');

        $.get(`${general_base_url}registroLote/getAutorizacionesClientePorLote/${idLote}`, function (data) {
            $('#loadAutsCliente').empty();
            let ctn;
            let p = 0;
            $.each(JSON.parse(data), function(i, item) {
                ctn = `
                    <div class="boxContent" style="margin-bottom:20px; padding: 10px; background: #f7f7f7; border-radius:15px">
                        <div class="d-flex">
                            <div class="w-80">
                                <small>
                                    <label class="m-0" style="font-size: 11px; font-weight: 100;">
                                        Solicitud de <b>${getTipoAutorizacion(item.id_tipo)}</b> ( ${ item['fecha_creacion'].substr(0,10) })
                                    </label>
                                </small>
                            </div>
                            <div class="w-20">
                                <div class="radio-with-icon-autorizacones d-flex justify-end">
                                    <p class="radioOption-Item m-0">
                                        <input type="radio" name="accion${i}" id="acceptAut${i}" value="0" class="d-none" aria-invalid="false">
                                        <label for="acceptAut${i}" class="cursor-point m-0">
                                            <i class="fas fa-thumbs-up iAccepted" style="font-size:15px" data-toggle="tooltip" data-placement="top" title="ACEPTAR"></i>
                                        </label>
                                    </p>
                                    <p class="radioOption-Item m-0 pl-1">
                                        <input type="radio" name="accion${i}" id="deniedAut${i}" value="2" class="d-none" aria-invalid="false">
                                        <label for="deniedAut${i}" class="cursor-point m-0">
                                            <i class="fas fa-thumbs-down iDenied" style="font-size:15px" data-toggle="tooltip" 
                                                data-placement="top" title="RECHAZAR"></i>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <label>${ item['autorizacion'] }</label>
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Comentario</label>
                            <input type="text" name="observaciones${i}" class="form-control" style="border-radius:27px; border: 1px solid #cdcdcd; background-image: none; padding: 0 20px;">
                        </div>
                        <input type="hidden" name="idAutorizacion${i}"  value="${item['id_autorizacion']}">
                        <input type="hidden" name="tipo${i}" value="${item.id_tipo}">
                    </div>
                `;
                $('#loadAutsCliente').append(ctn);
                p++;
            });

            introJs().start();

            $(".items-aut").text(p);
            $('#numeroDeRowAut').val(p);
            $('#autCliente').modal('show');
            $('#spiner-loader').addClass('hide');
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    });
});

jQuery(document).ready(function(){
    jQuery('#addFile').on('hidden.bs.modal', function () {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#expediente').val('');
        jQuery(this).find('#txtexp').val('');
        jQuery(this).find('#motivoAut').val('');
    })
});

$("#filtro4").on("change", function(){
    $('#addExp').DataTable().ajax.reload();
});

$("#sendAutsFromD").on('submit', function(e){
    e.preventDefault();

    if (parseInt($('#numeroDeRow').val()) !== $('#autClienteForm input:radio:checked').length) {
        alerts.showNotification("top", "right", "Debe APROBAR o RECHAZAR o ENVIAR A DC todas las solicitudes.", "warning");
        return;
    }

    let formData = new FormData(this);
    $('#spiner-loader').removeClass('hide');

    $.ajax({
        type: 'POST',
        url: `${general_base_url}RegistroCliente/updateAutsFromsDC`,
        data: formData,
        dataType: "json",
        contentType: false,
        processData:false,
        success: function(data) {
            alerts.showNotification("top", "right", data.mensaje, data.code);
            $('#addExp').DataTable().ajax.reload(null, false );
            $('#addFile').modal('hide');
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        },
        complete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#autClienteForm').on('submit', function (e) {
    e.preventDefault();

    if (parseInt($('#numeroDeRowAut').val()) !== $('#autClienteForm input:radio:checked').length) {
        alerts.showNotification("top", "right", "Debe APROBAR o RECHAZAR todas las solicitudes.", "warning");
        return;
    }

    $('#spiner-loader').removeClass('hide');

    $.ajax({
        type: 'POST',
        url: `${general_base_url}RegistroCliente/updateAutsFromsDC`,
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        processData: false,
        success: function(data) {
            alerts.showNotification("top", "right", data.mensaje, data.code);
            $('#aut-verificacion').DataTable().ajax.reload(null, false );
            $('#autCliente').modal('hide');
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        },
        complete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(window).resize(function(){
    tablaAut.columns.adjust();
    tablaAutClientes.columns.adjust();
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function getTipoAutorizacion(tipo) {
    if (parseInt(tipo) === TIPO_AUTORIZACION.CORREO) {
        return 'CORREO';
    }
    if (parseInt(tipo) === TIPO_AUTORIZACION.SMS) {
        return 'SMS';
    }

    return '';
}