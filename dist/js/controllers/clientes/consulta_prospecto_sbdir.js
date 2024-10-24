let titulos_encabezado = [];
let num_colum_encabezado = [];
var typeTransaction = 1;

$('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
    $(this).css('text-align', 'center');
    const title = $(this).text();
    titulos_encabezado.push(title);
    num_colum_encabezado.push(i);
    $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
            $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
        }
    });
});

//Eliminamos la ultima columna "ACCIONES" donde se encuentra un elemento de tipo boton (para omitir en excel o pdf).
num_colum_encabezado.pop();
$(document).ready(function () {

    multirol();

    //gerente

    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
});



function multirol(){
    $.post('../General/multirol', function(data){
        let unique = [...new Set(data.map(item => item.idRol))]; //los roles unicos del usuario
        if(unique.includes(59) || unique.includes(60)){
            createFilters(59);
            getFirstFilter(59, 2);
        }else{
            createFilters(2);
            getFirstFilter(2, 3);
        }
    },'json');
}

function createFilters(rol){
    if(rol == 59){
        let div = `<div class="col-md-3 form-group">
                        <div id="div1" class="form-group label-floating select-is-empty">
                            <label class="control-label">SUBDIRECTOR</label>
                        </div>
                    </div>`;
        div += `<div class="col-md-3 form-group">
                    <div id="div2" class="form-group label-floating select-is-empty">
                        <label class="control-label">GERENTE</label>
                    </div>
                </div>`;
        div += `<div class="col-md-3 form-group">
                    <div id="div3" class="form-group label-floating select-is-empty">
                        <label class="control-label">COORDINADOR</label>
                    </div>
                </div>`;
        div += `<div class="col-md-3 form-group">
                    <div id="div4" class="form-group label-floating select-is-empty">
                        <label class="control-label">ASESOR</label>
                    </div>
                </div>`;
        var $selectSub = 
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'subdirector',
                'name': 'subdirector',
                'data-style':"btn btn-round",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        var $selectGer = 
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'gerente',
                'name': 'gerente',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        var $selectCoord = 
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'coordinador',
                'name': 'coordinador',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        var $selectAse =
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'asesores',
                'name': 'asesores',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        $('#filterContainer').append(div);
        $selectSub.appendTo('#div1').selectpicker('refresh');
        $selectGer.appendTo('#div2').selectpicker('refresh');
        $selectCoord.appendTo('#div3').selectpicker('refresh');
        $selectAse.appendTo('#div4').selectpicker('refresh');
        // $option.appendTo('#asesores');

    }else if(2){ 
        let div =   `<div class="col-md-4 form-group">
                        <div id="div2" class="form-group label-floating select-is-empty">
                            <label class="control-label">GERENTE</label>
                        </div>
                    </div>`;
        div += `<div class="col-md-4 form-group">
                    <div id="div3" class="form-group label-floating select-is-empty">
                        <label class="control-label">COORDINADOR</label>
                    </div>
                </div>`;
        div += `<div class="col-md-4 form-group">
                    <div id="div4" class="form-group label-floating select-is-empty">
                        <label class="control-label">ASESOR</label>
                    </div>
                </div>`;
        
        var $selectGer =
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'gerente',
                'name': 'gerente',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        var $selectCoord =
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'coordinador',
                'name': 'coordinador',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        var $selectAse =
            $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'asesores',
                'name': 'asesores',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true",
                'title':"Selecciona una opción"
            });
        $('#filterContainer').append(div);
        $selectGer.appendTo('#div2').selectpicker('refresh');
        $selectCoord.appendTo('#div3').selectpicker('refresh');
        $selectAse.appendTo('#div4').selectpicker('refresh');
    }
}

function getFirstFilter(rol, secondRol){
    $(`#${rol == 59 ? 'subdirector':'gerente'}`).empty().selectpicker('refresh');
    $.post('../General/getUsersByLeader', {rol: rol, secondRol:secondRol},function(data) {
        var len = data.length;
        // console.log('users', data);
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $(`#${rol == 59 ? 'subdirector':'gerente'}`).append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $(`#${rol == 59 ? 'subdirector':'gerente'}`).append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
        }
        $(`#${rol == 59 ? 'subdirector':'gerente'}`).selectpicker('refresh');
    }, 'json');
}

$(document).on('change', '#subdirector',function () {
    var subdirector = $("#subdirector").val();
    $("#gerente").empty().selectpicker('refresh');
    $("#coordinador").empty().selectpicker('refresh');
   
   
    $("#coordinador").selectpicker('refresh');
    $("#asesores").selectpicker('refresh');

    $.post(general_base_url + 'index.php/Clientes/getGrsBySub/' + subdirector, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#gerente").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
        }
        $("#gerente").selectpicker('refresh');
    }, 'json');

    /**/ //carga tabla
    var url =general_base_url + 'index.php/Clientes/getProspectsListBySubdirector/' + subdirector;
    /*console.log("TypeTRans: " + typeTransaction);
    updateTable(url, typeTransaction);*/
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0)
});


$(document).on('change','#gerente', function () {

    /**/var gerente = $("#gerente").val();

    $("#coordinador").empty().selectpicker('refresh');
    $("#asesores").empty().selectpicker('refresh');
   
    $("#asesores").selectpicker('refresh');

    $.post(general_base_url + 'index.php/Clientes/getCoordsByGrs/' + gerente, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinador").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#coordinador").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
        }
        $("#coordinador").selectpicker('refresh');
    }, 'json');



    /**///carga tabla
    var url = general_base_url + 'index.php/Clientes/getProspectsListByGerente/' + gerente;
    /*console.log("TypeTRans: " + typeTransaction);
    updateTable(url, typeTransaction);*/
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0)
});

$(document).on('change', '#coordinador', function () {
    var coordinador = $("#coordinador").val();

    //gerente
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
            $("#asesores").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
        }
        $("#asesores").selectpicker('refresh');
    }, 'json');


    /**///carga tabla
    var url = general_base_url + 'index.php/Clientes/getProspectsListByCoord/'+coordinador;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0)
    // updateTable(url, typeTransaction);
});

//asesor
$(document).on('change', '#asesores',function () {
    var asesor = $("#asesores").val();

    /**///carga tabla
    var url = general_base_url + 'index.php/Clientes/getProspectsListByAsesor/' +asesor;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0)
    // updateTable(url, typeTransaction);
});



$(document).on("click", "#searchByDateRange", function () {
    var url_interno;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    var gerente = $("#gerente").val();
    var coordinador = $("#coordinador").val();
    var asesor = $("#asesores").val();

    if(gerente != '' && coordinador == '' && asesor==''){
        url_interno = general_base_url + 'index.php/Clientes/getProspectsListByGerente/' + gerente;
    }else if(gerente != '' && coordinador != '' && asesor == ''){
        url_interno = general_base_url + 'index.php/Clientes/getProspectsListByCoord/' + coordinador;
    }else if(gerente != '' && coordinador != '' && asesor != ''){
        url_interno = general_base_url + 'index.php/Clientes/getProspectsListByAsesor/' + asesor;
    }
    // console.log(url_interno);
    updateTable(url_interno, 3, finalBeginDate, finalEndDate, 0);/**/
});


function updateTable(url, typeTransaction, beginDate, endDate, where)
{
    var prospectsTable = $('#prospects-datatable_dir').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado general de prospectos',
            title:"Listado general de prospectos",
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado[columnIdx] +' ';
                    }
                }
            }
        }],
        language: {
            url: general_base_url + 'static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        columns: [
            { data: function (d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-green">Vigente</span><center>';
                } else {
                    return '<center><span class="label lbl-veryDarkRed">Sin vigencia</span><center>';
                }
            }
            },
            {
                data: function (d) {
                    if(d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label lbl-warning">Descartado</span><center>';
                    } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label lbl-brown">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3){ // CON CITA
                        b = '<center><span class="label lbl-darkCyan">Con cita</span><center>';
                    } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                        b = '<center><span class="label lbl-purple">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5){ // PAUSADO
                        b = '<center><span class="label lbl-violetBoots">Pausado</span><center>';
                    } else if (d.estatus_particular == 6){ // PREVENTA
                        b = '<center><span class="label lbl-azure">Preventa</span><center>';
                    } else if (d.estatus_particular == 7){ // CLIENTE
                        b = '<span class="label lbl-green">Cliente</span>';
                    }else{ // CLIENTE
                        b = '<span class="label lbl-gray">Sin especificar</span>';
                    }
                    return b;
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
                    if(id_rol_general == 2 || id_rol_general == 5){
                        if(id_rol_general != 7 && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                            return '';
                        } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                            return `<center>
                                        <button class="btn-data btn-blueMaderas see-information" 
                                                data-id-prospecto="${d.id_prospecto}"
                                                style="margin-right: 3px;"
                                                data-toggle="tooltip" 
                                                data-placement="top"
                                                title="Ver información">
                                            <i class="material-icons">
                                                remove_red_eye
                                            </i>
                                        </button>
                                    </center>`;
                        }
                    }
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
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}


sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
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
    // console.log('Fecha inicio: ', finalBeginDate);
    // console.log('Fecha final: ', finalEndDate);
    $("#beginDate").val(convertDate(beginDate));
    $("#endDate").val(convertDate(endDate));
    // fillTable(1, finalBeginDate, finalEndDate, 0);
}

function compareDates(fecha_creacion){
    let date1 = new Date(fecha_creacion);
    let date2 = new Date('2022-01-01');
    var isBefore = moment(fecha_creacion).isBefore('2022-01-20T00:00:00Z');
    return isBefore;
}