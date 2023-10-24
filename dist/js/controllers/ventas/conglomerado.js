
$(document).ready(function () {

    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    }); 
    checkTypeOfDesc();
    setIniDatesXMonth("#fechaIncial", "#endDate");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    // general();
});

let titulos_intxt = [];
$('#tabla-general thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla-general').DataTable().column(i).search() !== this.value ) {
            $('#tabla-general').DataTable().column(i).search(this.value).draw();
        }
    });
});

function checkTypeOfDesc() {
    const tipoDescuento = $('#tipo_descuento').val();
    loadTable(tipoDescuento);
}

function loadTable(tipoDescuento) {
    $('#tabla-general').ready(function () {

        $('#tabla-general').on('xhr.dt', function (e, settings, json, xhr) {
            var general = 0;
            var recaudado = 0;
            var caja = 0;
            var pendiente = 0;

            $.each(json.data, function (i, v) {
                general += parseFloat(v.monto);
                recaudado += parseFloat(v.total_descontado);
                caja += parseFloat(v.pagado_caja);
             });

             pendiente = (general-recaudado-caja);

             var totalFinal = formatMoney(general);
             var recaudadoFinal = formatMoney(recaudado);
             var cajaFinal = formatMoney(caja);
             var pendienteFinal = formatMoney(pendiente);



            document.getElementById("totalGeneral").textContent = '$' + totalFinal;
            document.getElementById("totalRecaudado").textContent = '$' + recaudadoFinal;
            document.getElementById("totalPagadoCaja").textContent = '$' + cajaFinal;
            document.getElementById("totalPendiente").textContent = '$' + pendienteFinal;
        });

        tablaGeneral = $('#tabla-general').DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons:[
            {
                text: '<i class="fa fa-edit" id="btn-nuevo-descuento"></i> NUEVO DESCUENTO',
                action: function () {
                   
                        open_Mb();
             
                },
                attr: {
                    class: ' btn-azure'
                }
            },
            {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Descuentos Universidad',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        },
        
        ],
       
        ordering: false,
        destroy: true,
        pageLength: 10,
        bAutoWidth: false,
        fixedColumns: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        columns:[
                {
                    // ID
                    "data": function (d) {
                        return `<p style="font-size: 1em;">${d.id_usuario}</p>`;
                    }
                },
                {
                    // Usuario
                    "data": function (d) {
                        return `<p style="font-size: 1em;">${d.nombre}</p>`;
                    }
                },
                {
                    // Puesto
                    "data": function (d) {
                        return `<p style="font-size: 1em;">${d.puesto}</p>`;
                    }
                },
                {
                    // Sede
                    "data": function (d) {
                        return `<p style="font-size: 1em;">${d.sede}</p>`;
                    }
                },
                {
                    // Saldo comisiones
                    "data": function (d) {
                        if (d.saldo_comisiones < 12500) {
                            color = 'color:gray';
                        } else{
                            color = 'color:blue';
                        }
                        return `<p style="font-size: 1em; ${color}">$${formatMoney(d.saldo_comisiones)}</p>`;
                    }
                },
                {
                    // Descuento
                    "data": function (d) {
                        return `<p style="font-size: 1em"><b>$${formatMoney(d.monto)}</b></p>`;
                    }
                },
                {
                    // Aplicado
                    "data": function (d) {
                        descontado = 0;
                        if (d.total_descontado == null || d.total_descontado <= 1) {
                            descontado = d.pagado_caja;
                        } else {
                            descontado = d.total_descontado;
                        }
                        return `<p style="font-size: 1em">$${formatMoney(descontado)}</p>`;

                    }
                },
                {
                    // Pa general
                    "data": function (d) {
                        return `<p style="font-size: 1em; color:gray">$${formatMoney(d.pagado_caja)}</p>`;
                    }
                },
                {
                    // Pendiente general
                    "data": function (d) {
                        return `<p style="font-size: 1em; color:gray">$${formatMoney(d.pendiente)}</p>`;
                    }
                },
                {
                    // Pago mensual
                    
                    "data": function (d) {
                        return `<p style="font-size: 1em">$${formatMoney(d.pago_individual)}</p>`;
                    }
                    
                },
                {
                    // Estatus
                    "data": function (d) {
                        reactivado = '';
                        valor = '';

                        if(d.estatus == 5){
                            reactivado = `<span class="label lbl-vividOrange">REACTIVADO ${(d.fecha_modificacion)}</span>`;
                        }
                        if(d.estado_usuario != 1){
                            reactivado = `<span class="label lbl-warning">USUARIO BAJA</span>`;
                        }

                        if (d.saldo_comisiones < 12500 && d.estatus != 5 && d.estatus != 2 && d.estatus != 3 && d.estatus != 4) {
                            valor = '<span class="label lbl-gray">SIN SALDO</span>';
                        } else if (d.estatus == 1 || d.banderaReactivado == 1 ) {
                            valor = '<span class="label lbl-violetChin">DISPONIBLE</span>';
                        } else if (d.estatus == 2) {
                            valor = '<span class="label lbl-blueMaderas">DESCUENTO APLICADO</span>';
                        } else if (d.estatus == 3) {
                            valor = '<span class="label lbl-warning">Detenido</span>';
                        } else if (d.estatus == 4) {
                            valor = '<span class="label lbl-green">LIQUIDADO</span>';
                        } else{
                            valor = '';
                        }
                        
                        return valor+reactivado;
                    }
                },
                // {
                //     // Pendiente mes
                //     "data": function (d) {
                //         const OK = parseFloat(d.pago_individual * d.pagos_activos);
                //         const OP = parseFloat(d.monto - d.aply);

                //         if (OK > OP) {
                //             OP2 = OP;
                //         } else {
                //             OP2 = OK;
                //         }

                //         if (OP2 < 1) {
                //             return `<p style="font-size: 1em; color:gray">$${formatMoney(0)}</p>`;
                //         }
                //         return `<p   tyle="font-size: 1em; color:red"><b>$${formatMoney(OP2)}</b></p>`;
                //     }
                // },
                {
                    // Disponible desc NUEVA OPERACION
                    "data": function (d) {
                        pagosDescontar = 0;
                        color = '';
                        valor = 0;
                        pendiente = 0;

                        if (d.saldo_comisiones >= 12500 && (d.estatus == 1 || d.banderaReactivado == 1) && d.pendiente > 1) {//TODAS SEDES
                            color = 'color:purple';
                            valor = Math.round(d.saldo_comisiones/12500);
                            pendiente = Math.round(d.pendiente/d.pago_individual);
                            pagosDescontar = valor>pendiente ? d.pendiente : valor*d.pago_individual;
                        }

                        return `<p style="font-size: 1em; ${color}">$${formatMoney(pagosDescontar)}</p>`;

                    }
                },
                {
                    // Fecha primer descuento
                    "data": function (d) {
                        return `<p style="font-size: 1em">${(d.primer_descuento) ? d.primer_descuento : 'SIN APLICAR'}</p>`;
                    }
                },
                {
                    // Fecha creación
                    "data": function (d) {

                        return '<p style="font-size: 1em">' + d.fecha_modificacion + '</p>';
                    }
                },
                {
                    "data": function (d) {

                        if(d.certificacion == 0){
                            return '<p style="font-size: 1em;">SIN ESTATUS</p>';

                        }else{
                            return `<span class='label lbl-${(d.colorCertificacion)}'>${(d.certificacion)}</span>`;

                            
                          }
                    }
                },
                {
                        // Acciones
                        "data": function (d) {

                            adicionales = '';

                            if(d.total_descontado > 1){//MIENTRAS TENGA SALDO APLICADO PODRA CONSULTAR LA INFO
                                base = '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_descuentos" title="Detalles">' + '<i class="fas fa-info-circle"></i></button>'+ 
                                '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-green consultar_fecha_pagos" title="Historial pagos">' + '<i class="fas fa-file"></i></button>';
                            } else{
                                base = '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-green consultar_fecha_pagos" title="Historial pagos">' + '<i class="fas fa-file"></i></button>';
                            }

                            if (d.saldo_comisiones >= 12500 && (d.estatus == 1 || d.banderaReactivado == 1) && d.pendiente > 1 && d.estado_usuario == 1) {//TODAS SEDES
                                valor = Math.round(d.saldo_comisiones/12500);
                                pendiente = Math.round(d.pendiente/d.pago_individual);
                                pagosDescontar = valor>pendiente ? d.pendiente : valor*d.pago_individual;
                                    
                                adicionales = `<button href="#" 
                                value="${d.id_usuario}" 
                                data-value="${pagosDescontar}"
                                data-saldoComisiones="${d.saldo_comisiones}"
                                data-nombre="${d.nombre}" 
                                data-code="${d.cbbtton}"
                                class="btn-data btn-violetDeep aplicarDescuentoMensual" title="Aplicar descuento"><i class="fas fa-plus"></i>
                                </button>
                                
                                <button href="#" 
                                value="${d.id_usuario}"
                                data-nombre="${d.nombre}"
                                data-rol="${d.puesto}"
                                data-totalDescuento="${d.monto}"
                                data-abonado="${d.total_descontado+d.pagado_caja}"
                                class="btn-data btn-orangeYellow topar_descuentos" title="Detener descuentos"><i class="fas fa-ban"></i>
                                </button>
                            `;

                            // <button value="${d.id_usuario}"
                            // data-code="${d.id_usuario}"
                            // data-nombre="${d.nombre}"
                            // data-value="${d.id_descuento}"
                            // data-code="${d.id_usuario}"
                            // data-descuento="${d.monto}"
                            // data-mensual="${d.pago_individual}"
                            // data-pendiente="${d.pendiente}"
                            // data-total="${d.monto}"
                            // data-idCertificacion="${valor}"
                            // class="btn-data btn-acidGreen uniAdd" title="Editar suficiente"><i class="fas fa-money-check-alt"></i>
                            // </button>

                            } else if(d.estatus == 3 && d.pendiente > 1 ){ //DESCUENTOS DETENIDOS ESTATUS 3
                                adicionales = `<button value="${d.id_usuario}" 
                                data-value="${d.id_descuento}"
                                data-pendiente="${d.pendiente}"
                                class="btn-data btn-violetDeep activar-prestamo" title="Activar"> <i class="fa fa-rotate-left"></i> 
                                </button>`;
                            }
                            
                            return '<div class="d-flex justify-center">'+base+adicionales+'</div>';
                               
                        }
                    }],
                    
            "ajax": {
                "url": `getDataConglomerado/`+tipoDescuento,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });


        // $(document).on("click", ".editar_descuentos", function () {
        //     $("#editDescuento").modal();
        //     document.getElementById("fechaIncial").value = ' ';
        //     document.getElementById("descuento1").value = '';
        //     id_descuento = $(this).attr("data-value");
        //     id_user = $(this).attr("data-code");
        //     pago_mensual = $(this).attr("data-mensual");
        //     descuento = $(this).attr("data-descuento");
        //     pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
        //     total = $(this).attr("data-total"); //dinero que ha pagado al momento
        //     descuento = Math.round(descuento);
        //     pago_mensual = Math.round(pago_mensual);
        //     cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos
        //     document.getElementById("pagado").value = total;
        //     document.getElementById("mensualidad").value = pago_mensual;
        //     document.getElementById("descuento_id").value = id_descuento;
        //     document.getElementById("total_pagos").value = cantidad_de_pagos;
        //     valor = 0;
        //     valor1 = 0;
       
        //     mensualidadesFaltantes = descuento / pago_mensual ;
        //     mensualidadesFaltantesMostrar = pendiente / pago_mensual ;
           
        //     document.getElementById("descuento1").value = descuento;
            
        //     if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

        //     }else{
        //         if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
        //         {
        //             if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
        //             {
                     
        //                 mensualidadesFaltantesMostrar = 1;
        //             }else{
                     
        //             }
           
        //         }else{
        //             mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
        //         }
        //        // mensualidadesFaltantes
        //     }
        //     if ((mensualidadesFaltantes % 1)  == 0 ){

        //     }else{
        //         if( 0 == Math.trunc(mensualidadesFaltantes))
        //         {
        //             if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
        //             {
        //                 mensualidadesFaltantes = 1;
        //             }else{
        //             }
        //         }else{
        //                 mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
        //         }
        //        // mensualidadesFaltantes
        //     }
         
        //     document.getElementById("numeroPagos1").value = Math.trunc( mensualidadesFaltantesMostrar);
        
        //     Total_a_pagar = mensualidadesFaltantes * pago_mensual;
            
            
        //     sobrante = Total_a_pagar - total;
        //     //para agregar llo que ya se pago
        //     NuevasMensualidades = sobrante  / mensualidadesFaltantes;

        //     document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);

        //     //faltantes = mensualidadesFaltantes/mensual;
            
        // });



        // $('#numeroPagos1').change(function () {
        //     total_pagos = document.getElementById("total_pagos").value ;
        //     actualess = document.getElementById("actualess").value ;
        //     totalmeses = document.getElementById("totalmeses").value ;
        //     cuanto = document.getElementById("cuanto").value ;
        //     mensualidad = document.getElementById("mensualidad").value ;
        //     pagado = document.getElementById("pagado").value ;  // lo que se ya se ha pagado
        //     loQueSedebe  = document.getElementById("descuento1").value ;
        //     pagos  = document.getElementById("numeroPagos1").value ;
        //     loQueSedebe = loQueSedebe - pagado;
        //     NuevasMensualidades = loQueSedebe / pagos;

            

            
        //     document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);
            

        
        // });

        // $(document).on('input', '.descuento1', function(){
        //     total_pagos = document.getElementById("total_pagos").value ;
        //     actualess = document.getElementById("actualess").value ;
        //     totalmeses = document.getElementById("totalmeses").value ;
        //     cuanto = document.getElementById("cuanto").value ;
        //     mensualidad = document.getElementById("mensualidad").value ;
        //     pagado = document.getElementById("pagado").value ;  // lo que se ya se ha pagado
        //     loQueSedebe  = document.getElementById("descuento1").value ;
        //     pagos  = document.getElementById("numeroPagos1").value ;

        //     loQueSedebe = loQueSedebe - pagado;
        //     NuevasMensualidades = loQueSedebe / pagos;
        //     document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);
            

          
        // });
     
     
        // $(document).on("click", ".updateDescuento", function () {
        //     document.getElementById('updateDescuento').disabled = true;
        //     let validation = true;
        //    mensualidades = document.getElementById("pago_ind011").value;
            
        //    pago = document.getElementById("descuento1").value ;
          
        //     if (mensualidades == '' ) 
        //     {
        //         validation = false;
        //     }
        //     if (pago == ''){
        //         validation = false;
        //     }
       
        //     id_descuento = document.getElementById("descuento_id").value; 
        //     if (validation ){
        //         $.ajax({
        //             url : 'UpdateDescuent',
        //             type : 'POST',
        //             data: {
        //             "id_descuento"      : id_descuento,
        //             "monto"             : pago,
        //             "pago_individual"   : mensualidades,
                 
        //               }, 
        //             success : response => {
        //                 document.getElementById('updateDescuento').disabled = false;
        //                 alerts.showNotification("top", "right", "Descuento actualizado satisfactoriamente.", "success");
                     
        //                 $('#editDescuento').modal('toggle');
        //             },
        //             error : (a, b, c) => {
        //                 alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
        //             }
           
        //         });
        //     }else {
        //         alerts.showNotification("top", "right", "Upps hace falta algunos datos.", "warning");
                      
        //     }
           
        // });
        
        
        $("#tabla-general tbody").on("click", ".consultar_logs_descuentos", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $("#nombreUsuario").html('');
            $("#lista-comentarios-descuentos").html('');


            id_user = $(this).val();
            usuario = $(this).attr("data-value");

            $("#historialLogsPagos").modal();
            $("#nombreUsuario").append(usuario);
            $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                let saldo_comisiones;

                if(data.saldo_comisiones == 'NULL' || data.saldo_comisiones=='null' || data.saldo_comisiones==undefined){
                    saldo_comisiones = '';
                }else{
                    saldo_comisiones = '<label style="font-size:small;border-radius: 13px;background: rgb(0, 122, 255);' +
                        'color: white;padding: 0px 10px;">Monto comisionado: <b>'+data.saldo_comisiones+'</b></label>';
                }

                if (!data) {
                    $("#lista-comentarios-descuentos").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');
                } else {
                    $.each(data, function (i, v) {
                        $("#lista-comentarios-descuentos").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;"><b>Comentario: </b>Se descontó la cantidad de <b>$' + formatMoney(v.comentario) +'</b><br>' + v.comentario2 +''+saldo_comisiones+'<br><b style="color:#3982C0;font-size:0.9em;">Movimiento: ' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });
        });

        $('#tabla-general tbody').on('click', '.activar-prestamo', function (e) {
            alert("entra a activar");

            id_usuario = $(this).val();
            id_descuento = $(this).attr("data-value");

            $('#id-descuento-pago').val(id_descuento);

            $('#activar-pago-form').trigger('reset');

                $('#activar-pago-modal').modal();
            
        });

        $("#tabla-general tbody").on("click", ".aplicarDescuentoMensual", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#listaLotesDisponibles").html('');
            $("#informacionGeneral").html('');
            $("#arrayLotes").val('');
            $("#usuarioId").val('');
            $("#nombre").val('');
            $("#saldoComisiones").val('');
            $("#comentario").val('');

            id_user = $(this).val();
            monto = $(this).attr("data-value");
            sde = $(this).attr("data-sede");
            validar = $(this).attr("data-validate");
            saldoComisiones = $(this).attr("data-saldoComisiones");
            nombreUsuario = $(this).attr("data-nombre");

            $("#modalAplicarDescuento modal-body").html("");
            $("#modalAplicarDescuento").modal();

            var user = $(this).val();
            let datos = user.split(',');
            $("#montoaDescontar").val('$' + formatMoney(monto));
            $("#usuarioId").val(id_user);
            $('#saldoComisiones').val(saldoComisiones);
            $('#informacionGeneral').append('<p>Descuento a <b>'+nombreUsuario+'</b>, saldo en comisiones: <b>$'+ formatMoney(saldoComisiones)+'</b></p>');

            $.post('getLotesOrigen2/' + id_user + '/' + monto, function (data) {
                var len = data.length;
                let  info = ''; 
                let sumaselected = 0;
                for (var i = 0; i < len; i++) {

                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = parseFloat(data[i]['comision_total']) - parseFloat(data[i]['abono_pagado']);
                    sumaselected = sumaselected + parseFloat(data[i]['comision_total']);
                    info += "<p>"
                    info += (i+1) + ' - ' + name;
                    info += ' - <b>';
                    info += formatMoney(comtotal.toFixed(2));
                    info += '</b></p>';

                    $("#arrayLotes").val(`${comision},${comtotal.toFixed(2)},${pago_neodata},${name}`);
                    $("#comentario").val(`DESCUENTO UNIVERSIDAD MADERAS POR EL MONTO DE $${formatMoney(monto)}`);
                }

                $("#listaLotesDisponibles").append(info);
                $("#totalDisponible").val('$' + formatMoney(sumaselected));
                $("#listaLotesDisponibles").selectpicker('refresh');
            }, 'json'); 


        });
 
   

    $("#tabla-general tbody").on("click", ".consultar_fecha_pagos", function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();
        document.getElementById('nameUser').innerHTML = '';
        document.getElementById('sumaMensualComisiones').innerHTML = '';
        $('#userid').val(0);
        id_user = $(this).val();
        usuario = $(this).attr("data-value");
        $('#userid').val(id_user);
        $("#seeInformationModalP").modal();
        $('#nameUser').append('<p>Usuario: <b>'+usuario+'</b></p>');
        let datos = '';
        let datosA = '';
        for (let index = 0; index < meses.length; index++) {
             datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        }
        for (let index = 0; index < anios.length; index++) {
             datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
        }
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        $('#anio').html(datosA);
        $('#anio').selectpicker('refresh');
    });

    let meses = [
        {id:01, mes:'Enero'},
        {id:02,mes:'Febrero'},
        {id:03,mes:'Marzo'},
        {id:04,mes:'Abril'},
        {id:05,mes:'Mayo'},
        {id:06,mes:'Junio'},
        {id:07,mes:'Julio'},
        {id:08,mes:'Agosto'},
        {id:09,mes:'Septiembre'},
        {id:10,mes:'Octubre'},
        {id:11,mes:'Noviembre'},
        {id:12,mes:'Diciembre'}
    ];
    let anios = [2019,2020,2021,2022,2023,2024];

    $('#mes').change(function() {
        anio = $('#anio').val();
        mes = $('#mes').val();
        let usuario = $('#userid').val();
        if(anio == ''){
            anio=0;
        }else{
    
            getPagosByUser(usuario,mes, anio);
        }
    });
    

    function getPagosByUser(usuario,mes, anio){
        document.getElementById('sumaMensualComisiones').innerHTML = 'Cargando...';
        $.getJSON("getPagosByUser/" + usuario+"/"+mes+"/"+anio).done(function (data) {
            document.getElementById('sumaMensualComisiones').innerHTML ='$'+ formatMoney(data[0].suma);
        });
    }
    

    $('#anio').change(function() {
        let usuario = $('#userid').val();
        mes = $('#mes').val();
        anio = $('#anio').val();
    
        if(mes != '' && (anio != '' || anio != null || anio != undefined)){
            getPagosByUser(usuario,mes, anio);
    
        }
    });

    $("#tabla-general tbody").on("click", ".topar_descuentos", function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();
     
        $('#mensajeConfirmacion').html('');
        $('#comentarioTopar').html('');
        $('#montosDescuento').html('');

        $('#usuarioTopar').val(0);
        id_user = $(this).val();
        nombreUsuario = $(this).attr("data-nombre");
        rolUsuario = $(this).attr("data-rol");
        totalDescuento = $(this).attr("data-totalDescuento");
        abonado = $(this).attr("data-abonado");
        
        $('#mensajeConfirmacion').append('<p>¿Está seguro de detener los pagos al '+rolUsuario+' <b>'+ nombreUsuario+'</b>?</p>');
        $('#montosDescuento').append('<p>Total descuento: <b>$'+formatMoney(totalDescuento)+'</b></p><p>Monto descontado: <b>$'+formatMoney(abonado)+'</b></p>');
        $('#usuarioTopar').val(id_user);

        $("#modal_nuevas").modal();
        // let datos = '';
        // let datosA = '';
        // for (let index = 0; index < meses.length; index++) {
        //      datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        // }
        // for (let index = 0; index < anios.length; index++) {
        //      datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
        // }
        // $('#mes').html(datos);
        // $('#mes').selectpicker('refresh');
        // $('#anio').html(datosA);
        // $('#anio').selectpicker('refresh');
    });




}); //END DATATABLE


function open_Mb() {

    $("#roles").val('');
    $("#roles").selectpicker("refresh");
    document.getElementById("users2").innerHTML = '';
    $("#usuarioid2").val('');
    $("#usuarioid2").selectpicker("refresh");
    $("#comentario2").val('');
    $('#ModalBonos').modal('show');
}

$("#roles").change(function () {
    var parent = $(this).val();

    $("#users2").val('');

    $("#usuarioid2").val('');
    $("#usuarioid2").selectpicker("refresh");


    document.getElementById("users2").innerHTML = '';
    // $('#users2').append(`<label class="label">Usuario</label><select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>`);


    $('#users2').append(`<div class="col-lg-12 form-group m-0" id="select">
    <label class="label-gral">Puesto</label><select class="selectpicker select-gral m-0" name="roles" id="roles" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select></div>`);


function filterFloat(evt, input) {

    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    var isNumber = (key >= 48 && key <= 57);
    var isSpecial = (key == 8 || key == 13 || key == 0 || key == 46);
    if (isNumber || isSpecial) {
        return filter(tempValue);
    }

    return false;

}

function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    return (preg.test(__val__) === true);
}
$("#usuarioid2").change(function () {

    $("#FaltaUsuarios").hide(1250);
    $("#ListoUsuarios").show("slow");
});
function onKeyUp(event) {
    var keycode = event.keyCode;
    var id = 0 ;
    if(keycode != '13'){ 

        let monto = replaceAll(monto1, '$', '');
    //
        
            var re = /^[0-9]*$/i;
            let msg = monto.value;
            // Si el caracter introducido no es un número
            if(!(msg.match(re) !== null)){
                // Elimina el último caracter introducido
                id = msg.slice(0, msg.length - 1);
            }
            console.log(id)
    // 
        if(monto <= 0 ){
            $("#FaltaDescuento").show("slow");
            $("#ListoDescuento").hide(1250);
       
    
        } else{
       
            $("#FaltaDescuento").hide(1250);
            $("#ListoDescuento").show("slow");
            
            let cantidad = parseFloat($('#numeroPagos').val());
            if(isNaN(monto)) {
               
            }
            
            let resultado = 0;
            resultado = monto / cantidad;
    
                if (resultado > 0) {
                    monto = monto.replace(/[$.]/g,'');
                    $('#descuento').val(formatMoney(monto));
                    $('#pago_ind01').val(formatMoney(resultado));
                    $("#FaltaMonto").hide(1250);
                    $("#ListoMonto").show("slow");
                } else {
                    $('#pago_ind01').val(formatMoney(0));
                    $("#FaltaMonto").hide(1250);
                    $("#ListoMonto").show("slow");
    
                }
        }

       
    }
}

    $("#roles").change(function () {
        // diseño incio
        $("#FaltaPuesto").hide(1250);
        $("#ListoPuesto").show("slow");
        $('#usuarioid2').empty();
        $("#ListoUsuarios").hide(1250);
        $("#FaltaUsuarios").show("slow");
        // diseño fin
      
       
        var parent = $(this).val();
        $("#users2").val('');
        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");
       
        // document.getElementById("users2").innerHTML = '';
     

        $.post('getUsuariosRolDU/' + parent, function (data) {
            
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['name_user'];
                $("#usuarioid2").append($('<option>').val(id).text(name));
            }
            if (len <= 0) {
                $("#usuarioid2").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
            }
            $("#usuarioid2").selectpicker('refresh');
        }, 'json'); 
    

    
});


        // $('#tabla-general tbody').on('click', '.btn-eliminar-descuento', function () {
        //     const idDescuento = $(this).val();

        //     $.ajax({
        //         type: 'POST',
        //         url: `eliminarDescuentoUniversidad/${idDescuento}`,
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function (data) {
        //             if (JSON.parse(data)) {
        //                 alerts.showNotification("top", "right", "El registro se ha eliminado exitosamente.", "success");
        //                 tablaGeneral.ajax.reload();
        //             } else {
        //                 alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
        //             }
        //         },
        //         error: function(){
        //             alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        //         }
        //     });
        // });

        // $('#tabla-general tbody').on('click', '.btn-editar-descuento', function () {
        //     const idDescuento = $(this).val();

        //     $.get(`obtenerDescuentoUniversidad/${idDescuento}`, function (data) {
        //         const info = JSON.parse(data);

        //         $('#id-descuento-pago-update').val(info.id_descuento);
        //         $('#usuario-update').text("").text(`Usuario: ${info.usuario}`);
        //         $('#descuento-update').val(info.monto);
        //         $('#numero-pagos-update').val(info.no_pagos);
        //         $('#pago-ind-update').val(info.pago_individual);
        //         $('#actualizar-descuento-modal').modal();
        //     });
        // });


        
     

//         $('#tabla-general tbody').on('click', 'td.details-control', function () {
//             var tr = $(this).closest('tr');
//             var row = tablaGeneral.row(tr);

//             if (row.child.isShown()) {
//                 row.child.hide();
//                 tr.removeClass('shown');
//                 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
//             } else {
//                 if (row.data().solicitudes == null || row.data().solicitudes == "null") {
//                     $.post(url + "Comisiones/getDescuentosCapitalpagos", {"id_usuario": row.data().id_usuario}).done(function (data) {

//                         row.data().solicitudes = JSON.parse(data);

//                         tablaGeneral.row(tr).data(row.data());

//                         row = tablaGeneral.row(tr);

//                         row.child(construir_subtablas(row.data().solicitudes)).show();
//                         tr.addClass('shown');
//                         $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");

//                     });
//                 } else {
//                     row.child(construir_subtablas(row.data().solicitudes)).show();
//                     tr.addClass('shown');
//                     $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
//                 }

//             }


//         });
//     });
// }

// function getInputTotalId(tipoDescuento) {
//     if (tipoDescuento === '1') {
//         return 'total-activo'; 
//     } else if (tipoDescuento === '2') {
//         return 'total-baja';
//     } else if (tipoDescuento === '3') {
//         return 'total-liquidado'
//     } else if (tipoDescuento === '4') {
//         return 'total-conglomerado';
//     }else if (tipoDescuento === '5') {
//         return 'total-detenido';
//     }
//     return '';
// }

// function getInputAbonadoId(tipoDescuento) {
//     if (tipoDescuento === '1') {
//         return 'total-abonado';
//     } else if (tipoDescuento === '2') {
//         return 'abonado-baja';
//     } else if (tipoDescuento === '3') {
//         return 'abonado-liquidado'
//     } else if (tipoDescuento === '4') {
//         return 'abonado-conglomerado';
//     }else if (tipoDescuento === '5') {
//         return 'total-detenido';
//     }
//     return '';
// }

// function getInputPendienteId(tipoDescuento) {
//     if (tipoDescuento === '1') {
//         return 'total-pendiente';
//     } else if (tipoDescuento === '2') {
//         return 'pendiente-baja';
//     } else if (tipoDescuento === '3') {
//         return 'pendiente-liquidado'
//     } else if (tipoDescuento === '4') {
//         return 'pendiente-conglomerado';
//     }else if (tipoDescuento === '5') {
//         return 'total-detenido';
//     }
//     return '';
// }


// $('#activar-pago-form').on('submit', function (e) {
//     e.preventDefault();

//     let dateForm = new Date($('#fecha').val());
//     dateForm.setDate(dateForm.getDate() + 1);
//     const today = new Date();

//     if (dateForm.setHours(0,0,0,0) < today.setHours(0,0,0,0)) {
//         alerts.showNotification("top", "right", "La Fecha debe ser igual o mayor a la actual.", "danger");
//     } else {
//         $.ajax({
//             type: 'POST',
//             url: 'reactivarPago',
//             data: new FormData(this),
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function (data) {
//                 if (JSON.parse(data)) {
//                     $('#activar-pago-modal').modal('hide');
//                     $('#id-descuento-pago').val('');
//                     alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
//                     tablaGeneral.ajax.reload();
//                 } else {
//                     alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
//                 }
//             },
//             error: function(){
//                 alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//             }
//         });
//     }
// });

// $('#actualizar-descuento-form')
//     .submit(function (e) {
//         e.preventDefault();
//     })
//     .validate({
//         rules: {
//             descuento: {
//                 required: true,
//                 number: true,
//                 min: 1,
//                 max: 99000
//             },
//             "numero-pagos": {
//                 required: true
//             }
//         },
//         messages: {
//             descuento: {
//                 required: '* Campo requerido.',
//                 number: 'Número no válido.',
//                 min: 'El valor mínimo debe ser 1',
//                 max: 'El valor máximo debe ser 99,000'
//             },
//             "numero-pagos": {
//                 required: '* Campo requerido.'
//             }
//         },
//         submitHandler: function (form) {
//             const data = new FormData($(form)[0]);

//             $.ajax({
//                 url: 'actualizarDescuentoUniversidad',
//                 data: data,
//                 method: 'POST',
//                 contentType: false,
//                 cache: false,
//                 processData: false,
//                 success: function (data) {

//                     $('#actualizar-descuento-modal').modal('hide');
//                     alerts.showNotification("top", "right", "Descuento actualizado con exito.", "success");
//                     $('#tabla-general').DataTable().ajax.reload(null, false);
//                 },
//                 error: function () {
//                     alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//                 }
//             });
//         }
//     });

// $('#numero-pagos-update').change(function () {
//     const monto1 = replaceAll($('#descuento-update').val(), ',', '');
//     const monto = replaceAll(monto1, '$', '');
//     const cantidad = parseFloat($('#numero-pagos-update').val());
//     let resultado = 0;

//     if (isNaN(monto)) {
//         alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
//         $('#pago-ind-update').val(resultado);
//     } else {
//         resultado = monto / cantidad;
//         if (resultado > 0) {
//             $('#pago-ind-update').val(formatMoney(resultado));
//         } else {
//             $('#pago-ind-update').val(formatMoney(0));
//         }
//     }
// });



// function construir_subtablas(data) {
//         var solicitudes = '<table class="table">';
//         $.each(data, function (i, v) {
//             //i es el indice y v son los valores de cada fila

//             // console.log(data);
//             if (v.id_usuario == 'undefined') {
//                 solicitudes += '<tr>';
//                 solicitudes += '<td><b>SIN PAGO APLICADOS</b></td>';
//                 solicitudes += '</tr>';

//             } else {
//                 solicitudes += '<tr>';
//                 solicitudes += '<td><b>Pago ' + (i + 1) + '</b></td>';
//                 solicitudes += '<td>' + '<b>' + 'USUARIO ' + '</b> ' + v.nombre + '</td>';
//                 solicitudes += '<td>' + '<b>' + 'MONTO: ' + '</b> $' + formatMoney(v.abono_neodata) + '</td>';
//                 solicitudes += '<td>' + '<b>' + 'CREADO POR: ' + '</b> ' + v.creado_por + '</td>';
//                 solicitudes += '<td>' + '<b>' + 'FECHA CAPTURA: ' + '</b> ' + v.fecha_abono + '</td>';
//                 solicitudes += '</tr>';
//             }

//         });

//         return solicitudes += '</table>';
//     }





// function filterFloat(evt, input) {

//     var key = window.Event ? evt.which : evt.keyCode;
//     var chark = String.fromCharCode(key);
//     var tempValue = input.value + chark;
//     var isNumber = (key >= 48 && key <= 57);
//     var isSpecial = (key == 8 || key == 13 || key == 0 || key == 46);
//     if (isNumber || isSpecial) {
//         return filter(tempValue);
//     }

//     return false;

// }

// function filter(__val__) {
//     var preg = /^([0-9]+\.?[0-9]{0,2})$/;
//     return (preg.test(__val__) === true);
// }


    // $("#roles").change(function () {
    //     var parent = $(this).val();

    //     $("#users2").val('');

    //     $("#usuarioid2").val('');
    //     $("#usuarioid2").selectpicker("refresh");


    //     document.getElementById("users2").innerHTML = '';
    //     $('#users2').append(`<label class="label">Usuario</label><select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>`);
    //     $.post('getUsuariosRolDU/' + parent, function (data) {
    //         $("#usuarioid2").append($('<option disabled>').val("default").text("Seleccione una opción"))
    //         var len = data.length;
    //         for (var i = 0; i < len; i++) {
    //             var id = data[i]['id_usuario'];
    //             var name = data[i]['name_user'];
    //             var status = data[i]['estatus'];
    //             if(status == 0){
    //                 name = name + ' (Inactivo)';
    //             }
    //             $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
    //         }
    //         if (len <= 0) {
    //             $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    //         }
    //         $("#usuarioid2").selectpicker('refresh');
    //     }, 'json');
    // });


$("#formularioAplicarDescuento").submit(function (e) {
    $('#btn_abonar').prop('disabled', true);
    document.getElementById('btn_abonar').disabled = true;

    $('#idloteorigen').removeAttr('disabled');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'saveDescuento/' + 3,
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    $('#idloteorigen option').remove();
                    $("#roles").val('');
                    $("#roles").selectpicker("refresh");
                    $('#usuarioid').val('default');
                    $('#usuarioid').val('default');

                    $("#usuarioid").selectpicker("refresh");

                    alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");


                } else if (data == 2) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    $(".directorSelect2").empty();

                } else if (data == 3) {
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    $(".directorSelect2").empty();

                }
                $('#idloteorigen').attr('disabled', 'true');

            },
            error: function () {
                $('#loaderDiv').addClass('hidden');
                $('#modalAplicarDescuento').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#idloteorigen').attr('disabled', 'true');


            }
        });
    }





    
});


// Función para pausar la solicitud
$("#form_interes").submit(function (e) {

    // $('#btn_topar').attr('disabled', 'true');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
           $.ajax({
            url: general_base_url+"Comisiones/toparDescuentoUniversidad",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data[0]) {
                    $("#modal_nuevas").modal('toggle');
                    alerts.showNotification("top", "right", "Se detuvo el descuento exitosamente", "success");
                    setTimeout(function () {
                        tablaGeneral.ajax.reload();
                    }, 3000);
                } else {
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            }, error: function () {
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA", "danger");
            }
        });
    }
});

// $("#form_nuevo").submit(function (e) {

//     // $('#btn_abonar').attr('disabled', 'true');
//     $('#btn_abonar').prop('disabled', true);
//     document.getElementById('btn_abonar').disabled = true;

//     e.preventDefault();
// }).validate({
//     rules: {
//         roles: {
//             required: true
//         },
//         descuento: {
//             required: true,
//             number: true,
//             min: 1,
//             max: 99000
//         },
//         numeroPagos: {
//             required: true
//         },
//         comentario2: {
//             required: true
//         }
//     },
//     messages: {
//         roles: {
//             required: '* Campo requerido'
//         },
//         descuento: {
//             required: '* Campo requerido',
//             number: 'Número no válido.',
//             min: 'El valor mínimo debe ser 1',
//             max: 'El valor máximo debe ser 99,000'
//         },
//         numeroPagos: {
//             required: '* Campo requerido'
//         },
//         comentario2: {
//             required: '* Campo requerido'
//         }
//     },
//     submitHandler: function (form) {

//         const data1 = new FormData($(form)[0]);
//         $.ajax({
//             url: 'saveDescuentoch/',
//             data: data1,
//             method: 'POST',
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function (data) {
//                 if (data == 1) {
//                     $('#loaderDiv').addClass('hidden');
//                     $('#tabla-general').DataTable().ajax.reload(null, false);
//                     $('#ModalBonos').modal('hide');
//                     $("#roles").val('');
//                     $("#roles").selectpicker("refresh");
//                     document.getElementById("users2").innerHTML = '';
//                     $("#usuarioid2").val('');
//                     $("#usuarioid2").selectpicker("refresh");

//                     $("#descuento").val('');
//                     $("#numeroPagos").val('');
//                     $("#pago_ind01").val('');
//                     $("#comentario2").val('');
//                     alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");

//                 } else if (data == 2) {
//                     $('#loaderDiv').addClass('hidden');
//                     $('#tabla-general').DataTable().ajax.reload(null, false);
//                     $('#ModalBonos').modal('hide');
//                     alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
//                     $(".directorSelect2").empty();

//                 } else if (data == 3) {
//                     $('#tabla-general').DataTable().ajax.reload(null, false);
//                     $('#ModalBonos').modal('hide');
//                     alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
//                     $(".directorSelect2").empty();

//                 }

//             },
//             error: function () {
//                 $('#loaderDiv').addClass('hidden');
//                 $('#ModalBonos').modal('hide');
//                 alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//                 $('#idloteorigen').attr('disabled', 'true');


        let monto1 = replaceAll($('#descuento').val(), ',', '');
        let monto = replaceAll(monto1, '$', '');
        let cantidad = parseFloat($('#numeroPagos').val());
        let resultado = 0;
        $("textarea").val('DESCUENTO UNIVERSIDAD MADERAS');
       

        if (isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            $('#pago_ind01').val(resultado);
            $('#btn_abonar').prop('disabled', true);
            document.getElementById('btn_abonar').disabled = true;
        } else if(monto <= 0 ){
            $("#FaltaDescuento").show("slow");
            $("#ListoDescuento").hide(1250);

            $("#ListoMensualidad").hide(1250);
            $("#FaltaMensualidad").show("slow");
        }else{
            $("#FaltaDescuento").hide(1250);
            $("#ListoDescuento").show("slow");

            $("#FaltaMensualidad").hide(1250);
            $("#ListoMensualidad").show("slow");
   
            resultado = monto / cantidad;

            if (resultado > 0) {
                $('#pago_ind01').val(formatMoney(resultado));
                $("#FaltaMonto").hide(1250);
                $("#ListoMonto").show("slow");
            } else {
                $('#pago_ind01').val(formatMoney(0));
                $("#FaltaMonto").hide(1250);
                $("#ListoMonto").show("slow");

            }
        }
    });


//         let monto1 = replaceAll($('#descuento').val(), ',', '');
//         let monto = replaceAll(monto1, '$', '');
//         let cantidad = parseFloat($('#numeroPagos').val());
//         let resultado = 0;


//         if (isNaN(monto)) {
//             alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
//             $('#pago_ind01').val(resultado);
//             $('#btn_abonar').prop('disabled', true);
//             document.getElementById('btn_abonar').disabled = true;
//         } else {
//             resultado = monto / cantidad;

//             if (resultado > 0) {
//                 $('#pago_ind01').val(formatMoney(resultado));
//             } else {
//                 $('#pago_ind01').val(formatMoney(0));
//             }
//         }
//     });


// function closeModalEng() {
//     document.getElementById("form_abono").reset();
//     a = document.getElementById('inputhidden');
//     padre = a.parentNode;
//     padre.removeChild(a);

//     $("#modal_abono").modal('toggle');

// }

// function CloseModalDelete2() {
//     document.getElementById("form-delete").reset();
//     a = document.getElementById('borrarBono');
//     padre = a.parentNode;
//     padre.removeChild(a);

//     $("#modal-delete").modal('toggle');

// }

// function CloseModalUpdate2() {
//     document.getElementById("form-update").reset();
//     a = document.getElementById('borrarUpdare');
//     padre = a.parentNode;
//     padre.removeChild(a);

//     $("#modal-abono").modal('toggle');

// }

// $(window).resize(function () {
//     tablaGeneral.columns.adjust();
// });

// function formatMoney(n) {
//     var c = isNaN(c = Math.abs(c)) ? 2 : c,
//         d = d == undefined ? "." : d,
//         t = t == undefined ? "," : t,
//         s = n < 0 ? "-" : "",
//         i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
//         j = (j = i.length) > 3 ? j % 3 : 0;
//     return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
// }

// $("#idloteorigen").change(function () {

//         let cuantos = $('#idloteorigen').val().length;
//         let suma = 0;
//         if (cuantos > 1) {

//             var comision = $(this).val();

//             for (let index = 0; index < $('#idloteorigen').val().length; index++) {
//                 datos = comision[index].split(',');
//                 let id = datos[0];
//                 let monto = datos[1];
//                 document.getElementById('monto').value = '';

//                 $.post('getInformacionData/' + id + '/' + 1, function (data) {

//                     var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
//                     var idecomision = data[0]['id_pago_i'];
//                     suma = suma + disponible;
//                     document.getElementById('montodisponible').innerHTML = '';
//                     $("#totalDisponible").val('$' + formatMoney(suma));
//                     $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + suma.toFixed(2) + '">');
//                     $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
//                     var len = data.length;
//                     if (len <= 0) {
//                         $("#totalDisponible").val('$' + formatMoney(0));
//                     }
//                     $("#montodisponible").selectpicker('refresh');
//                 }, 'json');
//             }
         
//         } else {
//             var comision = $(this).val();
//             datos = comision[0].split(',');
//               let id = datos[0];
//             let monto = datos[1];
//             document.getElementById('monto').value = '';
//             $.post('getInformacionData/' + id + '/' + 1, function (data) {
//                 var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
//                 var idecomision = data[0]['id_pago_i'];
//                 document.getElementById('montodisponible').innerHTML = '';
//                 $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + disponible + '">');
//                 $("#totalDisponible").val('$' + formatMoney(disponible));
//                 $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
//                 var len = data.length;
//                 if (len <= 0) {
//                     $("#totalDisponible").val('$' + formatMoney(0));
//                 }
//                 $("#montodisponible").selectpicker('refresh');
//             }, 'json');
//         }
//     });

// function verificar() {

//         let d2 = replaceAll($('#totalDisponible').val(), ',', '');
//         let disponiblefinal = replaceAll(d2, '$', '');
//         let m = replaceAll($('#monto').val(), ',', '');
//         let montofinal = replaceAll(m, '$', '');

//         let disponible = parseFloat(disponiblefinal);
//         let monto = parseFloat(montofinal);

//         if (monto < 1 || isNaN(monto)) {
//             alerts.showNotification("top", "right", "No hay saldo disponible para descontar.", "warning");

//             $('#btn_abonar').prop('disabled', true);
//             document.getElementById('btn_abonar').disabled = true;

//         } else {
//             if (parseFloat(monto) <= parseFloat(disponible)) {

//                  let cantidad = parseFloat($('#numeroP').val());
//                 resultado = monto / cantidad;
//                 $('#pago').val(formatMoney(resultado));

//                 $('#btn_abonar').prop('disabled', false);
//                 document.getElementById('btn_abonar').disabled = false;

        
//                 let cuantos = $('#idloteorigen').val().length;
//                 let cadena = '';
//                 var data = $('#idloteorigen').select2('data')
//                 for (let index = 0; index < cuantos; index++) {
//                     let datos = data[index].id;
//                     let montoLote = datos.split(',');
//                     let abono_neo = montoLote[1];

//                     if (parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1) {
//                         document.getElementById('msj2').innerHTML = "El monto ingresado se cubre con la comisión " + data[index].text;

//                         $('#btn_abonar').prop('disabled', false);
//                         document.getElementById('btn_abonar').disabled = false;

//                         break;
//                     }

//                 if(cuantos == 1){
//                     let datosLote = data[index].text.split('-   $');
//                     let nameLote = datosLote[0]
//                     let montoLote = datosLote[1];
//                     cadena =  'DESCUENTO UNIVERSIDAD MADERAS, LOTE INVOLUCRADO: '+nameLote+', DISPONIBLE: $'+montoLote+'. DESCUENTO DE: $'+formatMoney(monto)+', RESTANTE:$'+formatMoney(parseFloat(abono_neo) - parseFloat(monto));
//                 }else{
//                     cadena = 'DESCUENTO UNIVERSIDAD MADERAS';
//                 }

//                     document.getElementById('msj2').innerHTML = '';

//                 }
//                 $('#comentario2').val(cadena);
//             }
//             else if (parseFloat(monto) > parseFloat(disponible)) {
//                 alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
 
//                 $('#btn_abonar').prop('disabled', true);
//                 document.getElementById('btn_abonar').disabled = true;
//             }
//         }

//     }

// function general(){
//     $("#idloteorigen").select2({dropdownParent: $('#modalAplicarDescuento')});
//     $("#idloteorigen").select2("readonly", true);
// }


// function replaceAll(text, busca, reemplaza) {
//     while (text.toString().indexOf(busca) != -1)
//         text = text.toString().replace(busca, reemplaza);
//     return text;
// }
 

// $('#ModalBonos').on('hidden.bs.modal', function() {
//     $('#form_nuevo').trigger('reset');
// });



// $(document).on("click", ".uniAdd", function () {
//     let banderaLiquidados = false;
//     $("#modalUni").modal();

//     document.getElementById("fechaIncial").value = '';

//     document.getElementById("descuentoEscrito").value = '';
//     // el que modificaremos    
//     id_descuento = $(this).attr("data-value");
//     //id_usuario perteneciente a ese id_user
//     id_user = $(this).attr("data-code");    
//     // aqui mero va la bander de saber que info se guardara
//     pago_mensual = $(this).attr("data-mensual");
//     nombre = $(this).attr("data-nombre")
//     descuento = $(this).attr("data-descuento");
  
//     pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
//     total = $(this).attr("data-total"); //dinero que ha pagado al momento
//     MontoDescontarCerti = $(this).attr("data-value");
//     valorCertificacion = $(this).attr("data-idCertificacion");
//     document.getElementById("certificaciones").value = valorCertificacion;
//     if (descuento == total){
//         banderaLiquidados = true;

//     }else{

//         banderaLiquidados = false;
//     }
//     descuento = Math.round(descuento);
//     pago_mensual = Math.round(pago_mensual);

//     cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos

    
 
//     document.getElementById("banderaLiquidado").value = banderaLiquidados;
//     document.getElementById("dineroPagado").value = total;
//     document.getElementById("pagoIndiv").value = pago_mensual;
//     document.getElementById("idDescuento").value = id_descuento;
//     document.getElementById("totalPagos").value = cantidad_de_pagos;
//     document.getElementById("pagoDado").value = pagoDado;
//     id_user = $(this).attr("data-code");
//     pago_mensual = $(this).attr("data-mensual");
//     descuento = $(this).attr("data-descuento");
//     pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
//     total = $(this).attr("data-total"); //dinero que ha pagado al momento

//     valorPendiente = pendiente;

//     var titulo  = ' ';
//     titulo += '  <h3 id="tituloModalUni" name="tituloModalUni">Editando descuento actual para '+ nombre  +'</h3>';



//     var informacion_adicional = ' '; //inicio de div que contiene todo el modal
//     informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
 
//     informacion_adicional += '        <div class="form-group text-left">';
//     informacion_adicional += '            <label class="label ">Monto Descuento *</label>';
//     informacion_adicional += '            <input class="form-control  MontoDescontarCerti" type="number" id="MontoDescontarCerti"';
//     informacion_adicional += '                name="MontoDescontarCerti" autocomplete="off" min="1" max="99000" step=".01"';
//     informacion_adicional += '               required />';
//     informacion_adicional += '         </div>';
//     informacion_adicional += '       </div>';

//     informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
//     informacion_adicional += '        <div class="form-group text-left">';
//     informacion_adicional += '          <label class="label">Pagos repartidos*</label> ';
//     informacion_adicional += '         <select class="form-control mensualidadesC" name="mensualidadesC" id="mensualidadesC" required>';
//     informacion_adicional += '          <option value="" disabled="true" selected="selected">- Selecciona opción';
//     informacion_adicional += '          </option>';
//     informacion_adicional += '          <option value="1">1</option>';
//     informacion_adicional += '          <option value="2">2</option>';
//     informacion_adicional += '          <option value="3">3</option>';
//     informacion_adicional += '          <option value="4">4</option>';
//     informacion_adicional += '          <option value="5">5</option>';
//     informacion_adicional += '          <option value="6">6</option>';
//     informacion_adicional += '          <option value="7">7</option>';
//     informacion_adicional += '          <option value="8">8</option>';
//     informacion_adicional += '          <option value="9">9</option>';
//     informacion_adicional += '          <option value="10">10</option>';
//     informacion_adicional += '          <option value="11">11</option>';
//     informacion_adicional += '         </select>';
//     informacion_adicional += '        </div>';
//     informacion_adicional += '      </div>';

//     informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
//     informacion_adicional += '        <div class="form-group text-left">';
//     informacion_adicional += '            <label class="label">Nuevas mensualidades*</label>';
//     informacion_adicional += '            <input class="form-control newMensualidades" type="number" id="newMensualidades"';
//     informacion_adicional += '                name="newMensualidades" autocomplete="off" min="1" max="99000" step=".01"';
//     informacion_adicional += '               required />';
//     informacion_adicional += '         </div>';
//     informacion_adicional += '      </div>';
//     // eee

//     var cuerpoModalUni = document.getElementById('cuerpoModalUni');
//     cuerpoModalUni.innerHTML = informacion_adicional;

//     document.getElementById("MontoDescontarCerti").value = descuento;
//     var myCommentsLote = document.getElementById('tituloModalUni');
//     myCommentsLote.innerHTML = '';

//     var Header_modal = document.getElementById('header_modal');
//     Header_modal.innerHTML = titulo;
 
//        mensualidadesFaltantes = total / pago_mensual ;
//             mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;         
//             if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

//             }else{
//                 if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
//                 {
//                     if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
//                     {
//                         mensualidadesFaltantesMostrar = 1;
//                     }else{

//                     }           
//                 }else{

//                     mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
//                 }
//             }
//             if ((mensualidadesFaltantes % 1)  == 0 ){

//             }else{
//                 if( 0 == Math.trunc(mensualidadesFaltantes))
//                 {
//                     if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
//                     {

//                         mensualidadesFaltantes = 1;
//                     }else{
                    
//                     }
//                 }else{
//                         mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
//                 }
//             }
//             if(banderaLiquidados){
//                 document.getElementById("mensualidadesC").value = 1;
//                 mensualidadesFaltantesMostrar = 1;
//                 mensualidadesFaltantes = 1;
//             }else{
//                 mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;
//                 document.getElementById("mensualidadesC").value = Math.trunc( mensualidadesFaltantesMostrar);
//             }


//             ultimaMensualidad = document.getElementById("mensualidadesC").value
//             Total_a_pagar = ultimaMensualidad * pago_mensual;

//             sobrante = Total_a_pagar - total;

//             //para agregar llo que ya se pago
//             descuentoEscrito = document.getElementById("MontoDescontarCerti").value;
         
//             NuevasMensualidades= (pendiente)  / ultimaMensualidad ;

//             if(banderaLiquidados){

//                 sobrante = document.getElementById("MontoDescontarCerti").value;
//                 sobrante =  total - sobrante ;
//                 NuevasMensualidades = sobrante  / mensualidadesFaltantes;
//             }
//             document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
//             //faltantes = mensualidadesFaltantes/mensual;
//             document.getElementById("precioOrginal").value =   NuevasMensualidades.toFixed(2);

// });  

// $(document).on("click", "#cancelarOperation", function () {
// $('#editDescuento').modal('hide');
// });

// $('#editDescuento').on("click", "#editarDescuentos", function (){

// });
// $(document).on("click", "#editarDescuentos", function () {
//     $('#botonesInicio').css('display', 'none');
//     $('#updateDescuento').css('display', 'block');
//     $('#fomularioEditarDescuento').css('display', 'block');
// });
// $(document).on("click", "#descuentoCertificaciones", function () {

// }); 

// Nueva functionalidad
 //  aqui mero 

// $("#certificaciones").change(function () {

//     pagos  = document.getElementById("numeroDeMensualidades").value ;
//     selectCertificacion = document.getElementById("certificaciones").value;

//     var comentarioDescrip = document.getElementById('textDescripcion');
//     comentarioDescrip.innerHTML = '';
//     if(selectCertificacion == 1){
//         comentarioDescrip.innerHTML = '';
//         comentarioDescrip.innerHTML = 'Persona que obtuvo una calificación favorable y con ello la certificación.';
//     }else if(selectCertificacion == 2){
//         comentarioDescrip.innerHTML = '';
//         comentarioDescrip.innerHTML = 'Persona que obtuvo una ponderación menor a la deseada y por ende no obtiene la certificación';
//     }else if(selectCertificacion == 3){
//         comentarioDescrip.innerHTML = '';
//         comentarioDescrip.innerHTML = 'Persona que al no seguir los lineamientos de la institución evaluadora se le suspende su proceso de certificación. ';
//     }else if(selectCertificacion == 4){
//         comentarioDescrip.innerHTML = '';
//         comentarioDescrip.innerHTML = 'Persona que se encuentra por hacer examen final con el Tecnológico de Monterrey.';
//     }else if(selectCertificacion == 5){
//         comentarioDescrip.innerHTML = 'Personas que está en valoración el que se certifiquen en este año, así que en sus casos hay que dejar activo el pago, porque dependiendo de cómo se desenvuelva cada caso puede ser que aplique incremento.';
//         comentarioDescrip.innerHTML = '';
//     }else{
//         comentarioDescrip.innerHTML = '';
//         comentarioDescrip.innerHTML = 'No definido';
//     }
    
// });

// $(document).on("click", ".editar_descuentos", function () {


// });

// function subirInfo(){  
//     document.getElementById("descuentoEscrito").value = '';
//     id_descuento = $(this).attr("data-value");
//     id_user = $(this).attr("data-code");    
//     // aqui mero va la bander de saber que info se guardara
//     pago_mensual = $(this).attr("data-mensual");
//     descuento = $(this).attr("data-descuento");
//     pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
//     total = $(this).attr("data-total"); //dinero que ha pagado al momento
//     descuento = Math.round(descuento);
//     pago_mensual = Ma/th.round(pago_mensual);
//     cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos
//     document.getElementById("pagado").value = total;
//     document.getElementById("mensualidad").value = pago_mensual;
//     document.getElementById("descuento_id").value = id_descuento;
//     document.getElementById("pagoDado").value = dineroPagado;
//     valor = 0;
//     valor1 = 0;
//  }
 



// $(document).on('input', '.MontoDescontarCerti', function(){

//     mensualidadesC = document.getElementById("mensualidadesC").value;
//     pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
//     loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
//     pagos  = document.getElementById("mensualidadesC").value ;
//     banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
//     if(banderaLiquidado){
//         loQueSedebe = loQueSedebe - pagado;

//         NuevasMensualidades = loQueSedebe / pagos;
//     }else{
//         loQueSedebe = loQueSedebe - pagado;

//         NuevasMensualidades = loQueSedebe / pagos;   
//     }

//     document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
// });

// $("#numeroPagos").change(function () {
    // $(document).on('change', '#mensualidadesC', function() {

    //     mensualidadesC = document.getElementById("mensualidadesC").value;
    //     loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
    //     pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
    //     pagos  = document.getElementById("mensualidadesC").value ;

    //     banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
    //     if(banderaLiquidado){
    //         loQueSedebe = loQueSedebe - pagado;
    //         NuevasMensualidades = loQueSedebe / pagos;
  
    //     }else{
    //         loQueSedebe = loQueSedebe - pagado;
    //         NuevasMensualidades = loQueSedebe / pagos;
    //     } 
    //     document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
    // });
                                                          

// $(document).on("click", ".updateDescuentoCertificado", function () {
//     let tipoDescuento = $('#tipo_descuento').val();
//     // let fechaSeleccionada = $('#fechaIncial').val();
//     const fecha = new Date()
//     let pagos_activos ;
//     let banderaSoloEstatus = false ; 
//     let banderaPagosActivos = 0 ;
//     // bandera pagos activos
//     let fechanoEscrita = false; 
//     // 1 fecha usuario < día 5  mismo mes  2: fecha usuario > día 5 y > mes actual  3: no se mueve los movimientos actuales,
//     let validacion = true;
//     let banderaEditarEstatus = document.getElementById("precioOrginal").value; 
//     let escritoPorUsuario = document.getElementById("newMensualidades").value;
//     let fechaSeleccionada = '';
//     fechaSeleccionada = document.getElementById("fechaIncial").value;

//     if(tipoDescuento == 3){
//         estatus = 1;
//     }else{
//         estatus = '';
//     }
    
//     if(fechaSeleccionada == '' && banderaEditarEstatus == escritoPorUsuario){
//         banderaSoloEstatus = true ;    
//     }else{
//         fechanoEscrita = true
//         fechaSeleccionada == ''
//     }
//     year = fecha.getFullYear()
//     month = (fecha.getMonth())
//     day = fecha.getDate()
//     // const msg = new day;
//     const FechaEnArreglo = fechaSeleccionada.split("-");
//     // fecha en arreglo es para poder entrar al mes posicion 0 es dia, 1  mes , año
//     fechaComparar = (year + '-' + month + '-' + day);
//     var f1 = new Date(year,month, day);
//     var f2 = new Date(fechaSeleccionada);

//     MesSelecionado = parseInt(FechaEnArreglo[1]);
//     DiaSeleccionado = parseInt(FechaEnArreglo[2]);
//     MesSistemas = parseInt(month+1);
//     // fecha f2 es para la fecha seleccionada 
//     // fecha f1 es para la fecha del sistema 
//     // Se compara las fechas son para 
//     if(  (f2 > f1 || f2 == f1)){
//         // validamos que sea mayor la fecha seleccionada o que sean iguales
//         validacion =true;
//         if(DiaSeleccionado <= 5 && MesSelecionado == MesSistemas ){
//             banderaPagosActivos = 1;
//                         // && MesSelecionado == MesSistemas  
//         }else if(DiaSeleccionado > 5 ||  MesSelecionado >= MesSistemas  ){
//             banderaPagosActivos = 2 ;
//         }else {
//             banderaPagosActivos = 0;
//         }
//     }else if(f2 < f1){
//         alerts.showNotification("top", "right", "Upss, La fecha seleccionada es menor que la fecha actual", "warning");
//         validacion =false;
//     }

//     if(validacion ){


//         mensualidadesC  = document.getElementById("mensualidadesC").value;
//         id_descuento     = document.getElementById("idDescuento").value;
//         monto           = document.getElementById("MontoDescontarCerti").value;
//         pago_individual = document.getElementById("newMensualidades").value;
//         estatus_certificacion  = document.getElementById("certificaciones").value;
    
//             $.ajax({
//             url : 'descuentoUpdateCertificaciones',
//             type : 'POST',
//             dataType: "json",
//             data: {
//             "banderaSoloEstatus"    : banderaSoloEstatus, 
//             "fechaSeleccionada"     : fechaSeleccionada, 
//             "pagos_activos"         : pagos_activos,
//             "estatus"               : estatus,
//             "banderaPagosActivos"   : banderaPagosActivos,
//             "estatus_certificacion" : estatus_certificacion,
//             "id_descuento"          : id_descuento,
//             "monto"                 : monto,
//             "pago_individual"       : pago_individual,
//               }, 
    
//               success: function(data) {
               
//                 alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
//                 document.getElementById('updateDescuento').disabled = false;
//                 $('#tabla-general').DataTable().ajax.reload(null, false );
                
//                 // toastr[response.response_type](response.message);
//                 $('#modalUni').modal('toggle');
//             },              
//             error : (a, b, c) => {
//                 alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
//             }
    
//         });
//     }else{
    
//     }

  
// });



// function setInitialValues() {
//     // BEGIN DATE
//     const fechaInicio = new Date();
//     // Iniciar en este año, este mes, en el día 1
//     const FechaIncial = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
//     // END DATE
//     const fechaFin = new Date();
//     // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
//     const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
//     FechaIncial = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
//     finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
 
 
// }

function limpiarHistorialLogs() {
    var myCommentsList = document.getElementById('lista-comentarios-descuentos');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

}

function open_Mb() {

   
 
    $('#open_Mb').empty();
    $("#FaltaUsuarios").show("slow");
    $("#ListoUsuarios").hide();
    $("#FaltaPuesto").show("slow");
    $("#FaltaMonto").show("slow");
    $("#FaltaDescuento").show("slow");
    $("#FaltaMensualidad").show("slow");
    $("#FaltaMotivo").show("slow");
    
    $("#roles").val('');
    $("#roles").selectpicker("refresh");

    // document.getElementById("users2").innerHTML = '';
   
    $("#usuarioid2").val('');
    $("#usuarioid2").selectpicker("refresh");

    $("#comentario2").val('');

    $('#ModalBonos').modal('show');
}

$('#ModalBonos').on('hidden.bs.modal', function() {
    $('#form_nuevo').trigger('reset');
  

    $("#FaltaPuesto").hide();
    $("#FaltaMonto").hide();
    $("#FaltaDescuento").hide();
    $("#FaltaMensualidad").hide();
    $("#FaltaMotivo").hide();
    $("#FaltaUsuarios").hide();

    $("#ListoPuesto").hide();
    $("#ListoDescuento").hide();
    $("#ListoMensualidad").hide();
    $("#ListoMonto").hide();
    $("#ListoMotivo").hide();
    $("#ListoUsuarios").hide();



    $("#numeroPagos").selectpicker("refresh");
});



$(document).on("click", ".uniAdd", function () {
    let banderaLiquidados = false;
    $("#modalUni").modal();

    document.getElementById("fechaIncial").value = '';

    document.getElementById("descuentoEscrito").value = '';
    // el que modificaremos    
    id_descuento = $(this).attr("data-value");
    //id_usuario perteneciente a ese id_user
    id_user = $(this).attr("data-code");    
    // aqui mero va la bander de saber que info se guardara
    pago_mensual = $(this).attr("data-mensual");
    nombre = $(this).attr("data-nombre")
    descuento = $(this).attr("data-descuento");
    fechaIncial = $(this).attr("data-fecha");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento
    MontoDescontarCerti = $(this).attr("data-value");
    valorCertificacion = $(this).attr("data-idCertificacion");
    // {document.getElementById("certificaciones").value = valorCertificacion;}

    if (descuento == total){
        banderaLiquidados = true;

    }else{

        banderaLiquidados = false;
    }
    descuento = Math.round(descuento);
    pago_mensual = Math.round(pago_mensual);

    cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos

    document.getElementById("fechaIncial").value = fechaIncial;
 
    document.getElementById("banderaLiquidado").value = banderaLiquidados;
    document.getElementById("dineroPagado").value = total;
    document.getElementById("pagoIndiv").value = pago_mensual;
    document.getElementById("idDescuento").value = id_descuento;
    document.getElementById("totalPagos").value = cantidad_de_pagos;
    document.getElementById("pagoDado").value = pagoDado;

    id_user = $(this).attr("data-code");
    pago_mensual = $(this).attr("data-mensual");
    descuento = $(this).attr("data-descuento");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento

    valorPendiente = pendiente;
    // users2
    var titulo  = ' ';
    titulo += '  <h3 id="tituloModalUni" name="tituloModalUni">Editando descuento actual para '+ nombre  +'</h3>';
    // eee
    // var cuerpoModalUni = document.getElementById('cuerpoModalUni');
    // cuerpoModalUni.innerHTML = informacion_adicional;

    document.getElementById("MontoDescontarCerti").value = pendiente;
    var myCommentsLote = document.getElementById('tituloModalUni');
    myCommentsLote.innerHTML = '';

    var Header_modal = document.getElementById('header_modal');
    Header_modal.innerHTML = titulo;
 
    //    mensualidadesFaltantes = total / pago_mensual ;
    //         mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;         
            // if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

            // }else{
            //     if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
            //     {
            //         if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
            //         {
            //             mensualidadesFaltantesMostrar = 1;
            //         }else{

            //         }           
            //     }else{

            //         mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
            //     }
            // }
            // if ((mensualidadesFaltantes % 1)  == 0 ){

            // }else{
            //     if( 0 == Math.trunc(mensualidadesFaltantes))
            //     {
            //         if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
            //         {

            //             mensualidadesFaltantes = 1;
            //         }else{
                    
            //         }
            //     }else{
            //             mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
            //     }
            // }
            // if(banderaLiquidados){
            //     document.getElementById("mensualidadesC").value = 1;
            //     mensualidadesFaltantesMostrar = 1;
            //     mensualidadesFaltantes = 1;
            // }else{
            //     mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;
            //     document.getElementById("mensualidadesC").value = Math.trunc( mensualidadesFaltantesMostrar);
            // }


            // ultimaMensualidad = document.getElementById("mensualidadesC").value
            // Total_a_pagar = ultimaMensualidad * pago_mensual;

            // sobrante = Total_a_pagar - total;

            // //para agregar llo que ya se pago
            // descuentoEscrito = document.getElementById("MontoDescontarCerti").value;
         
            // NuevasMensualidades= (pendiente)  / ultimaMensualidad ;

            // if(banderaLiquidados){

            //     sobrante = document.getElementById("MontoDescontarCerti").value;
            //     sobrante =  total - sobrante ;
            //     NuevasMensualidades = sobrante  / mensualidadesFaltantes;
            // }
            // document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
            // //faltantes = mensualidadesFaltantes/mensual;
            // document.getElementById("precioOrginal").value =   NuevasMensualidades.toFixed(2);

});  

$(document).on("click", "#cancelarOperation", function () {
$('#editDescuento').modal('hide');
});

$('#editDescuento').on("click", "#editarDescuentos", function (){

});
$(document).on("click", "#editarDescuentos", function () {
    $('#botonesInicio').css('display', 'none');
    $('#updateDescuento').css('display', 'block');
    $('#fomularioEditarDescuento').css('display', 'block');
});
$(document).on("click", "#descuentoCertificaciones", function () {

}); 

// Nueva functionalidad
 //  aqui mero 

$("#certificaciones").change(function () {

    pagos  = document.getElementById("numeroDeMensualidades").value ;
    selectCertificacion = document.getElementById("certificaciones").value;

    var comentarioDescrip = document.getElementById('textDescripcion');
    comentarioDescrip.innerHTML = '';
    if(selectCertificacion == 1){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que obtuvo una calificación favorable y con ello la certificación.';
    }else if(selectCertificacion == 2){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que obtuvo una ponderación menor a la deseada y por ende no obtiene la certificación';
    }else if(selectCertificacion == 3){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que al no seguir los lineamientos de la institución evaluadora se le suspende su proceso de certificación. ';
    }else if(selectCertificacion == 4){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que se encuentra por hacer examen final con el Tecnológico de Monterrey.';
    }else if(selectCertificacion == 5){
        comentarioDescrip.innerHTML = 'Personas que está en valoración el que se certifiquen en este año, así que en sus casos hay que dejar activo el pago, porque dependiendo de cómo se desenvuelva cada caso puede ser que aplique incremento.';
        comentarioDescrip.innerHTML = '';
    }else{
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'No definido';
    }
    
});

$(document).on("click", ".editar_descuentos", function () {


});

function subirInfo(){  
    document.getElementById("descuentoEscrito").value = '';
    id_descuento = $(this).attr("data-value");
    id_user = $(this).attr("data-code");    
    // aqui mero va la bander de saber que info se guardara
    pago_mensual = $(this).attr("data-mensual");
    descuento = $(this).attr("data-descuento");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento
    descuento = Math.round(descuento);
    pago_mensual = Ma/th.round(pago_mensual);
    cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos
    document.getElementById("pagado").value = total;
    document.getElementById("mensualidad").value = pago_mensual;
    document.getElementById("descuento_id").value = id_descuento;
    document.getElementById("pagoDado").value = dineroPagado;
    valor = 0;
    valor1 = 0;
 }
 
$(document).on('input', '.MontoDescontarCerti', function(){

    mensualidadesC = document.getElementById("mensualidadesC").value;
    pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
    loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
    pagos  = document.getElementById("mensualidadesC").value ;
    banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
    if(banderaLiquidado){
     

        NuevasMensualidades = loQueSedebe / pagos;
    }else{

        NuevasMensualidades = loQueSedebe / pagos;   
    }

    document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
});

// $("#numeroPagos").change(function () {
    $(document).on('change', '#mensualidadesC', function() {

        mensualidadesC = document.getElementById("mensualidadesC").value;
        loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
        pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
        pagos  = document.getElementById("mensualidadesC").value ;
        console.log('mensualidadesC')
        console.log(mensualidadesC)
        console.log('loQueSedebe')
        console.log(loQueSedebe)
        console.log('pagado')
        console.log(pagado)
        console.log('pagos')
        console.log(pagos)

        banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
        if(banderaLiquidado){
          
            NuevasMensualidades = loQueSedebe / mensualidadesC;
  
        }else{
         
            NuevasMensualidades = loQueSedebe / mensualidadesC;
        } 
        document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
    });
                                                          
    $("#updateDescuentoCertificado").submit(function (e) {


        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

    let tipoDescuento = $('#tipo_descuento').val();
    // let fechaSeleccionada = $('#fechaIncial').val();
    const fecha = new Date()    
    let pagos_activos ;
    let banderaSoloEstatus = false ; 
    let banderaPagosActivos = 0 ;
    // bandera pagos activos
    let fechanoEscrita = false; 
    // 1 fecha usuario < día 5  mismo mes  2: fecha usuario > día 5 y > mes actual  3: no se mueve los movimientos actuales,
    let validacion = false;
    let banderaEditarEstatus = document.getElementById("precioOrginal").value; 
    let escritoPorUsuario = document.getElementById("newMensualidades").value;
    let fechaSeleccionada = '';
    fechaSeleccionada = document.getElementById("fechaIncial").value;

    if(tipoDescuento == 3){
        estatus = 1;
    }else{
        estatus = '';
    }
    
    if(fechaSeleccionada == '' && banderaEditarEstatus == escritoPorUsuario){
        banderaSoloEstatus = true ;    
    }else{
        fechanoEscrita = true
        fechaSeleccionada == ''
    }
    year = fecha.getFullYear()
    month = (fecha.getMonth())
    day = fecha.getDate()
    // const msg = new day;
    const FechaEnArreglo = fechaSeleccionada.split("/");
    // fecha en arreglo es para poder entrar al mes posicion 0 es dia, 1  mes , año
    fechaComparar = (year + '-' + month + '-' + day);
    var f1 = new Date(year,month, day);
    var f2 = new Date(FechaEnArreglo[2],FechaEnArreglo[1],FechaEnArreglo[0] );

    MesSelecionado = parseInt(FechaEnArreglo[1]);
    DiaSeleccionado = parseInt(FechaEnArreglo[0]);
    MesSistemas = parseInt(month+1);
    console.log(FechaEnArreglo)
    console.log('  // fecha FechaEnArreglo ')
    // fecha f2 es para la fecha seleccionada 
    // fecha f1 es para la fecha del sistema 
    // Se compara las fechas son para 
    console.log(f1)
    console.log('  // fecha f1 es para la fecha del sistema ')
    console.log(f2)
    console.log('fecha f2 es para la fecha seleccionada ')
    if(  (f2 > f1 || f2 == f1)){
        // validamos que sea mayor la fecha seleccionada o que sean iguales
      
        if(DiaSeleccionado <= 10 ){
            banderaPagosActivos = 1;
            console.log(1)
            validacion =true;
                        // && MesSelecionado == MesSistemas  
        }else if(DiaSeleccionado  <= 10  ){
            banderaPagosActivos = 2 ;
            console.log(1)
            validacion =true;
        }else {
            alerts.showNotification("top", "right", "Se recomienda una fecha entre el primero al 10 de cada mes ", "info");
            banderaPagosActivos = 0;
        }
    }else if(f2 < f1){
        alerts.showNotification("top", "right", "Upss, La fecha seleccionada es menor que la fecha actual", "warning");
        validacion =false;
    }

    if(validacion ){


        mensualidadesC  = document.getElementById("mensualidadesC").value;
        id_descuento     = document.getElementById("idDescuento").value;
        monto           = document.getElementById("MontoDescontarCerti").value;
        pago_individual = document.getElementById("newMensualidades").value;
        // estatus_certificacion  = document.getElementById("certificaciones").value;
    
            $.ajax({
            url : 'descuentoUpdateCertificaciones',
            type : 'POST',
            dataType: "json",
            data: {
            "banderaSoloEstatus"    : banderaSoloEstatus, 
            "fechaSeleccionada"     : fechaSeleccionada, 
            "pagos_activos"         : pagos_activos,
            "estatus"               : estatus,
            "banderaPagosActivos"   : banderaPagosActivos,
            "id_descuento"          : id_descuento,
            "monto"                 : monto,
            "pago_individual"       : pago_individual,
              }, 
    
              success: function(data) {
               
                alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
                document.getElementById('updateDescuento').disabled = false;
                $('#tabla-general').DataTable().ajax.reload(null, false );
                
                // toastr[response.response_type](response.message);
                $('#modalUni').modal('toggle');
            },              
            error : (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }
    
        });
    }else{
    
    }

  
}});


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
function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const FechaIncial = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    FechaIncial = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
 
 
}

 
