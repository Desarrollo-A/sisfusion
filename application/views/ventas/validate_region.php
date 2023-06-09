<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        switch ($this->session->userdata('id_rol')) {
            case '13': // CONTRALORÍA
            case '19': // SUBDIRECTOR CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $this->load->view('template/sidebar');
                break;
            default: // NO ACCESS
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Validar región de comisiones</h3>
                                    <!--<p class="card-title pl-1">(Valida la región y asigna un gerente a la venta.)</p>-->
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 pr-0">    
                                            <button type="button" value="6" class="btn-data-gral" style="background-color:#4BBC8E; color:#FFF;" onclick="assignManager(this.value)">Cancún</button>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="4" class="btn-data-gral" style="background-color:#1FA592; color:#FFF;" onclick="assignManager(this.value)">Ciudad de México</button>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="2" class="btn-data-gral" style="background-color:#008E8E; color:#FFF;" onclick="assignManager(this.value)">Querétaro</button> 
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="3" class="btn-data-gral" style="background-color:#137683; color:#FFF;" onclick="assignManager(this.value)">Península</button>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                            <button type="button" value="5" class="btn-data-gral" style="background-color:#275E70; color:#FFF;" onclick="assignManager(this.value)">León</button>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="1" class="btn-data-gral" style="background-color:#2F4858; color:#FFF;" onclick="assignManager(this.value)">San Luis Potosí</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_validar_comisiones" name="tabla_validar_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID PAGO</th>
                                                        <th>ABONO</th>
                                                        <th>ID LOTE</th>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>SEDE</th>
                                                        <th>APARTADO</th>
                                                        <th>SEDE COMISIÓN</th>
                                                        <th>ESTATUS</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
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
        var totaPen = 0;
        var tr;
    
        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        function assignManager(e) {
            $('#spiner-loader').removeClass('hide');
            if ($('input[name="idT[]"]:checked').length > 0) {
                var idcomision = $(tabla_validar_comisiones.$('input[name="idT[]"]:checked')).map(function () {
                    return this.value;
                }).get();
                $.get(`${general_base_url}Comisiones/updatePlaza/` + idcomision + "/" + e).done(function (data) {
                    $('#spiner-loader').addClass('hide');
                    if (data == 1) { // COMISIÓN RECHAZADA
                        alerts.showNotification("top", "right", "La comisión ha sido regresada correctamente para su validación.", "success");
                    } else if (data == 2) { // COMISIÓN ASIGNADA
                        alerts.showNotification("top", "right", "La asignación de plaza se ha llevado a cabo exitosamente.", "success");
                    } else if (data) { // COMISIÓN ASIGNADA
                        alerts.showNotification("top", "right", "Se ha aplicado cambio exitosamente.", "success");
                    } else { // NO ENCONTRÓ DATOS, ERROR GENERAL
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                    $('input[type="checkbox"]').prop('checked', false);
                    tabla_validar_comisiones.ajax.reload();
                });
            }
        }

        function selectAll(e) {
            const cb = document.getElementById('all');
            if (cb.checked) {
                $('input[type="checkbox"]').prop('checked', true);
            } else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        }

        $("#tabla_validar_comisiones").ready(function () {
            let titulos = [];
            $('#tabla_validar_comisiones thead tr:eq(0) th').each(function (i) {
                if (i != 0 ) {
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (tabla_validar_comisiones.column(i).search() !== this.value) {
                            tabla_validar_comisiones
                                .column(i)
                                .search(this.value)
                                .draw();
                            var total = 0;
                            var index = tabla_validar_comisiones.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_validar_comisiones.rows(index).data();
                            $.each(data, function (i, v) {
                                total += parseFloat(v.pago_cliente);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_nuevas").value = formatMoney(total);
                        }
                    });
                } else {
                    $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
                }
            });

            tabla_validar_comisiones = $("#tabla_validar_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 1:
                                            return 'ID PAGO';
                                            break;
                                        case 2:
                                            return 'ABONO';
                                            break;
                                        case 3:
                                            return 'ID LOTE'
                                        case 4:
                                            return 'PROYECTO';
                                            break;
                                        case 5:
                                            return 'LOTE';
                                            break;
                                        case 6:
                                            return 'SEDE';
                                            break;
                                        case 7:
                                            return 'APARTADO ';
                                            break;
                                        case 8:
                                            return 'SEDE COMISIÓN';
                                            break;
                                        case 9:
                                            return 'ESTATUS';
                                            break;
                                    }
                                }
                            }
                        }
                    },
                    {
                        text: "Enviar comisiones para pago",
                        titleAttr: 'Enviar comisiones para pago',
                        className: "btn btn-azure send-commissions-to-pay",
                    }
                ],
                columns: [
                    {},
                    {
                        data: function (d) {
                            return '<p class="m-0">' + d.id_pago_i + '</p>';
                        }
                    },
                    {
                        data: function (d) {
                            return d.pago_cliente;
                        }
                    },
                    {
                        data: function (d) {
                            return d.id_lote;
                        }
                    },
                    {
                        data: function (d) {
                            return '<p class="m-0">' + d.proyecto + '</p>';
                        }
                    },
                    {
                        data: function (d) {
                            return '<p class="m-0">' + d.lote + '</p>';
                        }
                    },
                    {
                        data: function (d) {
                            return '<p class="m-0">' + d.nombre + ' </p>';
                        }
                    },
                    {
                        data: function (d) {
                            return '<p class="m-0">' + d.fechaApartado + '</p>';
                        }
                    },
                    {
                        data: function (d) {
                            if (d.ubicacion_dos == null)
                                return '<p class="m-0">Sin lugar de venta asignado</p>';
                            else
                                return '<p class="m-0">' + d.ubicacion_dos + '</p>';
                        }
                    },
                    {
                        data: function (d) {
                            var lblStats;
                            if (d.ubicacion_dos == null)
                                lblStats = '<span class="label" style="background-color:#D17FC5; color:;">PENDIENTE ASIGNAR SEDE</span>';
                            else
                                lblStats = '<span class="label" style="background-color:#765FA4; color:;">SEDE ASIGNADA</span>';
                            return lblStats;
                        }
                    }

                ],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox dt-body-center',
                    targets: 0,
                    'searchable': false,
                    'render': function (d, type, full, meta) {
                        //if (full.estatus != 41 && full.estatus != 42) {
                        if (full.ubicacion_dos != null)
                            return '';
                        else
                            return '<input type="checkbox" class="input-check" name="idT[]" style="width:20px; height:20px;" value="' + full.id_pago_i + '">';
                    },
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: `${general_base_url}static/spanishLoader_v2.json`,
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                ajax: {
                    url: `${general_base_url}Comisiones/getCommissionsToValidate/`,
                    type: "POST",
                    cache: false,
                    data: function (d) {
                    }
                }
            });

        });

        $(document).on("click", ".send-commissions-to-pay", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let id_lote = [];
            tabla_validar_comisiones.column(3).data().unique().sort().each(function(value, index) { 
                id_lote.push(value); 
            });            
            $.ajax({
                type: 'POST',
                url: 'sendCommissionToPay',
                data: {
                    'id_lote': id_lote
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#spiner-loader').removeClass('hide');
                },
                success: function (data) {
                    if (data == true) {
                        alerts.showNotification("top", "right", "Los registros se han enviado de manera exitosa.", "success");
                        $("#tabla_validar_comisiones").DataTable().ajax.reload();
                        $('#spiner-loader').addClass('hide');
                    } else {
                        $('#spiner-loader').addClass('hide');
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                    }
                }, error: function () {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });
    </script>
</body>