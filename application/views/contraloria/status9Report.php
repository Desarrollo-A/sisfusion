<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
    switch ($this->session->userdata('id_rol')) {
        case '17': // SUBDIRECTOR CONTRALORÍA
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
                                <h3 class="card-title center-align">Reporte estatus 9</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="estatusNueveTable" name="estatusNueveTable"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>REFERENCIA</th>
                                            <th>GERENTE</th>
                                            <th>ENGANCHE</th>
                                            <th>TOTAL</th>
                                            <th>FECHA ESTATUS 9</th>
                                            <th>USUARIO</th>
                                            <th>FECHA APARTADO</th>
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





    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="text-align: center">Reporte estatus 9</h3>
                            <div class="toolbar">
                                <div class="row d-flex align-end">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex">
                                        <div class="container m-0" style="width: 70%">
                                            <div class="row d-flex align-end">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker"
                                                               id="beginDate" value="01/01/2021"/>
                                                        <input type="text" class="form-control datepicker" id="endDate"
                                                               value="01/01/2021"/>
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
                            <div class="material-datatables" id="box-estatusNueveTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="estatusNueveTable" name="estatusNueveTable"
                                               style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th title="PROYECTO" class="encabezado">PROYECTO</th>
                                                <th title="CONDOMINIO">CONDOMINIO</th>
                                                <th title="LOTE">LOTE</th>
                                                <th title="REFERENCIA">REFERENCIA</th>
                                                <th title="GERENTE">GERENTE</th>
                                                <th title="ENGANCHE">ENGANCHE</th>
                                                <th title="TOTAL">TOTAL</th>
                                                <th title="FECHA ESTATUS 9">FECHA ESTATUS 9</th>
                                                <th title="USUARIO">USUARIO</th>
                                                <th title="FECHA APARTADO">FECHA APARTADO</th>
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
</body>
<?php $this->load->view('template/footer');?>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>
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
                2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
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

    $('#estatusNueveTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#103f75; color:white; border: 0; font-weight: 100; font-size: 10px; text-align: center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#estatusNueveTable").DataTable().column(i).search() !== this.value) {
                $("#estatusNueveTable").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    function fillTable(typeTransaction, beginDate, endDate) {
        // let encabezado = (document.querySelector('#estatusNueveTable .encabezado .textoshead').placeholder).toUpperCase();
        generalDataTable = $('#estatusNueveTable').dataTable({
            dom: "Brtip",
            width: "auto",
            select: {
                style: 'single'
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-success buttons-excel',
                    titleAttr: 'Reporte estatus 9',
                    title: 'Reporte estatus 9',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                        break;
                                    case 3:
                                        return 'REFERENCIA ';
                                        break;
                                    case 4:
                                        return 'GERENTE';
                                        break;
                                    case 5:
                                        return 'ENGANCHE';
                                        break;
                                    case 6:
                                        return 'TOTAL';
                                        break;
                                    case 7:
                                        return 'FECHA ESTATUS 9';
                                        break;
                                    case 8:
                                        return 'USUARIO';
                                        break;
                                    case 9:
                                        return 'FECHA APARTADO';
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    text: "<i class='fas fa-sync' aria-hidden='true'></i>",
                    titleAttr: 'Cargar vista inicial',
                    className: 'btn btn-success buttons-excel reset-initial-values',
                }
            ],
            pagingType: "full_numbers",
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
                        return d.nombreResidencial;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreCondominio;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreLote;
                    }
                },
                {
                    data: function (d) {
                        return d.referencia;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreGerente;
                    }
                },
                {
                    data: function (d) {
                        return d.enganche;
                    }
                },
                {
                    data: function (d) {
                        return d.total;
                    }
                },
                {
                    data: function (d) {
                        return d.modificado;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreUsuario;
                    }
                },
                {
                    data: function (d) {
                        return d.fechaApartado;
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
                    "endDate": endDate
                }
            }
        });

    }

    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(2, finalBeginDate, finalEndDate);
    });

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
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        fillTable(1, finalBeginDate, finalEndDate);
    }

    $(document).on("click", ".reset-initial-values", function () {
        setInitialValues();
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        $(".idLote").val('');
        $(".textoshead").val('');
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        // $("#beginDate").val('01/01/2021');
        // $("#endDate").val('01/01/2021');
        fillTable(1, finalBeginDate, finalEndDate);
    });

</script>


