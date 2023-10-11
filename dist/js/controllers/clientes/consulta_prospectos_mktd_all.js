let titulos_intxt = [];
$('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
            $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function(){
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
});

sp = {
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

$("#subDir").empty().selectpicker('refresh');
$.post(general_base_url + 'index.php/Clientes/getSubdirs/', function(data) {
    var len = data.length;
    for( var i = 0; i<len; i++){
        var id = data[i]['id_usuario'];
        var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
        $("#subDir").append($('<option>').val(id).text(name));
    }
    if(len<=0){
        $("#subDir").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
    }
    $("#subDir").selectpicker('refresh');
}, 'json');

$("#lugar_p").empty().selectpicker('refresh');
$.post(general_base_url + 'index.php/Clientes/getProspectingPlaces/', function(data) {
    $("#lugar_p").append('<option value="0">Todos</option>');
    var len = data.length;
    for(var i = 0; i<len; i++){
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#lugar_p").append($('<option>').val(id).text(name));
    }
    if(len<=0){
        $("#lugar_p").append('<option selected="selected" disabled>NINGÚN LUGAR</option>');
    }
    $("#lugar_p").selectpicker('refresh');
}, 'json');


$("#gerente").empty().selectpicker('refresh');
$.post(general_base_url + 'index.php/Clientes/getGerentesAll/', function(data) {
    var len = data.length;
    for( var i = 0; i<len; i++){
        var id = data[i]['id_usuario'];
        var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
        $("#gerente").append($('<option>').val(id).text(name));
    }
    if(len<=0){
        $("#gerente").append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
    }
    $("#gerente").selectpicker('refresh');
}, 'json');


$('#subDir').on('change', function () {
    var subdir = $("#subDir").val();
    $("#gerente").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + 'index.php/Clientes/getGerentesBySubdir/'+subdir, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#gerente").append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
        }
        $("#gerente").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#gerente').on('change', function () {
    var gerente = $("#gerente").val();
    $("#coordinador").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + 'index.php/Clientes/getCoordsByGrs/'+gerente, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinador").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#coordinador").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
        }
        $("#coordinador").selectpicker('refresh');
    }, 'json');
    var lugar_p = $("#lugar_p").val();
    var subDir = $("#subDir").val();
    $('#spiner-loader').addClass('hide');
    if(lugar_p != '' && gerente != ''){
        var url = general_base_url + "index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    } else {
        var url = general_base_url + "index.php/Clientes/getProspectsListByGteAll/"+gerente;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    }
    $("#prospects-datatable_dir").removeClass('hide');
});


$('#coordinador').on('change', function () {
    var coordinador = $("#coordinador").val();
    $("#asesor").empty().selectpicker('refresh');
    $.post(general_base_url + 'index.php/Clientes/getAsesorByCoords/'+coordinador, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#asesor").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#asesor").append('<option selected="selected" disabled>NINGÚN ASESOR</option>');
        }
        $("#asesor").selectpicker('refresh');
    }, 'json');
    var gerente = $("#gerente").val();
    var lugar_p = $("#lugar_p").val();
    var subDir = $("#subDir").val();
    if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
        var url = general_base_url +  "index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    } else {
        var url = general_base_url + "index.php/Clientes/getProspectsListByCoordByGte/"+gerente+"/"+coordinador;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    }
});

$('#asesor').on('change', function () {
    var gerente = $("#gerente").val();
    var coordinador = $("#coordinador").val();
    var asesor = $("#asesor").val();
    var lugar_p = $("#lugar_p").val();
    var subDir = $("#subDir").val();
    if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
        var url = general_base_url + "index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    } else {
        var url = general_base_url + "index.php/Clientes/getProspectsListByAsByCoord/"+gerente+"/"+coordinador+"/"+asesor;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    }
});

$('#lugar_p').on('change', function () {
    var lugar_p = $("#lugar_p").val();
    var subDir = $("#subDir").val();
    var gerente = $("#gerente").val();
    var coordinador = $("#coordinador").val();
    var asesor = $("#asesor").val();
    if(lugar_p != '' && gerente != ''){
        var url = general_base_url + "index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
        var url = general_base_url + "index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
        var url = general_base_url + "index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    }
});

$(document).on("click", "#searchByDateRange", function () {
    var lugar_p = $("#lugar_p").val();
    var subDir = $("#subDir").val();
    var gerente = $("#gerente").val();
    var coordinador = $("#coordinador").val();
    var asesor = $("#asesor").val();
    var url;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    if(subDir!='' || gerente != '' && coordinador=='' && asesor=='' && lugar_p==''){
        url = general_base_url + "index.php/Clientes/getProspectsListByGteAll/"+gerente;
    }else if(subDir=='' && gerente != '' && coordinador=='' && asesor=='' || lugar_p!=''){
        url = general_base_url + "index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
    }else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor==''){
        url = general_base_url + "index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
    } else if(subDir!='' || gerente != '' && coordinador!='' && asesor=='' && lugar_p==''){
        url = general_base_url + "index.php/Clientes/getProspectsListByCoordByGte/"+gerente+"/"+coordinador;
    }else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
        url = general_base_url + "index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
    } else if(subDir!='' || gerente != '' && coordinador!='' && asesor!='' && lugar_p==''){
        url = general_base_url + "index.php/Clientes/getProspectsListByAsByCoord/"+gerente+"/"+coordinador+"/"+asesor;
    }
    updateTable(url, 3, finalBeginDate, finalEndDate, 0);
});

function updateTable(url, typeTransaction, beginDate, endDate, where){
    var prospectsTable = $('#prospects-datatable_dir').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title: 'CRM_LISTA_PROSPECTOS',
                titleAttr: 'CRM_LISTA_PROSPECTOS',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    format:     
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ordering: false,
        destroy: true,
        columns: [
            { data: function (d) {
                    return d.id_prospecto;
                }
            },
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                    return d.apellido_paterno;
                }
            },
            { data: function (d) {
                    return d.apellido_materno;
                }
            },
            { data: function (d) {
                    return d.correo;
                }
            },
            { data: function (d) {
                    return d.telefono;
                }
            },
            { data: function (d) {
                    return d.lp;
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
                    return d.fecha_creacion.split('.')[0];
                }
            }
        ],
        "ajax": {
            "url": url,
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    })
    $('#prospects-datatable_dir').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

