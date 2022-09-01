<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper ">
        <?php
        switch ($this->session->userdata('id_rol')) {
            case '19': // SUBDIRECTOR MKTD
            case '28': // EJECUTIVO ADMINISTRATIVO MKTD
            case '50': // GENERALISTA MKTD
            case '63': // CONTROL INTERNO AUDITORIA 
                $datos = array();
                $datos = $datos4;
                $datos = $datos2;
                $datos = $datos3;
                $this->load->view('template/sidebar', $datos);
            break;

            default:
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
            break;
        }
        ?>

        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <div class="row" style="text-align: center">
                            <h3>Consulta en NEODATA</h3>
                        </div>
                    </div>
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <h5>¿Estás segura de hacer este movimiento? </h5>
                            <p style="font-size: 0.8em">Marcarás este lote para solicitar que se disperese la comisión.</p>
                        </div>
                        <input id="idLote" class="hide">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="sendRequestCommissionPayment">Aceptar</button>
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
                                <h3 class="card-title center-align">Master cobranza</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group d-flex">
                                                <input type="number" class="form-control idLote" id="idLote"
                                                    placeholder="ID lote"/>
                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                        id="searchByLote">
                                                    <span class="material-icons">search</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker"
                                                                id="beginDate" value="01/01/2022"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"
                                                                value="01/01/2022"/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                                    id="searchByDateRange">
                                                                <span class="material-icons update-dataTable">search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="masterCobranzaTable" name="masterCobranzaTable">
                                                <thead>
                                                <tr>
                                                    <th title="ID LOTE" class="encabezado">ID LOTE</th>
                                                    <th title="NOMBRE">NOMBRE</th>
                                                    <th title="MONTO TOTAL">MONTO TOTAL</th>
                                                    <th title="FECHA APARTADO">FECHA APARTADO</th>
                                                    <th title="PLAZA">PLAZA</th>
                                                    <th title="SOLICITUD PAGO">SOLICITUD PAGO</th>
                                                    <th title="ESTATUS EVIDENCIA">ESTATUS EVIDENCIA</th>
                                                    <th title="ESTATUS CONTRATACIÓN">ESTATUS CONTRATACIÓN</th>
                                                    <th title="ESTATUS VENTA">ESTATUS VENTA</th>
                                                    <th title="ESTATUS COMISIÓN">ESTATUS COMISIÓN</th>
                                                    <th title="TOTAL COMISIÓN">TOTAL COMISIÓN</th>
                                                    <th title="TOTAL ABONADO">TOTAL ABONADO</th>
                                                    <th title="TOTAL PAGADO">TOTAL PAGADO</th>
                                                    <th title="LUGAR PROSPECCIÓN">LUGAR PROSPECCIÓN</th>
                                                    <th title="FECHA PROSPECCIÓN">FECHA PROSPECCIÓN</th>
                                                    <th></th>
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
    </div><!--main-panel close-->

    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <!-- Sliders Plugin -->
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <!--  Full Calendar Plugin    -->
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

    <script>
        var url = "<?=base_url()?>";
        $(document).ready(function () {
            sp.initFormExtendedDatetimepickers();
            $('.datepicker').datetimepicker({locale: 'es'});
            /*
            fillTable(typeTransaction, beginDate, endDate, where) PARAMS;
                typeTransaction:
                    1 = ES LA PRIMERA VEZ QUE SE LLENA LA TABLA O NO SE SELECCIONÓ UN RANGO DE FECHA (MUESTRA LO DEL AÑO ACTUAL)
                    2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL ID DE LOTE INGRESADO)
                    3 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
                beginDate
                    FECHA INICIO
                endDate
                    FECHA FIN
                where
                    ID LOTE (WHEN typeTransaction VALUE IS 2 WE SEND ID LOTE VALUE)
            */

            setInitialValues();
        });

        sp = { // MJ: SELECT PICKER
            initFormExtendedDatetimepickers: function () {
                $('.datepicker').datetimepicker({
                    format: 'MM/DD/YYYY',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down",
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove',
                        inline: true
                    }
                });
            }
        }

        $('#masterCobranzaTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            if ( i != 14 ){
                $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if ($("#masterCobranzaTable").DataTable().column(i).search() !== this.value) {
                        $("#masterCobranzaTable").DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        function fillTable(typeTransaction, beginDate, endDate, where) {
            let encabezado = (document.querySelector('#masterCobranzaTable .encabezado .textoshead').placeholder).toUpperCase();
            generalDataTable = $('#masterCobranzaTable').dataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return encabezado;
                                            break;
                                        case 1:
                                            return 'NOMBRE';
                                            break;
                                        case 2:
                                            return 'MONTO TOTAL'
                                        case 3:
                                            return 'FECHA APARTADO';
                                            break;
                                        case 4:
                                            return 'PLAZA';
                                            break;
                                        case 5:
                                            return 'SOLICITUD PAGO';
                                            break;
                                        case 6:
                                            return 'ESTATUS EVIDENCIA';
                                            break;
                                        case 7:
                                            return 'ESTATUS CONTRATACIÓN';
                                            break;
                                        case 8:
                                            return 'ESTATUS CONTRATACIÓN';
                                            break;
                                        case 9:
                                            return 'ESTATUS COMISIÓN';
                                            break;
                                        case 10:
                                            return 'TOTAL COMISIÓN';
                                            break;
                                        case 11:
                                            return 'TOTAL DISPERSADO';
                                            break;
                                        case 12:
                                            return 'TOTAL PAGADO';
                                            break;
                                        case 13:
                                            return 'LUGAR PROSPECCIÓN';
                                            break;
                                        case 14:
                                            return 'FECHA PROSPECCIÓN';
                                            break;
                                    }
                                }
                            }
                        }
                    },
                    {
                        text: "<i class='fa fa-refresh' aria-hidden='true'></i>",
                        titleAttr: 'Cargar vista inicial',
                        className: "btn btn-azure reset-initial-values",
                    }
                ],
                pagingType: "full_numbers",
                fixedHeader: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
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
                        data: function (d) {
                            return d.idLote;
                        }
                    },
                    {
                        data: function (d) {
                            return d.nombreLote;
                        }
                    },
                    {
                        data: function (d) {
                            if(d.rec == 8){
                                return '-';
                            }else{
                                if(d.precioTotalLote == '$0.00')
                                    return '<span style="color: #960034">' + d.total_sindesc + '</span>'
                                else
                                    return '<span style="font-weight: 700">'+d.precioTotalLote+'</span>';
                            }
                        }
                    },
                    {
                        data: function (d) {
                            if(d.rec == 8){
                            return '-';
                            }else{
                            return d.fechaApartado;
                        }
                        }
                    },
                    {
                        data: function (d) {
                            if(d.rec == 8){
                            return '-';
                            }else{
                            return d.plaza;
                        }
                        }
                    },
                    {
                        data: function (d) {
                            var labelStatus;

                            if(d.rec == 8){
                                    labelStatus = 'VENTA CANCELADA';
                            }else{

                            switch (d.registroComision) {
                                case 2:
                                case '2':
                                    labelStatus = '<span class="label" style="background:#2ECC71;">SOLICITUD ENVIADA</span>';
                                    break;
                                case 3:
                                default:
                                    labelStatus = '<span class="label" style="background:#808B96;">SIN SOLICITAR</span>';
                                    break;
                            }
                        }
                            return labelStatus;
                        }
                    },
                    {
                        data: function (d) {
                            var labelStatus;
                            if(d.rec == 8){
                                labelStatus = '<span class="label" style="background:red;">RECISIÓN DE CONTRATO</span>';
                            }else{
                            switch (d.estatusEvidencia) {
                                case 1:
                                case '1':
                                    labelStatus = '<span class="label" style="background:#3498DB;">ENVIADA A COBRANZA</span>';
                                    break;
                                case 10:
                                case '10':
                                    labelStatus = '<span class="label" style="background:#CD6155;">COBRANZA RECHAZÓ LA EVIDENCIA AL GERENTE</span>';
                                    break;
                                case 2:
                                case '2':
                                    labelStatus = '<span class="label" style="background:#27AE60;">ENVIADA A CONTRALORÍA</span>';
                                    break;
                                case 20:
                                case '20':
                                    labelStatus = '<span class="label" style="background:#E67E22;">CONTRALORÍA RECHAZÓ LA EVIDENCIA</span>';
                                    break;
                                case 3:
                                case '3':
                                    labelStatus = '<span class="label" style="background:#9B59B6;">EVIDENCIA ACEPTADA</span>';
                                    break;
                                default:
                                    labelStatus = '<span class="label" style="background:#808B96;">NO SE HA INTEGRADO EVIDENCIA</span>';
                                    break;
                            }
                            }
                            return labelStatus;
                        }
                    },
                    {
                        data: function (d) {
                            return d.idStatusContratacion;
                        }
                    },
                    {
                        data: function (d) {
                            var labelStatus;

                            if(d.rec == 8){
                                    labelStatus = 'VENTA CANCELADA';
                            }else{

                            switch (d.idStatusLote) {
                                case 1:
                                case '1':
                                    labelStatus = '<span class="label" style="background:#17A589;">DISPONIBLE</span>';
                                    break;
                                case 2:
                                case '2':
                                    labelStatus = '<span class="label" style="background:#2471A3;">CONTRATADO</span>';
                                    break;
                                case 3:
                                case '3':
                                    labelStatus = '<span class="label" style="background:#F39C12;">APARTADO</span>';
                                    break;
                                default:
                                    labelStatus = '<span class="label" style="background:#808B96;">SIN ESTATUS REGISTRADO</span>';
                                    break;
                            }
                        }
                            return labelStatus;
                        }
                    },
                    {
                        data: function (d) {
                            var labelStatus;
                            if(d.rec == 8){
                                    labelStatus = '<span class="label" style="background:#3498DB;">RECISIÓN DE CONTRATO</span>';
                            }else{

                            switch (d.registroComision) {
                                case 0:
                                case '0':
                                case 2:
                                case '2':
                                    labelStatus = '<span class="label" style="background:#27AE60;">SIN DISPERSAR</span>';
                                    break;
                                case 7:
                                case '7':
                                    labelStatus = '<span class="label" style="background:#CD6155;">LIQUIDADA</span>';
                                    break;
                                case 8:
                                case '8':
                                case 88:
                                case '88':
                                    labelStatus = '<span class="label" style="background:#3498DB;">RECISIÓN DE CONTRATO</span>';
                                    break;
                                case 1:
                                case '1':
                                default:
                                    labelStatus = '<span class="label" style="background:#AE2798FF;">ACTIVA</span>';
                                    break;
                            }
                        }
                            return labelStatus;
                        }
                    },
                    {
                        data: function (d) {
                            return d.comisionTotal;
                        }
                    },
                    {
                        data: function (d) {
                            return d.abonoDispersado;
                        }
                    },
                    {
                        data: function (d) {
                            return d.abonoPagado;
                        }
                    },
                    {
                        data: function (d) {
                            if (d.descuento_mdb == 1) 
                                return d.lugar_prospeccion + ' Martha Debayle';
                            else
                                return d.lugar_prospeccion;
                        }
                    },
                    {
                        data: function (d) {
                            return d.fecha_prospeccion;
                        }
                    },
                    {
                        data: function (d) {
                            let btns = '';

                            if(d.rec == 8){
                                btns = '';
                                    // labelStatus = '<span class="label" style="background:#3498DB;">RECISIÓN DE CONTRATO</span>';
                            }else{

                            btns = '<button class="btn-data btn-blueMaderas" data-idLote="' + d.idLote + '" data-registroComision="' + d.registroComision + '" id="verifyNeodataStatus" title="Ver más"></body><i class="fas fa-info"></i></button>';
                            if (d.estatusEvidencia == 3 && (d.registroComision == 0 /*|| d.registroComision == 8*/) && (d.idStatusContratacion == 11 || d.idStatusContratacion == 15))
                                btns += '<button class="btn-data btn-green" data-idLote="' + d.idLote + '" id="requestCommissionPayment" title="Solicitar pago"><i class="fas fa-money-bill-wave"></i></button>';

                        }
                            return '<div class="d-flex">'+btns+'</div>';
                        }
                    }
                ],
                columnDefs: [{
                    visible: false,
                    searchable: false
                }],
                ajax: {
                    url: 'getInformation',
                    type: "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where
                    }
                }
            });

            $("#masterCobranzaTable tbody").on("click", "#verifyNeodataStatus", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let tr = $(this).closest('tr');
                let row = $("#masterCobranzaTable").DataTable().row(tr);
                let idLote = $(this).attr("data-idLote");
                let registro_status = $(this).attr("data-registroComision");
                let cadena = '';

                $("#modal_NEODATA .modal-body").html("");
                $("#modal_NEODATA .modal-footer").html("");

                $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {
                    if (data.length > 0) {
                        switch (data[0].Marca) {
                            case 0:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            case 1:
                                if (registro_status == 0 || registro_status == 8) { //COMISION NUEVA
                                    let total0 = parseFloat(data[0].Aplicado);
                                    let total = 0;
                                    if (total0 > 0) {
                                        total = total0;
                                    } else {
                                        total = 0;
                                    }
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4>Monto registrado: <b>$' + formatMoney(data[0].Aplicado) + '</b></h4></div></div>');
                                    if (parseFloat(data[0].Bonificado) > 0) {
                                        cadena = '<h4>Bonificación: <b style="color:#D84B16;">$' + formatMoney(data[0].Bonificado) + '</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="${parseFloat(data[0].Bonificado)}">`);
                                    } else {
                                        cadena = '<h4>Bonificación: <b>$' + formatMoney(0) + '</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="0">`);
                                    }
                                } else if (registro_status == 1) {
                                    $.getJSON(url + "Comisiones/getDatosAbonadoSuma11/" + idLote).done(function (data1) {
                                        let total0 = parseFloat((data[0].Aplicado));
                                        let total = 0;
                                        if (total0 > 0) {
                                            total = total0;
                                        } else {
                                            total = 0;
                                        }
                                        var counts = 0;
                                        if (parseFloat(data[0].Bonificado) > 0) {
                                            cadena = '<h4>Bonificación: <b style="color:#D84B16;">$' + formatMoney(data[0].Bonificado) + '</b></h4>';
                                        } else {
                                            cadena = '<h4>Bonificación: <b >$' + formatMoney(0) + '</b></h4>';
                                        }
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-6" style="text-align: center;"><h4>Monto registrado: <b>$' + formatMoney(data[0].Aplicado) + '</b></h4></div><div class="col-md-6">' + cadena + '</div></div>');
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para dispersar de <i>' + row.data().nombreLote + '</i>: <b>$' + formatMoney(total0 - (data1[0].abonado)) + '</b></h3></div></div><br>');
                                    });
                                }
                                break;
                            case 2:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            case 3:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No tiene vivienda, sí hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            case 4:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            case 5:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            default:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                        }
                    } else {
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    }
                });
                $("#modal_NEODATA").modal();
            });
        }

        $(document).on("click", "#searchByLote", function () {
            let idLote = $("#idLote").val();
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            fillTable(2, finalBeginDate, finalEndDate, idLote);
        });

        $(document).on("click", "#searchByDateRange", function () {
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            fillTable(3, finalBeginDate, finalEndDate, 0);
        });

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        }

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
            finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
            fillTable(1, finalBeginDate, finalEndDate, 0);
        }

        $(document).on("click", ".reset-initial-values", function () {
            setInitialValues();
            $(".idLote").val('');
            $(".textoshead").val('');
            $("#beginDate").val('01/01/2022');
            $("#endDate").val('01/01/2022');
        });

        $(document).on('click', '#requestCommissionPayment', function () {
            let idLote = $(this).attr("data-idLote");
            $("#idLote").val(idLote);
            $("#modalConfirmRequest").modal();
        });

        $(document).on('click', '#sendRequestCommissionPayment', function () {
            let idLote = $("#idLote").val();
            $.ajax({
                type: 'POST',
                url: 'sendRequestPayment',
                data: {
                    'idLote': idLote
                },
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        $("#modalConfirmRequest").modal("hide");
                        alerts.showNotification("top", "right", "El registro ha sido actualizado de manera éxitosa.", "success");
                        $("#masterCobranzaTable").DataTable().ajax.reload();
                    } else {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                    }
                }, error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });
    </script>
</body>