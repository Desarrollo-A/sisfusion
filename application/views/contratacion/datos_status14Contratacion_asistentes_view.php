<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php
                $this->load->view('template/sidebar', '');
        ?>

        <!-- Modals -->
        <!-- modal  rechazar A CONTRALORIA 7-->
        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" > 
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                    <label>Comentario:</label>
                        <textarea class="form-control" id="comentario1" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save2" class="btn btn-primary">Registrar</button>
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
                                    <h3 class="card-title center-align" >Registro estatus 14</h3>
                                    <p class="card-title pl-1">(Firma Acuse cliente)</p>
                                </div>
                                <div class="material-datatables"> 
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_ingresar_14" name="tabla_ingresar_14">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>GERENTE</th>
                                                        <th>CLIENTE</th>
                                                        <?php
                                                        if($this->session->userdata('id_rol') != 53 && $this->session->userdata('id_rol') != 54) { // ANALISTA DE COMISIONES Y SUBDIREECTOR CONSULTA (POPEA)
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
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var getInfo1 = new Array(6);

        $("#tabla_ingresar_14").ready( function(){
            $('#tabla_ingresar_14 thead tr:eq(0) th').each( function (i) {

                if(i != 0 && i != 7){
                    var title = $(this).text();
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if (tabla_14.column(i).search() !== this.value ) {
                            tabla_14
                            .column(i)
                            .search(this.value)
                            .draw();
                        }
                    } );
                }
            });

            let titulos = [];
            $('#tabla_ingresar_14 thead tr:eq(0) th').each( function (i) {
                if( i!=0 && i!=13){
                    var title = $(this).text();
                    titulos.push(title);
                }
            });

            tabla_14 = $("#tabla_ingresar_14").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6],
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
                    width: "3%",
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {
                    data: function( d ){
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
                    width: "10%",
                    data: function( d ){
                        return '<p class="m-0">'+d.nombreResidencial+'</p>';
                    }
                },
                {
                    width: "10%",
                    data: function( d ){
                        return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                    }
                },
                {
                    width: "15%",
                    data: function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';

                    }
                }, 
                {
                    width: "20%",
                    data: function( d ){
                        return '<p class="m-0">'+d.gerente+'</p>';
                    }
                }, 
                {
                    width: "20%",
                    data: function( d ){
                        return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                    }
                }
                <?php
                if($this->session->userdata('id_rol') != 53 && $this->session->userdata('id_rol') != 54){ // ANALISTA DE COMISIONES Y SUBDIRECTOR CONSULTA (POPEA)
                ?>
                    , 
                    { 
                        width: "40%",
                        orderable: false,
                        data: function( data ){
                            var cntActions;
                            if(data.vl == '1') {
                                cntActions = 'En proceso de Liberación';
                            } 
                            else {
                                if(data.idStatusContratacion == 13 && data.idMovimiento == 43 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17)){
                                        cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                        'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
                                        'class="btn-data btn-green editReg" title="Registrar estatus">' +
                                        '<i class="far fa-thumbs-up"></i></button>';

                                }
                                else if(data.idStatusContratacion == 13 && data.idMovimiento == 68 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17)){
                                    cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                                'class="revCont btn-data btn-orangeYellow" title= "Registrar Status">' +
                                                '<i class="far fa-thumbs-up"></i></button>';

                                }
                                else
                                {
                                    cntActions ='N/A';
                                }
                            }
                            return '<div class="d-flex justify-center">'+cntActions+'</div>';
                        }
                    } 
                <?php } ?>
                ],
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                ajax: {
                    url: '<?=base_url()?>index.php/Asistente_gerente/getStatCont14',
                    dataSrc: "",
                    type: "POST",
                    cache: false,
                    data: function( d ){
                    }
                },    
            });

            $('#tabla_ingresar_14 tbody').on('click', 'td.details-control', function (){
                var tr = $(this).closest('tr');
                var row = tabla_14.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } 
                else {
                    var status;
                    var fechaVenc;
                    if(row.data().idStatusContratacion==13 && row.data().idMovimiento==43){
                        status= "Status 13 listo (Contraloría)";
                    } 
                    else if(row.data().idStatusContratacion==13 && row.data().idMovimiento==68){
                        status="Status 14 Rechazado (Contraloría)";
                    } else {
                        status="N/A";
                    }

                    if(row.data().idStatusContratacion==13 && row.data().idMovimiento==43){
                        fechaVenc = row.data().fechaVenc;
                    } else if(row.data().idStatusContratacion==13 && row.data().idMovimiento==68){
                        fechaVenc='VENCIDO';
                    } else {
                        status="N/A";
                    }
                    
                    var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>INFORMACIÓN ADICIONAL</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>'+status+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>' + row.data().comentario + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha vencimiento: </b>' + fechaVenc + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha realizado: </b></label>' + row.data().modificado + '</div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>'+row.data().coordinador+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>'+row.data().asesor+'</label></div></div></div>';


                    row.child(informacion_adicional).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                }
            });

            $("#tabla_ingresar_14 tbody").on("click", ".editReg", function(e){
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
  
            $("#tabla_ingresar_14 tbody").on("click", ".revCont", function(e){
                e.preventDefault();

                getInfo1[0] = $(this).attr("data-idCliente");
                getInfo1[1] = $(this).attr("data-nombreResidencial");
                getInfo1[2] = $(this).attr("data-nombreCondominio");
                getInfo1[3] = $(this).attr("data-idcond");
                getInfo1[4] = $(this).attr("data-nomlote");
                getInfo1[5] = $(this).attr("data-idLote");
                getInfo1[6] = $(this).attr("data-fecven");

                nombreLote = $(this).data("nomlote");
                $(".lote").html(nombreLote);
                $('#envARev2').modal('show');
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
            if (validaComent == 0) {
                alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
            }
            if (validaComent == 1) {
                $('#save1').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_lote_asistentes_proceceso14/',
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
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                            $('#save1').prop('disabled', false);
                            $('#editReg').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                });  
            }
        });

        $(document).on('click', '#save2', function(e) {
            e.preventDefault();

            var comentario = $("#comentario1").val();
            var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;
            var dataExp2 = new FormData();
            dataExp2.append("idCliente", getInfo1[0]);
            dataExp2.append("nombreResidencial", getInfo1[1]);
            dataExp2.append("nombreCondominio", getInfo1[2]);
            dataExp2.append("idCondominio", getInfo1[3]);
            dataExp2.append("nombreLote", getInfo1[4]);
            dataExp2.append("idLote", getInfo1[5]);
            dataExp2.append("comentario", comentario);
            dataExp2.append("fechaVenc", getInfo1[6]);

            if (validaComent == 0) {
                alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
            }
                
            if (validaComent == 1) {
                $('#save1').prop('disabled', true);
                $.ajax({
                    url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso14/',
                    data: dataExp2,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        response = JSON.parse(data);
                        if(response.message == 'OK') {
                            $('#save2').prop('disabled', false);
                            $('#envARev2').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Estatus enviado.", "success");
                        } else if(response.message == 'FALSE'){
                            $('#save2').prop('disabled', false);
                            $('#envARev2').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                        } else if(response.message == 'ERROR'){
                            $('#save2').prop('disabled', false);
                            $('#envARev2').modal('hide');
                            $('#tabla_ingresar_14').DataTable().ajax.reload();
                            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                        }
                    },
                    error: function( data ){
                        $('#save2').prop('disabled', false);
                        $('#envARev2').modal('hide');
                        $('#tabla_ingresar_14').DataTable().ajax.reload();
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

            jQuery('#envARev2').on('hidden.bs.modal', function (e) {
                jQuery(this).removeData('bs.modal');
                jQuery(this).find('#comentario1').val('');
            })
        })
    </script>
</body>