
$(document).ready(function () {
    setInitialDates();
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    cargarTablaInventario($("#beginDate").val(), $("#endDate").val());
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

$(document).on('click', '#searchByDateRange', function(){
    cargarTablaInventario($("#beginDate").val(), $("#endDate").val());
});

function setInitialDates() {
    var beginDt = moment().startOf('year').format('DD/MM/YYYY');
    var endDt = moment().format('DD/MM/YYYY');
    console.log(beginDt, endDt);
    $('#beginDate').val(beginDt);
    $('#endDate').val(endDt);
}

let titulosInventario = [];
$('#tablaReportes thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tablaReportes').DataTable().column(i).search() !== this.value) {
            $('#tablaReportes').DataTable().column(i).search(this.value).draw();
        }
    });
});

function cargarTablaInventario(fechaInicio, fechaFin) {    
    tabla_inventario = $("#tablaReportes").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Clientes/getFechaBetween/`,
            type: "POST",
            cache: false,
            data: {
                beginDate: fechaInicio,
                endDate: fechaFin
                
                
            }
        },
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Inventario lotes',
                exportOptions: {
                    columns: coordinador = (id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: 'Inventario lotes',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            }],
 
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        fixedColumns: true,
        columns: [
            { 
                data: 'nombreResidencial' 
            },
            { 
                data: 'nombreCondominio' 
            },
            {
                data: 'nombreLote'
            },
            
            { data: 'idLote' },
            { data: 'referencia' },
            { data: 'nombreCliente'},
            {
                data: function (d) {
                    var fecha = d.estatusLote == 8 || d.estatusLote == 9 || d.estatusLote == 10 ? d.fecha_modst : d.fechaApartado;
                    return fecha ? moment(fecha).format('DD-MM-YYYY') : 'SIN ESPECIFICAR';
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.nombreAsesor;
                    else
                        return d.nombreAsesor;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.nombreCoordinador;
                    else
                        return d.nombreCoordinador;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.nombreGerente;
                    else
                        return d.nombreGerente;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.nombreSubdirector;
                    else
                        return d.nombreSubdirector;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.nombreRegional;
                    else
                        return d.nombreRegional;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return 'SIN ESPECIFICAR';
                    else
                        return d.nombreRegional2;
                }
            },
            { data: 'estatusLote' },
            {data: 'estatusContratacion'},
            {data: 'descripcion'},
            {
                data: function (d) { // VALIDAR FECHAS NULL DESDE LA QUERY
                    if (d.comentario == null || d.comentario == 'NULL' || d.comentario == '')
                        return 'SIN ESPECIFICAR';
                    else
                        return d.comentario;
                }
            },
            {data: 'ubicacionVenta'},
        ],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

