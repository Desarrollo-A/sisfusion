<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;
            $this->load->view('template/sidebar', $datos);
        
        ?>

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
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones nuevas <b>asimilados</b></h3>
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
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
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
                                                                <th>ID PAGO</th>
                                                                <th>REFERENCIA</th>
                                                                <th>NOMBRE</th>
                                                                <th>SEDE</th>
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
        $('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_asimilados.column(i).search() !== this.value) {
                        tabla_asimilados.column(i).search(this.value).draw();

                        var total = 0;
                        var index = tabla_asimilados.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                        var data = tabla_asimilados.rows(index).data();
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

        $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function(i, v) {
                total += parseFloat(v.impuesto);
            });
            var to = formatMoney(total);
            document.getElementById("totpagarAsimilados").textContent = '$' + to;
        });

        tabla_asimilados = $("#tabla_asimilados").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [{
                text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
                action: function() {
                    if ($('input[name="idTQ[]"]:checked').length > 0) {
                        
                        $('#spiner-loader').removeClass('hide');
                        var idcomision = $(tabla_asimilados.$('input[name="idTQ[]"]:checked')).map(function() {
                            return this.value;
                        }).get();
                        
                        var com2 = new FormData();
                        com2.append("idcomision", idcomision); 
                        
                        $.ajax({
                            url : url2 + 'Comisiones/acepto_internomex_asimilados/',
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
                                    $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='<?= base_url('dist/img/send_intmex.gif')?>'><p style='color:#676767;'>Comisiones de esquema <b>asimilados</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>");
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
                title: 'ASIMILADOS COMISIONES',
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
                    return '<p class="m-0"><b>' + d.nombreComisionista + '</b></p>';
                }
            },
            {
                "width": "5%",
                "data": function(d) {
                    return '<p class="m-0"><b>' + d.sede + '</b></p>';
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
                    return '<p class="m-0"><b>' + d.estatus + '</b></p>';
                }
            },
            {
                "width": "5%",
                "orderable": false,
                "data": function( data ){
                    var BtnStats;
                    
                    BtnStats = '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Historial">' +'<i class="fas fa-info"></i></button>'+
                    '<button href="#" value="'+data.id_pago_suma+'" data-value="'+data.id_pago_suma+'" class="btn-data btn-warning cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-ban"></i></button>';
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
                            return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';
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
                url: general_base_url + "Suma/getAsimiladosRevision",
                type: "POST",
                dataType: 'json',
                dataSrc: ""
            },
        });

        $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            id_pago = $(this).val();
            referencia = $(this).attr("data-referencia");

            $("#seeInformationModalAsimilados").modal();
            $("#nameLote").html("");
            $("#comments-list-asimilados").html("");
            $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
            $.getJSON("getHistorial/"+id_pago).done( function( data ){
                $.each( data, function(i, v){
                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
                });
            });
        });

        $("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
            var tr = $(this).closest('tr');
            var row = tabla_asimilados.row( tr );
            id_pago_i = $(this).val();

            console.log(id_pago_i);
            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p class="text-center">¿Estás seguro de pausar la comisión con referencia <b>'+row.data().referencia+'</b> para <b>'+(row.data().nombreComisionista).toUpperCase()+'</b>?</p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="1"><input type="text" class="form-control input-gral observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
            $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+id_pago_i+'">');
            $("#modal_nuevas .modal-body").append('<div class="row mt-3"><div class="col-md-6"></div><div class="col-md-3"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div></div>');
            $("#modal_nuevas").modal();
        });
        
         //Función para pausar la solicitud
         $("#form_interes").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url + "Suma/despausar_solicitud/",
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
        });
    </script>
</body>
