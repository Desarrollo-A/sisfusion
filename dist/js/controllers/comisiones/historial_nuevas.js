var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_asimilados2 ;
var totaPen = 0;
let titulos = [];

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $("#spiner-loader").removeClass('hide');
    $.post(`${general_base_url}Comisiones/lista_roles`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var catalog = data[i]['id_catalogo'];
            $("#id_rol_hn").append($('<option>').val(id).attr('data-catalogo', catalog).text(name.toUpperCase()));
        }
        $("#id_rol_hn").selectpicker('refresh');
        $("#spiner-loader").addClass('hide');
    }, 'json');
});

$('#id_rol_hn').change(function(ruta){
    id_rol = $('#id_rol_hn').val();
    id_catalogo = $('#id_rol_hn>option:selected').attr("data-catalogo");
    $("#id_usuario_hn").empty().selectpicker('refresh');
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        url: `${general_base_url}Comisiones/usuarios_nuevas`,
        type: 'post',
        data: {'id_rol': id_rol, 'id_catalogo': id_catalogo},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['id_usuario'];
                var name = response[i]['nombre'];
                $("#id_usuario_hn").append($('<option>').val(id).text(name));
            }
            $("#id_usuario_hn").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });
});

$('#id_usuario_hn').change(function(ruta){
    $("#spiner-loader").removeClass('hide');
    id_rol = $('#id_rol_hn').val();
    id_usuario = $('#id_usuario_hn').val();
    if(id_usuario == '' || id_usuario == null || id_usuario == undefined)
    id_usuario = 0;
    fillTable(id_rol, id_usuario);
});

$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_asimilados2.column(i).search() !== this.value) {
            tabla_asimilados2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_asimilados2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_asimilados2.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.impuesto);
            });
            document.getElementById("totpagarAsimilados").textContent = formatMoney(total);
        }
    });
});

function fillTable(id_rol, id_usuario){

    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarAsimilados").textContent = to;
    });

    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados2 = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PAGOS NUEVOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
            data: "id_pago_i" 
        },
        { 
            data: "proyecto" 
        },
        { 
            data: "condominio" 
        },
        { 
            data: "lote" 
        },
        {
            data: "referencia" 
        },
        {
            data: function( d ){
                return formatMoney(d.precio_lote);
            }
        },
        {
            data: function( d ){
                return formatMoney(d.comision_total);
            }
        },
        { 
            data: "valimpuesto" 
        },
        {
            data: function( d ){
                return formatMoney(d.dcto);
            }
        },
        {
            data: function( d ){
                return formatMoney(d.impuesto);
            }
        },
        { 
            data: "usuario" 
        },
        { 
            data: "puesto" 
        },
        { 
            data: "estatus_actual" 
        },
        {
            orderable: false,
            data: function( data ){
                var BtnStats;
                    BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PAGO">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+ BtnStats +'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable:false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: `${general_base_url}Comisiones/getDatosNuevasMontos/${id_rol}/${id_usuario}`,
            type: "POST",
            cache: false,
            data: function( d ){
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });

    $('#tabla_asimilados').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });
}

$(window).resize(function(){
    tabla_asimilados2.columns.adjust();
});