let titulos = [];
$('#mktdProspectsTable thead tr:eq(0) th').each(function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this).on('keyup change', function () {
        if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value) {
            $('#mktdProspectsTable').DataTable().column(i).search(this.value).draw();
        }   
    });
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

var mktdProspectsTable
$(document).ready(function () {
    mktdProspectsTable = $('#mktdProspectsTable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Prospectos recomendados',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    },
                }
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all"
        }],
        columns: [{
            data: function (d) {
                var  b = '';
                if(d.estatus_particular == 1) { // DESCARTADO
                    b = '<span class="label lbl-warning">DESCARTADO</span>';
                } 
                else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                    b = '<span class="label lbl-yellow">INTERESADO SIN CITA</span>';
                } 
                else if (d.estatus_particular == 3){ // CON CITA
                    b = '<span class="label lbl-green">CON CITA</span>';
                } 
                else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                    b = '<span class="label lbl-gray">SIN ESPECIFICAR</span>';
                } 
                else if (d.estatus_particular == 5){ // PAUSADO
                    b = '<span class="label lbl-azure">PAUSADO</span>';
                } 
                else if (d.estatus_particular == 6){ // PREVENTA
                    b = '<span class="label lbl-violetDeep">PREVENTA</span>';
                }
                if (d.estatus == 1) {
                    return '<b>VIGENTE</b> <br>' + b;
                } 
                else {
                    return '<b>NO VIGENTE</b><br>' + b;
                }
            }
        },
        { 
            data: function (d) {
                return d.nombre;
            }
        },
        { 
            data: function (d) {
                return d.asesor;
            }
        },
        { 
            data: function (d) {
                return d.gerente;
            }
        },
        {
            data: function (d) {
            var  b = '';
            if(d.tipo_recomendado == 0) { // PROSPECT
                b = '<span class="label lbl-oceanGreen">P</span>';
            }
            else if(d.tipo_recomendado == 1) { // CLIENT
            b = '<span class="label lbl-violetChin">C</span>';
            }
            return d.recomendado_por + '<br>' + b;
            }
        },
        { 
            data: function (d) {
                return d.especificacion;
            }
        },
        { 
            data: function (d) {
                return d.fecha_creacion;
            }
        },
        { 
            data: function (d) {
                return d.fecha_vencimiento;
            }
        },
        { 
            data: function (d) {
                return d.fecha_modificacion;
            }
        },
        { 
            data: function (d) {
                return '<div class="d-flex justify-center"> <button class="btn-data btn-acidGreen see-comments" data-id-prospecto="' + d.id_prospecto + '" data-toggle="tooltip"  data-placement="top" title="VER INFORMACIÓN"><i class="fas fa-ellipsis-h"></i></button><div>';
            }
        }
        ],
        ajax: {
            "url": "getRecommendedReport",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });
});
