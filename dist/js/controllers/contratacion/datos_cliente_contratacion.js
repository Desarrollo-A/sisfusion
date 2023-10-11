$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#condominio").html("");
    $("#tabla_clientes").removeClass('hide');
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function () {
        $.post(general_base_url + "Contratacion/lista_condominio/" + index_proyecto, function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
    fillTable(index_proyecto, 0);
});

$('#condominio').change(function () {
    $('#spiner-loader').removeClass('hide');
    let index_proyecto = $("#proyecto").val();
    let index_condominio = $(this).val();
    fillTable(index_proyecto, index_condominio);
    $('#spiner-loader').addClass('hide');
});

let titulos_encabezado = [];
let num_colum_encabezado = [];
const excluir_column = ['ACCIONES', 'MÁS'];

$("#tabla_clientes").ready(function () {
    $('#tabla_clientes thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title) && title !== ''){
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length);
        }
        if(title !== ''){
            let readOnly = excluir_column.includes(title) ? 'readOnly': '';
            let width = title=='MÁS' ? 'width: 37px;': (title == 'ACCIONES' ? 'width: 57px;' : '');
            $(this).html(`<input type="text" style="${width}" class="textoshead " data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_valores_cliente.column(i).search() !== this.value) {
                    tabla_valores_cliente.column(i).search(this.value).draw();
                }
            });
        }
    });
});

function fillTable(index_proyecto, index_condominio) {
    tabla_valores_cliente = $("#tabla_clientes").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Registro de clientes',
            title: 'Registro de clientes',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado[columnIdx-1] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": `<div class="toggle-subTable">
                                        <i class="animacion fas fa-chevron-down fa-lg"></i>
                                    </div>`
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.id_cliente + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreCondominio + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreCompleto + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + (d.noRecibo == null || d.noRecibo == '' ? 'SIN ESPECIFICAR' : d.noRecibo) + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.referencia + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + myFunctions.validateEmptyField(d.tipo) + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + (d.fechaApartado == null || d.fechaApartado == '' ? 'SIN ESPECIFICAR' : d.fechaApartado) + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">$ ' + myFunctions.number_format(d.engancheCliente, 2, '.', ',') + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + (d.fechaEnganche == null || d.fechaEnganche == '' ? 'SIN ESPECIFICAR' : d.fechaEnganche) + '</p>';
                }
            },
            {
                data: function (d) {
                    return `<center>
                                <button class="btn-data btn-blueMaderas cop" data-toggle="tooltip" data-placement="top" title= "VENTAS COMPARTIDAS" data-idcliente="${d.id_cliente}" data-idLote="${d.idLote}"><i class="material-icons">people</i></button>
                            </center>`;
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
            url: general_base_url + "RegistroCliente/getregistrosClientesTwo",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
                "index_condominio": index_condominio
            }
        },
        "order": [
            [1, 'asc']
        ],
    });

    $('#tabla_clientes').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    
    $('#tabla_clientes tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_valores_cliente.row(tr);

        if (row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var informacion_adicional = 
                `<div class="container subBoxDetail">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                            <label>
                                <b>
                                    ${row.data().nombreCompleto}
                                </b>    
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Correo:
                                </b>
                                ${myFunctions.validateEmptyField(row.data().correo)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Teléfono:
                                </b>
                                ${myFunctions.validateEmptyField(row.data().telefono1)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    RFC: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().rfc)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Fecha +45: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().fechaVecimiento)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Fecha de nacimiento: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().fechaNacimiento)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Domicilio particular: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().domicilio_particular)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Enterado: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().enterado)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Gerente: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().gerente)}
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
                            <label>
                                <b>
                                    Asesor titular: 
                                </b>
                                ${myFunctions.validateEmptyField(row.data().asesor)}
                            </label>
                        </div>
                    </div>
                </div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        }
    });
}

var id_lote_global = 0;
$(document).on('click', '.cop', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var id_lote = $itself.attr('data-idLote');
    id_lote_global = id_lote;
    tableHistorial.ajax.reload();
    $('#verDetalles').modal('show');
});

let titulos_encabezado_detalle= [];
let num_colum_encabezado_detalle = [];
$('#tabla_clientes_detalles thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezado_detalle.push(title);
    num_colum_encabezado_detalle.push(i);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tabla_clientes_detalles').DataTable().column(i).search() !== this.value)
            $('#tabla_clientes_detalles').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

$(document).ready(function () {
    tableHistorial = $('#tabla_clientes_detalles').DataTable({
        responsive: true,
        searchable: false,
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Reporte ventas compartidas',
            title: 'Reporte ventas compartidas',
            exportOptions: {
                columns: num_colum_encabezado_detalle,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado_detalle[columnIdx] +' ';
                    }
                }
            }
        }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
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
        "processing": true,
        "bAutoWidth": false,
        "bLengthChange": false,
        "bInfo": true,
        "ordering": false,
        "fixedColumns": true,
        "ajax": {
            "url": `${general_base_url}Contratacion/getCoSallingAdvisers/`,
            "type": "POST",
            cache: false,
            "dataSrc": "",
            "data": function (d) {
                d.idLote = id_lote_global;
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip_details"]').tooltip("destroy");
            $('[data-toggle="tooltip_details"]').tooltip({trigger: "hover"});
        }
    });
});

$(window).resize(function () {
    tabla_valores_cliente.columns.adjust();
});