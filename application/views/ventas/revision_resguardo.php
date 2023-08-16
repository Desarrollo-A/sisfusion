<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                        
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles" name="roles" id="roles" required>
                                    <option value="">----Seleccionar-----</option> 
                                    <option value="1">Director</option> 
                                    <option value="2">Sub director</option>
                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control select2 js-example-theme-multiple" style="width: 100%; height:auto;"  required data-live-search="true"></select>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>   
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalremanente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsremanente()">clear</i>
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
                                                    <ul class="timeline timeline-simple" id="comments-list-remanente"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsremanente()"><b>Cerrar</b></button>
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

        <div class="modal fade modal-alertas" id="modal_despausar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" id="form_despausar">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_refresh" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" id="form_refresh">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalTQro" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body"></div>
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
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones resguardo</h3>
                                    <p class="card-title pl-1">(Comisiones solictadas por colaboradores de sudirección y dirección de ventas)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarremanente" id="totpagarremanente">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" id="totpagarPen" name="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label className="m-0" for="filtro33">Directivo</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un usuario" data-size="7" required>
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group select-gral">
                                                    <label className="m-0" for="filtro44">Proyecto</label>
                                                    <select class="selectpicker" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un proyecto" data-size="7" required/></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_resguardo" name="tabla_resguardo">
                                                <thead>
                                                    <tr> 
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>PROY.</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>REFERENCIA.</th>
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
        var id_user_session = "<?=$this->session->userdata('id_usuario')?>"

        function cleanCommentsremanente() {
            var myCommentsList = document.getElementById('comments-list-remanente');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }

        $(document).ready(function() {
            $("#tabla_resguardo").prop("hidden", true);

            var url = "<?=base_url()?>/index.php/";
            $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#filtro3").selectpicker('refresh');
            }, 'json');

            $.post("<?=base_url()?>index.php/Comisiones/getDirectivos", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['nombre'];
                    if(id_user_session == 1875 ){
                        if(id == 2){
                            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                        }
                    }
                    else{
                        $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                }
                $("#filtro33").selectpicker('refresh');
            }, 'json');
        });


        $('#filtro33').change(function(ruta){
            residencial = $('#filtro33').val();
            $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Contratacion/lista_proyecto/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++){
                        var id = response[i]['idResidencial'];
                        var name = response[i]['descripcion'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }

                    $("#filtro44").selectpicker('refresh');
                }
            });
        });

        $('#filtro3').change(function(ruta){
            proyecto = $('#filtro3').val();
            condominio = $('#filtro4').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            getInvoiceCommissions(proyecto, condominio);
        });

        $('#filtro4').change(function(ruta){
            proyecto = $('#filtro3').val();
            condominio = $('#filtro4').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0;
            }
            getInvoiceCommissions(proyecto, condominio);
        });


        $('#filtro33').change(function(ruta){
            proyecto = $('#filtro33').val();
            condominio = $('#filtro44').val();
            if(condominio == '' || condominio == null || condominio == undefined){
                condominio = 0; 
            }

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

        $('#filtro333').change(function(ruta){
            proyecto = $('#filtro333').val();
            getHistoryCommissions(proyecto);
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
        var tabla_resguardo2 ;
        var totaPen = 0;
        
        //INICIO TABLA QUERETARO************************************************
        let titulos = [];
        $('#tabla_resguardo thead tr:eq(0) th').each( function (i) {
            if(i != 17){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_resguardo2.column(i).search() !== this.value) {
                        tabla_resguardo2
                            .column(i)
                            .search(this.value)
                            .draw();
                        var total = 0;
                        var index = tabla_resguardo2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_resguardo2.rows(index).data();
                    }
                });
            }
        });

        function getAssimilatedCommissions(proyecto, condominio){
            $('#tabla_resguardo').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });

                var to = formatMoney(total);
                document.getElementById("totpagarremanente").textContent = to;
            });

            $("#tabla_resguardo").prop("hidden", false);
            tabla_resguardo2 = $("#tabla_resguardo").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'RESGUARDOS_COMISIONES',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
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
                                    return 'EMPRESA';
                                }else if(columnIdx == 7){
                                    return 'TOT. COMISIÓN';
                                }else if(columnIdx == 8){
                                    return 'P. CLIENTE';
                                }else if(columnIdx == 9){
                                    return 'A PAGAR';
                                }else if(columnIdx == 10){
                                    return 'TIPO VENTA';
                                }else if(columnIdx == 11){
                                    return 'USUARIO';
                                }else if(columnIdx == 12){
                                    return 'PUESTO';
                                }else if(columnIdx == 13){
                                    return 'FECHA ENVIO';
                                }
                                else if(columnIdx != 14 && columnIdx !=0){
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
                    "width": "2%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },   
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_pago_i+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "8%",
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
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.referencia+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.empresa+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        if(d.lugar_prospeccion == 0){
                            return '<p class="m-0" style="color:red;">VENTA CANCELADA <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';

                        }
                        else if(d.lugar_prospeccion == 6){
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
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><i> '+d.puesto+'</i></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        var BtnStats1;
                        BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                        return BtnStats1;
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function( data ){

                        var BtnStats;
                        if(id_user_session == 1875 || id_user_session == 10894){
                            BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_remanente" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        }
                        else{
                            BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_remanente" title="Detalles">' +'<i class="fas fa-info"></i></button>'+

                            '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-warning cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-ban"></i></button>';
                        }
                        
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    searchable:false,
                    className: 'dt-body-center',
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosResguardoContraloria/" + proyecto + "/" + condominio,
                    type: "POST",
                    cache: false,
                    data: function( d ){
                    }
                },
            });

            $('#tabla_resguardo tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_1.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
                }
                else {
                    $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                }
            });

            $("#tabla_resguardo tbody").on("click", ".consultar_logs_remanente", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalremanente").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-remanente").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });

            $('#tabla_resguardo').on('click', 'input', function() {
                tr = $(this).closest('tr');

                var row = tabla_resguardo2.row(tr).data();
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

            $("#tabla_resguardo tbody").on("click", ".cambiar_estatus", function(){
                var tr = $(this).closest('tr');
                var row = tabla_resguardo2.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se pauso la solicitud"></input></div></div>');
                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_nuevas").modal();
            });

            $("#tabla_resguardo tbody").on("click", ".despausar_estatus", function(){
                var tr = $(this).closest('tr');
                var row = tabla_resguardo2.row( tr );
                id_pago_i = $(this).val();
                $("#modal_refresh .modal-body").html("");
                $("#modal_refresh .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro regresar al estatus inicial la comisión  de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
                $("#modal_refresh .modal-body").append('<input class="idComPau" name="id_comision" type="text" value="'+row.data().id_comision+'" hidden>');
                $("#modal_refresh .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_refresh").modal();
            });

            $("#tabla_resguardo tbody").on("click", ".consultar_documentos", function(){
                id_com = $(this).val();
                id_pj = $(this).attr("data-personalidad");

                $("#seeInformationModal").modal();
                $.getJSON( url + "Comisiones/getDatosDocumentos/"+id_com+"/"+id_pj).done( function( data ){
                    $.each( data, function( i, v){
                        $("#seeInformationModal .documents").append('<div class="row">');
                        if (v.estado == "NO EXISTE"){
                            $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">'+(v.nombre).substr(0, 52)+'</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
                        }
                        else{
                            $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
                        }

                        $("#seeInformationModal .documents").append('</div>');
                    });
                });

                $.getJSON( url + "Comisiones/getDatosFactura/"+id_com).done( function( data ){
                    $("#seeInformationModal .facturaInfo").append('<div class="row">');
                    
                    if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){

                        $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    }
                    else {
                        $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
                    }

                    $("#seeInformationModal .facturaInfo").append('</div>');
                });
            });
        }

        //FIN TABLA  ****************************************************************************************
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        $(window).resize(function(){
            tabla_resguardo2.columns.adjust();
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
                    url: url + "Comisiones/pausar_solicitud/",
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
                                tabla_resguardo2.ajax.reload();
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
        });

        //Función para regresar a estatus 7 la solicitud
        $("#form_refresh").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
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
                                tabla_resguardo2.ajax.reload();
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
        });

        $("#form_despausar").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url + "Comisiones/despausar_solicitud/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data[0] ){
                            $("#modal_despausar").modal('toggle' );
                            alerts.showNotification("top", "right", "Se ha regresado la comisión exitosamente", "success");
                            setTimeout(function() {
                                tabla_resguardo2.ajax.reload();
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
        });

        /*$(document).on("click", ".btn-historial-lo", function(){
            window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
        });*/

        function preview_info(archivo){
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
        }

        /*function cleanComments(){
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }*/


        $("#roles").change(function() {
            var parent = $(this).val();
            document.getElementById('monto').value = ''; 
            document.getElementById('idmontodisponible').value = ''; 
            $('#usuarioid option').remove();
            $.post('getUsuariosRol/'+parent, function(data) {
                $("#usuarioid").append($('<option>').val("0").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
            
                    $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if(len<=0){
                    $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                
                $("#usuarioid").selectpicker('refresh');
            }, 'json'); 
        });

        $("#idloteorigen").select2({dropdownParent:$('#miModal')});

        $("#usuarioid").change(function() {
            document.getElementById('monto').value = ''; 
            document.getElementById('idmontodisponible').value = ''; 
            var user = $(this).val();
            
            $('#idloteorigen option').remove(); // clear all values
            $.post('getLotesOrigenResguardo/'+user, function(data) {
                $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"));
                var len = data.length;
            
                for( var i = 0; i<len; i++)
                {
                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];

                    
                    $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)}'>${name}  -   $${ formatMoney(comtotal.toFixed(2))}</option>`);
                }
                if(len<=0)
                {
                $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#idloteorigen").selectpicker('refresh');
            }, 'json'); 
        });
        
        $("#idloteorigen").change(function() {
            let cuantos = $('#idloteorigen').val().length;
            let suma =0;
            if(cuantos > 1){
                var comision = $(this).val();
                for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                    datos = comision[index].split(',');
                    let id = datos[0];
                    let monto = datos[1];
                    document.getElementById('monto').value = ''; 

                    $.post('getInformacionDataResguardo/'+id, function(data) {
                        var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                        var idecomision = data[0]['id_pago_i'];
                        suma = suma + disponible;
                        document.getElementById('montodisponible').innerHTML = '';
                        $("#idmontodisponible").val('$'+formatMoney(suma));
                        $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma.toFixed(2)+'">');
                        $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                            
                        var len = data.length;
                        if(len<=0){
                            $("#idmontodisponible").val('$'+formatMoney(0));
                        }
                
                        $("#montodisponible").selectpicker('refresh');
                    }, 'json');
                }
            }
            else{
                var comision = $(this).val();
                datos = comision[0].split(',');
                let id = datos[0];
                let monto = datos[1];
                alert(id+'-------'+monto);

                document.getElementById('monto').value = ''; 
                $.post('getInformacionDataResguardo/'+id, function(data) {
                    var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                
                    document.getElementById('montodisponible').innerHTML = '';
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
                    $("#idmontodisponible").val('$'+formatMoney(disponible));
                
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                    var len = data.length;
                
                    if(len<=0){
                        $("#idmontodisponible").val('$'+formatMoney(0));
                    }
                    
                    $("#montodisponible").selectpicker('refresh');
                }, 'json'); 
            }
        });

        /*$("#numeroP").change(function(){
    
            let monto = parseFloat($('#monto').val());
            let cantidad = parseFloat($('#numeroP').val());
            let resultado=0;

            if (isNaN(monto)) {
                alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
                $('#pago').val(resultado);
                document.getElementById('btn_abonar').disabled=true;
            }
            else{
                resultado = monto /cantidad;
                if(resultado > 0){
                    document.getElementById('btn_abonar').disabled=false;
                    $('#pago').val(formatMoney(resultado));
                }
                else{
                    document.getElementById('btn_abonar').disabled=true;
                    $('#pago').val(formatMoney(0));
                }
            }
        });*/

        function verificar(){
            let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
            let monto = parseFloat($('#monto').val()).toFixed(2);
            if(monto < 1 || isNaN(monto)){
                alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
                document.getElementById('btn_abonar').disabled=true; 
            }
            else{
                if(parseFloat(monto) <= parseFloat(disponible) ){
                    let cantidad = parseFloat($('#numeroP').val());
                    resultado = monto /cantidad;
                    $('#pago').val(formatMoney(resultado));
                    document.getElementById('btn_abonar').disabled=false;

                    let cuantos = $('#idloteorigen').val().length;
                    let cadena = '';
                    var data = $('#idloteorigen').select2('data')
                    for (let index = 0; index < cuantos; index++) {
                        cadena = cadena+' , '+data[index].text;
                    }
                    
                    $('#comentario').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: $'+formatMoney(monto));
                }
                else if(parseFloat(monto) > parseFloat(disponible) ){
                    alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                    
                    document.getElementById('monto').value = ''; 
                    document.getElementById('btn_abonar').disabled=true; 
                }
            }
        }
    </script>
</body>
