typeTransaction = 1;
let titulos_intxt = [];
$('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
            $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function () {
    /*primera carga*/
    $("#subDir").empty().selectpicker('refresh');
    $.post(general_base_url + 'index.php/Clientes/getSubdirs/', function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#subDir").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#subDir").append('<option selected="selected" disabled>NINGUN SUBDIRECTOR</option>');
        }
        $("#subDir").selectpicker('refresh');
    }, 'json');


    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth();
});
sp = { //  SELECT PICKER
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

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    var url_inter;
    $('#spiner-loader').removeClass('hide');

    if(gerente != undefined && coordinador==undefined && asesor==undefined){
        url_inter = general_base_url + "index.php/Clientes/getProspectsListByGerente/"+gerente;
    }else if(gerente != undefined && coordinador!=undefined && asesor==undefined){
        url_inter = general_base_url + "index.php/Clientes/getProspectsListByCoord/"+coordinador;
    }else if(gerente != undefined && coordinador!=undefined && asesor!=undefined){
        url_inter = general_base_url + "index.php/Clientes/getProspectsListByAsesor/"+asesor;
    }
    updateTable(url_inter, 3, finalBeginDate, finalEndDate, 0);
});

$('#subDir').on('change', function () {
    var subdir = $("#subDir").val();
    //gerente
    $("#gerente").empty().selectpicker('refresh');
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesores").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $('#filter_date').addClass('hide');
    $.post(general_base_url + 'index.php/Clientes/getGerentesBySubdir/'+subdir, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
        }
        $("#gerente").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

var gerente;
var coordinador;
var asesor;
$('#gerente').on('change', function () {
    $('#filter_date').removeClass('hide');
    gerente = $("#gerente").val();
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesores").empty().selectpicker('refresh');
    $.post(general_base_url + 'index.php/Clientes/getCoordsByGrs/'+gerente, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinador").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#coordinador").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
        }
        $("#coordinador").selectpicker('refresh');
    }, 'json');
    $('#prospects-datatable_dir').removeClass('hide');
    /**///carga tabla
    var url = general_base_url + "index.php/Clientes/getProspectsListByGerente/"+gerente;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

$('#coordinador').on('change', function () {
    coordinador = $("#coordinador").val();
    $('#filter_date').removeClass('hide');
    $("#asesores").empty().selectpicker('refresh');
    $.post(general_base_url + 'index.php/Clientes/getAsesorByCoords/'+coordinador, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#asesores").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#asesores").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
        }
        $("#asesores").selectpicker('refresh');
    }, 'json');
    /**///carga tabla
    var url = general_base_url + "index.php/Clientes/getProspectsListByCoord/"+coordinador;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

//asesor
$('#asesores').on('change', function () {
    asesor = $("#asesores").val();
    /**///carga tabla
    var url = general_base_url + "index.php/Clientes/getProspectsListByAsesor/"+asesor;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});



var prospectsTable;
function updateTable(url, typeTransaction, beginDate, endDate, where)
{
    prospectsTable = $('#prospects-datatable_dir').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        width:'100%',
        "ordering": false,
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado general de prospectos',
                title:"Listado general de prospectos",
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            { data: function (d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label lbl-green">Vigente</span><center>';
                    } else {
                        return '<center><span class="label lbl-warning">Sin vigencia</span><center>';
                    }
                }
            },
            { data: function (d) {
                    if(d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label lbl-warning">Descartado</span><center>';
                    } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label lbl-orangeYellow">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3){ // CON CITA
                        b = '<center><span class="label lbl-green">Con cita</span><center>';
                    } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                        b = '<center><span class="label lbl-gray">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5){ // PAUSADO
                        b = '<center><span class="label lbl-azure">Pausado</span><center>';
                    } else if (d.estatus_particular == 6){ // PREVENTA
                        b = '<center><span class="label lbl-pink">Preventa</span><center>';
                    }
                    return b;
                }
            },
            {   data: function (d) {
                    if (d.tipo == 0){
                        return '<center><span class="label lbl-orangeYellow">Prospecto</span></center>';
                    } else {
                        return '<center><span class="label lbl-oceanGreen">Cliente</span></center>';
                    }
                }
            },
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                    return d.asesor;
                }
            },
            { data: function (d) {
                    return d.coordinador;
                }
            },
            { data: function (d) {
                    return d.gerente;
                }
            },
            {
                data: function (d) {
                    return (d.subdirector === '  ') ? 'SIN ESPECIFICAR' : d.subdirector;
                }
            },
            {
                data: function (d) {
                    return (d.regional === '  ') ? 'SIN ESPECIFICAR' : d.regional;
                }
            },
            {
                data: function (d) {
                    return (d.regional_2 === '  ') ? 'SIN ESPECIFICAR' : d.regional_2;
                }
            },
            { data: function (d) {
                    return d.nombre_lp;
                }
            },
            { data: function (d) {
                    return d.fecha_creacion;
                }
            },
            { data: function (d) {
                    return d.fecha_vencimiento;
                }
            }
        ],
        "ajax": {
            "url": url,
            "dataSrc": "",
            cache: false,
            "type": "POST",
            data: {
                  "typeTransaction": typeTransaction,
                  "beginDate": beginDate,
                  "endDate": endDate,
                  "where": where
            }
        },
        initComplete: function () {
			$('#spiner-loader').addClass('hide');
		},
    })

    $('#prospects-datatable_dir').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

}