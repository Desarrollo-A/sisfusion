function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $.get('getFormasPago', function (data) {
        const formasPago = JSON.parse(data);
        formasPago.forEach(formaPago => {
            const id = formaPago.id_opcion;
            const name = formaPago.nombre;
            $("#forma-pago-filtro").append($('<option>').val(id).text(name.toUpperCase()));
        });
        $('#forma-pago-filtro').selectpicker('refresh');
    });

    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#id_proyecto_ei").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#id_proyecto_ei").selectpicker('refresh');
    }, 'json');
});

$('#id_proyecto_ei').change(function(ruta){
    residencial = $('#id_proyecto_ei').val();
    $("#id_condominio_ei").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Asesor/getCondominioDesc/${residencial}`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#id_condominio_ei").append($('<option>').val(id).text(name));
            }
            $("#id_condominio_ei").selectpicker('refresh');
        }
    });
});

$('#id_proyecto_ei').change(function(ruta){
    const formaPago = $('#forma-pago-filtro').val() || 0;
    const proyecto = $('#id_proyecto_ei').val();
    let condominio = $('#id_condominio_ei').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

$('#id_condominio_ei').change(function(ruta){
    const formaPago = $('#forma-pago-filtro').val() || 0;
    const proyecto = $('#id_proyecto_ei').val();
    let condominio = $('#id_condominio_ei').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

$('#forma-pago-filtro').change(function () {
    const formaPago = $(this).val() || 0;
    const proyecto = $('#id_proyecto_ei').val();
    let condominio = $('#id_condominio_ei').val();
    if(condominio === undefined || condominio == null || condominio === '') {
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio, formaPago);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_asimilados2 ;
var totaPen = 0;
//INICIO TABLA QUERETARO*************************************************
let titulos = [];

$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    if(i != 16 && i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input class="textoshead" type="text" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_asimilados2.column(i).search() !== this.value) {
                tabla_asimilados2
                    .column(i)
                    .search(this.value)
                    .draw();
                var total = 0;
                var index = tabla_asimilados2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_asimilados2.rows(index).data();

                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("totpagarAsimilados").textContent = formatMoney(total);
            }
        });
    }
});

function getAssimilatedCommissions(proyecto, condominio, formaPago) {
    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarAsimilados").textContent = '$' + to;
    });

    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados2 = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'ASIMILADOS_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0)
                            return 'ID PAGO';
                        else if(columnIdx == 1)
                            return 'PROYECTO';
                        else if(columnIdx == 2)
                            return 'CONDOMINIO';
                        else if(columnIdx == 3)
                            return 'NOMBRE LOTE ';
                        else if(columnIdx == 4)
                            return 'REFERENCIA';
                        else if(columnIdx == 5)
                            return 'PRECIO LOTE';
                        else if(columnIdx == 6)
                            return 'EMPRESA';
                        else if(columnIdx == 7)
                            return 'TOT. COMISIÓN';
                        else if(columnIdx == 8)
                            return 'P. CLIENTE';
                        else if(columnIdx == 9)
                            return 'DESCUENTO';
                        else if(columnIdx == 10)
                            return 'TOT. PAGAR';
                        else if(columnIdx == 11)
                            return 'TIPO VENTA';
                        else if(columnIdx == 12)
                            return 'COMISIONISTA';
                        else if(columnIdx == 13)
                            return 'PUESTO';
                        else if(columnIdx == 14)
                            return 'REGIMEN';
                        else if(columnIdx == 15)
                            return 'FECH. ENVÍO';
                        else if(columnIdx != 16 && columnIdx !=0)
                            return ' '+titulos[columnIdx-1] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [

            { data: "id_pago_i" },
            { data: "proyecto" },
            { data: "condominio" },
            { data: "lote" },
            { data: "referencia" },
            {
                data: function( d ){
                    return '$' + formatMoney(d.precio_lote);
                }
            },
            { data: "empresa" },
            {
                data: function( d ){
                    return '$' + formatMoney(d.comision_total);
                }
            },
            {
                data: function( d ){
                    return '$' + formatMoney(d.pago_neodata);
                }
            },
            {
                data: function( d ){
                    if(d.id_usuario == 4394)
                        return '<p style="color: red;"><b>NA</b></p>';
                    else {
                        if(d.forma_pago == 3)
                            return '$' + formatMoney(d.dcto);
                        else
                            return '$' + formatMoney(d.dcto);
                    }
                }
            },
            {
                data: function( d ){
                    return '<b>$'+formatMoney(d.impuesto)+'</b>';
                }
            },
            {
                data: function( d ){
                    if(d.lugar_prospeccion == 6){
                        return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                    }
                    else{
                        return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                    }
                
                }
            },
            { data: "usuario" },
            { data: "puesto" },
            {
                data: function( d ){
                    if(d.id_usuario == 4394){
                        return '<p style="color: red;"><b>NA</b></p>';
                    }
                    else{
                        return '<p class="m-0"><b>'+d.regimen+'</b></p>';
                    }
                }
            },
            {
                data: function( d ){
                    var BtnStats1;
                    BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                    
                    return BtnStats1;
                }
            },
            {
                orderable: false,
                data: function( data ){
                    var BtnStats;
                    BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    return BtnStats;
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
            url: `${general_base_url}Comisiones/getDatosEnviadasInternomex/${proyecto}/${condominio}/${formaPago}`,
            type: "POST",
            cache: false,
            data: function( d ){}
        },
    });

    $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    });

    $('#tabla_asimilados').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_asimilados2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
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
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_asimilados2.columns.adjust();
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