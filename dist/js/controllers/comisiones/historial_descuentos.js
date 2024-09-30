function cleanCommentsfactura() {
    var myCommentsList = document.getElementById('comments-list-factura');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).ready(function() {
    $("#tabla_factura").prop("hidden", true);
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');
});

$('#filtro33').change(function(ruta){
    residencial = $('#filtro33').val();
    $("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Asesor/getCondominioDesc/${residencial}`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});

$('#filtro33').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getFacturaCommissions(proyecto, condominio);
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getFacturaCommissions(proyecto, condominio);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_factura2 ;
var totaPen = 0;
//INICIO TABLA QUERETARO*************************************
let titulos = [];

$('#tabla_factura thead tr:eq(0) th').each( function (i) {
    if(i != 8 && i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input class="textoshead" type="text" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_factura2.column(i).search() !== this.value) {
                tabla_factura2.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_factura2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_factura2.rows(index).data();

                $.each(data, function(i, v) {
                    total += parseFloat(v.monto);
                });
                var to1 = formatMoney(total);
                document.getElementById("totpagarfactura").textContent = formatMoney(total);
            }
        });
    }
});

function getFacturaCommissions(proyecto, condominio) {
    $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.monto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarfactura").textContent = to;
    });

    $("#tabla_factura").prop("hidden", false);
    tabla_factura2 = $("#tabla_factura").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL_DESCUENTOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0)
                            return ' '+d +' ';
                        else if(columnIdx == 1)
                            return 'USUARIO';
                        else if(columnIdx == 2)
                            return 'MONTO DESCUENTO';
                        else if(columnIdx == 3)
                            return 'NOMBRE LOTE';
                        else if(columnIdx == 4)
                            return 'MOTIVO';
                        else if(columnIdx == 5)
                            return 'ESTATUS';
                        else if(columnIdx == 6)
                            return 'CREADO POR';
                        else if(columnIdx == 7)
                            return 'FECHA CAPTURA';
                        else if(columnIdx != 8 && columnIdx !=0)
                            return ' '+titulos[columnIdx-1] +' ';
                    }
                }
            },
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
        columns: [
            { data: "id_pago_i" },
            { data: "usuario" },
            { data: function( d ){
                return '<p class="m-0">$'+formatMoney(d.monto)+'</p>';
            }},
            { data: "nombreLote" },
            { data: "motivo" },
            { data: function( d ){
                if(d.estatus == 11 || d.estatus == '11' || d.estatus == 17 || d.estatus == '17')
                    return `<span class="label" style="background: #FAD7A0; color: #7E5109">Aplicado</span>`;
                else if(d.estatus == 16 || d.estatus == '16')
                    return `<span class="label" style="background: #AED6F1; color: #1B4F72">Descuento pago solicitado</span>`;
                else
                    return `<span class="label" style="background: #ABB2B9; color: #17202A">Inactivo</span>`;
            }},
            { data: "modificado_por" },
            { data: "fecha_abono" },
            {
                orderable: false,
                data: function( data ){
                    var BtnStats;
                    BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                }
            }
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: `${general_base_url}Comisiones/getHistorialDescuentos/${proyecto}/${condominio}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $('#tabla_factura').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_factura2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.monto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(window).resize(function(){
    tabla_factura2.columns.adjust();
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(document).on("click", ".btn-historial-lo", function(){
    window.open(`${general_base_url}Comisiones/getHistorialEmpresa`, "_blank");
});

function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = `${general_base_url}dist/documentos/${archivo}`;
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}