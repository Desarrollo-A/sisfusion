var tabla_valores_cliente;
let titulos_encabezado = [];
let num_colum_encabezado = [];
const excluir_column = ['ACCIONES', 'MÁS'];
let titulos_encabezado_detalle= [];
let num_colum_encabezado_detalle = [];
var busquedaParams = {  nombre: '', apellido_paterno: '', apellido_materno: '', correo: '', telefono: '' };
var id_lote_global = 0;          

$(document).ready(function () {
    updateTable();
});

function updateTable() {
    $('#tabla_clientes thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title) && title !== ''){
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly': '';
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
        $('input', this).on('keyup change', function () {
            tabla_valores_cliente.column(i).search(this.value).draw();
        });
    });

    tabla_valores_cliente = $("#tabla_clientes").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Búsqueda detallada de clientes',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.idLote + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreCondominio + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.nombreCliente + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.noRecibo + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + myFunctions.validateEmptyField(d.tipo) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.fechaApartado + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">$ ' + myFunctions.number_format(d.engancheCliente, 2, '.', ',') + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.fechaEnganche + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p class="m-0">' + d.asesor + '</p>';
                }
            },
            {
                "data": function (d) {
                    return `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas to-comment cop" data-toggle="tooltip" data-placement="top" title= "VENTAS COMPARTIDAS" data-idcliente="${d.id_cliente}" data-idLote="${d.idLote}"><i class="fas fa-user-friends"></i></button></div>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}index.php/registroCliente/getResultsClientsSerch/`,
            dataSrc: "",
            type: "POST",
            cache: false,
            //parameter to search and the action to perform
            data: function (d) {
                d.nombre = busquedaParams.nombre;
                d.correo = busquedaParams.correo;
                d.telefono = busquedaParams.telefono;
                d.apellido_paterno = busquedaParams.apellido_paterno;
                d.apellido_materno = busquedaParams.apellido_materno;
            }
        },
        order: [[1, 'asc']],
    });

    $('#tabla_clientes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_clientes tbody').on('click', 'td.details-control', function () {
        tr = $(this).closest('tr');
        row = tabla_valores_cliente.row(tr);
        if(row.child.isShown()){
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        }
        else {
            var informacion_adicional = 
                `<div class="container subBoxDetail">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                            <label>
                                <b>
                                    ${myFunctions.validateEmptyField(row.data().nombreCliente)}
                                </b>
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Correo: </b>
                                ${myFunctions.validateEmptyField(row.data().correo)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Teléfono: </b>
                                ${myFunctions.validateEmptyField(row.data().telefono1)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>RFC: </b>
                                ${myFunctions.validateEmptyField(row.data().rfc)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Fecha +45: </b>
                                ${myFunctions.validateEmptyField(row.data().fechaVecimiento)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Fecha nacimiento: </b>
                                ${myFunctions.validateEmptyField(row.data().fechaNacimiento)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Domicilio particular: </b>
                                ${myFunctions.validateEmptyField(row.data().domicilio_particular)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Enterado: </b>
                                ${myFunctions.validateEmptyField(row.data().enterado)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Gerente titular: </b>
                                ${myFunctions.validateEmptyField(row.data().gerente)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label>
                                <b>Asesor titular: </b>
                                ${myFunctions.validateEmptyField(row.data().asesor)}
                            </label>
                        </div>
                    </div>
                </div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });
};

$(document).on('click', '#buscarBtn', function (e) {
    $('#tabla_clientes').empty();
    var nombreField = $('#nombre').val();
    var correoField = $('#correo').val();
    var telefonoField = $('#telefono').val();
    var apellido_paterno = $('#apellido_paterno').val();
    var apellido_materno = $('#apellido_materno').val();
    busquedaParams = {nombre: $('#nombre').val(),apellido_paterno: $('#apellido_paterno').val(), apellido_materno: $('#apellido_materno').val(), correo: $('#correo').val(), telefono: $('#telefono').val()};
    //all vacío
    if (nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0) {
        alerts.showNotification('top', 'right', 'Ups, asegurate de colocar al menos un criterío de búsqueda', 'warning');
        $('#nombre').focus();
    }else{
        updateTable();
    }
});

$(document).on('click', '.cop', function (e) {
    var $itself = $(this);
    var id_lote = $itself.attr('data-idLote');
    id_lote_global = id_lote;
    tabla_detalle_cliente.ajax.reload();
    $('#verDetalles').modal('show');
});

var tabla_detalle_cliente
$(document).ready(function () {
    $('#verDet thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos_encabezado_detalle.push(title);
        num_colum_encabezado_detalle.push(i);
        $(this).html(`<input    type="text" class="textoshead" data-toggle="tooltip_details" data-placement="top" title="${title}" placeholder="${title}" readOnly/>`);
        $('input', this).on('keyup change', function () {
            if (verDet.column(i).search() !== this.value) {
                verDet.column(i).search(this.value).draw();
            }
        });
    });

    tabla_detalle_cliente = $('#verDet').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        select: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Ventas compartidas',
            exportOptions: {
                columns: num_colum_encabezado_detalle,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado_detalle[columnIdx] +' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                "data": "asesor"
            },
            {
                "data": "coordinador"
            },
            {
                "data": "gerente"
            },
            {
                "data": "subdirector"
            },
            {
                "data": "regional"
            },
            {
                "data": "regional2"
            },
            {
                "data": "fecha_creacion"
            },
            {
                "data": "creado_por"
            }
        ],
        ajax: {
            url:  `${general_base_url}Contratacion/getCoSallingAdvisers/`,
            dataSrc: "",
            type: "POST",
            cache: false,
            //parameter to search and the action to perform
            data: function (d) {
                d.idLote = id_lote_global;
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip_details"]').tooltip();
        }
    });
});