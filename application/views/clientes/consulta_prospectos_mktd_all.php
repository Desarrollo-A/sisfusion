<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <style>
        .label-inf {
            color: #333;
        }

        select:invalid {
            border: 2px dashed red;
        }

        .textoshead::placeholder {
            color: white;
        }

    </style>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-save fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <!--<label for="proyecto">Subdirector:</label>-->
                                            <select name="subDir" id="subDir" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona subdirector" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <!--<label for="proyecto">Gerente:</label>-->
                                            <select name="gerente" id="gerente" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona gerente" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <!--<label for="proyecto">Coordinador:</label>-->
                                            <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona coordinador" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <!--<label for="proyecto">Asesor:</label>-->
                                            <select name="asesor" id="asesor" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona asesor" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <!--<label for="proyecto">Lugar prospección:</label>-->
                                            <select name="lugar_p" id="lugar_p" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="Selecciona lugar prospección" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
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
                                    <table  id="prospects-datatable_dir" name="prospects-datatable_dir"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th class="disabled-sorting text-right"><center>ID</center></th>
                                            <th class="disabled-sorting text-right"><center>NOMBRE</center></th>
                                            <th class="disabled-sorting text-right"><center>APELLIDO PATERNO</center></th>
                                            <th class="disabled-sorting text-right"><center>APELLIDO MATERNO</center></th>
                                            <th class="disabled-sorting text-right"><center>CORREO</center></th>
                                            <th class="disabled-sorting text-right"><center>TEL</center></th>
                                            <th class="disabled-sorting text-right"><center>L.PROSP</center></th>
                                            <th class="disabled-sorting text-right"><center>ASESOR</center></th>
                                            <th class="disabled-sorting text-right"><center>COORD</center></th>
                                            <th class="disabled-sorting text-right"><center>GERENTE</center></th>
                                            <th class="disabled-sorting text-right"><center>SUB</center></th>
                                            <th class="disabled-sorting text-right"><center>CREACIÓN</center></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <?php include 'common_modals.php' ?>
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
                    <div class="block full">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                        <i class="material-icons">list</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <h4 class="card-title">Listado general de prospectos</h4>
                                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                <div class="col-md-4">
                                                    <select name="subDir" id="subDir" class="selectpicker"
                                                            data-style="btn " title="SUBDIRECTOR" data-size="7">
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="gerente" id="gerente" class="selectpicker"
                                                            data-style="btn " title="GERENTE" data-size="7">
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="coordinador" id="coordinador" class="selectpicker"
                                                            data-style="btn " title="Coordinador" data-size="7">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                <div class="col-md-4">
                                                    <select name="asesor" id="asesor" class="selectpicker"
                                                            data-style="btn " title="Asesor" data-size="7">
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="lugar_p" id="lugar_p" class="selectpicker"
                                                            data-style="btn " title="Lugar Prospección" data-size="7">
                                                    </select>
                                                </div>
                                                <div class="col col-xs-4 col-sm-12 col-md-4 col-lg-4">
                                                    <label id="external_filter_container18">Búsqueda por Fecha</label>
                                                    <br>
                                                    <div id="external_filter_container7"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <div class="material-datatables">
                                                    <table id="prospects-datatable_dir" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="disabled-sorting text-right"><center>ID</center></th>
                                                            <th class="disabled-sorting text-right"><center>NOMBRE</center></th>
                                                            <th class="disabled-sorting text-right"><center>APELLIDO PATERNO</center></th>
                                                            <th class="disabled-sorting text-right"><center>APELLIDO MATERNO</center></th>
                                                            <th class="disabled-sorting text-right"><center>CORREO</center></th>
                                                            <th class="disabled-sorting text-right"><center>TEL</center></th>
                                                            <th class="disabled-sorting text-right"><center>L.PROSP</center></th>
                                                            <th class="disabled-sorting text-right"><center>ASESOR</center></th>
                                                            <th class="disabled-sorting text-right"><center>COORD</center></th>
                                                            <th class="disabled-sorting text-right"><center>GERENTE</center></th>
                                                            <th class="disabled-sorting text-right"><center>SUB</center></th>
                                                            <th class="disabled-sorting text-right"><center>CREACIÓN</center></th>
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
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script>

    $('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
                $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $(document).ready(function(){
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


    $("#subDir").empty().selectpicker('refresh');
    $.post('<?=base_url()?>index.php/Clientes/getSubdirs/', function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#subDir").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#subDir").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
        }
        $("#subDir").selectpicker('refresh');
    }, 'json');

    $("#lugar_p").empty().selectpicker('refresh');
    $.post('<?=base_url()?>index.php/Clientes/getProspectingPlaces/', function(data) {
        $("#lugar_p").append('<option value="0">Todos</option>');
        var len = data.length;
        for(var i = 0; i<len; i++){
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#lugar_p").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#lugar_p").append('<option selected="selected" disabled>NINGÚN LUGAR</option>');
        }
        $("#lugar_p").selectpicker('refresh');
    }, 'json');


    $("#gerente").empty().selectpicker('refresh');
    $.post('<?=base_url()?>index.php/Clientes/getGerentesAll/', function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#gerente").append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
        }
        $("#gerente").selectpicker('refresh');
    }, 'json');


    $('#subDir').on('change', function () {
        var subdir = $("#subDir").val();
        $("#gerente").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $.post('<?=base_url()?>index.php/Clientes/getGerentesBySubdir/'+subdir, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#gerente").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#gerente").append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
            }
            $("#gerente").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');

    });



    //////////////


    $('#gerente').on('change', function () {
        var gerente = $("#gerente").val();
        $("#coordinador").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $.post('<?=base_url()?>index.php/Clientes/getCoordsByGrs/'+gerente, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#coordinador").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#coordinador").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
            }
            $("#coordinador").selectpicker('refresh');
        }, 'json');

        var lugar_p = $("#lugar_p").val();
        var subDir = $("#subDir").val();
        $('#spiner-loader').addClass('hide');


        if(lugar_p != '' && gerente != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGteAll/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


    });


    $('#coordinador').on('change', function () {
        var coordinador = $("#coordinador").val();
        $("#asesor").empty().selectpicker('refresh');
        $.post('<?=base_url()?>index.php/Clientes/getAsesorByCoords/'+coordinador, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#asesor").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#asesor").append('<option selected="selected" disabled>NINGÚN ASESOR</option>');
            }
            $("#asesor").selectpicker('refresh');
        }, 'json');

        var gerente = $("#gerente").val();
        var lugar_p = $("#lugar_p").val();
        var subDir = $("#subDir").val();


        if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoordByGte/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


    });



    $('#asesor').on('change', function () {

        var gerente = $("#gerente").val();
        var coordinador = $("#coordinador").val();
        var asesor = $("#asesor").val();
        var lugar_p = $("#lugar_p").val();
        var subDir = $("#subDir").val();


        if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsByCoord/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


    });



    $('#lugar_p').on('change', function () {

        var lugar_p = $("#lugar_p").val();
        var subDir = $("#subDir").val();
        var gerente = $("#gerente").val();
        var coordinador = $("#coordinador").val();
        var asesor = $("#asesor").val();



        if(lugar_p != '' && gerente != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }




    });


    $(document).on("click", "#searchByDateRange", function () {
        /*let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);*/
        var lugar_p = $("#lugar_p").val();
        var subDir = $("#subDir").val();
        var gerente = $("#gerente").val();
        var coordinador = $("#coordinador").val();
        var asesor = $("#asesor").val();
        var url;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();

        if(subDir!='' || gerente != '' && coordinador=='' && asesor=='' && lugar_p==''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByGteAll/"+gerente;
        }else if(subDir=='' && gerente != '' && coordinador=='' && asesor=='' || lugar_p!=''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
        }else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor==''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
        } else if(subDir!='' || gerente != '' && coordinador!='' && asesor=='' && lugar_p==''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoordByGte/"+gerente+"/"+coordinador;
        }else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
        } else if(subDir!='' || gerente != '' && coordinador!='' && asesor!='' && lugar_p==''){
            url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsByCoord/"+gerente+"/"+coordinador+"/"+asesor;
        }


        updateTable(url, 3, finalBeginDate, finalEndDate, 0);



       /* if(lugar_p != '' && gerente != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGteAll/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


        if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoordByGte/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


        if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else {
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsByCoord/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }


        if(lugar_p != '' && gerente != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGte/"+lugar_p+"/"+gerente;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord_v2/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        } else if(lugar_p != '' && subDir != '' && gerente != '' && coordinador != '' && asesor != ''){
            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAs/"+lugar_p+"/"+subDir+"/"+gerente+"/"+coordinador+"/"+asesor;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
        }*/

    });






    function updateTable(url, typeTransaction, beginDate, endDate, where){
        var prospectsTable = $('#prospects-datatable_dir').dataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    title: 'CRM_LISTA_PROSPECTOS',
                    titleAttr: 'CRM_LISTA_PROSPECTOS',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID';
                                        break;
                                    case 1:
                                        return 'NOMBRE';
                                        break;
                                    case 2:
                                        return 'APELLIDO PATERNO';
                                        break;
                                    case 3:
                                        return 'APELLIDO MATERNO';
                                        break;
                                    case 4:
                                        return 'CORREO';
                                        break;
                                    case 5:
                                        return 'TELÉFONO';
                                        break;
                                    case 6:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 7:
                                        return 'ASESOR';
                                        break;
                                    case 8:
                                        return 'COORDINADOR';
                                        break;
                                    case 9:
                                        return 'GERENTE';
                                        break;
                                    case 10:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 11:
                                        return 'FECHA CREACIÓN';
                                        break;
                                }
                            }
                        }
                    },
                }
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [
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
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            ordering: false,
            destroy: true,
            columns: [
                { data: function (d) {
                        return d.id_prospecto;
                    }
                },
                { data: function (d) {
                        return d.nombre;
                    }
                },
                { data: function (d) {
                        return d.apellido_paterno;
                    }
                },
                { data: function (d) {
                        return d.apellido_materno;
                    }
                },
                { data: function (d) {
                        return d.correo;
                    }
                },
                { data: function (d) {
                        return d.telefono;
                    }
                },
                { data: function (d) {
                        return d.lp;
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
                        return d.sub;
                    }
                },
                { data: function (d) {
                        return d.fecha_creacion;
                    }
                }
            ],
            "ajax": {
                "url": url,
                "type": "POST",
                cache: false,
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
                    column_number: 11,
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
