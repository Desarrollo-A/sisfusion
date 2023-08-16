<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- modal COMMENTS ADD/REMOVE MLTD -->
        <div class="modal fade" id="modal-add-remove-mktd" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header text-center">
                        <h4 class="modal-title" id="modal-mktd-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
                                <label>Comentario:</label>
                                <textarea class="form-control" id="comments" rows="3"></textarea>
                                <br>
                                <input id="id_lote" class="hidden">
                                <input id="type_transaction" class="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="add-remove-mktd" class="btn btn-success"><span class="material-icons" >send</span> </i> Cambiar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" onclick="cleanFields()"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Agregar o remover <b>MKTD</b></h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID LOTE</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>EST. CONTRATACIÓN</th>
                                                        <th>ESTATUS</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    </div><!--main-panel close-->
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
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var getInfo1 = new Array(6);
        var getInfo3 = new Array(6);

        $("#tabla_ingresar_9").ready(function () {
            let titulos = [];
            $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
                if (i != 0 && i != 10) {
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (tabla_1.column(i).search() !== this.value) {
                            tabla_1.column(i).search(this.value).draw();
                        }
                    });
                }
            });

            tabla_1 = $("#tabla_ingresar_9").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                        format: {
                            header: function (d, columnIdx) {
                                if (columnIdx == 0) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx == 10) {
                                    return ' ' + d + ' ';
                                } else if (columnIdx != 10 && columnIdx != 0) {
                                    if (columnIdx == 11) {
                                        return 'SEDE ';
                                    }
                                    if (columnIdx == 12) {
                                        return 'TIPO'
                                    } else {
                                        return ' ' + titulos[columnIdx - 1] + ' ';
                                    }
                                }
                            }
                        }
                    }
                }],
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
                columns: [{
                    width: "3%",
                    className: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
                    width: "5%",
                    data: function (d) {
                        var lblStats;
                        lblStats = '<p class="m-0"><b>' + d.idLote + '</b></p>';
                        return lblStats;
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        return '<p class="m-0">' + (d.nombreCondominio).toUpperCase();
                        +'</p>';
                    }
                },
                {
                    width: "12%",
                    data: function (d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';

                    }
                },
                {
                    width: "14%",
                    data: function (d) {
                        return '<p class="m-0"><b>' + d.nombre_cliente + '</b></p>';
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        var lblType;
                        if (d.tipo_venta == 1) {
                            lblType = '<span class="label label-danger">Venta Particular</span>';
                        } else if (d.tipo_venta == 2) {
                            lblType = '<span class="label label-success">Venta normal</span>';
                        }
                        return lblType;
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        var lblStats;
                        if (d.compartida == null) {
                            lblStats = '<span class="label label-warning" style="background:#E5D141;">Individual</span>';
                        } else {
                            lblStats = '<span class="label label-warning">Compartida</span>';
                        }
                        return lblStats;
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        var lblStats;
                        if (d.idStatusContratacion == 15) {
                            lblStats = '<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';
                        } else {
                            lblStats = '<p><b>' + d.idStatusContratacion + '</b></p>';
                        }
                        return lblStats;
                    }
                },
                {
                    width: "9%",
                    data: function (d) {
                        var lblStats;
                        if (d.totalNeto2 == null) {
                            lblStats = '<span class="label label-danger">Sin precio lote</span>';
                        } else {
                            switch (d.lugar_prospeccion) {
                                case '6':
                                    lblStats = '<span class="label" style="background:#B4A269;">MARKETING DIGITAL</span>';
                                    break;
                                case '12':
                                    lblStats = '<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
                                    break;
                                case '25':
                                    lblStats = '<span class="label" style="background:#0860BA;">IGNACIO GREENHAM</span>';
                                    break;
                                default:
                                    lblStats = '';
                                    break;
                            }
                        }
                        return lblStats;
                    }
                },
                {
                    width: "12%",
                    orderable: false,
                    data: function (data) {
                        var BtnStats;
                        if (data.lugar_prospeccion == 6) { // IS MKTD SALE
                            BtnStats = '<button class="btn-data btn-warning open-mktd-modal" data-type="2" title="Remover MKTD" data-type="2" data-lote="' + data.nombreLote + '" value="' + data.idLote + '"><i class="fas fa-trash"></i></button>';
                        } else { // IS NOT A MKTD SALE
                            BtnStats = '<button class="btn-data btn-green open-mktd-modal" data-type="1" title="Agregar MKTD" data-type="1" data-lote="' + data.nombreLote + '" value="' + data.idLote + '" color:#fff;"><i class="fas fa-user-plus"></i></button>';
                        }
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                    }
                }],
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                ajax: {
                    url: '<?=base_url()?>index.php/Comisiones/getMktdCommissionsList',
                    dataSrc: "",
                    type: "POST",
                    cache: false,
                    data: function (d) {
                    }
                },
            });

            $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_1.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } 
                else {
                    var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Subdirector: </b>'+ row.data().subdirector +'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Gerente: </b>' + row.data().gerente + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' + row.data().coordinador + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';
                    row.child(informacion_adicional).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                }
            });
        });

        /*jQuery(document).ready(function () {
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

            function myFunctionD2() {
                formatCurrency($('#inputEdit'));
            }
        });*/

        /*$('.decimals').on('input', function () {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });*/

        /*function SoloNumeros(evt) {
            if (window.event) {
                keynum = evt.keyCode;
            }
            else {
                keynum = evt.which;
            }
            if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46) {
                return true;
            }
            else {
                alerts.showNotification("top", "left", "Solo Numeros.", "danger");
                return false;
            }
        }*/

        /*function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };*/

        /*function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.
            // get input value
            var input_val = input.val();
            // don't validate empty input
            if (input_val === "") {
                return;
            }
            // original length
            var original_len = input_val.length;
            // initial caret position
            var caret_pos = input.prop("selectionStart");
            // check for decimal
            if (input_val.indexOf(".") >= 0) {
                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");
                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);
                // add commas to left side of number
                left_side = formatNumber(left_side);
                // validate right side
                right_side = formatNumber(right_side);
                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }
                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);
                // join number by .
                input_val = left_side + "." + right_side;
            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;
                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }
            // send updated string to input
            input.val(input_val);
            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }*/

        $(document).on('click', '#add-remove-mktd', function (e) { // MJ: FUNCIÓN PARA AGREGAR A MKTD EN UNA COMISIÓN
            document.getElementById("add-remove-mktd").disabled = true;
            e.preventDefault();
            e.stopImmediatePropagation();
            comments = $("#comments").val();
            type_transaction = $("#type_transaction").val();
            if (comments != '') { // MJ: SÍ HAY COMENTARIOS
                $.ajax({
                    type: 'POST',
                    url: url2 + 'Comisiones/addRemoveMktd',
                    data: {
                        'id_lote': $("#id_lote").val(),
                        'comments': comments,
                        'type_transaction': type_transaction,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data == 1) {
                            document.getElementById("add-remove-mktd").disabled = false;
                            alerts.showNotification("top", "right", type_transaction == 1 ? "Marketing digital se ha agregado con éxito." : "Marketing digital se ha removido con éxito.", "success");
                            tabla_1.ajax.reload();
                        } else {
                            document.getElementById("add-remove-mktd").disabled = false;
                            alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                        }
                        cleanFields();
                        $("#modal-add-remove-mktd").modal("hide");
                    }, error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            } else { // MJ: NO HAY COMENTARIOS
                document.getElementById("add-remove-mktd").disabled = false;
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        });

        function cleanFields() {
            $("#comments").val('')
            $("#id_lote").val('')
        }

        $(document).on('click', '.open-mktd-modal', function (e) { // MJ: OPEN MKTD COMMENTS MODAL
            e.preventDefault();
            e.stopImmediatePropagation();
            lote_name = $(this).attr("data-lote");
            $("#id_lote").val($(this).val());
            $("#type_transaction").val($(this).attr("data-type"));
            type = $(this).attr("data-type");
            document.getElementById("modal-mktd-title").innerHTML = type == 1 ? "Agregar MKTD en <b>" + lote_name + "</b>" : "Remover MKTD en <b>" + lote_name + "</b>";
            $("#modal-add-remove-mktd").modal();
        });
    </script>
</body>