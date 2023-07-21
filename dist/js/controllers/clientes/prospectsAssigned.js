$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
});
sp = { //  SELECT PICKER
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

$('#prospects_assigned_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

let titulosEvidence = [];
$('#prospects_assigned_datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulosEvidence.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects_assigned_datatable').DataTable().column(i).search() !== this.value ) {
            $('#prospects_assigned_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(3, finalBeginDate, finalEndDate, 0);
    console.log(finalBeginDate);
    console.log(finalEndDate);


});

function fillDataTable(typeTransaction, beginDate, endDate, where){
    $('#prospects_assigned_datatable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado general de prospectos asignados',
                title: 'Listado general de prospectos asignados',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosEvidence[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.id_prospecto;
                }
            },
            {
                data: function (d) {
                    return d.nombreProspecto;
                }
            },
            {
                data: function (d) {
                    return d.sede;
                }
            },
            {
                data: function (d) {
                    return d.valorAnterior;
                }
            },
            {
                data: function (d) {
                    return d.valorNuevo;
                }
            },
            {
                data: function (d) {
                    return d.nombreUsuarioModifica;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.fecha_asignacion;
                }
            },
            {
                data: function (d) {
                    if (d.otro_lugar == 'Contacto web') { // MJ: Contacto web
                        return "<small class='label lbl-warning'>Contacto web</small>";
                    } else if (d.otro_lugar == 'Facebook') { // MJ: Facebook
                        return "<small class='label lbl-azure'>Facebook</small>";
                    } else if (d.otro_lugar == 'Recomendado') { // MJ: Recomendado
                        return "<small class='label lbl-melon'>Recomendado</small>";
                    } else if (d.otro_lugar == '01 800') { // MJ: 01 800
                        return "<small class='label lbl-oceanGreen'>01 800</small>";
                    } else if (d.otro_lugar == 'Chat') { // MJ: Chat
                        return "<small class='label lbl-yellow'>Chat</small>";
                    } else if (d.otro_lugar == 'Referido personal') { // MJ: Referido personal
                        return "<small class='label lbl-violetBoots'>Referido personal</small>";
                    } else if (d.otro_lugar == 'WhatsApp') { // MJ: WhatsApp
                        return "<small class='label lbl-green'>WhatsApp</small>";
                    } else { // MJ: Otro
                        return "<small class='label lbl-gray'>Otro</small>";
                    }
                }
            }
        ],
        "ajax": {
            "url": 'getProspectsAssignedList',
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    })
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
    fillDataTable(1, finalBeginDate, finalEndDate, 0);
    
}

