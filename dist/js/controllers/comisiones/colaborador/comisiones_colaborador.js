const excluir_column = ['MÁS', ''];

// INICIO Restructura de codigo 
var IdTablas ,
    Array_Datos_Consulta_COMPLETA= new Array, ///contiene toda la data de la bajada
    Array_Datos_Consulta_NUEVAS = new Array, /// CONTIENE TODOS LOS ESTATUS 1
    Array_Datos_Consulta_REVISION = new Array, /// cONTIENE REVISION 4
    Array_Datos_Consulta_OTRAS = new Array, /// CONTIENE ESTATUS 6
    Array_Datos_Consulta_8 = new Array, //Contiene el estatus 8
    nombreTabla = '',
    justificacion_globla = "",
    recibidosOPN = new Array; //Contiene el estatus 8
let contadorDentroFacturas = 0,
    columnas_datatable = {},
    fin = userSede == 8 ? 16 : 13,
    boton_sol_pago = (forma_pago != 2) ? '' : 'hidden',
    pagos = []; //arreglo de pagos  


function asignarValorColumnasDT(nombre_datatable) { 
    if(!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = {titulos_encabezados: [], num_encabezados: []};
    }
    }
$(document).ready(function () {
    nombreTabla = 'tabla_nuevas_comisiones';
    peticionDataTable(nombreTabla)

    opn_cumplimiento();
}); 

    function opn_cumplimiento(){

        $.ajax({
            url: 'opnCumplimiento',
            type: 'post',
            dataType: 'JSON',
            success: function (DatosRecibidos) {

                recibidosOPN.push(DatosRecibidos)
                
                llenadoTextoTabla();
            
            }
        }); 
        
    }

    function llenadoTextoTabla(){
        let cadena
    
        $.ajax({
            url: 'tipoDePago',
            type: 'post',
            dataType: 'JSON',
            success: function (DatosRecibidos) {
                console.log(recibidosOPN[0][0]['estatus'] )

                if( DatosRecibidos.forma_pago  == 2 ){

                    if((recibidosOPN[0].length) == 0){
                        cadena = '<a href="Usuarios/configureProfile"> <span class="label label-danger" style="background:red;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA ></span> </a>';
                    } else
                    {
                        if(recibidosOPN[0][0]['estatus'] == 1){
                            cadena = `<button type="button" class="btn btn-info subir_factura_multiple" >
                                        SUBIR FACTURAS
                                        </button>`;
                        }
                        else if(recibidosOPN[0][0]['estatus'] == 0){
                            cadena =`<a href="Usuarios/configureProfile"> 
                                        <span class="label label-danger" style="background:orange;">  
                                    SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA
                                        </span> 
                                    </a>`;
                        }
                        else if(recibidosOPN[0][0]['estatus'] == 2){
                            cadena = ` <div class="col-lg-2">
                                                <epecial class="epecial btn-info  subir_factura_multiple">
                                                    SUBIR FACTURA
                                                </epecial>
                                        </div>` ;
                            // $cadena = '<div> <button class="button">  Hover Me!</button><span class="backdrop"></span></div>';
                        }
                    }
                } //LLAVE CIERRE 
                    else if (DatosRecibidos.forma_pago == 5) {
                        if(recibidosOPN[0].length == 0){
                            cadena = `<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>`;
                        } else if(recibidosOPN[0][0]['estatus'] == 0) {
                            cadena = `<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>`;
                        } else if (recibidosOPN[0][0]['estatus'] == 1) {
                            cadena = `<p>
                                        <b>Documento fiscal cargado con éxito</b>
                                        <a href="#" class="verPDFExtranjero" title="Documento fiscal" data-usuario="'.$opn_cumplimiento[0]["archivo_name"].'" style="cursor: pointer;">
                                        <u>Ver documento</u></a>
                                        </p>`;
                        } else if(recibidosOPN[0][0]['estatus'] == 2) {
                            cadena = `<p style="color: #02B50C;">Documento fiscal bloqueado, hay comisiones asociadas.</p>`;
                        }
                    }

                // RESPUESTA PARA LLENAR LA VISTA
                document.getElementById("encabezado").innerHTML = cadena;
            }
        }); 

    }

    function llenadoTablaNuevas(nombreTabla,datos ){

        asignarValorColumnasDT(nombreTabla);
        $('#'+nombreTabla +' thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            
            if(IdTablas == 1){
            columnas_datatable.tabla_nuevas_comisiones.titulos_encabezados.push(title);
            columnas_datatable.tabla_nuevas_comisiones.num_encabezados.push(columnas_datatable.tabla_nuevas_comisiones.titulos_encabezados.length-1);
            }else if(IdTablas == 2){
                columnas_datatable.tabla_revision_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_revision_comisiones.num_encabezados.push(columnas_datatable.tabla_revision_comisiones.titulos_encabezados.length-1);
            }else if(dTablas == 3){
                columnas_datatable.tabla_pagadas_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_pagadas_comisiones.num_encabezados.push(columnas_datatable.tabla_pagadas_comisiones.titulos_encabezados.length-1);
            }else if(dTablas == 4){
                columnas_datatable.tabla_otras_comisiones.titulos_encabezados.push(title);
                columnas_datatable.tabla_otras_comisiones.num_encabezados.push(columnas_datatable.tabla_otras_comisiones.titulos_encabezados.length-1);
            }
            
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
                        document.getElementById("myText_nuevas").textContent = formatMoney(total);
                    }
                });
            } else {
                $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)" data-toggle="tooltip_nuevas"  data-placement="top" title="SELECCIONAR"/>`);
            }
        });
    
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
            },{
                text: '<i class="fa fa-paper-plane"></i> SOLICITAR PAGO',
            className: boton_sol_pago,
            action: function () {
                let actual=13;
                if(userSede == 8){
                    actual=15;
                }
                var hoy = new Date(fechaServer);
                var dia = hoy.getDate();
                var mes = hoy.getMonth() + 1;
                var hora = hoy.getHours();

                if(2==2)
                     {
            
                    if ($('input[name="idT[]"]:checked').length > 0) {

                        var data = tabla_nuevas.row().data();

                        if(data.forma_pago != forma_pago){
                            alerts.showNotification("top", "right", "Se detectó un cambio de forma de pago, es necesario cerrar sesión y volver a iniciar.", "warning");
                            return false;
                        }

                        $('#spiner-loader').removeClass('hide');
                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function () {
                            return this.value;
                        }).get();
                        var com2 = new FormData();
                        com2.append("idcomision", idcomision);
                        com2.append("cp", $('#cp').val());
                        $.ajax({
                            url: general_base_url + 'Comisiones/acepto_comisiones_user/',
                            data: com2,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: function (data) {
                                response = JSON.parse(data);
                                if (data == 1) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#totpagarPen").html(formatMoney(0));
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");
                                    tabla_nuevas.ajax.reload();
                                    tabla_revision.ajax.reload();
                                } else if (data == 2) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "ESTÁS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES.", "warning");
                                } else if (data == 3) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "NO HAS INGRESADO TU CÓDIGO POSTAL", "warning");
                                } else if (data == 4) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "NO HAS ACTUALIZADO CORRECTAMENTE TU CÓDIGO POSTAL", "warning");
                                } else if (data == 5) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "NO CUENTAS CON UNA FORMA DE PAGO VÁLIDA", "warning");
                                } else {
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                }
                            },
                            error: function (data) {
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                            }
                        });
                    }
                }
                else {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al siguiente corte", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position:relative; float:right'
            }
            },
            {
                text: '<i class="fas fa-play"></i>',
                className: `btn btn-dt-youtube buttons-youtube`,
                titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de comisiones podrás visualizarlo en el siguiente tutorial',
                action: function (e, dt, button, config) {
                    window.open('https://youtu.be/6tDiInpg2Ao', '_blank');
                }
            }
        ],
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
                    return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
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
                    render: function (d, type, full, meta) {
                        let actual = 13;
                        if(userSede == 8){
                            actual=15;
    
                        }
                        var hoy = new Date();
                        var dia = hoy.getDate();
                        var mes = hoy.getMonth() + 1;
                        var hora = hoy.getHours();
    
                        if(2==2) {
    
                            switch (full.forma_pago) {
                                case '1': //SIN DEFINIR
                                case 1: //SIN DEFINIR
                                case '2': //FACTURA
                                case 2: //FACTURA
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                    break;
                                case '5':
                                case 5:
                                    if (full.fecha_abono && full.estatus == 1) {
                                        const fechaAbono = new Date(full.fecha_abono);
                                        const fechaOpinion = new Date(full.fecha_opinion);
                                        if (fechaAbono.getTime() > fechaOpinion.getTime()) {
                                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                        }
                                    }
                                    return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                                case '3': //ASIMILADOS
                                case 3: //ASIMILADOS
                                case '4': //RD
                                case 4: //RD
                                default:
                                    if (full.id_usuario == 5028 || full.id_usuario == 4773 || full.id_usuario == 5381) {
                                        return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                    } else {
                                        return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                                    }
                                    break;
                            }
                        } else {
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        }
                    },
                }],
                info: false,
                data:datos,
                "type": "POST",
                cache: false,
        
        });
        
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
       
    })
    $(document).on("click", ".proceso2", function () {
        nombreTabla = 'tabla_nuevas_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_REVISION)
        IdTablas = 2;
        
    })
    $(document).on("click", ".preceso3", function () {
        nombreTabla = 'tabla_pagadas_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_OTRAS)
        IdTablas = 3;
    
    })
    $(document).on("click", ".preceso4", function () {
        nombreTabla = 'tabla_otras_comisiones';
        llenadoTablaNuevas(nombreTabla,Array_Datos_Consulta_8)
        IdTablas = 4;

    })
    // $(document).on("click", ".preceso5", function () {
    //     nombreTabla = 'tabla_comisiones_sin_pago';
    //     llenadoTablaNuevas(nombreTabla,datos)
    //     alert(5);
    // })

    $(document).on("click", ".consultar_logs_nuevas", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + lote + '</b></h5></p>');
        $.getJSON("getComments/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">' + v.comentario + '</i><br><b style="color:#39A1C0">' + v.fecha_movimiento + '</b><b style="color:gray;"> - ' + v.nombre_usuario + '</b></p></div>');
            });
        });
    });

   
    
//Fin de RESTRUCTURA 


