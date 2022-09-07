<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);
    ?>
    <div class="modal fade" id="modal_pregunta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         data-backdrop="static" data-keyboard="false" style="z-index: 1600;top: 30%;" >
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="box-shadow: 0 27px 24px 0 rgb(0 0 0 / 57%), 0 40px 77px 0 rgb(0 0 0 / 90%);
            border-radius: 6px;border: 1px solid #ccc;">
                <div class="modal-header">
                    <h4 class="modal-title">¿Realmente desea asignar este prospecto al cliente?</h4>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-simple" data-dismiss="modal">CANCELAR
                            <div class="ripple-container"></div></button>
                        <button type="button" class="btn btn-primary" id="asignar_prospecto" data-dismiss="modal">ASIGNAR
                            <div class="ripple-container"></div></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_aut_ds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Solicitar</b> autorización.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class=""></h5>
                </div>
                <form id="my-edit-form" name="my-edit-form" method="post">
                    <div class="modal-body">
                    </div>

                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asignar_prospecto_a_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Asignar</b> prospecto al cliente
                        <b><span id="nom_cliente" style="text-transform: uppercase"></span></b>.</h4>
                        <a type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 2%;right: 5%;"><span class="material-icons">close</span></a>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                    <h5 class=""></h5>
                    <input type="hidden" id="id_cliente_asignar" name="id_cliente_asignar">
                    <div class="modal-body">
                        <div class="material-datatables">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="table_prospectos" width="100%">
                                <thead>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Información prospecto</th>
                                <th>Asignar</th>
                                </thead>
                            </table>
                        </div>

                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_loader_assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Asignando prospecto al cliente</h4>
                    <div class="modal-body" style="text-align: center">
                            <img src="<?=base_url()?>static/images/asignando.gif" width="100%">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar
                            <div class="ripple-container"></div></button>
                    </div>
                </div>
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
                                <h3 class="card-title center-align">Tus ventas</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <?php
                            if($this->session->userdata('id_usuario') == 9651) {
                            ?>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">Proyecto</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un proyecto"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">Condominio</label>
                                                    <select name="condominio" id="condominio" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona condominio"
                                                            data-size="7" data-live-search="true" required>
                                                        <option disabled selected>Selecciona un condominio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_deposito_seriedad" name="tabla_deposito_seriedad"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA APARTADO</th>
                                                <th>FECHA VENCIMIENTO</th>
                                                <th>COMENTARIO</th>
                                                <th>EXPEDIENTE</th>
                                                <th>DS</th>
                                                <th>PROSPECTO</th>
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


    <div class="content hide">

        <!-- modal  ENVIA A CONTRALORIA 2-->
        <div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal3" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A CONTRALORIA 6 por rechazo 1-->
        <div class="modal fade" id="modal4" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 6 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A VENTAS 8 por rechazo 1-->
        <div class="modal fade" id="modal5" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 8 Ventas) - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal6" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4></center>
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
        <!-- modal -->

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal7" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario7" rows="3"></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save7" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal  ENVIA A JURIDICO por rechazo 2-->
        <div class="modal fade" id="modal_return1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario8" rows="3"></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="b_return1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
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

let id_usuario = <?= $this->session->userdata('id_usuario') ?> ;

$(document).ready(function() {
    if (id_usuario == 9651) { // MJ: ERNESTO DEL PINO SILVA
        $.post(`${general_base_url}Contratacion/lista_proyecto`, function(data) {
            var len = data.length;
            for(var i = 0; i<len; i++)
            {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#proyecto").selectpicker('refresh');
        }, 'json');
    }
    else // MJ: PARA LOS DEMÁS SÍ CARGA EN EL READY
        fillDataTable(0);
});

$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(`${general_base_url}Contratacion/lista_condominio/`+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>Selecciona un codominio</option>'));

			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

$('#condominio').change( function(){
	let id_condominio = $(this).val();
    fillDataTable(id_condominio);
});
    Shadowbox.init();


    var miArray = new Array(6);
    var miArrayAddFile = new Array(6);

    var getInfo2A = new Array(7);
    var getInfo2_2A = new Array(7);
    var getInfo5A = new Array(7);
    var getInfo6A = new Array(7);
    var getInfo2_3A = new Array(7);
    var getInfo2_7A = new Array(7);
    var getInfo5_2A = new Array(7);
    var return1a = new Array(7);


    var aut;

    let titulos_intxt = [];
    $('#tabla_deposito_seriedad thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value ) {
                $('#tabla_deposito_seriedad').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
    $("#tabla_deposito_seriedad").ready( function(){
        $(document).on('click', '.abrir_prospectos', function () {
            $('#nom_cliente').html('');
            $('#id_cliente_asignar').val(0);
            var $itself = $(this);
            console.log($itself.attr('data-idCliente'));
            var id_cliente = $itself.attr('data-idCliente');
            var nombre_cliente = $itself.attr('data-nomCliente');
            /*asignar_prospecto_a_cliente
            nom_cliente*/
            $('#nom_cliente').append(nombre_cliente);
            $('#id_cliente_asignar').val(id_cliente);
            /*table_prospectos*/

            tabla_valores_ds = $("#table_prospectos").DataTable({
                width: 'auto',
                "dom": "Bfrtip",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Prospectos',
                        title:"Prospectos",
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                        className: 'btn buttons-pdf',
                        titleAttr: 'Prospectos',
                        title:"Prospectos",
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                    }
                ],
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                "pageLength": 10,
                "bAutoWidth": false,
                "fixedColumns": true,
                "ordering": false,
                "destroy": true,
                "language": {
                    /*"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"*/
                    "url": "<?=base_url()?>/static/spanishLoader.json"
                },
                "order": [[4, "desc"]],
                columns: [
                    {
                        "data": function(d){
                            return d.nombre + ' ' + d.apellido_paterno + ' ' + d.apellido_materno;
                        }
                    },
                    {
                        "data": function(d){
                            return myFunctions.validateEmptyField(d.correo);
                        }
                    },
                    {
                        "data": function(d){
                            return d.telefono;
                        }
                    },
                    {
                        "data": function(d){
                            var info = '';
                            info = '<b>Observación:</b> '+myFunctions.validateEmptyField(d.observaciones)+'<br>';
                            info += '<b>Lugar prospección:</b> '+d.lugar_prospeccion+'<br>';
                            info += '<b>Plaza venta:</b> '+d.plaza_venta+'<br>';
                            info += '<b>Nacionalidad:</b> '+d.nacionalidad+'<br>';


                            return info;
                        }
                    },
                    {
                        "data": function(d){
                            return '<center><button class="btn-data btn-green became_prospect_to_cliente"' +
                                'data-id_prospecto="'+d.id_prospecto+'" data-id_cliente="'+id_cliente+'">' +
                                '<i class="fas fa-user-check"></i></button></center>';
                        }
                    },
                ],

                "ajax": {
                    "url": "<?=base_url()?>index.php/Asesor/get_info_prospectos/",
                    "dataSrc": "",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },

            });

            $('#asignar_prospecto_a_cliente').modal();

        });
        $('#table_prospectos thead tr:eq(0) th').each( function (i) {

            //  if(i != 0 && i != 11){
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 300;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#table_prospectos').DataTable().column(i).search() !== this.value ) {
                    $('#table_prospectos').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            } );
            //}
        });
        $(document).on('click', '.became_prospect_to_cliente', function() {
            var $itself = $(this);
            var id_cliente = $itself.attr('data-id_cliente');
            var id_prospecto = $itself.attr('data-id_prospecto');
            /*console.log(id_cliente);
            console.log(id_prospecto);*/
            $('#modal_pregunta').modal();

            $(document).on('click', '#asignar_prospecto', function () {
                //ajax con el post de update prospecto a cliente
                $.ajax({
                    type: 'POST',
                    url: '<?=base_url()?>index.php/asesor/prospecto_a_cliente',
                    data: {'id_prospecto':id_prospecto,'id_cliente':id_cliente},
                    dataType: 'json',
                    beforeSend: function(){
                        $('#modal_loader_assign').modal();

                    },
                    success: function(data) {
                        console.log(data);
                        if (data.cliente_update == 'OK' && data.prospecto_update=='OK') {
                            $('#modal_loader_assign').modal("hide");
                            $('#asignar_prospecto_a_cliente').modal('hide');
                            $('#table_prospectos').DataTable().ajax.reload();
                            $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                            alerts.showNotification('top', 'right', 'Se ha asignado correctamente', 'success');

                        } else {
                            alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado verificalo ['+data+']', 'danger');
                        }
                    },
                    error: function(){
                        $('#modal_loader_assign').modal("hide");
                        $('#asignar_prospecto_a_cliente').modal('hide');
                        $('#table_prospectos').DataTable().ajax.reload();
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification('top', 'right', 'OCURRIO UN ERROR, INTENTALO DE NUEVO', 'danger');
                    }
                });
            });
        });

        $(document).on('click', '.pdfLink2', function () {
            var $itself = $(this);
            Shadowbox.open({
                content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
                width:      1600,
                height:     900
            });
        });

        $(document).on('click', '.pdfLink22', function () {
            var $itself = $(this);
            Shadowbox.open({
                content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
                width:      1600,
                height:     900
            });
        });

    });


    $(document).on("click", ".getInfo2", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo2", function(e){
        e.preventDefault();
        console.log("in");
        getInfo2A[0] = $(this).attr("data-idCliente");
        getInfo2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2A[3] = $(this).attr("data-idCondominio");
        getInfo2A[4] = $(this).attr("data-nombreLote");
        getInfo2A[5] = $(this).attr("data-idLote");
        getInfo2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal1').modal('show');
    });

    $(document).on("click", ".getInfo2_2", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_2", function(e){
        e.preventDefault();
        getInfo2_2A[0] = $(this).attr("data-idCliente");
        getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_2A[3] = $(this).attr("data-idCondominio");
        getInfo2_2A[4] = $(this).attr("data-nombreLote");
        getInfo2_2A[5] = $(this).attr("data-idLote");
        getInfo2_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal2').modal('show');
    });

    $(document).on("click", ".getInfo5", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo5", function(e){
        e.preventDefault();
        getInfo5A[0] = $(this).attr("data-idCliente");
        getInfo5A[1] = $(this).attr("data-nombreResidencial");
        getInfo5A[2] = $(this).attr("data-nombreCondominio");
        getInfo5A[3] = $(this).attr("data-idCondominio");
        getInfo5A[4] = $(this).attr("data-nombreLote");
        getInfo5A[5] = $(this).attr("data-idLote");
        getInfo5A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal3').modal('show');
    });

    $(document).on("click", ".getInfo6", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo6", function(e){
        e.preventDefault();
        getInfo6A[0] = $(this).attr("data-idCliente");
        getInfo6A[1] = $(this).attr("data-nombreResidencial");
        getInfo6A[2] = $(this).attr("data-nombreCondominio");
        getInfo6A[3] = $(this).attr("data-idCondominio");
        getInfo6A[4] = $(this).attr("data-nombreLote");
        getInfo6A[5] = $(this).attr("data-idLote");
        getInfo6A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal4').modal('show');
    });

    $(document).on("click", ".getInfo2_3", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_3", function(e){
        e.preventDefault();
        getInfo2_3A[0] = $(this).attr("data-idCliente");
        getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_3A[3] = $(this).attr("data-idCondominio");
        getInfo2_3A[4] = $(this).attr("data-nombreLote");
        getInfo2_3A[5] = $(this).attr("data-idLote");
        getInfo2_3A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal5').modal('show');
    });

    $(document).on("click", ".getInfo2_7", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_7", function(e){
        e.preventDefault();
        getInfo2_7A[0] = $(this).attr("data-idCliente");
        getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_7A[3] = $(this).attr("data-idCondominio");
        getInfo2_7A[4] = $(this).attr("data-nombreLote");
        getInfo2_7A[5] = $(this).attr("data-idLote");
        getInfo2_7A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal6').modal('show');
    });

    $(document).on("click", ".getInfo5_2", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".getInfo5_2", function(e){
        e.preventDefault();
        getInfo5_2A[0] = $(this).attr("data-idCliente");
        getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo5_2A[3] = $(this).attr("data-idCondominio");
        getInfo5_2A[4] = $(this).attr("data-nombreLote");
        getInfo5_2A[5] = $(this).attr("data-idLote");
        getInfo5_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal7').modal('show');
    });

    $(document).on("click", ".return1", function (e) {
    //$("#tabla_deposito_seriedad tbody").on("click", ".return1", function(e){
        e.preventDefault();
        return1a[0] = $(this).attr("data-idCliente");
        return1a[1] = $(this).attr("data-nombreResidencial");
        return1a[2] = $(this).attr("data-nombreCondominio");
        return1a[3] = $(this).attr("data-idCondominio");
        return1a[4] = $(this).attr("data-nombreLote");
        return1a[5] = $(this).attr("data-idLote");
        return1a[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal_return1').modal('show');
    });

    function fillDataTable(id_condominio) {
        tabla_valores_ds = $("#tabla_deposito_seriedad").DataTable({
            width: 'auto',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Tus ventas',
                    title:"Tus ventas",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,9],
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
                                        return 'LOTE';
                                    case 3:
                                        return 'CLIENTE';
                                        break;
                                    case 4:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 5:
                                        return 'FECHA VENCIMIENTO';
                                        break;
                                    case 6:
                                        return 'COMENTARIO';
                                        break;
                                    case 9:
                                        return 'PROSPECTO';
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Tus ventas',
                    title:"Tus ventas",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,9],
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
                                        return 'LOTE';
                                    case 3:
                                        return 'CLIENTE';
                                        break;
                                    case 4:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 5:
                                        return 'FECHA VENCIMIENTO';
                                        break;
                                    case 6:
                                        return 'COMENTARIO';
                                        break;
                                    case 9:
                                        return 'PROSPECTO';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            pageLength: 10,
            bAutoWidth: false,
            fixedColumns: true,
            ordering: false,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            order: [[4, "desc"]],
            destroy: true,
            columns: [
                { "data": "nombreResidencial" },
                { "data": "nombreCondominio" },
                { "data": "nombreLote" },
                {
                    "data": function( d ){
                        return d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno;
                    }
                },
                { "data": "fechaApartado" },
                {
                    "data": function( d ){
                        fv = (d.idMovimiento == 73 || d.idMovimiento == 92 || d.idMovimiento == 96) ?  d.modificado: d.fechaVenc;
                        return fv;
                    }
                },
                {
                    "data": function( d ){

                        comentario = d.idMovimiento == 31 ? d.comentario + "<br> <span class='label label-success'>Nuevo apartado</span>":
                        d.idMovimiento == 85 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 2</span>":
                        d.idMovimiento == 20 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 5</span>":
                        d.idMovimiento == 63 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 6</span>":
                        d.idMovimiento == 73 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Ventas estatus 8</span>":
                        d.idMovimiento == 82 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Jurídico estatus 7</span>":
                        d.idMovimiento == 92 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 5</span>":
                        d.idMovimiento == 96 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Jurídico estatus 7</span>":
                        d.comentario;
                        return comentario;
                    }
                },
                {
                    "data": function( d ){
                        var buttonst, dsbutton;
                        var especialClass = '';
                        var atributo_button ='';
                        var url_to_go  = '';

                        if(d.vl == '1') {
                            buttonst = 'En proceso de Liberación';
                        }
                        else {
                            if (d.idMovimiento == 31 && d.idStatusContratacion == 1) {
                                if (d.id_prospecto == 0 )/*&& d.concepto =='APARTADO DESDE LA PAGINA DE CIUDAD' MADERAS*/
                                {
                                    if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                                        atributo_button = '';
                                        url_to_go  = '<?=base_url()?>index.php/Asesor/deposito_seriedad/'+d.id_cliente+'/0';
                                    
                                        buttonst = customButton(d.dsType, d.idMovimiento, d.estatus, d.nombreLote, d.id_cliente, d.nombreResidencial, d.nombreCondominio, d.idCondominio, d.idLote, d.fechaVenc);
                                    }
                                    else{
                                        atributo_button = 'disabled';
                                        url_to_go  = '#';

                                        buttonst = customButton(d.dsType, d.idMovimiento, d.estatus, d.nombreLote, d.id_cliente, d.nombreResidencial, d.nombreCondominio, d.idCondominio, d.idLote, d.fechaVenc, 'disabled');
                                    }
                                }
                                else{
                                    atributo_button = '';
                                    url_to_go  = '<?=base_url()?>index.php/Asesor/deposito_seriedad/'+d.id_cliente+'/0';

                                    buttonst = customButton(d.dsType, d.idMovimiento, d.estatus, d.nombreLote, d.id_cliente, d.nombreResidencial, d.nombreCondominio, d.idCondominio, d.idLote, d.fechaVenc);
                                } 
                            }                            
                            else{
                                atributo_button = '';
                                url_to_go  = '<?=base_url()?>index.php/Asesor/deposito_seriedad/'+d.id_cliente+'/0';

                                buttonst = customButton(d.dsType, d.idMovimiento, d.estatus, d.nombreLote, d.id_cliente, d.nombreResidencial, d.nombreCondominio, d.idCondominio, d.idLote, d.fechaVenc);
                            }
                        }

                        
                        let bts ='<div class="d-flex">'+buttonst+dsbutton+'</div>'
                        return bts;
                    }
                },
                {
                    "data" : function(d){
                        var action='';
                        if (d.dsType == 1) {
                            if (d.idMovimiento == 31 && d.idStatusContratacion == 1) {
                                if (d.id_prospecto == 0)/*APARTADO DESDE LA PAGINA DE CIUDAD MADERAS*/
                                {
                                    if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806)
                                        action = 'Asignado correctamente';
                                    else {
                                        var nombre_cliente = '';
                                        nombre_cliente = d.nombre + ' ' + d.apellido_paterno + ' ' + d.apellido_materno;
                                        action = '<center><button class="btn-data btn-green abrir_prospectos ' +
                                        'btn-fab btn-fab-mini" data-idCliente="'+d.id_cliente+'" data-nomCliente="'+nombre_cliente+'">' +
                                        '<i class="fas fa-user-check"></i></button></center><br>';
                                        action += 'Debes asignar el prospecto al cliente para poder acceder al depósito de seriedad o integrar el expediente';
                                    }

                                } else {
                                    action = 'Asignado correctamente';
                                }
                            }
                             else {
                                    action = 'Asignado correctamente';
                                }
                        }
                        return action;
                    }
                }
            ],
            ajax: {
                url: "<?=base_url()?>index.php/Asesor/tableClienteDS/",
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    "id_condominio": id_condominio,
                }
            },

        });
    }


    $(document).on('click', '#save1', function(e) {
        e.preventDefault();

        var comentario = $("#comentario").val();

        var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;

        var dataExp1 = new FormData();

        dataExp1.append("idCliente", getInfo2A[0]);
        dataExp1.append("nombreResidencial", getInfo2A[1]);
        dataExp1.append("nombreCondominio", getInfo2A[2]);
        dataExp1.append("idCondominio", getInfo2A[3]);
        dataExp1.append("nombreLote", getInfo2A[4]);
        dataExp1.append("idLote", getInfo2A[5]);
        dataExp1.append("comentario", comentario);
        dataExp1.append("fechaVenc", getInfo2A[6]);

        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {

            $('#save1').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/intExpAsesor/',
                data: dataExp1,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);

                    if(response.message == 'OK') {
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'MISSING_DOCUMENTS'){
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        
                        alerts.showNotification("top", "right", "Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO, RECIBOS DE APARTADO Y ENGANCHE Y DEPÓSITO DE SERIEDAD Y AUTORIZACIONES VALIDADAS antes de llevar a cabo el avance.", "danger");

                    } else if(response.message == 'ERROR'){
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al envial la solicitud.", "danger");
                    } else if(response.message == 'MISSING_DOCUMENTS_AUTORIZACION'){
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "En proceso de autorización. Asegúrate de incluir los documentos: IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                    } else if(response.message == 'MISSING_AUTORIZACION'){
                        $('#save1').prop('disabled', false);
                        $('#modal1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "EN PROCESO DE AUTORIZACIÓN. Hasta que la autorización no haya sido aceptada o rechazada, no podrás avanzar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });

        }

    });

    $(document).on('click', '#save2', function(e) {
        e.preventDefault();

        var comentario = $("#comentario2").val();

        var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;

        var dataExp2 = new FormData();

        dataExp2.append("idCliente", getInfo2_2A[0]);
        dataExp2.append("nombreResidencial", getInfo2_2A[1]);
        dataExp2.append("nombreCondominio", getInfo2_2A[2]);
        dataExp2.append("idCondominio", getInfo2_2A[3]);
        dataExp2.append("nombreLote", getInfo2_2A[4]);
        dataExp2.append("idLote", getInfo2_2A[5]);
        dataExp2.append("comentario", comentario);
        dataExp2.append("fechaVenc", getInfo2_2A[6]);

        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {

            $('#save2').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/intExpAsesor/',
                data: dataExp2,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);

                    if(response.message == 'OK') {
                        $('#save2').prop('disabled', false);
                        $('#modal2').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save2').prop('disabled', false);
                        $('#modal2').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'MISSING_DOCUMENTS'){
                        $('#save2').prop('disabled', false);
                        $('#modal2').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO, RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save2').prop('disabled', false);
                        $('#modal2').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save2').prop('disabled', false);
                    $('#modal2').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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

        dataExp3.append("idCliente", getInfo5A[0]);
        dataExp3.append("nombreResidencial", getInfo5A[1]);
        dataExp3.append("nombreCondominio", getInfo5A[2]);
        dataExp3.append("idCondominio", getInfo5A[3]);
        dataExp3.append("nombreLote", getInfo5A[4]);
        dataExp3.append("idLote", getInfo5A[5]);
        dataExp3.append("comentario", comentario);
        dataExp3.append("fechaVenc", getInfo5A[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#save3').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
                data: dataExp3,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#save3').prop('disabled', false);
                        $('#modal3').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save3').prop('disabled', false);
                        $('#modal3').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'MISSING_DOCUMENTS'){
                        $('#save3').prop('disabled', false);
                        $('#modal3').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO, RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                    }else if(response.message == 'PENDIENT_AUTHORIZATION'){
                        $('#save3').prop('disabled', false);
                        $('#modal3').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Aún tienes una autorización pendiente para este lote, revisala para poder seguir el proceso", "danger");
                    }
                    else if(response.message == 'ERROR'){
                        $('#save3').prop('disabled', false);
                        $('#modal3').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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

        dataExp4.append("idCliente", getInfo6A[0]);
        dataExp4.append("nombreResidencial", getInfo6A[1]);
        dataExp4.append("nombreCondominio", getInfo6A[2]);
        dataExp4.append("idCondominio", getInfo6A[3]);
        dataExp4.append("nombreLote", getInfo6A[4]);
        dataExp4.append("idLote", getInfo6A[5]);
        dataExp4.append("comentario", comentario);
        dataExp4.append("fechaVenc", getInfo6A[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#save4').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
                data: dataExp4,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#save4').prop('disabled', false);
                        $('#modal4').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save4').prop('disabled', false);
                        $('#modal4').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save4').prop('disabled', false);
                        $('#modal4').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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

        dataExp5.append("idCliente", getInfo2_3A[0]);
        dataExp5.append("nombreResidencial", getInfo2_3A[1]);
        dataExp5.append("nombreCondominio", getInfo2_3A[2]);
        dataExp5.append("idCondominio", getInfo2_3A[3]);
        dataExp5.append("nombreLote", getInfo2_3A[4]);
        dataExp5.append("idLote", getInfo2_3A[5]);
        dataExp5.append("comentario", comentario);
        dataExp5.append("fechaVenc", getInfo2_3A[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#save5').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2/',
                data: dataExp5,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#save5').prop('disabled', false);
                        $('#modal5').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save5').prop('disabled', false);
                        $('#modal5').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save5').prop('disabled', false);
                        $('#modal5').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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

        dataExp6.append("idCliente", getInfo2_7A[0]);
        dataExp6.append("nombreResidencial", getInfo2_7A[1]);
        dataExp6.append("nombreCondominio", getInfo2_7A[2]);
        dataExp6.append("idCondominio", getInfo2_7A[3]);
        dataExp6.append("nombreLote", getInfo2_7A[4]);
        dataExp6.append("idLote", getInfo2_7A[5]);
        dataExp6.append("comentario", comentario);
        dataExp6.append("fechaVenc", getInfo2_7A[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#save6').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/envioRevisionAsesor2aJuridico7/',
                data: dataExp6,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#save6').prop('disabled', false);
                        $('#modal6').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save6').prop('disabled', false);
                        $('#modal6').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save6').prop('disabled', false);
                        $('#modal6').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });
        }
    });



    $(document).on('click', '#save7', function(e) {
        e.preventDefault();

        var comentario = $("#comentario7").val();

        var validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;

        var dataExp7 = new FormData();

        dataExp7.append("idCliente", getInfo5_2A[0]);
        dataExp7.append("nombreResidencial", getInfo5_2A[1]);
        dataExp7.append("nombreCondominio", getInfo5_2A[2]);
        dataExp7.append("idCondominio", getInfo5_2A[3]);
        dataExp7.append("nombreLote", getInfo5_2A[4]);
        dataExp7.append("idLote", getInfo5_2A[5]);
        dataExp7.append("comentario", comentario);
        dataExp7.append("fechaVenc", getInfo5_2A[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#save7').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2/',
                data: dataExp7,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#save7').prop('disabled', false);
                        $('#modal7').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#save7').prop('disabled', false);
                        $('#modal7').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#save7').prop('disabled', false);
                        $('#modal7').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });
        }
    });


    $(document).on('click', '#b_return1', function(e) {
        e.preventDefault();

        var comentario = $("#comentario8").val();

        var validaComent = ($("#comentario8").val().length == 0) ? 0 : 1;

        var dataExp8 = new FormData();

        dataExp8.append("idCliente", return1a[0]);
        dataExp8.append("nombreResidencial", return1a[1]);
        dataExp8.append("nombreCondominio", return1a[2]);
        dataExp8.append("idCondominio", return1a[3]);
        dataExp8.append("nombreLote", return1a[4]);
        dataExp8.append("idLote", return1a[5]);
        dataExp8.append("comentario", comentario);
        dataExp8.append("fechaVenc", return1a[6]);


        if (validaComent == 0) {
            alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
        }

        if (validaComent == 1) {
            $('#b_return1').prop('disabled', true);
            $.ajax({
                url : '<?=base_url()?>index.php/asesor/return1aaj/',
                data: dataExp8,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    response = JSON.parse(data);
                    if(response.message == 'OK') {
                        $('#b_return1').prop('disabled', false);
                        $('#modal_return1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if(response.message == 'FALSE'){
                        $('#b_return1').prop('disabled', false);
                        $('#modal_return1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                    } else if(response.message == 'ERROR'){
                        $('#b_return1').prop('disabled', false);
                        $('#modal_return1').modal('hide');
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    }
                },
                error: function( data ){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });
        }
    });



    jQuery(document).ready(function(){


        jQuery('#modal1').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario').val('');
        })

        jQuery('#modal2').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario2').val('');
        })

        jQuery('#modal3').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario3').val('');
        })

        jQuery('#modal4').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario4').val('');
        })

        jQuery('#modal5').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario5').val('');
        })

        jQuery('#modal6').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario6').val('');
        })

        jQuery('#modal7').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario7').val('');
        })

        jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#comentario8').val('');
        })
    })

    function customButton(dsType, idMovimiento, estatus, nombreLote, id_cliente, nombreResidencial, nombreCondominio, idCondominio, idLote, fechaVenc,attBtn = ''){        
        especialClass = idMovimiento == 31 ? 'getInfo2' : idMovimiento == 85 ? 'getInfo2_2'  : idMovimiento == 20 ? 'getInfo5' :  idMovimiento == 63 ? 'getInfo6' : idMovimiento == 73 ? 'getInfo2_3' : idMovimiento == 82 ? 'getInfo2_7' : idMovimiento == 92 ? 'getInfo5_2' : idMovimiento == 96 ? 'return1' : comentario;

        stringBtn = '<a href="#" '+attBtn+' data-estatus="'+estatus+'" data-nomLote="'+nombreLote+'" data-idCliente="'+id_cliente+'" data-nombreResidencial="'+nombreResidencial+'" data-nombreCondominio="'+nombreCondominio+'" data-nombreLote="'+nombreLote+'" data-idCondominio="'+idCondominio+'" data-idLote="'+idLote+'" data-fechavenc="'+fechaVenc+'" class="btn-data btn-green '+especialClass+'">  <i class="fas fa-check" title= "Enviar estatus"></i></a>';

        if (dsType == 1){
            dsbutton = '<a class="btn-data btn-blueMaderas btn_ds'+id_cliente+'" '+attBtn+' id="btn_ds'+id_cliente+'" href="'+url_to_go+'" title= "Depósito de seriedad"><i class="fas fa-print"></i></a>';
        } else if(dsType == 2) { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA OLD VERSION
            dsbutton = '<a class="btn-data btn-blueMaderas" href="<?=base_url()?>index.php/Asesor/deposito_seriedad_ds/'+id_cliente+'/0" title= "Depósito de seriedad"><i class="fas fa-print"></i></a>';
        }

        var dsbutton = '<a class="btn-data btn-blueMaderas" href="<?=base_url()?>index.php/Asesor/deposito_seriedad_ds/'+id_cliente+'/0" title= "Depósito de seriedad"><i class="fas fa-print"></i></a>';
        return stringBtn;
    }
</script>