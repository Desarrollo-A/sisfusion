let contInicio = 0, contReporte = 0

$(document).ready(function(){
    repoVtas();

});
function repoVtas(){
    initRepoVtas();
}
async function initRepoVtas(){
    let rol = userType == 2 ? await getRolDR(idUser): userType;
    let rolString;
    if ( rol == '1' || rol == '18' || rol == '4')
        rolString = 'director_regional';
    else if ( rol == '2' || (rol == '5' && ( idUser != '28' || idUser != '30' )))
        rolString = 'gerente';
    else if ( rol == '3' || rol == '6' )
        rolString = 'coordinador';
    else if ( rol == '59' || (rol == '5' && ( idUser == '28' || idUser == '30' )))
        rolString = 'subdirector';
    else 
        rolString = 'asesor';
    fillBoxAccordions(rolString, rol == 18 || rol == '18' ? 1 : rol, idUser, 1, 1, null, [0, null, null, null, null, null, rol]);
}

function fillBoxAccordions(option, rol, id_usuario, render, transaction, dates=null, leadersList){
    if( rol == 5 && (idUser == 28 && idUser == 30) )
        rolEspecial = 59;
    else if( rol == 5 && (idUser != 28 && idUser != 30) )
        rolEspecial = 2;
    else if( rol == 6 )
        rolEspecial = 3;
    else if( rol == 4 )
        rolEspecial = 2
    else rolEspecial = rol;
    createAccordions(option, render, rolEspecial);
    let newRol = newRoles(option);
    $(".js-accordion-title").addClass('open');
    $(".accordion-content").css("display", "block");
    if(render == 1){
        $("#chartButton").data('option', option);
    }

    $('#table'+option+' thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" class="w-100 textoshead"  placeholder="' + title + '"/>');
    });
    
    $('#table'+option).DataTable({
        destroy: true,
        ajax: {
            url: 'getInfRepoVta',
            dataSrc: "",
            type: "POST",
            cache: false
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: 'auto',
        ordering: false,
        pagingType: "full_numbers",
        scrollX: true,
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 1:
                                    return 'ID '+option;
                                    break;
                                case 2:
                                    return 'NOMBRE DE '+ option;
                                    break;
                                case 3:
                                    return 'FECHA CREACION';
                                    break;
                                case 4:
                                    return 'NUM LOTES';
                                    break;
                                case 5:
                                    return 'TOTAL DE VENTAS';
                                    break;
                                case 6:
                                    return 'PERIODO';
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            {
                with: "20%",
                data: function (d){
                    return d.id_asesor;
                }
            },
            {
                with: "30%",
                data: function (d){
                    return d.nombre_asesor;
                }
            },
            {
                with: "30%",
                data: function (d){
                    return d.fecha_creacion;
                }
            },
            {
                with: "30%",
                data: function (d){
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="5" data-idUser="${d.id_asesor}" class="btnModalDetails">${d.num_lotes}</button>`;
                }
            },
            {
                with: "30%",
                data: function (d){
                    return d.total_ventas_lotes;
                }
            },
            {
                with: "20%",
                data: function (d){
                    return d.periodo;
                }
            }
        ]
    });
}

function createAccordions(option, render, rol){
    let tittle = "En la presente vista se podrá visualizar un reporte de ventas agrupadas por periodo y asesor."
    let html = '';
    html = `<div data-rol="${rol}" class="bk ${render == 1 ? 'parentTable': 'childTable'}">
                <div class="d-flex justify-between align-center">   
                    <div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div>
                        <h4 class="p-0 accordion-title js-accordion-title center-align">`+tittle+`</h4>
                    </div>
                    <div>
                        ${render == 1 ? '': '<i class="fas fa-times deleteTable"></i>'}
                    </div>
                </div>
            <div class="accordion-content">
                <table class="table-striped table-hover" id="table`+option+`" name="table`+option+`">
                    <thead>
                        <tr>
                            <th>ID `+option.toUpperCase()+`</th>
                            <th class="encabezado">NOMBRE DE `+option.toUpperCase()+`</th>
                            <th>FECHA CREACION</th>
                            <th>NUM LOTES</th>
                            <th>TOTAL DE VENTAS</th>
                            <th>PERIODO</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>`;

    $(".boxAccordionsVtas").append(html);
}

function newRoles(option) {
    var rol;
    switch (option) {
        case 'director_regional':
            rol = 59;
            break;
        case 'gerente':
            rol = 3;
            break;
        case 'coordinador':
            rol = 9;
            break;
        case 'subdirector':
            rol = 2;
            break;
        case 'asesor':
            rol = 7;
            break;
        default:
            rol = 'N/A';
    }
    return rol;
}

// 0: Lo que ve a setear
// 1:  Asesor
// 2: Corrdinador
// 3: Gerente
// 4: Subirector
// 5: Director regional
// 6: Rol
function getLeadersLine (leadersList, id_usuario, id_lider) {  
    if (leadersList[0] == 0 && (leadersList[6] == 1 || leadersList[6] == 4)){ // PRIMER NIVEL: SÓLO TENEMOS EL ID REGIONAL
        leadersList[5] = id_usuario;
    }
    else if (leadersList[0] == 2){ // SEGUNDO NIVEL: TENEMOS EL ID SUBDIRECTOR
        leadersList[4] = id_usuario;
    }
    else if (leadersList[0] == 3){ // TERCER NIVEL: TENEMOS EL ID GERENTE
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 9){ // CUARTO NIVEL: TENEMOS EL ID COORDINADOR
        leadersList[2] = id_usuario;
    }
    else if (leadersList[0] == 7){ // 5 NIVEL: TENEMOS EL ID COORDINADOR
        leadersList[1] = id_usuario;
    }
    else if (leadersList[0] == 0 && (leadersList[6] == 59 || (leadersList[6] == 5 && (idUser == 28 || idUser == 30)))) { // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        if(id_usuario == 3 || id_usuario == 607)
            leadersList[5] = 0;
        else
            leadersList[5] = leadersList[6] == 59 ? id_lider : idLider;
        leadersList[4] = id_usuario;
    }
    else if (leadersList[6] == 5 && (idUser != 28 || idUser != 30)) { 
        // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        if( idLider == 7092 )
            leadersList[5] = 3;
        else if ( idLider == 681 || idLider == 9471 )
            leadersList[5] = 607;
        else leadersList[5] = 0;

        leadersList[4] = idLider;
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 2 ) {
        leadersList[5] = ( idLider == 3 || idLider == 607 ) ? idLider : 0;
        leadersList[4] = id_lider;
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 3 ) { // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        leadersList[5] = 0;
        leadersList[4] = 0;
        leadersList[3] = id_lider;
        leadersList[2] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 6  ){
        //Asistente de gerente
        leadersList[5] = 0;
        leadersList[4] = 0;
        leadersList[3] = idLider;
        leadersList[2] = id_usuario;
    }
    return leadersList;
}

$(document).off('click', '.js-accordion-title').on('click', '.js-accordion-title', function () {
    $(this).parent().parent().next().slideToggle(200);
    $(this).toggleClass('open', 200);
});

$(document).on('click', '.deleteTable', function () {
    accordionToRemove($(this).parent().parent().parent().data( "rol" ));
});

$(document).on('click', '.btnModalDetails', function () {
    let dataObject = {
        user: $(this).data("iduser")
    }
    //console.log(dataObject);
    fillTableReport(dataObject);
    $("#seeInfoModalRepoVtas").modal();
});

function fillTableReport(dataObject) {
    $('#lotesInfoTableVtas thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" class="w-100 textoshead"  placeholder="' + title + '"/>');
    });
    $("#lotesInfoTableVtas").DataTable({
        destroy: true,
        ajax: {
            url: 'getInfDetVta',
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "user": dataObject.user
            }
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "auto",
        ordering: false,
        pagingType: "full_numbers",
        scrollX: true,
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'Proyecto';
                                    break;
                                case 1:
                                    return 'Condominio';
                                    break;
                                case 2:
                                    return 'Lote'
                                    break;
                                case 3:
                                    return 'ID Lote';
                                    break;
                                case 4:
                                    return 'Total de Lote';
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        columns: [
           {data: "proyecto"},
           {data: "condominio"},
           {data: "nombreLote"},
           {data: "idLote"},
           {data: "total_lotes"}
        ]
    });
}