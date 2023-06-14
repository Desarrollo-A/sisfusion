<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    table thead tr th {
        padding: 0px !important;
        color:#fff;
        font-weight: lighter;
        font-size: 0.8em;
    }
    tfoot tr{
        background: #143860;
    }
    table tfoot tr th{
        padding: 0px !important;
        color:#fff;
        font-weight: lighter;
        font-size: 1.3em;
        text-align: center;
    }
</style>
<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <!-- Modals -->
    <div class="modal" tabindex="-1" role="dialog" id="notificacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="p-0 text-center">Tienes que seleccionar al menos un valor para el campo <i><b>Empresa</b></i>.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modals -->

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Reporte por lotes (NeoData)</h3>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty p-0">
                                            <select id="empresas" name="empresas" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona una empresa" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group d-flex p-0">
                                            <select id="proyectos" name="proyectos" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona un proyecto" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group d-flex p-0">
                                            <select id="clientes" name="clientes" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona un cliente" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group p-0">
                                            <button class="btn-gral-data mb-3" id="searchInfo">Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group m-0">
                                            <label class="m-0 check-style">
                                                <input type="checkbox" id="dates" onClick="toggleSelect2()">
                                                <span><i class="fas fa-calendar-alt fa-lg m-1"></i>Filtro por fecha</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <div class="form-group d-flex m-0">
                                            <input type="text" class="form-control datepicker hide"
                                                   id="beginDate" value="01/01/2022"/>
                                            <input type="text" class="form-control datepicker hide" id="endDate"
                                                   value="01/01/2022" style="border-radius: 0 27px 27px 0!important;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive box-table">
                                <table id="tableLotificacionNeodata" name="tableLotificacionNeodata"
                                       class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>CÓDIGO CLIENTE</th>
                                        <th>CUENTA 2170</th>
                                        <th>CUENTA 1150</th>
                                        <th>VIVIENDA</th>
                                        <th>CONTRATO</th>
                                        <th>CLIENTE</th>
                                        <th>SÚPER CONTRATO</th>
                                        <th>PRECIO DE VENTA</th>
                                        <th>FECHA DE CONTRATO</th>
                                        <th>FECHA DE RECONOCIMIENTO</th>
                                        <th>FOLIO FISCAL</th>
                                        <th>INTERMEDIARIO</th>
                                        <th>PAGO A CAPITAL 2170</th>
                                        <th>PAGO A CAPITAL 1150</th>
                                        <th>BONIFICACION</th>
                                        <th>ESCRITURA INDIVIDUIL</th>
                                        <th>FECHA ESCRITURA</th>
                                        <th>SIN INTERESES</th>
                                        <th>CON INTERESES</th>
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
    <?php $this->load->view('template/footer_legend'); ?>
</div>
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
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script>
    let url = "<?=base_url()?>";
    let typeTransaction = 1; // MJ: SELECTS MULTIPLES
</script>

<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script>
    $(document).on('change', "#residenciales", function() {
        getCondominios($(this).val());
    });

    $(document).on('change', "#condominios", function() {
        getLotes($(this).val());
    });

    function toggleSelect2() {
        var isChecked = document.getElementById("dates").checked;
        (isChecked) ? $(".datepicker").removeClass("hide") : $(".datepicker").addClass("hide");
    }

    $(document).ready(function () {
        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        getEmpresasList();
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

    $(document).on('click', '#searchInfo', function () {
            let empresa = $("#empresas").val();
            let idProyecto = $("#proyectos").val();
            let idCliente = $("#clientes").val();
            let dates = 0;
            if (document.getElementById("dates").checked)
                dates = 1
            let fechaIni = $("#beginDate").val();
            let fechaFin = $("#endDate").val();

            if (empresa == undefined || empresa == '')
                $('#notificacion').modal('show');
            else
                fillTableLotificacionNeoData(empresa, idProyecto, idCliente, fechaIni, fechaFin, dates);
        }
    );
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    function fillTableLotificacionNeoData(empresa, idProyecto, idCliente, fechaIni, fechaFin, dates) {
        generalDataTableNeoData = $('#tableLotificacionNeodata').dataTable({
            dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return "CÓDIGO CLIENTE";
                                        break;
                                    case 1:
                                        return "CUENTA 2170";
                                        break;
                                    case 2:
                                        return "CUENTA 1150"
                                    case 3:
                                        return "VIVIENDA";
                                        break;
                                    case 4:
                                        return "CONTRATO";
                                        break;
                                    case 5:
                                        return "CLIENTE";
                                        break;
                                    case 6:
                                        return "SÚPER CONTRATO";
                                        break;
                                    case 7:
                                        return "PRECIO DE VENTA";
                                        break;
                                    case 8:
                                        return "FECHA DE CONTRATO";
                                        break;
                                    case 9:
                                        return "FECHA DE RECONOCIMIENTO";
                                        break;
                                    case 10:
                                        return "FOLIO FISCAL";
                                        break;
                                    case 11:
                                        return "INTERMEDIARIO";
                                        break;
                                    case 12:
                                        return "PAGO A CAPITAL 2170";
                                        break;
                                    case 13:
                                        return "PAGO A CAPITAL 1150";
                                        break;
                                    case 14:
                                        return "BONIFICACIÓN";
                                        break;
                                    case 15:
                                        return "ESCRITURA INDIVIDUAL";
                                        break;
                                    case 16:
                                        return "FECHA ESCRITURA";
                                        break;
                                        case 17:
                                        return "SIN INTERESES";
                                        break;
                                    case 18:
                                        return "CON INTERESES";
                                        break;
                                }
                            },

                        }
                    }
                }
            ],
            scrollX: true,
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
                        return myFunctions.validateEmptyField(d.codcliente);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.Cuenta2170);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.Cuenta1150);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.Vivienda);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.Contrato);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.cliente);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.superficie);
                    }
                },
                {
                    data: function (d) {
                       return '<p>$ '+formatMoney(d.precioventa)+'</p>';
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.fecha_contrato);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.freconocimiento);
                    }
                },
                {
                    data: function (d) {
                        return d.uuid;
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.intermediariocte);
                    }
                },
                {
                    data: function (d) {
                        return '<p>$ '+formatMoney(d.monto2170)+'</p>';
                    }
                },
                {
                    data: function (d) {
                        return '<p>$ '+formatMoney(d.monto1150)+'</p>';
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.montoorden);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.escrituraind);
                    }
                },
                {
                    data: function (d) {
                        return myFunctions.validateEmptyField(d.fescritura);
                    }
                },
                {
                    data: function (d) {
                        return '<p>$ '+formatMoney(d.totcontrato)+'</p>';
                    }
                },
                {
                    data: function (d) {
                        return '<p>$ '+formatMoney(d.totcontratoint)+'</p>';
                    }
                }
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: "getInformationFromNeoData",
                type: "POST",
                cache: false,
                data: {
                    "empresa": empresa,
                    "idProyecto": idProyecto,
                    "idCliente": idCliente,
                    "dates": dates,
                    "fechaIni": fechaIni,
                    "fechaFin": fechaFin
                }
            }
        });
    }

    function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    $(document).on('change', "#empresas", function () {
        getProyectosList($(this).val());
    });

    $(document).on('change', "#proyectos", function () {
        getClientesList($("#empresas").val(), $(this).val());
    });

</script>
</body>