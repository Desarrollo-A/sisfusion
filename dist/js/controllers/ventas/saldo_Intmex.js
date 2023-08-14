var tr;
var tabla_historialGral2;
var totaPen = 0;

function cleanCommentsData() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    myCommentsList.innerHTML = '';
}

$(document).ready(function(){
    $("#tabla_historialGral").prop("hidden", true);
    $.post(general_base_url + "Comisiones/listEmpresa", function(data) {
        var len = data.length;
        $("#empresa").append($('<option value="null">TODAS</option>'));
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['nombreUser'];
            var name = data[i]['nombreUser'];
            $("#empresa").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#empresa").selectpicker('refresh');
    }, 'json');
    $.post(general_base_url + "Comisiones/listRegimen", function(data) {
        var len = data.length;
        $("#regimen").append($('<option value="0">TODOS</option>'));
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_opcion'];
            var name = data[i]['descripcion'];
            $("#regimen").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#regimen").selectpicker('refresh');
    }, 'json');
});

$('#empresa').change( function(){
    empresa = $('#empresa').val();
    regimen = $('#regimen').val();
    if(regimen == ''){
        regimen = 0;
    }
    getAssimilatedCommissions(empresa, regimen);
});

$('#regimen').change( function(){
    regimen = $('#regimen').val();
    empresa = $('#empresa').val();
    if(empresa == ''){
        empresa = 0;
    }
    getAssimilatedCommissions(empresa, regimen);
});

let titulos = [];
$('#tabla_historialGral thead tr:eq(0) th').each(function(i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value) {
            $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
        }
        if (tabla_historialGral2.column(i).search() !== this.value) {
            tabla_historialGral2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_historialGral2.rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = tabla_historialGral2.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.dispersado);
            });
            document.getElementById("myText_nuevas").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

function getAssimilatedCommissions(empresa, regimen) {
    $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.dispersado);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("myText_nuevas").textContent = to;
    });

    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Reporte de saldos',
            exportOptions: {
                columns: [0,1, 2, 3, 4],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
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
            data: function(d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.idResidencial + '</b></p>';
                return lblStats;
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.empresa + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(numberTwoDecimal(d.dispersado))+ '</b></p>';
            }
        },
        {
            data: function(d) {
                if(d.nombre == null){
                    return '<p class="m-0"> TODOS </p>';
                }else{
                    return '<p class="m-0">' + d.nombre + ' </p>';
                } 
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosSaldosIntmex/" + empresa + "/" + regimen,
            "type": "POST",
            cache: false,
            data: function(d) {}
        },
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_historialGral').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_historialGral2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.pago_cliente;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });
}

$(window).resize(function() {
    tabla_historialGral2.columns.adjust();
}); 