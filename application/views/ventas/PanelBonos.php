<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>


        <!-- Modals -->
        <!--<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_espera_uno">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <!--<div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">BONOS</h4>
                    </div>
                    <form method="post" id="form_bonos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker" name="roles" id="roles" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>
                                </select>
                            </div>

                            <div class="form-group" id="users"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="label">Bono</label>
                                    <input class="form-control" type="text" id="monto" name="monto">
                                </div>
                                <div class="col-md-4">
                                    <label class="label">Meses a pagar</label>
                                    <select class="form-control" name="numeroP" id="numeroP" required>
                                        <option value="">-------SELECCIONAR--------</option>
                                        <option value="6">6</option>
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="label">Pago</label>
                                    <input class="form-control" id="pago" type="text" name="pago" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Comentario</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->

        <!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>-->

        <div class="modal fade modal-alertas" id="modal_bonos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_bonos">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?= base_url() ?>static/images/autor.png" width="200" height="200"></center>
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modals -->

            <div class="content boxContent">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <ul class="nav nav-tabs nav-tabs-cm">
                                <li class="active">
                                    <a href="#nuevas-1" role="tab" data-toggle="tab">
                                        <i class="fas fa-star pr-1 fa-lg"></i>NUEVOS
                                    </a>
                                </li>
                                <li>
                                    <a href="#proceso-1" role="tab" data-toggle="tab">
                                    <i class="fas fa-clipboard pr-1 fa-lg"></i> EN REVISIÓN
                                    </a>
                                </li>
                                <li>
                                    <a href="#proceso-2" role="tab" data-toggle="tab">
                                        <i class="fas fa-hand-holding-usd pr-1 fa-lg"></i> POR PAGAR
                                    </a>
                                </li>
                                <li>
                                    <a href="#proceso-3" role="tab" data-toggle="tab">
                                        <i class="fas fa-exclamation-triangle  pr-1 fa-lg"></i>OTROS
                                    </a>
                                </li>
                            </ul>
                            <div class="card no-shadow m-0">
                                <div class="card-content p-0">
                                    <div class="nav-tabs-custom">
                                        <div class="tab-content p-2">
                                            <div class="tab-pane active" id="nuevas-1">
                                                <h3 class="card-title center-align">Nuevos bonos</h3>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>USUARIO</th>
                                                                        <th>PUESTO</th>
                                                                        <th>MONTO BONO</th>
                                                                        <th>ABONADO</th>
                                                                        <th>PENDIENTE</th>
                                                                        <th>TOTAL PAGOS</th>
                                                                        <th>PAGO INDIVIDUAL</th>
                                                                        <th>IMPUESTO</th>
                                                                        <th>TOTAL A PAGAR</th>
                                                                        <th>ESTATUS</th>
                                                                        <th>FECHA DE REGISTRO</th>
                                                                        <th>OPCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="proceso-1">
                                                <h3 class="card-title center-align">Bonos en revisión</h3>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table-striped table-hover" id="tabla_bono_revision" name="tabla_bono_revision">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>USUARIO</th>
                                                                        <th>PUESTO</th>
                                                                        <th>MONTO BONO</th>
                                                                        <th>ABONADO</th>
                                                                        <th>PENDIENTE</th>
                                                                        <th>TOTAL PAGOS</th>
                                                                        <th>PAGO INDIVIDUAL</th>
                                                                        <th>IMPUESTO</th>
                                                                        <th>TOTAL A PAGAR</th>
                                                                        <th>ESTATUS</th>
                                                                        <th>FECHA DE REGISTRO</th>
                                                                        <th>OPCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="proceso-2">
                                                <h3 class="card-title center-align">Bonos pagados</h3>
                                                <div class="toolbar">
                                                    <div class="container-fluid p-0">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="form-group d-flex justify-center align-center">
                                                                    <h4 class="title-tot center-align m-0">Bonos pagados</h4>
                                                                    <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table-striped table-hover" id="tabla_bono_pagado" name="tabla_bono_pagado">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>USUARIO</th>
                                                                        <th>PUESTO</th>
                                                                        <th>MONTO BONO</th>
                                                                        <th>ABONADO</th>
                                                                        <th>PENDIENTE</th>
                                                                        <th>TOTAL PAGOS</th>
                                                                        <th>PAGO INDIVIDUAL</th>
                                                                        <th>IMPUESTO</th>
                                                                        <th>TOTAL A PAGAR</th>
                                                                        <th>ESTATUS</th>
                                                                        <th>FECHA DE REGISTRO</th>
                                                                        <th>OPCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="proceso-3">
                                                <h3 class="card-title center-align">Otros</h3>
                                                <div class="toolbar">
                                                    <div class="container-fluid p-0">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="form-group d-flex justify-center align-center">
                                                                    <h4 class="title-tot center-align m-0">Bonos</h4>
                                                                    <p class="input-tot pl-1" name="totalo" id="totalo">$0.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table-striped table-hover" id="tabla_bono_otros" name="tabla_bono_otros">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>USUARIO</th>
                                                                        <th>PUESTO</th>
                                                                        <th>MONTO BONO</th>
                                                                        <th>ABONADO</th>
                                                                        <th>PENDIENTE</th>
                                                                        <th>TOTAL PAGOS</th>
                                                                        <th>PAGO INDIVIDUAL</th>
                                                                        <th>IMPUESTO</th>
                                                                        <th>TOTAL A PAGAR</th>
                                                                        <th>ESTATUS</th>
                                                                        <th>FECHA DE REGISTRO</th>
                                                                        <th>OPCIONES</th>
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
                    </div>
                </div>
            </div>
            <?php $this->load->view('template/footer_legend'); ?>
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
        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totaPen = 0;
        var tr;

        function closeModalEng() {
            document.getElementById("form_abono").reset();
            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);

            $("#modal_abono").modal('toggle');
        }

        $("#form_bonos").on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById("form_bonos"));
            formData.append("dato", "valor");
            $.ajax({
                url: 'saveBono',
                data: formData,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data == 1) {
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
                        tabla_nuevas.ajax.reload();
                        tabla_nuevas2.ajax.reload();
                        document.getElementById("form_bonos").reset();
                    } else if (data == 2) {
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    } else if (data == 3) {
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    }
                },
                error: function() {
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $("#tabla_prestamos").ready(function() {
            let titulos = [];
            $('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
                if( i!=12){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if (tabla_nuevas.column(i).search() !== this.value ) {
                            tabla_nuevas
                            .column(i)
                            .search(this.value)
                            .draw();

                            var total = 0;
                            var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                            var data = tabla_nuevas.rows( index ).data();
                        }
                    });
                }
            });
            
            tabla_nuevas = $("#tabla_prestamos").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO ';
                                }else if(columnIdx == 2){
                                    return 'ROL ';
                                }else if(columnIdx == 3){
                                    return 'MONTO BONO';
                                }else if(columnIdx == 4){
                                    return 'ABONDADO';
                                }else if(columnIdx == 5){
                                    return 'PENDIENTE';
                                }
                                else if(columnIdx == 6){
                                    return 'NÚMERO PAGO';
                                }else if(columnIdx == 7){
                                    return 'PAGO INDIVIDUAL';
                                }
                                else if(columnIdx == 8){
                                    return 'IMPUESTO';
                                }
                                else if(columnIdx == 9){
                                    return 'TOTAL A PAGAR';
                                }
                                else if(columnIdx == 10){
                                    return 'ESTATUS';
                                }
                                else if(columnIdx == 11){
                                    return 'FECHA';
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
                    "width": "4%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
                    }
                },
                {
                    "width": "16%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.nombre + '</center></p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>$' + formatMoney(d.monto) + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        let abonado = d.n_p*d.pago;
                        if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                            abonado = d.monto;
                        }else{
                            abonado =d.n_p*d.pago;
                        }
                        return '<p class="m-0"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        let pendiente = d.monto - (d.n_p*d.pago);
                        if(pendiente < 1){
                            pendiente = 0;
                        }else{
                            pendiente = d.monto - (d.n_p*d.pago);
                        }
                        return '<p class="m-0"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>0%</b></center></p>';
                        }
                        else{
                            let impuesto = d.impuesto;
                            return '<p class="m-0"><center><b>'+parseFloat(impuesto)+'%</b></center></p>';
                        

                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                        }
                        else{
                            let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                            let pagar = parseFloat(d.pago) - iva;
                            return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
                        }
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {

                        if (d.estado == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                        } else if (d.estado == 2) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISION</span><center>';
                        } else if (d.estado = 3) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISION</span><center>';
                        }
                    }
                },   
                {
                    "width": "10%",
                    "data": function(d) {
                        let fecha = d.fecha_abono.split('.');
                        return '<p class="m-0"><center>' + fecha[0] + '</center></p>';
                    }
                },
                {
                    "width": "19%",
                    "orderable": false,
                    "data": function(d) {
                        if (d.estado == 1) {
                            return '<button class="btn btn-success btn-round btn-fab btn-fab-mini abonar" value="' + d.id_pago_bono + ',' + d.abono + '"  style="margin-right: 3px;background-color:#20A117;border-color:#20A117;margin:5px;"><i class="material-icons " style="font-size:24px;color:#fff;background:#20A117;"  data-toggle="tooltip" data-placement="right" title="AUTORIZAR">done</i></button>' +
                            '<button class="btn btn-default btn-round btn-fab btn-fab-mini consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+'  "  data-impuesto="'+d.impuesto1+'"  style="margin-right: 3px;background-color:#A1A1A1;border-color:#A1A1A1;margin:5px;"><i class="material-icons" style="font-size:24px;color:#fff;background:#A1A1A1;" data-toggle="tooltip" data-placement="right" title="HISTORIAL">bar_chart</i></button>';
                        }
                    }
                }],
                ajax: {
                    "url": url2 + "Comisiones/getBonosPorUser/" + 1,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {
                    }
                },
            });

            $("#tabla_prestamos tbody").on("click", ".consulta_abonos", function() {
                valores = $(this).val();
                let nuevos = valores.split(',');
                impuesto = $(this).attr("data-impuesto");
                let id= nuevos[0];
                let nombre=nuevos[1];
                $.getJSON(url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
                    $("#modal_bonos .modal-header").html("");
                    $("#modal_bonos .modal-body").html("");
                    $("#modal_bonos .modal-footer").html("");

                    let estatus = '';
                    let color='';

                    if(data[0].estado == 1){
                        estatus=data[0].nombre;
                        color='27AE60';
                    }else if(data[0].estado == 2){
                        estatus=data[0].nombre;
                        color='E3A13C';
                    }else if(data[0].estado == 3){
                        estatus=data[0].nombre;
                        color='07DF9F';
                    }else if(data[0].estado == 4){
                        estatus=data[0].nombre;
                        color='C2A205';
                    }else if(data[0].estado == 5){
                        estatus='CANCELADO';
                        color='red';
                    }
                    
                    let f = data[0].fecha_movimiento.split('.');
                    $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
                    <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
                    <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
                    <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
                    </div>`);

                    $("#modal_bonos .modal-body").append(`<div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #71B85C;">
                            <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
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
                    </div>`);

                    for (let index = 0; index < data.length; index++) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha_movimiento+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');   
                    }
                    
                    $("#modal_bonos").modal();
                });
            });

            /**------------------------------------------- */
            $("#tabla_prestamos tbody").on("click", ".abonar", function() {
                bono = $(this).val();
                var dat = bono.split(",");
                
                $("#modal_abono .modal-body").append(`<div id="inputhidden">
                <h6><em>¿Seguro que deseas autorizar el bono seleccionado de <b style="color:green;">$${formatMoney(dat[1])}</em></b> ?</h6>
                <input type='hidden' name="id_abono" id="id_abono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}">
                <div class="col-md-4"><button type="submit" id="" class="btn btn-primary btn-block">AUTORIZAR</button></div>
                <div class="col-md-4"></div>
                <div class="col-md-4"> <button type="button" onclick="closeModalEng()" class=" btn btn-danger btn-block" data-dismiss="modal">CANCELAR</button></div></div>`);

                $("#modal_abono .modal-body").append(``);
                $('#modal_abono').modal('show');
            });
        });

        /**-------------------------TABLA REVISONES-------------------------------- */
        $("#tabla_bono_revision").ready(function() {
            let titulos = [];

            $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
                if( i!=12){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {

                        if (tabla_nuevas2.column(i).search() !== this.value ) {
                            tabla_nuevas2
                            .column(i)
                            .search(this.value)
                            .draw();

                            var total = 0;
                            var index = tabla_nuevas2.rows({ selected: true, search: 'applied' }).indexes();
                            var data = tabla_nuevas2.rows( index ).data();
                        }
                    });
                }
            });

            tabla_nuevas2 = $("#tabla_bono_revision").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO ';
                                }else if(columnIdx == 2){
                                    return 'ROL ';
                                }else if(columnIdx == 3){
                                    return 'MONTO BONO';
                                }else if(columnIdx == 4){
                                    return 'ABONDADO';
                                }else if(columnIdx == 5){
                                    return 'PENDIENTE';
                                }
                                else if(columnIdx == 6){
                                    return 'NÚMERO PAGO';
                                }else if(columnIdx == 7){
                                    return 'PAGO INDIVIDUAL';
                                }
                                else if(columnIdx == 8){
                                    return 'IMPUESTO';
                                }
                                else if(columnIdx == 9){
                                    return 'TOTAL A PAGAR';
                                }
                                else if(columnIdx == 10){
                                    return 'ESTATUS';
                                }
                                else if(columnIdx == 11){
                                    return 'FECHA';
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
                    "width": "4%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
                    }
                },
                {
                    "width": "16%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.nombre + '</center></p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>$' + formatMoney(d.monto) + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        let abonado = d.n_p*d.pago;
                        if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                            abonado = d.monto;
                        }else{
                            abonado =d.n_p*d.pago;
                        }
                        return '<p class="m-0"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        let pendiente = d.monto - (d.n_p*d.pago);
                        if(pendiente < 1){
                            pendiente = 0;
                        }else{
                            pendiente = d.monto - (d.n_p*d.pago);
                        }
                        return '<p class="m-0"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>0%</b></center></p>';
                        }
                        else{
                            let impuesto = d.impuesto;
                            return '<p class="m-0"><center><b>'+parseFloat(impuesto)+'%</b></center></p>';
                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                        }
                        else{
                            let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                            let pagar = parseFloat(d.pago) - iva;
                            return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
                        }
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        if (d.estado == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                        } else if (d.estado == 2) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISION</span><center>';
                        } else if (d.estado = 3) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISION</span><center>';
                        }
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        let fecha = d.fecha_abono.split('.');
                        return '<p class="m-0"><center>' + fecha[0] + '</center></p>';
                    }
                },
                {
                    "width": "19%",
                    "orderable": false,
                    "data": function(d) {
                        if (d.estado == 2) {
                            return '<button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ '" data-impuesto="'+d.impuesto1+'" title="Historial"><i class="fas fa-info"></i></button>';
                        }
                    }
                }],
                ajax: {
                    url: url2 + "Comisiones/getBonosPorUser/" + 2,
                    type: "POST",
                    cache: false,
                    data: function(d) {
                    }
                },
            });

            $("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function() {
                valores = $(this).val();
                let nuevos = valores.split(',');
                impuesto = $(this).attr("data-impuesto");

                let id= nuevos[0];
                let nombre=nuevos[1];
                $.getJSON(url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {

                    $("#modal_bonos .modal-header").html("");
                    $("#modal_bonos .modal-body").html("");
                    $("#modal_bonos .modal-footer").html("");

                    let estatus = '';
                    let color='';

                    if(data[0].estado == 1){
                        estatus=data[0].nombre;
                        color='27AE60';
                    }else if(data[0].estado == 2){
                        estatus=data[0].nombre;
                        color='E3A13C';
                    }else if(data[0].estado == 3){
                        estatus=data[0].nombre;
                        color='07DF9F';
                    }else if(data[0].estado == 4){
                        estatus=data[0].nombre;
                        color='C2A205';
                    }else if(data[0].estado == 5){
                        estatus='CANCELADO';
                        color='red';
                    }
            
                    let f = data[0].fecha_movimiento.split('.');
                    $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
                    <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
                    <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
                    <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
                    </div>`);

                    $("#modal_bonos .modal-body").append(`<div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #71B85C;">
                            <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
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
                    </div>`);

                    for (let index = 0; index < data.length; index++) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha_movimiento+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');  
                    }

                    $("#modal_bonos").modal();
                });
            });
        });
        /**--------------------- */
        
        /**-----------------TABLA PAGADOS-------------------------------- */
        $("#tabla_bono_pagado").ready(function() {
            let titulos = [];

            $('#tabla_bono_pagado thead tr:eq(0) th').each( function (i) {
                if( i!=12){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if (tabla_nuevas3.column(i).search() !== this.value ) {
                            tabla_nuevas3
                            .column(i)
                            .search(this.value)
                            .draw();

                            var total = 0;
                            var index = tabla_nuevas3.rows({ selected: true, search: 'applied' }).indexes();
                            var data = tabla_nuevas3.rows( index ).data();

                            $.each(data, function(i, v){
                                total += parseFloat(v.impuesto1);
                                console.log(total);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("totalp").textContent = '$'+formatMoney(total);
                            console.log('fsdf'+total);
                        }
                    });
                }
            });
            $('#tabla_bono_pagado').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.impuesto1);
                });
                var to = formatMoney(total);
                document.getElementById("totalp").textContent = '$' +  to;
            });


            tabla_nuevas3 = $("#tabla_bono_pagado").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO ';
                                }else if(columnIdx == 2){
                                    return 'ROL ';
                                }else if(columnIdx == 3){
                                    return 'MONTO BONO';
                                }else if(columnIdx == 4){
                                    return 'ABONDADO';
                                }else if(columnIdx == 5){
                                    return 'PENDIENTE';
                                }
                                else if(columnIdx == 6){
                                    return 'NÚMERO PAGO';
                                }else if(columnIdx == 7){
                                    return 'PAGO INDIVIDUAL';
                                }
                                else if(columnIdx == 8){
                                    return 'IMPUESTO';
                                }
                                else if(columnIdx == 9){
                                    return 'TOTAL A PAGAR';
                                }
                                else if(columnIdx == 10){
                                    return 'ESTATUS';
                                }
                                else if(columnIdx == 11){
                                    return 'FECHA';
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
                    "width": "4%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.nombre + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>$' + formatMoney(d.monto) + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.n_p*d.pago) + '</b></center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + formatMoney(d.pago) + '</center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p style="font-size: .9em !important"><center><b>0%</b></center></p>';
                        }
                        else{
                            let impuesto = d.impuesto;
                            return '<p class="m-0"><center><b>'+parseFloat(impuesto)+'%</b></center></p>';
                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                        }
                        else{
                            let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                            let pagar = parseFloat(d.pago) - iva;
                            return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
                        }
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        if (d.estado == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                        } else if (d.estado == 2) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISIÓN</span><center>';
                        } else if (d.estado == 3) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">PAGADO</span><center>';
                        }
                        else if (d.estado == 4) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">POR PAGAR</span><center>';
                        } else if (d.estado == 5) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">CANCELADO</span><center>';
                        }
                    }
                },
                {
                    "width": "22%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.fecha_abono + '</center></p>';
                    }
                },
                {
                    "width": "6%",
                    "orderable": false,
                    "data": function(d) {
                        if (d.estado == 4) {
                            return '<button class="btn btn-default btn-round btn-fab btn-fab-mini consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-impuesto="'+d.impuesto1+'"  style="margin-right: 3px;background-color:#A1A1A1;border-color:#A1A1A1;margin:5px;"><i class="material-icons" style="font-size:24px;color:#fff;background:#A1A1A1;" data-toggle="tooltip" data-placement="right" title="HISTORIAL">bar_chart</i></button>';
                        }
                    }
                }],
                ajax: {
                    "url": url2 + "Comisiones/getBonosPorUser/" + 4,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {

                    }
                },
            });

            $("#tabla_bono_pagado tbody").on("click", ".consulta_abonosconsulta_abonos", function() {
                valores = $(this).val();
                let nuevos = valores.split(',');
                impuesto = $(this).attr("data-impuesto");

                let id= nuevos[0];
                let nombre=nuevos[1];
                $.getJSON(url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
                    $("#modal_bonos .modal-header").html("");
                    $("#modal_bonos .modal-body").html("");
                    $("#modal_bonos .modal-footer").html("");

                    let estatus = '';
                    let color='';
                    
                    color='F88E24';
                    estatus = 'PAGADO';
                    
                    $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
                    <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
                    <div class="col-md-3"><h6>Fecha: <b>${data[0].fecha_movimiento}</b></h6></div>
                    <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
                    </div>`);

                    $("#modal_bonos").modal();
                });
            });
        });

   
        /**------------------------TABLA PAGADOS-------------------------------- */
        let titulos = [];

        $('#tabla_bono_otros thead tr:eq(0) th').each( function (i) {
                if( i!=12){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {

                        if (tabla_otros.column(i).search() !== this.value ) {
                            tabla_otros
                            .column(i)
                            .search(this.value)
                            .draw();

                            var total = 0;
                            var index = tabla_otros.rows({ selected: true, search: 'applied' }).indexes();
                            var data = tabla_otros.rows( index ).data();
                            
                            $.each(data, function(i, v){
                                total += parseFloat(v.impuesto1);
                                console.log(total);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("totalo").textContent = '$'+formatMoney(total);
                            console.log('fsdf'+total);

                        }
                    } );
                }
            });
        $("#tabla_bono_otros").ready(function() {

            

            $('#tabla_bono_otros').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.impuesto1);
                });
                var to = formatMoney(total);
                document.getElementById("totalo").textContent = '$' +  to;
            });
            tabla_otros = $("#tabla_bono_otros").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO ';
                                }else if(columnIdx == 2){
                                    return 'ROL ';
                                }else if(columnIdx == 3){
                                    return 'MONTO BONO';
                                }else if(columnIdx == 4){
                                    return 'ABONDADO';
                                }else if(columnIdx == 5){
                                    return 'PENDIENTE';
                                }
                                else if(columnIdx == 6){
                                    return 'NÚMERO PAGO';
                                }else if(columnIdx == 7){
                                    return 'PAGO INDIVIDUAL';
                                }
                                else if(columnIdx == 8){
                                    return 'IMPUESTO';
                                }
                                else if(columnIdx == 9){
                                    return 'TOTAL A PAGAR';
                                }
                                else if(columnIdx == 10){
                                    return 'ESTATUS';
                                }
                                else if(columnIdx == 11){
                                    return 'FECHA';
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
                    "width": "4%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.nombre + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center>$' + formatMoney(d.monto) + '</center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.n_p*d.pago) + '</b></center></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>$' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + formatMoney(d.pago) + '</center></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p class="m-0"><center><b>0%</b></center></p>';
                        }
                        else{
                            let impuesto = d.impuesto;
                            return '<p class="m-0"><center><b>'+parseFloat(impuesto)+'%</b></center></p>';
                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                        return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                        }
                        else{
                            let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                            let pagar = parseFloat(d.pago) - iva;
                            return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
                        }
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        if (d.estado == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                        } else if (d.estado == 2) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISIÓN</span><center>';
                        } else if (d.estado == 3) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">PAGADO</span><center>';
                        }
                        else if (d.estado == 4) {
                            return '<center><span class="label label-danger" style="background:#E3A13C">POR PAGAR</span><center>';
                        } else if (d.estado == 5) {
                            return '<center><span class="label label-danger" style="background:RED">CANCELADO</span><center>';
                        }
                    }
                },
                {
                    "width": "22%",
                    "data": function(d) {
                        return '<p class="m-0"><center>' + d.fecha_abono + '</center></p>';
                    }
                },
                {
                    "width": "6%",
                    "orderable": false,
                    "data": function(d) {
                        if (d.estado == 5) {
                            return '<button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ '" data-impuesto="'+d.impuesto1+'" title="Historial"><i class="fas fa-info"></i></button>';
                        }
                    }
                }],
                ajax: {
                    url: url2 + "Comisiones/getBonosPorUser/" + 5,
                    type: "POST",
                    cache: false,
                    data: function(d) {
                    }
                },
            });

            $("#tabla_bono_otros tbody").on("click", ".consulta_abonos", function() {
                valores = $(this).val();
                let nuevos = valores.split(',');
                impuesto = $(this).attr("data-impuesto");

                let id= nuevos[0];
                let nombre=nuevos[1];
                $.getJSON(url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {

                    $("#modal_bonos .modal-header").html("");
                    $("#modal_bonos .modal-body").html("");
                    $("#modal_bonos .modal-footer").html("");

                    let estatus = '';
                    let color='';
                    color='RED';
                    estatus = 'CANCELADO';
            
                    $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
                    <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
                    <div class="col-md-3"><h6>Fecha: <b>${data[0].fecha_movimiento}</b></h6></div>
                    <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
                    </div>`);

                    $("#modal_bonos").modal();
                });
            });
        });

        /**-------------------- */
        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $("#form_abono").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("form_abono"));
            formData.append("dato", "valor");
            $.ajax({
                method: 'POST',
                url: url + 'Comisiones/UpdateRevision',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data == 1) {
                        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                        $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                        
                        tabla_nuevas.ajax.reload();
                        tabla_nuevas2.ajax.reload();
                        closeModalEng();

                        alerts.showNotification("top", "right", "Abono autorizado con exito.", "success");                    
                        document.getElementById("form_abono").reset();

                    } else if (data == 2) {
                        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                        $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                        closeModalEng();
                    
                        alerts.showNotification("top", "right", "Pago liquidado.", "warning");
                
                    } else if (data == 3) {
                        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                        $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                        closeModalEng();

                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    }
                },
                error: function() {
                    closeModalEng();
                    $('#modal_abono').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });
    </script>
</body>