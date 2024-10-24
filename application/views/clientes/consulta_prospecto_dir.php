<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Subdirector</label>
                                            <select name="subDir" id="subDir"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona subdirector" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Gerente</label>
                                            <select name="gerente" id="gerente"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona gerente" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Coordinador</label>
                                            <select name="coordinador" id="coordinador"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona coordiniador" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Asesor</label>
                                            <select name="asesores" id="asesores"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona asesor" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 hide" id="filter_date">
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
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="prospects-datatable_dir"
                                               class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                                <tr>
                                                    <th>ESTADO</th>
                                                    <th>ETAPA</th>
                                                    <th>TIPO</th>
                                                    <th>PROSPECTO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>LUGAR DE PROSPECCIÓN</th>
                                                    <th>CREACIÓN</th>
                                                    <th>VENCIMIENTO</th>
                                                    <th>CORREO</th>
                                                    <th>TELÉFONO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <?php include 'common_modals.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>

<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    typeTransaction = 1;
    let titulos = [];

    $('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        const title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
                $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
            }
        });
    });

</script>
<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>



<script>
    $(document).ready(function () {
        /*primera carga*/



        $("#subDir").empty().selectpicker('refresh');
        $.post('<?=base_url()?>index.php/Clientes/getSubdirs/', function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#subDir").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#subDir").append('<option selected="selected" disabled>NINGUN SUBDIRECTOR</option>');
            }
            $("#subDir").selectpicker('refresh');
        }, 'json');


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
        // fillTable(1, finalBeginDate, finalEndDate, 0);
    }

    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        var url_inter;
        console.log(gerente);
        console.log(coordinador);
        console.log(asesor);

        if(gerente != undefined && coordinador==undefined && asesor==undefined){
            url_inter = "<?=base_url()?>index.php/Clientes/getProspectsListByGerente/"+gerente;
            console.log('Sólo tiene gerente');
        }else if(gerente != undefined && coordinador!=undefined && asesor==undefined){
            url_inter = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+coordinador;
            console.log('Tiene Gerente y coordinador');
        }else if(gerente != undefined && coordinador!=undefined && asesor!=undefined){
            url_inter = "<?=base_url()?>index.php/Clientes/getProspectsListByAsesor/"+asesor;
            console.log('Tiene Gerente, coordinador y asesor');
        }
        updateTable(url_inter, 3, finalBeginDate, finalEndDate, 0);
    });

    $('#subDir').on('change', function () {
        var subdir = $("#subDir").val();
        console.log('Elegiste: ' + subdir);

        //gerente

        $("#gerente").empty().selectpicker('refresh');
        $("#coordinador").empty().selectpicker('refresh');
        $("#asesores").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $('#filter_date').addClass('hide');
        $.post('<?=base_url()?>index.php/Clientes/getGerentesBySubdir/'+subdir, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#gerente").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
            }
            $("#gerente").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });

    var gerente;
    var coordinador;
    var asesor;
    $('#gerente').on('change', function () {
        $('#filter_date').removeClass('hide');
        /**/gerente = $("#gerente").val();
        console.log('Elegiste: ' + gerente);

        $("#coordinador").empty().selectpicker('refresh');
        $("#asesores").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $.post('<?=base_url()?>index.php/Clientes/getCoordsByGrs/'+gerente, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#coordinador").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#coordinador").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
            }
            $("#coordinador").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');

        }, 'json');



        /**///carga tabla
        var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGerente/"+gerente;
        console.log("TypeTRans: " + typeTransaction);
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    });

    $('#coordinador').on('change', function () {
        coordinador = $("#coordinador").val();
        console.log('Elegiste: ' + coordinador);
        $('#filter_date').removeClass('hide');

        //gerente
        $("#asesores").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $.post('<?=base_url()?>index.php/Clientes/getAsesorByCoords/'+coordinador, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#asesores").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#asesores").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
            }
            $("#asesores").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');

        }, 'json');


        /**///carga tabla
        var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+coordinador;
        console.log("TypeTRans: " + typeTransaction);
        // updateTable(url, typeTransaction);
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    });

    //asesor
    $('#asesores').on('change', function () {
        asesor = $("#asesores").val();
        console.log('Elegiste: ' + asesor);

        /**///carga tabla
        var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsesor/"+asesor;
        console.log("TypeTRans: " + typeTransaction);
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0);
    });



    var prospectsTable;
    function updateTable(url, typeTransaction, beginDate, endDate, where)
    {
        console.log('url: ', url);
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);
        prospectsTable = $('#prospects-datatable_dir').dataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "ordering": false,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Listado general de prospectos',
                    title:"Listado general de prospectos",
                    exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                },
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            pagingType: "full_numbers",
            language: {
                url: `${general_base_url}/static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            columns: [
                { data: function (d) {
                        if (d.estatus == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                        } else {
                            return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                        }
                    }
                },
                { data: function (d) {
                        if(d.estatus_particular == 1) { // DESCARTADO
                            b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                        } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                            b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                        } else if (d.estatus_particular == 3){ // CON CITA
                            b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                        } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                            b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                        } else if (d.estatus_particular == 5){ // PAUSADO
                            b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                        } else if (d.estatus_particular == 6){ // PREVENTA
                            b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                        }
                        return b;
                    }
                },
                {   data: function (d) {
                        if (d.tipo == 0){
                            return '<center><span class="label label-danger" style="background: #B7950B">Prospecto</span></center>';
                        } else {
                            return '<center><span class="label label-danger" style="background: #75DF8F">Cliente</span></center>';
                        }
                    }
                },
                { data: function (d) {
                        return d.nombre;
                    }
                },
                { data: function (d) {
                        return d.asesor;
                    }
                },
                { data: function (d) {
                        return d.coordinador;
                    }
                },
                { data: function (d) {
                        return d.gerente;
                    }
                },
                { data: function (d) {
                        return d.nombre_lp;
                    }
                },
                { data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { data: function (d) {
                        return d.fecha_vencimiento;
                    }
                },
                { data: function (d) {
                        return d.correo;
                    }
                },
                { data: function (d) {
                        return d.telefono;
                    }
                }
            ],
            "ajax": {
                "url": url,
                "dataSrc": "",
                cache: false,
                "type": "POST",
                data: {
                      "typeTransaction": typeTransaction,
                      "beginDate": beginDate,
                      "endDate": endDate,
                      "where": where
                }
            }
        })/*.yadcf(
            [
                {
                    column_number: 6,
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
            ]
        )*/
    }



</script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
