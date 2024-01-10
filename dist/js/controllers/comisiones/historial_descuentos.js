var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_factura2 ;
var totaPen = 0;
let titulos = [];

function cleanCommentsfactura() {
    var myCommentsList = document.getElementById('comentariosFactura');
    var myCommentsLote = document.getElementById('nombreLote');
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
            $("#catalogo_descuento").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_descuento").selectpicker('refresh');
    }, 'json');
});

$('#catalogo_descuento').change(function(ruta){
    residencial = $('#catalogo_descuento').val();
    $("#condominio_descuento").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Asesor/getCondominioDesc/${residencial}`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominio_descuento").append($('<option>').val(id).text(name));
            }
            $("#condominio_descuento").selectpicker('refresh');
        }
    });
});

$('#catalogo_descuento').change(function(ruta){
    proyecto = $('#catalogo_descuento').val();
    condominio = $('#condominio_descuento').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getFacturaCommissions(proyecto, condominio);
});

$('#condominio_descuento').change(function(ruta){
    proyecto = $('#catalogo_descuento').val();
    condominio = $('#condominio_descuento').val();
    if(condominio == '' || condominio == null || condominio == undefined)
        condominio = 0;
    getFacturaCommissions(proyecto, condominio);
});

$('#tabla_factura thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();

    titulos.push(title);
    $(this).html('<input class="textoshead" type="text" placeholder="' + title + '" title="'+title+'" />');
    $('input', this).on('keyup change', function() {
        if (tabla_factura2.column(i).search() !== this.value) {
            tabla_factura2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_factura2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_factura2.rows(index).data();

            $.each(data, function(i, v) {
                total += parseFloat(v.monto);
            });
            var to1 = formatMoney(total);
            document.getElementById("totpagarfactura").textContent = to1;
        }
    });
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
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth:true,
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
                            return titulos[columnIdx];
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
        columns: [{ 
            data: "id_pago_i" 
        },
        { 
            data: "usuario" 
        },
        { 
            data: function( d ){
                return '<p class="m-0">$'+formatMoney(d.monto)+'</p>';
            }
        },
        { 
            data: "nombreLote" 
        },
        { 
            data: "motivo" 
        },
        { 
            data: function( d ){
                if(d.estatus == 11 || d.estatus == '11' || d.estatus == 17 || d.estatus == '17')
                    return `<span class="label lbl-orange">Aplicado</span>`;
                else if(d.estatus == 16 || d.estatus == '16')
                    return `<span class="label lbl-blueMaderas">Descuento pago solicitado</span>`;
                else
                    return `<span class="label lbl-gray">Inactivo</span>`;
            }
        },
        { 
            data: "modificado_por" 
        },
        { 
            data: "fecha_abono" 
        },
        {
            orderable: false,
            data: function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
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