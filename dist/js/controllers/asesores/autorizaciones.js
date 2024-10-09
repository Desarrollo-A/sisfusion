const movimientosPermitidosAsesor = [31, 85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111];

function validateEmptyFields(){
    var miArray = [];
    for (i = 0; i < $("#tamanocer").val(); i++) {
        if ($("#comentario_"+i).val() == ""){
            $("#comentario_"+i).focus();
            toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
            miArray.push(0);
            return false;
        }
        else {
            miArray.push(1);
        }
    }
    $('#btnSubmitEnviar').submit();
}

$("#my_authorization_form").on('submit', function(e){
    e.preventDefault();
    $('#spiner-loader').removeClass('hide');

    $.ajax({
        type: 'POST',
        url: general_base_url+'asesor/addAutorizacionSbmt',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 'true') {
                $('#solicitarAutorizacion').modal("hide");
                alerts.showNotification('top', 'right', 'Se enviaron las autorizaciones correctamente', 'success');
            } else {
                alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
            }
        },
        error: function(){
            alerts.showNotification('top', 'right', 'Oops! Algo salió mal, inténtalo de nuevo.', 'danger');
        },
        complete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#residencial').change(function(){
    var valorSeleccionado = $(this).val();
    $('#filtro4').load("<?= site_url('registroCliente/getCondominioDesc') ?>/"+valorSeleccionado, function(){
    });
});

$('#filtro4').change(function(){
    var residencial = $('#filtro3').val()
    var valorSeleccionado = $(this).val();
    $('#filtro5').load("<?= site_url('registroCliente/getLotesAsesor') ?>/"+valorSeleccionado+'/'+residencial);
});

$('#filtro5').change(function(){
    var valorSeleccionado = $(this).val();
    $('.table-responsive').load("<?= site_url('registroCliente/get_log_aut') ?>/"+valorSeleccionado);
});

var miArray = new Array(6);
var miArrayAddFile = new Array(6);
var getInfo2A = new Array(7);
var getInfo2_2A = new Array(7);
var getInfo5A = new Array(7);
var getInfo6A = new Array(7);
var getInfo2_3A = new Array(7);
var getInfo2_7A = new Array(7);
var aut;
let titulos_autorizaciones = [];
let num_colum_autorizaciones = [];
/*$('#addExp thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html(`<input type="text" class="textoshead"data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`);
    titulos_autorizaciones.push(title);
    num_colum_autorizaciones.push(i);
    $( 'input', this ).on('keyup change', function () {
        if ($('#addExp').DataTable().column(i).search() !== this.value ) {
            $('#addExp').DataTable().column(i).search(this.value).draw();
        }
    });
});*/
num_colum_autorizaciones.pop();

function apply() {
    // let id = table.tables().nodes().to$().attr('id')

    $(`table thead tr:eq(0) th`).each(function (i) {
        $('input', this).on('keyup change', function () {
            console.log(i)
            
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        })
    })

    // $(`#${id}`).on('draw.dt', function() {
    //     $('[data-toggle="tooltip"]').tooltip({
    //         trigger: "hover"
    //     });
    // });
}

$(document).ready (function() {    
    construirHead('sol_aut');
    let table2 = $('#sol_aut').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: 'Solicitud de autorizaciones' ,
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: `${_('descargar-pdf')}`,
            title: 'Solicitud de autorizaciones' ,
            orientation: 'landscape',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: _('video-tutorial'),
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/1zcshxE2nP4', '_blank');
            }
        }],
        pagingType: "full_numbers",
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
            "data": "nombreResidencial"
        },
        { 
            "data": "nombreCondominio"
        },
        { 
            "data": "nombreLote" 
        },
        {
            "data": "nombreCliente"
        },
        {
            "data": "coordinador"
        },
        {
            "data": "gerente"
        },
        {
            "data": "subdirector"
        },
        {
            "data": "regional"
        },
        {
            "data": "regional2"
        },
        { 
            "data": "fechaApartado" 
        },
        {
            "data": function( d ){
                if((d.idStatusContratacion == 1 || d.idStatusContratacion == 2 || d.idStatusContratacion == 3) && movimientosPermitidosAsesor.includes(parseInt(d.idMovimiento))){
                    aut =
                        `<a href="#" class="btn-data btn-blueMaderas addAutorizacionAsesor" data-idCliente="${d.id_cliente}" data-nombreResidencial="${d.nombreResidencial}" data-nombreCondominio="${d.nombreCondominio}" data-nombreLote="${d.nombreLote}" data-idCondominio="${d.idCondominio}" data-idLote="${d.idLote}" data-toggle="tooltip" data-placement="top" title="ACCIONES"><i class="fas fa-redo"></i></a>`;
                    return '<div class="d-flex justify-center">'+aut+'</div>';
                }
                else{
                    return '';
                }
            }
        }],
        ajax: {
            "url": general_base_url+"asesor/get_sol_aut/",
            "type": "POST",
            cache: false
        },
    });
    // applySearch(table2);

    $(`#sol_aut thead tr:eq(0) th`).each(function (i) {
        $('input', this).on('keyup change', function () {
            console.log(i)
            
            if (table2.column(i).search() !== this.value) {
                table2.column(i).search(this.value).draw();
            }
        })
    })

    construirHead('addExp');
    let table = $('#addExp').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: 'Autorizaciones' ,
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: `${_('descargar-pdf')}`,
            title: 'Autorizaciones' ,
            orientation: 'landscape',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            // titleAttr: `${_("video-tutorial")}`,                                             
            titleAttr: _("video-tutorial"), 
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/1zcshxE2nP4', '_blank');
            }
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { "data": "nombreResidencial" },
            { "data": "nombreCondominio" },
            { "data": "nombreLote" },
            { "data": "nombreCliente"},
            { "data": "sol" },
            { "data": "coordinador"},
            { "data": "gerente"},
            { "data": "subdirector"},
            { "data": "regional"},
            { "data": "regional2"},
            { "data": "aut" },
            {
                "data": function( d ){
                    acciones = `<a  href="#" class="btn-data btn-blueMaderas seeAuts" data-id_autorizacion="${d.id_autorizacion}" data-idLote="${d.idLote}" data-toggle="tooltip" data-placement="top" title="VISUALIZAR"><i class='fas fa-eye'></i></a></div>`;
                    return '<div class="d-flex justify-center">'+acciones+'</div>';
                }
            }
        ],
        ajax: {
            url: general_base_url+"asesor/getAutorizacionAs/",
            type: "POST",
            cache: false
        },
    });    
    // applySearch(table);

    $(`#addExp thead tr:eq(0) th`).each(function (i) {
        $('input', this).on('keyup change', function () {
            console.log(i)
            
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        })
    })
});

// let titulos_solicitud = [];
// let num_colum_solicitud = [];
// $('#sol_aut thead tr:eq(0) th').each( function (i) {
//     var title = $(this).text();
//     $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
//     titulos_solicitud.push(title);
//     num_colum_solicitud.push(i);
//     $( 'input', this ).on('keyup change', function () {
//         if ($('#sol_aut').DataTable().column(i).search() !== this.value ) {
//             $('#sol_aut').DataTable().column(i).search(this.value).draw();
//         }
//     });
//     $('[data-toggle="tooltip"]').tooltip();
// });
// num_colum_solicitud.pop();

var contador=1;
$(document).on('click', '.addAutorizacionAsesor', function(e) {
    contador=1;
    e.preventDefault();
    var $itself = $(this);
    $("#dirAutoriza").val('default');
    $('#dirAutoriza').selectpicker("refresh");
    $('#autorizacionesExtra').html('');
    validateNumsOfAutorizacion();
    $('#comentario_0').val('');
    $('#idCliente').val($itself.attr('data-idCliente'));
    $('#idLote').val($itself.attr('data-idLote'));
    $('#nombreCondominio').val($itself.attr('data-nombreCondominio'));
    $('#nombreResidencial').val($itself.attr('data-nombreResidencial'));
    $('#nombreLote').val($itself.attr('data-nombreLote'));
    $('#idCondominio').val($itself.attr('data-idCondominio'));
    $('#id_sol').val(id_usuario_general);
    $('#solicitarAutorizacion').modal('show');
});

$('#solicitarAutorizacion').on('hidden.bs.modal', function (e) {
    $('#tamanocer').val('1');
});

$(document).on('click', '.seeAuts', function (e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    var $itself = $(this);
    var idLote=$itself.attr('data-idLote');
    $.post( general_base_url+"asesor/get_auts_by_lote/"+idLote, function( data ) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function(i, item) {
            if(item['estatus'] == 0){               
                statusProceso = `<span class='label lbl-green'>${_('aceptada')}</span>`;
            }
            else if(item['estatus'] == 1){
                statusProceso=`<span class='label lbl-orangeYellow'>${_('en-proceso2')}</span>`;
            }
            else if(item['estatus'] == 2){
                statusProceso=`<span class='label lbl-warning'>${_('denegada2')}</span>`;
            }
            else if(item['estatus'] == 3){
                statusProceso="<span class='label lbl-sky'>EN DC</span>";
            }
            else{
                statusProceso="<span class='label lbl-gray'>N/A</span>";
            }
            $('#auts-loads').append(`
                <div class="container-fluid" style="background-color: #f7f7f7; border-radius: 15px; padding: 15px; margin-bottom: 15px">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-7">
                            <label style="font-weight:100; font-size: 12px"><label>${_('solicitud-autorizacion')}</label>: <b>${statusProceso}</b></label>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-5" style="text-align: right">
                            <label style="font-weight:100; font-size: 12px">${item['fecha_creacion']}</label>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p style="text-align: justify;">
                                <span class="font-weight:400">${item['autorizacion']}</span>
                            </p>
                        </div>
                    </div>
                </div>
            `);
        });
        $('#verAutorizacionesAsesor').modal('show');
        $('#spiner-loader').addClass('hide');

    });
});


contador = 1;
function agregarAutorizacion (){
    $("#autorizacionesExtra").append('<div class="mt-2" id="cnt-'+contador+'"><label>Observación: (<span class="isRequired">*</span>) </label>' +
        '<button class="fl-r" onclick="eliminaAutorizacion('+contador+')" style="color: gray; background-color:transparent; border:none;" title="Eliminar observación"><i class="fas fa-trash"></i></button>' +
        '<textarea name="comentario_' + contador + '" placeholder="Ingresa tu comentario" ' +
        '           class="text-modal" id="comentario_'+ contador +'" rows="3" >'+
        '</textarea></div>');
    contador = contador + 1;
    $('#tamanocer').val(contador);
    validateNumsOfAutorizacion();
}

function eliminaAutorizacion(contenedor){
    $('#cnt-'+contenedor).remove();
    contador = contador - 1;
    $('#tamanocer').val(contador);
    validateNumsOfAutorizacion();
}

function validateNumsOfAutorizacion(){
    if($('#tamanocer').val() == 5){
        $('#functionAdd').html('');
    }
    else{
        if(contador<=4 && $('#functionAdd').is(':empty'))
        {
            $('#functionAdd').append('<a onclick="agregarAutorizacion()"  style="float: right; color: black; cursor: pointer; " title="Agregar observación"><span class="material-icons">add</span></a>');
        }
    }
}

$(document).ready(function () {
    validateNumsOfAutorizacion();    
    if(id_usuario_general == 1){
        alerts.showNotification("top", "right", "Se enviaron las autorizaciones correctamente", "success");
    }
    else if( id_usuario_general == 99){
        alerts.showNotification("top", "right", "Ocurrio un error al enviar la autorización", "warning");
    }
    
    $("#dirAutoriza").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'registroCliente/getActiveDirs/',
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['id_usuario'];
                var name = response[i]['nombre']+' '+response[i]['apellido_paterno']+' '+response[i]['apellido_materno'];
                $("#dirAutoriza").append($('<option>').val(id).text(name));
            }
            $("#dirAutoriza").selectpicker('refresh');
        }
    });
});


