var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";
var tr;
let tablaGeneral;
let titulosTablaGeneral = [];
// sp.initFormExtendedDatetimepickers();

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
$(document).ready(function() {  

    sp.initFormExtendedDatetimepickers();
        var endDt = moment().format('DD/MM/YYYY');


        $('.fechaIncial').val(endDt);
    $('#tabla-general thead tr:eq(0) th').each(function (i) {
        if (i !== 15) {
            const title = $(this).text();
            titulosTablaGeneral.push(title);
 
            $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tablaGeneral.column(i).search() !== this.value) {
                    tablaGeneral.column(i).search(this.value).draw();

                    let totalDescuento = 0;
                    let totalAbonado = 0;
                    let totalPendiente = 0;
                    const index = tablaGeneral.rows({selected: true, search: 'applied'}).indexes();
                    const data = tablaGeneral.rows(index).data();

                    $.each(data, function (i, v) {
                        totalDescuento += parseFloat(v.monto);

                        if (v.aply == null || v.aply <= 1) {
                            totalAbonado += parseFloat(v.pagado_caja);
                        } else {
                            totalAbonado += parseFloat(v.aply);
                        }
                        totalPendiente += parseFloat(v.monto - v.aply);


                    });

                    const tipoDescuento = $('#tipo_descuento').val();
                    document.getElementById(getInputTotalId(tipoDescuento)).value = formatMoney(totalDescuento);

                    document.getElementById(getInputAbonadoId(tipoDescuento)).value = formatMoney(totalAbonado);

                    document.getElementById(getInputPendienteId(tipoDescuento)).value = formatMoney(totalPendiente);
                }
            });
        }
    })

    checkTypeOfDesc();
    general();
});

function checkTypeOfDesc() {
    const tipoDescuento = $('#tipo_descuento').val();

    if (tipoDescuento === '1') {
        $('#title-activo').css('display', 'block');
        $('#title-baja').css('display', 'none');
        $('#title-liquidado').css('display', 'none');
        $('#title-conglomerado').css('display', 'none');
    } else if (tipoDescuento === '2') {
        $('#title-activo').css('display', 'none');
        $('#title-baja').css('display', 'block');
        $('#title-liquidado').css('display', 'none');
        $('#title-conglomerado').css('display', 'none');
    } else if (tipoDescuento === '3') {
        $('#title-activo').css('display', 'none');
        $('#title-baja').css('display', 'none');
        $('#title-liquidado').css('display', 'block');
        $('#title-conglomerado').css('display', 'none');
    } else if(tipoDescuento === '4') {
        $('#title-activo').css('display', 'none');
        $('#title-baja').css('display', 'none');
        $('#title-liquidado').css('display', 'none');
        $('#title-conglomerado').css('display', 'block');
    }

    loadTable(tipoDescuento);
}

function loadTable(tipoDescuento) {
    $('#tabla-general').ready(function () {
        $('#tabla-general').on('xhr.dt', function (e, settings, json, xhr) {
            let total = 0;
            let abonado = 0;
            let pendiente = 0;
            $.each(json.data, function (i, v) {
                total += parseFloat(v.monto);

                if (v.aply == null || v.aply <= 1) {
                    abonado += parseFloat(v.pagado_caja);
                } else {
                    abonado += parseFloat(v.aply);
                }

                pendiente += parseFloat(v.monto - v.aply);



            });
            document.getElementById(getInputTotalId(tipoDescuento)).value = formatMoney(total);
            document.getElementById(getInputAbonadoId(tipoDescuento)).value = formatMoney(abonado);
            document.getElementById(getInputPendienteId(tipoDescuento)).value = formatMoney(pendiente);
        });

        tablaGeneral = $('#tabla-general').DataTable({
            dom: 'Brt' + "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "buttons": [
                {
                    text: '<i class="fa fa-edit" id="btn-nuevo-descuento"></i> NUEVO DESCUENTO',
                    action: function () {
                        if (tipoDescuento === '1') {
                            open_Mb();
                        }
                    },
                    attr: {
                        class: ' btn-azure'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'buttons-excel',
                    titleAttr: 'DESCUENTOS UNIVERSIDAD',
                    title: 'DESCUENTOS UNIVERSIDAD',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,13,14],
                        format: {
                            header: function (d, columnIndex) {
                                return ' ' + titulosTablaGeneral[columnIndex] + ' ';
                            }
                        }
                    }
                }
            ],
            "width": 'auto',
            "ordering": false,
            "destroy": true,
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            language: {
                url: "./..//static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            scrollX: true,
            pagingType: "full_numbers",
            "columns": [
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
                        if (d.id_sede == 6) {
                            if (d.abono_nuevo < 15000) {
                                return `<p style="font-size: 1em; color:gray">$${formatMoney(d.abono_nuevo)}</p>`;
                            } else {
                                return `<p style="font-size: 1em; color:blue"><b>$${formatMoney(d.abono_nuevo)}</b></p>`;
                            }

                        }
                        if (d.abono_nuevo < 12500) {
                            return `<p style="font-size: 1em; color:gray">$${formatMoney(d.abono_nuevo)}</p>`;
                        } else {
                            return `<p style="font-size: 1em; color:blue"><b>$${formatMoney(d.abono_nuevo)}</b></p>`;
                        }
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
                        if (d.aply == null || d.aply <= 1) {
                            return `<p style="font-size: 1em">$${formatMoney(d.pagado_caja)}</p>`;
                        } else {
                            return `<p style="font-size: 1em">$${formatMoney(d.aply)}</p>`;
                        }
                    }
                },
                {
                    // Pendiente general
                    "data": function (d) {
                        let pendiente = parseFloat(d.monto - d.aply);
                        return `<p style="font-size: 1em; color:gray">$${formatMoney(pendiente)}</p>`;
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
                        const primerDescuento = (d.no_descuentos == 1) ? '<br><div style="margin-top: 5px;"><span class="label" style="background:deepskyblue;">PRIMER DESCUENTO</span></div>' : '';

                        const baja = (d.status == 0 || d.status == 3) ? '<br><div style="margin-top: 5px;"><span class="label" style="background:red;">BAJA</span></div>' : '';

                        // if ((d.status == 0 || d.status == 3 ) && (d.estatus != 2 && d.estatus != 3 && d.estatus != 4) ) {
                        //     const Baja = `<span class="label" style="background:red;">BAJA</span>`;
                        // }

                        if (d.id_sede == 6) {
                            if (d.abono_nuevo < 15000) {
                                $RES = 0;
                            } else {
                                $RES = 1;
                            }
                        } else if (d.abono_nuevo < 12500) {
                            $RES = 0;
                        } else {
                            $RES = 1;
                        }

                        switch (d.estatus) {
                            case '0':
                                if ($RES == 0) {
                                    return `<span class="label" style="background:#7F8C8D;">SIN SALDO *</span>${primerDescuento}${baja}`;
                                }
                                return `<span class="label" style="background:#9B59B6;">DISPONIBLE</span>${primerDescuento}`;
                            case '1':
                                if (d.pagos_activos == 0){
                                    return `<span class="label" style="background:#7F8C8D;">REACTIVADO</span>${primerDescuento}${baja}`;
                                }
                                if ($RES == 0){
                                    return `<span class="label" style="background:#7F8C8D;">SIN SALDO *</span>${primerDescuento}${baja}`;
                                }
                                return `<span class="label" style="background:#9B59B6;">DISPONIBLE</span>${primerDescuento}${baja}`;

                            case '2':
                                return `<span class="label" style="background:green;">DESCUENTO APLICADO</span>${primerDescuento}${baja}`;

                            case '3':
                                return `<span class="label" style="background:#95A5A6;">LIQUIDADO EN CAJA</span>${primerDescuento}${baja}`;

                            case '4':
                                return `<span class="label" style="background:#34495E;">LIQUIDADO</span>${primerDescuento}${baja}`;

                            case '5':
                                return `<span class="label" style="background:#7F8C8D;">REACTIVADO</span>${primerDescuento}${baja}`;

                            default:
                                 return `<span class="label" style="background:#7F8C8D;">REACTIVADO</span>${primerDescuento}${baja}`;
                        }
                    }
                },
                {
                    // Pendiente mes
                    "data": function (d) {
                        const OK = parseFloat(d.pago_individual * d.pagos_activos);
                        const OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }

                        if (OP2 < 1) {
                            return `<p style="font-size: 1em; color:gray">$${formatMoney(0)}</p>`;
                        }
                        return `<p style="font-size: 1em; color:red"><b>$${formatMoney(OP2)}</b></p>`;
                    }
                },
                {
                    // Disponible desc
                    "data": function (d) {
                        let validar = 0;
                        const OK = parseFloat(d.pago_individual * d.pagos_activos);
                        const OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }

                        if (OP2 < 1) {
                            respuesta = 0;

                        } else if (d.id_sede == 6) {
                            if (d.abono_nuevo < 15000) {
                                respuesta = 0;
                            } else {

                                validar = Math.trunc(d.abono_nuevo / 15000);

                                if (validar >= d.pagos_activos) {
                                    validar = d.pagos_activos;
                                    respuesta = OP2;
                                } else {
                                    respuesta = validar * d.pago_individual;
                                }
                            }
                        } else {
                            if (d.abono_nuevo < 12500) {
                                respuesta = 0;
                            } else {

                                validar = Math.trunc(d.abono_nuevo / 12500);

                                if (validar >= d.pagos_activos) {
                                    validar = d.pagos_activos;
                                    respuesta = OP2;
                                } else {

                                    if((validar * d.pago_individual)>(d.monto - d.aply)){
                                        respuesta = (d.monto - d.aply);
                                    
                                    }else{
                                        respuesta = (validar * d.pago_individual);
                                    
                                }
                                }

                            }
                        }

                        return '<p style="font-size: 1em; color:gray"><b>$' + formatMoney(respuesta) + '</b></p>';
                    }
                },
                {
                    // Fecha primer descuento
                    "data": function (d) {
                        return `<p style="font-size: 1em">${(d.fecha_mov_1) ? d.fecha_mov_1 : ''}</p>`;
                    }
                },
                {
                    // Fecha creación
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.fecha_creacion + '</p>';
                    }
                },
                {
                    "data": function (d) {
                        if(d.certificacion ==  null || d.certificacion == ''){
                            return '<p style="font-size: 1em; color:gray"><b> SIN DEFINIR</b></p>';

                        }else{
                            
                            return '<span class="label label-warning" style="background:' + d.colorCertificacion + ';"> '+ d.certificacion +' </span>';
                        }
                    }
                },
                // {
                //     // Acciones
                //     "data": function (d) {
                //         const btnEliminarEditar = ((d.estatus == 1 || d.estatus == 2 || d.estatus == 5)
                //             && d.no_descuentos == 0 && d.pagado_caja == 0 && d.status == 1)
                //             ? `<button class="btn-data btn-warning btn-eliminar-descuento"
                //                 value="${d.id_descuento}">
                //                 <i class="fa fa-trash"></i>
                //                </button>
                //                <button class="btn-data btn-green btn-editar-descuento"
                //                 value="${d.id_descuento}">
                //                 <i class="fa fa-edit"></i>
                //                </button>`
                //             : '';

                //         if (d.estatus == 0) {
                //             return `
                //                     <div class="d-flex justify-center">
                //                         <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                             title="Detalles">
                //                                 <i class="fas fa-info-circle"></i>
                //                         </button>
                //                         <button value="${d.id_usuario}"
                //                             class="btn-data btn-violetDeep activar-prestamo"
                //                             title="Activar">
                //                             <i class="fa fa-rotate-left"></i>
                //                         </button>
                //                     </div>
                //                 `;
                //         } else if ((d.estatus == 1 || d.estatus == 5) && d.pagos_activos == 0) {
                //             return `
                //                     <div class="d-flex justify-center">
                //                         <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                             title="Detalles">
                //                                 <i class="fas fa-info-circle"></i>
                //                         </button>${btnEliminarEditar}
                //                     </div>
                //                 `;
                //         } else if (tipoDescuento === '2' || tipoDescuento === '3') {
                //             return `
                //                 <div class="d-flex justify-center">
                //                     <button value="${d.id_usuario}"
                //                         data-value="${d.nombre}"
                //                         data-code="${d.id_usuario}"
                //                         class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                         title="Detalles">
                //                             <span class="fas fa-info-circle"></span>
                //                     </button>
                //                     <button value="${d.id_usuario}"
                //                         data-value="${d.nombre}"
                //                         data-code="${d.id_usuario}"
                //                         class="btn-data btn-gray consultar_historial_pagos"
                //                         title="Historial pagos">
                //                             <i class="fas fa-chart-bar"></i>
                //                     </button>${btnEliminarEditar}
                //                 </div>`;
                //         }

                //         let tipo_descuento = d.queryType;
                //         if(tipo_descuento == 2){
                //             return `
                //                 <div class="d-flex justify-center">
                //                     <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                             title="Detalles">
                //                                 <span class="fas fa-info-circle"></span>
                //                     </button>
                //                     <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                             title="editarDescuento">
                //                                 <span class="fas fa-info-circle"></span>
                //                     </button>${btnEliminarEditar}
                //                 </div>`;
                //         } else if(tipo_descuento == 1 ){
                //             if (d.status == 0) {
                //                 let pendiente = parseFloat(d.monto - d.aply);
                //                 if(pendiente < 0 ){
                //                    actividad =  (pendiente * -1);
                //                 }
                //                 let total ;
                //                 if(d.aply == null || d.aply <= 1){
                //                     total = d.pagado_caja;
                //                 } else {
                //                     total = d.aply;
                //                 }
                //                 return `
                //                     <div class="d-flex justify-center">
                //                         <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                             title="Detalles">
                //                             <i class="fas fa-info-circle"></i>
                //                         </button>
                                        
                //                         <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-darkMaderas consultar_historial_pagos"
                //                             title="Historial pagos">
                //                             <i class="fas fa-chart-bar"></i>
                //                         </button>
                //                         </button>
                //                         <button value="${d.id_usuario}"
                //                          data-value="${d.id_descuento}"
                //                          data-code="${d.id_usuario}"
                //                          data-descuento="${d.monto}"
                //                          data-mensual="${d.pago_individual}"
                //                          data-pendiente="${pendiente}"
                //                          data-total="${total}"
                //                          class="btn-data btn-violetBoots editar_descuentos"
                //                          title="Cambiar descuentos">
                //                          <i class="fas fa-money-check-alt"></i>
                //                      </button>
                //                         <button value="${d.id_usuario}"
                //                             data-value="${d.nombre}"
                //                             data-code="${d.id_usuario}"
                //                             class="btn-data btn-darkMaderas pagos"
                //                             title="Editar descuento">
                //                             <i class="fa-duotone fa-money-check-dollar-pen"></i>
                //                         </button>${btnEliminarEditar}
                //                     </div>`;

                //             } else {
                //                 OK = parseFloat(d.pago_individual * d.pagos_activos);
                //                 OP = parseFloat(d.monto - d.aply);

                //                 if (OK > OP) {
                //                     pend = OP;
                //                 } else {
                //                     pend = OK;
                //                 }


                //                 if (d.estatus == 2 || d.estatus == 3 || d.estatus == 4 || d.status == 3) {
                //                     BOTON = 0;
                //                 } else if (pend > 0) {
                //                     if (d.id_sede == 6) {
                //                         if (d.abono_nuevo < 15000) {
                //                             BOTON = 0;
                //                         } else {
                //                             validar = Math.trunc(d.abono_nuevo / 15000);
                //                             if (validar >= d.pagos_activos) {
                //                                 validar = d.pagos_activos;
                //                                 pendiente = pend;
                //                             } else {
                //                                 pendiente = (validar * d.pago_individual);
                //                             }
                //                             BOTON = 1;
                //                         }
                //                     } else if (d.abono_nuevo < 12500) {
                //                         BOTON = 0;
                //                     } else {
                //                         validar = Math.trunc(d.abono_nuevo / 12500);
                //                         if (validar >= d.pagos_activos) {
                //                             validar = d.pagos_activos;
                //                             pendiente = pend;
                //                         } else {
                //                             // pendiente = (validar * d.pago_individual);
                //                             if((validar * d.pago_individual)>(d.monto - d.aply)){
                //                                 pendiente = (d.monto - d.aply);
                //                             }else{
                //                                 pendiente = (validar * d.pago_individual);
                //                             }
                //                         }
                //                         BOTON = 1;
                //                     }
                //                 } else {
                //                     BOTON = 0;
                //                 }

                //                 if (BOTON == 0) {
                //                     let pendiente = parseFloat(d.monto - d.aply);
                //                     if(pendiente < 0 ){
                //                        actividad =  (pendiente * -1);
                //                     }
                //                     let total ;
                //                     if(d.aply == null || d.aply <= 1){
                //                         total = d.pagado_caja;
                //                     } else {
                //                         total = d.aply;
                //                     }
                                    
                //                     return `
                //                         <div class="d-flex justify-center">
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${d.nombre}"
                //                                 data-code="${d.id_usuario}"
                //                                 class="btn-data btn-blueMaderas consultar_logs_asimilados"
                //                                 title="Detalles">
                //                                 <span class="fas fa-info-circle"></span>
                //                             </button>
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${d.aply}"
                //                                 data-code="${d.id_usuario}"
                //                                 class="btn-data btn-orangeYellow topar_descuentos"
                //                                 title="Detener descuentos">
                //                                 <i class="fas fa-money"></i>
                //                             </button>
                //                                <button value="${d.id_usuario}"
                //                                 data-value="${d.id_descuento}"
                //                                 data-code="${d.id_usuario}"
                //                                 data-descuento="${d.monto}"
                //                                 data-mensual="${d.pago_individual}"
                //                                 data-pendiente="${pendiente}"
                //                                 data-total="${total}"
                //                                 class="btn-data btn-violetBoots editar_descuentos"
                //                                 title="Cambiar descuentos">
                //                                 <i class="fas fa-money-check-alt"></i>
                //                             </button>
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${d.nombre}"
                //                                 data-code="${d.id_usuario}"
                                               
                //                                 class="btn-data btn-gray consultar_historial_pagos"
                //                                 title="Historial pagos">
                                              
                //                                 <i class="fas fa-chart-bar"></i>
                //                             </button>${btnEliminarEditar}
                //                         </div>`;
                //                 } else if (d.estatus == 5) {
                //                     let pendiente = parseFloat(d.monto - d.aply);
                //                     if(pendiente < 0 ){
                //                        actividad =  (pendiente * -1);
                //                     }
                //                     let total ;
                //                     if(d.aply == null || d.aply <= 1){
                //                         total = d.pagado_caja;
                //                     } else {
                //                         total = d.aply;
                //                     }
                //                     return `
                //                         <div class="d-flex justify-center">
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${d.nombre}"
                //                                 data-code="${d.id_usuario}"
                //                                 class="btn-data btn-gray consultar_historial_pagos"
                //                                 title="Historial pagos">
                //                                 <i class="fas fa-chart-bar"></i>
                //                             </button>${btnEliminarEditar}
                //                             </button>
                //                             <button value="${d.id_usuario}"
                //                              data-value="${d.id_descuento}"
                //                              data-code="${d.id_usuario}"
                //                              data-descuento="${d.monto}"
                //                              data-mensual="${d.pago_individual}"
                //                              data-pendiente="${pendiente}"
                //                              data-total="${total}"
                //                              class="btn-data btn-violetBoots editar_descuentos"
                //                              title="Cambiar descuentos">
                //                              <i class="fas fa-money-check-alt"></i>
                //                             </button>    
                //                         </div>
                //                         `;
                //                 } else {
                //                     let pendiente = parseFloat(d.monto - d.aply);
                //                     if(pendiente < 0 ){
                //                        actividad =  (pendiente * -1);
                //                     }
                //                     let total ;
                //                     if(d.aply == null || d.aply <= 1){
                //                         total = d.pagado_caja;
                //                     } else {
                //                         total = d.aply;
                //                     }
                //                     return `
                //                         <div class="d-flex justify-center">
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${pendiente}"
                //                                 data-saldoCom="${d.abono_nuevo}"
                //                                 data-sede="${d.id_sede}"
                //                                 data-validate="${validar}"
                //                                 data-code="${d.cbbtton}"
                //                                 class="btn-data btn-violetDeep agregar_nuevo_descuento"
                //                                 title="Aplicar descuento">
                //                                 <i class="fas fa-plus"></i>
                //                             </button>
                //                             </button>
                //                             <button value="${d.id_usuario}"
                //                              data-value="${d.id_descuento}"
                //                              data-code="${d.id_usuario}"
                //                              data-descuento="${d.monto}"
                //                              data-mensual="${d.pago_individual}"
                //                              data-pendiente="${pendiente}"
                //                              data-total="${total}"
                //                              class="btn-data btn-violetBoots editar_descuentos"
                //                              title="Cambiar descuentos">
                //                              <i class="fas fa-money-check-alt"></i>
                //                          </button>
                //                             <button value="${d.id_usuario}"
                //                                 data-value="${d.nombre}"
                //                                 data-code="${d.id_usuario}"
                //                                 class="btn-data btn-gray consultar_historial_pagos"
                //                                 title="Historial pagos">
                //                                 <i class="fas fa-chart-bar"></i>
                //                             </button>${btnEliminarEditar}
                //                         </div>`
                //                 }
                //             }
                //         }
                //     }
                // }],

                {
                        // Acciones
                        "data": function (d) {
                            let valor = ''; 
                            if(d.aply == null || d.aply <= 1){
                                total = d.pagado_caja;
                            } else {
                                total = d.aply;
                            }
                   
                            if(d.idCertificacion == null )
                            {
                                // document.getElementById("certificaciones").value = '0';
                                valor = 0
                            }else{
                               
                                // document.getElementById("certificaciones").value = d.idCertificacion;
                                valor = d.idCertificacion
                            }

                            let pendientes = parseFloat(d.monto - d.aply);
                            if(pendientes < 0 ){
                               actividad =  (pendientes * -1);
                            }
                            if (d.estatusDU == 0) {
                                return `
                                        <div class="d-flex justify-center">
                                            <button value="${d.id_usuario}"
                                                data-value="${d.nombre}"
                                                data-code="${d.id_usuario}"
                                                class="btn-data btn-blueMaderas consultar_logs_asimilados"
                                                title="Detalles">
                                                    <i class="fas fa-info-circle"></i>
                                            </button>
                                            <button value="${d.id_usuario}"
                                                class="btn-data btn-violetDeep activar-prestamo"
                                                title="Activar">
                                                <i class="fa fa-rotate-left"></i>
                                            </button>
                                        </div>
                                        <button value="${d.id_usuario}"
                                            data-code="${d.id_usuario}"
                                            data-nombre="${d.nombre}"
                                            data-value="${d.id_descuento}"
                                            data-code="${d.id_usuario}"
                                            data-descuento="${d.monto}"
                                            data-mensual="${d.pago_individual}"
                                            data-pendiente="${pendientes}"
                                            data-idCertificacion="${valor}"
                                            data-total="${total}"
                                            class="btn-data btn-acidGreen uniAdd"
                                            title="Editar suficiente">
                                            <i class="fas fa-money-check-alt"></i>
                                        </button>
                                    `;
                            } else if ((d.estatusDU == 1 || d.estatusDU == 5) && d.pagos_activos == 0) {
                                return `
                                        <div class="d-flex justify-center">
                                            <button value="${d.id_usuario}"
                                                data-value="${d.nombre}"
                                                data-code="${d.id_usuario}"
                                                class="btn-data btn-blueMaderas consultar_logs_asimilados"
                                                title="Detalles">
                                                    <i class="fas fa-info-circle"></i>
                                            </button>
                                            
                                        </div>
                                    `;
                            } else if (tipoDescuento === '2' || tipoDescuento === '3') {

                                  // aqui podemos ponerles 
                                  let total ;
                                  if(d.aply == null || d.aply <= 1){
                                      total = d.pagado_caja;
                                  } else {
                                      total = d.aply;
                                  }
                                  let pendientes = parseFloat(d.monto - d.aply);
                                  if(pendientes < 0 ){
                                     actividad =  (pendientes * -1);
                                  }

                                return `
                                    <div class="d-flex justify-center">
                                        <button value="${d.id_usuario}"
                                            data-value="${d.nombre}"
                                            data-code="${d.id_usuario}"
                                            class="btn-data btn-blueMaderas consultar_logs_asimilados"
                                            title="Detalles">
                                                <span class="fas fa-info-circle"></span>
                                        </button>
                                        <button value="${d.id_usuario}"
                                            data-value="${d.nombre}"
                                            data-code="${d.id_usuario}"
                                            title="Historial pagos"
                                            class="btn-data btn-gray consultar_historial_pagos">
                                                <i class="fas fa-chart-bar"></i>
                                        </button>
                                        <button value="${d.id_usuario}"
                                            data-code="${d.id_usuario}"
                                            data-nombre="${d.nombre}"
                                            data-value="${d.id_descuento}"
                                            data-code="${d.id_usuario}"
                                            data-descuento="${d.monto}"
                                            data-mensual="${d.pago_individual}"
                                            data-pendiente="${pendientes}"
                                            data-total="${total}"
                                            data-idCertificacion="${valor}"
                                            class="btn-data btn-acidGreen uniAdd"
                                            title="Editar suficiente">
                                            <i class="fas fa-money-check-alt"></i>
                                        </button>
                                    </div>`;
                            }

                            let tipo_descuento = d.queryType;
                            if(tipo_descuento == 2){
                                return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<span class="fas fa-info-circle"></span></button></div>';
                            } else if(tipo_descuento == 1 ){
                                if (d.status == 0) {
                                    return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<i class="fas fa-info-circle"></i></button>'+
                                        '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-darkMaderas consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button></div>';

                                } else {
                                    OK = parseFloat(d.pago_individual * d.pagos_activos);
                                    OP = parseFloat(d.monto - d.aply);

                                    if (OK > OP) {
                                        pend = OP;
                                    } else {
                                        pend = OK;
                                    }


                                    if (d.estatus == 2 || d.estatus == 3 || d.estatus == 4 || d.status == 3) {
                                        BOTON = 0;
                                    } else if (pend > 0) {
                                        if (d.id_sede == 6) {
                                            if (d.abono_nuevo < 15000) {
                                                BOTON = 0;
                                            } else {
                                                validar = Math.trunc(d.abono_nuevo / 15000);
                                                if (validar >= d.pagos_activos) {
                                                    validar = d.pagos_activos;
                                                    pendiente = pend;
                                                } else {
                                                    pendiente = (validar * d.pago_individual);
                                                }
                                                BOTON = 1;
                                            }
                                        } else if (d.abono_nuevo < 12500) {
                                            BOTON = 0;
                                        } else {
                                            validar = Math.trunc(d.abono_nuevo / 12500);
                                            if (validar >= d.pagos_activos) {
                                                validar = d.pagos_activos;
                                                pendiente = pend;
                                            } else {
                                                pendiente = (validar * d.pago_individual);
                                            }
                                            BOTON = 1;
                                        }
                                    } else {
                                        BOTON = 0;
                                    }

                                    if (BOTON == 0) {
                                        return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<span class="fas fa-info-circle"></span></button><button href="#" value="' + d.id_usuario + '" data-value="' + d.aply + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-orangeYellow topar_descuentos" title="Detener descuentos">' + '<i class="fas fa-money"></i></button>'+
                                        '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-gray consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button> '+
                                        '<button value="'+d.id_usuario+'"  data-code="'+d.id_usuario+'" data-nombre="'+d.nombre+'" data-value="'+d.id_descuento+'"  data-code="'+d.id_usuario+'" data-descuento="'+d.monto+'" data-mensual="'+d.pago_individual+'" data-pendiente="'+pendientes+'" data-total="'+total+'" class="btn-data btn-acidGreen uniAdd"      data-idCertificacion="'+valor+'"  title="Editar suficiente"> <i class="fas fa-money-check-alt"></i> </button>' +
                                        
                                        ' </div>';
                                    } else {
                                        return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + pendiente + '"  ' +
                                        'data-saldoCom="'+d.abono_nuevo+'" data-sede="' + d.id_sede + '" data-validate="' + validar + '" data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-violetDeep agregar_nuevo_descuento"  title="Aplicar descuento">' + '<i class="fas fa-plus"></i></button>'+
                                        '<button value="'+d.id_usuario+'"  data-code="'+d.id_usuario+'" data-nombre="'+d.nombre+'" data-value="'+d.id_descuento+'"  data-code="'+d.id_usuario+'" data-descuento="'+d.monto+'" data-mensual="'+d.pago_individual+'" data-pendiente="'+pendientes+'" data-total="'+total+'" class="btn-data btn-acidGreen uniAdd" data-idCertificacion="'+valor+'" title="Editar suficiente"> <i class="fas fa-money-check-alt"></i> </button>' +
                                        '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-gray consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button></div>';
                                        
                                    }
                                }
                            }
                        }
                    }],
                    
            "ajax": {
                "url": `getDataConglomerado/${tipoDescuento}`,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });
        $(document).on("click", ".editar_descuentos", function () {
            $("#editDescuento").modal();
            document.getElementById("fechaIncial").value = ' ';
            document.getElementById("descuento1").value = '';
            id_descuento = $(this).attr("data-value");
            id_user = $(this).attr("data-code");
            pago_mensual = $(this).attr("data-mensual");
            descuento = $(this).attr("data-descuento");
            pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
            total = $(this).attr("data-total"); //dinero que ha pagado al momento
            descuento = Math.round(descuento);
            pago_mensual = Math.round(pago_mensual);
            cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos
            document.getElementById("pagado").value = total;
            document.getElementById("mensualidad").value = pago_mensual;
            document.getElementById("descuento_id").value = id_descuento;
            document.getElementById("total_pagos").value = cantidad_de_pagos;
            valor = 0;
            valor1 = 0;
       
            mensualidadesFaltantes = descuento / pago_mensual ;
            mensualidadesFaltantesMostrar = pendiente / pago_mensual ;
           
            document.getElementById("descuento1").value = descuento;
            
            if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

            }else{
                if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
                {
                    if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
                    {
                     
                        mensualidadesFaltantesMostrar = 1;
                    }else{
                     
                    }
           
                }else{
                    mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
                }
               // mensualidadesFaltantes
            }
            if ((mensualidadesFaltantes % 1)  == 0 ){

            }else{
                if( 0 == Math.trunc(mensualidadesFaltantes))
                {
                    if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
                    {
                        mensualidadesFaltantes = 1;
                    }else{
                    }
                }else{
                        mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
                }
               // mensualidadesFaltantes
            }
         
            document.getElementById("numeroPagos1").value = Math.trunc( mensualidadesFaltantesMostrar);
        
            Total_a_pagar = mensualidadesFaltantes * pago_mensual;
            
            
            sobrante = Total_a_pagar - total;
            //para agregar llo que ya se pago
            NuevasMensualidades = sobrante  / mensualidadesFaltantes;

            document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);

            //faltantes = mensualidadesFaltantes/mensual;
            
        });
        $('#numeroPagos1').change(function () {
            total_pagos = document.getElementById("total_pagos").value ;
            actualess = document.getElementById("actualess").value ;
            totalmeses = document.getElementById("totalmeses").value ;
            cuanto = document.getElementById("cuanto").value ;
            mensualidad = document.getElementById("mensualidad").value ;
            pagado = document.getElementById("pagado").value ;  // lo que se ya se ha pagado
            loQueSedebe  = document.getElementById("descuento1").value ;
            pagos  = document.getElementById("numeroPagos1").value ;
            loQueSedebe = loQueSedebe - pagado;
            NuevasMensualidades = loQueSedebe / pagos;

            

            
            document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);
            

        
        });

        $(document).on('input', '.descuento1', function(){
            total_pagos = document.getElementById("total_pagos").value ;
            actualess = document.getElementById("actualess").value ;
            totalmeses = document.getElementById("totalmeses").value ;
            cuanto = document.getElementById("cuanto").value ;
            mensualidad = document.getElementById("mensualidad").value ;
            pagado = document.getElementById("pagado").value ;  // lo que se ya se ha pagado
            loQueSedebe  = document.getElementById("descuento1").value ;
            pagos  = document.getElementById("numeroPagos1").value ;

            loQueSedebe = loQueSedebe - pagado;
            NuevasMensualidades = loQueSedebe / pagos;
            document.getElementById("pago_ind011").value = Math.trunc( NuevasMensualidades);
            

          
        });
     
     
        $(document).on("click", ".updateDescuento", function () {
            document.getElementById('updateDescuento').disabled = true;
            let validation = true;
           mensualidades = document.getElementById("pago_ind011").value;
            
           pago = document.getElementById("descuento1").value ;
          
            if (mensualidades == '' ) 
            {
                validation = false;
            }
            if (pago == ''){
                validation = false;
            }
       
            id_descuento = document.getElementById("descuento_id").value; 
            if (validation ){
                $.ajax({
                    url : 'UpdateDescuent',
                    type : 'POST',
                    data: {
                    "id_descuento"      : id_descuento,
                    "monto"             : pago,
                    "pago_individual"   : mensualidades,
                 
                      }, 
                    success : response => {
                        document.getElementById('updateDescuento').disabled = false;
                        alerts.showNotification("top", "right", "Descuento actualizado satisfactoriamente.", "success");
                     
                   
                        // toastr[response.response_type](response.message);
                        $('#editDescuento').modal('toggle');
                    },
                    error : (a, b, c) => {
                        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
                    }
           
                });
            }else {
                alerts.showNotification("top", "right", "Upps hace falta algunos datos.", "warning");
                      
            }
           
        });
        
        
        $("#tabla-general tbody").on("click", ".consultar_logs_asimilados", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            id_user = $(this).val();
            lote = $(this).attr("data-value");

            $("#seeInformationModalDU").modal();
            $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DESCUENTO: <b>' + lote + '</b></h5></p>');
            $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                let saldo_comisiones;

                if(data.saldo_comisiones == 'NULL' || data.saldo_comisiones=='null' || data.saldo_comisiones==undefined){
                    saldo_comisiones = '';
                }else{
                    saldo_comisiones = '<label style="font-size:small;border-radius: 13px;background: rgb(0, 122, 255);' +
                        'color: white;padding: 0px 10px;">Monto comisionado: <b>'+data.saldo_comisiones+'</b></label>';
                }

                if (!data) {
                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');
                } else {
                    $.each(data, function (i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SE DESCONTÓ LA CANTIDAD DE <b>$' + formatMoney(v.comentario) +'<br>' + v.comentario2 +'</b>'+saldo_comisiones+'<br><b style="color:#3982C0;font-size:0.9em;">' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });
        });

        $('#tabla-general tbody').on('click', '.activar-prestamo', function () {
            const usuarioId = $(this).val();

            $('#activar-pago-form').trigger('reset');

            $.get(`${url}Comisiones/getTotalPagoFaltanteUsuario/${usuarioId}`, function (data) {
                const pago = JSON.parse(data);

                $('#id-descuento-pago').val(pago.id_descuento);

                if (pago.faltante !== null) {
                    $('#faltante-pago').text('').text(formatMoney(pago.faltante));
                } else {
                    $('#faltante-pago').text('').text(formatMoney(pago.monto_total));
                }

                $('#activar-pago-modal').modal();
            });
        });

        $("#tabla-general tbody").on("click", ".agregar_nuevo_descuento", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#condominios1").val('');
          
            $("#idloteorigen").val('');
            $("#usuarioid").val('');
            $("#pagos_aplicados").val('');


            $("#idloteorigen").selectpicker("refresh");
            $('#idloteorigen option').remove();
            $("#condominios1").selectpicker('refresh');
            $('#condominios1 option').remove();
            id_user = $(this).val();
            monto = $(this).attr("data-value");
            sde = $(this).attr("data-sede");
            validar = $(this).attr("data-validate");
            saldo_comisiones = $(this).attr("data-saldoCom");

            // alert(validar);

            $("#miModal modal-body").html("");
            $("#miModal").modal();

            var user = $(this).val();
            let datos = user.split(',');
            $("#monto").val('$' + formatMoney(monto));
            $("#usuarioid").val(id_user);
            $("#pagos_aplicados").val(validar);
            $('#saldo_comisiones').val(saldo_comisiones);

            $.post('getLotesOrigen2/' + id_user + '/' + monto, function (data) {
                var len = data.length;


                let valores = '';
                let sumaselected = 0;
                for (var i = 0; i < len; i++) {

                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = parseFloat(data[i]['comision_total']) - parseFloat(data[i]['abono_pagado']);
                    sumaselected = sumaselected + parseFloat(data[i]['comision_total']);


                    $("#condominios1").append(`<option value='${comision},${comtotal.toFixed(2)},${pago_neodata},${name}' selected="selected">${name}  -   $${formatMoney(comtotal.toFixed(2))}</option>`);

                    $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)},${pago_neodata},${name}' selected="selected">${name}  -   $${formatMoney(comtotal.toFixed(2))}</option>`);
                }

                $("#idmontodisponible").val('$' + formatMoney(sumaselected));
                verificar();

                if (len <= 0) {
                    $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#idloteorigen").selectpicker('refresh');
                $("#condominios1").selectpicker('refresh');
            }, 'json');


        });

        $('#tabla-general tbody').on('click', '.btn-eliminar-descuento', function () {
            const idDescuento = $(this).val();

            $.ajax({
                type: 'POST',
                url: `eliminarDescuentoUniversidad/${idDescuento}`,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (JSON.parse(data)) {
                        alerts.showNotification("top", "right", "El registro se ha eliminado exitosamente.", "success");
                        tablaGeneral.ajax.reload();
                    } else {
                        alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                    }
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $('#tabla-general tbody').on('click', '.btn-editar-descuento', function () {
            const idDescuento = $(this).val();

            $.get(`obtenerDescuentoUniversidad/${idDescuento}`, function (data) {
                const info = JSON.parse(data);

                $('#id-descuento-pago-update').val(info.id_descuento);
                $('#usuario-update').text("").text(`Usuario: ${info.usuario}`);
                $('#descuento-update').val(info.monto);
                $('#numero-pagos-update').val(info.no_pagos);
                $('#pago-ind-update').val(info.pago_individual);
                $('#actualizar-descuento-modal').modal();
            });
        });

        let meses = [
            {
                id: '01',
                mes:'Enero'
            },
            {
                id:'02',
                mes:'Febrero'
            },
            {
                id:'03',
                mes:'Marzo'
            },
            {
                id:'04',
                mes:'Abril'
            },
            {
                id:'05',
                mes:'Mayo'
            },
            {
                id:'06',
                mes:'Junio'
            },
            {
                id:'07',
                mes:'Julio'
            },
            {
                id:'08',
                mes:'Agosto'
            },
            {
                id:'09',
                mes:'Septiembre'
            },
            {
                id:'10',
                mes:'Octubre'
            },
            {
                id:'11',
                mes:'Noviembre'
            },
            {
                id:'12',
                mes:'Diciembre'
            }
        ];
        let anios = [2019,2020,2021,2022];

        $("#tabla-general tbody").on("click", ".consultar_historial_pagos", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            document.getElementById('nameUser').innerHTML = '';
            document.getElementById('montito').innerHTML = '';

            $('#userid').val(0);

            id_user = $(this).val();
            user = $(this).attr("data-value");
            $('#userid').val(id_user);

            $("#seeInformationModalP").modal();
            $("#nameUser").append('<p><h5 style="color: white;">HISTORIAL PAGOS: <b>' + user + '</b></h5></p>');

            let datos = '';
            let datosA = '';
            for (let index = 0; index < meses.length; index++) {
                //  const element = array[index];
                datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;

            }
            for (let index = 0; index < anios.length; index++) {
                //  const element = array[index];
                datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;

            }
            $('#mes').html(datos);
            $('#mes').selectpicker('refresh');
            $('#anio').html(datosA);
            $('#anio').selectpicker('refresh');

            //$("#comments-list-asimiladosP .select-gral-mes").append(`${datos}`);




            /* $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                 if (!data) {

                     $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');

                 } else {
                     $.each(data, function (i, v) {
                         $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SE DESCONTÓ LA CANTIDAD DE <b>$' + formatMoney(v.comentario) + '</b><br><b style="color:#3982C0;font-size:0.9em;">' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                     });
                 }
             });*/
        });

      
        $("#tabla-general tbody").on("click", ".topar_descuentos", function () {
            var tr = $(this).closest('tr');
            var row = tablaGeneral.row(tr);
            id_usuario = $(this).val();


            $("#modal_nuevas .modal-header").html("");
            $("#modal_nuevas .modal-body").html("");

            $("#modal_nuevas .modal-header").append('<h4 class="card-title"><b>Detener Descuento</b></h4>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p style="font-size:1.1em;">¿Está seguro de detener los pagos al ' + row.data().puesto + ' <u>' + row.data().nombre + '</u> con la cantidad de <b>$' + formatMoney(row.data().aply) + '</b>?</p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="monto" value="' + row.data().aply + '"><br><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe el motivo por el cual se pausa esta solicitud"></input></div></div><br>');
            $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="' + row.data().id_usuario + '">');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12" style="align-content: first;"><center><input type="submit" id="btn_topar" class="btn btn-primary" value="DETENER" style="margin: 15px;"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></center></div></div>');
            $("#modal_nuevas").modal();
        });

        $('#tabla-general tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tablaGeneral.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
            } else {
                if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                    $.post(url + "Comisiones/getDescuentosCapitalpagos", {"id_usuario": row.data().id_usuario}).done(function (data) {

                        row.data().solicitudes = JSON.parse(data);

                        tablaGeneral.row(tr).data(row.data());

                        row = tablaGeneral.row(tr);

                        row.child(construir_subtablas(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");

                    });
                } else {
                    row.child(construir_subtablas(row.data().solicitudes)).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                }

            }


        });
    });
}

function getInputTotalId(tipoDescuento) {
    if (tipoDescuento === '1') {
        return 'total-activo'; 
    } else if (tipoDescuento === '2') {
        return 'total-baja';
    } else if (tipoDescuento === '3') {
        return 'total-liquidado'
    } else if (tipoDescuento === '4') {
        return 'total-conglomerado';
    }
    return '';
}

function getInputAbonadoId(tipoDescuento) {
    if (tipoDescuento === '1') {
        return 'total-abonado';
    } else if (tipoDescuento === '2') {
        return 'abonado-baja';
    } else if (tipoDescuento === '3') {
        return 'abonado-liquidado'
    } else if (tipoDescuento === '4') {
        return 'abonado-conglomerado';
    }
    return '';
}

function getInputPendienteId(tipoDescuento) {
    if (tipoDescuento === '1') {
        return 'total-pendiente';
    } else if (tipoDescuento === '2') {
        return 'pendiente-baja';
    } else if (tipoDescuento === '3') {
        return 'pendiente-liquidado'
    } else if (tipoDescuento === '4') {
        return 'pendiente-conglomerado';
    }
    return '';
}


$('#activar-pago-form').on('submit', function (e) {
    e.preventDefault();

    let dateForm = new Date($('#fecha').val());
    dateForm.setDate(dateForm.getDate() + 1);
    const today = new Date();

    if (dateForm.setHours(0,0,0,0) < today.setHours(0,0,0,0)) {
        alerts.showNotification("top", "right", "La Fecha debe ser igual o mayor a la actual.", "danger");
    } else {
        $.ajax({
            type: 'POST',
            url: 'reactivarPago',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (JSON.parse(data)) {
                    $('#activar-pago-modal').modal('hide');
                    $('#id-descuento-pago').val('');
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    tablaGeneral.ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

$('#actualizar-descuento-form')
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            descuento: {
                required: true,
                number: true,
                min: 1,
                max: 99000
            },
            "numero-pagos": {
                required: true
            }
        },
        messages: {
            descuento: {
                required: '* Campo requerido.',
                number: 'Número no válido.',
                min: 'El valor mínimo debe ser 1',
                max: 'El valor máximo debe ser 99,000'
            },
            "numero-pagos": {
                required: '* Campo requerido.'
            }
        },
        submitHandler: function (form) {
            const data = new FormData($(form)[0]);

            $.ajax({
                url: 'actualizarDescuentoUniversidad',
                data: data,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    $('#actualizar-descuento-modal').modal('hide');
                    alerts.showNotification("top", "right", "Descuento actualizado con exito.", "success");
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    });

$('#numero-pagos-update').change(function () {
    const monto1 = replaceAll($('#descuento-update').val(), ',', '');
    const monto = replaceAll(monto1, '$', '');
    const cantidad = parseFloat($('#numero-pagos-update').val());
    let resultado = 0;

    if (isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
        $('#pago-ind-update').val(resultado);
    } else {
        resultado = monto / cantidad;
        if (resultado > 0) {
            $('#pago-ind-update').val(formatMoney(resultado));
        } else {
            $('#pago-ind-update').val(formatMoney(0));
        }
    }
});

function getPagosByUser(user,mes, anio){
    document.getElementById('montito').innerHTML = 'Cargando...';
    $.getJSON("getPagosByUser/" + user+"/"+mes+"/"+anio).done(function (data) {
        document.getElementById('montito').innerHTML ='$'+ formatMoney(data[0].suma);
    });
}

$('#mes').change(function(ruta) {
    anio = $('#anio').val();
    mes = $('#mes').val();
    let user = $('#userid').val();
    if(anio == ''){
        anio=0;
    }else{

        getPagosByUser(user,mes, anio);
    }
});

$('#anio').change(function(ruta) {
    let user = $('#userid').val();
    mes = $('#mes').val();
    anio = $('#anio').val();

    if(mes != '' && (anio != '' || anio != null || anio != undefined)){
        //alert(34)
        getPagosByUser(user,mes, anio);

    }
});

function construir_subtablas(data) {
        var solicitudes = '<table class="table">';
        $.each(data, function (i, v) {
            //i es el indice y v son los valores de cada fila

            // console.log(data);
            if (v.id_usuario == 'undefined') {
                solicitudes += '<tr>';
                solicitudes += '<td><b>SIN PAGO APLICADOS</b></td>';
                solicitudes += '</tr>';


            } else {
                solicitudes += '<tr>';
                solicitudes += '<td><b>Pago ' + (i + 1) + '</b></td>';
                solicitudes += '<td>' + '<b>' + 'USUARIO ' + '</b> ' + v.nombre + '</td>';
                solicitudes += '<td>' + '<b>' + 'MONTO: ' + '</b> $' + formatMoney(v.abono_neodata) + '</td>';
                solicitudes += '<td>' + '<b>' + 'CREADO POR: ' + '</b> ' + v.creado_por + '</td>';
                solicitudes += '<td>' + '<b>' + 'FECHA CAPTURA: ' + '</b> ' + v.fecha_abono + '</td>';
                solicitudes += '</tr>';
            }

        });

        return solicitudes += '</table>';
    }


//Función para pausar la solicitud
$("#form_interes").submit(function (e) {

    $('#btn_topar').attr('disabled', 'true');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
   
        // data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/topar_descuentos",
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
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});


function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
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


    $("#roles").change(function () {
        var parent = $(this).val();

        $("#users2").val('');

        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");


        document.getElementById("users2").innerHTML = '';
        $('#users2').append(`<label class="label">Usuario</label><select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>`);
        $.post('getUsuariosRolDU/' + parent, function (data) {
            $("#usuarioid2").append($('<option disabled>').val("default").text("Seleccione una opción"))
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['name_user'];
                var status = data[i]['estatus'];
                if(status == 0){
                    name = name + ' (Inactivo)';
                }
                $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
            }
            if (len <= 0) {
                $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#usuarioid2").selectpicker('refresh');
        }, 'json');
    });


$("#form_basta").submit(function (e) {
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
                    $('#miModal').modal('hide');
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
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    $(".directorSelect2").empty();

                } else if (data == 3) {
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    $(".directorSelect2").empty();

                }
                $('#idloteorigen').attr('disabled', 'true');

            },
            error: function () {
                $('#loaderDiv').addClass('hidden');
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#idloteorigen').attr('disabled', 'true');


            }
        });
    }
});

$("#form_nuevo").submit(function (e) {

    // $('#btn_abonar').attr('disabled', 'true');
    $('#btn_abonar').prop('disabled', true);
    document.getElementById('btn_abonar').disabled = true;

    e.preventDefault();
}).validate({
    rules: {
        roles: {
            required: true
        },
        descuento: {
            required: true,
            number: true,
            min: 1,
            max: 99000
        },
        numeroPagos: {
            required: true
        },
        comentario2: {
            required: true
        }
    },
    messages: {
        roles: {
            required: '* Campo requerido'
        },
        descuento: {
            required: '* Campo requerido',
            number: 'Número no válido.',
            min: 'El valor mínimo debe ser 1',
            max: 'El valor máximo debe ser 99,000'
        },
        numeroPagos: {
            required: '* Campo requerido'
        },
        comentario2: {
            required: '* Campo requerido'
        }
    },
    submitHandler: function (form) {

        const data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'saveDescuentoch/',
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#ModalBonos').modal('hide');
                    $("#roles").val('');
                    $("#roles").selectpicker("refresh");
                    document.getElementById("users2").innerHTML = '';
                    $("#usuarioid2").val('');
                    $("#usuarioid2").selectpicker("refresh");

                    $("#descuento").val('');
                    $("#numeroPagos").val('');
                    $("#pago_ind01").val('');
                    $("#comentario2").val('');
                    alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");

                } else if (data == 2) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#ModalBonos').modal('hide');
                    alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    $(".directorSelect2").empty();

                } else if (data == 3) {
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#ModalBonos').modal('hide');
                    alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    $(".directorSelect2").empty();

                }

            },
            error: function () {
                $('#loaderDiv').addClass('hidden');
                $('#ModalBonos').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#idloteorigen').attr('disabled', 'true');


            }
        });
    }
});


$("#numeroPagos").change(function () {


        let monto1 = replaceAll($('#descuento').val(), ',', '');
        let monto = replaceAll(monto1, '$', '');
        let cantidad = parseFloat($('#numeroPagos').val());
        let resultado = 0;


        if (isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            $('#pago_ind01').val(resultado);
            // document.getElementById('btn_abonar').disabled = true;
            $('#btn_abonar').prop('disabled', true);
            document.getElementById('btn_abonar').disabled = true;
        } else {
            resultado = monto / cantidad;

            if (resultado > 0) {
                // document.getElementById('btn_abonar').disabled=false;
                $('#pago_ind01').val(formatMoney(resultado));
            } else {
                // document.getElementById('btn_abonar').disabled=true;
                $('#pago_ind01').val(formatMoney(0));
            }
        }
    });


function closeModalEng() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal_abono").modal('toggle');

}

function CloseModalDelete2() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form-delete").reset();
    a = document.getElementById('borrarBono');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal-delete").modal('toggle');

}

function CloseModalUpdate2() {
    // document.getElementById("inputhidden").innerHTML = "";
    document.getElementById("form-update").reset();
    a = document.getElementById('borrarUpdare');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal-abono").modal('toggle');

}

$(window).resize(function () {
    tablaGeneral.columns.adjust();
});

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

$("#idloteorigen").change(function () {

        let cuantos = $('#idloteorigen').val().length;
        let suma = 0;
        //let ids = $('#idloteorigen').val();

        if (cuantos > 1) {

            var comision = $(this).val();


            //alert(comision);
            //let ids = comision.split(',');
            for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                datos = comision[index].split(',');
                let id = datos[0];
                let monto = datos[1];
                // var id = comision[index];
                document.getElementById('monto').value = '';

                $.post('getInformacionData/' + id + '/' + 1, function (data) {

                    var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                    suma = suma + disponible;
                    document.getElementById('montodisponible').innerHTML = '';
                    $("#idmontodisponible").val('$' + formatMoney(suma));
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + suma.toFixed(2) + '">');
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                    var len = data.length;
                    if (len <= 0) {
                        $("#idmontodisponible").val('$' + formatMoney(0));
                    }
                    $("#montodisponible").selectpicker('refresh');
                }, 'json');
            }
         
        } else {
            var comision = $(this).val();
            datos = comision[0].split(',');
              let id = datos[0];
            let monto = datos[1];
            //alert(id+'-------'+monto);
            document.getElementById('monto').value = '';
            $.post('getInformacionData/' + id + '/' + 1, function (data) {
                var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                document.getElementById('montodisponible').innerHTML = '';
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + disponible + '">');
                $("#idmontodisponible").val('$' + formatMoney(disponible));
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                var len = data.length;
                if (len <= 0) {
                    $("#idmontodisponible").val('$' + formatMoney(0));
                }
                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    });

function verificar() {

    


        // let d = $('#valor_comision').val();
        let d2 = replaceAll($('#idmontodisponible').val(), ',', '');
        let disponiblefinal = replaceAll(d2, '$', '');
        //let m1 = $('#monto').val();
        let m = replaceAll($('#monto').val(), ',', '');
        let montofinal = replaceAll(m, '$', '');

        let disponible = parseFloat(disponiblefinal);
        let monto = parseFloat(montofinal);

        if (monto < 1 || isNaN(monto)) {
            alerts.showNotification("top", "right", "No hay saldo disponible para descontar.", "warning");

            $('#btn_abonar').prop('disabled', true);
            document.getElementById('btn_abonar').disabled = true;

        } else {
            if (parseFloat(monto) <= parseFloat(disponible)) {

                 let cantidad = parseFloat($('#numeroP').val());
                resultado = monto / cantidad;
                $('#pago').val(formatMoney(resultado));

                $('#btn_abonar').prop('disabled', false);
                document.getElementById('btn_abonar').disabled = false;

        
                let cuantos = $('#idloteorigen').val().length;
                let cadena = '';
                var data = $('#idloteorigen').select2('data')
                for (let index = 0; index < cuantos; index++) {
                    let datos = data[index].id;
                    let montoLote = datos.split(',');
                    let abono_neo = montoLote[1];

                    if (parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1) {
                        document.getElementById('msj2').innerHTML = "El monto ingresado se cubre con la comisión " + data[index].text;
                        // document.getElementById('btn_abonar').disabled = true;

                        $('#btn_abonar').prop('disabled', false);
                        document.getElementById('btn_abonar').disabled = false;

                        break;
                    }

                if(cuantos == 1){
                    let datosLote = data[index].text.split('-   $');
                    let nameLote = datosLote[0]
                    let montoLote = datosLote[1];
                    cadena =  'DESCUENTO UNIVERSIDAD MADERAS \n LOTE INVOLUCRADO: '+nameLote+',  MONTO DISPONIBLE: $'+montoLote+'.\n DESCUENTO DE: $'+formatMoney(monto)+', RESTANTE:$'+formatMoney(parseFloat(abono_neo) - parseFloat(monto));
                }else{
                    cadena = 'DESCUENTO UNIVERSIDAD MADERAS';
                }

                    document.getElementById('msj2').innerHTML = '';

                }
                $('#comentario').val(cadena);

              //  $('#comentario').val('Lotes involucrados en el descuento(universidad): ' + cadena + '. Por la cantidad de: $' + formatMoney(monto));

                // console.log(cadena);
            }
            //else {
            else if (parseFloat(monto) > parseFloat(disponible)) {
                alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                //document.getElementById('monto').value = '';
                // document.getElementById('btn_abonar').disabled = true;

                $('#btn_abonar').prop('disabled', true);
                document.getElementById('btn_abonar').disabled = true;
            }
        }

    }

function general(){
    $("#idloteorigen").select2({dropdownParent: $('#miModal')});
    $("#idloteorigen").select2("readonly", true);
}

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

function open_Mb() {
    // console.log("SI ENTRA");
    // $("ModalBonos").modal();

    $("#roles").val('');
    $("#roles").selectpicker("refresh");

    document.getElementById("users2").innerHTML = '';


    $("#usuarioid2").val('');
    $("#usuarioid2").selectpicker("refresh");

    $("#comentario2").val('');

    $('#ModalBonos').modal('show');
}

$('#ModalBonos').on('hidden.bs.modal', function() {
    $('#form_nuevo').trigger('reset');
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
  
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento
    MontoDescontarCerti = $(this).attr("data-value");
    valorCertificacion = $(this).attr("data-idCertificacion");
    document.getElementById("certificaciones").value = valorCertificacion;
    if (descuento == total){
        banderaLiquidados = true;

    }else{

        banderaLiquidados = false;
    }
    descuento = Math.round(descuento);
    pago_mensual = Math.round(pago_mensual);

    cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos

    
 
    document.getElementById("banderaLiquidado").value = banderaLiquidados;
    document.getElementById("dineroPagado").value = total;
    document.getElementById("pagoIndiv").value = pago_mensual;
    document.getElementById("idDescuento").value = id_descuento;
    document.getElementById("totalPagos").value = cantidad_de_pagos;
    document.getElementById("pagoDado").value = pagoDado;
    // monto a descontar,  lp importante es mas 
    id_user = $(this).attr("data-code");
    pago_mensual = $(this).attr("data-mensual");
    descuento = $(this).attr("data-descuento");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento

    valorPendiente = pendiente;

    var titulo  = ' ';
    titulo += '  <h3 id="tituloModalUni" name="tituloModalUni">Editando descuento actual para '+ nombre  +'</h3>';



    var informacion_adicional = ' '; //inicio de div que contiene todo el modal
    informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
 
    informacion_adicional += '        <div class="form-group text-left">';
    informacion_adicional += '            <label class="label ">Monto Descuento *</label>';
    informacion_adicional += '            <input class="form-control  MontoDescontarCerti" type="number" id="MontoDescontarCerti"';
    informacion_adicional += '                name="MontoDescontarCerti" autocomplete="off" min="1" max="99000" step=".01"';
    informacion_adicional += '               required />';
    informacion_adicional += '         </div>';
    informacion_adicional += '       </div>';

    informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
    informacion_adicional += '        <div class="form-group text-left">';
    informacion_adicional += '          <label class="label">Pagos repartidos*</label> ';
    informacion_adicional += '         <select class="form-control mensualidadesC" name="mensualidadesC" id="mensualidadesC" required>';
    informacion_adicional += '          <option value="" disabled="true" selected="selected">- Selecciona opción';
    informacion_adicional += '          </option>';
    informacion_adicional += '          <option value="1">1</option>';
    informacion_adicional += '          <option value="2">2</option>';
    informacion_adicional += '          <option value="3">3</option>';
    informacion_adicional += '          <option value="4">4</option>';
    informacion_adicional += '          <option value="5">5</option>';
    informacion_adicional += '          <option value="6">6</option>';
    informacion_adicional += '          <option value="7">7</option>';
    informacion_adicional += '          <option value="8">8</option>';
    informacion_adicional += '          <option value="9">9</option>';
    informacion_adicional += '          <option value="10">10</option>';
    informacion_adicional += '         </select>';
    informacion_adicional += '        </div>';
    informacion_adicional += '      </div>';

    informacion_adicional += '      <div class="col-xs-4 col-sm-4 col-md-4">';
    informacion_adicional += '        <div class="form-group text-left">';
    informacion_adicional += '            <label class="label">Nuevas mensualidades*</label>';
    informacion_adicional += '            <input class="form-control newMensualidades" type="number" id="newMensualidades"';
    informacion_adicional += '                name="newMensualidades" autocomplete="off" min="1" max="99000" step=".01"';
    informacion_adicional += '               required />';
    informacion_adicional += '         </div>';
    informacion_adicional += '      </div>';
    // eee

    var cuerpoModalUni = document.getElementById('cuerpoModalUni');
    cuerpoModalUni.innerHTML = informacion_adicional;

    document.getElementById("MontoDescontarCerti").value = descuento;
    var myCommentsLote = document.getElementById('tituloModalUni');
    myCommentsLote.innerHTML = '';

    var Header_modal = document.getElementById('header_modal');
    Header_modal.innerHTML = titulo;


    // if(banderaLiquidados){
    //     document.getElementById("mensualidadesC").value = 1;
    // }else{
    //     document.getElementById("mensualidadesC").value = Math.trunc( mensualidadesFaltantesMostrar);
    // }
       mensualidadesFaltantes = total / pago_mensual ;
            mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;         
            if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

            }else{
                if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
                {
                    if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
                    {
                        mensualidadesFaltantesMostrar = 1;
                    }else{

                    }           
                }else{

                    mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
                }
               // mensualidadesFaltantes
            }
            if ((mensualidadesFaltantes % 1)  == 0 ){

            }else{
                if( 0 == Math.trunc(mensualidadesFaltantes))
                {
                    if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
                    {

                        mensualidadesFaltantes = 1;
                    }else{
                    
                    }
                }else{
                        mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
                }
               // mensualidadesFaltantes
            }
            if(banderaLiquidados){
                document.getElementById("mensualidadesC").value = 1;
                mensualidadesFaltantesMostrar = 1;
                mensualidadesFaltantes = 1;
            }else{
                mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;
                document.getElementById("mensualidadesC").value = Math.trunc( mensualidadesFaltantesMostrar);
            }


            ultimaMensualidad = document.getElementById("mensualidadesC").value
            Total_a_pagar = ultimaMensualidad * pago_mensual;

            sobrante = Total_a_pagar - total;

            //para agregar llo que ya se pago
            descuentoEscrito = document.getElementById("MontoDescontarCerti").value;
         
            NuevasMensualidades= (pendiente)  / ultimaMensualidad ;

            if(banderaLiquidados){

                sobrante = document.getElementById("MontoDescontarCerti").value;
                sobrante =  total - sobrante ;
                NuevasMensualidades = sobrante  / mensualidadesFaltantes;
            }
            document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
            //faltantes = mensualidadesFaltantes/mensual;
            document.getElementById("precioOrginal").value =   NuevasMensualidades.toFixed(2);

});  

$(document).on("click", "#cancelarOperation", function () {

// $('#botonesInicio').css('display', 'none');
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
    // total_pagos = document.getElementById("total_pagos").value ;
    // actualess = document.getElementById("actualess").value ;
    // totalmeses = document.getElementById("totalmeses").value ;
    // cuanto = document.getElementById("cuanto").value ;
    // mensualidad = document.getElementById("mensualidad").value ;
    mensualidadesC = document.getElementById("mensualidadesC").value;
    pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
    loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
    pagos  = document.getElementById("mensualidadesC").value ;
    banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
    if(banderaLiquidado){
        loQueSedebe = loQueSedebe - pagado;

        NuevasMensualidades = loQueSedebe / pagos;
    }else{
        loQueSedebe = loQueSedebe - pagado;

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

        banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
        if(banderaLiquidado){
            loQueSedebe = loQueSedebe - pagado;
            NuevasMensualidades = loQueSedebe / pagos;
  
        }else{
            loQueSedebe = loQueSedebe - pagado;
            NuevasMensualidades = loQueSedebe / pagos;
        } 
        document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
    });
    
    // $("#mensualidadesC").change(function () {
        // console.log('mensaje de realizacioón');
        // alert('refromazado');
   
    //     mensualidadesC = document.getElementById("mensualidadesC").value;
    //     pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
    //     loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
    //     pagos  = document.getElementById("mensualidadesC").value ;
    //     console.log("loQueSedebe" + loQueSedebe );
    //     banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
    //     if(banderaLiquidado){
    //         loQueSedebe = loQueSedebe - pagado;
    //         console.log("Pagado" + pagado );
    //         NuevasMensualidades = loQueSedebe / pagos;
    //     }else{
    //         loQueSedebe = loQueSedebe - pagado;
    //         console.log("Pagado" + pagado );
    //         NuevasMensualidades = loQueSedebe / pagos;
    //     } 
    //     document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    // 
    // });                                                                                                                                                                                              
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
    let validacion = true;
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
    const FechaEnArreglo = fechaSeleccionada.split("-");
    // fecha en arreglo es para poder entrar al mes posicion 0 es dia, 1  mes , año
    fechaComparar = (year + '-' + month + '-' + day);
    var f1 = new Date(year,month, day);
    var f2 = new Date(fechaSeleccionada);
    console.log(f1,'f1');
    console.log(f2,'f2');
    MesSelecionado = parseInt(FechaEnArreglo[1]);
    DiaSeleccionado = parseInt(FechaEnArreglo[2]);
    MesSistemas = parseInt(month+1);
    // fecha f2 es para la fecha seleccionada 
    // fecha f1 es para la fecha del sistema 
    // Se compara las fechas son para 
    
    if(  (f2 > f1 || f2 == f1)){
        // validamos que sea mayor la fecha seleccionada o que sean iguales
        validacion =true;
        if(DiaSeleccionado <= 5 && MesSelecionado == MesSistemas ){
            banderaPagosActivos = 1;
                        // && MesSelecionado == MesSistemas  
        }else if(DiaSeleccionado > 5 ||  MesSelecionado >= MesSistemas  ){
            banderaPagosActivos = 2 ;
        }else {
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
        estatus_certificacion  = document.getElementById("certificaciones").value;
    
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
            "estatus_certificacion" : estatus_certificacion,    
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

        }
});



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
    // console.log('Fecha inicio: ', finalBeginDate);
    // console.log('Fecha final: ', finalEndDate);
    // $("#beginDate").val(finalBeginDate);
     $("#fechaIncial").val(FechaIncial);
 
}

