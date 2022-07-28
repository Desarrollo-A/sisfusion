<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .buttons-html5 {
        margin-right: 10px;
    }
</style>
<div>
    <div class="wrapper">
        <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);
        ?>


        <style>
            .textoshead::placeholder { color: white; }
        </style>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Lista de usuarios</h3>
                                <div class="toolbar">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="all_users_datatable" class="table-striped table-hover" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th><center>ESTATUS</center></th>
                                                        <th><center>ID</center></th>
                                                        <th><center>NOMBRE</center></th>
                                                        <th><center>CORREO</center></th>
                                                        <th><center>TELÉFONO</center></th>
                                                        <th><center>TIPO</center></th>
                                                        <th><center>SEDE</center></th>
                                                        <th><center>FORMA PAGO</center></th>
                                                       <?php if($this->session->userdata('id_rol') != 49){ ?> <th><center>NACIONALIDAD</center></th> <?php } ?>
                                                        <th><center>COORDINADOR</center></th>
                                                        <th><center>GERENTE</center></th>
                                                        <th><center>SUBDIRECTOR</center></th>
                                                        <th><center>DIRECTOR REGIONAL</center></th>
                                                        <th><center>TIPO DE USUARIO</center></th>
                                                        <th><center>FECHA ALTA</center></th>
                                                        <th><center></center></th>
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

        <div class="modal fade" id="changesRegsUsers" tabindex="-1" role="dialog" 
                                                        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                
                                                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons" onclick="cleanComments()">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Consulta información</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div role="tabpanel">
                                                                        <!-- Nav tabs -->
                                                                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                                                            <li role="presentation" class="active"><a href="#changelogUsersTab" aria-controls="changelogUsersTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                                                                        </ul>
                                                                        <!-- Tab panes -->
                                                                        <div class="tab-content">
                                                                            <div role="tabpanel" class="tab-pane active" id="changelogUsersTab">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="card card-plain">
                                                                                            <div class="card-content">
                                                                                                <ul class="timeline timeline-simple" id="changelogUsers"></ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Edita su información</h4>
                                                                </div>
                                                                <form id="editUserForm" name="editUserForm" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group label-floating select-is-empty div_payment_method">
                                                                                <label class="control-label">Forma de pago <small>(requerido)</small></label>
                                                                                <select id="payment_method" name="payment_method" class="form-control payment_method" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group">
                                                                                <input id="id_usuario" name="id_usuario" type="hidden" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                            <i class="material-icons" onclick="cleanComments()">clear</i>
                                                                        </button>
                                                                        <h4 class="modal-title">Consulta información</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div role="tabpanel">
                                                                            <!-- Nav tabs -->
                                                                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                                                                <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                                                                            </ul>
                                                                            <!-- Tab panes -->
                                                                            <div class="tab-content">
                                                                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="card card-plain">
                                                                                                <div class="card-content">
                                                                                                    <ul class="timeline timeline-simple" id="changelog"></ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

        <?php $this->load->view('template/footer_legend');?>

    </div>
</div>
</body>

<?php $this->load->view('template/footer');?>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script>

    userType = <?= $this->session->userdata('id_rol') ?> ;
    userId = <?= $this->session->userdata('id_usuario') ?>;

    $.getJSON("getPaymentMethod").done( function( data ){
        $(".payment_method").append($('<option disabled selected>').val("").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".payment_method").append($('<option>').val(id).text(name));
        }
    });

    $('#all_users_datatable thead tr:eq(0) th').each( function (i) {

         if(i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#all_users_datatable').DataTable().column(i).search() !== this.value ) {
                $('#all_users_datatable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
        }
    });

    $('#all_users_datatable').DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Lista de usuarios',
                title:'Lista de usuarios',
                exportOptions: {
                
                    columns: userType == 49 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] ,
                    format: {
                        header: function (d, columnIdx) {

                            if(userType == 49){
                                switch (columnIdx) {
                                case 0:
                                    return 'ESTATUS';
                                    break;
                                case 1:
                                    return 'ID';
                                    break;
                                case 2:
                                    return 'NOMBRE';
                                case 3:
                                    return 'CORREO';
                                    break;
                                case 4:
                                    return 'TELÉFONO';
                                    break;
                                case 5:
                                    return 'TIPO';
                                    break;
                                case 6:
                                    return 'SEDE';
                                    break;
                                case 7:
                                    return 'FORMA PAGO';
                                    break;
                                case 8:
                                    return 'NACIONALIDAD';
                                    break;
                                case 9:
                                    return 'COORDINADOR';
                                    break;
                                case 10:
                                    return 'GERENTE';
                                    break;
                                case 11:
                                    return 'SUBDIRECTOR';
                                    break;
                                case 12:
                                    return 'DIRECTOR REGIONAL';
                                    break;
                                case 13:
                                    return 'TIPO DE USUARIO';
                                    break;
                                case 14:
                                    return 'FECHA ALTA';
                                    break;
                            }

                            }else{
                                switch (columnIdx) {
                                case 0:
                                    return 'ESTATUS';
                                    break;
                                case 1:
                                    return 'ID';
                                    break;
                                case 2:
                                    return 'NOMBRE';
                                case 3:
                                    return 'CORREO';
                                    break;
                                case 4:
                                    return 'TELÉFONO';
                                    break;
                                case 5:
                                    return 'TIPO';
                                    break;
                                case 6:
                                    return 'SEDE';
                                    break;
                                case 7:
                                    return 'FORMA PAGO';
                                    break;
                                case 8:
                                    return 'COORDINADOR';
                                    break;
                                case 9:
                                    return 'GERENTE';
                                    break;
                                case 10:
                                    return 'SUBDIRECTOR';
                                    break;
                                case 11:
                                    return 'DIRECTOR REGIONAL';
                                    break;
                                case 12:
                                    return 'TIPO DE USUARIO';
                                    break;
                                case 13:
                                    return 'FECHA ALTA';
                                    break;
                            }

                            }
                        }
                    }
                }
            }
        ],
        ordering: false,
        paging: true,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            {
                data: function (d) {

                    // return '<center><span class="label label-danger" style="background:#27AE60">'+d.nuevo+'</span><center>';

                    if (d.nuevo == 1) {
                        return '<center><span class="label label-info" >Nuevo usuario</span><center>';

                    } else {
                        if (d.estatus == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                        } else if (d.estatus == 3) {
                            boton =  '<center><span class="label label-danger" style="background:#E74C3C">Baja </span><center>';

                             <?php
                                        if($this->session->userdata('id_rol') == 49){
                                    ?>
                                     var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                    <?php
                                        }else{
                                    ?>
                                     var fecha_baja = '';
                                    <?php        
                                        }

                                    ?>
                                    

                                    return boton + fecha_baja;


                        } else {
                            if (d.abono_pendiente !== undefined) {
                                if (parseFloat(d.abono_pendiente) > 0) {
                                    boton = '<center><p class="mt-1"><span class="label label-danger" style="background:#E74C3C">Baja </span></p><center>';


                                    <?php
                                        if($this->session->userdata('id_rol') == 49){
                                    ?>
                                     var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                    <?php
                                        }else{
                                    ?>
                                     var fecha_baja = '';
                                    <?php        
                                        }

                                    ?>


                                    return boton + fecha_baja;

                                } else {
                                    // return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
                                    var boton = '<center><span class="label label-danger" style="background:#E74C3C">Baja </span></center>';
                                   
                                    <?php
                                        if($this->session->userdata('id_rol') == 49){
                                    ?>
                                     var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                    <?php
                                        }else{
                                    ?>
                                     var fecha_baja = '';
                                    <?php        
                                        }

                                    ?>
                                    return boton + fecha_baja;
                                }

                            } else {
                                // return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
                                    var boton = '<center><span class="label label-danger" style="background:#E74C3C">Baja </span></center>';
                                   
                                    <?php
                                        if($this->session->userdata('id_rol') == 49){
                                    ?>
                                     var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                    <?php
                                        }else{
                                    ?>
                                     var fecha_baja = '';
                                    <?php        
                                        }

                                    ?>
                                    return boton + fecha_baja;
                            }
                        }
                    }
                }
            },
            { data: function (d) {
                    return d.id_usuario;
                }
            },
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                    return d.correo;
                }
            },
            { data: function (d) {
                    return d.telefono;
                }
            },
            { data: function (d) {
                    return d.puesto;
                }
            },
            { data: function (d) {
                    return d.sede;
                }
            },
            { data: function (d) {
                    
                     if (userType == 49) {
                        if(d.usuariouniv==1){
                        return '<center><span class="label label-info">DESCUENTO UNIVERSIDAD</span><center>';
                        }else{
                        return '<center><span class="label label-info" style="background:gray">SIN DESCUENTO</span><center>';
                        }
                      }
                        else{
                            return d.forma_pago;
                        }
                }
            },
            <?php
                                        if($this->session->userdata('id_rol') != 49){
                                    ?>
            {
                
                 data: function (d) {
               

                        if(d.id_forma_pago == 5 && d.id_nacionalidad == 0){
                                return '<center>Sin definir<center>';
                            }else{
                                return '<center><span class="label label-danger" style="background:#'+d.color+'">'+d.nacionalidad+'</span><center>';

                            }
                        
               

                }


            },
            <?php
                                        }
                                    ?>
            { data: function (d) {
                    return d.coordinador == '  ' ? 'NO APLICA' : d.coordinador;
                }
            },
            { data: function (d) {
                    return d.gerente == '  ' ? 'NO APLICA' : d.gerente;
                }
            },
            { data: function (d) {
                    return d.subdirector == '  ' ? 'NO APLICA' : d.subdirector;
                }
            },
            { data: function (d) {
                    return d.regional == '  ' ? 'NO APLICA' : d.regional;
                }
            },
            {
                data: function (d) {
                    if (d.ismktd == 1)
                        return '<center><span class="label label-info">ES MKTD</span><center>';
                    else
                        return '<center><span class="label label-info" style="background:gray">SIN ESPECIFICAR</span><center>';
                }
            },
            { data: function (d) {
                    return d.fecha_creacion;
                }
            },
            { data: function (d) {
                    if (userId == 2767) {
                        return '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-user-information" data-id-usuario="' + d.id_usuario +'" style="margin-right: 5px;background-color:#2874A6;border-color:#21618C" title="Cambiar forma de pago"><i class="material-icons">edit</i></button>'+
                        '<button class="btn btn-success btn-round btn-fab btn-fab-mini see-user-information" data-id-usuario="' + d.id_usuario +'" style="background-color:#96843d;border-color:#48DBA7" title="Ver historial de cambios"><i class="material-icons">visibility</i></button>';
                    } else {
                        return '<button class="btn btn-success btn-round btn-fab btn-fab-mini see-user-information" data-id-usuario="' + d.id_usuario +'" style="background-color:#96843d;border-color:#48DBA7" title="Ver historial de cambios"><i class="material-icons">visibility</i></button>';
                    }
                }
            }
        ],
        "ajax": {
            "url": "getUsersList",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });

    $(document).on('click', '.edit-user-information', function(e){
        id_usuario = $(this).attr("data-id-usuario");
        $.getJSON("getUserInformation/"+id_usuario).done( function( data ){
            $.each( data, function(i, v){
                $("#editUserModal").modal();
                $("#payment_method").val(v.forma_pago);
                $("#id_usuario").val(v.id_usuario);
                $(".div_payment_method").removeClass("is-empty");
            });
        });
    });

    $(document).on('click', '.see-user-information', function(e){
        id_usuario = $(this).attr("data-id-usuario");
        $.getJSON("getChangelog/"+id_usuario).done( function( data ){
            $("#seeInformationModal").modal();
            $.each( data, function(i, v){
                fillChangelog(v);

            });
        });
    });

    function fillChangelog (v) {
        $("#changelog").append('<li class="timeline-inverted">\n' +
            '    <div class="timeline-badge success"><span class="material-icons">check</span></div>\n' +
            '    <div class="timeline-panel">\n' +
            '            <label><h6>'+v.parametro_modificado+'</h6></label><br>\n' +
            '            <b>Valor anterior:</b> '+v.anterior+'\n' +
            '            <br>\n' +
            '            <b>Valor nuevo:</b> '+v.nuevo+'\n' +
            '        <h6>\n' +
            '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.fecha_creacion+' - '+v.creador+'</span>\n' +
            '        </h6>\n' +
            '    </div>\n' +
            '</li>');
    }

    function cleanComments() {
        var myChangelog = document.getElementById('changelog');
        myChangelog.innerHTML = '';
    }

    $("#editUserForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'updateUser',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            },
            success: function(data) {
                if (data == 1) {
                    $('#editUserModal').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#all_users_datatable').DataTable().ajax.reload(null, false);
                } else {
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });


    $(document).on('click', '.see-changes-log', function(){
        id_usuario = $(this).attr("data-id-usuario");
        // console.log('camara alv :', id_usuario);
        $.post("getChangeLogUsers/"+id_usuario).done( function( data ){
            console.log("aqui es: " + data);
            $("#changesRegsUsers").modal();
            $.each( JSON.parse(data), function(i, v){
                // $("#changesRegsUsers").modal();
                fillChangelogUsers(v);
            });
        });
    });

</script>



</html>
