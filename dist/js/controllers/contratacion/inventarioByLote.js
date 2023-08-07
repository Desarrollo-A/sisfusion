var idLote = 0;
let titulos_intxt = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(".find_doc").click( function() {
    $("#tabla_inventario_contraloria").removeClass('hide');
    var idLote = $('#inp_lote').val();
    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ajax:
        {
            "url": general_base_url + 'index.php/Contratacion/getInventoryByLote/'+idLote,
            "dataSrc": ""
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'MADERAS_CRM_INVENTARIO',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx]  + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: 'nombreResidencial'
        },
        {
            "data": function(d){
                return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
            }
        },
        {
            "data": function(d){
                return '<p>'+(d.nombreLote).toUpperCase()+'</p>';
            }
        },
        {
            "data": function(d){
                return '<p>'+ d.idLote +'</p>';
            }
        },
        {
            "data": function(d){
                return '<p>'+d.superficie+'<b> m<sup>2</sup></b></p>';
            }
        },
        {
            "data": function(d){
                var preciot;
                if(d.nombreResidencial == 'CCMP'){
                    if(d.idStatusLote != 3){
                        var stella;
                        var aura;
                        var terreno;
                        if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                        d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                        d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
                        d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                        d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
                        
                        d.nombreLote == 'CCMP-LIRIO-010' ||
                        d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                        d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                        d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100'){
                                stella = ( parseInt(d.total) + parseInt(2029185) );
                                aura = ( parseInt(d.total) + parseInt(1037340) );
                                terreno = parseInt(d.total);
                                preciot = '<p>S: '+formatMoney(stella)+'</p>' + '<p>A: '+formatMoney(aura)+'</p>' + '<p>T: '+formatMoney(terreno)+'</p>';
                        }
                        else {
                            stella = ( parseInt(d.total) + parseInt(2104340) );
                            aura = ( parseInt(d.total) + parseInt(1075760) );
                            terreno = parseInt(d.total);
                            preciot = '<p>S: '+formatMoney(stella)+'</p>' + '<p>A: '+formatMoney(aura)+'</p>' + '<p>T: '+formatMoney(terreno)+'</p>';
                        }
                    } 
                    else if(d.idStatusLote == 3 || d.idStatusLote == 2){
                        preciot = '<p> '+formatMoney(d.total)+'</p>';
                    }
                } 
                else {
                    preciot = '<p> '+formatMoney(d.total)+'</p>';
                }
                return preciot;
            }
        },
        {
            "data": function(d){
                return '<p class="m-0"> '+formatMoney(d.totalNeto2)+'</p>';
            }
        },
        {
            "data": function(d){
                var preciom2;					
                if(d.nombreResidencial == 'CCMP'){
                    if(d.idStatusLote != 3){
                        var stella;
                        var aura;
                        var terreno;
                        if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                        d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                        d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
                        d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                        d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
                        d.nombreLote == 'CCMP-LIRIO-010' ||
                        d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                        d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                        d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
                            stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
                            aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
                            terreno = (parseInt(d.total) / d.superficie);
                            preciom2 = '<p>S: '+formatMoney(stella)+'</p>' + '<p>A: '+formatMoney(aura)+'</p>' + '<p>T: '+formatMoney(terreno)+'</p>';
                        }
                        else {
                                stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
                                aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
                                terreno = (parseInt(d.total) / d.superficie);
                                preciom2 = '<p>S: '+formatMoney(stella)+'</p>' + '<p>A: '+formatMoney(aura)+'</p>' + '<p>T: '+formatMoney(terreno)+'</p>';
                        }
                    } 
                    else if(d.idStatusLote == 3 || d.idStatusLote == 2) {
                        preciom2 = '<p> '+formatMoney(d.precio)+'</p>';
                    }
                } 
                else {
                    preciom2 = '<p> '+formatMoney(d.precio)+'</p>';
                }
                return preciom2;
            }
        },
        {
            data: 'referencia'
        },
        {
            data: 'msni'
        },
        {
            "data": function(d){
                var asesor;
                if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                {
                    asesor = myFunctions.validateEmptyField(d.asesor2);
                }
                else
                {
                    asesor = myFunctions.validateEmptyField(d.asesor);
                }
                return asesor;
            }
        },
        {
            "data": function(d){
                var coordinador;
                if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                {
                    if(d.id_rol == 9){
                        coordinador = myFunctions.validateEmptyField(d.asesor2);
                    } else {
                        coordinador = myFunctions.validateEmptyField(d.coordinador2);
                    }
                }
                else
                {
                    coordinador = myFunctions.validateEmptyField(d.coordinador);
                }
                coordinador = coordinador = '' ? 'Sin registro' : coordinador;
                return coordinador;
            }
        },
        {
            "data": function(d){
                var gerente;
                if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                {
                    if(d.id_rol == 9){
                        gerente = myFunctions.validateEmptyField(d.coordinador2);
                    } else {
                        gerente = myFunctions.validateEmptyField(d.gerente2);
                    }
                }
                else
                {
                    gerente = myFunctions.validateEmptyField(d.gerente);
                }
                return gerente;
            }
        },
        {
            "data": function(d){
                valTV = (d.tipo_venta == null) ? '<center><span class="label" style="color:background:#'+d.color+';">'+d.descripcion_estatus+'</span> <center>' :
                '<center><span class="label" style="color:#0a548b; border: none; background:#'+d.color+'18;">'+d.descripcion_estatus+'</span> <p><p> <span class="label lbl-orangeYellow">'+d.tipo_venta+'</span> <center>';
                return valTV;
            }
        },
        {
            "data": function(d){
                if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
                    if(d.fecha_modst == null || d.fecha_modst == 'null') {
                        return 'Sin registro';
                    } else {
                        return '<p>'+d.fecha_modst+'</p>';
                    }
                } else {
                    if(d.fechaApartado == null || d.fechaApartado == 'null') {
                        return 'Sin registro';
                    } else {
                        return '<p>'+d.fechaApartado+'</p>';
                    }
                }
            }
        },
        {
            "data": function(d){
                if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
                    return ' - ';
                }
                else
                {
                    return '<p>'+d.comentario+'</p>';
                }
            }
        },
        {
            data: 'lugar_prospeccion'
        },
        {
            "data": function( d ){
                return '<div class="d-flex justify-center"><button class="btn-data btn-sky ver_historial" data-toggle="tooltip" data-placement="top" title="CONSULTA HISTORIAL" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'" data-tipo-venta="'+d.tipo_venta+'"><i class="fas fa-history"></i></button></div>';
            }
        }]
    });
    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});

$('#tabla_inventario_contraloria').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", ".ver_historial", function(){
    var tr = $(this).closest('tr');
    var row = tabla_inventario.row( tr );
    idLote = $(this).val();
    var $itself = $(this);
    var element = document.getElementById("li_individual_sales");
    if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
        $.getJSON(general_base_url + "Contratacion/getClauses/"+idLote).done( function( data ){
            $('#clauses_content').html(data[0]['nombre']);
        });
        element.classList.remove("hide");
    } 
    else {
        element.classList.add("hide");
        $('#clauses_content').html('');
    }
    $("#seeInformationModal").on("hidden.bs.modal", function(){
        $("#changeproces").html("");
        $("#changelog").html("");
        $('#nomLoteHistorial').html("");
    });
    $("#seeInformationModal").modal();
    var urlTableFred = '';
    $.getJSON(general_base_url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
        urlTableFred = general_base_url+"Contratacion/obtener_liberacion/"+idLote;
        fillFreedom(urlTableFred);
    });
    var urlTableHist = '';
    $.getJSON(general_base_url+"Contratacion/historialProcesoLoteOp/"+idLote).done( function( data ){
        $('#nomLoteHistorial').html($itself.attr('data-nomLote'));
            urlTableHist = general_base_url+"Contratacion/historialProcesoLoteOp/"+idLote;
            fillHistory(urlTableHist);
    });
    var urlTableCSA = '';
    $.getJSON(general_base_url+"Contratacion/getCoSallingAdvisers/"+idLote).done( function( data ){
        urlTableCSA = general_base_url+"Contratacion/getCoSallingAdvisers/"+idLote;
        fillCoSellingAdvisers(urlTableCSA);
    });	
    fill_data_asignacion();
});

function fillLiberacion (v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge success"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
        '<b>ID:</b> '+v.idLiberacion+'\n' +
        '<br>\n' +
        '<b>Estatus:</b> '+v.estatus_actual+'\n' +
        '<br>\n' +
        '<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

function fillProceso (i, v) {
    $("#changeproces").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge info">'+(i+1)+'</div>\n' +
        '<div class="timeline-panel">\n' +
        '<b>'+v.nombreStatus+'</b><br><br>\n' +
        '<b>Comentario:</b> \n<p><i>'+v.comentario+'</i></p>\n' +
        '<br>\n' +
        '<b>Detalle:</b> '+v.descripcion+'\n' +
        '<br>\n' +
        '<b>Perfil:</b> '+v.perfil+'\n' +
        '<br>\n' +
        '<b>Usuario:</b> '+v.usuario+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

let titulos_ver = [];
$('#verDet thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_ver.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#verDet').DataTable().column(i).search() !== this.value ) {
            $('#verDet').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillHistory(urlTableHist){
    tableHistorial = $('#verDet').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        select: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'PROCESO DE CONTRA',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_ver[columnIdx]  + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { "data": "nombreLote" },
            { "data": "nombreStatus" },
            { "data": "descripcion" },
            { "data": "comentario" },
            { "data": "modificado" },
            { "data": "usuario" }
        ],
        ajax: {
            "url": urlTableHist,
            "dataSrc": ""
        },
    });
}

let titulos_det = [];
$('#verDetBloqueo thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_det.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#verDetBloqueo').DataTable().column(i).search() !== this.value ) {
            $('#verDetBloqueo').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillFreedom(urlTableFred){
    tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        select: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'LIBERACIÓN',
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_det[columnIdx]  + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { "data": "nombreLote" },
            { "data": "precio" },
            { "data": "modificado" },
            { "data" : "observacionLiberacion"},
            { "data": "userLiberacion" }
        ],
        ajax:
            {
                "url": urlTableFred,
                "dataSrc": ""
            },
    });
}

let titulos_see = [];
$('#seeCoSellingAdvisers thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_see.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#seeCoSellingAdvisers').DataTable().column(i).search() !== this.value ) {
            $('#seeCoSellingAdvisers').DataTable().column(i).search(this.value).draw();
        }
    });
});
    
function fillCoSellingAdvisers(urlTableCSA){
    tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        select: true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Asesores venta compartida',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: 
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_see[columnIdx]  + ' ';
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
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { "data": "asesor" },
            { "data": "coordinador" },
            { "data": "gerente" },
            { "data" : "fecha_creacion"},
            { "data": "creado_por" }
        ],
        ajax:{
            "url": urlTableCSA,
            "dataSrc": ""
        },
    });
}

function fill_data_asignacion(){
    $.getJSON(general_base_url + "Administracion/get_data_asignacion/"+idLote).done( function( data ){
        (data.id_estado == 1) ? $("#check_edo").prop('checked', true) : $("#check_edo").prop('checked', false);
        $('#sel_desarrollo').val(data.id_desarrollo_n);
        $("#sel_desarrollo").selectpicker('refresh');
    });
}

$(document).on('click', '#save_asignacion', function(e) {
    e.preventDefault();
    var id_desarrollo = $("#sel_desarrollo").val();
    var id_estado = ($('input:checkbox[id=check_edo]:checked').val() == 'on') ? 1 : 0;
    var data_asignacion = new FormData();
    data_asignacion.append("idLote", idLote);
    data_asignacion.append("id_desarrollo", id_desarrollo);
    data_asignacion.append("id_estado", id_estado);
    if (id_desarrollo == null) {
        alerts.showNotification("top", "right", "Debes seleccionar un desarrollo.", "danger");
    } 
    if (id_desarrollo != null) {
        $('#save_asignacion').prop('disabled', true);
            $.ajax({
            url : general_base_url + 'index.php/Administracion/update_asignacion/',
            data: data_asignacion,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
            response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Asignado con éxito.", "success");
                } else if(response.message == 'ERROR'){
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save_asignacion').prop('disabled', false);
                $('#seeInformationModal').modal('hide');
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});