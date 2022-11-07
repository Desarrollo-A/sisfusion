<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    ?>
    <!--Contenido de la página-->


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Registro estatus 15</h3>
                                <p class="card-title pl-1">(Acuse entregado)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tabla_ingresar_15" name="tabla_ingresar_15"
                                            class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>GERENTE</th>
                                                <th>CLIENTE</th>
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

    <!-- modal  ENVIA A CONTRALORIA 7-->
    <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h4 class="modal-title"><label>Registro estatus 15 - <b><span
                                            class="lote"></span></b></label></h4></center>
                </div>
                <div class="modal-body">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <label>Comentario:</label>
                            <textarea class="form-control" id="comentario" rows="3"></textarea>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->


    <!-- modal  rechazar A CONTRALORIA 7-->
    <div class="modal fade" id="rechReg" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h4 class="modal-title"><label>Rechazo estatus 15 - <b><span
                                            class="lote"></span></b></label></h4></center>
                </div>
                <div class="modal-body">
                    <label>Comentario:</label>
                    <textarea class="form-control" id="comentario3" rows="3"></textarea>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save3" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->


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
<script>

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";


    var getInfo1 = new Array(6);
    var getInfo3 = new Array(6);


    $("#tabla_ingresar_15").ready(function () {
        $('#tabla_ingresar_15 thead tr:eq(0) th').each(function (i) {

            if (i != 0 && i != 7 && i != 1) {
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (tabla_15.column(i).search() !== this.value) {
                        tabla_15
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });


        tabla_15 = $("#tabla_ingresar_15").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",

            width: 'auto',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro estatus 15',
                    title:"Registro estatus 15",
                    exportOptions: {
                        columns: [1,2,3,4,5,6],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'TIPO VENTA';
                                    case 2:
                                        return 'PROYECTO';
                                    case 3:
                                        return 'CONDOMINIO';
                                        break;
                                    case 4:
                                        return 'LOTE';
                                        break;
                                    case 5:
                                        return 'GERENTE';
                                        break;
                                    case 6:
                                        return 'CLIENTE';
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Registro estatus 15',
                    title: "Registro estatus 15",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [1,2,3,4,5,6],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'TIPO VENTA';
                                    case 2:
                                        return 'PROYECTO';
                                    case 3:
                                        return 'CONDOMINIO';
                                        break;
                                    case 4:
                                        return 'LOTE';
                                        break;
                                    case 5:
                                        return 'GERENTE';
                                        break;
                                    case 6:
                                        return 'CLIENTE';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [
                {
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {

                    "data": function (d) {
                        var lblStats;
                        if (d.tipo_venta == 1)
                            lblStats = '<span class="label label-danger">Venta Particular</span>';
                        else if (d.tipo_venta == 2)
                            lblStats = '<span class="label label-success">Venta normal</span>';
                        else if (d.tipo_venta == 3)
                            lblStats = '<span class="label label-warning">Bono</span>';
                        else if (d.tipo_venta == 4)
                            lblStats = '<span class="label label-primary">Donación</span>';
                        else if (d.tipo_venta == 5)
                            lblStats = '<span class="label label-info">Intercambio</span>';
                        else if(d.tipo_venta==6)
                            lblStats ='<span class="label label-info">Reubicación</span>';
                        else if(d.tipo_venta==7)
                            lblStats ='<span class="label label-info">Venta especial</span>';
                        else if (d.tipo_venta == null)
                            lblStats = '<span class="label label-info">Sin especificar</span>';   
                        else
                            lblStats = '<span class="label label-info">Sin especificar</span>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p class="m-0">' + (d.nombreCondominio).toUpperCase();
                        +'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';

                    }
                },
                {
                    "width": "20%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.gerente + '</p>';
                    }
                },
                {
                    "width": "20%",
                    "data": function (d) {
                        return '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>';
                    }
                },
                {
                    "width": "40%",
                    "orderable": false,
                    "data": function (data) {

                        var cntActions;

                        if (data.vl == '1') {
                            cntActions = 'En proceso de Liberación';

                        } else {

                            if (data.idStatusContratacion == 14 && data.idMovimiento == 44 ||
                                data.idStatusContratacion == 14 && data.idMovimiento == 69 ||
                                data.idStatusContratacion == 14 && data.idMovimiento == 80) {

                                cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                    'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                                    'class="btn-data btn-green editReg" title="Registrar estatus">' +
                                    '<i class="fas fa-thumbs-up"></i></button>';
                            } 
                            else {
                                cntActions = 'N/A';
                            }
                        }
                        return '<div class="d-flex justify-center">'+cntActions+'</div>';

                    }
                }

            ],

            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },

            ],

            "ajax": {
                "url": '<?=base_url()?>index.php/Contraloria/getregistroStatus15ContratacionContraloria',
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function (d) {
                }
            },
            "order": [[1, 'asc']]

        });

        $('#tabla_ingresar_15 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_15.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } else {
                var status;

                var fechaVenc;
                if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 44) {
                    status = 'Status 14 listo (Asistentes Gerentes)';
                } else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 69) {
                    status = 'Status 14 Enviado a Revición (Asistentes Gerentes)';
                } else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 80) {
                    status = 'Status 14 (Regreso Contratación)';
                } else {
                    status = 'N/A';
                }

                if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 44 ||
                    row.data().idStatusContratacion == 14 && row.data().idMovimiento == 69 ||
                    row.data().idStatusContratacion == 14 && row.data().idMovimiento == 80) {
                    fechaVenc = row.data().fechaVenc;
                } else {
                    fechaVenc = 'N/A';
                }


                var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '  <div class="row">';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '          <label><b>Información adicional</b></label>';
                informacion_adicional += '      </div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>'+ status +'</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA VENCIMIENTO: </b> ' + fechaVenc + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA REALIZADO: </b> ' + row.data().modificado + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
                informacion_adicional += '  </div>';
                informacion_adicional += '</div>';




                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
            }


        });


        $("#tabla_ingresar_15 tbody").on("click", ".editReg", function (e) {
            e.preventDefault();

            getInfo1[0] = $(this).attr("data-idCliente");
            getInfo1[1] = $(this).attr("data-nombreResidencial");
            getInfo1[2] = $(this).attr("data-nombreCondominio");
            getInfo1[3] = $(this).attr("data-idcond");
            getInfo1[4] = $(this).attr("data-nomlote");
            getInfo1[5] = $(this).attr("data-idLote");
            getInfo1[6] = $(this).attr("data-fecven");
            getInfo1[7] = $(this).attr("data-code");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#editReg').modal('show');

        });


        $("#tabla_ingresar_15 tbody").on("click", ".cancelReg", function (e) {
            e.preventDefault();

            getInfo3[0] = $(this).attr("data-idCliente");
            getInfo3[1] = $(this).attr("data-nombreResidencial");
            getInfo3[2] = $(this).attr("data-nombreCondominio");
            getInfo3[3] = $(this).attr("data-idcond");
            getInfo3[4] = $(this).attr("data-nomlote");
            getInfo3[5] = $(this).attr("data-idLote");
            getInfo3[6] = $(this).attr("data-fecven");
            getInfo3[7] = $(this).attr("data-code");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#rechReg').modal('show');

        });


    });


    $(document).on('click', '#save1', function (e) {
        e.preventDefault();

        var comentario = $("#comentario").val();


        var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;

        var dataExp1 = new FormData();

        dataExp1.append("idCliente", getInfo1[0]);
        dataExp1.append("nombreResidencial", getInfo1[1]);
        dataExp1.append("nombreCondominio", getInfo1[2]);
        dataExp1.append("idCondominio", getInfo1[3]);
        dataExp1.append("nombreLote", getInfo1[4]);
        dataExp1.append("idLote", getInfo1[5]);
        dataExp1.append("comentario", comentario);
        dataExp1.append("fechaVenc", getInfo1[6]);


        if (validaComent == 0) {
            alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
        }

        if (validaComent == 1) {

            $('#save1').prop('disabled', true);
            $.ajax({
                url: '<?=base_url()?>index.php/Contraloria/editar_registro_lote_contraloria_proceceso15/',
                data: dataExp1,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    response = JSON.parse(data);

                    if (response.message == 'OK') {
                        $('#save1').prop('disabled', false);
                        $('#editReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if (response.message == 'FALSE') {
                        $('#save1').prop('disabled', false);
                        $('#editReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if (response.message == 'ERROR') {
                        $('#save1').prop('disabled', false);
                        $('#editReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function (data) {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });

        }

    });


    $(document).on('click', '#save3', function (e) {
        e.preventDefault();

        var comentario = $("#comentario3").val();

        var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;

        var dataExp3 = new FormData();

        dataExp3.append("idCliente", getInfo3[0]);
        dataExp3.append("nombreResidencial", getInfo3[1]);
        dataExp3.append("nombreCondominio", getInfo3[2]);
        dataExp3.append("idCondominio", getInfo3[3]);
        dataExp3.append("nombreLote", getInfo3[4]);
        dataExp3.append("idLote", getInfo3[5]);
        dataExp3.append("comentario", comentario);
        dataExp3.append("fechaVenc", getInfo3[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {

            $('#save3').prop('disabled', true);
            $.ajax({
                url: '<?=base_url()?>index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso15/',
                data: dataExp3,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    response = JSON.parse(data);

                    if (response.message == 'OK') {
                        $('#save3').prop('disabled', false);
                        $('#rechReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if (response.message == 'FALSE') {
                        $('#save3').prop('disabled', false);
                        $('#rechReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if (response.message == 'ERROR') {
                        $('#save3').prop('disabled', false);
                        $('#rechReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function (data) {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });

        }

    });


    jQuery(document).ready(function () {

        jQuery('#editReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario').val('');
        })

        jQuery('#rechReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario3').val('');
        })

    })


</script>

