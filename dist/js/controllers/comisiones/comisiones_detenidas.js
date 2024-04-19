
$('#comisiones-detenidas-table').ready(function () {

    let titulos = [];
    $('#comisiones-detenidas-table thead tr:eq(0) th').each(function (i) {
        if (i !== 0) {
            const title = $(this).text();
            titulos.push(title);
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (comisionesDetenidasTabla.column(i).search() !== this.value) {
                    comisionesDetenidasTabla.column(i).search(this.value).draw();
                }
            });
        }
    });

    let comisionesDetenidasTabla = $('#comisiones-detenidas-table').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: "<i class='fa fa-file-excel-o' aria-hidden='true'></i>",
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES DETENIDAS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        pagingType: 'full_numbers',
        fixedHeader: true,
        scrollX: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + '/static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            'className': 'details-control',
            'orderable': false,
            'data': null,
            'defaultContent': `<div class='toggle-subTable'><i class='animacion fas fa-chevron-down fa-lg'></i></div>`
        },
        {
            data: 'nombreResidencial'
        },
        {
            data: 'nombreCondominio'
        },
        { 
            data: function (d) {

            if(d.id_cliente_reubicacion_2 >1 ) {
                nombreLote = d.nombreLoteReub;
            } else{
                nombreLote = d.nombreLote;
            }
            return nombreLote;
        }},
        {
            data: 'idLote'
        },
        {
            data: 'nombreCliente'
        },
        { 
            data: function (d) {
                return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span><br><span class="${d.colorProcesoCl}">${d.procesoCl}</span>`;
        }},
        { 
            data: function (d) {
            var labelCompartida;

            if(d.compartida == null) {
                labelCompartida ='<span class="label lbl-yellow">Individual</span>';
            } else{
                labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
            }
            return labelCompartida;
        }},
        { 
            data: function (d) {
            var labelStatus;

            if(d.idStatusContratacion == 15) {
                labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
            }else {
                labelStatus ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
            }
            return labelStatus;
        }},
        { 
            data: function (d) {
            var labelEstatus;

            if(d.penalizacion == 1 && (d.bandera_penalizacion == 0 || d.bandera_penalizacion == 1) ){
                labelEstatus =`<p class="m-0"><b>Penalización ${d.dias_atraso} días</b></p><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
            }
            else{
                if(d.totalNeto2 == null) {
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
        { 
            data: function (d) {
            let motivo;
            let color;

            if (d.motivo == 4 || d.motivo == 5 || d.motivo == 3 || d.motivo == 6 || d.motivo == 8) {
                motivo = d.motivoOpc;
            } else {
                color = 'lbl-azure';
                motivo = d.motivo;
            }
            return '<span class="label lbl-gray">' + motivo + '</span>';
        }},
        { 
            data: function (d) {
            var fechaActualizacion;

            if(d.fecha_sistema == null) {
                fechaActualizacion ='<span class="label lbl-gray">Sin Definir</span>';
            }else {
                fechaActualizacion = '<span class="label lbl-azure">'+d.fecha_sistema+'</span>';
            }
            
            return fechaActualizacion;
        }},
        {
            data: function (d) {
                let botton = '';
                
                if (id_rol_general != 63 && id_rol_general != 4) {
                    if(id_usuario_general == 2749 || id_usuario_general == 2807 || id_usuario_general == 2767 || id_usuario_general == 11947	){
                        botton = `<div class="d-flex justify-center"><button value="${d.idLote}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas btn-cambiar-estatus" data-toggle="tooltip" data-placement="top" title="REGRESAR A DISPERSIÓN"><i class="material-icons">undo</i></button></div>`;
                    }else{
                        botton = `NO APLICA`;
                    }
                    return botton;
                } else {
                    return 'NO APLICA';
                }
            }
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            'url': general_base_url + 'Comisiones/getDataDetenidas',
            'dataSrc': '',
            'type': 'GET',
            cache: false,
            'data': function (d) { }
        },
    });

    $('#comisiones-detenidas-table').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $('#comisiones-detenidas-table tbody').on('click', 'td.details-control', function () {
        const tr = $(this).closest('tr');
        const row = comisionesDetenidasTabla.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            row.child(`<div class="container subBoxDetail">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                            <label><b>Descripción</b></label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding: 10px 30px 0 30px;">
                            <label>` + row.data().comentario + `</label>
                        </div>
                    </div>
                </div>`).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $('#comisiones-detenidas-table tbody').on('click', '.btn-cambiar-estatus', function () {
        const idLote = $(this).val();
        let data = new FormData();
        data.append('idLote', idLote);
        $.ajax({
            type: 'POST',
            url: 'updateBanderaDetenida',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('#estatus-modal').modal("hide");
                    $("#id-lote").val("");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    comisionesDetenidasTabla.ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                }
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
});