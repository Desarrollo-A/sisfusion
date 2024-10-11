
$(document).ready(function() {
    /*primera carga*/
    $("#subDir").empty().selectpicker('refresh');
    $.post('<?= base_url() ?>index.php/Clientes/getSubdirs/', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#subDir").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#subDir").append(`<option selected="selected" disabled>${_("ningun-subdirector")}</option>`);
        }
        $("#subDir").selectpicker('refresh');
    }, 'json');
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({
        locale: 'es'
    });
    setInitialValues();
});

sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function() {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
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

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');        
    $("#beginDate").val(convertDate(beginDate));
    $("#endDate").val(convertDate(endDate));
    // fillTable(1, finalBeginDate, finalEndDate, 0);
}

$(document).on("click", "#searchByDateRange", function() {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    var url_inter;
    if (gerente != undefined && coordinador == undefined && asesor == undefined) {
        url_inter = "<?= base_url() ?>index.php/Clientes/getProspectsListByGerente/" + gerente;
    } else if (gerente != undefined && coordinador != undefined && asesor == undefined) {
        url_inter = "<?= base_url() ?>index.php/Clientes/getProspectsListByCoord/" + coordinador;
    } else if (gerente != undefined && coordinador != undefined && asesor != undefined) {
        url_inter = "<?= base_url() ?>index.php/Clientes/getProspectsListByAsesor/" + asesor;
    }
    updateTable(url_inter, 3, finalBeginDate, finalEndDate, 0);
});

$('#subDir').on('change', function() {
    var subdir = $("#subDir").val();
    //gerente
    $("#gerente").empty().selectpicker('refresh');
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesores").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $('#filter_date').addClass('hide');
    $.post('<?= base_url() ?>index.php/Clientes/getGerentesBySubdir/' + subdir, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#gerente").append(`<option selected="selected" disabled>${_("ningun-gerente")}</option>`);
        }
        $("#gerente").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

var gerente;
var coordinador;
var asesor;

$('#gerente').on('change', function() {
    $('#filter_date').removeClass('hide');
    /**/
    gerente = $("#gerente").val();
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesores").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $.post('<?= base_url() ?>index.php/Clientes/getCoordsByGrs/' + gerente, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinador").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#coordinador").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
        }
        $("#coordinador").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    /**/ //carga tabla
    var url = "<?= base_url() ?>index.php/Clientes/getProspectsListByGerente/" + gerente;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

$('#coordinador').on('change', function() {
    coordinador = $("#coordinador").val();
    $('#filter_date').removeClass('hide');
    //gerente
    $("#asesores").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $.post('<?= base_url() ?>index.php/Clientes/getAsesorByCoords/' + coordinador, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#asesores").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#asesores").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
        }
        $("#asesores").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    /**/ //carga tabla
    var url = "<?= base_url() ?>index.php/Clientes/getProspectsListByCoord/" + coordinador;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

//asesor
$('#asesores').on('change', function() {
    asesor = $("#asesores").val();
    /**/ //carga tabla
    var url = "<?= base_url() ?>index.php/Clientes/getProspectsListByAsesor/" + asesor;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

var prospectsTable;
function updateTable(url, typeTransaction, beginDate, endDate, where) {
    construirHead("prospects-datatable_dir");
    prospectsTable = $('#prospects-datatable_dir').DataTable({
        dom: 'Brt' + "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        "ordering": false,
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: _('descargar-excel'),
            title: _("listado-prospectos"),
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header: function(d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        }],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [{
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                    } else {
                        return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                    }
                }
            },
            {
                data: function(d) {
                    if (d.estatus_particular == 1) { // DESCARTADO
                        b = `<center><span class="label" style="background:#E74C3C" data-i18n="descartado-2">${_("descartado-2")}</span><center>`;
                    } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = `<center><span class="label" style="background:#B7950B" data-i18n="interesado-sin-cita">${_("interesado-sin-cita")}</span><center>`;
                    } else if (d.estatus_particular == 3) { // CON CITA
                        b = `<center><span class="label" style="background:#27AE60" data-i18n="con-cita-2">${_("con-cita-2")}</span><center>`;
                    } else if (d.estatus_particular == 4) { // SIN ESPECIFICAR
                        b = `<center><span class="label" style="background:#5D6D7E" data-i18n="sin-especificar2">${_("sin-especificar2")}</span><center>`;
                    } else if (d.estatus_particular == 5) { // PAUSADO
                        b = `<center><span class="label" style="background:#2E86C1" data-i18n="pausado-2">${_("pausado-2")}</span><center>`;
                    } else if (d.estatus_particular == 6) { // PREVENTA
                        b = `<center><span class="label" style="background:#8A1350" data-i18n="preventa-2">${_("preventa-2")}</span><center>`;
                    }
                    return b;
                }
            },
            {
                data: function(d) {
                    if (d.tipo == 0) {
                        return `<center><span class="label label-danger" style="background: #B7950B" data-i18n="prospecto">${_("prospecto")}</span></center>`;
                    } else {
                        return `<center><span class="label label-danger" style="background: #75DF8F" data-i18n="cliente">${_("cliente")}</span></center>`;
                    }
                }
            },
            {
                data: function(d) {
                    return d.nombre;
                }
            },
            {
                data: function(d) {
                    return d.asesor;
                }
            },
            {
                data: function(d) {
                    return d.coordinador;
                }
            },
            {
                data: function(d) {
                    return d.gerente;
                }
            },
            {
                data: function(d) {
                    return d.nombre_lp;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    return d.fecha_vencimiento;
                }
            },
            {
                data: function(d) {
                    return d.correo;
                }
            },
            {
                data: function(d) {
                    return d.telefono;
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
        }
    })
    applySearch(prospectsTable);
}