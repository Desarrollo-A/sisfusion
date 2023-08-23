let tablaComisiones;

$(document).ready(function () {
    $("#div-tabla").prop("hidden", true);
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Comisiones/getPuestoComisionesAsistentes`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].id_opcion;
                const nombre = data[i].nombre;
                $('#puestos').append($('<option>').val(id).text(nombre));
            }
            $('#puestos').selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
    });

    $.ajax({
        url: `${general_base_url}Comisiones/findAllResidenciales`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].idResidencial;
                const nombre = data[i].descripcion;
                $('#proyectos').append($('<option>').val(id).text(nombre));
            }
            $('#proyectos').selectpicker('refresh');
        }
    });

    $.ajax({
        url: `${general_base_url}Comisiones/getEstatusComisionesAsistentes`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                if (data[i].idEstatus !== 6) {
                    const id = data[i].idEstatus;
                    const nombre = data[i].nombre;
                    $('#estatus').append($('<option>').val(id).text(nombre));
                }
            }
            $('#estatus').selectpicker('refresh');
        }
    });
});

$('#puestos').on('change', function () {
    const puesto = $(this).val();
    $("#div-tabla").prop("hidden", true);

    if (puesto !== '0') {
        $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: `${general_base_url}Comisiones/findUsuariosByPuestoAsistente/${puesto}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    const id = data[i].id_usuario;
                    const nombre = data[i].nombre_completo;
                    $('#usuarios').append($('<option>').val(id).text(nombre));
                }
                $('#usuarios').selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    }
});

$('#usuarios').on('change', function () {
    const idUsuario = $(this).val();
    const idProyecto = $('#proyectos').val() || 0;
    const idEstatus = $('#estatus').val() || 0;

    if (idUsuario !== '') {
        $('#spiner-loader').removeClass('hide');
        loadTable(idUsuario, idProyecto, idEstatus);
    } else {
        $("#div-tabla").prop("hidden", true);
    }
});

$('#proyectos').on('change', function () {
    const idProyecto = $(this).val() || 0;
    const idUsuario = $('#usuarios').val();
    const idEstatus = $('#estatus').val() || 0;

    if (idUsuario !== '0') {
        $('#spiner-loader').removeClass('hide');
        loadTable(idUsuario, idProyecto, idEstatus);
    }
});

$('#estatus').on('change', function () {
    const idEstatus = $(this).val();
    const idUsuario = $('#usuarios').val();
    const idProyecto = $('#proyectos').val();

    if (idUsuario !== '0') {
        $('#spiner-loader').removeClass('hide');
        loadTable(idUsuario, idProyecto, idEstatus);
    }
});

let titulos_intxt = [];
$('#tabla-historial thead tr:eq(0) th').each( function (i) {
    const title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tabla-historial').DataTable().column(i).search() !== this.value ) {
            $('#tabla-historial').DataTable().column(i).search(this.value).draw();
        }
    });
});

function loadTable(idUsuario, idProyecto, idEstatus) {
    $("#div-tabla").prop("hidden", false);

    tablaComisiones = $('#tabla-historial').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL_GENERAL_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                return '<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.restante === null || d.restante === ''){
                    return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
                }
                else{
                    return '<p class="m-0">'+formatMoney(d.restante)+'</p>';
                }
            }
        },
        {
            "data": function( d ){
                if(d.activo === 0 || d.activo === '0'){
                    return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                }
                else{
                    return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                if (d.bonificacion >= 1) {
                    p1 = '<p class="m-0"><span class="label lbl-pink">Bonificación '+formatMoney(d.bonificacion)+'</span></p>';
                } else {
                    p1 = '';
                }
                if(d.lugar_prospeccion === 0){
                    p2 = '<p class="m-0"><span class="label lbl-warning">Recisión de contrato</span></p>';
                } else {
                    p2 = '';
                }
                return p1 + p2;
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                if((d.id_estatus_actual === 11) && d.descuento_aplicado === 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO</span></p>';
                }else if((d.id_estatus_actual === 12) && d.descuento_aplicado === 1 ){
                    etiqueta = '<p><span class="label lbl-orange">DESCUENTO RESGUARDO</span></p>';
                }else if((d.id_estatus_actual === 0) && d.descuento_aplicado === 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO EN PROCESO</span></p>';
                }else if((d.id_estatus_actual === 16) && d.descuento_aplicado === 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO DE PAGO</span></p>';
                }else if((d.id_estatus_actual === 17) && d.descuento_aplicado === 1 ){
                    etiqueta = '<p><span class="label lbl-pink">DESCUENTO UNIVERSIDAD</span></p>';
                }else{
                    switch(d.id_estatus_actual){
                        case '1':
                        case 1:
                        case '2':
                        case 2:
                        case '12':
                        case 12:
                        case '13':
                        case 13:
                        case '14':
                        case 14:
                        case '51':
                        case 51:
                        case '52':
                        case 52:
                            etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                            break;
                        case '3':
                        case 3:
                            etiqueta = '<p><span class="label lbl-brown">'+d.estatus_actual+'</span></p>';
                            break;
                        case '4':
                        case 4:
                            etiqueta = '<p><span class="label lbl-violetDeep">'+d.estatus_actual+'</span></p>';
                            break;
                        case '5':
                        case 5:
                            etiqueta = '<p><span class="label lbl-pink">'+d.estatus_actual+'</span></p>';
                            break;
                        case '6':
                        case 6:
                            etiqueta = '<p><span class="label lbl-lightBlue">'+d.estatus_actual+'</span></p>';
                            break;
                        case '7':
                        case 7:
                            etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p>';
                            break;
                        case '8':
                        case 8:
                            etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                            break;
                        case '9':
                        case 9:
                            etiqueta = '<p><span class="label lbl-orange">'+d.estatus_actual+'</span></p>';
                            break;
                        case '10':
                        case 10:
                            etiqueta = '<p><span class="label lbl-orange">'+d.estatus_actual+'</span></p>';
                            break;
                        case '11':
                        case 11:
                            if(d.pago_neodata < 1){
                                etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p><p><span class="label lbl-oceanGreen">IMPORTACIÓN</span></p>';
                            }else{
                                etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p>';
                            }
                            break;
                        case '88':
                        case 88:
                            etiqueta = '<p><span class="label lbl-pink">'+d.estatus_actual+'</span></p>';
                            break;
                        default:
                            etiqueta = '';
                            break;
                    }
                }
                return etiqueta;
            }
        },
        {
            "data": function( data ){
                return `
                    <div class="d-flex justify-center">
                        <button href="#" value="${data.id_pago_i}" data-value="${data.nombreLote}" data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="HISTORIAL DE PAGO"><i class="fas fa-info"></i></button>
                    </div>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets:   0,
            'searchable':false,
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": `${general_base_url}Comisiones/getUsuariosByComisionesAsistentes/${idUsuario}/${idProyecto}/${idEstatus}`,
            "type": "GET",
            "cache": false,
            "data": function( d ) {}
        },
        initComplete: function(){
            $('#spiner-loader').addClass('hide');
        },
        order: [[ 1, 'asc' ]]
    });

    $('#tabla-historial').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla-historial tbody").on("click", ".consultar_logs_asimilados", function(e){
        $("#spiner-loader").removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        const id_pago = $(this).val();
        const lote = $(this).attr("data-value");

        $.getJSON("getComments/"+id_pago).done( function( data ){
            $("#seeInformationModalAsimilados").modal();
            $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
            $("#spiner-loader").addClass('hide');
        });
    });
}

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}