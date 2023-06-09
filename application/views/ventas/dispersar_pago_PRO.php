<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper">
        <?php
        if ($this->session->userdata('id_rol') == "13" || $this->session->userdata('id_rol') == "17" || $this->session->userdata('id_rol') == "32" || $this->session->userdata('id_rol') == "8") //
        {
            $this->load->view('template/sidebar');
        }
        else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>

        <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }

            #modal_vc{
                z-index: 1041!important;
            }
        </style>

        <!-- Modals -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reporte dispersion</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="fecha1" id="fecha1" class="form-control">
                            </div>
                            <div class="col-md-6" id="f2">
                                <input type="date" name="fecha2" id="fecha2" class="form-control"> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                    <div class="modal-header">
                        <button type="button"class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Modificar estatus</b></h4>
                    </div>
                        <div class="modal-body" style="text-align: center;">
                        </div>
                        <div class="modal-footer">
                        <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas"
             id="detenciones-modal"
             role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <form method="post"
                          class="row"
                          id="detenidos-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden"
                                   name="id_pagoc"
                                   id="id-lote-detenido">
                                   <input type="hidden"
                                   name="statusLote"
                                   id="statusLote">

                            <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <label for="motivo" class="control-label label-gral">Motivo</label>
                                    <input id="motivo"
                                           name="motivo"
                                           type="text"
                                           class="form-control input-gral"
                                           placeholder="Escriba un motivo corto..."
                                           minlength="3"
                                           maxlength="50"
                                           required />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group label-floating">
                                    <textarea class="form-control"
                                              name="descripcion"
                                              rows="3"
                                              placeholder="Escriba la descripción de la controversia..."
                                              required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modals -->
        <div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_pagadas">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal verifyNEODATA -->
        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal verifyNEODATA -->
        <div class="modal fade modal-alertas" id="modal_NEODATA2" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_NEODATA2">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detalle-plan-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title" id="title-plan"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" id="planes-div">
                                <div class="form-group">
                                    <select class="selectpicker select-gral"
                                            id="planes"
                                            name="planes"
                                            data-style="btn"
                                            required>
                                    </select>
                                </div>
                            </div>
                            <div id="detalle-tabla-div"
                                 class="col-lg-12">
                                <table class="table table-bordered"
                                       id="plan-detalle-tabla">
                                    <thead>
                                        <tr>
                                            <th scope="col">PUESTO</th>
                                            <th scope="col">COMISIÓN</th>
                                            <th scope="col">NEODATA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="plan-detalle-tabla-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Dispersión de pago</h3>
                                    <p class="card-title pl-1">Lotes nuevos sin dispersar, con saldo disponible en neodata y recesiones con la nueva venta.</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row aligned-row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Monto hoy: </h4>
                                                    <p class="category input-tot pl-1" id="monto_label">
                                                        <?php $query = $this->db->query("SELECT SUM(monto) nuevo_general FROM (SELECT SUM(pci.abono_neodata) monto FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");

                                                        foreach ($query->result() as $row){
                                                            $number = $row->nuevo_general;
                                                            echo '<B>$'.number_format($number, 3),'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Pagos hoy: </h4>
                                                    <p class="category input-tot pl-1" id="pagos_label">
                                                     
                                                        <?php $query = $this->db->query("SELECT SUM(pagos) nuevo_general FROM (SELECT  count(id_pago_i) pagos FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");
                                                        foreach ($query->result() as $row){
                                                            $number = $row->nuevo_general;
                                                            echo '<B>'.$number,'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Lotes hoy: </h4>
                                                    <p class="category input-tot pl-1" id="lotes_label">
                                                    
                                                    <?php $query = $this->db->query("SELECT SUM(lotes) nuevo_general FROM (SELECT  COUNT(DISTINCT(id_lote)) lotes FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");

                                                        foreach ($query->result() as $row) {
                                                            $number = $row->nuevo_general;
                                                            echo '<B>'.$number,'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end text-center">
                                                <a data-target="#myModal" data-toggle="modal" class="btn-gral-data" id="MainNavHelp" href="#myModal" style="color:white"> Reporte dispersión</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end text-center">
                                                <button class="btn-gral-data"
                                                   id="btn-detalle-plan"
                                                   style="color:white; ">
                                                    Planes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>CONTRATACIÓN</th>
                                                        <th>PLAN VENTA</th>
                                                        <th>F. NEODATA</th>
                                                        <th>MÁS</th>
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
    <?php $this->load->view('template/footer_legend');?>
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
    <script>

    $(document).on('click', '.update_bandera', function(e){
        id_pagoc = $(this).attr("data-idpagoc");
            nombreLote = $(this).attr("data-nombreLote");
            param = $(this).attr("data-param");

            $("#myUpdateBanderaModal .modal-body").html('');

            $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param"><h4 class="modal-title">¿Está seguro de regresar el lote <b>'+nombreLote+'</b> a comisiones por dispersar?</h4><center><img src="../static/images/backaw2.gif" width="100" height="100"></center>');

            $("#myUpdateBanderaModal").modal();
        $("#id_pagoc").val(id_pagoc);
        $("#param").val(1);
    });

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";

    var getInfo1 = new Array(6);
    var getInfo3 = new Array(6);

    function showDetailModal(idPlan) {
        $('#planes-div').hide();
        $.ajax({
            url: `${url}Comisiones/findPlanDetailById/${idPlan}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#plan-detalle-tabla-tbody').empty();
                $('#title-plan').text(`Plan: ${data.descripcion}`);
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();

                const roles = data.comisiones;
                roles.forEach(rol => {
                    if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                        $('#plan-detalle-tabla tbody').append('<tr>');
                        $('#plan-detalle-tabla tbody').append(`<td>${rol.puesto}</td>`);
                        $('#plan-detalle-tabla tbody').append(`<td>${convertirPorcentajes(rol.com)} %</td>`);
                        $('#plan-detalle-tabla tbody').append(`<td>${convertirPorcentajes(rol.neo)} %</td>`);
                        $('#plan-detalle-tabla tbody').append('</tr>');
                    }
                });
                $('#detalle-tabla-div').show();
            }
        });
    }

    $('#btn-detalle-plan').on('click', function () {
        $('#planes-div').show();
        $('#planes').empty().selectpicker('refresh');

        $('#planes').append($('<option>').val(0).text('SELECCIONA UNA OPCIÓN')).selectpicker('refresh');

        $.ajax({
            url: `${url}Comisiones/findAllPlanes`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    const id = data[i].id_plan;
                    const name = data[i].descripcion.toUpperCase();
                    $('#planes').append($('<option>').val(id).text(name));
                }

                $('#title-plan').text('Planes de comisión');
                $('#planes').selectpicker('refresh');
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();
            }
        });
    });

    $('#planes').change(function () {
        const idPlan = $(this).val();
        if (idPlan !== '0') {
            $.ajax({
                url: `${url}Comisiones/findPlanDetailById/${idPlan}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#plan-detalle-tabla-tbody').empty();
                    const roles = data.comisiones;
                    roles.forEach(rol => {
                        if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                            $('#plan-detalle-tabla tbody').append('<tr>');
                            $('#plan-detalle-tabla tbody').append(`<td>${rol.puesto}</td>`);
                            $('#plan-detalle-tabla tbody').append(`<td>${convertirPorcentajes(rol.com)} %</td>`);
                            $('#plan-detalle-tabla tbody').append(`<td>${convertirPorcentajes(rol.neo)} %</td>`);
                            $('#plan-detalle-tabla tbody').append('</tr>');
                        }
                    });
                    $('#detalle-tabla-div').show();
                }
            });
        } else {
            $('#detalle-tabla-div').hide();
        }
    });

    $("#tabla_ingresar_9").ready( function(){
        let titulos = [];
        $('#tabla_ingresar_9 thead tr:eq(0) th').each( function (i) {
            if(i != 0 && i != 12){
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (tabla_1.column(i).search() !== this.value ) {
                        tabla_1
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });

        tabla_1 = $("#tabla_ingresar_9").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'REPORTE COMISIONES POR DISPERSAR',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format: {
                        header:  function (d, columnIdx) {
                            if(columnIdx == 0){
                                return ' '+d +' ';
                            }else if(columnIdx == 11){
                                return ' '+d +' ';
                            }else if(columnIdx != 11 && columnIdx !=0){
                                if(columnIdx == 12){
                                    return 'TIPO'
                                }else{
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
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
                "width": "2%",
                "className": 'details-control',
                "orderable": false,
                "data" : null,
                "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                "width": "5%",
                "data": function( d ){
                    var lblStats;
                    lblStats ='<p class="m-0"><b>'+d.idLote+'</b></p>';
                    return lblStats;
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreResidencial+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                }
            },
            {
                "width": "12%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            }, 
            {
                "width": "12%",
                "data": function( d ){
                    return '<p class="m-0"><b>'+d.nombre_cliente+'</b></p>';
                }
            }, 
            {
                "width": "7%",
                "data": function( d ){
                    var lblType;
                    if(d.tipo_venta==1) {
                        lblType ='<span class="label label-danger">Venta Particular</span>';
                    }else if(d.tipo_venta==2) {
                        lblType ='<span class="label label-success">Venta normal</span>';
                    }else if(d.tipo_venta==7) {
                        lblType ='<span class="label label-warning">Venta especial</span>';
                    }else{
                        lblType ='<span class="label label-danger">SIN TIPO DE VENTA</span>';
                    }
                    return lblType;
                }
            }, 
            {
                "width": "7%",
                "data": function( d ){
                    var lblStats;
                    if(d.compartida==null) {
                        lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
                    }else {
                        lblStats ='<span class="label label-warning">Compartida</span>';
                    }
                    return lblStats;
                }
            }, 
            {
                "width": "7%",
                "data": function( d ){
                    var lblStats;
                    if(d.idStatusContratacion==15) {
                        lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';
                    }else {
                        lblStats ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
                    }
                    return lblStats;
                }
            },
   
            {
                "width": "8%",
                "data": function( d ){
                    var lblStats;
                    if(d.totalNeto2==null) {
                        lblStats ='<span class="label label-danger">Sin precio lote</span>';
                    } else if(d.registro_comision == 2){
                        lblStats ='<span class="label" style="background:#11DFC6;">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
                    }else{
                        lblStats = `<span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
                    }
                    return lblStats;
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    var lblStats;

                    if(d.fecha_modificacion <= '2021-01-01' || d.fecha_modificacion == null ) {
                        lblStats ='';
                    }else if (d.registro_comision == 8){
                        lblStats ='<span class="label label-gray" style="color:gray;">Recisión Nueva Venta</span>';
                    }
                    else {
                        lblStats ='<span class="label label-info">'+d.date_final+'</span>';
                    }
                    return lblStats;
                }
            },
            {
                "width": "8%",
                "orderable": false,
                "data": function( data ){
                    var BtnStats = '';
                    var RegresaActiva = '';
                    
                    if(data.totalNeto2==null || data.totalNeto2==''|| data.totalNeto2==0) {
                        BtnStats = 'Asignar Precio';
                    }else if(data.tipo_venta==null || data.tipo_venta==0) {
                        BtnStats = 'Asignar Tipo Venta';
                    }else if((data.id_prospecto==null || data.id_prospecto==''|| data.id_prospecto==0) && data.lugar_prospeccion == 6) {
                        BtnStats = 'Asignar Prospecto';
                    }else if(data.id_subdirector==null || data.id_subdirector==''|| data.id_subdirector==0) {
                        BtnStats = 'Asignar Subdirector';
                    }else if(data.id_sede==null || data.id_sede==''|| data.id_sede==0) {
                        BtnStats = 'Asignar Sede';
                    }else if(data.plan_comision==null || data.plan_comision==''|| data.plan_comision==0) {
                        BtnStats = 'Asignar Plan <br> Sede:'+data.sede;
                    } else{
                        if(data.compartida==null) {
                            varColor  = 'btn-sky';
                        } else{
                            varColor  = 'btn-green';
                        }
                        
                        if(data.fecha_modificacion != null && data.registro_comision != 8 ) {
                            RegresaActiva = '<button href="#" data-param="1" data-idpagoc="' + data.idLote + '" data-nombreLote="' + data.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" title="Regresar a activas">' +'<i class="fas fa-undo-alt"></i></button>';
                        }
                        
                        BtnStats = '<button href="#" value="'+data.idLote+'" data-value="'+data.registro_comision+'" data-totalNeto2 = "'+data.totalNeto2+'" data-estatus="'+data.idStatusContratacion+'" data-cliente="'+data.id_cliente+'" data-plan="'+data.plan_comision+'"  data-tipov="'+data.tipo_venta+'"data-descplan="'+data.plan_descripcion+'" data-code="'+data.cbbtton+'" ' +'class="btn-data '+varColor+' verify_neodata" title="Verificar en NEODATA">'+'<span class="material-icons">verified_user</span></button> '+RegresaActiva+'';
                       
                        BtnStats += `
                                <button href="#"
                                    value="${data.idLote}"
                                    data-value="${data.nombreLote}"
                                    class="btn-data btn-blueMaderas btn-detener btn-warning"
                                    title="Detener">
                                    <i class="material-icons">block</i>
                                </button>`;
                        
                    }
                    return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                }
                // +'<button class="btn-data btn-orangeYellow marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'"><i class="material-icons">how_to_reg</i></button>'  data-estatus  ;
            }],
            columnDefs: [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            },
            ],
            ajax: {
                "url": '<?=base_url()?>index.php/Comisiones/getDataDispersionPago',
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){}
            }
        });

        $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_1.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } 
            else {
 
                var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Director: </b>` + row.data().director + `</label></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Regional: </b>` + row.data().regional + `</label></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Subdirector: </b>` + row.data().subdirector + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
                </div></div>`;

                row.child(informacion_adicional).show();
                tr.addClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
            }
        });
        $("#tabla_ingresar_9 tbody").on('click', '.btn-detener', function () {
                const idLote = $(this).val();
                const nombreLote = $(this).attr("data-value");
                const statusLote = $(this).attr("data-statusLote");

                $('#id-lote-detenido').val(idLote);
                $('#statusLote').val(statusLote);

                $("#detenciones-modal .modal-header").html("");
                $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Motivo de controversia para <b>'+nombreLote+'</b></h4>');

                $("#detenciones-modal").modal();
            });
        $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", async function(){ 
 
            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            
            let cadena = '';
            idLote = $(this).val();
            registro_comision = $(this).attr("data-value");
            totalNeto2 = $(this).attr("data-totalNeto2");
            id_estatus = $(this).attr("data-estatus");
            idCliente = $(this).attr("data-cliente");
            plan_comision = $(this).attr("data-plan");
            descripcion_plan = $(this).attr("data-descplan");
 
            tipo_venta = $(this).attr("data-tipov");

            if(parseFloat(totalNeto2) > 0){
           
                    $("#modal_NEODATA .modal-body").html("");
                    $("#modal_NEODATA .modal-footer").html("");
                    $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                       
                        if(data.length > 0){
                            switch (data[0].Marca) {
                                case 0:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                                break;
                                case 1:
                                    console.log('case 1 ');

                                    if(registro_comision == 0 || registro_comision ==8 || registro_comision == 2){
                                        console.log('case registro_comision ');
                                        //COMISION NUEVA
                                        let total0 = parseFloat(data[0].Aplicado);
                                        let total = 0;
                                        if(total0 > 0){
                                            total = total0;
                                        }else{
                                            total = 0; 
                                        }

                                        // INICIO BONIFICACION *********************************
                                        if(parseFloat(data[0].Bonificado) > 0){
                                            cadena = '<h5>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4></div></div>';
                                            $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="${parseFloat(data[0].Bonificado)}">`);
                                        }else{
                                            cadena = '<h5>Bonificación: <b>$'+formatMoney(0)+'</b></h4></div></div>';
                                            $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="0">`);
                                        }
                                        // FINAL BONIFICACION *********************************

                                        $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12 text-center"><h3>Lote: <b>${row.data().nombreLote}</b></h3><l style='color:gray;'>Plan de venta: <b>${descripcion_plan}</b></l></div></div><div class="row"><div class="col-md-3 p-0"><h5>Precio lote: <b>$${formatMoney(totalNeto2)}</b></h5></div><div class="col-md-3 p-0"><h5>$ Neodata: <b style="color:${data[0].Aplicado <= 0 ? 'black' : 'blue'};">$${formatMoney(data[0].Aplicado)}</b></h5></div><div class="col-md-3 p-0"><h5>Disponible: <b style="color:green;">$${formatMoney(total0)}</b></h5></div><div class="col-md-3 p-0">${cadena}</div></div><br>`);
 
                                        
                                        // OPERACION PARA SACAR 5% *********************************
                                        first_validate = (totalNeto2 * 0.05).toFixed(3);
                                        new_validate = parseFloat(first_validate);
                                        // console.log('OP 5%: '+new_validate);
                                        // console.log('OP T: '+new_validate);
  
                                        if(total>(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)){

                                            // console.log("SOLO DISPERSA LA MITAD*******");
                                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo </b> diponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                            bandera_anticipo = 1;
                                        }
                                        else if((total<(new_validate-1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)){
                                            // console.log("SOLO DISPERSA LO PROPORCIONAL*******");
                                            bandera_anticipo = 0;
                                        }
                                        else if((  total>(new_validate-1) && total<(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)  ){
                                            // console.log("SOLO DISPERSA 5% *******");
                                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo 5%</b> disponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                            bandera_anticipo = 2;
                                        }
                                        // FIN BANDERA OPERACION PARA SACAR 5% *********************************

                                        $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>`);
                              
                                        // lugar = lugar_prospeccionLote;
                                        var_sum = 0;

                                        let abonado=0;
                                        let porcentaje_abono=0;
                                        let total_comision=0;

                                        $.getJSON( url + "Comisiones/porcentajes/"+idCliente+"/"+plan_comision).done( function( resultArr ){
                                            let parteAsesor=0;
                                            let parteGerente=0;
                                            let parteCoord=0;
                                            let resta=0;

                                            $.each( resultArr, function( i, v){
                                                let porcentajeAse =  v.porcentaje_decimal;
                                                let total_comision1=0;
                                                total_comision1 = totalNeto2 * (porcentajeAse / 100);

                                                let saldo1 = 0;
                                                let total_vo = 0;
                                                total_vo = total;
                                                console.log('TOTAL COMISIÓN'+total_comision1)
                                                console.log('TOTAL_VO'+total_vo)
                                                saldo1 = total_vo * (v.porcentaje_neodata / 100);
                                                    
                                                if(saldo1 > total_comision1){
                                                    saldo1 = total_comision1;
                                                }else if(saldo1 < total_comision1){
                                                    saldo1 = saldo1;
                                                }else if(saldo1 < 1){
                                                    saldo1 = 0;
                                                }

                                                let resto1 = 0;
                                                resto1 = total_comision1 - saldo1;
                                                
                                                if(resto1 < 1){
                                                    resto1 = 0;
                                                }else{
                                                    resto1 = total_comision1 - saldo1;
                                                }

                                                let saldo1C=0;

                                                if(bandera_anticipo == 1){
                                                    console.log("entra a banderaa 1 "+bandera_anticipo);
                                                    saldo1C = (saldo1/2);
                                                } else if(bandera_anticipo == 2){
                                                    console.log("entra a banderaa 2 "+bandera_anticipo);
                                                    saldo1C = (saldo1/2);
                                                } else{
                                                    console.log("entra a banderaa 0 "+bandera_anticipo);
                                                    saldo1C = saldo1;
                                                }
                                                total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                                abonado =parseFloat(abonado) +parseFloat(saldo1C);
                                                porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                                console.log('-----');
                                                console.log(saldo1C);

                                                $("#modal_NEODATA .modal-body").append(`<div class="row">
                                                <div class="col-md-3">
                                                <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}">
                                                <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.nombre}" style="font-size:12px;"><b><p style="font-size:12px;">${v.detail_rol}</p></b></div>
                                                <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" name="porcentaje[]"  required readonly="true" type="hidden" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : parseFloat(v.porcentaje_decimal)}"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : v.porcentaje_decimal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]}%"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_total[]" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_abonada[]" required readonly="true" value="${formatMoney(0)}"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_pendiente[]" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required decimals" name="comision_dar[]"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo1C)}"></div></div>`);
                                           
                                                if(i == resultArr.length -1){
                                                    $("#modal_NEODATA .modal-body").append(`
                                                    <input type="hidden" name="pago_neo" id="pago_neo" value="${formatMoney(data[0].Aplicado)}">
                                                    <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                    <input type="hidden" name="porcentaje_abono" id="porcentaje_abono" value="${porcentaje_abono}">
                                                    <input type="hidden" name="abonado" id="abonado" value="${formatMoney(abonado)}">
                                                    <input type="hidden" name="total_comision" id="total_comision" value="${formatMoney(total_comision)}">
                                                    <input type="hidden" name="bonificacion" id="bonificacion" value="${formatMoney(data[0].Bonificado)}">
                                                    <input type="hidden" name="pendiente" id="pendiente" value="${formatMoney(total_comision-abonado)}">
                                                    <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                                                    <input type="hidden" name="id_disparador" id="id_disparador" value="0">
                                                     
                               
                                                    <input type="hidden" name="totalNeto2" id="totalNeto2" value="${totalNeto2}">
                                                    `);
                                                }
                                            });
                                            
                                            $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
                                        
                                        });

        
                                    }
                                    else{
                                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                                            let total0 = parseFloat((data[0].Aplicado));
                                            let total = 0;
                                            if(total0 > 0){
                                                total = total0;
                                            }
                                            else{
                                                total = 0; 
                                            }

                                            var counts=0;

                                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-(data1[0].abonado))+'</b></h3></div></div><br>');

                                            $("#modal_NEODATA .modal-body").append('<div class="row">'+
                                            '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                                            '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                                            '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                                            if(parseFloat(data[0].Bonificado) > 0){
                                                cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                                            }else{
                                                cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';
                                            }
                                            $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: $${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                            <div class="col-md-4"><h4>Aplicado neodata: <b>$${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                            </div><br>`);
                                            
                                            $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');
                                                let contador=0;
                                                console.log('gree:'+data.length);
                                                let coor = data.length;
                                                for (let index = 0; index < data.length; index++) {
                                                    const element = data[index].id_usuario;
                                                    if(data[index].id_usuario == 5855){
                                                        contador +=1;
                                                    }
                                                }

                                                $.each( data, function( i, v){
                                                    saldo =0;
                                                    if(tipo_venta == 7 && coor == 2){
                                                        total = total - data1[0].abonado;
                                                        console.log(total);

                                                        saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.925*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : ((12.5 *(v.porcentaje_decimal / 100)) * total);

                                                    }
                                                    else if(tipo_venta == 7 && coor == 3){
                                                        total = total - data1[0].abonado;
                                                        console.log(total);
                                                        saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.675*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : tipo_venta == 7 && v.rol_generado == "9" ?  (0.25*total) :   ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                    }
                                                    else{
                                                        saldo =  ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                    }

                                                    if(parseFloat(v.abono_pagado) > 0){
                                                        console.log("OPCION 1");
                                                        console.log(v.colaborador);
                                                        evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                                        if(parseFloat(evaluar) < 0){
                                                           // pending = 0;
                                                           pending=evaluar;
                                                            saldo = 0;
                                                        }
                                                        else{
                                                            pending = evaluar;
                                                        }
                                                        console.log('EVALUAR: '+evaluar);
                                                        console.log('PENDDING: '+pending);

                                                        resta_1 = saldo-v.abono_pagado;
                                                        
                                                        console.log('resta_1: '+resta_1);

                                                        if(parseFloat(resta_1) <= 0){
                                                            saldo = 0;
                                                        }
                                                        else if(parseFloat(resta_1) > 0){
                                                            if(parseFloat(resta_1) > parseFloat(pending)){
                                                                saldo = pending;
                                                            }
                                                            else{
                                                                saldo = saldo-v.abono_pagado;
                                                            }
                                                        }

                                                        console.log(saldo);
                                                    }  
                                                    else if(v.abono_pagado <= 0){
                                                        console.log("OPCION 2");
                                                        pending = (v.comision_total);
                                                        if(saldo > pending){
                                                            saldo = pending;
                                                        }
                                                        if(pending < 0){
                                                            saldo = 0;
                                                        }
                                                    }
                                                    console.log('SALDO'+saldo);

                                                    if( (parseFloat(saldo) + parseFloat(v.abono_pagado)) > (parseFloat(v.comision_total)+0.5 )){
                                                        console.log((parseFloat(saldo) + parseFloat(v.abono_pagado)));
                                                        console.log(parseFloat(v.comision_total));
                                                        console.log('ENTRA AQUI AL CERO');
                                                            saldo = 0;
                                                        }
                                                    $("#modal_NEODATA .modal-body").append(`<div class="row">
                                                    <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                                    <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                    <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="rol" type="hidden" name="rol[]" value="${v.id_usuario}">
                                                    <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                                    <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>
                                                    <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}%"></div>
                                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}"></div>
                                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}"></div>
                                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}"></div>
                                                    <div class="col-md-2"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control ng-invalid ng-invalid-required abono_nuevo" readonly="true"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                                    <input class="form-control ng-invalid ng-invalid-required decimals"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo)}"></div></div>`);
                                                    counts++
                                                });
                                            });

                                            $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
                                            
                                            if(total < 1 ){
                                                $('#dispersar').prop('disabled', true);
                                            }
                                            else{
                                                $('#dispersar').prop('disabled', false);
                                            }
                                        });
                                    }
                                break;
                                case 2:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                                case 3:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                                case 4:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                                case 5:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                                default:
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento: .</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                                break;
                            }
                        }
                        else{
                            console.log("QUERY SIN RESULTADOS");
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        }
                    }); //FIN getStatusNeodata
                    
                    $("#modal_NEODATA").modal();
                }
 
        }); //FIN VERIFY_NEODATA
        /**----------------------------------------------------------------------- */
    
    });
    $('#detenidos-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'changeLoteToStopped',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data) {
                        $('#detenciones-modal').modal("hide");
                        $("#id-lote-detenido").val("");
                        alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                        tabla_1.ajax.reload();
                    } else {
                        alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                    }
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });
    $("#form_NEODATA").submit( function(e) {
        $('#dispersar').prop('disabled', true);
        document.getElementById('dispersar').disabled = true;

        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#spiner-loader').removeClass('hidden');
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url + 'Comisiones/InsertNeo',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data == 1 ){
                        $('#spiner-loader').addClass('hidden');
                        alerts.showNotification("top", "right", "Dispersión guardada con éxito", "success");
                        tabla_1.ajax.reload();
                        $("#modal_NEODATA").modal( 'hide' );
                        function_totales();
                        $('#dispersar').prop('disabled', false);
        document.getElementById('dispersar').disabled = false;

                    }else if (data == 2) {
                        $('#spiner-loader').addClass('hidden');
                        alerts.showNotification("top", "right", "Ya se dispersó por otra persona o es una recisión", "warning");
                        tabla_1.ajax.reload();
                        $("#modal_NEODATA").modal( 'hide' );
                        $('#dispersar').prop('disabled', false);
        document.getElementById('dispersar').disabled = false;
                    }else{
                        $('#spiner-loader').addClass('hidden');
                        alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                        $('#dispersar').prop('disabled', false);
        document.getElementById('dispersar').disabled = false;
                    }
                },error: function(){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "ERROR EN EL SISTEMA, REVISAR CON SISTEMAS", "danger");

                }
            });     
        }
    });   

    $("#form_pagadas").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#spiner-loader').removeClass('hidden');
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url2 + "Comisiones/liquidar_comision",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#spiner-loader').addClass('hidden');
                        $("#modal_pagadas").modal('toggle');
                        tabla_1.ajax.reload();
                        alert("¡Se agregó con éxito!");


                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#spiner-loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });

    $("#form_NEODATA2").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#spiner-loader').removeClass('hidden');
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url + 'Comisiones/InsertNeoCompartida',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data == 1 ){
                        $('#spiner-loader').addClass('hidden');
                        tabla_1.ajax.reload();
                        alert("Dispersión guardada con exito.");
                        $("#modal_NEODATA2").modal( 'hide' ); 
                        function_totales();
                    }else if (data == 2) {
                        alert("Ya disperso otra persona esta comision");
                        tabla_1.ajax.reload();
                        $("#modal_NEODATA2").modal( 'hide' ); 
                        function_totales();
                        $('#spiner-loader').addClass('hidden');
                    }else{
                        $('#spiner-loader').addClass('hidden');
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },error: function(){
                    $('#spiner-loader').addClass('hidden');
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });

    jQuery(document).ready(function(){
        jQuery('#editReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario').val('');
            jQuery(this).find('#totalNeto').val('');
            jQuery(this).find('#totalNeto2').val('');
        })

        jQuery('#rechReg').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario3').val('');
        })

        function myFunctionD2(){
            formatCurrency($('#inputEdit'));
        }
    })

    $('.decimals').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });

    function SoloNumeros(evt){
        if(window.event){
            keynum = evt.keyCode; 
        }
        else{
            keynum = evt.which;
        } 

        if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
            return true;
        }
        else{
            alerts.showNotification("top", "left", "Solo Numeros.", "danger");
            return false;
        }
    }

    function function_totales(){
        $.getJSON( url + "Comisiones/getMontoDispersado").done( function( data ){
            $cadena = '<b>$'+formatMoney(data[0].monto)+'</b>';
            document.getElementById("monto_label").innerHTML = $cadena ;
        });
        $.getJSON( url + "Comisiones/getPagosDispersado").done( function( data ){
            $cadena01 = '<b>'+data[0].pagos+'</b>';
            document.getElementById("pagos_label").innerHTML = $cadena01 ;
        });
        $.getJSON( url + "Comisiones/getLotesDispersado").done( function( data ){
            $cadena02 = '<b>'+data[0].lotes+'</b>';
            document.getElementById("lotes_label").innerHTML = $cadena02 ;
        });  
    }

    $('#fecha1').change( function(){
        fecha1 = $(this).val(); 
        var fecha2 = $('#fecha2').val();
        if(fecha2 == ''){
            alerts.showNotification("top", "right", "Selecciona la segunda fecha", "info");
        }
        else{
            document.getElementById("fecha2").value = "";
        }
    });

    $('#fecha2').change( function(){  
        $("#myModal .modal-body").html('');
        var fecha2 = $(this).val();  
        var fecha1 = $('#fecha1').val();
        if(fecha1 == ''){
            alerts.showNotification("top", "right", "Selecciona la primer fecha", "info");
        }
        else{
            $.getJSON( url + "Comisiones/getMontoDispersadoDates/"+fecha1+'/'+fecha2).done( function( $datos ){
                $("#myModal .modal-body").append('<div class="row">                <div class="col-md-5"><p class="category"><b>Monto</b>: $'+formatMoney($datos['datos_monto'][0].monto)+'</p></div><div class="col-md-4"><p class="category"><b>Pagos</b>: '+formatMiles($datos['datos_monto'][0].pagos)+'</p></div><div class="col-md-3"><p class="category"><b>Lotes</b>: '+formatMiles($datos['datos_monto'][0].lotes)+'</p></div></div>');
            });
        }
    });

    $("#my_updatebandera_form").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'updateBandera',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            },
            success: function(data) {
                if (data == 1) {
                    $('#myUpdateBanderaModal').modal("hide");
                    $("#id_pagoc").val("");
                    alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                    tabla_1.ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    function formatCurrency(input, blur) {
        var input_val = input.val();
        if (input_val === "") { return; }
        var original_len = input_val.length;
        var caret_pos = input.prop("selectionStart");
        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            if (blur === "blur") {
            right_side += "00";
            }
            right_side = right_side.substring(0, 2);
            input_val = left_side + "." + right_side;
        } else {
            input_val = formatNumber(input_val);
            input_val = input_val;
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        input.val(input_val);
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }


  const formatMiles = (number) => {
  const exp = /(\d)(?=(\d{3})+(?!\d))/g;
  const rep = '$1,';
  return number.toString().replace(exp,rep);
}

function convertirPorcentajes(value) {
        const fixed = Number(value).toFixed(3);
        const partes = fixed.split(".");
        const numeroEntero = partes[0];
        const numeroDecimal = checkDecimal(partes[1]);
        if (numeroDecimal === '') {
            return `${numeroEntero}`;
        }
        return `${numeroEntero}.${numeroDecimal}`;
    }

    function checkDecimal(decimal) {
        let str = '';
        for (let i = 0; i < decimal.length; i++) {
            if (decimal.charAt(i) !== '0') {
                str += decimal.charAt(i);
            }
        }
        return str;
    }

    </script>
</body>