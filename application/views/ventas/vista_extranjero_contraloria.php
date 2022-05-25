<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
            if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_usuario')=="2767"){
                $datos = array();
                $datos = $datos4;
                $datos = $datos2;
                $datos = $datos3;  
                $this->load->view('template/sidebar', $datos);
            }
            else
            {
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
            }
        ?>
    
        <!-- Modals -->
        <!--<div class="modal fade modal-alertas" id="modal_users" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
            
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
            
                    <form method="post" id="form_colaboradores">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">EDITAR INFORMACIÓN</h4>
                    </div>
                    <form method="post" id="form_MKTD">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <!--<div class="modal fade modal-alertas" id="modalParcialidad" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">SOLICITAR PARCIALIDAD DE PAGO</h4>
                    </div>
                    <form method="post" id="form_parcialidad">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>-->


        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanComments()">clear</i>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                        </div>
                    </div>
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

        <!--<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>-->
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">        
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos Solicitados</a></li>
                            <li><a href="#proceso-1" role="tab" data-toggle="tab">Invoice</a></li>
                        </ul>
                        
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                        <div class="card-content">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Comisiones nuevas <b>Factura Extranjero</b></h3>
                                        <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de Factura Extranjero)</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarextranjero" id="totpagarextranjero">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro33">Proyecto</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required>
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro44">Condominio</label>
                                                    <select class="selectpicker select-gral" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required/></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_extranjero" name="tabla_extranjero">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>ID</th>
                                                            <th>PROY.</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>REFERENCIA</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>EMP.</th>
                                                            <th>TOT. COM.</th>
                                                            <th>P. CLIENTE</th>
                                                            <th>A PAGAR</th>
                                                            <th>TIPO VENTA</th>
                                                            <th>USUARIO</th>
                                                            <th>PUESTO</th>
                                                            <th>FEC. ENVÍO</th>
                                                            <th>MÁS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="text-center">
                                                <h3 class="card-title center-align">Comisiones dispersadas por dirección mktd</h3>
                                                <p class="card-title pl-1">(Lotes correspondientes a comisiones solicitadas para pago por el área de MKTD, en espera de validación contraloría y pago de internomex)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total</h4>
                                                                <p class="input-tot pl-1" id="myText_proceso">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>USUARIO</th>
                                                        <th>MONTO</th>
                                                        <th>PROYECTO</th>
                                                        <th>EMPRESA</th>
                                                        <th>OPINIÓN CUMPLIMIENTO</th>
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
        $(document).ready(function() {
            $("#tabla_extranjero").prop("hidden", true);

            var url = "<?=base_url()?>/index.php/";
          

            $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#filtro33").selectpicker('refresh');
            }, 'json');

 
        });
 
        $('#filtro33').change(function(ruta){
            residencial = $('#filtro33').val();
            $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++){
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }

                    $("#filtro44").selectpicker('refresh');
                }
            });
        });

 
        $('#filtro33').change(function(ruta){
            proyecto = $('#filtro33').val();
            condominio = $('#filtro44').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            console.log(proyecto);
            console.log(condominio);
            getAssimilatedCommissions(proyecto, condominio);
        });

        $('#filtro44').change(function(ruta){
            proyecto = $('#filtro33').val();
            condominio = $('#filtro44').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            getAssimilatedCommissions(proyecto, condominio);
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
        var tabla_remanente2 ;
        var totaPen = 0;

          //INICIO TABLA QUERETARO*************************************
          $('#tabla_extranjero thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_extranjero2.column(i).search() !== this.value) {
                        tabla_extranjero2
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_extranjero2.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_extranjero2.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("totpagarextranjero").textcontent = formatMoney(total);
                    }
                });
            }
            else {
                $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
            }
        });

        function getAssimilatedCommissions(proyecto, condominio){
            $('#tabla_extranjero').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("totpagarextranjero").textContent = '$' + to;
            });

            $("#tabla_extranjero").prop("hidden", false);
            tabla_extranjero2 = $("#tabla_extranjero").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
                    action: function() {
                        if ($('input[name="idTQ[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            var idcomision = $(tabla_extranjero2.$('input[name="idTQ[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            
                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 
                            $.ajax({
                                url : url2 + 'Comisiones/acepto_internomex_remanente/',
                                data: com2,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST', 
                                success: function(data){
                                    response = JSON.parse(data);
                                    if(data == 1) {
                                        $('#spiner-loader').addClass('hide');
                                        $("#totpagarPen").html(formatMoney(0));
                                        $("#all").prop('checked', false);
                                        var fecha = new Date();
                                        $("#myModalEnviadas").modal('toggle');
                                        tabla_extranjero2.ajax.reload();
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='<?= base_url('dist/img/send_intmex.gif')?>'><p style='color:#676767;'>Comisiones de esquema <b>Factura extranjero</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>");
                                    }
                                    else {
                                        $('#spiner-loader').addClass('hide');
                                        $("#myModalEnviadas").modal('toggle');
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                                    }
                                },
                                error: function( data ){
                                    $('#spiner-loader').addClass('hide');
                                    $("#myModalEnviadas").modal('toggle');
                                    $("#myModalEnviadas .modal-body").html("");
                                    $("#myModalEnviadas").modal();
                                    $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                                }
                            });
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                        style: 'position: relative; float: right;',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'EXTRANJERO_CONTRALORÍA_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'ID PAGO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 4){
                                    return 'NOMBRE LOTE ';
                                }else if(columnIdx == 5){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 6){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 7){
                                    return 'EMPRESA';
                                }else if(columnIdx == 8){
                                    return 'TOT. COMISIÓN';
                                }else if(columnIdx == 9){
                                    return 'P. CLIENTE';
                                }else if(columnIdx == 10){
                                    return 'TOT. PAGAR';
                                }else if(columnIdx == 11){
                                    return 'TIPO VENTA';
                                }else if(columnIdx == 12){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 13){
                                    return 'PUESTO';
                                }else if(columnIdx == 14){
                                    return 'FECH. ENVÍO';
                                }
                                else if(columnIdx != 15 && columnIdx !=0){
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
                ordering: false,
                columns: [{
                    "width": "3%" },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_pago_i+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.lote+'</b></p>';
                    }
                },
                {
                    "width": "7%",
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
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.empresa+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },

                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.lugar_prospeccion == 6){
                            return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                        }
                        else{
                            return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                        }
                    
                    }
                },
                {
                    "width": "9%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0"><i> '+d.puesto+'</i></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        var BtnStats1;
                        BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                        return BtnStats1;

                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function( data ){
                        var BtnStats;
                        
                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_extranjero" title="Detalles">' +'<i class="fas fa-info"></i></button>'+

                        '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-warning cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-ban"></i></button>';
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    searchable:false,
                    className: 'dt-body-center',
                    render: function (d, type, full, meta){
                        if(full.estatus == 4){
                            if(full.id_comision){
                                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            }
                            else{
                                return '';
                            }
                        }
                        else{
                            return '';
                        }
                    },
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosNuevasEContraloria/" + proyecto + "/" + condominio,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },
            });

            $("#tabla_extranjero tbody").on("click", ".consultar_logs_extranjero", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalExtranjero").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-extranjero").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });

            $('#tabla_extranjero').on('click', 'input', function() {
                tr = $(this).closest('tr');
                var row = tabla_extranjero2.row(tr).data();
                if (row.pa == 0) {
                    row.pa = row.impuesto;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                }
                else {
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }

                $("#totpagarPen").html(formatMoney(totaPen));
            });

            $("#tabla_extranjero tbody").on("click", ".cambiar_estatus", function(){
                var tr = $(this).closest('tr');
                var row = tabla_extranjero2.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_nuevas").modal();
            });

          
        }
        //FIN TABLA  ****************************************************************************************
    
        //INICIO TABLA QUERETARO******************************************
        let titulos = [];

        $('#tabla_factura thead tr:eq(0) th').each( function (i) {
            if(i != 15 && i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input class="textoshead" type="text" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_factura2.column(i).search() !== this.value) {
                        tabla_factura2.column(i).search(this.value).draw();

                        var total = 0;
                        var index = tabla_factura2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_factura2.rows(index).data();

                        $.each(data, function(i, v) {
                            total += parseFloat(v.total);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("totpagarfactura").textContent = formatMoney(total);
                    }
                });
            }
        });

        function getFacturaCommissions(proyecto, condominio){
            $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.total);
                });
                var to = formatMoney(total);
                document.getElementById("totpagarfactura").textContent = '$' + to;
            });

            $("#tabla_factura").prop("hidden", false);
            tabla_factura2 = $("#tabla_factura").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    text: 'XMLS',
                    action: function(){
                        if(rol == 17 || rol == 13 || rol == 31 || rol== 32){
                            window.location = url+'Kel_XML/descargar_XML';
                        }
                        else{
                            alerts.showNotification("top", "right", "No tienes permisos para descargar archivos.", "warning");
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                        style: 'position: relative; float: right;',
                    }
                },
                {
                    text: 'OPINIONES CUMPLIMIENTO',
                    action: function(){
                        if(rol == 17 || rol == 13 || rol == 31 || rol== 32){
                            window.location = url+'Kel_XML/descargar_PDF';
                        }
                        else{
                            alerts.showNotification("top", "right", "No tienes permisos para descargar archivos.", "warning");
                        }
                    },
                    attr: {
                        class: 'btn buttons-pdf',
                        style: 'position: relative; float: right;',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'CONCENTRADO_FACTURAS',
                    exportOptions: {
                        columns: [1,2,3,4,5],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'MONTO ACUMULADO';
                                }else if(columnIdx == 3){
                                    return 'PROYECTO';
                                }else if(columnIdx == 4){
                                    return 'EMPRESA ';
                                }else if(columnIdx == 5){
                                    return 'OPINIÓN CUMPLIMIENTO';
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
                ordering: false,
                columns: [{
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.usuario+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0"><b> $'+formatMoney(d.total)+'</b></p>';
                    }
                },{
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.empresa+'</b></p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){

                        if(d.estatus_opinion == 1 || d.estatus_opinion == 2){
                        return '<span class="label label-success" style="background:#F1C40F;">OPINIÓN DE CUMPLIMIENTO</span>';
                        }else{
                            return '<span class="label" style="background:#A6A6A6;">SIN ARCHIVO</span>';
                        }
                    }
                },
                {
                    "width": "15%",
                    "orderable": false,
                    "data": function( data ){
                        var BtnStats ='';
                        let btnpdf = '';
                        let btnpausar = '';
                        if(data.estatus_opinion == 1 || data.estatus_opinion == 2){
                            if(rol == 2 || rol == 3 || rol == 7 || rol==9){
                                let namefile2 = data.xmla.split('.');
                                if(data.bandera != 3 ){
                                    btnpdf = '<button value="'+data.uuid+'" data-userfactura="'+data.usuario+'" data-file="'+data.xmla+'" class="btn-data btn-green subirPDF" title="Subir PDF">' +'<i class="fas fa-upload"></i></button>';
                                }
                                else{
                                    btnpdf = '<a class="btn-data btn-warning verPDF2" title= "Ver pdf" data-usuario="'+namefile2[0]+'" ><i class="fas fa-file-pdf"></i></a>';
                                }
                            }
                            else{
                                BtnStats = '<button href="#" value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalle de factura">' +'<i class="fas fa-info"></i></button><a href="#" class="btn-data btn-warning verPDF" title= "Ver opinión de cumplimiento" data-usuario="'+data.archivo_name+'" ><i class="material-icons">description</i></a>';
                    
                                let namefile = data.xmla.split('.');
                                if(data.bandera != 3 ){
                                    btnpdf = '<button value="'+data.uuid+'" data-userfactura="'+data.usuario+'" data-file="'+data.xmla+'" class="btn-data btn-blueMaderas subirPDF" title="Subir PDF">' +'<i class="fas fa-upload"></i></button>';
                                }
                                else{
                                    btnpdf = '<a class="btn-data btn-warning verPDF2" title= "Ver pdf" data-usuario="'+namefile[0]+'" ><i class="fas fa-file-pdf"></i></a>';
                                }

                                btnpausar = '<button value="'+data.uuid+'" data-id_user="'+data.id_usuario+'" data-userfactura="'+data.usuario+'" data-total="'+data.total+'" class="btn-data btn-violetChin regresar" title="Refacturar">' +'<span class="material-icons">autorenew</span></button>';
                            }
                        }
                        else{
                            BtnStats = '<button value="'+data.uuid+'" data-value="'+data.idResidencial+'" data-userfactura="'+data.usuario+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_documentos" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        }

                        return '<div class="d-flex justify-center">'+BtnStats+btnpdf+btnpausar+'</div>';
                    }
                }],
                columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosNuevasXContraloria/" + proyecto + "/" + condominio,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },
            });


            $('#tabla_factura tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_factura2.row(tr);

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
                }
                else {
                    if( row.data().solicitudes == null || row.data().solicitudes == "null" ){
                        $.post( url + "Comisiones/carga_listado_factura" , { "idResidencial" : row.data().idResidencial, "id_usuario" : row.data().id_usuario } ).done( function( data ){
                            row.data().solicitudes = JSON.parse( data );
                            tabla_factura2.row( tr ).data( row.data() );
                            row = tabla_factura2.row( tr );
                            row.child( construir_subtablas( row.data().solicitudes ) ).show();
                            tr.addClass('shown');
                            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                        });
                    }
                    else{
                        row.child( construir_subtablas( row.data().solicitudes ) ).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                    }
                }
            });


            function construir_subtablas( data ){
                var solicitudes = '<table class="table">';
                $.each( data, function( i, v){ 
                    solicitudes += '<tr>';
                    solicitudes += '<td><b>'+(i+1)+'</b></td>';
                    solicitudes += '<td>'+'<b>'+'ID: '+'</b> '+v.id_pago_i+'</td>';
                    solicitudes += '<td>'+'<b>'+'CONDOMINIO: '+'</b> '+v.condominio+'</td>';
                    solicitudes += '<td>'+'<b>'+'LOTE: '+'</b> '+v.lote+'</td>';
                    solicitudes += '<td>'+'<b>'+'MONTO: '+'</b> $'+formatMoney(v.pago_cliente)+'</td>';
                    solicitudes += '<td>'+'<b>'+'USUARIO: '+'</b> '+v.usuario+'</td>';
                    solicitudes += '</tr>';
                });          

                return solicitudes += '</table>';
            }

            /*$("#tabla_factura tbody").on("click", ".enviar_internomex", function(){
                id_usuario = $(this).val();
                id_residencial = $(this).attr("data-value");
                user_factura = $(this).attr("data-userfactura");
                
                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de enviar las comisiones de <b>'+user_factura+'</b> a Internomex?</p></div></div>');

                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_usuario" value="'+id_usuario+'"><input type="hidden" name="id_residencial" value="'+id_residencial+'">');

                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="Enviar"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button></div></div>');
                $("#modal_nuevas").modal();
            });*/

            $("#tabla_factura tbody").on("click", ".subirPDF", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                uuid = $(this).val();
                user_factura = $(this).attr("data-userfactura");
                xmlfname = $(this).attr("data-file");
                $("#seeInformationModalPDF").modal();

                $("#seeInformationModalPDF .modal-body").append(`
                <div class="input-group">
                    <input type="hidden" name="opc" id="opc" value="1">
                    <input type="hidden" name="uuid" id="uuid" value="${uuid}">
                    <input type="hidden" name="user" id="user" value="${user_factura}">
                    <input type="hidden" name="xmlfile" id="xmlfile" value="${xmlfname}">

                    <label  class="input-group-btn">
                    </label>
                    <span class="btn btn-primary">
                    <i class="fa fa-cloud-upload"></i> Subir archivo
                    <input id="file-uploadE" name="file-uploadE" required  accept="application/pdf" type="file"   / >
                    </span>
                    <p id="archivoE"></p>
                </div>`);

                $("#seeInformationModalPDF .modal-footer").append(`
                    <button type="submit" id="sendFile" class="btn btn-primary"><span
                    class="material-icons" >send</span> Guardar documento </button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);
            });

            $("#tabla_factura tbody").on("click", ".regresar", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                uuid = $(this).val();
                usuario = $(this).attr("data-userfactura");
                total = $(this).attr("data-total");
                id_user = $(this).attr("data-id_user");

                $("#seeInformationModalPDF").modal();
                $("#seeInformationModalPDF .modal-body").append(`
                <div class="input-group">
                <input type="hidden" name="opc" id="opc" value="4">

                <input type="hidden" name="uuid2" id="uuid2" value="${uuid}">
                <input type="hidden" name="totalxml" id="totalxml" value="${total}">
                <input type="hidden" name="id_user" id="id_user" value="${id_user}">

                <h6>¿Estas seguro que deseas regresar esta factura de <b>${usuario}</b> por la cantidad de <b> $${formatMoney(total)}</b> ?</h6>
                <span>Motivo</span>
                <textarea id="motivo" name="motivo" class="form-control"></textarea>`);
        
                $("#seeInformationModalPDF .modal-body").append(`<div class="row">
                    <div class="col-md-12 col-lg-12 text-left"></div></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput" style='width:250px'>
                                <div>
                                    <br>
                                    <span class="fileinput-new">Selecciona archivo XML</span>
                                    <input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml" style='width:250px'>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <button class="btn btn-warning" type="button" onclick="xml2(${id_user})" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y <br> CARGAR</button>
                        </div>
                    </div>`);
                    
                $("#seeInformationModalPDF .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                $("#seeInformationModalPDF .modal-body").append(
                    '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                    '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                    '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                    '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                    ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"> </div></div>');

                $("#seeInformationModalPDF .modal-footer").append(`<button type="submit" id="sendFile" class="btn btn-primary"> Aceptar</button><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);
            });

            /**----------------------------------------------------------------- */
            /*$("#tabla_factura tbody").on("click", ".regresarPago", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                idpago = $(this).val();
                usuario = $(this).attr("data-userfactura");
                total = $(this).attr("data-total");
                lote =    $(this).attr("data-lote");  
                $("#seeInformationModalPDF").modal();
                $("#seeInformationModalPDF .modal-body").append(`<div class="input-group">
                    <input type="hidden" name="opc" id="opc" value="3">
                    <input type="hidden" name="id2" id="id2" value="${idpago}">
                    <h6>¿Estas seguro que deseas regresar este pago de <b>${formatMoney(total)}</b> con ID <b>${idpago}</b>, lote <b>${lote}</b> del usuario <b>${usuario}</b> ?</h6>
                    <span>Motivo</span>
                    <textarea id="motivo" name="motivo" class="form-control"></textarea>`);
        
                $("#seeInformationModalPDF .modal-footer").append(`<button type="submit" id="sendFile" class="btn btn-primary"> Aceptar</button><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);
            });*/

            /**--------------------------------------------------- */
            $("#tabla_factura tbody").on("click", ".consultar_documentos", function(e){
                $("#seeInformationModalfactura .modal-body").html("");

                e.preventDefault();
                e.stopImmediatePropagation();

                uuid = $(this).val();
                id_residencial = $(this).attr("data-value");
                user_factura = $(this).attr("data-userfactura");
                $("#seeInformationModalfactura").modal();
                $.getJSON( url + "Comisiones/getDatosFactura/"+uuid+"/"+id_residencial).done( function( data ){
                    $("#seeInformationModalfactura .modal-body").append('<div class="row">');
                    let uuid,fecha,folio,tot,descripcion;
                    if (!data.datos_solicitud['uuid'] == '' && !data.datos_solicitud['uuid'] == '0'){
                        $.get(url+"Comisiones/GetDescripcionXML/"+data.datos_solicitud['nombre_archivo']).done(function (dat) {
                            let datos = JSON.parse(dat);
                            uuid = datos[0][0];
                            fecha = datos[1][0];
                            folio = datos[2][0];
                            
                            tot = datos[3][0];
                            descripcion = datos[4];

                            $("#seeInformationModalfactura .modal-body").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> PROYECTO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+tot+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMISIÓN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+fecha+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');


                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+uuid+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+folio+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        
                            $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+descripcion+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        });
                    }
                    else {
                        $("#seeInformationModalfactura .modal-body").append('<div class="col-md-12"><label style="font-size:16px; margin:0; color:black;">NO HAY DATOS A MOSTRAR</label></div>');
                    }
                    $("#seeInformationModalfactura .modal-body").append('</div>');
                });
            });
        }
        //FIN TABLA  *****************************************************************
 
        // FUNCTION MORE
        /*$(document).on( "click", ".nuevo_plan", function(){
            $("#modal_mktd .modal-body").html("");
            $("#modal_mktd .modal-footer").html("");

            $.getJSON( url + "Comisiones/getDatosNuevo/").done( function( data1 ){
                $("#modal_mktd .modal-body").append('<div class="row"><div class="col-md-6"><label>Fecha inicio: </label><input type="date" class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" name="fecha_inicio" id="fecha_inicio" required=""></div></div>');

                $.each( data1, function( i, v){
                    $("#modal_mktd .modal-body").append('<div class="row">'
                            +'<div class="col-md-3"><br><input class="form-contol ng-invalid ng-invalid-required" style="border: 1px solid white; outline: none;" value="'+v.puesto+'"  readonly><input id="puesto" name="puesto[]" value="'+v.id_rol+'" type="hidden"></div>'

                            +'<div class="col-md-3"><select id="userMKTDSelect'+i+'" name="userMKTDSelect[]" class="form-control userMKTDSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                            +'<div class="col-md-2"><input id="porcentajeUserMk'+i+'" name="porcentajeUserMk[]" class="form-control porcentajeUserMk ng-invalid ng-invalid-required" required placeholder="%" value="0"></div>'

                            +'<div class="col-md-2"><select id="plazaMKTDSelect'+i+'" name="plazaMKTDSelect[]" class="form-control plazaMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                            +'<div class="col-md-2"><select id="sedeMKTDSelect'+i+'" name="sedeMKTDSelect[]" class="form-control sedeMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div></div>');

                            $.post('getUserMk', function(data) {
                            $("#userMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                            var len = data.length;
                            for( var j = 0; j<len; j++)
                            {
                                var id = data[j]['id_usuario'];
                                var name = data[j]['name_user'];
                                // var sede = data[i]['id_sede'];
                                // alert(name);
                                $("#userMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0)
                            {
                            $("#userMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            }
                            
                            $("#userMKTDSelect"+i+"").val(data1[i].id_usuario);                     
    
                            $("#userMKTDSelect"+i+"").selectpicker('refresh');
                        }, 'json');



                        $.post('getPlazasMk', function(data) {
                            $("#plazaMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                            var len = data.length;
                            for( var j = 0; j<len; j++)
                            {
                                var id = data[j]['id_opcion'];
                                var name = data[j]['nombre'];
                                // var sede = data[i]['id_sede'];
                                // alert(name);
                                $("#plazaMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0)
                            {
                            $("#plazaMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            }
                    
                                    $("#plazaMKTDSelect"+i+"").val(1); 
        
                            $("#plazaMKTDSelect"+i+"").selectpicker('refresh');
                        }, 'json');



                        $.post('getSedeMk', function(data) {
                            $("#sedeMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                            var len = data.length;
                            for( var j = 0; j<len; j++)
                            {
                                var id = data[j]['id_sede'];
                                var name = data[j]['nombre'];
                                
                                $("#sedeMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0)
                            {
                            $("#sedeMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            }
                            console.log(data1[i].id_sede);

                            if(data1[i].id_rol=='20'){
                                
                                $("#sedeMKTDSelect"+i+"").val(data1[i].id_sede);

                            }else{
                                    $("#sedeMKTDSelect"+i+"").val(2); 
                            }


                                // $("#sedeMKTDSelect"+i+"").val(data1[i].id_usuario);
                            $("#sedeMKTDSelect"+i+"").selectpicker('refresh');
                        }, 'json'); 
                });
            });

            $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" id="btnsubmit" class="btn btn-success" value="GUARDAR"></center></div></div>');
            $("#modal_mktd").modal();
        });*/

        function formatMoney( n ) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        /*$(document).on( "click", ".subir_factura", function(){
            resear_formulario();
            id_comision = $(this).val();
            link_post = "Comisiones/guardar_solicitud/"+id_comision;
            $("#modal_formulario_solicitud").modal( {backdrop: 'static', keyboard: false} );
            });*/

        //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
        function resear_formulario(){
            $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
            $("#modal_formulario_solicitud textarea").html('');

            $("#modal_formulario_solicitud #obse").val('');
    
            var validator = $( "#frmnewsol" ).validate();
            validator.resetForm();
            $( "#frmnewsol div" ).removeClass("has-error");

        }
 
        /*$("#cargar_xml").click( function(){
            subir_xml( $("#xmlfile") );
        });*/

        var justificacion_globla = "";

        /*function subir_xml( input ){
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data.respuesta[0] ){
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml( informacion_factura );
                        $("#solobs").val( justificacion_globla );
                    }
                    else{
                        input.val('');
                        alert( data.respuesta[1] );
                    }
                },
                error: function( data ){
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }*/

        /*function cargar_info_xml( informacion_factura ){
            $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
            $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);
            $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
            $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);
            $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);
            $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
            $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);
            $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);
            $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);
            $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);
            $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);
            $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
        }*/

        $("#form_colaboradores").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                $('#loader').removeClass('hidden');
                var data = new FormData( $(form)[0] );
                let sumat=0;
                let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
                let valor1 = parseFloat(valor-0.10);
                let valor2 = parseFloat(valor)+0.010;
            
                for(let i=0;i<$('#cuantos').val();i++){
                    sumat += parseFloat($('#abono_marketing_'+i).val());
                }
                
                let sumat2 =  parseFloat((sumat).toFixed(3));
                document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';
                if(parseFloat(sumat2.toFixed(3)) < valor1){
                    alerts.showNotification("top", "right", "Falta dispersar", "warning");
                }
                else{
                    if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
                        $.ajax({
                            url: url2 + "Comisiones/nueva_mktd_comision",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            method: 'POST',
                            type: 'POST', // For jQuery < 1.9
                            success: function(data){
                                if(true){
                                    $('#loader').addClass('hidden');
                                    $("#modal_colaboradores").modal('toggle');
                                    plaza_2.ajax.reload();
                                    plaza_1.ajax.reload();
                                    alert("¡Se agregó con éxito!");
                                }else{
                                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                                    $('#loader').addClass('hidden');
                                }
                            },error: function( ){
                                alert("ERROR EN EL SISTEMA");
                            }
                        });
                    }
                    else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
                        alerts.showNotification("top", "right", "Cantidad excedida", "danger");
                    }
                }
            }
        });

        $("#frmnewsol").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                data.append("xmlfile", documento_xml);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data.resultado ){
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal( 'toggle' );
                            tabla_nuevas.ajax.reload();
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },error: function(){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });          

        $("#form_MKTD").submit( function(e) {
            e.preventDefault();        
        }).validate({
            rules: {
                'porcentajeUserMk[]':{
                    required: true,
                }
            },
            messages: {
                'porcentajeUserMk[]':{
                    required : "Dato requerido"
                }
            },
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                $.ajax({
                    url: url + "Comisiones/save_new_mktd",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data.resultado ){
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                                $("#modal_mktd").modal( 'toggle' );
                            //  tabla_nuevas.ajax.reload();
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },error: function(){
                        alert("ERROR EN EL SISTEMA");
                    }
                });   
            }
        });

        /*function calcularMontoParcialidad() {
            $precioFinal = parseFloat($('#value_pago_cliente').val());
            $precioNuevo = parseFloat($('#new_value_parcial').val());
            if ($precioNuevo >= $precioFinal) {
                $('#label_estado').append('<label>MONTO NO VALIDO</label>');
            }
            else if ($precioNuevo < $precioFinal) {
                $('#label_estado').append('<label>MONTO VALIDO</label>');
            }
        }*/

        /*function preview_info(archivo){
            $("#documento_preview .modal-dialog").html("");
            $("#documento_preview").css('z-index', 9999);
            archivo = url+"dist/documentos/"+archivo+"";
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(archivo)[1];
            elemento = "";
            if (ext == 'pdf'){
                elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
                elemento += '</iframe>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if(ext == 'jpg' || ext == 'jpeg'){
                elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
                elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if(ext == 'xlsx'){
                elemento += '<div class="modal-content">';
                elemento += '<iframe src="'+archivo+'"></iframe>';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
            }
        }*/
 
        function cleanComments() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }

        $(window).resize(function(){
            plaza_1.columns.adjust();
            plaza_2.columns.adjust();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

    </script>

    <script>
        $(document).ready( function(){
            $.getJSON( url + "Comisiones/report_plazas").done( function( data ){
                $(".report_plazas").html();
                $(".report_plazas1").html();
                $(".report_plazas2").html();
                if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
                    if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                        $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    }
                    else{
                        $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
                    }
                }
                if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
                    if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                        $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    }
                    else{
                        $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
                    }
                }
                if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
                    if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                        $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    }
                    else{
                        $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
                    }
                }
            });
        });                                               
    </script>
</body>