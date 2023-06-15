<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
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
                                <h3 class="card-title center-align">Expedientes rechazados de Jurídico</h3>
                                <p class="card-title pl-1" id="showDate"></p>
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
                                    <table  id="Jtabla"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CLUSTER</th>
                                            <th>LOTE</th>
                                            <th>SEDE</th>
                                            <th>GERENTE</th>
                                            <th>COORDINADOR</th>
                                            <th>ASESOR</th>
                                            <th>USUARIO</th>
                                            <th>APARTADO</th>
                                            <th>COMENTARIO</th>
                                            <th>REALIZADO</th>
                                            <th>VENICIMIENTO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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



    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content" style="padding: 50px 20px;">
                            <h4 class="card-title" id="showDate" style="text-align: center"></h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <div id="external_filter_container18"><B> Filtrar por Fecha </B></div>
                                        <br>
                                        <div id="external_filter_container7"></div>
                                        <br>
                                        <table id="Jtabla" class="table table-bordered table-hover" width="100%"
                                               style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center;">
                                                    Proyecto
                                                </th>
                                                <th>
                                                    <center> Cluster</center>
                                                </th>
                                                <th>
                                                    <center> Lote</center>
                                                </th>
                                                <th>
                                                    <center> Gerente</center>
                                                </th>

                                                <th>
                                                    <center> Coordinador</center>
                                                </th>

                                                <th>
                                                    <center>Asesor</center>
                                                </th>
                                                <th>
                                                    <center>Usuario</center>
                                                </th>
                                                <th>
                                                    <center>Apartado</center>
                                                </th>
                                                <th>
                                                    <center>Comentario</center>
                                                </th>
                                                <th>
                                                    <center> Realizado</center>
                                                </th>
                                                <th>
                                                    <center> Vencimiento</center>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

<script>
    $('#Jtabla thead tr:eq(0) th').each(function (i) {

        // if (i != 0 && i != 9) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#Jtabla').DataTable().column(i).search() !== this.value) {
                $('#Jtabla').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
        // }
    });



    $(document).ready(function () {
        $.ajax(
            {
                post: "POST",
                url: "<?=site_url() . '/registroLote/getDateToday/'?>"
            }).done(function (data) {
            // $('#showDate').append('<center><h3>Expedientes ingresados al día de hoy: '+data+'</h3></center>');
            $('#showDate').append('(al día de hoy: ' + data + ")");
        }).fail(function () {
            // $('#showDate').append('<center><h3>Lotes contratados al: '+new Date().getDay()+new Date().getMonth()+new Date().getFullYear()'</h3></center>');
        });


        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();



    });

    sp = { //  SELECT PICKER
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
        // console.log('Fecha inicio: ', finalBeginDate);
        // console.log('Fecha final: ', finalEndDate);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        fillTable(1, finalBeginDate, finalEndDate, 0);
    }

    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);
    });


    function fillTable(typeTransaction, beginDate, endDate, where) {
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);

        var table = $('#Jtabla').dataTable({
            "ajax":
                {
                    "url": '<?=base_url()?>index.php/contraloria/getRevision7',
                    "dataSrc": "",
                    "type": "POST",
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where
                    }
                },
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy:true,
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-success',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Expedientes rechazados de jurídico',
                    title:'Expedientes rechazados de jurídico',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                    case 1:
                                        return 'CLUSTER';
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SEDE';
                                    case 4:
                                        return 'GERENTE';
                                    case 5:
                                        return 'COORDINADOR';
                                    case 6:
                                        return 'ASESOR';
                                    case 7:
                                        return 'USUARIO';
                                    case 8:
                                        return 'APARTADO';
                                    case 9:
                                        return 'COMENTARIO';
                                    case 10:
                                        return 'REALIZADO';
                                    case 11:
                                        return 'VENCIMIENTO';
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    orientation: 'landscape',
                    pageSize: 'A3',
                    titleAttr: 'Expedientes rechazados de jurídico',
                    title:'Expedientes rechazados de jurídico',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                    case 1:
                                        return 'CLUSTER';
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SEDE';
                                    case 4:
                                        return 'GERENTE';
                                    case 5:
                                        return 'COORDINADOR';
                                    case 6:
                                        return 'ASESOR';
                                    case 7:
                                        return 'USUARIO';
                                    case 8:
                                        return 'APARTADO';
                                    case 9:
                                        return 'COMENTARIO';
                                    case 10:
                                        return 'REALIZADO';
                                    case 11:
                                        return 'VENCIMIENTO';
                                }
                            }
                        }
                    }
                }
            ],
            "columns":
                [
                    {
                        data: 'nombreResidencial'
                    },
                    {
                        data: 'nombreCondominio'
                    },
                    {
                        data: 'nombreLote'
                    },
                    {
                        data: 'nombreSede'
                    },
                    {
                        data: function (data) {
                            return myFunctions.validateEmptyField(data.gerente);

                        }
                    },
                    {
                        data: function (data) {
                            return myFunctions.validateEmptyField(data.coordinador);

                        }
                    },
                    {
                        data: function (data) {
                            return myFunctions.validateEmptyField(data.asesor);

                        }
                    },
                    {
                        data: function (data) {
                            return myFunctions.validateEmptyField(data.nombreUsuario);

                        }
                    },
                    {
                        data: function (data) {
                            return data.fechaApartado;
                        }
                    },
                    {
                        data: function (data) {
                            return data.comentario;
                        }
                    },
                    {
                        data: function (data) {
                            return data.modificado;
                        }
                    },
                    {
                        data: function (data) {
                            return data.fechaVenc;
                        }
                    },
                ]
        })/*.yadcf([
            {
                column_number: 7,
                filter_container_id: 'external_filter_container7',
                filter_type: 'range_date',
                datepicker_type: 'bootstrap-datetimepicker',
                filter_default_label: ['Desde', 'Hasta'],
                date_format: 'YYYY-MM-DD',
                filter_plugin_options: {
                    format: 'YYYY-MM-DD',
                    showClear: true,
                }
            },
        ])*/;
    }




</script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
