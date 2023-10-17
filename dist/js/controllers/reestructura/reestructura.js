$(document).ready(function () {
    $("#tabla_clientes").addClass('hide');
    $("#tabla_clientes_liberar").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    getProtectos(bandera = 0, '#proyecto');
});

function getProtectos($bandera, $tipo){
    $("#proyectoLiberado").empty();
    $("#proyecto").empty();
    
    $.post(general_base_url + "Reestructura/lista_proyecto",{ bandera : $bandera},   function (data) {
        var len = data.length;
        const ids = data.map((row) => {
            return row.idResidencial;
        }).join(',');
            $($tipo).append($('<option>').val(ids).text('SELECCIONAR TODOS'));
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];            
            $($tipo).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $($tipo).selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

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
    const idLoteReave = $(this).attr('data-idLote');
    const nombreLote = $(this).attr('data-nombreLote');
    const precioAv = $(this).attr('data-precio');

    changeSizeModal('modal-md');
        appendBodyModal(`<form method="post" id="formLiberarLote">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                            <h4>¿Estás seguro de liberar el lote?</h4>
                        </div>
                        <br>
                        <input type="hidden" name="idLote" id="idLoteenvARevCE" value="${idLoteReave}" >
                        <input type="hidden" name="nombreLote" id="nombreLoteAv" value="${nombreLote}" >
                        <input type="hidden" name="precio" id="precioAv" value="${precioAv}" >        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="saveLi" name="saveLi" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>`);
        showModal();
});

$(document).on('click', '.stat5Rev', function () {
    $("#grabado").empty();

    changeSizeModal('modal-md');
        appendBodyModal(`<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                        <h4 class="modal-title text-center">Validar lote para reestructura</h4>
                    </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>ESTATUS</label>
                                <select name="grabado" id="grabado" class="selectpicker select-gral m-0 grabado" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1">
                            <label>COMENTARIO</label>
                            <textarea class="text-modal" id="comentario2" rows="3"></textarea>
                        </div>
                        <br>
                        <input type="hidden" name="idLoteCatalogo" id="idLoteCatalogo" >
                    <div class="modal-footer">
                        <button type="button" id="cancelarValidacion" class="btn btn-danger btn-simple cancelarValidacion" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="guardarValidacion" name="guardarValidacion" class="btn btn-primary guardarValidacion">Registrar</button>
                    </div>`);
        showModal();

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
            hideModal();
            alerts.showNotification("top", "right", "Información actualizada.", "success");
            $('#idLoteCatalogo').val('');
            $('#grabado').val('');
            $('#comentario2').val('');
            $("#spiner-loader").addClass('hide');
            }
        },
        error: function(){
            hideModal();
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.reesInfo', function (){
    id_prospecto = $(this).attr("data-idLote");
    $('#historialLine').html('');
    $("#spiner-loader").removeClass('hide');

    changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-header">
                    <h4 class="modal-title text-center">HISTORIAL MOVIMIENTOS</h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="historialTap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="historialLine"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" ><b>Cerrar</b></button>
                </div>`);
    showModal();

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
});

$(document).on('click', '#saveLi', function(){
    $("#spiner-loader").removeClass('hide');
    let datos = new FormData($("#formLiberarLote")[0]);
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
                hideModal();
                alerts.showNotification("top", "right", "Lote liberado.", "success");
                $("#spiner-loader").addClass('hide');
                $('#idLoteenvARevCE').val('');
                $('#nombreLoteAv').val('');
                $('#precioAv').val('');
            }
        },
        error: function(){
            hideModal();
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function open_Mb(){
    changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-header">
                    <div class="row d-flex justify-center align-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <h4 class="modal-title text-center">CATÁLOGO</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="material-datatables">
                        <div class="form-group">
                            <table class="table-striped table-hover" id="tableCatalogo" name="tableCatalogo">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>`);
        showModal();
    fillTableC(); 
}

function open_Mdc(){
    changeSizeModal('modal-sm');
    appendBodyModal(`<div class="modal-header">
            <h5 class="modal-title text-center">Cargar nueva opción</h5>
        </div>
        <form id="addNewDesc">
            <input type="hidden" value="0" name="id_opcion" id="id_opcion">
            <div class="form-group d-flex justify-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <input type="text" class="form-control input-gral" id="inputCatalogo" name="inputCatalogo" required>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row mt-1 mb-1 d-flex align-center">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <input type="button" class="btn btn-danger btn-simple m-0" data-dismiss="modal" value="CANCELAR">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <input type="button" class="btn btn-primary" name="guardarCatalogo"  id="guardarCatalogo" value="GUARDAR">
                    </div>
                </div>
            </div>
        </form>`);
    showModal();
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
                alerts.showNotification("top", "right", "Opción insertada correctamente.", "success");
                $('#inputCatalogo').val('');
                open_Mb();
                $("#spiner-loader").addClass('hide');
            }
        },
        error: function(){
            hideModal();
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
                columns: [0,1,2,3,4,5,6,7,8],
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
                let btns = '';

                const BTN_LIBRESS = `<button class="btn-data btn-green reesVal" data-toggle="tooltip" data-placement="top" title= "LIBERAR LOTE" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-precio="${d.precio}"><i class="fas fa-thumbs-up"></i></button>`;
                const BTN_VALREES = `<button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="${d.idLote}"><i class="fas fa-edit"></i></button>`;
                const BTN_INFREES = `<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" data-idLote="${d.idLote}" title="HISTORIAL"><i class="fas fa-info"></i></button></div>`;

                if(d.liberadoReubicacion ==  "LIBERACIÓN JURÍDICA"){
                    btns += BTN_VALREES;
                    btns += BTN_INFREES;
                }else{
                    btns += BTN_LIBRESS;
                    btns += BTN_VALREES;
                    btns += BTN_INFREES;
                }
                return `<div class="d-flex justify-center">${btns}</div>`;
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
                return '<p class="m-0">N/A</p>';
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

$(document).on('click', '.liberarBandera', function (){
    document.getElementById('liberarBandera').disabled = true;
    var bandera = document.getElementById('bandera').value;
    var idLoteBandera = document.getElementById('idLoteBandera').value;

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
            hideModal();
        },
        error : (a, b, c) => {
            alerts.showNotification("top", "right", "Lote No actualizado .", "warning");
        }
    });
});

$(document).on('click', '.cambiarBandera', function (){
    let bandera  = '¿Estás seguro de LIBERAR el lote para reestructura?';
    lote = $(this).attr("data-idLote");
    activoDetenido  = $(this).attr("data-bandera");

    changeSizeModal('modal-sm');
    appendBodyModal(`<div class="modal-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                <h4  id="tituloAD" name="tituloAD"></h4>
            </div>
                <br>
                <input type="hidden" name="idLoteBandera" id="idLoteBandera" >
                <input type="hidden" name="bandera" id="bandera" >        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="liberarBandera" name="liberarBandera" class="btn btn-primary liberarBandera">Aceptar</button>
            </div>`);
    showModal();

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

function fillTable1(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes_liberar").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
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
                if (d.nombreCliente == null || d.nombreCliente == '' || d.nombreCliente == ' ') {
                    return '<p class="m-0">SIN ESPECIFICAR</p>';
                }
                return '<p class="m-0"> ' + d.nombreCliente + '</p>'
            }
        },
        {
            data: function (d){
                if (d.liberaBandera == 1) {
                    return '<p class="m-0">LIBERADO</p>';
                }else if(d.liberaBandera == 0){
                    return '<p class="m-0">SIN LIBERAR</p>';
                }      
            }
        },
        {
            data: function (d) {

                const colorBtn = (d.liberaBandera == 0) ? "btn-blueMaderas" : "btn-warning";
                const tituloBtn = (d.liberaBandera == 0) ? "Liberar Lote" : "Quitar liberación de Lote";
                const banderaBtn = (d.liberaBandera == 0) ? "1" : "0";
                const iconoBtn = (d.liberaBandera == 0) ? "fa-unlock" : "fa-lock";

                return `<div class="d-flex justify-center"><button class="btn-data ${colorBtn} cambiarBandera" data-toggle="tooltip" data-placement="top" title="${tituloBtn}" data-idLote="${d.idLote}" data-bandera= ${banderaBtn}><i class="fas ${iconoBtn}"></i></button></div>`;
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/obtenerRegistrosLiberar",
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
