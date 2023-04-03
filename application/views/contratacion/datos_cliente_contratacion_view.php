<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php
    switch ($this->session->userdata('id_rol')) {
        case '2':
        case '13':
        case '33':
        case '17':
        case '6':
        case '5':
        case '3':
        case '4':
        case '9':
        case '11':
        case '34':
        case '15':
        case '13':
        case '32':
        case '12':
        case '40': // COBRANZA
        case '53': // COBRANZA
        case '70': // COBRANZA
            // code...
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;
            $this->load->view('template/sidebar', $datos);
            break;
        default:
            // code...
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
            break;
    }
    ?>
    <!--Contenido de la página-->

    <div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h5 class=""></h5>
                </div>
                <form id="my-edit-form" name="my-edit-form" method="post">
                    <div class="modal-body">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Registro de Clientes</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="m-0" for="proyecto">Proyecto</label>
                                            <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  data-live-search="true" title="Selecciona proyecto" data-size="7" required>
                                                <option value="0">Seleccionar todo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="m-0" for="proyecto">Condominio</label>
                                            <select name="condominio" id="condominio"  class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona condominio" data-size="7" required>
                                                <option value="0">Seleccionar todo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="tabla_clientes" name="tabla_clientes">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO PATERNO</th>
                                                <th>APELLIDO MATERNO</th>
                                                <th>NO. RECIBO</th>
                                                <th>REFERENCIA</th>
                                                <th>TIPO PAGO</th>
                                                <th>FECHA APARTADO</th>
                                                <th>ENGANCHE</th>
                                                <th>FECHA ENGANCHE</th>
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
    </div>

    <div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <center><b><h4 class="card-title ">Ventas compartidas</h4></b></center>
                    <div class="material-datatables">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id="verDet" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th>Gerente</th>
                                            <th>Coordinador</th>
                                            <th>Asesor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
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
<script>

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";

    $(document).ready(function () {
        $.post(url + "Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            }

            $("#proyecto").selectpicker('refresh');
        }, 'json');
    });

    $('#proyecto').change(function () {
        let index_proyecto = $(this).val();
        $("#condominio").html("");
        $(document).ready(function () {
            $.post(url + "Contratacion/lista_condominio/" + index_proyecto, function (data) {
                var len = data.length;
                $("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));

                for (var i = 0; i < len; i++) {
                    var id = data[i]['idCondominio'];
                    var name = data[i]['nombre'];
                    $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#condominio").selectpicker('refresh');
            }, 'json');
        });
        fillTable(index_proyecto, 0);
    });

    $('#condominio').change(function () {
        let index_proyecto = $("#proyecto").val();
        let index_condominio = $(this).val();
        fillTable(index_proyecto, index_condominio);
    });

    function fillTable(index_proyecto, index_condominio) {
        tabla_valores_cliente = $("#tabla_clientes").DataTable({
            width: 'auto',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro de clientes',
                    title:'Registro de clientes',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'ID';
                                        break;
                                    case 2:
                                        return 'PROYECTO';
                                        break;
                                    case 3:
                                        return 'CONDOMINIO'
                                    case 4:
                                        return 'LOTE';
                                        break;
                                    case 5:
                                        return 'NOMBRE';
                                        break;
                                    case 6:
                                        return 'APELLIDO PATERNO';
                                        break;
                                    case 7:
                                        return 'APELLIDO MATERNO';
                                        break;
                                    case 8:
                                        return 'NO. RECIBO';
                                        break;
                                    case 9:
                                        return 'REFERENCIA';
                                        break;
                                    case 10:
                                        return 'TIPO PAGO';
                                        break;
                                    case 11:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 12:
                                        return 'ENGANCHE';
                                        break;
                                    case 13:
                                        return 'FECHA ENGANCHE';
                                        break;
                                }
                            }
                        }
                    },

                }
            ],
            pagingType: "full_numbers",
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            processing: true,
            pageLength: 10,
            bAutoWidth: false,
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
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },

                {
                    "data": function (d) {
                        return '<p class="m-0">' + d.id_cliente + '</p>';
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
                        return '<p class="m-0">' + d.nombre + '</p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p class="m-0">'+ d.apellido_paterno + '</p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p class="m-0">' + d.apellido_materno + '</p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p class="m-0">' + d.noRecibo + '</p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p class="m-0">' + d.referencia + '</p>';
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
                        return '<center><button class="btn-data btn-deepGray cop" title= "Ventas compartidas" data-idcliente="' + d.id_cliente + '"><i class="material-icons">people</i></button></center>';
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
                url: url + "RegistroCliente/getregistrosClientesTwo",
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    "index_proyecto": index_proyecto,
                    "index_condominio": index_condominio
                }
            },
            "order": [[1, 'asc']]
        });
        $('#tabla_clientes tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_valores_cliente.row(tr);

            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            }
            else {



                var informacion_adicional2 = '<table class="table text-justify">' +
                    '<tr>INFORMACIÓN: <b>' + row.data().nombre + ' ' + row.data().apellido_paterno + ' ' + row.data().apellido_materno + '</b>' +
                    '<td style="font-size: .8em"><strong>CORREO: </strong>' + myFunctions.validateEmptyField(row.data().correo) + '</td>' +
                    '<td style="font-size: .8em"><strong>TELEFONO: </strong>' + myFunctions.validateEmptyField(row.data().telefono1) + '</td>' +
                    '<td style="font-size: .8em"><strong>RFC: </strong>' + myFunctions.validateEmptyField(row.data().rfc) + '</td>' +
                    '<td style="font-size: .8em"><b>FECHA +45:</b> ' + myFunctions.validateEmptyField(row.data().fechaVecimiento) + '</td>' +
                    '<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>' + myFunctions.validateEmptyField(row.data().fechaNacimiento) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="font-size: .8em"><b>DOMICILIO PARTICULAR:</b> ' + myFunctions.validateEmptyField(row.data().domicilio_particular) + '</td>' +
                    '<td style="font-size: .8em"><b>ENTERADO:</b> ' + myFunctions.validateEmptyField(row.data().enterado) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="font-size: .8em"><b>GERENTE TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().gerente) + '</td>' +
                    '<td style="font-size: .8em"><b>ASESOR TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().asesor) + '</td>' +
                    '</tr>' +
                    '</table>';
                    var informacion_adicional = '<div class="container subBoxDetail">';
                    informacion_adicional += '       <div class="row">';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                    informacion_adicional += '               <label><b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b></label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Correo: </b>'+myFunctions.validateEmptyField(row.data().correo)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Teléfono: </b>'+myFunctions.validateEmptyField(row.data().telefono1)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>RFC: </b>'+myFunctions.validateEmptyField(row.data().rfc)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Fecha +45: </b>'+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Fecha nacimiento: </b>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Domicilio Particular: </b>'+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Enterado: </b>'+myFunctions.validateEmptyField(row.data().enterado)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Gerente: </b>'+myFunctions.validateEmptyField(row.data().gerente) +'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
                    informacion_adicional += '               <label><b>Asesor Titular: </b>'+myFunctions.validateEmptyField(row.data().asesor)+'</label>';
                    informacion_adicional += '           </div>';
                    informacion_adicional += '       </div>';
                    informacion_adicional += '    </div>';


                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            }
        });
    }

    $("#tabla_clientes").ready(function () {
        $('#tabla_clientes thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 15) {
                var title = $(this).text();
                $(this).html('<input class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (tabla_valores_cliente.column(i).search() !== this.value) {
                        tabla_valores_cliente
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        let titulos = [];
        $('#tabla_clientes thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 13) {
                var title = $(this).text();

                titulos.push(title);
            }
        });
    });


    var id_cliente_global = 0;

    $(document).on('click', '.cop', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var id_cliente = $itself.attr('data-idcliente');

        id_cliente_global = id_cliente;
        tableHistorial.ajax.reload();
        $('#verDetalles').modal('show');
    });


    $(document).ready(function () {
        tableHistorial = $('#verDet').DataTable({
            responsive: true,
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Reporte ventas compartidas',
                    title:'Reporte ventas compartidas',
                }
            ],
            "scrollX": true,
            "pageLength": 10,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columns: [
                {"data": "nombreGerente"},
                {"data": "nombreCoordinador"},
                {"data": "nombreAsesor"}
            ],
            "processing": true,
            "bAutoWidth": false,
            "bLengthChange": false,
            "bInfo": true,
            "ordering": false,
            "fixedColumns": true,
            "ajax": {
                "url": "<?=base_url()?>index.php/registroCliente/getcop/",
                "type": "POST",
                cache: false,
                "data": function (d) {
                    d.id_cliente = id_cliente_global;
                }
            },
        });
    });


    $(window).resize(function () {
        tabla_valores_cliente.columns.adjust();
    });

</script>

