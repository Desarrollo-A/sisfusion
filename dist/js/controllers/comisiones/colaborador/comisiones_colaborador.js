const excluir_column = ['MÁS', ''];
let columnas_datatable = {};
let fin = userSede == 8 ? 16 : 13;



// INICIO Restructura de codigo 
var IdTablas ;
var Array_Datos_Consulta_COMPLETA= new Array; ///contiene toda la data de la bajada
var Array_Datos_Consulta_NUEVAS = new Array; /// CONTIENE TODOS LOS ESTATUS 1
var Array_Datos_Consulta_REVISION = new Array; /// cONTIENE REVISION 4
var Array_Datos_Consulta_OTRAS = new Array; /// CONTIENE ESTATUS 6
var Array_Datos_Consulta_8 = new Array; //Contiene el estatus 8
var nombreTabla = ''

function asignarValorColumnasDT(nombre_datatable) { 
    if(!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = {titulos_encabezados: [], num_encabezados: []};
    }
    }
$(document).ready(function () {
    nombreTabla = 'tabla_nuevas_comisiones';
    peticionDataTable(nombreTabla)



   

}); 

    function llenadoTablaNuevas(nombreTabla,datos ){

        asignarValorColumnasDT(nombreTabla);
        $('#'+nombreTabla +' thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            console.log('primer')
            if(IdTablas == 1){
            columnas_datatable.tabla_nuevas_comisiones.titulos_encabezados.push(title);
            columnas_datatable.tabla_nuevas_comisiones.num_encabezados.push(columnas_datatable.tabla_nuevas_comisiones.titulos_encabezados.length-1);
            }else if(dTablas == 2){
                columnas_datatable.tabla_revision_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_revision_comisiones.num_encabezados.push(columnas_datatable.tabla_revision_comisiones.titulos_encabezados.length-1);
            }else if(dTablas == 3){
                columnas_datatable.tabla_pagadas_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_pagadas_comisiones.num_encabezados.push(columnas_datatable.tabla_pagadas_comisiones.titulos_encabezados.length-1);
            }else if(dTablas == 4){
                columnas_datatable.tabla_otras_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_otras_comisiones.num_encabezados.push(columnas_datatable.tabla_otras_comisiones.titulos_encabezados.length-1);
            }
            console.log('2')
            let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
            if (title !== '') {
                $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip_nuevas" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
                $('input', this).on('keyup change', function () {
                    if (tabla_nuevas.column(i).search() !== this.value) {
                        tabla_nuevas.column(i).search(this.value).draw();
                        var total = 0;
                        var index = tabla_nuevas.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_nuevas.rows(index).data();
                        $.each(data, function (i, v) {
                            total += parseFloat(v.pago_cliente);
                        });
                        document.getElementById("myText_nuevas").textContent = '$' + formatMoney(total);
                    }
                });
            } else {
                $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)" data-toggle="tooltip_nuevas"  data-placement="top" title="SELECCIONAR"/>`);
            }
        });
        console.log('5')
        $('#'+nombreTabla).on('xhr.dt', function (e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function (i, v) {
                total += parseFloat(v.pago_cliente);
            });
            var to = formatMoney(total);
            document.getElementById("myText_nuevas").textContent = to;
        });
        $('#spiner-loader').addClass('hide');
        tabla_nuevas = $("#"+nombreTabla).DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            scrollX: true,
            buttons: [{
                extend: 'excelHtml5',
                text: `<i class="fa fa-file-excel-o" aria-hidden="true"></i>`,
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'REPORTE COMISIONES NUEVAS',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + columnas_datatable.tabla_nuevas_comisiones.titulos_encabezados[columnIdx] + ' ';
                        }
                    }
                },
            }],
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            fixedHeader: true,
            destroy: true,
            ordering: false,
            columns: [{
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.id_pago_i + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.proyecto + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0"><b>' + d.lote + '</b></p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de ' + d.porcentaje_abono + '% GENERAL </p>';
                }
            },
            {
                "data": function( d ){
                    var lblPenalizacion = '';
    
                    if (d.penalizacion == 1){
                        lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-vividOrange"> + 90 DÍAS</span></p>';
                    }
    
                    if(d.bonificacion >= 1){
                        p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-darkPink"">BON. $ '+formatMoney(d.bonificacion)+'</span></p>';
                    }
                    else{
                        p1 = '';
                    }
    
                    if(d.lugar_prospeccion == 0){
                        p2 = '<p class="m-0" title="LOTE CON CANCELACIÓN DE CONTRATO"><span class="label lbl-warning">RECISIÓN</span></p>';
                    }
                    else{
                        p2 = '';
                    }
    
                    if(d.id_cliente_reubicacion_2 != 0 ) {
                        p3 = `<p class="${d.colorProcesoCl}">${d.procesoCl}</p>`;
                    }else{
                        p3 = '';
                    }
    
                    return p1 + p2 + lblPenalizacion + p3;
                }
            },
            {
                "data": function (d) {
                    switch (d.forma_pago) {
                        case '1': //SIN DEFINIR
                        case 1: //SIN DEFINIr
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue">
                                            SIN DEFINIR FORMA DE PAGO
                                        </span>
                                    </p>
                                    <p>
                                        <span class="label lbl-green">
                                            REVISAR CON RH
                                        </span>
                                    </p>`.split("\n").join("").split("  ").join("");
                        case '2': //FACTURA
                        case 2: //FACTURA
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue">
                                            FACTURA
                                        </span>
                                    </p>
                                    <p style="font-size: .5em">
                                        <span class="label lbl-green">
                                            SUBIR XML
                                        </span>
                                    </p>`.split("\n").join("").split("  ").join("");
                        case '3': //ASIMILADOS
                        case 3: //ASIMILADOS
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue" >
                                            ASIMILADOS 
                                        </span>
                                    </p>
                                    <p style="font-size: .5em">
                                        <span class="label lbl-green">
                                            LISTA PARA APROBAR
                                        </span>
                                    </p>`.split("\n").join("").split("  ").join("");
                        case '4': //RD
                        case 4: //RD
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue">
                                            REMANENTE DIST.
                                        </span>
                                    </p>
                                    <p style="font-size: .5em">
                                        <span class="label lbl-green">
                                            LISTA PARA APROBAR
                                        </span>
                                    </p>`.split("\n").join("").split("  ").join("");
                        case '5':
                        case 5:
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue">FACTURA EXTRANJERO</span>
                                    </p>
                            `;
                        default:
                            return `<p class="mb-1">
                                        <span class="label lbl-dark-blue">
                                            DOCUMENTACIÓN FALTANTE
                                        </span>
                                    </p>
                                    <p>
                                        <span class="label lbl-green">
                                            REVISAR CON RH
                                        </span>
                                    </p>`.split("\n").join("").split("  ").join("");
                    }
                }
            },
            {
                "orderable": false,
                "data": function (data) {
                    return `<div class="d-flex justify-center">
                                <button href="#" 
                                        value="${data.id_pago_i}"
                                        data-value="${data.lote}"
                                        data-code="${data.cbbtton}"
                                        class="btn-data btn-blueMaderas consultar_logs_nuevas" 
                                        title="DETALLES"
                                        data-toggle="tooltip_nuevas" 
                                        data-placement="top">
                                    <i class="fas fa-info"></i>
                                </button>
                            </div>`;
                }
            }],
            columnDefs: [{
                    visible: false,
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center',
                }],
                info: false,
                data:datos,
                "type": "POST",
                cache: false,
        
        });
        console.log('10')
        // llenadoTablaNuevas(data);
        // Array_Datos_Consulta_COMPLETA.push(data.Datos)
        // llenado(Array_Datos_Consulta_COMPLETA)
    }



    function peticionDataTable(NombreTabla){
        $.ajax({
            url: 'getDatosComisionesAsesor',
            type: 'post',
            dataType: 'JSON',
            success: function (INFORMACION) {

                $('#spiner-loader').removeClass('hide');
                Array_Datos_Consulta_NUEVAS = INFORMACION.filter(pagos => pagos.estatus == 1);
        
                Array_Datos_Consulta_REVISION = INFORMACION.filter(pagos => pagos.estatus == 4);

                Array_Datos_Consulta_OTRAS = INFORMACION.filter(pagos => pagos.estatus == 6);


                Array_Datos_Consulta_8 = INFORMACION.filter(pagos => pagos.estatus == 8);
                IdTablas = 1;
                nombreTabla = 'tabla_nuevas_comisiones';
                llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_NUEVAS)
    
            }
        });
    }


    $(document).on("click", ".nuevas1", function () {
        nombreTabla = 'tabla_nuevas_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_NUEVAS)
        IdTablas = 1;
        alert(1);
    })
    $(document).on("click", ".proceso2", function () {
        nombreTabla = 'tabla_revision_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_REVISION)
        IdTablas = 2;
        alert(2);
    })
    $(document).on("click", ".preceso3", function () {
        nombreTabla = 'tabla_pagadas_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_OTRAS)
        IdTablas = 3;
        alert(3);
    })
    $(document).on("click", ".preceso4", function () {
        nombreTabla = 'tabla_otras_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_8)
        IdTablas = 4;
        alert(4);
    })
    // $(document).on("click", ".preceso5", function () {
    //     nombreTabla = 'tabla_comisiones_sin_pago';
    //     llenadoTablaNuevas(nombreTabla,datos)
    //     alert(5);
    // })
//Fin de RESTRUCTURA 

let anios = [];

$(document).ready(function () {
    $.ajax({
        url: 'getYears',
        type: 'post',
        dataType: 'JSON',
        success: function (anos) 
        {
            for(var i in anos) {
            anios.push(parseInt(anos[i].nombre));
                }

                console.log(anios)
                console.log('anios')
                
        }
    });
})


