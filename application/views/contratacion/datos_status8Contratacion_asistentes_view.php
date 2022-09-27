<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php
        /*-------------------------------------------------------*/
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;  
        $this->load->view('template/sidebar', $datos);
        /*--------------------------------------------------------*/
        ?>

        <!-- Modals -->

        <!-- modal  ENVIA A CONTRALORIA 7-->
        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A CONTRALORIA 7-->
        <div class="modal fade" id="editLoteRev" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario2" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save2" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  rechazar A CONTRALORIA 7-->
        <div class="modal fade" id="rechReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo/regreso estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario3" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save3" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  rechazar A asesor 7-->
        <div class="modal fade" id="rechazoAs" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario4" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save4" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A CONTRALORIA 7-->
        <div class="modal fade" id="rev8" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario5" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save5" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A CONTRALORIA 7-->
        <div class="modal fade" id="rev_2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 8 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario6" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save6" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
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
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Registro de estatus 8</h3>
                                    <p class="card-title pl-1">(Contrato entregado al asesor para firma del cliente)</p>
                                </div>
                                <div class="material-datatables"> 
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="Jtabla" name="Jtabla">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>GERENTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>ESTATUS ACTUAL</th>
                                                        <?php
                                                        if($this->session->userdata('id_rol')!=53){
                                                        ?>
                                                        <th>ACCIONES</th>
                                                    <?php 
                                                    }
                                                    ?>
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

        var idlote_global = 0;


        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";

        var getInfo1 = new Array(7);
        var getInfo2 = new Array(7);
        var getInfo3 = new Array(7);
        var getInfo4 = new Array(7);
        var getInfo5 = new Array(7);
        var getInfo6 = new Array(7);


        $("#Jtabla").ready( function(){

                $('#Jtabla thead tr:eq(0) th').each( function (i) {

                if(i != 0 && i != 8){
                    var title = $(this).text();
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if (tabla_6.column(i).search() !== this.value ) {
                            tabla_6
                            .column(i)
                            .search(this.value)
                            .draw();
                        }
                    } );
                }
            });
            
            let titulos = [];
            $('#Jtabla thead tr:eq(0) th').each( function (i) {
                if( i!=0 && i!=13){
                    var title = $(this).text();
                    titulos.push(title);
                }
            });

            tabla_6 = $("#Jtabla").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header:  function (d, columnIdx) {
                            if(columnIdx == 0){
                                return ' '+d +' ';
                                }
                            
                                        return ' '+titulos[columnIdx-1] +' ';
                                
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
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
                    "data": function( d ){
                        var lblStats;
                        if(d.tipo_venta==1) {
                            lblStats ='<span class="label label-danger">Venta Particular</span>';
                        }
                        else if(d.tipo_venta==2) {
                            lblStats ='<span class="label label-success">Venta normal</span>';
                        }
                        else if(d.tipo_venta==3) {
                            lblStats ='<span class="label label-warning">Bono</span>';
                        }
                        else if(d.tipo_venta==4) {
                            lblStats ='<span class="label label-primary">Donación</span>';
                        }
                        else if(d.tipo_venta==5) {
                            lblStats ='<span class="label label-info">Intercambio</span>';
                        }
                        else if(d.tipo_venta==6) {
                            lblStats ='<span class="label label-info">Reubicación</span>';
                        }
                        else if(d.tipo_venta==7) {
                            lblStats ='<span class="label label-info">Venta especial</span>';
                        }
                        else if(d.tipo_venta== null) {
                            lblStats ='<span class="label label-info"></span>';
                        }
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreResidencial+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';

                    }
                }, 
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.gerente+'</p>';
                    }
                }, 
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreCliente+'</p>';
                    }
                },
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.descripcion+'</p>';
                    }
                }
                <?php
                if($this->session->userdata('id_rol')!=53){
                ?>
                    , 
                    { 
                        "width": "40%",
                        "orderable": false,
                        "data": function( data ){
                            var cntActions;        
                            if(data.vl == '1') {
                                cntActions = 'En proceso de Liberación';
                            } 
                            else {
                                if (data.idStatusContratacion == 7 && data.idMovimiento == 64 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17)) {
                                    cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                    'class="btn-data btn-orangeYellow editReg2" title="Registrar estatus">' +
                                    '<i class="far fa-thumbs-up"></i></button>';

                                    cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'"  ' +
                                    'class="btn-data btn-warning cancelReg" title="Rechazo/regreso estatus (Jurídico)">' +
                                    '<i class="far fa-thumbs-down"></i></button>';

                                    cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                    'class="btn-data btn-orangeYellow cancelAs" title="Rechazo/regreso estatus (Asesor)">' +
                                    '<i class="far fa-thumbs-down"></i></button>';              
                                } 
                                else if ((data.idStatusContratacion == 7 && data.idMovimiento == 37 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 7 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 77 && data.perfil == 15)
                                || (data.idStatusContratacion == 11 && data.idMovimiento == 41 && data.perfil == 11)) {
                                    cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                    'class="btn-data btn-green editReg" title="Registrar estatus">' +
                                    '<i class="far fa-thumbs-up"></i></button>';

                                    cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'"  ' +
                                    'class="btn-data btn-warning cancelReg" title="Rechazo/regreso estatus (Jurídico)">' +
                                    '<i class="far fa-thumbs-down"></i></button>';

                                    cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                    'class="btn-data btn-orangeYellow cancelAs" title="Rechazo/regreso estatus (Asesor)">' +
                                    '<i class="far fa-thumbs-down"></i></button>';
                                }
                                else if (data.idStatusContratacion == 7 && data.idMovimiento == 66 && data.perfil == 11) {
                                    cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                    'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                    'class="btn-data btn-warning editLoteTo8" title="Registrar estatus">' +
                                    '<i class="far fa-thumbs-up"></i></button>';
                                } 
                                else {
                                    cntActions = 'N/A';
                                }
                            }
                            return '<div class="d-flex justify-center">'+cntActions+'</div>';
                        } 
                    }
                <?php 
                }
                ?>
                ],
                columnDefs: [{
                "searchable": false,
                "orderable": false,
                "targets": 0
                }],
                ajax: {
                    "url": '<?=base_url()?>index.php/Asistente_gerente/getStatus8ContratacionAsistentes',
                    "dataSrc": "",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },
            });

            $('#Jtabla tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_6.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } 
                else {
                    var status;
                    var fechaVenc;

                    if(row.data().idStatusContratacion==7 && row.data().idMovimiento==37){
                        status="Status 7 listo (Jurídico)";
                    }
                    else if(row.data().idStatusContratacion==7 && row.data().idMovimiento==7){
                        status="Status 7 listo con Modificaciones (Jurídico)";
                    } 
                    else if(row.data().idStatusContratacion==7 && row.data().idMovimiento==64){
                        status="Status 8 Rechazado (Contraloria)";
                    } 
                    else if(row.data().idStatusContratacion==7 && row.data().idMovimiento==66){
                        status="Status 8 Rechazado (Administración)";
                    } 
                    else if(row.data().idStatusContratacion==7 && row.data().idMovimiento==77){
                        status="Status 2 enviado a Revisión (Ventas)";
                    }

                    if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 37 ||
                        row.data().idStatusContratacion == 7 && row.data().idMovimiento == 7 ||
                        row.data().idStatusContratacion == 7 && row.data().idMovimiento == 64 ||
                        row.data().idStatusContratacion == 7 && row.data().idMovimiento == 77) {
                        fechaVenc = row.data().fechaVenc;
                    } else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66) {
                        fechaVenc = 'Vencido';
                    }

                    var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>INFORMACIÓN ADICIONAL</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>'+status+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>' + row.data().comentario + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha vencimiento: </b>' + fechaVenc + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha realizado: </b></label>' + row.data().modificado + '</div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>'+row.data().coordinador+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>'+row.data().asesor+'</label></div></div></div>';

                    row.child(informacion_adicional).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                }
            });

            $("#Jtabla tbody").on("click", ".editReg", function(e){
                e.preventDefault();

                getInfo1[0] = $(this).attr("data-idCliente");
                getInfo1[1] = $(this).attr("data-nombreResidencial");
                getInfo1[2] = $(this).attr("data-nombreCondominio");
                getInfo1[3] = $(this).attr("data-idcond");
                getInfo1[4] = $(this).attr("data-nomlote");
                getInfo1[5] = $(this).attr("data-idLote");
                getInfo1[6] = $(this).attr("data-fecven");
                getInfo1[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#editReg').modal('show');
            });


            $("#Jtabla tbody").on("click", ".editLoteRev", function(e){
                e.preventDefault();

                getInfo2[0] = $(this).attr("data-idCliente");
                getInfo2[1] = $(this).attr("data-nombreResidencial");
                getInfo2[2] = $(this).attr("data-nombreCondominio");
                getInfo2[3] = $(this).attr("data-idcond");
                getInfo2[4] = $(this).attr("data-nomlote");
                getInfo2[5] = $(this).attr("data-idLote");
                getInfo2[6] = $(this).attr("data-fecven");
                getInfo2[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#editLoteRev').modal('show');
            });


            $("#Jtabla tbody").on("click", ".cancelReg", function(e){
                e.preventDefault();

                getInfo3[0] = $(this).attr("data-idCliente");
                getInfo3[1] = $(this).attr("data-nombreResidencial");
                getInfo3[2] = $(this).attr("data-nombreCondominio");
                getInfo3[3] = $(this).attr("data-idcond");
                getInfo3[4] = $(this).attr("data-nomlote");
                getInfo3[5] = $(this).attr("data-idLote");
                getInfo3[6] = $(this).attr("data-fecven");
                getInfo3[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#rechReg').modal('show');
            });

            $("#Jtabla tbody").on("click", ".cancelAs", function(e){
                e.preventDefault();
                getInfo4[0] = $(this).attr("data-idCliente");
                getInfo4[1] = $(this).attr("data-nombreResidencial");
                getInfo4[2] = $(this).attr("data-nombreCondominio");
                getInfo4[3] = $(this).attr("data-idcond");
                getInfo4[4] = $(this).attr("data-nomlote");
                getInfo4[5] = $(this).attr("data-idLote");
                getInfo4[6] = $(this).attr("data-fecven");
                getInfo4[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#rechazoAs').modal('show');
            });


            $("#Jtabla tbody").on("click", ".editLoteTo8", function(e){
                e.preventDefault();
                getInfo5[0] = $(this).attr("data-idCliente");
                getInfo5[1] = $(this).attr("data-nombreResidencial");
                getInfo5[2] = $(this).attr("data-nombreCondominio");
                getInfo5[3] = $(this).attr("data-idcond");
                getInfo5[4] = $(this).attr("data-nomlote");
                getInfo5[5] = $(this).attr("data-idLote");
                getInfo5[6] = $(this).attr("data-fecven");
                getInfo5[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#rev8').modal('show');
            });
            
            
            $("#Jtabla tbody").on("click", ".editReg2", function(e){
                e.preventDefault();
                getInfo6[0] = $(this).attr("data-idCliente");
                getInfo6[1] = $(this).attr("data-nombreResidencial");
                getInfo6[2] = $(this).attr("data-nombreCondominio");
                getInfo6[3] = $(this).attr("data-idcond");
                getInfo6[4] = $(this).attr("data-nomlote");
                getInfo6[5] = $(this).attr("data-idLote");
                getInfo6[6] = $(this).attr("data-fecven");
                getInfo6[7] = $(this).attr("data-code");
                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#rev_2').modal('show');
            });
        });

        $(document).on('click', '#save1', function(e) {
            e.preventDefault();
            var comentario = $("#comentario").val();
            var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
            var dataExp1 = new FormData();
            dataExp1.append("idCliente", getInfo1[0]);
            dataExp1.append("nombreResidencial", getInfo1[1]);
            dataExp1.append("nombreCondominio", getInfo1[2]);
            dataExp1.append("idCondominio", getInfo1[3]);
            dataExp1.append("nombreLote", getInfo1[4]);
            dataExp1.append("idLote", getInfo1[5]);
            dataExp1.append("comentario", comentario);
            dataExp1.append("fechaVenc", getInfo1[6]);
            dataExp1.append("numContrato", getInfo1[7]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }

            if (validaComent == 1) {
                $('#save1').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_lote_asistentes_proceceso8/',
                    data: dataExp1,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);

                        if(response.message == 'OK') {
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save1').prop('disabled', false);
                        $('#editReg').modal('hide');
                        $('#Jtabla').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });
            }
        });

        $(document).on('click', '#save3', function(e) {
            e.preventDefault();
            var comentario = $("#comentario3").val();
            var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
            var dataExp3 = new FormData();
            dataExp3.append("idCliente", getInfo3[0]);
            dataExp3.append("nombreResidencial", getInfo3[1]);
            dataExp3.append("nombreCondominio", getInfo3[2]);
            dataExp3.append("idCondominio", getInfo3[3]);
            dataExp3.append("nombreLote", getInfo3[4]);
            dataExp3.append("idLote", getInfo3[5]);
            dataExp3.append("comentario", comentario);
            dataExp3.append("fechaVenc", getInfo3[6]);
            dataExp3.append("numContrato", getInfo3[7]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }
            
            if (validaComent == 1) {
                $('#save3').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRechazo_asistentes_proceceso8/',
                    data: dataExp3,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);
                        if(response.message == 'OK') {
                            $('#save3').prop('disabled', false);
                            $('#rechReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save3').prop('disabled', false);
                            $('#rechReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save3').prop('disabled', false);
                            $('#rechReg').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save3').prop('disabled', false);
                        $('#rechReg').modal('hide');
                        $('#Jtabla').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });
            }
        });

        $(document).on('click', '#save4', function(e) {
            e.preventDefault();
            var comentario = $("#comentario4").val();
            var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
            var dataExp4 = new FormData();
            dataExp4.append("idCliente", getInfo4[0]);
            dataExp4.append("nombreResidencial", getInfo4[1]);
            dataExp4.append("nombreCondominio", getInfo4[2]);
            dataExp4.append("idCondominio", getInfo4[3]);
            dataExp4.append("nombreLote", getInfo4[4]);
            dataExp4.append("idLote", getInfo4[5]);
            dataExp4.append("comentario", comentario);
            dataExp4.append("fechaVenc", getInfo4[6]);
            dataExp4.append("numContrato", getInfo4[7]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }
            
            if (validaComent == 1) {
                $('#save4').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRechazoAstatus2_asistentes_proceceso8/',
                    data: dataExp4,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);

                        if(response.message == 'OK') {
                            $('#save4').prop('disabled', false);
                            $('#rechazoAs').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save4').prop('disabled', false);
                            $('#rechazoAs').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save4').prop('disabled', false);
                            $('#rechazoAs').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save4').prop('disabled', false);
                        $('#rechazoAs').modal('hide');
                        $('#Jtabla').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });
            }
        });

        $(document).on('click', '#save5', function(e) {
            e.preventDefault();
            var comentario = $("#comentario5").val();
            var validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;
            var dataExp5 = new FormData();
            dataExp5.append("idCliente", getInfo5[0]);
            dataExp5.append("nombreResidencial", getInfo5[1]);
            dataExp5.append("nombreCondominio", getInfo5[2]);
            dataExp5.append("idCondominio", getInfo5[3]);
            dataExp5.append("nombreLote", getInfo5[4]);
            dataExp5.append("idLote", getInfo5[5]);
            dataExp5.append("comentario", comentario);
            dataExp5.append("fechaVenc", getInfo5[6]);
            dataExp5.append("numContrato", getInfo5[7]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }
            
            if (validaComent == 1) {
                $('#save5').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRevision_asistentesAadministracion11_proceceso8/',
                    data: dataExp5,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);
                        if(response.message == 'OK') {
                            $('#save5').prop('disabled', false);
                            $('#rev8').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save5').prop('disabled', false);
                            $('#rev8').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save5').prop('disabled', false);
                            $('#rev8').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save5').prop('disabled', false);
                        $('#rev8').modal('hide');
                        $('#Jtabla').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });
            }
        });

        $(document).on('click', '#save6', function(e) {
            e.preventDefault();
            var comentario = $("#comentario6").val();
            var validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
            var dataExp6 = new FormData();
            dataExp6.append("idCliente", getInfo6[0]);
            dataExp6.append("nombreResidencial", getInfo6[1]);
            dataExp6.append("nombreCondominio", getInfo6[2]);
            dataExp6.append("idCondominio", getInfo6[3]);
            dataExp6.append("nombreLote", getInfo6[4]);
            dataExp6.append("idLote", getInfo6[5]);
            dataExp6.append("comentario", comentario);
            dataExp6.append("fechaVenc", getInfo6[6]);
            dataExp6.append("numContrato", getInfo6[7]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }
            
            if (validaComent == 1) {
                $('#save6').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso8/',
                    data: dataExp6,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);

                        if(response.message == 'OK') {
                            $('#save6').prop('disabled', false);
                            $('#rev_2').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save6').prop('disabled', false);
                            $('#rev_2').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save6').prop('disabled', false);
                            $('#rev_2').modal('hide');
                            $('#Jtabla').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save6').prop('disabled', false);
                        $('#rev_2').modal('hide');
                        $('#Jtabla').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });
            }
        });

        jQuery(document).ready(function(){
            jQuery('#editReg').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario').val('');
            })

            jQuery('#editLoteRev').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario2').val('');
            })

            jQuery('#rechReg').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario3').val('');
            })

            jQuery('#rechazoAs').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario4').val('');
            })

            jQuery('#rev8').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario5').val('');
            })

            jQuery('#rev_2').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario6').val('');
            })
        })
    </script>
</body>