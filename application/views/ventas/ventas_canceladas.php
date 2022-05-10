<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
    <?php $this->load->view('template/sidebar', ""); ?>

    <div class="modal fade modal-alertas"
         id="detalle-modal"
         role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" >Comisiones canceladas</h3>
                                <p class="card-title pl-1">Lotes donde la venta se canceló.</p>
                            </div>

                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table class="table-striped table-hover"
                                           id="canceladas-tabla">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>PLAN VENTA</th>
                                                <th>TOTAL</th>
                                                <th>MÁS</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('template/footer_legend');?>
</div>

<?php $this->load->view('template/footer'); ?>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>
    const url = "<?=base_url()?>";
    let tablaCanceladas;

    $('#canceladas-tabla').ready(function () {
        let titulos = [];
        $('#canceladas-tabla thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tablaCanceladas.column(i).search() !== this.value) {
                    tablaCanceladas.column(i).search(this.value).draw();
                }
            });
        });

        tablaCanceladas = $('#canceladas-tabla').DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES CANCELADAS',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            header: function (d, columnIndex) {
                                return titulos[columnIdx - 1];
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [
                {
                    'width': '10%',
                    'data': function (d) {
                        return `<p class="m-0">${d.id_lote}</p>`;
                    }
                },
                {
                    'width': '25%',
                    'data': function (d) {
                        return `<p class="m-0">${d.nombreLote}</p>`;
                    }
                },
                {
                    'width': '20%',
                    'data': function (d) {
                        return `<p class="m-0">${d.nombre_cliente}</p>`;
                    }
                },
                {
                    'width': '25%',
                    'data': function (d) {
                        return `<p class="m-0">${d.plan_descripcion}</p>`;
                    }
                },
                {
                    'width': '15%',
                    'data': function (d) {
                        return `<p class="m-0">${formatMoney(d.comision_total)}</p>`;
                    }
                },
                {
                    'width': '5%',
                    'data': function (d) {
                        return `
                            <div class="d-flex justify-center">
                                <button class="btn-data btn-sky"
                                    title="Detalle"
                                    onclick="detalleLote(${d.id_lote}, ${d.idCliente})">
                                    <i class="material-icons">info</i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            ajax: {
                url: '<?=base_url()?>Comisiones/getVentasCanceladas',
                type: "GET",
                data: function (d) {}
            }
        });
    });

    function detalleLote(idLote, idCliente) {
        $.ajax({
            url: `${url}Comisiones/getDetailVentaCancelada/${idLote}/${idCliente}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                const modalBody = $('#detalle-modal .modal-body');

                modalBody.html('');

                modalBody.append(`
                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <h4><b>Lote: ${response.cantidades.nombreLote}</b></h4>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <h4>Total pago: <b>$${formatMoney(response.cantidades.comision_total)}</b></h4>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <h4>Total abonado: <b>$${formatMoney(response.cantidades.abonado)}</b></h4>
                        </div>
                    </div>
                `);

                modalBody.append(`
                        <div class="row">
                            <div class="col-md-4">
                                <b>USUARIOS</b>
                            </div>
                            <div class="col-md-1">
                                <b>%</b>
                            </div>
                            <div class="col-md-2">
                                <b>TOT. COMISIÓN</b>
                            </div>
                            <div class="col-md-2">
                                <b>ABONADO</b>
                            </div>
                            <div class="col-md-2">
                                <b>PENDIENTE</b>
                            </div>
                        </div>
                    `);

                $.each(response.detalle, function (i, row) {
                    modalBody.append(`
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control ng-invalid ng-invalid-required"
                                    required
                                    readonly="true"
                                    value="${row.colaborador}"
                                    style="font-size:12px; ${row.descuento === "1" ? 'color:red;' : ''}">
                                        <b>
                                            <p style="font-size:12px;${row.descuento === '1' ? 'color:red;' : ''} ">
                                                ${row.descuento !== '1' ?  row.rol : row.rol +' Incorrecto' }
                                            </p>
                                        </b>
                            </div>
                            <div class="col-md-1">
                                <input class="form-control ng-invalid ng-invalid-required"
                                    style="${row.descuento === '1' ? 'color:red;' : ''}"
                                    required
                                    readonly="true"
                                    value="${row.porcentaje_decimal}%">
                            </div>
                            <div class="col-md-2">
                                <input class="form-control ng-invalid ng-invalid-required"
                                    style="${row.descuento === '1' ? 'color:red;' : ''}"
                                    required
                                    readonly="true"
                                    value="$${formatMoney(row.comision_total)}">
                            </div>
                            <div class="col-md-2">
                                <input class="form-control ng-invalid ng-invalid-required"
                                    style="${row.descuento === '1' ? 'color:red;' : ''}"
                                    required
                                    readonly="true"
                                    value="$${formatMoney(row.abono_pagado)}">
                            </div>
                            <div class="col-md-2">
                                <input class="form-control ng-invalid ng-invalid-required"
                                    style="${row.pending < 0 ? 'color:red' : ''}"
                                    required
                                    readonly="true"
                                    value="$${formatMoney(row.pending)}">
                            </div>
                        </div>
                    `)
                })

                $('#detalle-modal').modal();
            }
        });
    }

    function formatMoney(n) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = (d === undefined) ? "." : d,
            t = (t === undefined) ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
</script>
