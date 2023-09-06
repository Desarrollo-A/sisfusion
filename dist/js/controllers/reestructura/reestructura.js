$(document).ready(function () {
    $("#tabla_clientes").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Reestructura/lista_proyecto", function (data) {
        var len = data.length;
        var ids = '30,21,25,13';
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

    datos = {
        "idLote": idLote,
        "nombreLote": nombreLot,
        "precio": precio,
        "tipoLiberacion": 9,
    };

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/aplicarLiberacion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Abono registrado con éxito.", "success");
            document.getElementById("form_abono").reset(); 
            }
        },
        error: function(){
            closeModalEng();
            $('#modal_abono').modal('hide');
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

function fillTable(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes").DataTable({
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
                return '<p class="m-0">' + d.idLote + '</p>'
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.superficie + '</p>'
            }
        },
        {
            data: function (d){
                return '<p class="m-0">' + formatMoney(d.precio) + '</p>'
            }
        },
        {
            data: function (d) {
                if(d.observacion == null || d.observacion == "NULL"){
                    return '<p class="m-0">SIN OBSERVACIÓN</p>';
                }else{
                    return '<p class="m-0">' + d.observacion + '</p>';
                } 
            }
        },
        {
            data: function (d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-green reesVal" data-toggle="tooltip" data-placement="top" title= "LIBERAR LOTE" data-idLote="' +d.idLote+ '" data-nombreLote="' +d.nombreLote+ '" data-precio="' +d.precio+ '"><i class="fas fa-thumbs-up"></i></button>'
                +'<button class="btn-data btn-deepGray stat5Rev" data-toggle="tooltip" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="' +d.idLote+ '"><i class="fas fa-solid fa-paper-plane"></i></button>'
                +'<button class="btn-data btn-blueMaderas reesInfo" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
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


