Shadowbox.init();
let getInfo2A = new Array(7);
let getInfo2_2A = new Array(7);
let getInfo5A = new Array(7);
let getInfo6A = new Array(7);
let getInfo2_3A = new Array(7);
let getInfo2_7A = new Array(7);
let getInfo5_2A = new Array(7);
let return1a = new Array(7);
let tipo_comprobante ;
let aut;
let titulos_intxt = [];
let cliente = null;

const MOVIMIENTOS = Object.freeze({
    RECHAZO_CONTRALORIA_ESTATUS_5: 20,
    NUEVO_APARTADO: 31,
    RECHAZO_CONTRALORIA_ESTATUS_6: 63,
    RECHAZO_VENTAS_ESTATUS_8: 73,
    RECHAZO_JURIDICO_ESTATUS_7: 82,
    RECHAZO_CONTRALORIA_ESTATUS_2: 85,
    RECHAZO_CONTRALORIA_ESTATUS_5_II: 92,
    RECHAZO_JURIDICO_ESTATUS_7_II: 96,
    RECHAZO_POSTVENTA_ESTATUS_3: 99,
    RECHAZO_CONTRALORIA_ESTATUS_2_II: 102,
    RECHAZO_CONTRALORIA_ESTATUS_6_II: 104,
    RECHAZO_CONTRALORIA_ESTATUS_6_III: 107,
    RECHAZO_POSTVENTA_ESTATUS_3_II: 108,
    RECHAZO_JURIDICO_ESTATUS_7_III: 109,
    RECHAZO_POSTVENTA_3: 111,
});
const ESTATUS_AUTORIZACION = Object.freeze({
    ENVIADO: 1,
    AUTORIZADO: 2
});
const STATUS_CONTRATACION = 1;

$('#tabla_deposito_seriedad thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);

    $('input', this).on('keyup change', function () {
        if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value) {
            $('#tabla_deposito_seriedad').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function() {
    if (id_usuario_general == 9651) { // MJ: ERNESTO DEL PINO SILVA
        $('#tabla_deposito_seriedad').addClass('hide');
        $.post(`${general_base_url}Contratacion/lista_proyecto`, function(data) {
            for(let i = 0; i < data.length; i++){
                const id = data[i]['idResidencial'];
                const name = data[i]['descripcion'];
                $('#proyecto').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#proyecto').selectpicker('refresh');
        }, 'json');
    } else { // MJ: PARA LOS DEMÁS SÍ CARGA EN EL READY
        fillDataTable(0);
    }

    $('#subdirector').empty().selectpicker('refresh');
    $.get(`${general_base_url}Asesor/getSubdirectores`, function (data) {
        const subdirectores = JSON.parse(data);
        subdirectores.forEach(subdirector => {
            $('#subdirector').append($('<option>').val(subdirector.id_subdir).text(subdirector.nombre_subdir));
        });
        $('#subdirector').selectpicker('refresh');
    });
});

$('#proyecto').change( function(){
    const proyecto = $(this).val();
    $("#condominio").html("");
    $(document).ready(function(){
        $.post(`${general_base_url}Contratacion/lista_condominio/`+proyecto, function(data) {
            $('#condominio').append($('<option disabled selected>Selecciona un codominio</option>'));
            for(let i = 0; i < data.length; i++) {
                const id = data[i]['idCondominio'];
                const name = data[i]['nombre'];
                $('#condominio').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
});

$('#condominio').change( function(){
    $('#tabla_deposito_seriedad').removeClass('hide');
    fillDataTable($(this).val());
});

$("#tabla_deposito_seriedad").ready( function(){
    $(document).on('click', '.abrir_prospectos', function () {
        $('#nom_cliente').html('');
        $('#id_cliente_asignar').val(0);
        const $itself = $(this);
        const id_cliente = $itself.attr('data-idCliente');
        const nombre_cliente = $itself.attr('data-nomCliente');
        $('#nom_cliente').append(nombre_cliente);
        $('#id_cliente_asignar').val(id_cliente);
        tabla_valores_ds = $("#table_prospectos").DataTable({
            width: '100%',
            bAutoWidth: true,
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            scrollX: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Prospectos',
                title:"Prospectos",
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Prospectos',
                title:"Prospectos",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            }],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            "pageLength": 10,
            "fixedColumns": true,
            "ordering": false,
            "destroy": true,
            "language": {
                "url": general_base_url+"static/spanishLoader.json"
            },
            "order": [[4, "desc"]],
            columns: [
                {
                    "data": function(d){
                        return `${d.nombre} ${d.apellido_paterno} ${d.apellido_materno}`;
                    }
                },
                {
                    "data": function(d){
                        return myFunctions.validateEmptyField(d.correo);
                    }
                },
                {
                    "data": function(d){
                        return d.telefono;
                    }
                },
                {
                    "data": function(d){
                        var info = '';
                        info = myFunctions.validateEmptyField(d.observaciones)
                        return info;
                    }
                },
                {
                    "data": function(d){
                        return d.lugar_prospeccion;
                    }
                },
                {
                    "data": function(d){
                        return d.plaza_venta;
                    }
                },
                {
                    "data": function(d){
                        return d.nacionalidad;
                    }
                },
                {
                    "data": function(d){
                        return '<center><button class="btn-data btn-green became_prospect_to_cliente"' +
                            'data-id_prospecto="'+d.id_prospecto+'" data-id_cliente="'+id_cliente+'" data-toggle="tooltip" data-placement="top" title="NUEVO PROSPECTO">' +
                            '<i class="fas fa-user-check"></i></button></center>';
                    }
                },
            ],
            "ajax": {
                "url": general_base_url+"Asesor/get_info_prospectos/",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });
        $('#asignar_prospecto_a_cliente').modal();
    });

    let titulos_encabezado = [];
    $('#table_prospectos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $( 'input', this ).on('keyup change', function () {
            if ($('#table_prospectos').DataTable().column(i).search() !== this.value ) {
                $('#table_prospectos').DataTable().column(i).search(this.value).draw();
            }
        });
        titulos_encabezado.push(title);
    });

    $(document).on('click', '.became_prospect_to_cliente', function() {
        const $itself = $(this);
        const id_cliente = $itself.attr('data-id_cliente');
        const id_prospecto = $itself.attr('data-id_prospecto');
        $('#modal_pregunta').modal();
        $(document).on('click', '#asignar_prospecto', function () {
            $.ajax({
                type: 'POST',
                url: general_base_url+'asesor/prospecto_a_cliente',
                data: {'id_prospecto':id_prospecto,'id_cliente':id_cliente},
                dataType: 'json',
                beforeSend: function(){
                    $('#modal_loader_assign').modal();
                },
                success: function(data) {
                    if (data.cliente_update == 'OK' && data.prospecto_update=='OK') {
                        $('#modal_loader_assign').modal("hide");
                        $('#asignar_prospecto_a_cliente').modal('hide');
                        $('#table_prospectos').DataTable().ajax.reload();
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification('top', 'right', 'Se ha asignado correctamente', 'success');
                    } else {
                        alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado verificalo ['+data+']', 'danger');
                    }
                },
                error: function(){
                    $('#modal_loader_assign').modal("hide");
                    $('#asignar_prospecto_a_cliente').modal('hide');
                    $('#table_prospectos').DataTable().ajax.reload();
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'OCURRIO UN ERROR, INTENTALO DE NUEVO', 'danger');
                }
            });
        });
    });

    $(document).on('click', '#cancelar', function(){
        $('#asignar_prospecto_a_cliente').css({overflow:'auto'});
    });

    $(document).on('click', '.pdfLink2', function () {
        const $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink22', function () {
        const $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });
});

$(document).on("click", ".getInfo2", function (e) {
    e.preventDefault();
    getInfo2A[0] = $(this).attr("data-idCliente");
    getInfo2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2A[3] = $(this).attr("data-idCondominio");
    getInfo2A[4] = $(this).attr("data-nombreLote");
    getInfo2A[5] = $(this).attr("data-idLote");
    getInfo2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal1').modal('show');
});

$(document).on("click", ".getInfo2_2", function (e) {
    e.preventDefault();
    getInfo2_2A[0] = $(this).attr("data-idCliente");
    getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_2A[3] = $(this).attr("data-idCondominio");
    getInfo2_2A[4] = $(this).attr("data-nombreLote");
    getInfo2_2A[5] = $(this).attr("data-idLote");
    getInfo2_2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal2').modal('show');
});

$(document).on("click", ".getInfo5", function (e) {
    e.preventDefault();
    getInfo5A[0] = $(this).attr("data-idCliente");
    getInfo5A[1] = $(this).attr("data-nombreResidencial");
    getInfo5A[2] = $(this).attr("data-nombreCondominio");
    getInfo5A[3] = $(this).attr("data-idCondominio");
    getInfo5A[4] = $(this).attr("data-nombreLote");
    getInfo5A[5] = $(this).attr("data-idLote");
    getInfo5A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal3').modal('show');
});

$(document).on("click", ".getInfo6", function (e) {
    e.preventDefault();
    getInfo6A[0] = $(this).attr("data-idCliente");
    getInfo6A[1] = $(this).attr("data-nombreResidencial");
    getInfo6A[2] = $(this).attr("data-nombreCondominio");
    getInfo6A[3] = $(this).attr("data-idCondominio");
    getInfo6A[4] = $(this).attr("data-nombreLote");
    getInfo6A[5] = $(this).attr("data-idLote");
    getInfo6A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal4').modal('show');
});

$(document).on("click", ".getInfo2_3", function (e) {
    e.preventDefault();
    getInfo2_3A[0] = $(this).attr("data-idCliente");
    getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_3A[3] = $(this).attr("data-idCondominio");
    getInfo2_3A[4] = $(this).attr("data-nombreLote");
    getInfo2_3A[5] = $(this).attr("data-idLote");
    getInfo2_3A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal5').modal('show');
});

$(document).on("click", ".getInfo2_7", function (e) {
    e.preventDefault();
    getInfo2_7A[0] = $(this).attr("data-idCliente");
    getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
    getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
    getInfo2_7A[3] = $(this).attr("data-idCondominio");
    getInfo2_7A[4] = $(this).attr("data-nombreLote");
    getInfo2_7A[5] = $(this).attr("data-idLote");
    getInfo2_7A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal6').modal('show');
});

$(document).on("click", ".getInfo5_2", function (e) {
    e.preventDefault();
    getInfo5_2A[0] = $(this).attr("data-idCliente");
    getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
    getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
    getInfo5_2A[3] = $(this).attr("data-idCondominio");
    getInfo5_2A[4] = $(this).attr("data-nombreLote");
    getInfo5_2A[5] = $(this).attr("data-idLote");
    getInfo5_2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal7').modal('show');
});

$(document).on("click", ".return1", function (e) {
    e.preventDefault();
    return1a[0] = $(this).attr("data-idCliente");
    return1a[1] = $(this).attr("data-nombreResidencial");
    return1a[2] = $(this).attr("data-nombreCondominio");
    return1a[3] = $(this).attr("data-idCondominio");
    return1a[4] = $(this).attr("data-nombreLote");
    return1a[5] = $(this).attr("data-idLote");
    return1a[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#modal_return1').modal('show');
});

function fillDataTable(idCondominio) {
    tabla_valores_ds = $("#tabla_deposito_seriedad").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        pageLength: 10,
        ordering: false,
        destroy: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Tus ventas',
            title:"Tus ventas",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Tus ventas',
                title:"Tus ventas",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            { "data": "nombreResidencial" },
            { "data": "nombreCondominio" },
            { "data": "nombreLote" },
            { "data": "nombreCliente" },
            {
                "data": function( d ){
                    return d.coordinador;
                }
            },
            {
                "data": function( d ){
                    return d.gerente;
                }
            },
            {
                "data": function( d ){
                    return d.subdirector;
                }
            },
            {
                "data": function( d ){
                    return d.regional;
                }
            },
            {
                "data": function( d ){
                    return d.regional2;
                }
            },
            { "data": "fechaApartado" },
            {
                "data": function( d ){
                    return (
                        [
                            MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II,
                            MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II,
                            MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III,
                            MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III,
                            MOVIMIENTOS.RECHAZO_POSTVENTA_3
                        ].includes(d.idMovimiento)
                    ) ? d.modificado : d.fechaVenc;
                }
            },
            {
                "data": function( d ){
                    const idMovimiento = parseInt(d.idMovimiento);
                    if (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO) {
                        return `${d.comentario}<br><span class='label lbl-sky'>Nuevo apartado</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Ventas estatus 8</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_3) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo de Contraloría estatus 6</span>`;
                    }
                    return d.comentario;
                }
            },
            {
                "data" : function(d){
                    if (d.dsType != 1) {
                        return '';
                    }
                    if (parseInt(d.idMovimiento) !== MOVIMIENTOS.NUEVO_APARTADO && parseInt(d.idStatusContratacion) !== STATUS_CONTRATACION) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                    if (d.id_prospecto != 0) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                    if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                return '<p>DEBES ASIGNAR EL PROSPECTOS AL CLIENTE PARA PODER ACCEDER AL DEPÓSITO DE SERIEDAD O INTEGRAR EL EXPEDIETNE</p>';
                }
            },
            {
                "data": function (d) {
                    if (d.autorizacion_correo === null) {
                        return "<span class='label lbl-gray'>Sin envío de verificación</span>";
                    }
                    if (parseInt(d.total_sol_correo_pend) > 0) {
                        return "<span class='label lbl-azure'>Solicitud de autorización</span>";
                    }
                    if (parseInt(d.total_sol_correo_rech) > 0 && parseInt(d.total_sol_correo_aut) === 0 && parseInt(d.total_sol_correo_pend) === 0) {
                        return "<span class='label lbl-warning'>Solicitud rechazada</span>";
                    }
                    if (parseInt(d.autorizacion_correo) === 1) {
                        return `<span class='label lbl-yellow'>Verificación pendiente:</span></br>&nbsp;<span class='label lbl-yellow'>${d.correo}</span>`;
                    }
                    if (parseInt(d.autorizacion_correo) === 2) {
                        return `<span class='label lbl-green'>Verificado:</span></br>&nbsp;<span class='label lbl-green'>${d.correo}</span>`;
                    }
                    return '';
                }
            },
            {
                "data": function (d) {
                    if (d.autorizacion_sms === null) {
                        return "<span class='label lbl-gray'>Sin envío de verificación</span>";
                    }
                    if (parseInt(d.total_sol_sms_pend) > 0) {
                        return "<span class='label lbl-azure'>Solicitud de autorización</span>";
                    }
                    if (parseInt(d.total_sol_sms_rech) > 0 && parseInt(d.total_sol_sms_aut) === 0 && parseInt(d.total_sol_sms_pend) === 0) {
                        return "<span class='label lbl-warning'>Solicitud rechazada</span>";
                    }
                    if (parseInt(d.autorizacion_sms) === 1) {
                        return `<span class='label lbl-yellow'>Verificación pendiente:</span></br>&nbsp;<span class='label lbl-yellow'>${d.telefono}</span>`;
                    }
                    if (parseInt(d.autorizacion_sms) === 2) {
                        return `<span class='label lbl-green'>Verificado:</span></br>&nbsp;<span class='label lbl-green'>${d.telefono}</span>`;
                    }
                    return '';
                }
            },
            {
                "data": function( d ){
                    let atributoButton = '';
                    let buttons = '';
                    const idMovimiento = parseInt(d.idMovimiento);
                    const idStatusContratacion = parseInt(d.idStatusContratacion);
                    if(d.vl == '1') {
                        buttons = 'En proceso de Liberación';
                    } else if (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO && idStatusContratacion === STATUS_CONTRATACION) {
                        if (d.id_prospecto == 0) {
                            if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                                buttons = construirBotonEstatus(d, d.fechaVenc, 'getInfo2');
                            } else {
                                buttons = construirBotonEstatus(d, d.fechaVenc, 'disabled', 'disabled');
                            }
                        } else {
                            buttons = construirBotonEstatus(d, d.fechaVenc, 'getInfo2');
                        }
                        buttons += generarBotonesAutorizacion(d);
                    } else {
                        buttons = (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2_2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo5')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo6')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2_3')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2_7')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) ? construirBotonEstatus(d, d.modificado, 'getInfo5_2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II) ? construirBotonEstatus(d, d.fechaVenc, 'return1')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3) ? construirBotonEstatus(d, d.fechaVenc, 'enviar_nuevamente_estatus3', '', 'Enviar a estatus 3')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_3) ? construirBotonEstatus(d, d.fechaVenc, 'getInfo2')
                            : d.comentario;
                    }
                    let urlToGo  = '';
                    if (d.idMovimiento == 31 && d.idStatusContratacion == STATUS_CONTRATACION) {
                        if (d.id_prospecto == 0) { // APARTADO DESDE LA PAGINA DE CIUDAD MADERAS
                            if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                                atributoButton = '';
                                urlToGo  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                            } else {
                                atributoButton = 'disabled';
                                urlToGo  = '#';
                            }
                        } else {
                            atributoButton = '';
                            urlToGo  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                        }
                    } else {
                        atributoButton = '';
                        urlToGo  = general_base_url+'Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                    }
                    if (d.dsType == 1){
                        buttons += '<a class="btn-data btn-blueMaderas btn_ds'+d.id_cliente+'" '+atributoButton+' id="btn_ds'+d.id_cliente+'" href="'+urlToGo+'" data-toggle="tooltip" data-placement="top" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                    } else if(d.dsType == 2) { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA OLD VERSION
                        buttons += '<a class="btn-data btn-blueMaderas" href="'+general_base_url+'Asesor/deposito_seriedad_ds/'+d.id_cliente+'/0" data-toggle="tooltip" data-placement="left" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                    }
                    if(d.dsType == 2) { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA OLD VERSION
                        buttons += '<a class="btn-data btn-blueMaderas" href="'+general_base_url+'Asesor/deposito_seriedad_ds/'+d.id_cliente+'/0" data-toggle="tooltip" data-placement="left" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                    }
                    if (
                        d.dsType == 1 &&
                        (parseInt(d.idMovimiento) === MOVIMIENTOS.NUEVO_APARTADO && parseInt(d.idStatusContratacion) === STATUS_CONTRATACION) &&
                        d.id_prospecto == 0 &&
                        (d.id_coordinador != 10807 && d.id_coordinador != 10806 && d.id_gerente != 10807 && d.id_gerente != 10806)
                    ) {
                        buttons += `<button class="btn-data btn-green abrir_prospectos btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="ASIGNAR PROSPECTO" data-idCliente="${d.id_cliente}" data-nomCliente="${d.nombreCliente}"> <i class="fas fa-user-check"></i></button>`;
                    }
                    return '<div class="d-flex justify-center">'+buttons+'</div>';
                }
            }
        ],
        ajax: {
            url: general_base_url+"Asesor/tableClienteDS/",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "idCondominio": idCondominio,
            }
        }
    });
}

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    const comentario = $("#comentario").val();
    const validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    let dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);
    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/intExpAsesor/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE Y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al envial la solicitud.", "danger");
                } else if(response.message == 'MISSING_AUTORIZACION'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE AUTORIZACIÓN. Hasta que la autorización no haya sido aceptada o rechazada, no podrás avanzar la solicitud.", "danger");
                } else if(response.message == 'OBSERVACION_CONTRATO'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás avanzar la solicitud hasta que el proceso de liberación haya concluido", "danger");
                } else if (response.message == 'VERIFICACION CORREO/SMS') {
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El correo electrónico y/o número telefónico no están verificados.", "danger");
                }
            },
            error: function(){
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#guardar_re3pv', function(e) {
    e.preventDefault();
    const comentario = $("#comentarioST3PV2").val();
    const validaComent = ($("#comentarioST3PV2").val().length == 0) ? 0 : 1;
    let dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);
    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#guardar_re3pv').prop('disabled', true);
        $.ajax({
            url : general_base_url+'Postventa/enviarLoteARevisionPostVenta3/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE Y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al envial la solicitud.", "danger");
                } else if(response.message == 'MISSING_AUTORIZACION'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV  ').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE AUTORIZACIÓN. Hasta que la autorización no haya sido aceptada o rechazada, no podrás avanzar la solicitud.", "danger");
                } else if(response.message == 'OBSERVACION_CONTRATO'){
                    $('#guardar_re3pv').prop('disabled', false);
                    $('#enviarNuevamenteEstatus3PV').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás avanzar la solicitud hasta que el proceso de liberación haya concluido", "danger");
                }
            },
            error: function( data ){
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save2', function(e) {
    e.preventDefault();
    const comentario = $("#comentario2").val();
    const validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;
    let dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo2_2A[0]);
    dataExp2.append("nombreResidencial", getInfo2_2A[1]);
    dataExp2.append("nombreCondominio", getInfo2_2A[2]);
    dataExp2.append("idCondominio", getInfo2_2A[3]);
    dataExp2.append("nombreLote", getInfo2_2A[4]);
    dataExp2.append("idLote", getInfo2_2A[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2_2A[6]);
    dataExp2.append('tipo_comprobante', tipo_comprobante);
    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/intExpAsesor/',
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function(e) {
    e.preventDefault();
    const comentario = $("#comentario3").val();
    const validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
    let dataExp3 = new FormData();
    dataExp3.append("idCliente", getInfo5A[0]);
    dataExp3.append("nombreResidencial", getInfo5A[1]);
    dataExp3.append("nombreCondominio", getInfo5A[2]);
    dataExp3.append("idCondominio", getInfo5A[3]);
    dataExp3.append("nombreLote", getInfo5A[4]);
    dataExp3.append("idLote", getInfo5A[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo5A[6]);
    dataExp3.append('tipo_comprobante', tipo_comprobante);
    let comprobante_domicilio = (tipo_comprobante==1) ? '' : ', COMPROBANTE DE DOMICILIO';
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL "+comprobante_domicilio+", RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save3').prop('disabled', false);
                $('#modal3').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save4', function(e) {
    e.preventDefault();
    const comentario = $("#comentario4").val();
    const validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
    let dataExp4 = new FormData();
    dataExp4.append("idCliente", getInfo6A[0]);
    dataExp4.append("nombreResidencial", getInfo6A[1]);
    dataExp4.append("nombreCondominio", getInfo6A[2]);
    dataExp4.append("idCondominio", getInfo6A[3]);
    dataExp4.append("nombreLote", getInfo6A[4]);
    dataExp4.append("idLote", getInfo6A[5]);
    dataExp4.append("comentario", comentario);
    dataExp4.append("fechaVenc", getInfo6A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save4').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
            data: dataExp4,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save4').prop('disabled', false);
                $('#modal4').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save5', function(e) {
    e.preventDefault();
    const comentario = $("#comentario5").val();
    const validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;
    let dataExp5 = new FormData();
    dataExp5.append("idCliente", getInfo2_3A[0]);
    dataExp5.append("nombreResidencial", getInfo2_3A[1]);
    dataExp5.append("nombreCondominio", getInfo2_3A[2]);
    dataExp5.append("idCondominio", getInfo2_3A[3]);
    dataExp5.append("nombreLote", getInfo2_3A[4]);
    dataExp5.append("idLote", getInfo2_3A[5]);
    dataExp5.append("comentario", comentario);
    dataExp5.append("fechaVenc", getInfo2_3A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save5').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2/',
            data: dataExp5,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save6', function(e) {
    e.preventDefault();
    const comentario = $("#comentario6").val();
    const validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
    let dataExp6 = new FormData();
    dataExp6.append("idCliente", getInfo2_7A[0]);
    dataExp6.append("nombreResidencial", getInfo2_7A[1]);
    dataExp6.append("nombreCondominio", getInfo2_7A[2]);
    dataExp6.append("idCondominio", getInfo2_7A[3]);
    dataExp6.append("nombreLote", getInfo2_7A[4]);
    dataExp6.append("idLote", getInfo2_7A[5]);
    dataExp6.append("comentario", comentario);
    dataExp6.append("fechaVenc", getInfo2_7A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save6').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/envioRevisionAsesor2aJuridico7/',
            data: dataExp6,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save7', function(e) {
    e.preventDefault();
    const comentario = $("#comentario7").val();
    const validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;
    let dataExp7 = new FormData();
    dataExp7.append("idCliente", getInfo5_2A[0]);
    dataExp7.append("nombreResidencial", getInfo5_2A[1]);
    dataExp7.append("nombreCondominio", getInfo5_2A[2]);
    dataExp7.append("idCondominio", getInfo5_2A[3]);
    dataExp7.append("nombreLote", getInfo5_2A[4]);
    dataExp7.append("idLote", getInfo5_2A[5]);
    dataExp7.append("comentario", comentario);
    dataExp7.append("fechaVenc", getInfo5_2A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save7').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2/',
            data: dataExp7,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save7').prop('disabled', false);
                $('#modal7').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#b_return1', function(e) {
    e.preventDefault();
    const comentario = $("#comentario8").val();
    const validaComent = ($("#comentario8").val().length == 0) ? 0 : 1;
    let dataExp8 = new FormData();
    dataExp8.append("idCliente", return1a[0]);
    dataExp8.append("nombreResidencial", return1a[1]);
    dataExp8.append("nombreCondominio", return1a[2]);
    dataExp8.append("idCondominio", return1a[3]);
    dataExp8.append("nombreLote", return1a[4]);
    dataExp8.append("idLote", return1a[5]);
    dataExp8.append("comentario", comentario);
    dataExp8.append("fechaVenc", return1a[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#b_return1').prop('disabled', true);
        $.ajax({
            url : general_base_url+'asesor/return1aaj/',
            data: dataExp8,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#b_return1').prop('disabled', false);
                $('#modal_return1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on("click", ".enviar_nuevamente_estatus3", function (e) {
    e.preventDefault();
    getInfo2A[0] = $(this).attr("data-idCliente");
    getInfo2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2A[3] = $(this).attr("data-idCondominio");
    getInfo2A[4] = $(this).attr("data-nombreLote");
    getInfo2A[5] = $(this).attr("data-idLote");
    getInfo2A[6] = $(this).attr("data-fechavenc");
    nombreLote = $(this).data("nomlote");
    tipo_comprobante = $(this).attr('data-ticomp');
    $(".lote").html(nombreLote);
    $('#enviarNuevamenteEstatus3PV').modal('show');
});

$(document).on('click', '.btn-autorizacion', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (cliente.autorizacion_correo != null) {
            $('#chk-correo-aut-div').hide();
            $('#correo-aut-div').hide();
            $('#correoAut').removeAttr('required');
            $('#chk-sms-aut-div').removeAttr('class');
            $('#chk-sms-aut-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
        } else {
            $('#correoAut').val(cliente.correo);
            $('#chkCorreoAut').prop('checked', true);
        }
        if (cliente.autorizacion_sms != null) {
            $('#chk-sms-aut-div').hide();
            $('#sms-aut-div').hide();
            $('#ladaAut').removeAttr('required');
            $('#smsAut').removeAttr('required');
            $('#chk-correo-aut-div').removeAttr('class');
            $('#chk-correo-aut-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
        } else {
            let telefono = '';
            if (cliente.telefono1) {
                const telLength = cliente.telefono1.length;
                telefono = (telLength > 10)
                    ? parseInt(cliente.telefono1.substring(telLength - 10, telLength))
                    : parseInt(cliente.telefono1);
            }
            $('#smsAut').val(telefono);
            $('#ladaAut').val(cliente.lada_tel).trigger('change');
            $('#chkSmsAut').prop('checked', true);
        }
        $('#autorizaciones-modal').modal('toggle');
    });
});

$(document).on('click', '.btn-reenvio', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (parseInt(cliente.autorizacion_correo) !== ESTATUS_AUTORIZACION.ENVIADO) {
            $('#chk-correo-reenvio-div').hide();
            $('#chk-sms-reenvio-div').removeAttr('class');
            $('#chk-sms-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkCorreoReenvio').prop('checked', false);
        }
        if (parseInt(cliente.autorizacion_sms) !== ESTATUS_AUTORIZACION.ENVIADO) {
            $('#chk-sms-reenvio-div').hide();
            $('#chk-correo-reenvio-div').removeAttr('class');
            $('#chk-correo-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkSmsReenvio').prop('checked', false);
        }
        $('#reenvio-modal').modal('toggle');
    });
});

$(document).on('click', '.btn-solicitar', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (parseInt(cliente.total_sol_correo_pend) > 0 || parseInt(cliente.total_sol_correo_aut) > 0 || cliente.autorizacion_correo === null || parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.AUTORIZADO) {
            $('#chk-correo-sol-div').hide();
            $('#chk-sms-sol-div').removeAttr('class');
            $('#chk-sms-sol-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkCorreoSol').prop('checked', false);
        }
        if (parseInt(cliente.total_sol_sms_pend) > 0 || parseInt(cliente.total_sol_sms_aut) > 0 || cliente.autorizacion_sms === null || parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.AUTORIZADO) {
            $('#chk-sms-sol-div').hide();
            $('#chk-correo-sol-div').removeAttr('class');
            $('#chk-correo-sol-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkSmsSol').prop('checked', false);
        }
        $('#solicitar-modal').modal('toggle');
    });
});

$(document).on('hidden.bs.modal', '#autorizaciones-modal', function () {
    cliente = null;
    $('#correoAut').val('');
    $('#smsAut').val('');
    $('#chk-correo-aut-div').show();
    $('#correo-aut-div').show();
    $('#chk-sms-aut-div').show();
    $('#sms-aut-div').show();
    $('#correoAut').attr('required');
    $('#ladaAut').attr('required');
    $('#smsAut').attr('required');
    $('#chk-sms-aut-div').removeAttr('class');
    $('#chk-sms-aut-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-aut-div').removeAttr('class');
    $('#chk-correo-aut-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoAut').prop('checked', true);
    $('#chkSmsAut').prop('checked', true);
});

$(document).on('hidden.bs.modal', '#reenvio-modal', function () {
    cliente = null;
    $('#chk-correo-reenvio-div').show();
    $('#chk-sms-reenvio-div').show();
    $('#chk-sms-reenvio-div').removeAttr('class');
    $('#chk-sms-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-reenvio-div').removeAttr('class');
    $('#chk-correo-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoReenvio').prop('checked', true);
    $('#chkSmsReenvio').prop('checked', true);
});

$(document).on('hidden.bs.modal', '#solicitar-modal', function () {
    cliente = null;
    $('#chk-correo-sol-div').show();
    $('#chk-sms-sol-div').show();
    $('#chk-sms-sol-div').removeAttr('class');
    $('#chk-sms-sol-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-sol-div').removeAttr('class');
    $('#chk-correo-sol-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoSol').prop('checked', true);
    $('#chkSmsSol').prop('checked', true);
    $('#comentarioSol').val('');
    $('#subdirector').val(null).trigger('change');
});

$(document).on('submit', '#autorizacion-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#autorizacion-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoAut && !formValues.chkSmsAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (cliente.autorizacion_correo !== null && !formValues.chkSmsAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (cliente.autorizacion_sms !== null && !formValues.chkCorreoAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (formValues.chkCorreoAut && cliente.autorizacion_correo === null) {
        if (formValues.correoAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo correo electrónico es obligatorio.', 'danger');
            return;
        }
    }
    if (formValues.chkSmsAut && cliente.autorizacion_sms === null) {
        if (formValues.ladaAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo lada es obligatorio.', 'danger');
            return;
        }
        if (formValues.smsAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo teléfono es obligatorio.', 'danger');
            return;
        }
        if (formValues.smsAut.length !== 10) {
            alerts.showNotification('top', 'right', 'El campo teléfono debe tener una longitud de 10 caracteres.', 'danger');
            return;
        }
    }

    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    if (formValues.chkCorreoAut && cliente.autorizacion_correo === null) {
        data.append('correo', formValues.correoAut);
    }
    if (formValues.chkSmsAut && cliente.autorizacion_sms === null) {
        data.append('telefono', formValues.smsAut);
        data.append('lada', formValues.ladaAut);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/enviarAutorizaciones`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Verificación enviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#autorizaciones-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('submit', '#reenvio-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#reenvio-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoReenvio && !formValues.chkSmsReenvio) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (parseInt(cliente.autorizacion_sms) !== ESTATUS_AUTORIZACION.ENVIADO &&
        parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO && !formValues.chkCorreoReenvio) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (parseInt(cliente.autorizacion_correo) !== ESTATUS_AUTORIZACION.ENVIADO &&
        (parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO && !formValues.chkSmsReenvio)) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    if (parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO && formValues.chkCorreoReenvio) {
        data.append('correo', true);
    }
    if (parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO && formValues.chkSmsReenvio) {
        data.append('sms', true);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/reenvioAutorizacion`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Autorización reenviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#reenvio-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('submit', '#solicitar-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#solicitar-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoSol && !formValues.chkSmsSol) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (formValues.comentario.length === 0) {
        alerts.showNotification('top', 'right', 'El comentario es requerido.', 'danger');
        return;
    }
    if (formValues.subdirector === null || formValues.subdirector === '') {
        alerts.showNotification('top', 'right', 'El subdirector es requerido.', 'danger');
        return;
    }
    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    data.append('idSubdirector', formValues.subdirector);
    data.append('comentario', formValues.comentario);
    if ((parseInt(cliente.total_sol_correo_pend) === 0 || cliente.autorizacion_correo !== null) && formValues.chkCorreoSol) {
        data.append('correo', true);
    }
    if ((parseInt(cliente.total_sol_sms_pend) === 0 || cliente.autorizacion_sms !== null) && formValues.chkSmsSol) {
        data.append('sms', true);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/solicitarAclaracion`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Solicitud enviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#solicitar-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

function chkCorreoAutOnChange() {
    const isChecked = $('#chkCorreoAut').is(':checked');
    if (isChecked) {
        $('#correo-aut-div').show();
        $('#correoAut').attr('required');
    } else {
        $('#correo-aut-div').hide();
        $('#correoAut').removeAttr('required');
    }
}

function chkSmsAutOnChange() {
    const isChecked = $('#chkSmsAut').is(':checked');
    if (isChecked) {
        $('#sms-aut-div').show();
        $('#ladaAut').attr('required');
        $('#smsAut').attr('required');
    } else {
        $('#sms-aut-div').hide();
        $('#ladaAut').removeAttr('required');
        $('#smsAut').removeAttr('required');
    }
}

jQuery(document).ready(function(){
    jQuery('#modal1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
    jQuery('#modal2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
    })
    jQuery('#modal3').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
    jQuery('#modal4').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario4').val('');
    })
    jQuery('#modal5').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario5').val('');
    })
    jQuery('#modal6').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario6').val('');
    })
    jQuery('#modal7').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario7').val('');
    })
    jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario8').val('');
    })
})

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function construirBotonEstatus(data, fechaVenc, classButton, atributoButton = '', titulo = 'ENVIAR ESTATUS') {
    return `<a href='#' 
                ${atributoButton}
                data-tiComp='${data.tipo_comprobanteD}'
                data-nomLote='${data.nombreLote}'
                data-idCliente='${data.id_cliente}'
                data-nombreResidencial='${data.nombreResidencial}'
                data-nombreCondominio='${data.nombreCondominio}'
                data-nombreLote='${data.nombreLote}'
                data-idCondominio='${data.idCondominio}'
                data-idLote='${data.idLote}'
                data-fechavenc='${fechaVenc}'
                class="btn-data btn-green ${classButton}"
                data-toggle="tooltip"
                data-placement="top"
                title="${titulo}">
        <i class="fas fa-check"></i>
    </a>`;
}

function generarBotonesAutorizacion(clienteData) {
    let botones = '';
    if (clienteData.autorizacion_correo === null || clienteData.autorizacion_sms === null) {
        botones += `
            <button class="btn-data btn-violetDeep btn-rounded btn-autorizacion"
                    data-toggle="tooltip" 
                    data-placement="left" 
                    title="ENVÍO DE VERIFICACIONES"
                    data-idCliente='${clienteData.id_cliente}'>
                <i class="fas fa-send"></i>
            </button>
        `;
    }
    if (parseInt(clienteData.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO || parseInt(clienteData.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO) {
        botones += `
            <button class="btn-data btn-azure btn-rounded btn-reenvio"
                    data-toggle="tooltip" 
                    data-placement="left" 
                    title="REENVÍO DE VERIFICACIÓN"
                    data-idCliente='${clienteData.id_cliente}'>
                <i class="fas fa-rotate-right"></i>
            </button>
        `;
    }

    if (
        (parseInt(clienteData.total_sol_correo_pend) === 0 && parseInt(clienteData.total_sol_correo_aut) === 0) &&
            parseInt(clienteData.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO ||
        (parseInt(clienteData.total_sol_sms_pend) === 0 && parseInt(clienteData.total_sol_sms_aut) === 0) &&
            parseInt(clienteData.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO
    ) {
        botones += `
            <button class="btn-data btn-yellow btn-rounded btn-solicitar"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="SOLICITAR EDICIÓN DEL REGISTRO" 
                    data-idCliente='${clienteData.id_cliente}'>
                <i class="fas fa-hand-paper-o"></i>
            </button>
        `;
    }

    return botones;
}