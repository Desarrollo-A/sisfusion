
$('#comisiones-detenidas-table').ready(function () {
    let titulos = [];

    $('#comisiones-detenidas-table thead tr:eq(0) th').each(function (i) {
        if (i !== 0 && i !== 9) {
            const title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (comisionesDetenidasTabla.column(i).search() !== this.value) {
                    comisionesDetenidasTabla.column(i).search(this.value).draw();
                }
            });
        }
    });

    let comisionesDetenidasTabla = $('#comisiones-detenidas-table').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: "<i class='fa fa-file-excel-o' aria-hidden='true'></i>",
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES DETENIDAS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
            url: general_base_url+'/static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                'width': '3%',
                'className': 'details-control',
                'orderable': false,
                'data' : null,
                'defaultContent': `
                    <div class='toggle-subTable'>
                        <i class='animacion fas fa-chevron-down fa-lg'></i>
                    </div>
                `
            },
            { data:'idLote'},
            {data:'nombreResidencial'},
            {data:'nombreCondominio'},
            {data: 'nombreLote' },
            {
                "width": "8%",
                "data": function( d ){
                    if (d.tipo_venta == 1) {
                        return '<span class="label lbl-warning">Venta Particular</span>';
                    }else if (d.tipo_venta == 2) {
                        return '<span class="label lbl-green">Venta normal</span>';
                    } else if (d.tipo_venta == 7) {
                        return '<span class="label lbl-orangeYellow">Venta especial</span>';
                    } else {
                        return '';
                    }
                }
            },
            {
                'width': '8%',
                data: function( d ){
                    if (d.compartida === null) {
                        return '<span class="label lbl-orangeYellow" >Individual</span>';
                    } else {
                        return '<span class="label lbl-warning">Compartida</span>';
                    }
                }
            },
            {
                'width': '8%',
                data: function( d ){
                    if (d.idStatusContratacion === 15) {
                        return '<span class="label lbl-violetDeep">Contratado</span>';
                    } else {
                        return '<p class="m-0 lbl-violetDeep"><b>'+d.idStatusContratacion+'</b></p>';
                    }
                }
            },
            {
                'width': '15%',
                'orderable': false,
                'data': function (d) {
                        let motivo ;
                        let color ;
                        if(d.motivo == 1 || d.motivo == 2 || d.motivo == 3){
                            motivo = d.motivoOpc;
                            color  = 'lbl-gray';
                        }else  {
                            color = 'lbl-azure';
                            motivo = d.motivo;
                        }
                    return '<span class="label '+color+'">'+motivo+'</span>';
                }
            },
            {
                'width': '8%',
                'orderable': false,
                'data': function (d) {
                    if(id_rol_general != 63 && id_rol_general != 4){

                        return `
                            <div class="d-flex justify-center">
                                <button value="${d.idLote}" data-value="${d.nombreLote}"
                                    class="btn-data btn-blueMaderas btn-cambiar-estatus"
                                    title="Detener">
                                    <i class="material-icons">undo</i>
                                </button>
                            </div>
                        `;
                        } else{
                        return 'NA';
                        }
                   
                }
            }
        ],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            'url': general_base_url+'Comisiones/getStoppedCommissions',
            'dataSrc': '',
            'type': 'GET',
            cache: false,
            'data': function (d) {}
        },
    });

    $('#comisiones-detenidas-table tbody').on('click', 'td.details-control', function () {
        const tr = $(this).closest('tr');
        const row = comisionesDetenidasTabla.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            row.child(`
            
                <div class="container subBoxDetail">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12"
                            style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                            <label><b>Descripción</b></label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12"
                            style="padding: 10px 30px 0 30px;">
                            <label>` + row.data().comentario + `</label>
                        </div>
                    </div>
                </div>
            `).show();
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
            processData:false,
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
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
});