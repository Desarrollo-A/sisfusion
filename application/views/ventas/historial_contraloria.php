<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<body>
    <div class="wrapper">
        <?php
        if($this->session->userdata('id_rol')=="63" || $this->session->userdata('id_rol')=="17"  || $this->session->userdata('id_rol')=="28" || $this->session->userdata('id_rol')=="32"|| $this->session->userdata('id_rol')=="18"|| $this->session->userdata('id_rol')=="1"|| $this->session->userdata('id_rol')=="2"|| $this->session->userdata('id_rol')=="3"|| $this->session->userdata('id_rol')=="7" || $this->session->userdata('id_rol')=="9" || $this->session->userdata('id_rol')=="31" )//contraloria
        {/*-------------------------------------------------------*/
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;
            $this->load->view('template/sidebar', $datos);
        }else{
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>

        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                                <div id="nameLote"></div>
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
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade modal-alertas" id="modal_informacion" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h3><center>Detalle</center></h3>
                    </div>
                    <div class="modal-body">
                        <div class="material-datatables">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table-striped table-hover" id="tabla_modal" name="tabla_modal"><thead>
                                        <tr>
                                            <th>ID PAGO</th>
                                            <th>LOTE</th>
                                            <th>MONTO</th>
                                            <th>FECHA APLICADO</th>
                                            <th>MONTO ANTERIOR</th>
                                            <th>ESTATUS</th>
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

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#solicitudesCRM" role="tab"  data-toggle="tab">Historial CRM</a>
                            </li>

                            <li><a href="#solicitudesCanceladas" role="tab"  data-toggle="tab">Historial canceladas</a>
                                </li>

                            <?php if( $this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9) { ?>
                                <li>
                                    <a href="#solicitudesSUMA" role="tab"  data-toggle="tab">Historial SUMA</a>
                                </li>
                            <?php }?>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="solicitudesCRM">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align">Historial Activos</h3>
                                                <p class="card-title pl-1">(Listado de todos los pagos aplicados, en proceso de lotes contratados y activos)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="proyecto">Año</label>
                                                            <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                    for ($i = 2019; $i <= 2022; $i++) {
                                                                        $yearName  = $i;
                                                                        echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="proyecto">Proyecto</label>
                                                            <select name="filtro44" id="filtro44" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required> <option value="0">Seleccione todo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>PROY.</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>REF.</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>TOTAL COM.</th>
                                                                    <th>PAGO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>PAGADO</th>
                                                                    <th>PENDIENTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- INICIO tab CANCELADAS validado -->

                                        <div class="tab-pane" id="solicitudesCanceladas">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align">Historial Canceladas</h3>
                                                <p class="card-title pl-1">(Listado de todos los pagos aplicados, en proceso de lotes cancelados con recisión)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="proyecto">Año</label>
                                                            <select name="filtro35" id="filtro35" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                    for ($i = 2019; $i <= 2022; $i++) {
                                                                        $yearName  = $i;
                                                                        echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="proyecto">Proyecto</label>
                                                            <select name="filtro45" id="filtro45" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required> <option value="0">Seleccione todo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_comisiones_canceladas" name="tabla_comisiones_canceladas">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>PROY.</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>REF.</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>TOTAL COM.</th>
                                                                    <th>PAGO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>PAGADO</th>
                                                                    <th>PENDIENTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End tab CANCELADAS validado -->


                                        <?php if( $this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9) { ?>
                                        <div class="tab-pane" id="solicitudesSUMA">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align">Historial general SUMA</h3>
                                            </div>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="anio">Año</label>
                                                            <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_comisiones_suma" name="tabla_comisiones_suma">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>NOMBRE</th>
                                                                    <th>SEDE</th>
                                                                    <th>FORMA PAGO</th>
                                                                    <th>TOTAL COMISION</th>
                                                                    <th>IMPUESTO</th>
                                                                    <th>% COMISION</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End tab SUMA  validado solo para ventas-->
                                        <?php }?>
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
        $('#filtro33').change(function(ruta){
            residencial = $('#filtro33').val();
            param = $('#param').val();
            $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Contratacion/lista_proyecto_dos/',
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++){
                        var id = response[i]['idResidencial'];
                        var name = response[i]['descripcion'];
                        $("#filtro44").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#filtro44").selectpicker('refresh');
                }
            });
        });


        $('#filtro44').change(function(ruta){
            proyecto = $('#filtro33').val();
            condominio = $('#filtro44').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            if(tabla_historialGral2){
                 tabla_historialGral2.destroy();
            }

            getAssimilatedCommissions(proyecto, condominio);
            // 
        });

        $('#filtro35').change(function(ruta){
            residencial = $('#filtro35').val();
            param = $('#param').val();
            $("#filtro45").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Contratacion/lista_proyecto_dos/',
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++){
                        var id = response[i]['idResidencial'];
                        var name = response[i]['descripcion'];
                        $("#filtro45").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#filtro45").selectpicker('refresh');
                }
            });
        });


        $('#filtro45').change(function(ruta){
            proyecto = $('#filtro35').val();
            condominio = $('#filtro45').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            if(tabla_historialGral3){
                 tabla_historialGral3.destroy();
            }

            getAssimilatedCancelacion(proyecto, condominio);
        
        });

        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }

        $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            if(i != 15){
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                        $('#tabla_historialGral').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });

        $('#tabla_comisiones_canceladas thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            if(i != 15){
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#tabla_comisiones_canceladas').DataTable().column(i).search() !== this.value ) {
                        $('#tabla_comisiones_canceladas').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });

        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var totalLeon = 0;
        var totalQro = 0;
        var totalSlp = 0;
        var totalMerida = 0;
        var totalCdmx = 0;
        var totalCancun = 0;
        var tr;
        var tabla_historialGral2 ; 
        var tabla_historialGral3 ;
        var totaPen = 0;

        //INICIO TABLA QUERETARO ACTIVOS****************************************************************************************

        function getAssimilatedCommissions(proyecto, condominio){
            let titulos = [];
            $("#tabla_historialGral").prop("hidden", false);
            tabla_historialGral2 = $("#tabla_historialGral").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',                
                buttons: [
                // {
                //     text: '<i class="fa fa-table" aria-hidden="true"></i>',
                //     className: 'btn buttons-general-dt ver-info-asesor',
                //     titleAttr: 'Reporte pagos UM',
                // },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'HISTORIAL_GENERAL_ACTIVAS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    //  return ' '+d +' ';
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 3){
                                    return 'NOMBRE LOTE';
                                }else if(columnIdx == 4){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 5){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 6){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 7){
                                    return 'PAGO CLIENTE';
                                }else if(columnIdx == 8){
                                    return 'DISPERSADO NEODATA';
                                }else if(columnIdx == 9){
                                    return 'PAGADO';
                                }else if(columnIdx == 10){
                                    return 'PENDIENTE';
                                }else if(columnIdx == 11){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 12){
                                    return 'PUESTO';
                                }else if(columnIdx == 13){
                                    return 'DETALLE';
                                }else if(columnIdx == 14){
                                    return 'ESTATUS ACTUAL';
                                }else if(columnIdx != 15 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
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
                deferRender: true,

                columns: [{
                    "width": "5%",
                    "data": function( d ){
                        var lblStats;
                        lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.referencia+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pagado)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.restante==null||d.restante==''){
                            return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                        }
                        else{
                            return '<p class="m-0">$'+formatMoney(d.restante)+'</p>';
                        }
                    }
                }, 
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.activo == 0 || d.activo == '0'){
                            return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label" style="background:red;">BAJA</span></p>';
                        }
                        else{
                            return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.puesto+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;"> + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        var etiqueta;
     
                                if(d.pago_neodata < 1){
                                    etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p><p class="m-0"><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                                }else{

                                    etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p>';
                                }
 
                        return etiqueta;
                    }
                },
                { 
                    "width": "2%",
                    "orderable": false,
                    "data": function( data ){

                        var BtnStats;

                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados"  title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    'searchable':false,
                    'className': 'dt-body-center',

                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {

                    "url": url2 + "Comisiones/getDatosHistorialPago/" + proyecto + "/" + condominio,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}
                },
                order: [[ 1, 'asc' ]]
            });

            $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }

        //FIN TABLA  ****************************************************************************************

        //INICIO TABLA QUERETARO CANCELACIONES****************************************************************************************

        function getAssimilatedCancelacion(proyecto, condominio){
            let titulos = [];
            $("#tabla_comisiones_canceladas").prop("hidden", false);
            tabla_historialGral3 = $("#tabla_comisiones_canceladas").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',                
                buttons: [
                // {
                //     text: '<i class="fa fa-table" aria-hidden="true"></i>',
                //     className: 'btn buttons-general-dt ver-info-asesor',
                //     titleAttr: 'Reporte pagos UM',
                // },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'HISTORIAL_GENERAL_CANCELADAS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    //  return ' '+d +' ';
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 3){
                                    return 'NOMBRE LOTE';
                                }else if(columnIdx == 4){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 5){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 6){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 7){
                                    return 'PAGO CLIENTE';
                                }else if(columnIdx == 8){
                                    return 'DISPERSADO NEODATA';
                                }else if(columnIdx == 9){
                                    return 'PAGADO';
                                }else if(columnIdx == 10){
                                    return 'PENDIENTE';
                                }else if(columnIdx == 11){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 12){
                                    return 'PUESTO';
                                }else if(columnIdx == 13){
                                    return 'DETALLE';
                                }else if(columnIdx == 14){
                                    return 'ESTATUS ACTUAL';
                                }else if(columnIdx != 15 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
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
                deferRender: true,

                columns: [{
                    "width": "5%",
                    "data": function( d ){
                        var lblStats;
                        lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.referencia+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pagado)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.restante==null||d.restante==''){
                            return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                        }
                        else{
                            return '<p class="m-0">$'+formatMoney(d.restante)+'</p>';
                        }
                    }
                }, 
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.activo == 0 || d.activo == '0'){
                            return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label" style="background:red;">BAJA</span></p>';
                        }
                        else{
                            return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                        }
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.puesto+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        var lblPenalizacion = '';

                        if (d.penalizacion == 1){
                            lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label" style="background:orange;"> + 90 días</span></p>';
                        }

                        if(d.bonificacion >= 1){
                            p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label" style="background:RED;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        
                        return p1 + p2 + lblPenalizacion;
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        var etiqueta;
     
                                if(d.pago_neodata < 1){
                                    etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p><p class="m-0"><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                                }else{

                                    etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+';">'+d.estatus_actual+'</span></p>';
                                }
 
                        return etiqueta;
                    }
                },
                { 
                    "width": "2%",
                    "orderable": false,
                    "data": function( data ){

                        var BtnStats;

                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados"  title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    'searchable':false,
                    'className': 'dt-body-center',

                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {

                    "url": url2 + "Comisiones/getDatosHistorialCancelacion/" + proyecto + "/" + condominio,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}
                },
                order: [[ 1, 'asc' ]]
            });

            $("#tabla_comisiones_canceladas tbody").on("click", ".consultar_logs_asimilados", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        }

        //FIN TABLA  ****************************************************************************************


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

        function cancela(){
            $("#modal_nuevas").modal('toggle');
        }

        //Función para pausar la solicitud
        $("#form_interes").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url + "Comisiones/despausar_solicitud",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data[0] ){
                            $("#modal_nuevas").modal('toggle' );
                            alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                            setTimeout(function() {
                                tabla_historialGral2.ajax.reload();
                            }, 3000);
                        }else{
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function cleanComments(){
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }

        $(document).on('click', '.ver-info-asesor', function(){
           $('#modal_informacion').modal();

            /*tabla_modal*/
            $("#tabla_modal").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel ',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'HISTORIAL',
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
                    "width": "5%",
                    "data": function( d ){
                        var lblStats;
                        lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                        return lblStats;
                    }
                },
                    {
                        "width": "5%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.nombreLote+'</p>';
                        }
                    },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0">$ '+formatMoney(d.abono_neodata)+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.fecha_modificacion+'</p>';
                        }
                    },
                    {
                        "width": "5%",
                        "data": function( d ){
                            return '<p class="m-0">$'+formatMoney(d.saldo_comisiones)+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0"> Descuentos universidad</p>';
                        }
                    }
                    ],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    'searchable':false,
                    'className': 'dt-body-center',

                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    "url": url2 + "Comisiones/inforReporteAsesor",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}
                },
                order: [[ 1, 'asc' ]]
            });
            /*TABLA MODAL END*/
        });


        function tableComisionesSuma(anio){
            $('#tabla_comisiones_suma thead tr:eq(0) th').each( function (i) {
                if( i != 9 ){
                    var title = $(this).text();  
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_suma.column(i).search() !== this.value) {
                            tabla_suma.column(i).search(this.value).draw();
                        }
                    });
                }
            });

            $('#tabla_comisiones_suma').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json, function(i, v) {
                    total += parseFloat(v.total_comision);
                });
                var to = formatMoney(total);
                
            });

            tabla_suma = $("#tabla_comisiones_suma").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES SUMA PAGADAS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 2){
                                    return 'NOMBRE COMISIONISTA';
                                }else if(columnIdx == 3){
                                    return 'SEDE';
                                }else if(columnIdx == 4){
                                    return 'FORMA PAGO';
                                }else if(columnIdx == 5){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 6){
                                    return 'IMPUESTO';
                                }else if(columnIdx == 7){
                                    return '% COMISIÓN';
                                }else if(columnIdx == 8){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: `${general_base_url}static/spanishLoader_v2.json`,
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_suma + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.referencia + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.sede + '</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.total_comision) + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.impuesto) + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return `<span style="background-color:${d.color_estatus}40; padding: 7px 10px; border-radius: 20px;"><label class="m-0 fs-125"><b style="color:${d.color_estatus}">${d.estatus}</b></label><span>`;
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history m-auto" title="Detalles">' +'<i class="fas fa-info"></i></button>';

                    }
                }],
                ajax: {
                    url: general_base_url + "Suma/getAllComisionesByUser",
                    type: "POST",
                    data: {anio : anio},
                    dataType: 'json',
                    dataSrc: ""
                },
            });

            $("#tabla_comisiones_suma tbody").on("click", ".consultar_history", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                id_pago = $(this).val();
                referencia = $(this).attr("data-referencia");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").html("");
                $("#comments-list-asimilados").html("");
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
                $.getJSON(general_base_url+"Suma/getHistorial/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
                    });
                });
            });
        }
            

        $("#anio").ready( function(){
            let yearBegin = 2019;
            let currentYear = moment().year()
            while( yearBegin <= currentYear ){
                $("#anio").append(`<option value="${yearBegin}">${yearBegin}</option>`);
                yearBegin++;
            }
            $("#anio").val(currentYear);
            $("#anio").selectpicker('refresh');

            tableComisionesSuma(currentYear);
        });

        $("#anio").on("change", function(){
            tableComisionesSuma(this.value);
        })
    </script>
</body>