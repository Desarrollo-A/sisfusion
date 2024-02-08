sp = {
    initFormExtendedDatetimepickers: function () {
var today = new Date();
var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
var time = today.getHours() + ":" + today.getMinutes();
    $(".datepicker").datetimepicker({
            format: "DD-MM-YYYY",
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-screenshot",
                clear: "fa fa-trash",
                close: "fa fa-remove",
                inline: true,
            },
        });
    },
};

var usuarios = [];
$('#spiner-loader').removeClass('hide');

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $(".datepicker").datetimepicker({ locale: "es" });
    setInitialValues();
    $.post(general_base_url + "/Comisiones/getDatosReporteDesc", function (data) {
        let sedes = data.sedes, empresa = data.empresas, puestos = data.puestos;
        usuarios = data.usuarios;      
        for (var i = 0; i < sedes.length; i++) {
            var id = sedes[i]['id_sede'];
            var name = sedes[i]['nombre'];
            $(`#sede`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        for (var i = 0; i < empresa.length; i++) {
            var id = empresa[i]['nombre'];
            $(`#empresa`).append($('<option>').val(id).text(id.toUpperCase()));
        }
        for (var i = 0; i < puestos.length; i++) {
            var id = puestos[i]['id_opcion'];
            var name = puestos[i]['nombre'];
            $(`#puesto`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $(`.selectpicker`).selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});
$('#puesto').change( function(){
    idPuesto = $(this).val();
    let getUsers = usuarios.filter(users => users.id_rol == idPuesto);
    $("#usuarios").html("");
    for (var i = 0; i < getUsers.length; i++) {
        var id = getUsers[i]['id_usuario'];
        var name = getUsers[i]['nombre'];
        $(`#usuarios`).append($('<option>').val(id).text(name.toUpperCase()));
    }
    $(`#usuarios`).selectpicker('refresh');
});
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
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('-');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('-');
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('[data-toggle="tooltip"]').tooltip();
}
var totaPen = 0;
let titulos = [];
    $('#tabla_prestamos thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {

            if (tabla_nuevas.column(i).search() !== this.value) {
                tabla_nuevas.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_nuevas.rows(index).data();
                const unique = [];
                $.each(data, function (i, v) {
                    if (!unique.includes(v.id_prestamo)) {
                        unique.push(v.id_prestamo);
                        total += parseFloat(v.monto);
                    }
                });
                var to1 = formatMoney(total);
                document.getElementById("totalp").textContent = to1;
            }
        });
    });
setTablaReporte();
function setTablaReporte(sede = 0, empresa = 0, puesto = 0, usuario = 0, beginDate = 0, endDate = 0){
    $('#tabla_prestamos').dataTable().fnClearTable();
    $('#tabla_prestamos').dataTable().fnDestroy();
    $('#tabla_prestamos').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        const unique = [];
        $.each(json.data, function (i, v) {
            if (!unique.includes(v.id_prestamo)) {
                unique.push(v.id_prestamo);
                total += parseFloat(v.monto);
                }
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = to;
    });
    tabla_nuevas = $("#tabla_prestamos").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PRÉSTAMOS Y PENALIZACIONES',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header: function (d, columnIdx) {
                        if (columnIdx >= 0) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
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
        scrollX: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [
        { 
            data: 'id_prestamo' 
        },
        { 
            data: 'id_pago_i' 
        },
        { 
            data: 'idLote' 
        },
        { 
            data: 'id_usuario' 
        },
        { 
            data: 'nombre' 
        },
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.monto)} </p> `;
                return formato;
            }
        },
        { 
            data: 'num_pagos'
        },
        { 
            data: 'n_p'
        },
        {
            data: function (d) {
                let formato = '';
                if (d.estatus == 1) {
                    formato = '<span class="label lbl-blueMaderas ">ACTIVO</span>';
                } else if (d.estatus == 3 || d.estatus == 2) {
                    formato = '<span class="label lbl-green" >APLICADO</span>';
                } else if (d.estatus == 0) {
                    formato = '<span class="label lbl-warning" >DETENIDO</span>';
                }
                return formato;
            }
        },
        {
            data: function (d) {
                return `<p><span class="label" style="background-color:${d.color}" >${d.tipoDesc}</span></p>`;
            }
        },
        {
            data: function (d) {
                let fecha_creacion = moment(d.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
                return fecha_creacion;
            }
        },
        {
            data: function (d) {
                let fecha_modificacion = moment(d.fecha_modificacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
                return fecha_modificacion;
            }
        },
        { 
            data: 'sede' 
        },
        { 
            data: 'empresa' 
        },
        { 
            data: function (d) {
                return (d.relacion_evidencia != null )  
            } 
        },
    ],
        ajax: {
            url: general_base_url + "Comisiones/getReporteDesc",
            type: "POST",
            cache: false,
            data: {
                sede:sede,
                empresa:empresa,
                puesto:puesto,
                usuario:usuario,
                beginDate: beginDate,
                endDate: endDate
            }
        },
    });    
    $('#spiner-loader').addClass('hide');
}
$("#btnTable").click(function(e){
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let sede = $(`#sede`).val() != '' ? $(`#sede`).val() : 0;
    let empresa =  $(`#empresa`).val() != '' ? $(`#empresa`).val() : 0;
    let puesto =  $(`#puesto`).val() != '' ? $(`#puesto`).val() : 0;
    let usuario =  $(`#usuarios`).val() != '' ? $(`#usuarios`).val() : 0;
    let beginDate =  $(`#beginDate`).val() != '' ? $(`#beginDate`).val() : 0;
    let endDate =  $(`#endDate`).val() != '' ? $(`#endDate`).val() : 0;
    setTablaReporte(sede, empresa, puesto, usuario, beginDate, endDate);
});

$('#table_detalles').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

$(window).resize(function () {
    tabla_nuevas.columns.adjust();
});

$(document).on("click", "#preview", function () {
    var itself = $(this);
    console.log(itself.attr('data-doc'))
    Shadowbox.open({
        content: `<div>
                    <iframe style="overflow:hidden;width: 100%;height: 100%; 
                                    position:absolute;z-index:999999!important;" 
                                    src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-doc')}">
                    </iframe>
                </div>`,
        player: "html",
        title: `Visualizando archivo: evidencia `,
        width: 985,
        height: 660
    });
});


