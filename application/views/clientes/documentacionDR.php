<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!-- Modals -->
    <!-- modal  INSERT FILE-->
    <div class="modal fade" id="addFile" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="expediente" id="expediente" style="display: none;">
								</span>
                        </label>
                        <input type="text" class="form-control" id= "txtexp" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="sendFile" class="btn btn-primary"><span
                            class="material-icons" >send</span> Guardar documento </button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal INSERT-->

    <!--modal que pregunta cuando se esta borrando un archivo-->
    <div class="modal fade" id="cuestionDelete" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title">¡Eliminar archivo!</h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row centered center-align">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></h1>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <h4 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h4>
                                <h5 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <br><br>
                    <button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
    <!--termina el modal de cuestion-->

    <!-- autorizaciones-->
    <div class="modal fade" id="verAutorizacionesAsesor" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title">Autorizaciones <span class="material-icons">vpn_key</span></h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="auts-loads">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
    <!-- autorizaciones end-->
    <!-- END Modals -->

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Documentación por lote</h3>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_name">
                                            <label class="control-label">ID LOTE</label>
                                            <input id="idLotte" name="idLotte" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_name">
                                            <label class="control-label">NOMBRE</label>
                                            <input id="name" name="name" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="control-label">CORREO</label>
                                            <input id="mail" name="mail" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="control-label">TELÉFONO</label>
                                            <input id="telephone" name="telephone" type="text" class="form-control input-gral" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating div_last_name">
                                            <!--<label class="control-label">TELÉFONO</label>-->
                                            <select class="selectpicker select-gral m-0" id="sede" name="sede[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Selecciona sede" data-size="7" required="" multiple="" tabindex="-98">
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align centered">
                                        <div class="form-group label-floating div_last_name">
                                            <button type="button" class="btn btn-primary" id="searchButton">BUSCAR</button>
                                        </div>
                                    </div>

                                </div>
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="table-responsive">
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>PROYECTO</th>
                                        <th>CONDOMINIO</th>
                                        <th>ID LOTE</th>
                                        <th>LOTE</th>
                                        <th>CLIENTE</th>
                                        <th>COORDINADOR</th>
                                        <th>GERENTE</th>
                                        <th>SUBDIRECTOR</th>
                                        <th>REGIONAL</th>
                                        <th>NOMBRE DE DOCUMENTO</th>
                                        <th>HORA/FECHA</th>
                                        <th>DOCUMENTO</th>
                                        <th>RESPONSABLE</th>
                                        <th>UBICACIÓN</th>
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
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript">
    Shadowbox.init();
</script>
<script>
    var id_rol_current = <?php echo $this->session->userdata('id_rol')?>;



    $(document).ready (function() {
        $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
            var input = $(this).closest('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });


        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
            console.log('triggered');
        });



        $('#filtro3').change(function(){
            var valorSeleccionado = $(this).val();
            //build select condominios
            $("#filtro4").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');

                }
            });
        });

        $('#filtro4').change(function(){
            var residencial = $('#filtro3').val();
            var valorSeleccionado = $(this).val();
            $("#filtro5").empty().selectpicker('refresh');
            <?php
            $metodoToExc = 'getLotesAsesor';
            ?>
            $.ajax({
                url: '<?=base_url()?>registroCliente/<?php echo $metodoToExc;?>/'+valorSeleccionado+'/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++){
                        var datos = response[i]['idLote']+','+response[i]['venta_compartida'];
                        var name = response[i]['nombreLote'];
                        $("#filtro5").append($('<option>').val(datos).text(name));
                    }
                    $("#filtro5").selectpicker('refresh');

                },
            });
        });

        let titulos = [];
        $('#tableDoct thead tr:eq(0) th').each( function (i) {
            if( i!=0 && i!=13){
                var title = $(this).text();
                titulos.push(title);
            }
        });

        $('#filtro5').change(function(){
            var seleccion = $(this).val();
            let datos = seleccion.split(',');
            let valorSeleccionado=datos[0];
            let ventaC = datos[1];
            let titulos_intxt = [];
            $('#tableDoct thead tr:eq(0) th').each( function (i) {
                $(this).css('text-align', 'center');
                var title = $(this).text();
                titulos_intxt.push(title);
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                        $('#tableDoct').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            $('#tableDoct').DataTable({
                destroy: true,
                ajax:
                    {
                        "url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+valorSeleccionado,
                        "dataSrc": ""
                    },
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                "ordering": false,
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        title: 'DOCUMENTACION_LOTE',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4,5, 6, 8, 9 ],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'ID LOTE';
                                            break;
                                        case 3:
                                            return 'LOTE';
                                            break;
                                        case 4:
                                            return 'CLIENTE';
                                            break;
                                        case 5:
                                            return 'COORDINADOR';
                                            break;
                                        case 6:
                                            return 'GERENTE';
                                            break;
                                        case 7:
                                            return 'SUBDIRECTOR';
                                            break;
                                        case 8:
                                            return 'REGIONAL';
                                            break;
                                        case 9:
                                            return 'NOMBRE DE DOCUMENTO';
                                            break;
                                        case 10:
                                            return 'HORA/FECHA';
                                            break;
                                        case 12:
                                            return 'RESPONSABLE';
                                            break;
                                        case 13:
                                            return 'UBICACIÓN';
                                            break;
                                    }
                                }
                            }
                        },
                    }
                ],
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                "columns":
                    [

                        {data: 'nombreResidencial'},
                        {data: 'nombre'},
                        {data: 'idLote'},
                        {data: 'nombreLote'},
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
                            },
                        },
                        {
                            data: null,
                            render: function( data, type, row )
                            {
                                return (data.coordinador == '  ' ? 'No aplica' : data.coordinador);
                            }
                        },
                        {
                            data: null,
                            render: function( data, type, row )
                            {
                                return (data.gerente == '  ' ? 'No aplica' : data.gerente);
                            }
                        },
                        {
                            data: null,
                            render: function( data, type, row )
                            {
                                return (data.subdirector == '  ' ? 'No aplica' : data.subdirector);
                            }
                        },
                        {
                            data: null,
                            render: function( data, type, row )
                            {
                                return (data.regional == '  ' ? 'No aplica' : data.regional);
                            }
                        },
                        {data: 'movimiento'},
                        {data: 'modificado'},
                        {
                            data: null,
                            render: function ( data, type, row ){
                                // if(data.flag_compartida == 1){
                                datos = data.id_asesor;
                                if (getFileExtension(data.expediente) == "pdf") {
                                    if(data.tipo_doc == 8){
                                        file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                    }else if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD btn-data btn-warning" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
                                    } else {
                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                        if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) && (ventaC == 1) ){
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        } else {
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                        }
                                        <?php } else {?>file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';<?php } ?>
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
                                    file = "<a href='../../static/documentos/cliente/corrida/" + data.expediente + "' class='btn-data btn-green-excel'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a>";
                                }
                                else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
                                    console.log('TIPO DOC:'+data.tipo_doc);
                                    console.log('MOVIMIENTO:'+data.idMovimiento);
                                    console.log('ROL:'+id_rol_current);
                                    console.log('VENTA COMPARTIDA:'+ventaC);

                                    console.log('***************ATENCION***********');
                                    // console.log(<?php echo $this->session->userdata('datauserjava'); ?>);
                                    if(data.tipo_doc == 7){
                                        file = '<button type="button" title= "Corrida inhabilitada" class="btn-data btn-warning disabled" disabled><i class="fas fa-file-excel"></i></button>';
                                    } else if(data.tipo_doc == 8){
                                        file = '<button type="button" title= "Contrato inhabilitado" class="btn-data btn-warning disabled" disabled><i class="fas fa-file"></i></button>';
                                    } else {
                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                        //
                                        if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) && (ventaC == 1)){
                                            file = '<button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
                                        } else {
                                            file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
                                        }
                                        <?php } else {?> file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>'; <?php } ?>
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
                                    file = '<a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
                                    file = '<a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                                }
                                else if (getFileExtension(data.expediente) == "Autorizaciones") {
                                    file = '<a href="#" class="btn-data btn-blueMaderas seeAuts" title= "Autorizaciones" data-idCliente="'+data.idCliente+'" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
                                }
                                else if (getFileExtension(data.expediente) == "Prospecto") {
                                    file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-lp="'+data.lugar_prospeccion+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a>';
                                }
                                /*generar funcion para ver Evidencia MKTD*/
                                else
                                {
                                    <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                    if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) ){

                                        if(data.tipo_doc == 66){
                                            file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>' +
                                                '';
                                        }else{
                                            file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>' +
                                                '';
                                        }
                                    } else {

                                        if(data.tipo_doc == 66){
                                            file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>';
                                        }else{
                                            file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                        }

                                    }
                                    <?php } else {?>

                                    if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a>';
                                    }else{
                                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                    }

                                    <?php }?>

                                }
                                return '<div class="d-flex justify-center">' + file + '</div>';
                                // }else{
                                // 	return '<span class="label label-success">Se necesita especificar si es venta compartida</span>';
                                // }
                            }
                        },
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                            },
                        },
                        {data: 'ubic'},
                    ]
            });
            <?php $this->session->unset_userdata('datauserjava'); ?>
        });

        $('.btn-documentosGenerales').on('click', function () {
            $('#modalFiles').modal('show');
        });

        function getFileExtension(filename) {
            validaFile =  filename == null ? 'null':
                filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
                    filename == 'Autorizaciones' ? 'Autorizaciones':
                        filename.split('.').pop();
            return validaFile;
        }

        $.post("<?php echo base_url()?>Contraloria/get_sede", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
            }

            $("#sede").selectpicker('refresh');
        }, 'json');
    });

    /***********/
    $('#searchButton').click(()=>{

        let idLote = $('#idLotte').val();
        let name = $('#name').val();
        let mail = $('#mail').val();
        let telephone = $('#telephone').val();
        let sede = $('#sede').val();

        console.log('sedeII:', JSON.stringify(sede));

        idLote = (idLote!='') ? idLote : '';
        name = (name!='') ? name : '';
        mail = (mail!='') ? mail : '';
        telephone = (telephone!='') ? telephone : '';
        sede = (sede!='') ? sede.toString() : '';


        if(idLote!='' || name!='' || mail!='' || telephone!='' || sede!=''){
            let array_data = [];
            array_data['idLote'] = idLote;
            array_data['name'] = name;
            array_data['mail'] = mail;
            array_data['telephone'] = telephone;
            array_data['sede'] = sede;
            // fillTable(array_data);
            console.log(array_data);
        }else{
            alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de busqueda', 'warning')
        }
    });


    /**********/


    $(document).on('click', '.pdfLink', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      985,
            height:     660
        });
    });

    $(document).on('click', '.pdfLink2', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink22', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink3', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      985,
            height:     660
        });
    });

    $(document).on('click', '.verProspectos', function () {
        var $itself = $(this);
        let functionName = '';
        if ($itself.attr('data-lp') == 6) { // IS MKTD
            functionName = 'printProspectInfoMktd';
        } else {
            functionName = 'printProspectInfo';
        }
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>clientes/'+functionName+'/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
            width:      985,
            height:     660

        });
    });


    /*evidencia MKTD PDF*/
    $(document).on('click', '.verEVMKTD', function () {
        var $itself = $(this);
        var cntShow = '';

        if(checaTipo($itself.attr('data-expediente')) == "pdf")
        {
            cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
        }else{
            cntShow = '<div><img src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
        }
        Shadowbox.open({
            content:    cntShow,
            player:     "html",
            title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
            width:      985,
            height:     660

        });
    });

    function checaTipo(archivo){
        archivo.split('.').pop();
        return validaFile;
    }

    $(document).on('click', '.seeAuts', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var idLote=$itself.attr('data-idLote');
        $.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
            $('#auts-loads').empty();
            var statusProceso;
            $.each(JSON.parse(data), function(i, item) {
                if(item['estatus'] == 0)
                {
                    statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
                }
                else if(item['estatus'] == 1)
                {
                    statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
                }
                else if(item['estatus'] == 2)
                {
                    statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
                }
                else if(item['estatus'] == 3)
                {
                    statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
                }
                else
                {
                    statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
                }
                $('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
                $('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
                $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
                    '<br><hr>');


            });
            $('#verAutorizacionesAsesor').modal('show');
        });
    });

    <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2){?>
    var miArrayAddFile = new Array(8);
    var miArrayDeleteFile = new Array(1);
    $(document).ready (function() {
        $(document).on("click", ".update", function(e){
            e.preventDefault();
            $('#txtexp').val('');

            var descdoc= $(this).data("descdoc");
            var idCliente = $(this).attr("data-idCliente");
            var nombreResidencial = $(this).attr("data-nombreResidencial");
            var nombreCondominio = $(this).attr("data-nombreCondominio");
            var idCondominio = $(this).attr("data-idCondominio");
            var nombreLote = $(this).attr("data-nombreLote");
            var idLote = $(this).attr("data-idLote");
            var tipodoc = $(this).attr("data-tipodoc");
            var iddoc = $(this).attr("data-iddoc");

            miArrayAddFile[0] = idCliente;
            miArrayAddFile[1] = nombreResidencial;
            miArrayAddFile[2] = nombreCondominio;
            miArrayAddFile[3] = idCondominio;
            miArrayAddFile[4] = nombreLote;
            miArrayAddFile[5] = idLote;
            miArrayAddFile[6] = tipodoc;
            miArrayAddFile[7] = iddoc;

            $(".lote").html(descdoc);
            $('#addFile').modal('show');
        });
    });

    $(document).on('click', '#sendFile', function(e) {
        e.preventDefault();
        var idCliente = miArrayAddFile[0];
        var nombreResidencial = miArrayAddFile[1];
        var nombreCondominio = miArrayAddFile[2];
        var idCondominio = miArrayAddFile[3];
        var nombreLote = miArrayAddFile[4];
        var idLote = miArrayAddFile[5];
        var tipodoc = miArrayAddFile[6];
        var iddoc = miArrayAddFile[7];
        var expediente = $("#expediente")[0].files[0];
        var validaFile = (expediente == undefined) ? 0 : 1;
        tipodoc = (tipodoc == 'null') ? 0 : tipodoc;
        var dataFile = new FormData();

        dataFile.append("idCliente", idCliente);
        dataFile.append("nombreResidencial", nombreResidencial);
        dataFile.append("nombreCondominio", nombreCondominio);
        dataFile.append("idCondominio", idCondominio);
        dataFile.append("nombreLote", nombreLote);
        dataFile.append("idLote", idLote);
        dataFile.append("expediente", expediente);
        dataFile.append("tipodoc", tipodoc);
        dataFile.append("idDocumento", iddoc);

        if (validaFile == 0) {
            alerts.showNotification('top', 'right', 'Debes seleccionar un archivoo', 'danger');
        }

        if (validaFile == 1) {
            $('#sendFile').prop('disabled', true);
            $.ajax({
                url: "<?=base_url()?>index.php/registroCliente/addFileAsesor",
                data: dataFile,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success : function (response) {
                    response = JSON.parse(response);
                    if(response.message == 'OK') {
                        alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
                        $('#sendFile').prop('disabled', false);
                        $('#addFile').modal('hide');
                        $('#tableDoct').DataTable().ajax.reload();
                    } else if(response.message == 'ERROR'){
                        alerts.showNotification('top', 'right', 'Error al enviar expediente y/o formato no válido', 'danger');
                        $('#sendFile').prop('disabled', false);
                    }
                }
            });
        }
    });

    $(document).ready (function() {
        $(document).on("click", ".delete", function(e){
            e.preventDefault();
            var iddoc= $(this).data("iddoc");
            var tipodoc= $(this).data("tipodoc");

            miArrayDeleteFile[0] = iddoc;

            $(".tipoA").html(tipodoc);
            $('#cuestionDelete').modal('show');

        });
    });

    $(document).on('click', '#aceptoDelete', function(e) {
        e.preventDefault();
        var id = miArrayDeleteFile[0];
        var dataDelete = new FormData();
        dataDelete.append("idDocumento", id);

        $('#aceptoDelete').prop('disabled', true);
        $.ajax({
            url: "<?=base_url()?>index.php/registroCliente/deleteFile",
            data: dataDelete,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success : function (response) {
                response = JSON.parse(response);
                if(response.message == 'OK') {
                    //toastr.success('Archivo eliminado.', '¡Alerta de Éxito!');
                    alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
                    $('#aceptoDelete').prop('disabled', false);
                    $('#cuestionDelete').modal('hide');
                    $('#tableDoct').DataTable().ajax.reload();
                } else if(response.message == 'ERROR'){
                    //toastr.error('Error al eliminar el archivo.', '¡Alerta de error!');
                    alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
                    $('#tableDoct').DataTable().ajax.reload();
                }
            }
        });

    });
    <?php } ?>
</script>
</body>