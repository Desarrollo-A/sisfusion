<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
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


        <!--<div class="modal fade modal-alertas" id="modal_refresh" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_refresh">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <div class="modal fade modal-alertas" id="modal_multiples" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <form method="post" id="form_multiples">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
 

        <!--<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>-->


        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>


        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">            
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones nuevas <b>asimiliados</b></h3>
                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de asimilados)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarAsimilados" id="totpagarAsimilados">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" id="totpagarPen" name="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row aligned-row d-flex align-end">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro33">Puesto</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un puesto" data-size="7" required> 
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro44">Usuario</label>
                                                    <select class="selectpicker select-gral" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un usuario" data-size="7" required/></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                                                <div class="form-group w-100">
                                                    <button type="button" class="btn-gral-data Pagar">Pagar masivamente</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
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
                                                        <th>SOLICITADO</th>
                                                        <th>IMPTO.</th>
                                                        <th>DESCUENTO</th>
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

        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }


        $(document).ready(function() {
            $("#tabla_asimilados").prop("hidden", true);
            $.post("<?=base_url()?>index.php/Comisiones/lista_roles", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_opcion'];
                    var name = data[i]['nombre'];
                    $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#filtro33").selectpicker('refresh');
            }, 'json');

        });

        $('#filtro33').change(function(ruta){
            residencial = $('#filtro33').val();
            $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Comisiones/lista_usuarios/'+residencial+"/"+3,
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
        var tabla_asimilados2 ;
        var totaPen = 0;
        //INICIO TABLA QUERETARO*********************
        let titulos = [];
    

        $('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_asimilados2.column(i).search() !== this.value) {
                        tabla_asimilados2
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_asimilados2.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                        var data = tabla_asimilados2.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.impuesto);
                        });

                        var to1 = formatMoney(total);
                        document.getElementById("totpagarAsimilados").textContent = formatMoney(total);
                    }
                });
            } 
            else {
                $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
            }
        });

        function getAssimilatedCommissions(proyecto, condominio){
            $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("totpagarAsimilados").textContent = '$' + to;
            });

            $("#tabla_asimilados").prop("hidden", false);
            tabla_asimilados2 = $("#tabla_asimilados").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
                    action: function() {
                        if ($('input[name="idTQ[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            var idcomision = $(tabla_asimilados2.$('input[name="idTQ[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            
                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 
                            $.ajax({
                                url : url2 + 'Comisiones/pago_internomex/',
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
                                        tabla_asimilados2.ajax.reload();
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='<?= base_url('dist/img/send_intmex.gif')?>'><p style='color:#676767;'>Comisiones de esquema <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.</p></center>");
                                    } else {
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
                    title: 'ASIMILADOS_INTERNOMEX_COMISIONES',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
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
                                    return 'SOLICITADO';
                                }else if(columnIdx == 11){
                                    return 'IMPUESTO';
                                }else if(columnIdx == 12){
                                    return 'DESCUENTO';
                                }else if(columnIdx == 13){
                                    return 'TOT. PAGAR';
                                }else if(columnIdx == 14){
                                    return 'TIPO VENTA';
                                }else if(columnIdx == 15){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 16){
                                    return 'PUESTO';
                                }else if(columnIdx == 17){
                                    return 'FECH. ENVÍO';
                                } else if(columnIdx != 18 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
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
                    "width": "3%" 
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_pago_i+'</p>';
                    }
                },
                {
                    "width": "3%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.lote+'</b></p>';
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
                    "width": "3%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.empresa+'</p>';
                    }
                },
                {
                    "width": "5%",
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
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_cliente)+'</p>';
                    }
                },
                {
                    "width": "3%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+formatMoney(d.valimpuesto)+'%</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.dcto)+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
                    }
                },
                {
                    "width": "8%",
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
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
                    }
                },

                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0"><i> '+d.puesto+'</i></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        var BtnStats1;
                        if(d.estatus == 8){
                            BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                        }
                        else{
                            BtnStats1 =  '<p style="color:red;"><B>PAUSADA</B></p>';
                        }
                        return BtnStats1;

                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function( data ){
                        var BtnStats;
                        if(data.estatus == 8){
                            BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>'+

                            '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-orangeYellow cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-pause"></i></button>';
                        }
                        else{
                            BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>'+
                            '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-green regresar_estatus" title="Activar solicitud">' + '<i class="fas fa-play"></i></button>';
                        }
                        return '<div class="d-flex">'+ BtnStats +'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable:false,
                    className: 'dt-body-center',
                    render: function (d, type, full, meta){
                        if(full.estatus == 8){
                            if(full.id_comision){
                                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            }else{
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
                    url: url2 + "Comisiones/getDatosNuevasAContraloria/" + proyecto + "/" + condominio,
                    type: "POST",
                    cache: false,
                    data: function( d ){
                    }
                },
            });
        
            $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
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

            $("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
                var tr = $(this).closest('tr');
                var row = tabla_asimilados2.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="88"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_nuevas").modal();
            });

            $("#tabla_asimilados tbody").on("click", ".regresar_estatus", function(){
                var tr = $(this).closest('tr');
                var row = tabla_asimilados2.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="8"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_nuevas").modal();
            });

            /**--------------------------------------------------------------------------------------------- */
 
        }

        //FIN TABLA  ****************************************************************************************
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        $(window).resize(function(){
            tabla_asimilados2.columns.adjust();
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

        /*function cancela(){
            $("#modal_nuevas").modal('toggle');
        }*/

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
                            alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                            setTimeout(function() {
                                tabla_asimilados2.ajax.reload();
                                // tabla_otras2.ajax.reload();
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

        function CloseModalDelete2(){
            document.getElementById("form_multiples").reset();
            a = document.getElementById('borrarProyect');
            padre = a.parentNode;
            padre.removeChild(a);
            $("#modal_multiples").modal('toggle');  
        }

        $(document).on("click", ".Pagar", function() {          
            $("#modal_multiples .modal-body").html("");
            $("#modal_multiples .modal-header").html("");
            $("#modal_multiples .modal-header").append('<h4 class="card-title"><b>Marcar pagadas</b></h4>');
            $("#modal_multiples .modal-footer").append(`<div class="row" id="borrarProyect"><center><input type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button></center></div>`);

            $("#modal_multiples .modal-header").append(`<div class="row">
            <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);
            $.post('getDesarrolloSelectINTMEX/'+3, function(data) {
                $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
                    $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if (len <= 0) {
                    $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#desarrolloSelect").val(0);
                $("#desarrolloSelect").selectpicker('refresh');
            }, 'json');
                
            $('#desarrolloSelect').change(function() {
                $("#modal_multiples .modal-body .bodypagos").html("");
                if(document.getElementById('bodypago2')){
                    let a =  document.getElementById('bodypago2');
                    padre = a.parentNode;
                    padre.removeChild(a);
                }
            
                var valorSeleccionado = $(this).val();
                var combo = document.getElementById("desarrolloSelect");
                var selected = combo.options[combo.selectedIndex].text;

                $.getJSON(url + "Comisiones/getPagosByProyect/"+valorSeleccionado+"/"+3).done(function(data) {
                    let sumaComision = 0;
                    console.log(data[0]);
                    if (!data) {
                        $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');

                    } 
                    else {
                        if(data.length > 0){
                            $("#modal_multiples .modal-body ").append(`<div class="row bodypagos" >
                            <p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $<b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div>`);
                        } 
                        
                        $("#modal_multiples .modal-body ").append(`<div  id="bodypago2"></div>`);
                        $.each(data[1], function(i, v) {
                            $("#modal_multiples .modal-body #bodypago2").append(`
                            <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                            
                        });
                        document.getElementById('btn-aceptar').disabled = false;
                    }
                });
            });

            $("#modal_multiples").modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        //Función para regresar a estatus 7 la solicitud
        /*$("#form_refresh").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url + "Comisiones/refresh_solicitud/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data[0] ){
                            $("#modal_refresh").modal('toggle' );
                            alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                            setTimeout(function() {
                                tabla_asimilados2.ajax.reload();
                            }, 3000);
                        }
                        else{
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });*/

        /*$(document).on("click", ".btn-historial-lo", function(){
            window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
        });*/


        /*function cleanComments(){
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }*/

        function selectAll(e) {
            tota2 = 0;
            $(tabla_asimilados2.$('input[type="checkbox"]')).each(function (i, v) {
                if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    tota2 += parseFloat(tabla_asimilados2.row($(this).closest('tr')).data().impuesto);
                } else {
                    $(this).prop("checked", false);
                }
                $("#totpagarPen").html('$' + formatMoney(tota2));
            });
        }
    </script>

    <script>
        /*$(document).ready( function(){
            $.getJSON( url + "Comisiones/getReporteEmpresa").done( function( data ){
                $(".report_empresa").html();
                $.each( data, function( i, v){
                    $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
                });
            });
        });*/

        $("#form_multiples").submit( function(e) {
            $('#spiner-loader').removeClass('hidden');
            e.preventDefault();
        }).validate({

            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                $.ajax({
                    url: url + "Comisiones/IntMexPagadosByProyect",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data == 1){
                            CloseModalDelete2();
                            alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                        }else{
                            CloseModalDelete2();
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                        }
                        $('#spiner-loader').addClass('hidden');

                    },error: function( ){
                        CloseModalDelete2();
                        alert("ERROR EN EL SISTEMA");
                        $('#spiner-loader').addClass('hidden');

                    }
                });
            }
        });
    </script>
</body>