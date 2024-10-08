



$(document).ready(function () {
    numerosDispersion();
    let titulos_intxt = [];
    setIniDatesXMonth("#beginDate", "#endDate");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    $('#tabla_dispersar_comisiones thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        // if (i != 0 ) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_dispersar_comisiones').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_dispersar_comisiones').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_dispersar_comisiones').DataTable().rows({
                selected: true,
                search: 'applied'
                }).indexes();
                var data = $('#tabla_dispersar_comisiones').DataTable().rows(index).data();
            });
        // }
    });

    dispersionDataTable = $('#tabla_dispersar_comisiones').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Comisiones Dispersión',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,16],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
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
        destroy: true,
        ordering: false,
        columns: [
            {
            className: 'details-control',
            orderable: false,
            data : null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div>'
            },
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            { data: function (d) {
                if(d.id_cliente_reubicacion_2 >1 ) {
                    nombreLote =  d.nombreLoteReub;
                } else{
                    nombreLote = d.nombreLote;
                }
                return nombreLote;
            }},
            {data: 'idLote'},
            {data: 'nombreCliente'},
            { data: function (d) {
                    return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span>`;
            }},
            { data: function (d) {
                var labelCompartida;
                if(d.compartida == null) {
                    labelCompartida ='<span class="label lbl-yellow">Individual</span>';
                } else{
                    labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
                }
                return labelCompartida;
            }},
            { data: function (d) {
                var labelStatus;
                if(d.idStatusContratacion == 15) {
                    labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
                }else {
                    labelStatus ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
                }
                return labelStatus;
            }},
            { data: function (d) {
                var labelEstatus;
                if(d.penalizacion == 1 && (d.bandera_penalizacion == 0 || d.bandera_penalizacion == 1) ){
                    labelEstatus =`<p class="m-0"><b>Penalización ${d.dias_atraso} días</b></p><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
                }
                else{
                    if(d.totalNeto2 == null && d.proceso == 0) {
                        labelEstatus ='<p class="m-0"><b>Sin Precio Lote</b></p>';
                    }else if(d.registro_comision == 2){
                        labelEstatus ='<span class="label lbl-cerulean">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
                    }else {
                        if(d.plan_descripcion=="-")
                            return '<p>SIN PLAN</p>';
                        else
                            labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span></label>`;
                    }
                }
                return labelEstatus;
            }},
            { data: function (d) {
                return formatMoney(d.Precio_Total);
            }},
            { data: function (d) {
                return d.Comision_total ? `${parseFloat(d.Comision_total)}%`: 'SIN ESPECIFICAR';
            }},
            { data: function (d) {
                return formatMoney(d.Comisiones_Pagadas);
            }},
            { data: function (d) {
                return formatMoney(d.Comisiones_pendientes);
            }},
            { data: function (d) {
                var rescisionLote;
                var reactivo;
                rescisionLote = '';
                reactivo = '';
                if (d.registro_comision == 8){
                    rescisionLote = '<br><span class="label lbl-warning">Recisión Nueva Venta</span>';
                }
                if(d.id_cliente_reubicacion_2 != 0 ) {
                    if((d.bandera_dispersion == 1 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2  && d.registro_comision != 9) ||
                    (d.bandera_dispersion == 1  && d.registro_comision != 9 && validarLiquidadas == 0 || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0))){
                        reactivo = '<br><span class="label lbl-gray">DISPERSIÓN VENTAS</span>';
                    } else if((d.bandera_dispersion == 3  && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 3 && d.registro_comision != 9) ||
                    ((d.registro_comision == 1 && d.validaLiquidadas == 1 && (d.banderaOOAM == 0 || d.banderaOOAM > 0 )) || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM > 0))){//LIQUIDADA 1°
                        reactivo = '<br><span class="label lbl-lightBlue">DISPERSIÓN EEC</span>';
                    } 
                }
                return rescisionLote+reactivo;
            }},
            { data: function (d) {
                var fechaActualizacion;

                if(d.fecha_sistema == null) {
                    fechaActualizacion ='<span class="label lbl-gray">Sin Definir</span>';
                }else {
                    fechaActualizacion = '<span class="label lbl-azure">'+d.fecha_sistema+'</span>';
                }
                
                return fechaActualizacion;
            }},
            {data: 'nombreMensualidad'},
            { data: function (d) {
                var BtnStats = '';

                var Mensaje = 'Verificar en NEODATA';
                varColor2  = 'btn-gray';
                var RegresaActiva = '';

                if(d.fecha_sistema != null && d.registro_comision != 8 && d.registro_comision != 0) {
                    RegresaActiva = '<button href="#" data-idpagoc="' + d.idLote + '" data-nombreLote="' + d.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" data-toggle="tooltip" data-placement="top" title="Enviar a activas">' +'<i class="fas fa-undo-alt"></i></button>';
                }

                if(d.penalizacion == 1 && d.bandera_penalizacion == 0 && d.id_porcentaje_penalizacion != '4') {
                    BtnStats += `<button href="#" value="${d.idLote}" data-value="${d.nombreLote}" data-cliente="${d.id_cliente}" class="btn-data btn-blueMaderas btn-penalizacion" data-toggle="tooltip"  data-placement="top" title="Aprobar Penalización"> <i class="material-icons">check</i></button>
                    <button href="#" value="${d.idLote}" data-value="${d.nombreLote}" data-cliente="${d.id_cliente}" class="btn-data btn-blueMaderas btn-Nopenalizacion btn-warning" data-toggle="tooltip"  data-placement="top" title="Rechazar Penalización"> <i class="material-icons">close</i> </button>`;
                }else if(d.penalizacion == 1 && d.bandera_penalizacion == 0 && d.id_porcentaje_penalizacion == '4') {
                    BtnStats += `<button href="#" value="${d.idLote}" data-value="${d.nombreLote}" data-cliente="${d.id_cliente}" class="btn-data btn-blueMaderas btn-penalizacion4" data-toggle="tooltip"  data-placement="top" title="Aprobar Penalización"> <i class="material-icons">check</i> </button>
                    <button href="#" value="${d.idLote}" data-value="${d.nombreLote}" data-cliente="${d.id_cliente}" class="btn-data btn-blueMaderas btn-Nopenalizacion btn-warning" data-toggle="tooltip"  data-placement="top" title="Rechazar Penalización"><i class="material-icons">close</i></button>`;
                }else{
                    if((d.totalNeto2==null || d.totalNeto2==''|| d.totalNeto2==0) && d.proceso == 0) {
                        BtnStats = 'Asignar Precio';
                    }else if(d.tipo_venta==null || d.tipo_venta==0) {
                        BtnStats = 'Asignar Tipo Venta';
                    }else if((d.id_prospecto==null || d.id_prospecto==''|| d.id_prospecto==0) && d.lugar_prospeccion == 6) {
                        BtnStats = 'Asignar Prospecto';
                    }else if(d.referencia==null || d.referencia==''|| d.referencia==0) {
                        BtnStats = 'Asignar Referencia';
                    }else if(d.id_subdirector==null || d.id_subdirector==''|| d.id_subdirector==0) {
                        BtnStats = 'Asignar Subdirector';
                    }else if(d.id_sede==null || d.id_sede==''|| d.id_sede==0) {
                        BtnStats = 'Asignar Sede';
                    }else if(d.plan_comision==null || d.plan_comision==''|| d.plan_comision==0) {
                        BtnStats = 'Asignar Plan <br> Sede:'+d.sede;
                    } else{
                        if(d.compartida==null) {
                            varColor  = 'btn-sky';
                        } else{
                            varColor  = 'btn-green';
                        }

                        disparador = 0;
                        var precioDestino = d.totalNeto2;
                        d.totalNeto2Cl = ([65,85].indexOf(parseInt(d.plan_comision)) >= 0  && (parseFloat(d.totalNeto2Cl) < parseFloat(d.totalNeto2)) && (parseInt(d.proceso) == 2 || parseInt(d.proceso) == 4) ) ? ( d.totalNeto2Cl > d.totalNeto2 ? d.totalNeto2 : d.totalNeto2Cl ) :([65,85].indexOf(parseInt(d.plan_comision)) < 0 ? d.totalNeto2Cl : d.totalNeto2 );
                        d.totalNeto2Cl = (parseInt(d.proceso) == 6 || parseInt(d.proceso) == 5) ? ( ((parseFloat(d.sumaFusion) < parseFloat(d.totalNeto2) && d.cuantosDestinos == 1) || (d.cuantosDestinos > 1 && [41152,97660,3631,4479,4480].indexOf(parseInt(d.idLote)) < 0) )  ? parseFloat(d.sumaFusion / d.cuantosDestinos) :  parseFloat(d.totalNeto2)  ): d.totalNeto2Cl; 
                        if(d.bandera_dispersion == 1 && d.registro_comision == 9){//NUEVA VENTAS 1°
                            disparador = 1;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente_reubicacion_2;
                            plan_comision = d.plan_comisionReu;
                            descripcion_plan = d.descripcion_planReu;
                            ooamDispersion = 2;//NUEVA VENTAS 1°
                            nombreOtro = d.nombreOtro;
 
                        }else if(d.bandera_dispersion == 2 && d.registro_comision == 9){//REUBICADAS 1°
                            disparador = 1;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 1;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente_reubicacion_2;
                            plan_comision = d.plan_comisionReu;
                            descripcion_plan = d.descripcion_planReu;
                            ooamDispersion = 2; //REUBICADAS 1°
                            nombreOtro = d.nombreOtro;

                        } else if(d.bandera_dispersion == 3  && d.registro_comision == 9){//LIQUIDADA 1°
                            disparador = 1;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 1; //LIQUIDADA 1°
                            nombreOtro = '';

                                    
                        }else if(d.bandera_dispersion == 1  && d.registro_comision != 9 && validarLiquidadas == 0){//NUEVA VENTAS 2°
                            disparador = 2;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente_reubicacion_2;
                            plan_comision = d.plan_comisionReu;
                            descripcion_plan = d.descripcion_planReu;
                            ooamDispersion = 2; //NUEVA VENTAS 2°
                            nombreOtro = '';

                        }else if(d.bandera_dispersion == 2  && d.registro_comision != 9){//REUBICADAS 2°
                            disparador = 2;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 1;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente_reubicacion_2;
                            plan_comision = d.plan_comisionReu;
                            descripcion_plan = d.descripcion_planReu;
                            ooamDispersion = 2; //REUBICADAS 2°
                            nombreOtro = '';

                        } else if(d.bandera_dispersion == 3 && d.registro_comision != 9){//LIQUIDADA 2°
                            disparador = 2;   
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 1; //LIQUIDADA 2°
                            nombreOtro = '';

                        } else if(d.bandera_dispersion == 0 && (d.registro_comision == 0 || d.registro_comision == 8)){//VENTA NORMAL 1°
                            disparador = 1;
                            totalLote = d.totalNeto2;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 0; //VENTAS SIN REESTRUCTURA
                            nombreOtro = '';

                        } else if(d.bandera_dispersion == 0 && d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0 && d.reubicadas == 0 ){// NORMAL 2°
                            disparador = 2;
                            totalLote = d.totalNeto2;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 0; //VENTAS SIN REESTRUCTURA
                            nombreOtro = '';
                        } 
                        else if(d.bandera_dispersion == 0 && d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0 && d.reubicadas != 0 ){ //VENTAS CON REESTRUCTURA OOAM 1,31

                            disparador = 2;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 1;
                            nombreLote = d.nombreLoteReub;
                            id_cliente = d.id_cliente_reubicacion_2;
                            plan_comision = d.plan_comisionReu;
                            descripcion_plan = d.descripcion_planReu;
                            ooamDispersion = 2;  //VENTAS CON REESTRUCTURA OOAM 1,31
                            nombreOtro = '';
                        } 

                        else if(d.registro_comision == 1 && d.validaLiquidadas == 1 && d.banderaOOAM == 0 ){// OOAM 1°
                            disparador = 3;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 1;  //OOAM 1°
                            nombreOtro = '';
                        } 

                        else if((d.registro_comision == 1 && d.validaLiquidadas == 1 && d.banderaOOAM > 0 ) || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM > 0 ) ){// OOAM 1°
                            disparador = 2;
                            totalLote = d.totalNeto2Cl;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 1;  //OOAM 1°
                            nombreOtro = '';
                        }

                        if(disparador != 0){
                            // BtnStats += `${disparador}`; 
                            d.abonadoAnterior = [2,3,4,7].includes(parseInt(d.proceso)) ? parseFloat(d.sumComisionesReu) + parseFloat(d.abonadoAnterior) : d.abonadoAnterior;
                            let disableRew = parseInt(d.plan_comision) == 56 ? ( parseInt(d.idStatusContratacion) == 15 ? '' : 'disabled' ) : '';
                            BtnStats += `<button href="#" 
                            value = "${d.idLote}" 
                            data-totalNeto2 = "${totalLote}"
                            data-totalNeto2Cl = "${d.totalNeto2Cl}" 
                            data-total8P = "${d.total8P}"
                            data-precioDestino= "${precioDestino}"
                            data-reubicadas = "${reubicadas}" 
                            data-penalizacion = "${d.penalizacion}"
                            data-nombreLote = "${nombreLote}" 
                            data-nombreOtro = "${nombreOtro}" 
                            data-banderaPenalizacion = "${d.bandera_penalizacion}" 
                            data-cliente = "${id_cliente}" 
                            data-plan = "${plan_comision}" 
                            data-disparador = "${disparador}" 
                            data-tipov = "${d.tipo_venta}"
                            data-descplan = "${descripcion_plan}" 
                            data-ooam = "${ooamDispersion}"
                            data-estatusLote = "${d.idStatusContratacion}"
                            data-abonadoAnterior = "${d.abonadoAnterior}"
                            data-procesoReestructura = "${d.proceso}"
                            data-code = "${d.cbbtton}"
                            data-opcionMensualidad = "${d.opcionMensualidad}"
                            data-nombreMensualidad = "${d.nombreMensualidad}"
                            class = "btn-data ${varColor} verify_neodata" data-toggle="tooltip" ${disableRew}  data-placement="top" title="${ Mensaje }"><span class="material-icons">verified_user</span></button> ${RegresaActiva}`;
                            
                            BtnStats += `<button href="#" value="${d.idLote}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas btn-detener btn-warning" data-toggle="tooltip"  data-placement="top" title="Detener"> <i class="material-icons">block</i> </button>`;
                        }else{
                            BtnStats += ``;
                        
                    }   

                    }
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }}
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getDataDispersionPago',
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    })

    $('#tabla_dispersar_comisiones tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_comisiones').DataTable().row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Director: </b>` + row.data().director + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Regional: </b>` + row.data().regional + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Subdirector: </b>` + row.data().subdirector + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
            </div></div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-detener', function () {
        $("#motivo").val("");
        $("#motivo").selectpicker('refresh');
        $("#descripcion").val("");
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const statusLote = $(this).attr("data-statusLote");

        $('#id-lote-detenido').val(idLote);
        $('#statusLote').val(statusLote);
        $('#anterior').val(0);

        $("#detenciones-modal .modal-header").html("");
                
        $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            if(data.length > 0){
                $('#saldoNeodata').val(data[0].Aplicado);
                $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Enviar a controversia: <b>'+nombreLote+'</b></h4>');

            } else{
                $('#saldoNeodata').val(0);
                $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Sin localizar en NEODATA  <b>'+nombreLote+'</b>, el lote se enviará a controversia sin embargo hay que regresarlo manualmente ya que no detectamos saldo ligado a este lote y es indispensable para regresarlo automáticamente. </h4>');
            }     
        }); 

        $("#detenciones-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-penalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_penalizacion').val(idLote);
        $('#id_cliente_penalizacion').val(idCliente);
        $("#penalizacion-modal .modal-header").html("");
        $("#penalizacion-modal .modal-header").append('<h4 class="modal-title"> Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes correspondientes.</P>');
        $("#penalizacion-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-penalizacion4', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id-lote-penalizacion4').val(idLote);
        $('#id-cliente-penalizacion4').val(idCliente);
        $("#penalizacion4-modal .modal-header").html("");
        $("#penalizacion4-modal .modal-header").append('<h4 class="modal-title">Penalización + 160 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes asignados.</P>');
        $("#penalizacion4-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-Nopenalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_cancelar').val(idLote);
        $('#id_cliente_cancelar').val(idCliente);
        $("#Nopenalizacion-modal .modal-header").html("");
        $("#Nopenalizacion-modal .modal-header").append('<h4 class="modal-title"> Cancelar Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al cancelar esta penalización no se podrán revertir los cambios.</P>');
        $("#Nopenalizacion-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on("click", ".verify_neodata", async function(){

        
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_comisiones').DataTable().row(tr);
        let cadena = '';

        idLote = $(this).val();
        totalNeto2 = $(this).attr("data-totalNeto2");
        totalNeto2Cl = $(this).attr("data-totalNeto2Cl");
        total8P = $(this).attr("data-total8P");
        reubicadas = $(this).attr("data-reubicadas");
        penalizacion = $(this).attr("data-penalizacion");
        nombreLote = $(this).attr("data-nombreLote");
        bandera_penalizacion = $(this).attr("data-banderaPenalizacion");
        idCliente = $(this).attr("data-cliente");
        plan_comision = $(this).attr("data-plan");
        disparador = $(this).attr("data-disparador");
        tipo_venta = $(this).attr("data-tipov");
        descripcion_plan = $(this).attr("data-descplan");
        ooamDispersion = $(this).attr("data-ooam");
        nombreOtro = $(this).attr("data-nombreOtro");
        estatusLote = $(this).attr("data-estatusLote");
        abonadoAnterior = $(this).attr("data-abonadoAnterior");
        procesoReestructura = $(this).attr("data-procesoReestructura");

        opcionMensualidad = $(this).attr("data-opcionMensualidad");
        nombreMensualidad = $(this).attr("data-nombreMensualidad");

        precioDestino = $(this).attr("data-precioDestino");
        totalNeto2 = (plan_comision == 66 || plan_comision == 86) ? total8P : totalNeto2;


        if(parseFloat(totalNeto2) > 0){

            // alert(ooamDispersion);
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                var AplicadoGlobal = data.length > 0 ? data[0].Aplicado : 0;
                if(data.length > 0){
                    switch (data[0].Marca) {
                        case 0:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                        break;
                        case 1:
                            if((disparador == 1 || disparador == 3)){
                                //COMISION NUEVA
                                let total0 = parseFloat(data[0].Aplicado-abonadoAnterior);
                                let total = 0;
                                let totalPivote=0;
                                if(total0 > 0){
                                    total = total0;
                                }else{
                                    total = 0;
                                }
                                // INICIO BONIFICACION y PLAN 66
                                bonificadoTotal = 0;

                                if(parseFloat(data[0].Bonificado) > 0){
                                    bonificadoTotal = data[0].Bonificado;
                                }

                                $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value=">${bonificadoTotal}">`);
                                
                                if(plan_comision == 66 || plan_comision == 86){
                                    cadena = 
                                    `<div class="col-md-3 p-0">
                                        <h5>Bonificación: <b style="color:#D84B16;">${formatMoney(bonificadoTotal)}</b></h5>
                                    </div>
                                    
                                    <div class="col-md-4 p-0">
                                        <h5>Precio Lote Origen: <b>${formatMoney(totalNeto2Cl)}</b></h5>
                                    </div>

                                    <div class="col-md-4 p-0">
                                        <h5>Excedente: <b>${formatMoney(total8P)}</b></h5>
                                    </div>
                                    `;
                                } else{
                                    cadena = 
                                    `<div class="col-12">
                                        <h5>Bonificación: <b style="color:#D84B16;">${formatMoney(bonificadoTotal)}</b></h5>
                                    </div>
                                    `;
                                }
                                // FINAL BONIFICACION y PLAN 66

                                let labelPenalizacion = '';
                                if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">(Penalización + 90 días)</b>';}
                                $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h3>Lote: <b>${nombreLote}${labelPenalizacion}</b></h3>
                                            </div>
                                        </div>
                                        
                                            <div class="col-md-3 pl-2">
                                                <h5>Tipo Mensualidad: <b><span class="card-title">${nombreMensualidad}</span></b></h5>
                                            </div>

                                            <div class="col-md-3 p-0">
                                                <h5>Precio Lote: <b>${(plan_comision == 66 || plan_comision == 86) ? formatMoney(precioDestino) : formatMoney(totalNeto2)}</b></h5>
                                            </div>

                                            <div class="col-md-3 p-0">
                                                <h5>NEODATA: <b style="color:${data[0].Aplicado <= 0 ? 'black' : 'blue'};">${formatMoney(data[0].Aplicado)}</b></h5>
                                            </div>

                                            <div class="col-md-3 p-0">
                                                <h5>Pagado: <b style="color:'black;">${formatMoney(abonadoAnterior)}</b></h5>
                                            </div>

                                            <div class="col-md-3 p-0">
                                                <h5>Disponible: <b style="color:green;">${formatMoney(total0)}</b></h5>
                                            </div>
                                                    ${cadena}
                                        </div>`);

                                        
                                // OPERACION PARA SACAR 5% y 8%
                                operacionA = (totalNeto2 * 0.05).toFixed(3);
                                operacionB = (totalNeto2 * 0.08).toFixed(3);
                                cincoporciento = parseFloat(operacionA);
                                ochoporciento = parseFloat(operacionB);
                                var porcentajeAbonado = ((total * 100) / totalNeto2);
                                console.log('%%%%%%%%%%'+porcentajeAbonado);

                                if(procesoReestructura != 0 && estatusLote < 15 && ooamDispersion == 1 ){
                                // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Dispersión OOAM 50%</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 3; //[2,4,7].includes(parseInt(procesoReestructura)) ? 4 : 3;
                                } else if(procesoReestructura != 0 && estatusLote >= 15 && ooamDispersion == 1){
                                    // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Dispersión OOAM</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                        bandera_anticipo = 4;
                                } else if(total<(cincoporciento-1) && (disparador != 3 || ooamDispersion == 2)){
                                // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                console.log('Si el monto es menor al 5% ');
                                $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo menor al 5%</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 0;
                                }else if(total>=(ochoporciento) && (disparador != 3 || ooamDispersion == 2) ){
                                // *********Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% / se dispersa la mitad
                                console.log('Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% ');
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo mayor/igual al 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`); 
                                    bandera_anticipo = 1;
                                } else if(total>=(cincoporciento-1) && total<(ochoporciento) && (disparador != 3 || ooamDispersion == 2) ){
                                    console.log('Si el monto el igual o mayor a 5% y menor al 8% ');
                                // *********Si el monto el igual o mayor a 5% y menor al 8% se dispersará la 4° parte de la comisión
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo entre 5% - 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 2;
                                } 
                                console.log(bandera_anticipo);

                                // FIN BANDERA OPERACION PARA SACAR 5%
                                $("#modal_NEODATA .modal-body").append(`<div class="row rowTitulos">
                                <div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div>
                                <div class="col-md-1"><b>%</b></div>
                                <div class="col-md-2"><b>TOT. COMISIÓN</b></div>
                                <div class="col-md-2"><b><b>ABONADO</b></div>
                                <div class="col-md-2"><b>PENDIENTE</b></div>
                                <div class="col-md-2"><b>DISPONIBLE</b></div>
                                </div>`);
                                
                                var_sum = 0;
                                let abonado=0;
                                let porcentaje_abono=0;
                                let total_comision=0;

                                const datosPlan8PAnterior =  [
                                    {
                                        idRol:7,
                                        porcentaje:0.50
                                    },
                                    {
                                        idRol:3,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:2,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:1,
                                        porcentaje:0.1
                                    }
                                ];
                                const datosPlan8PNuevo =  [
                                    {
                                        idRol:7,
                                        porcentaje:0.50
                                    },
                                    {
                                        idRol:3,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:2,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:59,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:1,
                                        porcentaje:0.1
                                    }
                                ];
                                const datosPlan8P = plan_comision == 66 ? datosPlan8PAnterior : datosPlan8PNuevo;

                                $.post(general_base_url + "Comisiones/porcentajes",{idCliente:idCliente,totalNeto2:totalNeto2,plan_comision:plan_comision,reubicadas:reubicadas,ooamDispersion:ooamDispersion}, function (resultArr) {
                                    resultArr = JSON.parse(resultArr);
                                    //console.log(disparador)
                                    var SumaComisionTotal = 0;
                                    var sumaAsesorCoor = 0;
                                    var cuantosAsesores = 0;
                                    var cuantosCoor = 0;
                                    var comisionTotalRewards = 0;
                                    var porcentajeReferido = 0;
                                    $.each( resultArr, function( i, v){
                                        SumaComisionTotal = SumaComisionTotal + v.comision_total;
                                        if(parseInt(v.id_usuario) == 12841 && plan_comision == 56){ // MADERAS REWORDS
                                            comisionTotalRewards = v.comision_total;
                                            porcentajeReferido = ((comisionTotalRewards * 100) / total);
                                        }
                                        if(v.id_rol == 7){
                                            cuantosAsesores = cuantosAsesores + 1; 
                                        }if(v.id_rol == 9){
                                            cuantosCoor = cuantosCoor + 1; 
                                        }
                                    });
                                    console.log(SumaComisionTotal);
                                    const busquedaPivote = pivoteMultiplicador.find((planes) => planes.id_plan == parseInt(plan_comision));
                                    console.log(busquedaPivote);
                                    let pivoteNuevas = busquedaPivote == undefined ? 0.125 : (busquedaPivote.valor / 100);
                                   // console.log(totalNeto2Cl*(busquedaPivote.porcentaje /100))
                                    SumaComisionTotal = busquedaPivote != undefined ? SumaComisionTotal + (totalNeto2Cl*(busquedaPivote.valor / 100)) : SumaComisionTotal;
                                    $.each( resultArr, function( i, v){
                                        let porcentajes = '';
                                        if(plan_comision == 66 || plan_comision == 86){
                                            v.id_rol = plan_comision == 86 && v.id_usuario == 13546 ? 59 : v.id_rol;
                                            const busqueda = datosPlan8P.find((roles) => roles.idRol == v.id_rol);
                                            porcentajes = busqueda != undefined ? `<p style="font-size:12px;">${busqueda.porcentaje}% L.O. + ${v.porcentaje_decimal}% E.</p>` : '' ;
                                            v.porcentaje_decimal = busqueda != undefined ? v.porcentaje_decimal + busqueda.porcentaje : v.porcentaje_decimal;
                                            v.comision_total = busqueda != undefined ? (v.comision_total + ((busqueda.porcentaje/100)) * totalNeto2Cl) : v.comision_total;
                                        }

                                        let porcentajeAse = v.porcentaje_decimal;
                                        let total_comision1 = 0;
                                        total_comision1 = totalNeto2 * (porcentajeAse / 100);
                                        let saldo1 = 0;
                                        let total_vo = 0;
                                        total_vo = total;
                                        saldo1 = total_vo * (v.porcentaje_neodata / 100);
                                        if(saldo1 > total_comision1){
                                            saldo1 = total_comision1;
                                        }else if(saldo1 < total_comision1){
                                            saldo1 = saldo1;
                                        }else if(saldo1 < 1){
                                            saldo1 = 0;
                                        }
                                        let resto1 = 0;
                                        resto1 = total_comision1 - saldo1;
                                        if(resto1 < 1){
                                            resto1 = 0;
                                        }else{
                                            resto1 = total_comision1 - saldo1;
                                        }
                                        let saldo1C = 0;
                                        console.log(total)

                                        total = [2,3,4,7].includes(parseInt(procesoReestructura)) ? total  : total;
                                        total = ([2,3,4,7].includes(parseInt(procesoReestructura)) && (data[0].Aplicado-abonadoAnterior) <= 0) ? 0 : total;
                                        totalPivote = total;
                                        console.log('------------')
                                        console.log(SumaComisionTotal)
                                        console.log(estatusLote)
                                        console.log(procesoReestructura)
                                        console.log(plan_comision)
                                        console.log(data[0].Aplicado-abonadoAnterior)

                                        if((parseInt(estatusLote) === 15 && [2,3,4,7].includes(parseInt(procesoReestructura)) && ((data[0].Aplicado-abonadoAnterior) > 6000) && [64,65,66,84,85,86].includes(parseInt(plan_comision))) || idLote == 58052){
                                            total = parseFloat(SumaComisionTotal) < total ? AplicadoGlobal : total;
                                           // total = idLote == 63107 ? AplicadoGlobal : total;
                                           console.log(total);
                                            console.log(9);
                                        }else  if(estatusLote < 15 && [2,3,4,7].includes(parseInt(procesoReestructura)) && ((data[0].Aplicado-abonadoAnterior) > (SumaComisionTotal / 2) && [64,65,66,84,85,86].includes(parseInt(plan_comision)) )){
                                            console.log(8);
                                            total = (SumaComisionTotal / 2) < total ? AplicadoGlobal : total;
                                        }else {
                                            console.log(7);
                                            total = SumaComisionTotal < total ? AplicadoGlobal : total;
                                            total = totalPivote;
                                            total = idLote == 52436 ? ((data[0].Aplicado-abonadoAnterior) - 7859.826399999984) : total;
                                            console.log(total);

                                        }

                                        
                                       // console.log('Suma porcentajes: ' +sumaAsesorCoor);
                                        switch(bandera_anticipo){
                                            case 0:// monto < 5% se dispersará solo lo proporcional
                                                    if(plan_comision == 56){

                                                        let totalOperacion = total;
                                                        let nuevoPorcentaje = 0;
                                            let porcentajeMaderas = 0;
                                                        //let porcentajeReferido = 0;
                                                        /*if(porcentajeAbonado < 1){ //ATICIPO MENOR AL 1%
                                                            let porcentajeRestante = 100; //- porcentajeReferido;

                                                            if(parseInt(v.id_usuario) == 12841){
                                                                porcentajeMaderas =  (8 * (porcentajeReferido / 100));
                                                                nuevoPorcentaje = porcentajeMaderas;

                                                            }else{
                                                                if([7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){
                                                                    console.log('porcentaje restante'+porcentajeRestante);
                                                                    nuevoPorcentaje = v.id_rol == 7 ? (8 * (33.335  / cuantosAsesores) /100): (8 *(13.333  / cuantosCoor) /100);
                                                                    console.log('nuevo porcentaje ' + nuevoPorcentaje)
                                                                }else{
                                                                    nuevoPorcentaje = 0;
                                                                }

                                                            } 
                                                        }else*/ if(porcentajeAbonado < 5){ // ABONADO ENTRE EL 5 Y EL 2%
                                                            let porcentajeRestante = 100;// - porcentajeReferido;

                                                            if(parseInt(v.id_usuario) == 12841){
                                                                porcentajeMaderas =  (8 * (porcentajeReferido / 100));
                                                                nuevoPorcentaje = porcentajeMaderas;
                                                                totalOperacion = totalOperacion;
                                                            }else{
                                                                if([7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){
                                                                    console.log('porcentaje restante'+porcentajeRestante);
                                                                    nuevoPorcentaje = v.id_rol == 7 ? (8 * (33.335  / cuantosAsesores) /100): (8 *(13.333 / cuantosCoor) /100);
                                                                    console.log('nuevo porcentaje ' + nuevoPorcentaje)
                                                                }else{
                                                                    nuevoPorcentaje = (8 * 13.333  /100);
                                                                }
                                                                totalOperacion = totalOperacion - comisionTotalRewards;
                                                            }
                                                        }
                                                        /*if(plan_comision == 56 && [7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){ //MADERAS REWORDS
                                                        porcentajeMaderas = 0;
                                                    }
                                                    else if(plan_comision == 56 && parseInt(v.id_usuario) == 12841){
                                                        porcentajeMaderas = v.porcentaje_decimal + sumaAsesorCoor;
                                                        } */
                                                       
                                                            operacionValidar = (totalOperacion*(pivoteNuevas*nuevoPorcentaje));
                                                    }else{
                                                        operacionValidar = (total*(pivoteNuevas*v.porcentaje_decimal));
                                                    }
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;
                                            case 1:// monto igual o mayor a 8% dispersar 12.5% / la mitad
                                            console.log("del 8 al 12");
                                            operacionValidar = parseInt(v.id_usuario) == 12841 ? total_comision1 : (total_comision1 / 2);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;
                                            case 2: // monto entre 5% y 8% dispersar 4 parte
                                            console.log("del 5 al 8");
                                            if(plan_comision == 56){
                                                let totalOperacion = total;
                                                let nuevoPorcentaje = 0;
                                                let porcentajeMaderas = 0;
                                                 if(porcentajeAbonado >= 5 && porcentajeAbonado < 8){ // ABONADO ENTRE EL 5 Y EL 2%
                                                    let porcentajeRestante = 100;
                                                    if(parseInt(v.id_usuario) == 12841){
                                                        porcentajeMaderas =  (8 * (porcentajeReferido / 100));
                                                        nuevoPorcentaje = porcentajeMaderas;
                                                        totalOperacion = totalOperacion;
                                                    }else{
                                                        if([7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){
                                                            console.log('porcentaje restante'+porcentajeRestante);
                                                            nuevoPorcentaje = v.id_rol == 7 ? (8 * (33.335  / cuantosAsesores) /100): (8 *(13.333 / cuantosCoor) /100);
                                                            console.log('nuevo porcentaje ' + nuevoPorcentaje)
                                                        }else{
                                                            nuevoPorcentaje = (8 * 13.333  /100);
                                                        }
                                                        totalOperacion = totalOperacion - comisionTotalRewards;
                                                    }
                                                }
                                            operacionValidar = (totalOperacion*(pivoteNuevas*nuevoPorcentaje));
                                            }else{
                                                operacionValidar =  (total_comision1 / 2);
                                            }
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;
                                            case 3: // monto OOAM 50%
                                            operacionValidar = (total*(pivoteNuevas*v.porcentaje_decimal));
                                            if(operacionValidar > (v.comision_total/2)){
                                                saldo1C = (v.comision_total/2);
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;

                                            case 4: // monto OOAM 100%
                                            operacionValidar = idLote == 63107 ? (total*((2)*v.porcentaje_decimal)) : (total*(pivoteNuevas*v.porcentaje_decimal));
                                            console.log('total'+total);
                                            console.log('operacionValidar'+operacionValidar);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }

                                            break;

                                        }

                                        total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                        abonado = parseFloat(abonado) +parseFloat(saldo1C);
                                        porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                                $("#modal_NEODATA .modal-body").append(`
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label id="" class="control-label labelNombre hide">Usuarios</label>
                                                            <input type="hidden" name="penalizacion" id="penalizacion" value="${penalizacion}"><input type="hidden" name="nombreLote" id="nombreLote" value="${nombreLote}">
                                                            <input type="hidden" name="plan_c" id="plan_c" value="${plan_comision}">
                                                            <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}"><input id="num_usuarios" type="hidden" name="num_usuarios[]" value="${v.num_usuarios}">
                                                            <input class="form-control input-gral" required readonly="true" value="${v.nombre}" style="font-size:12px;"><b><p style="font-size:12px;margin-bottom:0px !important;">${v.detail_rol}</p></b>${porcentajes}
                                                            
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label id="" class="control-label labelPorcentaje hide">%</label>
                                                            <input class="form-control input-gral" name="porcentaje[]"  required readonly="true" type="hidden" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : parseFloat(v.porcentaje_decimal)}">
                                                            <input class="form-control input-gral" style="padding:10px;" required readonly="true" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : v.porcentaje_decimal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelTC hide">Total de la comisión</label>
                                                            <input class="form-control input-gral" name="comision_total[]" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelAbonado hide">Abonado</label>
                                                            <input class="form-control input-gral" name="comision_abonada[]" required readonly="true" value="${formatMoney(0)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelPendiente hide">Pendiente</label>
                                                            <input class="form-control input-gral" name="comision_pendiente[]" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelDisponible hide">Disponible</label>
                                                            <input class="form-control input-gral decimals" name="comision_dar[]"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo1C)}">
                                                        </div>
                                                    </div>`);
                                                if(i == resultArr.length -1){
                                                    $("#modal_NEODATA .modal-body").append(`
                                                    <input type="hidden" name="pago_neo" id="pago_neo" value="${formatMoney(data[0].Aplicado)}">
                                                    <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                    <input type="hidden" name="porcentaje_abono" id="porcentaje_abono" value="${porcentaje_abono}">
                                                    <input type="hidden" name="abonado" id="abonado" value="${formatMoney(abonado)}">
                                                    <input type="hidden" name="total_comision" id="total_comision" value="${formatMoney(total_comision)}">
                                                    <input type="hidden" name="bonificacion" id="bonificacion" value="${formatMoney(data[0].Bonificado)}">
                                                    <input type="hidden" name="pendiente" id="pendiente" value="${formatMoney(total_comision-abonado)}">
                                                    <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                                                    <input type="hidden" name="id_disparador" id="id_disparador" value="${disparador}">
                                                    <input type="hidden" name="ooamValor" id="ooamValor" value="${ooamDispersion}">
                                                    <input type="hidden" name="totalNeto2" id="totalNeto2" value="${totalNeto2}">
                                                    <input type="hidden" name="nombreOtro" id="nombreOtro" value="${nombreOtro}">
                                                    
                                                    `);
                                                }
                                    });
                                    responsive(maxWidth);
                                    $("#modal_NEODATA .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersar" value="Dispersar"></div>');
                                });
                            }
                            else{
                                $.getJSON( general_base_url + "Comisiones/getDatosAbonadoSuma11/"+idLote+"/"+ooamDispersion).done( function( data1 ){
                                    var cuantosAsesores = 0;
                                    var cuantosCoor = 0;
                                    $.each( data1, function( i, v){
                                        if(v.id_rol == 7){
                                            cuantosAsesores = cuantosAsesores + 1; 
                                        }if(v.id_rol == 9){
                                            cuantosCoor = cuantosCoor + 1; 
                                        }
                                    });
                                    console.log('procesoReestructura '+procesoReestructura);
                                    console.log('abonadoAnterior '+abonadoAnterior);
                                    let total0 = [2,3,4,7].includes(parseInt(procesoReestructura)) ? parseFloat((data[0].Aplicado - abonadoAnterior)) : parseFloat((data[0].Aplicado));
                                    let total = 0;
                                    if(total0 > 0){
                                        total = total0;
                                    }
                                    else{
                                        total = 0;
                                    }
                                    var counts=0;
                                    let labelPenalizacion = '';
                                    // data1[0].abonado
                                    console.log('total0 '+total0);
                                    if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">Lote con Penalización + 90 días</b>';}
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${row.data().nombreLote}</i>: <b>${formatMoney([2,3,4,7].includes(parseInt(procesoReestructura)) ? total0 : (total0-(data1[0].abonado)))}</b><br>${labelPenalizacion}</h3></div></div><br>`);
                                    $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-4 pl-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div>
                                            <div class="col-md-4">Total abonado: <b style="color:green">${formatMoney(abonadoAnterior)}</b></div>
                                            <div class="col-md-4">Total pendiente: <b style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div>
                                        </div>
                                        <div class="col-md-3 pl-2">
                                            <h5>Tipo Mensualidad: <b><span class="card-title">${nombreMensualidad}</span></b></h5>
                                        </div>

                                    `);
                                   let cadenaExcedente = [4,6,7].indexOf(parseInt(procesoReestructura)) >= 0 ? `<h4>Excedente: <b>${formatMoney(total8P)}</b></h4>` : ''; 
                                    console.log([4,6,7].indexOf(parseInt(procesoReestructura)));
                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = `<h4>Bonificación: <b style="color:#D84B16;">$${formatMoney(data[0].Bonificado)}</b></h4>${cadenaExcedente}`;
                                    }else{
                                        cadena = `<h4>Bonificación: <b >${formatMoney(0)}</b></h4>${cadenaExcedente}`;
                                    }
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: ${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                    <div class="col-md-4"><h4>Aplicado neodata: <b>${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                    </div><br>`);

                                    $.getJSON( general_base_url + "Comisiones/getDatosAbonadoDispersion/"+idLote+"/"+ooamDispersion+"/"+data1[0].estructura).done( function( data ){
                                        $("#modal_NEODATA .modal-body").append(`
                                                        <div class="row">
                                                            <div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div>
                                                            <div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div>
                                                            <div class="col-md-2"><b><b>ABONADO</b></div>
                                                            <div class="col-md-2"><b>PENDIENTE</b></div>
                                                            <div class="col-md-2"><b>DISPONIBLE</b></div>
                                                        </div>`);
                                        let contador=0;
                                        let coor = data.length;
                                        for (let index = 0; index < data.length; index++) {
                                            const element = data[index].id_usuario;
                                            if(data[index].id_usuario == 5855){
                                                contador += 1;
                                            }
                                        }
                                        total = plan_comision == 56 ? total - data1[0].abonado : total;
                                        $.each( data, function( i, v){
                                            saldo =0;
                                            if(tipo_venta == 7 && coor == 2){
                                                total = total - data1[0].abonado;
                                                saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.925*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                            }
                                            else if(tipo_venta == 7 && coor == 3){
                                                total = total - data1[0].abonado;
                                                saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.675*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : tipo_venta == 7 && v.rol_generado == "9" ?  (0.25*total) :   ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                            }
                                            else{
                                                
                                                let pendienteGlobal = parseFloat(data1[0].total_comision - data1[0].abonado);
                                                console.log('pendiente: '+pendienteGlobal);
                                                console.log('total: '+total);
                                                //saldo =  ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                /* buscar el valor divisor segun el % del plan*/

                                                    console.log(plan_comision);
                                                    const busquedaPivote = pivoteMultiplicador.find((planes) => planes.id_plan == parseInt(plan_comision));
                                                    console.log(busquedaPivote);
                                                    let pivote = busquedaPivote == undefined ? 12.5 : busquedaPivote.valor;
                                                    console.log(pivote);

                                                /**/ 
                                                console.log('SALDO-----------'+ saldo);
                                                console.log('TOTAL----------'+total);
                                                console.log('TOTAL----------'+AplicadoGlobal);
                                                v.porcentaje_decimal = idLote == 37629 && v.id_usuario == 13556 ? 2.5 : v.porcentaje_decimal;
                                                saldo = (([2,3,4,7].includes(parseInt(procesoReestructura)) && total > 2238.71) && idLote != 52454 ) ? ( pendienteGlobal > total ? ((pivote *(v.porcentaje_decimal / 100)) * total)  :  ((pivote *(v.porcentaje_decimal / 100)) * parseFloat(AplicadoGlobal)) ) : ((pivote *(v.porcentaje_decimal / 100)) * total);
                                                saldo = ([2,3,4,7].includes(parseInt(procesoReestructura)) && total <= 0) ? 0 : saldo;
                                                v.porcentaje_decimal = idLote == 37629 && v.id_usuario == 13556 ? 3.5 : v.porcentaje_decimal;
                                            
                                            }
                                            console.log('saldo'+saldo);

                                            if(parseFloat(v.abono_pagado) > 0){
                                                evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                                if(parseFloat(evaluar) < 0){
                                                    pending=evaluar;
                                                    saldo = 0;
                                                }
                                                else{
                                                    pending = evaluar;
                                                }
                                                console.log('saldo segundo '+saldo);
                                                console.log('saldo tercero '+ ( saldo-v.abono_pagado ));
                                                console.log('total::'+total);
                                                console.log('procesoReestructura::'+procesoReestructura);
                                                console.log('plan_comision::'+plan_comision);
                                                console.log('idLote::'+idLote);
                                                resta_1 = (([2,3,4,7].includes(parseInt(procesoReestructura)) && (total < 5000) ) || ([64,65,66,84,85,86,56].indexOf(plan_comision) >= 0 || [57154,48216,55933,52454,54261,63123,30499,40165,37107,40002,98054,98065,98066,98067,98068,98098,98104,98116,51295,56931,94223,98755,98756,98757,99924,100361,101117,102611,100059].indexOf(parseInt(idLote)) >= 0) || plan_comision == 56) ? saldo : ( saldo-v.abono_pagado );
                                                console.log('RESTA'+resta_1);
                                                if(parseFloat(resta_1) <= 0){
                                                    saldo = 0;
                                                }
                                                else if(parseFloat(resta_1) > 0){
                                                    if(parseFloat(resta_1) > parseFloat(pending)){
                                                        saldo = pending;
                                                    }
                                                    else{
                                                        console.log('entra hasta aca')
                                                        console.log(saldo)
                                                        saldo = (( [2,3,4,7].includes(parseInt(procesoReestructura))  && total < (5000)) || ([64,65,66,84,85,86,56].indexOf(parseInt(plan_comision)) >= 0 || [57154,48216,55933,52454,54261,63123,30499,40165,37107,40002,98054,98065,98066,98067,98068,98098,98104,98116,51295,56931,94223,98755,98756,98757,99924,100059,100361,101117,102611].indexOf(parseInt(idLote)) >= 0) || plan_comision == 56) ? saldo : saldo-v.abono_pagado;
                                                        console.log(saldo)
                                                    }
                                                }
                                            }
                                            else if(v.abono_pagado <= 0){
                                                pending = (v.comision_total);
                                                if(saldo > pending){
                                                    saldo = pending;
                                                }
                                                if(pending < 0){
                                                    saldo = 0;
                                                }
                                            }
                                            if( (parseFloat(saldo) + parseFloat(v.abono_pagado)) > (parseFloat(v.comision_total)+0.5 )){
                                                //ENTRA AQUI AL CERO
                                                saldo = 0;
                                            }

                                            console.log('----------------------------------------------------------------');

                                            $("#modal_NEODATA .modal-body").append(`<div class="row">
                                            <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="${disparador}"><input type="hidden" name="penalizacion" id="penalizacion" value="${penalizacion}"><input type="hidden" name="nombreLote" id="nombreLote" value="${nombreLote}"><input type="hidden" name="idCliente" id="idCliente" value="${idCliente}"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                            <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                            <input id="id_comision" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.rol_generado}">
                                            <input class="form-control input-gral" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                            <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>
                                            <div class="col-md-1"><input class="form-control input-gral" required readonly="true" style="padding: 10px; ${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}"></div>
                                            <div class="col-md-2"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control input-gral abono_nuevo" readonly="true"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                            <input class="form-control input-gral decimals"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo)}"></div></div>`);
                                            counts++
                                        });
                                    });
                                    $("#modal_NEODATA .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersar" value="Dispersar"></div>');

                                    if(total < 1 ){
                                        $('#dispersar').prop('disabled', true);
                                    }
                                    else{
                                        $('#dispersar').prop('disabled', false);
                                    }
                                });
                            }
                        break;
                        case 2:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 3:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 4:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 5:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        default:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento: .</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    }
                }
                else{
                    //QUERY SIN RESULTADOS
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            }); //FIN getStatusNeodata

            $("#modal_NEODATA").modal();
        }
    }); //FIN VERIFY_NEODATA
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


$('#detenidos-form').on('submit', function (e) {
    document.getElementById('detenerLote').disabled = true;
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToStopped',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#detenciones-modal').modal("hide");
                $("#id-lote-detenido").val("");
                document.getElementById('detenerLote').disabled = false;
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                $('#spiner-loader').addClass('hide');
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                $('#spiner-loader').addClass('hide');
            }
        }, error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#penalizacion-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToPenalizacion',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#penalizacion-modal').modal("hide");
                $("#id_lote_penalizacion").val("");
                $("#id_cliente_penalizacion").val("");
                $("#comentario_aceptado").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#penalizacion4-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToPenalizacionCuatro',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#penalizacion4-modal').modal("hide");
                $("#id-lote-penalizacionC").val("");
                $("#id-cliente-penalizacionC").val("");
                $("#asesor").val("");
                $("#coordinador").val("");
                $("#gerente").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#Nopenalizacion-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'cancelLoteToPenalizacion',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#Nopenalizacion-modal').modal("hide");
                $("#id_lote_cancelar").val("");
                $("#id_cliente_cancelar").val("");
                $("#comentario_rechazado").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_NEODATA").submit( function(e) {
    $('#dispersar').prop('disabled', true); 
    document.getElementById('dispersar').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Comisiones/InsertNeo',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1 ){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Dispersión guardada con éxito", "success");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                    $.ajax({
                        url: general_base_url + 'Comisiones/ultimaDispersion',
                        data: formulario,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST',
                        success:function(data){
                        numerosDispersion();
                        }
                    })
                } else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otro usuario", "warning");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
        jQuery(this).find('#totalNeto').val('');
        jQuery(this).find('#totalNeto2').val('');
    })

    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })

})

$('.decimals').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});

function SoloNumeros(evt){
    if(window.event){
        keynum = evt.keyCode;
    } else{
        keynum = evt.which;
    }
    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
        return true;
    } else{
        alerts.showNotification("top", "left", "Solo Numeros.", "danger");
        return false;
    }
}

$(document).on("click", "#searchByDateRange", function () {
    document.getElementById('mBody').innerHTML = '';
    var fecha2 = $('#endDate').val();
    var fecha1 = $('#beginDate').val();
    if(fecha1 == '' || fecha2 == ''){
        alerts.showNotification("top", "right", "Debes seleccionar ambas fechas", "info");
    }
    else{
        $('#spiner-loader').removeClass('hide');
        $.post(general_base_url + "Comisiones/getMontoDispersadoDates",{
            fecha1: fecha1,
            fecha2: fecha2
        },
        function (datos) {
            if(datos['datos_monto'][0].lotes == null ){
                $("#myModal .modal-body").append('<div class="row" id="divDatos2"><div class="col-md-12 d-flex"><p class="text-center"><p>SIN DATOS POR MOSTRAR</p></div></div>');
            }
            else{
                $("#myModal .modal-body").append('<div class="row" id="divDatos"><div class="col-md-5"><p class="category"><b>Monto</b>:'+formatMoney(datos['datos_monto'][0].monto)+'</p></div><div class="col-md-4"><p class="category"><b>Pagos</b>: '+datos['datos_monto'][0].pagos+'</p></div><div class="col-md-3"><p class="category"><b>Lotes</b>: '+datos['datos_monto'][0].lotes+'</p></div></div>');
            }
            $('#spiner-loader').addClass('hide');

        },"json");
    }
});

function cleanComments(){
    document.getElementById('mBody').innerHTML = '';
}

$("#my_updatebandera_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateBandera',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).attr("data-idpagoc");
        nombreLote = $(this).attr("data-nombreLote");
        $("#myUpdateBanderaModal .modal-body").html('');
        $("#myUpdateBanderaModal .modal-header").html('');
        $("#myUpdateBanderaModal .modal-header").append('<h4 class="modal-title">Enviar a activas: <b>'+nombreLote+'</b></h4>');
        $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">');
        $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(1);
});

function showDetailModal(idPlan) {
    cleanElement('detalle-tabla-div');
    cleanElement("mHeader");
    $('#spiner-loader').removeClass('hide');
    $('#planes-div').hide();
    $.ajax({
        url: `${general_base_url}Comisiones/getDetallePlanesComisiones/${idPlan}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#plan-detalle-tabla-tbody').empty();
            $('#title-plan').text(`Plan: ${data.descripcion}`);
            $('#detalle-plan-modal').modal();
            $('#detalle-tabla-div').hide();
            const roles = data.comisiones;
            $('#detalle-tabla-div').append(`
            <div class="row subBoxDetail" id="modalInformation">
                <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLANES DE COMISIÓN</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>PUESTO</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% COMISIÓN</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% NEODATA</b></label></div>
                <div class="prueba"></div>
            `)
            roles.forEach(rol => {
                if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                    $('#detalle-tabla-div .prueba').append(`
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${(rol.puesto.split(' ')[0]).toUpperCase()}</label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.neo)} %</label></div>
                    `);
                }

            });
            $('#detalle-tabla-div').append(`
            </div>`)
            $('#detalle-tabla-div').show();
            $('#spiner-loader').addClass('hide');
        },
        error: function(){
            alerts.showNotification("top", "right", "No hay datos por mostrar.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

$('#btn-detalle-plan').on('click', function () {
    cleanElement('mHeader');
    $('#planes-div').show();
    $('#planes').empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Comisiones/getPlanesComisiones`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].id_plan;
                const name = data[i].descripcion.toUpperCase();
                $('#planes').append($('<option>').val(id).text(name));
            }
            $("#detalle-plan-modal .modal-header").append('<h4 class="modal-title">Planes de comisión</h4>');
            $('#planes').selectpicker('refresh');
            $('#detalle-plan-modal').modal();
            $('#detalle-tabla-div').hide();
        }
    });
});

// Cambiar tabla
$('#planes').change(function () {
    cleanElement('detalle-tabla-div');
    const idPlan = $(this).val();
    if (idPlan !== '0' || idPlan !== NULL) {
        $.ajax({
            url: `${general_base_url}Comisiones/getDetallePlanesComisiones/${idPlan}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#plan-detalle-tabla-tbody').empty();
                $('#title-plan').text(`Plan: ${data.descripcion}`);
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();
                const roles = data.comisiones;
                $('#detalle-tabla-div').append(`
                <div class="row subBoxDetail" id="modalInformation">
                    <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLANES DE COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>PUESTO</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% NEODATA</b></label></div>
                    <div class="prueba"></div>
                `)
                roles.forEach(rol => {
                    if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                        $('#detalle-tabla-div .prueba').append(`
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${(rol.puesto.split(' ')[0]).toUpperCase()}</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.neo)} %</label></div>
                        `);
                    }

                });
                $('#detalle-tabla-div').append(`
                </div>`)
                $('#detalle-tabla-div').show();
            },
        });
    } else {
        $('#plan-detalle-tabla tbody').append('No tiene un plan asignado');
        $('#detalle-tabla-div').hide();
    }
});

function llenado (){
    $.ajax({
        type: 'POST',
        url: 'ultimoLlenado',
        contentType: false,
        cache: false,
        dataType:'json',
        success: function (data) {
            $("#llenadoPlan").modal();
            $('#tiempoRestante').removeClass('hide');
            if(data.date ==  undefined || data.date == false){
                $("#tiempoRestante").html("Disponible para ejecutar ");
                $('#cerradoPlan').removeClass('hide');
                $('#llenadoPlanbtn').removeClass('hide');
                $('#llenadoPlanbtn').removeClass('hide');
            }else{
                $('#llenadoPlanbtn').addClass('hide');
                $('#cerradoPlan').addClass('hide');
                $("#tiempoRestante").html("ultima ejecución : "+data.date[0].fecha_mostrar );
            }
        }
    })
}

$(document).on("click",".llenadoPlanbtn", function (e){
    $('#spiner-loader').removeClass('hide');
    document.getElementById('llenadoPlanbtn').disabled = true;
    let bandera = 0;
    $.ajax({
        type: 'POST',
        url: 'ultimoLlenado',
        contentType: false,
        cache: false,
        dataType:'json',
        success: function (data) {
            let ban ;
            if(data.date ==  undefined || data.date == false){
                bandera = 1;
                var milliseconds = new Date().getTime() + (1 * 60 * 60 * 4000);
                fecha_reinicio = new Date(milliseconds);
            }else{
                fecha_reinicio =  new Date(data.date[0].fecha_reinicio)
                fechaSitema =  new Date();
                if (fechaSitema.getTime() >= fecha_reinicio.getTime())  {
                    bandera = 1;
                }else{
                    bandera = 0;
                    document.getElementById('llenadoPlanbtn').disabled = false;
                }
            }
            if(bandera == 1 ){
                $.ajax({
                    type: 'POST',
                    url: 'nuevoLlenadoPlan',
                    contentType: false,
                    data: {
                        "fecha_reinicio"    : fecha_reinicio
                    },
                    cache: false,
                    dataType:'json',
                    success: function (data) {
                        if(data == true){
                            $.ajax({
                                type: 'POST',
                                url: '../ScheduleTasks_dos/LlenadoPlan',
                                contentType: false,
                                cache: false,
                                success: function (data) {
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Se ha corrido la funcion para llenar los planes de venta.", "success");
                                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload(null, false );
                                    $('#llenadoPlan').modal('toggle');
                                    document.getElementById('llenadoPlan').disabled = false;
                                }
                            });
                        }else{
                            if(data == 300 ){
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Ups, Error  300. aun no se cumple con las 4 horas de espera.", "warning");
                            }else{
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Ups,al guardar la información Error 315.", "warning");
                            }
                            // a; marcar este error es debido a que no se pudo guardar la informacion en la base
                            // al registrar un nuevo valor en historial llenado plan
                        }
                    }
                });
            }else {
                $('#spiner-loader').addClass('hide');
                document.getElementById('llenadoPlan').disabled = false;
                alerts.showNotification("top", "right", "Ups, aún no se cumple el tiempo de espera para volver a ejecutar.", "warning");
            }
        }
    });
});

function numerosDispersion(){
    $('#monto_label').html('');
    $('#pagos_label').html('');
    $('#lotes_label').html('');
    $.post(general_base_url + "/Comisiones/lotes", function (data) {
        let montoLabel = data.monto ;
        $('#monto_label').append(formatMoney(montoLabel));
        $('#pagos_label').append(data.pagos);
        $('#lotes_label').append(data.lotes);
    }, 'json');
}

$('#tabla_dispersar_comisiones').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


const formatMiles = (number) => {
    const exp = /(\d)(?=(\d{3})+(?!\d))/g;
    const rep = '$1,';
    return number.toString().replace(exp,rep);
}

function responsive(maxWidth) {
    if (maxWidth.matches ) { //true mayor 991
        $('.labelNombre').removeClass('hide');
        $('.labelPorcentaje').removeClass('hide');
        $('.labelTC').removeClass('hide');
        $('.labelAbonado').removeClass('hide');
        $('.labelPendiente').removeClass('hide');
        $('.labelDisponible').removeClass('hide');
        $('.rowTitulos').addClass('hide');
    } else { //false menor 991
        $('.labelNombre').addClass('hide');
        $('.labelPorcentaje').addClass('hide');
        $('.labelTC').addClass('hide');
        $('.labelAbonado').addClass('hide');
        $('.labelPendiente').addClass('hide');
        $('.labelDisponible').addClass('hide');
        $('.rowTitulos').removeClass('hide');
    }
}

function function_totales(){
    $.getJSON( general_base_url + "Comisiones/getMontoDispersado").done( function( data ){
        $cadena = '<b>'+formatMoney(data[0].monto)+'</b>';
        document.getElementById("monto_label").innerHTML = $cadena ;
    });
    $.getJSON( general_base_url + "Comisiones/getPagosDispersado").done( function( data ){
        $cadena01 = '<b>'+data[0].pagos+'</b>';
        document.getElementById("pagos_label").innerHTML = $cadena01 ;
    });
    $.getJSON( general_base_url + "Comisiones/getLotesDispersado").done( function( data ){
        $cadena02 = '<b>'+data[0].lotes+'</b>';
        document.getElementById("lotes_label").innerHTML = $cadena02 ;
    });
}

var maxWidth = window.matchMedia("(max-width: 992px)");
responsive(maxWidth);
maxWidth.addListener(responsive);