<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>



    <!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_interes">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>-->


    <div class="modal fade" id="seeInformationModalDU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #3982C0;">
                            <div id="nameLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                            onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
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
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Descuentos Universidad - <b>Liquidados</b></h3>
                                <p class="card-title pl-1">(Listado de descuentos completos ó pausados)</p><br>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h5 class="card-title center-align">
                                    <!--Total bonos aplicados<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totalp" id="totalp">-->
                                    Total descuentos<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="totalp" id="totalp">
                                </h5>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tabla_descuentos" name="tabla_descuentos"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
                                                <th>DESCUENTO</th>
                                                <th>APLICADO</th>
                                                <th>PENDIENTE GRAL.</th>
                                                <th>PAGO MENSUAL</th>
                                                <th>ESTATUS</th>
                                                <th>PENDIENTE MES</th>
                                                <th>DISPONIBLE DESC.</th>
                                                <th>FEC. CREACIÓN</th>
                                                <th>ACCIONES</th>
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
 

    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<link href="<?= base_url() ?>dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>dist/js/controllers/select2/select2.min.js"></script>-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var totaPen = 0;
    var tr;


    $("#tabla_descuentos").ready(function () {

        let titulos = [];

        $('#tabla_descuentos thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i!=12) {
                var title = $(this).text();
                titulos.push(title);

                //titulos.push(title);

                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {

                    if (tabla_nuevas.column(i).search() !== this.value) {
                        tabla_nuevas
                            .column(i)
                            .search(this.value)
                            .draw();

                        var total = 0;
                        var index = tabla_nuevas.rows({selected: true, search: 'applied'}).indexes();
                        var data = tabla_nuevas.rows(index).data();

                        $.each(data, function (i, v) {
                            total += parseFloat(v.monto);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("totalp").value = to1;
                        // console.log('fsdf'+total);
                    }
                });
            }
        });

        $('#tabla_descuentos').on('xhr.dt', function (e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function (i, v) {
                total += parseFloat(v.monto);
            });
            var to = formatMoney(total);
            document.getElementById("totalp").value = to;
        });

        tabla_nuevas = $("#tabla_descuentos").DataTable({
            // dom: 'Brtip',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            "buttons": [

     
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'buttons-excel',
                    titleAttr: 'DESCUENTOS UNIVERSIDAD LIQUIDADOS',
                    title: 'DESCUENTOS UNIVERSIDAD LIQUIDADOS',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID';
                                        break;
                                    case 1:
                                        return 'USUARIO';
                                        break;
                                    case 2:
                                        return 'PUESTO';
                                    case 3:
                                        return 'SEDE';
                                        break;
                                    case 4:
                                        return 'DESCUENTO';
                                        break;
                                    case 5:
                                        return 'APLICADO';
                                        break;
                                    case 6:
                                        return 'PENDIENTE GRAL.';
                                        break;
                                    case 7:
                                        return 'PAGO MENSUAL';
                                        break;
                                    case 8:
                                        return 'ESTATUS';
                                        break;
                                    case 9:
                                        return 'PENDIENTE MES';
                                        break;
                                    case 10:
                                        return 'DISPONIBLE DESC';
                                        break;
                                    case 11:
                                        return 'FECHA CREACIÓN';
                                        break;
                                }
                            }
                        }
                    }
                },


            ],
            width: 'auto',
            "ordering": false,

            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
            "columns": [
                {
                    "width": "3%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.id_usuario + '</p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.nombre + '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.puesto + '</p>';
                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.sede + '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        // , du.pagado_caja, du.pago_individual, du.pagos_activos
                        return '<p style="font-size: 1em"><b>$' + formatMoney(d.monto) + '</b></p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        // abono_00 = parseFloat(d.abono_pagado + d.pagado_caja);
                        if (d.aply == null || d.aply <= 1) {
                            return '<p style="font-size: 1em">$' + formatMoney(d.pagado_caja) + '</p>';
                        } else {
                            return '<p style="font-size: 1em">$' + formatMoney(d.aply) + '</p>';
                        }

                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        OP = parseFloat(d.monto - d.aply);
                        return '<p style="font-size: 1em; color:gray">$' + formatMoney(OP) + '</p>';
                    }
                },

                {
                    "width": "8%",// PAGADO mensual
                    "data": function (d) {

                        return '<p style="font-size: 1em">$' + formatMoney(d.pago_individual) + '</p>';

                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        if (d.status == 0 && d.estatus != 4) {
                            return '<span class="label" style="background:red;">BAJA</span>';
                        }
                        else if (d.estatus == 4) {
                            return '<span class="label" style="background:black;">LIQUIDADO</span>';
                        }
                        else {
                            return '<span class="label" style="background:gray">NO DETECTADO</span>';
                        }
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        OK = parseFloat(d.pago_individual * d.pagos_activos);
                        OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }


                        if (OP2 < 1) {

                            return '<p style="font-size: 1em; color:gray">$' + formatMoney(0) + '</p>';

                        } else {
                            return '<p style="font-size: 1em; color:red"><b>$' + formatMoney(OP2) + '</b></p>';

                        }
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {

                        validar = 0;
                        OK = parseFloat(d.pago_individual * d.pagos_activos);
                        OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }


                        if (OP2 < 1) {

                            respuesta = 0;

                        } else {

                            if (d.id_sede == 6) {
                                if (d.abono_nuevo < 15000) {
                                    respuesta = 0;
                                } else {

                                    validar = Math.trunc(d.abono_nuevo / 15000);

                                    if (validar >= d.pagos_activos) {
                                        validar = d.pagos_activos;
                                        respuesta = OP2;
                                    } else {

                                        respuesta = validar * d.pago_individual;
                                    }

                                }
                            } else {
                                if (d.abono_nuevo < 10000) {
                                    respuesta = 0;
                                } else {

                                    validar = Math.trunc(d.abono_nuevo / 10000);

                                    if (validar >= d.pagos_activos) {
                                        validar = d.pagos_activos;
                                        respuesta = OP2;
                                    } else {

                                        respuesta = (validar * d.pago_individual);
                                    }

                                }
                            }


                        }

                        return '<p style="font-size: 1em; color:gray"><b>$' + formatMoney(respuesta) + '</b></p>';

                    }
                },
                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.fecha_creacion + '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<span class="fas fa-info-circle"></span></button></div>';
                    },
                }
            ],
            columnDefs: [
                {

                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center'
                }],

            "ajax": {
                "url": url2 + "Comisiones/getDescuentosLiquidados",
                /*registroCliente/getregistrosClientes*/
                "type": "POST",
                cache: false,
                "data": function (d) {

                }
            },
        });


        $("#tabla_descuentos tbody").on("click", ".consultar_logs_asimilados", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            id_user = $(this).val();
            lote = $(this).attr("data-value");

            $("#seeInformationModalDU").modal();
            $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DESCUENTO: <b>' + lote + '</b></h5></p>');
            $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                if (!data) {

                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');

                } else {
                    $.each(data, function (i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SE DESCONTÓ LA CANTIDAD DE <b>$' + formatMoney(v.comentario) + '</b><br><b style="color:#3982C0;font-size:0.9em;">' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });
        });


      

        $('#tabla_descuentos tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
            } else {
                if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                    $.post(url + "Comisiones/getDescuentosCapitalpagos", {"id_usuario": row.data().id_usuario}).done(function (data) {

                        row.data().solicitudes = JSON.parse(data);

                        tabla_nuevas.row(tr).data(row.data());

                        row = tabla_nuevas.row(tr);

                        row.child(construir_subtablas(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");

                    });
                } else {
                    row.child(construir_subtablas(row.data().solicitudes)).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                }

            }


        });


        function construir_subtablas(data) {
            var solicitudes = '<table class="table">';
            $.each(data, function (i, v) {
                //i es el indice y v son los valores de cada fila

                // console.log(data);
                if (v.id_usuario == 'undefined') {
                    solicitudes += '<tr>';
                    solicitudes += '<td><b>SIN PAGO APLICADOS</b></td>';
                    solicitudes += '</tr>';


                } else {
                    solicitudes += '<tr>';
                    solicitudes += '<td><b>Pago ' + (i + 1) + '</b></td>';
                    solicitudes += '<td>' + '<b>' + 'USUARIO ' + '</b> ' + v.nombre + '</td>';
                    solicitudes += '<td>' + '<b>' + 'MONTO: ' + '</b> $' + formatMoney(v.abono_neodata) + '</td>';
                    solicitudes += '<td>' + '<b>' + 'CREADO POR: ' + '</b> ' + v.creado_por + '</td>';
                    solicitudes += '<td>' + '<b>' + 'FECHA CAPTURA: ' + '</b> ' + v.fecha_abono + '</td>';
                    solicitudes += '</tr>';
                }

            });

            return solicitudes += '</table>';
        }

 
    });


    /**-------------------------------------------------------------------------------------------------------------------------------------------------------- */






    /*function cancela() {
        $("#modal_nuevas").modal('toggle');
    }*/


    //Función para pausar la solicitud
    /*$("#form_interes").submit(function (e) {

        $('#btn_topar').attr('disabled', 'true');

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);
            console.log(data);
            // data.append("id_pago_i", id_pago_i);
            $.ajax({
                url: url + "Comisiones/topar_descuentos",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data[0]) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se detuvo el descuento exitosamente", "success");
                        setTimeout(function () {
                            tabla_nuevas.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    } else {
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });*/


    /*function filterFloat(evt, input) {
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        var isNumber = (key >= 48 && key <= 57);
        var isSpecial = (key == 8 || key == 13 || key == 0 || key == 46);
        if (isNumber || isSpecial) {
            return filter(tempValue);
        }

        return false;

    }*/

    /*function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        return (preg.test(__val__) === true);
    }*/


    $("#roles").change(function () {
        var parent = $(this).val();

        $("#users2").val('');

        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");


        document.getElementById("users2").innerHTML = '';
        $('#users2').append(`<label class="label">Usuario</label><select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>`);
        $.post('getUsuariosRolDU/' + parent, function (data) {
            $("#usuarioid2").append($('<option disabled>').val("default").text("Seleccione una opción"))
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['name_user'];
                $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
            }
            if (len <= 0) {
                $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#usuarioid2").selectpicker('refresh');
        }, 'json');
    });


    /*$("#form_basta").submit(function (e) {

        $('#idloteorigen').removeAttr('disabled');
        $('#btn_abonar').attr('disabled', 'true');

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data1 = new FormData($(form)[0]);
            $.ajax({
                url: 'saveDescuento/' + 3,
                data: data1,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        $('#idloteorigen option').remove();
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        $('#usuarioid').val('default');
                        $('#usuarioid').val('default');

                        $("#usuarioid").selectpicker("refresh");

                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");


                    } else if (data == 2) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();

                    } else if (data == 3) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();

                    }
                    $('#idloteorigen').attr('disabled', 'true');

                },
                error: function () {
                    $('#loaderDiv').addClass('hidden');
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#idloteorigen').attr('disabled', 'true');


                }
            });
        }
    });*/


    // btn_descontar


    /*$("#form_nuevo").submit(function (e) {

        $('#btn_abonar').attr('disabled', 'true');

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data1 = new FormData($(form)[0]);
            $.ajax({
                url: 'saveDescuentoch/',
                data: data1,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        document.getElementById("users2").innerHTML = '';
                        $("#usuarioid2").val('');
                        $("#usuarioid2").selectpicker("refresh");

                        $("#descuento").val('');
                        $("#numeroPagos").val('');
                        $("#pago_ind01").val('');
                        $("#comentario2").val('');
                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");

                    } else if (data == 2) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();

                    } else if (data == 3) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();

                    }

                },
                error: function () {
                    $('#loaderDiv').addClass('hidden');
                    $('#ModalBonos').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#idloteorigen').attr('disabled', 'true');


                }
            });
        }
    });*/


    /*$("#numeroPagos").change(function () {


        let monto1 = replaceAll($('#descuento').val(), ',', '');
        let monto = replaceAll(monto1, '$', '');
        let cantidad = parseFloat($('#numeroPagos').val());
        let resultado = 0;


        if (isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            $('#pago_ind01').val(resultado);
            document.getElementById('btn_abonar').disabled = true;
        } else {
            resultado = monto / cantidad;

            if (resultado > 0) {
                // document.getElementById('btn_abonar').disabled=false;
                $('#pago_ind01').val(formatMoney(resultado));
            } else {
                // document.getElementById('btn_abonar').disabled=true;
                $('#pago_ind01').val(formatMoney(0));
            }
        }
    });*/


    function closeModalEng() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form_abono").reset();
        a = document.getElementById('inputhidden');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal_abono").modal('toggle');

    }

    function CloseModalDelete() {
        // document.getElementById("inputhidden").innerHTML = "";
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-delete").modal('toggle');

    }

    /*function CloseModalDelete2() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-delete").reset();
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-delete").modal('toggle');

    }*/

    /*function CloseModalUpdate2() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-update").reset();
        a = document.getElementById('borrarUpdare');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-abono").modal('toggle');

    }*/

    /*$(document).on('submit', '#form-delete', function (e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("form-delete"));
        formData.append("dato", "valor");
        $.ajax({
            method: 'POST',
            url: url + 'Comisiones/BorrarDescuento',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                    CloseModalDelete2();
                    // $('#modal_abono').modal('hide');
                    alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
                    document.getElementById("form_abono").reset();

                } else if (data == 0) {
                    $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                    CloseModalDelete2();
                    //$('#modal-delete').modal('hide');
                    alerts.showNotification("top", "right", "Pago liquidado.", "warning");
                }
            },
            error: function () {
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });*/


    /*$("#form_aplicar").submit(function (e) {
        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);
            console.log(data);
            data.append("id_pago_i", id_pago_i);
            $.ajax({
                // url: url + "Comisiones/pausar_solicitud/",
                url: url + 'Comisiones/UpdateDescuento',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data = 1) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                        setTimeout(function () {
                            tabla_nuevas.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    } else {
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });*/


    // FIN TABLA PAGADAS


    /*function mandar_espera(idLote, nombre) {
        idLoteespera = idLote;
        // link_post2 = "Cuentasxp/datos_para_rechazo1/";
        link_espera1 = "Comisiones/generar comisiones/";
        $("#myModalEspera .modal-footer").html("");
        $("#myModalEspera .modal-body").html("");
        $("#myModalEspera ").modal();
        // $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
        $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
    }*/


    // FUNCTION MORE

    $(window).resize(function () {
        tabla_nuevas.columns.adjust();
        // tabla_proceso.columns.adjust();
        // tabla_pagadas.columns.adjust();
        // tabla_otras.columns.adjust();
    });

    function formatMoney(n) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    /**.---------------------------ROLES------------------------------------------ */


    /**----------------------------FIN ROLES------------------------------------------------------------- */
    /*$("#idloteorigen").select2({dropdownParent: $('#miModal')});
    $("#idloteorigen").select2("readonly", true);*/
    /**-----------------------------LOTES----------------------- */
    /*$("#idloteorigen").change(function () {

        let cuantos = $('#idloteorigen').val().length;
        let suma = 0;
        //let ids = $('#idloteorigen').val();

        if (cuantos > 1) {

            var comision = $(this).val();


            //alert(comision);
            //let ids = comision.split(',');
            for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                datos = comision[index].split(',');
                let id = datos[0];
                let monto = datos[1];
                // var id = comision[index];
                document.getElementById('monto').value = '';

                $.post('getInformacionData/' + id + '/' + 1, function (data) {

                    var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                    suma = suma + disponible;
                    document.getElementById('montodisponible').innerHTML = '';
                    $("#idmontodisponible").val('$' + formatMoney(suma));
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + suma.toFixed(2) + '">');
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                    var len = data.length;
                    if (len <= 0) {
                        $("#idmontodisponible").val('$' + formatMoney(0));
                    }
                    $("#montodisponible").selectpicker('refresh');
                }, 'json');
            }
            console.log(suma);
        } else {
            var comision = $(this).val();
            datos = comision[0].split(',');
            let id = datos[0];
            let monto = datos[1];
            //alert(id+'-------'+monto);
            document.getElementById('monto').value = '';
            $.post('getInformacionData/' + id + '/' + 1, function (data) {
                var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                document.getElementById('montodisponible').innerHTML = '';
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + disponible + '">');
                $("#idmontodisponible").val('$' + formatMoney(disponible));
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                var len = data.length;
                if (len <= 0) {
                    $("#idmontodisponible").val('$' + formatMoney(0));
                }
                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    });*/

    /**--------------------------------------------------------------------------------------------------------- */



    /*function verificar() {
        // let d = $('#valor_comision').val();
        let d2 = replaceAll($('#idmontodisponible').val(), ',', '');
        let disponiblefinal = replaceAll(d2, '$', '');
        //let m1 = $('#monto').val();
        let m = replaceAll($('#monto').val(), ',', '');
        let montofinal = replaceAll(m, '$', '');

        let disponible = parseFloat(disponiblefinal);
        let monto = parseFloat(montofinal);
        console.log('disponible: ' + disponible);
        console.log('monto: ' + monto);
        if (monto < 1 || isNaN(monto)) {
            alerts.showNotification("top", "right", "No hay saldo disponible para descontar.", "warning");
            document.getElementById('btn_abonar').disabled = true;
        } else {
            if (parseFloat(monto) <= parseFloat(disponible)) {
                // console.log('paso');
                let cantidad = parseFloat($('#numeroP').val());
                resultado = monto / cantidad;
                $('#pago').val(formatMoney(resultado));
                document.getElementById('btn_abonar').disabled = false;
                // console.log('OK');
                let cuantos = $('#idloteorigen').val().length;
                let cadena = '';
                var data = $('#idloteorigen').select2('data')
                for (let index = 0; index < cuantos; index++) {
                    let datos = data[index].id;
                    let montoLote = datos.split(',');
                    let abono_neo = montoLote[1];
                    if (parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1) {
                        document.getElementById('msj2').innerHTML = "El monto ingresado se cubre con la comisión " + data[index].text;
                        document.getElementById('btn_abonar').disabled = true;
                        break;
                    }
                    cadena = cadena + ' , ' + data[index].text;
                    document.getElementById('msj2').innerHTML = '';

                }
                $('#comentario').val('Lotes involucrados en el descuento(universidad): ' + cadena + '. Por la cantidad de: $' + formatMoney(monto));

                // console.log(cadena);
            }
            //else {
            else if (parseFloat(monto) > parseFloat(disponible)) {
                alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                //document.getElementById('monto').value = '';
                document.getElementById('btn_abonar').disabled = true;
            }
        }

    }*/


    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }


    /*function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }*/


    /*function open_Mb() {
        // console.log("SI ENTRA");
        // $("ModalBonos").modal();

        $("#roles").val('');
        $("#roles").selectpicker("refresh");

        document.getElementById("users2").innerHTML = '';


        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");

        $("#comentario2").val('');

        $('#ModalBonos').modal('show');
    }*/

</script>
   

