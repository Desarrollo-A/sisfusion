var idResidencial;
var grupo;
var clusterSelect;
var clusterSelect2;
var supSelect;
var supSelect2;
var preciomSelect;
var preciomSelect2;
var totalSelect;
var totalSelect2;
var mesesSelect;
var mesesSelect2;

$(document).ready(function() {
    $.post(`${general_base_url}index.php/Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro3").selectpicker('refresh');
    }, 'json');
});

$('#filtro3').change(function(){
    residencial = $('#filtro3').val();
    grupo = $('#filtro5').val();
    if(residencial == 0){
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getCondominioDescTodos/`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++) {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');
            }
        });
        $("#filtro6").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getSupOneTodos/`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['sup'];
                    var name = response[i]['sup'];
                    $("#filtro6").append($('<option>').val(id).text(name+" m2"));
                }
                $("#filtro6").selectpicker('refresh');
            }
        });
        $("#filtro7").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getPrecioTodos/`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['precio'];
                    var name = response[i]['precio'];
                    $("#filtro7").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
                }
                $("#filtro7").selectpicker('refresh');
            }
        });
        $("#filtro8").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getTotalTodos/`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['total'];
                    var name = response[i]['total'];
                    $("#filtro8").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
                }
                $("#filtro8").selectpicker('refresh');
            }
        });
        $("#filtro9").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getMesesTodos/`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['msni'];
                    var name = response[i]['msni'];
                    $("#filtro9").append($('<option>').val(id).text(name + " MSI"));
                }
                $("#filtro9").selectpicker('refresh');
            }
        });
    }
    else if (residencial > 0){
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getCondominioDesc/${residencial}`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');
            }
        });
        $("#filtro6").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getSupOne/${residencial}`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['sup'];
                    var name = response[i]['sup'];
                    $("#filtro6").append($('<option>').val(id).text(name+" m2"));
                }
                $("#filtro6").selectpicker('refresh');
            }
        });
        $("#filtro7").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getPrecio/${residencial}`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['precio'];
                    var name = response[i]['precio'];
                    $("#filtro7").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
                }
                $("#filtro7").selectpicker('refresh');
            }
        });
        $("#filtro8").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Asesor/getTotal/${residencial}`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['total'];
                    var name = response[i]['total'];
                    $("#filtro8").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
                }
                $("#filtro8").selectpicker('refresh');
            }
        });
        $("#filtro9").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'Asesor/getMeses/'+residencial+'/'+1,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['msni'];
                    var name = response[i]['msni'];
                    $("#filtro9").append($('<option>').val(id).text(name + " MSI"));
                }
                $("#filtro9").selectpicker('refresh');
            }
        });
    }
});

$('#filtro4').change(function(){
    let condominio = $('#filtro4').val();
    $("#filtro9").empty().selectpicker('refresh');
    if(condominio.length>0){
        $.ajax({
            url: general_base_url + 'Asesor/getMeses/'+condominio+'/'+2,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['msni'];
                    var name = response[i]['msni'];
                    $("#filtro9").append($('<option>').val(id).text(name + " MSI"));
                }
                $("#filtro9").selectpicker('refresh');
            }
        });
    }
});

$('.selectpicker').on('change', function(event){
    var form = $(this).closest('form');
    form.submit();
});

$('#formFilters').on('submit', function(event){
    event.preventDefault();
    var data = $('#formFilters').serializeArray();
    $.ajax({
        url: `${general_base_url}Asesor/get_info_tabla/`,
        type: 'post',
        dataType: 'json',
        data: data,
        beforeSend:function(){
			$('#spiner-loader').removeClass('hide');
            $('#addExp').addClass('hide');
        },
        success:function(response){
            dataTable(response);
			$('#spiner-loader').addClass('hide');
            $('#addExp').removeClass('hide');
        }
    })
});

let titulos_encabezado = [];
let num_colum_encabezado = [];
$('#addExp thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#addExp').DataTable().column(i).search() !== this.value) {
            $('#addExp').DataTable().column(i).search(this.value).draw();
        }
    });
    if (title !== 'ACCIONES') {
        titulos_encabezado.push(title);
        num_colum_encabezado.push(i);
    }    
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

function dataTable(ruta) {
    var table = $('#addExp').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,   
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        },
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Reporte Inventario Disponible',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado[columnIdx] +' ';
                    }
                }
            },
        } ,
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: 'Descargar archivo PDF',
            title: 'Reporte Inventario Disponible',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado[columnIdx] +' ';
                    }
                }
            }
        }],
        destroy: true,
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
        }],
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            {
                data: function (d) {
                    return d.sup + ' <b>m<sup>2</sup></b>';
                }
            },
            { data: function(data){return "$ " + alerts.number_format(data.precio, '2', '.', ',')} },
            { data: function(data){return "$ " + alerts.number_format(data.total, '2', '.', ',')} },
            { data: 'mesesn' },
            { 
                data:function(data){
                    if(data.tipo_venta == 1){
                        return `<small  class='label lbl-green'>
                                    VENTA DE PARTICULARES
                                </small>`} 
                    else { 
                        return `<small  class='label lbl-sky'>
                                    VENTA NORMAL
                                </small>`
                    } 
                }
            },
            { data: 
                function(data){ 
                    if(data.tipo_venta == 1) { 
                        return `<center>
                                    <button class="btn-data btn-blueMaderas ver_historial" value="${data.idLote}" data-nomLote="${data.nombreLote}" data-tipo-venta="${data.tipo_venta}" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN" ><i class="fas fa-info"></i></button>
                                </center>`;
                    } else { 
                        return "" 
                    } 
                } 
            }
        ],
        "data": ruta
    });
}

$(document).on("click", ".ver_historial", function(){
    idLote = $(this).val();
    $.getJSON(`${general_base_url}Contratacion/getClauses/${idLote}`).done( function( data ){
        $('#clauses_content').html(data[0]['nombre']);
    });	
    $("#seeInformationModal").modal();
});