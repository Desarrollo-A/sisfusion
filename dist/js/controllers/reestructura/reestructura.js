$(document).ready(function () {
    $("#tabla_clientes").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Reestructura/lista_proyecto", function (data) {
        var len = data.length;
        var ids = '1, 11, 28, 14, 12, 32, 22, 34';
        $("#proyecto").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];            
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    $("#spiner-loader").removeClass('hide');
    let index_proyecto = $(this).val();
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
    $('#liberarReestructura').modal();
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
    $('#nombreLoteAv').val($(this).attr('data-nombreLote'));
    $('#precioAv').val($(this).attr('data-precio'));
});

$(document).on('click', '.stat5Rev', function () {
    $('#aceptarReestructura').modal();
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
});

$(document).on('click', '.reesInfo', function (){
    $('#modal_historial').modal();
});

$(document).on('click', '#saveLi', function(){

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
            }
        },
        error: function(){
            closeModalEng();
            $('#liberarReestructura').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '#save2', function () {
    var idLote = $("#idLoteenvARevCE").val();
    let grabado = $("#grabado").val();
    let proJur = $("#procesoJ").val();
    let comentario = $("#comentario2").val();

    parametros = {
        "idLote": idLote,
        "comentario": comentario,
        "grabado": grabado,
        "procesoJuridico": proJur,
    };
});

function open_Mb(){
    $("#catalogoRee").modal();   
}

$(document).on("click","#btnMultiRol",function(){
    $('#multirol').append(`
            <div class="col-md-12 aligned-row">
                <div class="col-md-10 pr-0 pr-0">
                    <div class="form-group text-left m-0">
                        <label class="control-label">Nueva opción (<small class="isRequired">*</small>)</label>
                        <input class="form-control input-gral inpCat" id="inpCat" name="inpCat"></input>
                    </div>
                </div>
                <div class="col-md-2 justify-center d-flex align-end">
                    <div class="form-group m-0 p-0">
                        <button class="btn-data btn-green mb-1 opcCat" id="opcCat" name="opcCat" type="button" data-toggle="tooltip" data-placement="top" title="Eliminar rol"><i class="fas fa-check"></i></button>
                    </div>
                </div>
            </div>
        `);
        // $('[data-toggle="tooltip"]').tooltip();
        // for (var i = 0; i < puestos.length; i++) {
        //     var id = puestos[i].id;
        //     var name = puestos[i].nombre;
        //     $(`#multi_${index}`).append($('<option>').val(id).text(name.toUpperCase()));
        // }
        // for (var i = 0; i < sedes.length; i++) {
        //     var id = sedes[i].id;
        //     var name = sedes[i].nombre;
        //     $(`#sedes_${index}`).append($('<option>').val(id).text(name.toUpperCase()));
        // }
        // $(`#multi_${index}`).selectpicker('refresh');
        // $(`#sedes_${index}`).selectpicker('refresh');
        // index = parseInt(index + 1);
        // $('#index').val(index);
});

$(document).on('click', '#opcCat', function () {
    var nombreLot = $("#nombreLoteAv").val();
});


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
                columns: [0,1,2,3,4,5,6],
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
                return '<p class="m-0">' + d.nombreCliente + '</p>'
            }
        },
        {
            data: function (d) {
                if(d.observacion == null || d.observacion == "NULL"){
                    return '<span class="label lbl-azure">SIN OBSERVACIONES</span>';
                }else if(d.observacion == "LIBERACIÓN JURÍDICA"){
                    return '<span class="label lbl-green">LIBERACIÓN JURÍDICA</span>';
                }else if(d.observacion == "Liberado por Yola"){
                    return '<span class="label lbl-gray">LIBERADO POR YOLANDA</span>';
                }else if(d.observacion == "LIBERADO POR CORREO"){
                    return '<span class="label lbl-orangeYellow">LIBERADO POR CORREO</span>';
                }else{
                    return '<p class="m-0">' + d.observacion + '</p>';
                }
            }
        },
        {
            data: function (d) {
                if(d.observacion == "LIBERACIÓN JURÍDICA"){
                    return '<div class="d-flex justify-center"><button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="' +d.idLote+ '"><i class="fas fa-solid fa-paper-plane"></i></button>'
                    +'<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
                }else{
                    return '<div class="d-flex justify-center"><button class="btn-data btn-green reesVal" data-toggle="tooltip" data-placement="top" title= "LIBERAR LOTE" data-idLote="' +d.idLote+ '" data-nombreLote="' +d.nombreLote+ '" data-precio="' +d.precio+ '"><i class="fas fa-thumbs-up"></i></button>'
                    +'<button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="' +d.idLote+ '"><i class="fas fa-solid fa-paper-plane"></i></button>'
                    +'<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
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
            url: general_base_url + "Reestructura/getregistros",
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


