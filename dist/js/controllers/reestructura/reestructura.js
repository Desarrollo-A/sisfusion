$(document).ready(function () {
    $("#tabla_clientes").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Reestructura/lista_proyecto",   function (data) {
        
        var len = data.length;
        const ids = data.map((row) => {
            return row.idResidencial;
        }).join(',');

        $("#proyecto").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
     
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];            
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

    $.post(general_base_url + "Reestructura/lista_proyecto", { bandera: 1,} ,  function (data) {
        var len = data.length;
        const ids = data.map((row) => {
            return row.idResidencial;
        }).join(',');
        $("#proyectoLiberado").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];            
            $("#proyectoLiberado").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyectoLiberado").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');



    $.post(general_base_url + "Reestructura/lista_catalogo_opciones", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
        }
        $('.indexCo').val($(this).attr(id));
        $('#spiner-loader').addClass('hide');
    }, 'json'); 
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();

    $("#spiner-loader").removeClass('hide');
    $("#tabla_clientes").removeClass('hide');

    fillTable(index_proyecto);
});

let titulos_intxt = [];
$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_clientes').DataTable().column(i).search() !== this.value ) {
            $('#tabla_clientes').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).on('click', '.reesVal', function (){
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
    $('#nombreLoteAv').val($(this).attr('data-nombreLote'));
    $('#precioAv').val($(this).attr('data-precio'));
    $('#liberarReestructura').modal();
});

$(document).on('click', '.stat5Rev', function () {
    document.getElementById("idLoteCatalogo").value = "";
    document.getElementById("comentario2").value = "";
    $("#grabado").empty();

    $.post(general_base_url + "Reestructura/lista_catalogo_opciones", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];            
            $("#grabado").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $('.indexCo').val($(this).attr(id));
        $("#grabado").selectpicker('refresh');
    }, 'json');

    $('#idLoteCatalogo').val($(this).attr('data-idLote'));
    $('#grabado').val('').trigger('change');
    $('#aceptarReestructura').modal();
});

$(document).on('click', '.guardarValidacion', function(){
    var idLoteCa = $('#idLoteCatalogo').val();
    var opcionValidacion = $('#grabado').val();
    var comentarioValidacion = $('#comentario2').val();
    $("#spiner-loader").removeClass('hide');

    if(comentarioValidacion == ''){
        comentarioValidacion = "SIN COMENTARIO";
    } 

    if(opcionValidacion == ''){
        $("#spiner-loader").addClass('hide');
        alerts.showNotification("top", "right", "Selecciona una opción", "warning");
        return;
    }

    var datos = new FormData();
    datos.append("idLote", idLoteCa);
    datos.append("opcionReestructura", opcionValidacion);
    datos.append("comentario", comentarioValidacion);
    
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/validarLote',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tabla_clientes').DataTable().ajax.reload(null, false);
            $('#aceptarReestructura').modal('hide');
            alerts.showNotification("top", "right", "Información actualizada.", "success");
            $('#idLoteCatalogo').val('');
            $('#grabado').val('');
            $('#comentario2').val('');
            $("#spiner-loader").addClass('hide');
            }
        },
        error: function(){
            $('#aceptarReestructura').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.reesInfo', function (){
    id_prospecto = $(this).attr("data-idLote");
    $('#historialLine').html('');
    $("#spiner-loader").removeClass('hide');

    $.getJSON("getHistorial/" + id_prospecto).done(function(data) {

        array=  data.sort(function(a, b) {
            return a.id_auditoria-b.id_auditoria; 
        });

        if(array.length == 0){
            $("#spiner-loader").addClass('hide');
            $('#historialLine').append("SIN DATOS POR MOSTRAR");
        }else{
            $.each(array, function(i, v) {
                $("#spiner-loader").addClass('hide');
                fillChangelog(v);
            });
        }
    });
    $('#modal_historial').modal();
});

$(document).on('click', '#saveLi', function(){
    $("#spiner-loader").removeClass('hide');
    var idLote = $("#idLoteenvARevCE").val();
    var nombreLot = $("#nombreLoteAv").val();
    var precio = $("#precioAv").val();
    var datos = new FormData();

    datos.append("idLote", idLote);
    datos.append("nombreLote", nombreLot);
    datos.append("precio", precio);
    datos.append("tipoLiberacion", 9); 
    
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/aplicarLiberacion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tabla_clientes').DataTable().ajax.reload(null, false);
            $('#liberarReestructura').modal('hide');
            alerts.showNotification("top", "right", "Lote liberado.", "success");
            $("#spiner-loader").addClass('hide');
            $('#idLoteenvARevCE').val('');
            $('#nombreLoteAv').val('');
            $('#precioAv').val('');
            }
        },
        error: function(){
            $('#liberarReestructura').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function open_Mb(){
    $("#catalogoRee").modal();
    fillTableC(); 
}

function open_Mdc(){
    $("#catalogoNuevo").modal();
}

$(document).on('click', '#guardarCatalogo', function(){
    var ipuntCat = $("#inputCatalogo").val();
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');

    datos.append("nombre", ipuntCat);

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/insertarOpcionN',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tableCatalogo').DataTable().ajax.reload(null, false);
            $('#catalogoNuevo').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Opción insertada correctamente.", "success");
            $('#inputCatalogo').val('');
            }
        },
        error: function(){
            $('#catalogoNuevo').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    return;
});

$(document).on('click', '#borrarOpcion', function () {
    $('#idOpcion').val($(this).attr('data-idOpcion'));
    $("#modalBorrar").modal();
});

$(document).on('click', '#borrarOp', function(){
    var idOpcion = $("#idOpcion").val();
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');

    datos.append("idOpcion", idOpcion);

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/borrarOpcion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tableCatalogo').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            $('#modalBorrar').modal('hide');
            alerts.showNotification("top", "right", "Opción Eliminada.", "success");
            }
        },
        error: function(){
            $("#spiner-loader").addClass('hide');
            $('#modalBorrar').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '#editarOpcion', function(){
    $('#id_opcionEdit').val($(this).attr('data-idOpcion'));
    $("#editarModel").modal();
})

$(document).on('click', '#guardarEdit', function(){
    var idOpcionEdit = $('#id_opcionEdit').val();
    var editarCatalogo = $("#editarCatalogo").val();
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');

    datos.append("idOpcionEdit", idOpcionEdit);
    datos.append("editarCatalogo", editarCatalogo);

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/editarOpcion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tableCatalogo').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            $('#editarModel').modal('hide');
            alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
            $('#editarCatalogo').val('');
            $('#idOpcionEdit').val('');
            }
        },
        error: function(){
            $('#editarModel').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function fillChangelog(v) {
    $("#historialLine").append(`<li>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <a><b>  ${v.creado_por.toUpperCase()}  </b></a><br>
                </div>
                <div class="float-end text-right">
                    <a> ${v.fecha_creacion} </a>
                </div>
                <div class="col-md-12">
                    <p class="m-0"><small>Valor anterior: </small><b>  ${(v.nombre) ? v.nombre.toUpperCase() : '-'} </b></p>
                    <p class="m-0"><small>Valor nuevo: </small><b> ${v.nombreNuevo.toUpperCase()} </b></p>
                </div>
            </div>
        </div>
    </li>`);
}

function fillTable(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
        text: '<i class="fas fa-tags"></i> CATÁLOGO',
            action: function() {
                open_Mb();
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: right',
            },
        },
        {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Reestructuración',
        title: 'Reestructuración',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_intxt[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.idLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.superficie + '</p>';
            }
        },
        {
            data: function (d){
                return '<p class="m-0">' + formatMoney(d.precio) + '</p>';
            }
        },
        {
            data: function (d){
                if (d.nombreCliente === null || d.nombreCliente.trim() === '') {
                    return '<p class="m-0">SIN ESPECIFICAR</p>';
                }
                return '<p class="m-0">' + d.nombreCliente + '</p>'
            }
        },
        {
            data: function (d){
                if(d.nombreOp !=  null){
                    return '<p class="m-0">' + d.nombreOp + '</p>'
                }else{
                    return '<p class="m-0">N/A</p>'
                }
            }
        },
        {
            data: function (d){
                if(d.comentarioReubicacion != null && d.comentarioReubicacion != 'NULL'){
                    return '<p class="m-0">' + d.comentarioReubicacion + '</p>'
                }else{
                    return '<p class="m-0"> - </p>'
                }
            }
        },
        {
            data: function (d) {
                if(d.liberadoReubicacion == "LIBERACIÓN JURÍDICA"){
                    return '<span class="label lbl-green">LIBERACIÓN JURÍDICA</span>';
                }else{
                    return '<span class="label lbl-azure">SIN OBSERVACIONES</span>';
                }
            }
        },
        {
            data: function (d) {
                if(d.liberadoReubicacion ==  "LIBERACIÓN JURÍDICA"){
                    return '<div class="d-flex justify-center"><button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="' +d.idLote+ '"><i class="fas fa-edit"></i></button>'
                    +'<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" data-idLote="' +d.idLote+ '" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
                }else{
                    return '<div class="d-flex justify-center"><button class="btn-data btn-green reesVal" data-toggle="tooltip" data-placement="top" title= "LIBERAR LOTE" data-idLote="' +d.idLote+ '" data-nombreLote="' +d.nombreLote+ '" data-precio="' +d.precio+ '"><i class="fas fa-thumbs-up"></i></button>'
                    +'<button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="' +d.idLote+ '"><i class="fas fa-edit"></i></button>'
                    +'<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" data-idLote="' +d.idLote+ '" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
                }
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/getRegistros",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_clientes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$('#tableCatalogo thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tableCatalogo').DataTable().column(i).search() !== this.value ) {
            $('#tableCatalogo').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTableC(index_proyecto) {
    tabla_valores_catalogos = $("#tableCatalogo").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
        text: '<i class="fas fa-check"></i> Agregar',
            action: function() {
                open_Mdc();
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: left',
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 5,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            data: function (d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-warning borrarOpcion" id="borrarOpcion" name="borrarOpcion" data-toggle="tooltip" data-placement="top" title= "ELIMINAR OPCIÓN" data-idOpcion="' +d.id_opcion+ '"><i class="fas fa-trash"></i></button></div>';        
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/lista_catalogo_opciones",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_clientes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}




// tabla para liberar segunda tabla inicio 


$(document).on('click', '.liberarBandera', function (){
    document.getElementById('liberarBandera').disabled = true;
    var bandera = document.getElementById('bandera').value;

    var idLoteBandera = document.getElementById('idLoteBandera').value;
    console.log(bandera)
    console.log(idLoteBandera)
    $.ajax({
        url : 'cambiarBandera',
        type : 'POST',
        dataType: "json",
        data: {
        "bandera"    : bandera,
        "idLoteBandera"     : idLoteBandera,
            },
            success: function(data) {
            alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
            document.getElementById('liberarBandera').disabled = false;
            $('#tabla_clientes_liberar').DataTable().ajax.reload(null, false );

            // toastr[response.response_type](response.message);
            $('#banderaLiberar').modal('toggle');
        },
        error : (a, b, c) => {
            alerts.showNotification("top", "right", "Lote No actualizado .", "warning");
        }
    });

});

$(document).on('click', '.cambiarBandera', function (){
    let bandera  = '¿Estás seguro de LIBERAR el lote para reestructura?';
  
    lote   = $(this).attr("data-idLote");
    activoDetenido  = $(this).attr("data-bandera");
    if(activoDetenido == 0){ 
        bandera = '¿Estás seguro de REGRESAR el lote del proceso de reestructura?';
     
    }
 
    
    document.getElementById("tituloAD").innerHTML =   bandera;
 
    document.getElementById("bandera").value = activoDetenido;
    document.getElementById("idLoteBandera").value = lote;

    $('#banderaLiberar').modal();

});


let titulos_intxtLiberado = [];
$('#tabla_clientes_liberar thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxtLiberado.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_clientes_liberar').DataTable().column(i).search() !== this.value ) {
            $('#tabla_clientes_liberar').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#proyectoLiberado').change(function () {
    let index_proyecto = $(this).val();

    $("#spiner-loader").removeClass('hide');
    $("#tabla_clientes_liberar").removeClass('hide');

    fillTable1(index_proyecto);
});
$('#proyectoLiberado').change(function () {
    let index_proyecto = $(this).val();

    $("#spiner-loader").removeClass('hide');
    $("#tabla_clientes_liberar").removeClass('hide');

    fillTable1(index_proyecto);
});

function fillTable1(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes_liberar").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
        {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Reestructuración',
        title: 'Reestructuración',
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_intxtLiberado[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
                // proyecto
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            // condominio
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            /// lote
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.idLote + '</p>';
            // IDlote
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.superficie + '</p>';
            // superficie
            }
        },
        {
            data: function (d){
                return '<p class="m-0">' + formatMoney(d.precio) + '</p>';
        //    precio
            }
        },
        {
            data: function (d){
                if (d.nombreCliente == null || d.nombreCliente == '' || d.nombreCliente == ' ') {
                    return '<p class="m-0">SIN ESPECIFICAR</p>';
        
                }
                return '<p class="m-0"> ' + d.nombreCliente + '</p>'
            // NOMBRE
            }
        },
        {
            data: function (d){
                if (d.liberaBandera == 1   ) {
                    return '<p class="m-0">LIBERADO</p>';
        
                }else if(d.liberaBandera == 0){
                    return '<p class="m-0">SIN LIBERAR</p>';
                }      
            // NOMBRE
            }
        },
        {
            data: function (d) {
                    if(d.liberaBandera == 0){
                    return `<div class="d-flex justify-center">
                            <button class="btn-data btn-azure cambiarBandera" data-toggle="tooltip" data-placement="top"  
                            title= "Liberar Lote" 
                            data-idLote="${d.idLote}" data-bandera="1"><i class="fas fa-unlock"></i></button>`;
                    }else{
                    return `<div class="d-flex justify-center">
                            <button class="btn-data btn-warning cambiarBandera" data-toggle="tooltip" data-placement="top" 
                            title= "Quitar liberación de Lote" 
                            data-idLote="${d.idLote}" data-bandera="0"><i class="fas fa-lock"></i></button>` ;
                        }
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/getRegistros",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_clientes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}


// fin de la segunda tabla 
