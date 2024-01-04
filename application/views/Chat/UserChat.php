<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <style type="text/css">
            .btn-circle.btn-xl {
                width: 70px;
                height: 70px;
                padding: 10px 16px;
                border-radius: 35px;
                font-size: 24px;
                line-height: 1.33;
            }
            .box-img{
                border-radius: 50%;
                border: 2px solid white;
                width: 170px;
                height: 170px;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
        
        <?php
            if ($this->session->userdata('id_rol') == 20 && empty($permiso)) {
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
            }
            if($this->session->userdata('id_rol') == 20 && $permiso[0]['estado'] ==0){
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
                //ok
            }
            if ($this->session->userdata('id_rol') == 19 && empty($permiso)) {
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
            }
            if($this->session->userdata('id_rol') == 19 && $permiso[0]['estado'] ==0){
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';//ok
            }
            /*-------------------------------------------------------*/
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;  
            $this->load->view('template/sidebar', $datos);
            /*--------------------------------------------------------*/
        ?>

        <!-- Modals -->
        <div class="modal fade" id="EstadoperfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirmar operación</h5>
                    </div>
                    <div class="modal-body">
                    <form id="formestado">
                        <input type="hidden" name="idasesorE" id="idasesorE">
                        <input type="hidden" name="estadoE" id="estadoE">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 30px!important; margin-left: 5px">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Bloquear" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmar operación</h5>
                
                </div>
                <div class="modal-body">
                <form id="formbloqueado">
                    <input type="hidden" name="idasesorB" id="idasesorB">
                    <input type="hidden" name="bloqueado" id="bloqueado">
                
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 30px!important; margin-left: 5px">Aceptar</button>
                    </form>
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="AutperfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro que desea autorizar al usuario seleccionado?</h5>
                    
                    </div>
                    <div class="modal-body">
                    <form id="formAut">
                        <input type="hidden" name="idasesorAut" id="idasesorAut">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 30px!important; margin-left: 5px">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EditarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" style="width: 28%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Editar perfil chat</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 d-flex justify-center">
                                <div class="box-img">

                                </div>
                            </div>
                        </div>
                        <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                            <div class="container-fluid">
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group label-floating div_name">
                                            <label class="label p-0">Mensaje de bienvenida</label>
                                            <textarea class="form-control scroll-styles" name="mensajeE" id="mensajeE" rows="2" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="label p-0">Número de chats</label>
                                            <input id="num_chatE" name="num_chatE" type="number" class="form-control" required="number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">             
                                        <label for="file-upload" class="custom-file-upload">
                                            <i class="fa fa-cloud-upload"></i> Subir archivo
                                        </label>
                                        <input id="file-uploadE" name="file-uploadE" accept=".png, .jpeg, .jpg" type="file"/>
                                        <input type="hidden" id="filenameE" name="filenameE" />
                                        <p id="archivoE"></p>						        	
                                    </div>
                                    <div class="col-md-12" style="display:flex; justify-content: flex-end; padding:10px 0 0 0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                                        <button type="submit" class="btn btn-primary" style="padding: 12px 30px!important; margin-left: 5px">Aceptar</button>
                                    </div>
                                    <input type="hidden" name="idasesorEp" id="idasesorEp">
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editPerfilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" style="width: 28%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Agregar perfil de chat</h4>
                    </div>
                    
                    <div class="modal-body">
                        <form id="editPerfilForm" name="editUsersForm" method="post">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating div_name">
                                            <label class="control-label p-0">Mensaje de bienvenida <small>(requerido)</small></label>
                                            <textarea class="form-control" name="mensaje" id="mensaje" rows="2" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group label-floating div_last_name">
                                            <label class="control-label p-0">Número de chats<small>(requerido)</small></label>
                                            <input id="num_chat" name="num_chat" type="number" class="form-control" required="number">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">             
                                        <label for="file-upload" class="custom-file-upload">
                                            <i class="fa fa-cloud-upload"></i> Subir archivo
                                        </label>
                                        <input id="file-upload" name="file-upload" required="" accept=".png, .jpeg, .jpg" type="file"/>
                                        <input type="hidden" id="filename" name="filename">
                                    </div>
                                    <input type="hidden" name="idasesor" id="idasesor">
                                    <div class="col-sm-12" style="display:flex; justify-content: flex-end; padding:10px 0 0 0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                                        <button type="submit" id="btnsave" class="btn btn-primary" style="padding: 12px 30px!important; margin-left: 5px">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END modals -->

       <div class="content boxContent">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-lg-4">
                        <a href="<?=base_url()?>Chat/UsersOnline/1 " style="background: #47F2C8;" class="btn btn-danger btn-circle btn-xl"><span class="material-icons" style="font-size: 40px;">record_voice_over</span><span class="new badge" style="color: white;background: #C00F0F;"><?=count($online)?></span></a>
                        <br><b>Online</b>
                    </div>

                    <div class="col-lg-4">
                        <a href="<?=base_url()?>Chat/UsersOnline/2" style="background: #F9C87D;" class="btn btn-danger btn-circle btn-xl"><span class="material-icons" style="font-size: 40px;">supervised_user_circle</span><span class="new badge" style="color: white;background: #C00F0F;"><?=count($consulta)?></span></a>
                        <br><b>Consulta</b> 
                    </div>
                    <div class="col-lg-4">
                        <a href="<?=base_url()?>Chat/UsersOnline/3" style="background: #9C7831;"  class="btn btn-danger btn-circle btn-xl"><span class="material-icons" style="font-size: 40px;">voice_over_off</span><span class="new badge" style="color: white;background: #C00F0F;"><?=count($offline)?></span></a>
                        <br> <b>Offline</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <h3 class="card-title center-align">Usuarios</h3>
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="users_datatable" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ESTATUS</th>
                                                        <th>ID</th>
                                                        <th>NOMBRE</th>
                                                        <th>TELÉFONO</th>
                                                        <th>NÚMERO DE CHAT</th>
                                                        <th>JEFE DIRECTO</th>
                                                        <th>SEDE</th>
                                                        <th>TIPO</th>
                                                        <th>ACCIONES</th>
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
    <script type="text/javascript">
        let usuario = <?=$this->session->userdata('id_rol')?>

        let v2;

        $("#file-uploadE").on('change', function(e){ 		
            v2 = document.getElementById("file-uploadE").files[0].name; 
        });

        $(document).ready(function () {
            $('#users_datatable thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                if ( i != 8 ) {
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function (){
                        if (allUsersTable.column(i).search() !== this.value ) {
                            allUsersTable
                            .column(i)
                            .search(this.value)
                            .draw();
                        }
                    });
                }
            });

            allUsersTable = $('#users_datatable').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                    }
                ],
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
                columns: [
                { 
                    data: function (d) {
                        if (d.estado == 1) {
                            if (d.estatus == 3 ) {
                                return '<center><b>Alta<br></b><span class="label label-danger" style="background:#C8CFD0">Off line</span><center>';
                            }
                            else if(d.estatus == 2){
                                return '<center><b>Alta<br></b><span class="label label-danger" style="background:#F9C87D">Consulta</span><center>';
                            }
                            else if(d.estatus == 1){
                                return '<center><b>Alta<br></b><span class="label label-danger" style="background:#27AE60">En linea</span><center>';
                            }
                            else if(d.estatus == 4){
                                return '<center><b>Alta<br></b><span class="label label-danger" style="background:#47F2C8">Autorizado</span><center>';  
                            } 
                        } 
                        else if(d.estado == 0){
                            return '<center><span class="label label-warning" >Dado de baja</span><center>';
                        }
                        else if(d.estado == undefined || d.estado == null){
                            return '<center><span class="label label-danger" style="background:#E74C3C">No agregado</span><center>';
                        }
                    }
                },
                { 
                    data: function (d) {
                        return d.id_usuario;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        return d.telefono;
                    }
                },
                { 
                    "width": "15%",
                    data: function (d) {
                    if(d.num_chat == null){
                        return '0';
                    }else{
                        return d.num_chat;
                    }
                    
                    }
                },
                { 
                    data: function (d) {
                        if(d.num_chat == null){
                            return 'N/A';
                        }
                        else{
                            return d.jefe_directo;
                        }
                    }
                },
                { 
                    data: function (d) {
                        if(d.id_rol == 7){
                            if(d.sede == 1){
                                return '<p class="m-0">San Luis Potosí</p>';
                            }
                            else if(d.sede == 2){
                                return '<p class="m-0">Querétaro</p>';
                            }
                            else if(d.sede == 3){
                                return '<p class="m-0">Península</p>';
                            }
                            else if(d.sede == 4){
                                return '<p class="m-0">Ciudad de México</p>';
                            }
                            else if(d.sede == 5){
                                return '<p class="m-0">León</p>';
                            }
                            else if(d.sede == 6){
                                return '<p class="m-0">Cancún</p>';
                            }
                            else if(d.sede == 7){
                                return '<p class="m-0">United States</p>';
                            }
                            else if(d.sede == 8){
                                return '<p class="m-0">Tijuana</p>';
                            }
                            else if(d.sede == '1,2'){
                                return '<p class="m-0">Querétaro</p>';
                            }
                        }
                        else if(d.id_rol == 19){
                            if(d.id_usuario == 1981){
                                return '<p class="m-0">Península, Ciudad de México, León, Cancún</p>';
                            }
                            else{
                                return '<p class="m-0">San Luis Potosí, Querétaro</p>';
                            }
                        } 
                        else if(d.id_rol == 20){
                            if(d.sede == 1){
                                return '<p class="m-0">San Luis Potosí</p>';
                            }
                            else if(d.sede == 2){
                                return '<p class="m-0">Querétaro</p>';
                            }
                            else if(d.sede == 3){
                                return '<p class="m-0">Península</p>';
                            }
                            else if(d.sede == 4){
                                return '<p class="m-0">Ciudad de México</p>';
                            }
                            else if(d.sede == 5){
                                return '<p class="m-0">León</p>';
                            }
                            else if(d.sede == 6){
                                return '<p class="m-0">Cancún</p>';
                            }
                            else if(d.sede == 7){
                                return '<p class="m-0">United States</p>';
                            }
                            else if(d.sede == 8){
                                return '<p class="m-0">Tijuana</p>';
                            }
                        }
                        else if(d.id_rol == 3){
                            if(d.sede == 1){
                                return '<p class="m-0">San Luis Potosí</p>';
                            }
                            else if(d.sede == 2){
                                return '<p class="m-0">Querétaro</p>';
                            }
                            else if(d.sede == 3){
                                return '<p class="m-0">Península</p>';
                            }
                            else if(d.sede == 4){
                                return '<p class="m-0">Ciudad de México</p>';
                            }
                            else if(d.sede == 5){
                                return '<p class="m-0">León</p>';
                            }
                            else if(d.sede == 6){
                                return '<p class="m-0">Cancún</p>';
                            }
                            else if(d.sede == 7){
                                return '<p class="m-0">United States</p>';
                            }
                            else if(d.sede == 8){
                                return '<p class="m-0">Tijuana</p>';
                            }
                        }
                    }
                },
                { 
                    data: function (d) {
                        if(d.id_rol == 7){
                            return '<p class="m-0">Asesor</p>';
                        }
                        else if(d.id_rol == 19){
                            return '<p class="m-0">Supervisor</p>';
                        } 
                        else if(d.id_rol == 20){
                            return '<p class="m-0">Gerente</p>';
                        }
                        else if(d.id_rol == 3){
                            return '<p class="m-0">Gerente comercial</p>';
                        }
                    }
                },
                { 
                    data: function (d) {
                        if(usuario == 28 || usuario == 18){
                            if(d.id_rol == 7){
                                if (d.estado != undefined) {
                                    if (d.estado == 1) {
                                        if (d.estatus ==3) {
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                            '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                        }
                                        else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                            '<button class="btn-data btn-orangeYellow bloquear-user-perfil" data-id-usuario="' + d.id_usuario +'"  title="Bloquear"><i class="fas fa-lock"></i></button></div>';
                                        }     
                                    }
                                    else{
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                    }   
                                } 
                                else{
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></div>';
                                }
                            }
                            else if(d.id_rol == 19){
                                if (d.estado != undefined) {
                                    if (d.estado == 1) {
                                        if (d.estatus ==3) {
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                            '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                        }
                                        else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button></div>';
                                        }
                                    }
                                    else{
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                    }
                                } 
                                else {
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></div>';
                                }
                            }
                            else if(d.id_rol == 20){
                                if (d.estado != undefined) {
                                    if (d.estado == 1) {
                                        if (d.estatus ==3) {
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                            '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                        }
                                        else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button></div>';
                                        }            
                                    }
                                    else{
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                    }        
                                } 
                                else {
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></button></div>';
                                }

                            }
                            else if(d.id_rol == 3){
                                if (d.estado != undefined) {
                                    if (d.estado == 1) {
                                        if (d.estatus ==3) {
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                            '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                        }
                                        else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                            return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button></div>';
                                        }                                
                                    }
                                    else{
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                    }
                                } 
                                else {
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></div>';
                                }
                            }
                        }
                        else if(usuario == 19){
                            if (d.estado != undefined) {
                                if (d.estado == 1) {
                                    if (d.estatus ==3) {
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                        '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                    }
                                    else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button></div>';
                                    }                
                                }
                                else{
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                }            
                            } 
                            else {
                                return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></div>';
                            }
                        }
                        else if(usuario == 20){
                            if (d.estado != undefined) {
                                if (d.estado == 1) {
                                    if (d.estatus ==3) {
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button>'+
                                        '<button class="btn-data btn-warning baja_perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de baja"><i class="fas fa-thumbs-down"></i></button></div>';
                                    }
                                    else if(d.estatus == 1 || d.estatus ==4 || d.estatus ==2){
                                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-user-perfil" data-id-usuario="' + d.id_usuario +'" title="Editar"><i class="fas fa-pencil-alt"></i></button></div>';
                                    }                
                                }
                                else{
                                    return '<div class="d-flex justify-center"><button class="btn-data btn-green alta-perfil" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="right" title="Dar de alta"><i class="fas fa-thumbs-up"></i></button></div>';
                                }  
                            }
                            else {
                                return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_perfil" data-id-usuario="' + d.id_usuario +'" title="Agregar perfil de chat"><i class="fa fa-comments" aria-hidden="true"></i></button></div>';
                            }
                        }
                    }
                }],
                ajax: {
                    "url": "<?=base_url()?>Chat/UserChats",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(document).on('click', '.add_perfil', function(e){
            id_asesor = $(this).attr("data-id-usuario");
            $('#idasesor').val(id_asesor);      
            $("#editPerfilModal").modal();

        });

        $(document).on('click', '.edit-user-perfil', function(e){
            let id_asesor = $(this).attr("data-id-usuario");
            $.getJSON("getInfoPerfilGte/"+id_asesor).done( function( data ){
                $.each( data, function(i, v){
                    $("#EditarPerfilModal").modal();
                    fillFields(v);
                });
            });
        
            function fillFields (v) {
                $("#mensajeE").val(v.mensaje);
                $("#num_chatE").val(v.num_chat);
                document.getElementById("archivoE").innerHTML = v.foto;
                $('.box-img').css('background-image', 'url(../static/images/perfil/' +v.id_usuario+'/'+v.foto +')');
                $("#idasesorEp").val(v.id_usuario);
                $('#filenameE').val(v.foto);
            }

        });


        $("#EditarPerfilForm").on('submit', function(e){ 
            let val=0;
            if (v2 == undefined || v2 == '') { val =1; }
            else{ val=2; }

            e.preventDefault();
            let mensaje = $('#mensajeE').val();
            let numeros =  getNumbersInString(mensaje);

            if(numeros.length > 2 || mensaje.indexOf('@') >= 0){
                alerts.showNotification("top", "right", "No se permite ingresar teléfonos ni correos en este campo.", "warning");
            }
            else{
                var formData = new FormData(document.getElementById("EditarPerfilForm"));
                formData.append("dato", "valor");   
                $.ajax({
                    type: 'POST',
                    url: 'UpdatePerfil/'+val,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        // Actions before send post
                    },
                    success: function(data) {
                        if (data == 1) {
                            document.getElementById("EditarPerfilForm").reset();
                            $("#EditarPerfilModal").modal('hide'); 
                            alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                            allUsersTable.ajax.reload();
                        } else {
                            document.getElementById("EditarPerfilForm").reset();
                            $("#EditarPerfilModal").modal('hide'); 
                            allUsersTable.ajax.reload();
                            alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                        }
                    },
                    error: function(){
                        $('#users_datatable').DataTable().ajax.reload(null, false);
                        $("#EditarPerfilModal").modal('hide'); 
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        });

        /*---VOLVER A  DAR DE ALTA EL ASESOR ----*/
        $(document).on('click', '.baja_perfil', function(e){
            let id_asesor = $(this).attr("data-id-usuario");
            $('#idasesorE').val(id_asesor); 
            $('#estadoE').val("0");
            $("#EstadoperfilModal").modal();
        });

        $(document).on('click', '.bloquear-user-perfil', function(e){
            let id_asesor = $(this).attr("data-id-usuario");
            $('#idasesorB').val(id_asesor); 
            $('#bloqueado').val("1");
            $("#Bloquear").modal();
        });

        $(document).on('click', '.aut_perfil', function(e){
            let id_asesor = $(this).attr("data-id-usuario");
            $('#idasesorAut').val(id_asesor); 
            $("#AutperfilModal").modal();
        });

        $(document).on('click', '.alta-perfil', function(e){
            let id_asesor = $(this).attr("data-id-usuario");
            $('#idasesorE').val(id_asesor); 
            $('#estadoE').val("1");
            $("#EstadoperfilModal").modal();
        });

        $("#formestado").on('submit', function(e){ 
            e.preventDefault();
            var formData = new FormData(document.getElementById("formestado"));
            formData.append("dato", "valor");   
            $.ajax({
                type: 'POST',
                url: 'EstadoPerfil',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        $("#EstadoperfilModal").modal('hide'); 
                        alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                        allUsersTable.ajax.reload();
                    } else {
                        $("#EstadoperfilModal").modal('hide'); 
                        allUsersTable.ajax.reload();
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    $("#EstadoperfilModal").modal('hide'); 
                    allUsersTable.ajax.reload();
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });


        $("#formbloqueado").on('submit', function(e){ 
            e.preventDefault();
            var formData = new FormData(document.getElementById("formbloqueado"));
            formData.append("dato", "valor");   
            $.ajax({
                type: 'POST',
                url: 'BloquearUsuario',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        $("#Bloquear").modal('hide'); 
                        alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                        allUsersTable.ajax.reload();
                    } else {
                        $("#Bloquear").modal('hide'); 
                        allUsersTable.ajax.reload();
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    $("#Bloquear").modal('hide'); 
                    allUsersTable.ajax.reload();
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        /*-----------------------------*/
        $("#editPerfilForm").on('submit', function(e){ 
            e.preventDefault();
            $("#btnsave").button({ disabled: true });
            document.getElementById('btnsave').disabled=true;
            let mensaje = $('#mensaje').val();
            let numeros =  getNumbersInString(mensaje);

            if(numeros.length > 2 || mensaje.indexOf('@') >= 0){
                alerts.showNotification("top", "right", "No se permite ingresar teléfonos ni correos en este campo.", "warning");
            }
            else{
                var formData = new FormData(document.getElementById("editPerfilForm"));
                formData.append("dato", "valor");
                $.ajax({
                    type: 'POST',
                    url: 'savePerfil', 
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        // Actions before send post
                    },
                    success: function(data) {
                        
                        if (data == 1) {
                            $('#mensaje').val("");
                            $('#num_chat').val("");
                            $('#filename').val("");
                            $('#file-upload').val("");

                            $('#users_datatable').DataTable().ajax.reload(null, false);
                            $("#editPerfilModal").modal('hide');
                            document.getElementById('btnsave').disabled=false;
                            alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                        } else {
                        
                            $('#users_datatable').DataTable().ajax.reload(null, false);
                            $("#editPerfilModal").modal('hide');
                        //	allUsersTable.ajax.reload();
                        document.getElementById('btnsave').disabled=false;
                            alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                        }
                    },
                    error: function(){
                        $('#users_datatable').DataTable().ajax.reload(null, false);
                        $("#editPerfilModal").modal('hide');
                    //	allUsersTable.ajax.reload();
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        });

        /**------------------------------------------------------------------------------------- */


        function LoadingSpinner (form, spinnerHTML) {
            form = form || document

            //Keep track of button & spinner, so there's only one automatic spinner per form
            var button
            var spinner = document.createElement('div')
            spinner.innerHTML = spinnerHTML
            spinner = spinner.firstChild

            //Delegate events to a root element, so you don't need to attach a spinner to each individual button.
            form.addEventListener('click', start)

            //Stop automatic spinner if validation prevents submitting the form
            //Invalid event doesn't bubble, so use capture
            form.addEventListener('invalid', stop, true)

            //Start spinning only when you click a submit button
            function start (event) {
                if (button) stop()
                button = event.target
                if (button.type === 'submit') {
                LoadingSpinner.start(button, spinner)
                }
            }

            function stop () {
                LoadingSpinner.stop(button, spinner)
            }

            function destroy () {
                stop()
                form.removeEventListener('click', start)
                form.removeEventListener('invalid', stop, true)
            }
            return {start: start, stop: stop, destroy: destroy}
        }

        LoadingSpinner.start = function (element, spinner) {
            element.classList.add('loading')
            return element.appendChild(spinner)
        }

        LoadingSpinner.stop = function (element, spinner) {
            element.classList.remove('loading')
            return spinner.remove()
        }

        var exampleForm = document.querySelector('#editPerfilForm')
        var exampleLoader = new LoadingSpinner(exampleForm, 'Guardando....')
        //Delay submit so you can see the spinner spinning, then stop the loading spinner instead of submitting because we're on Codepen.
        exampleForm.addEventListener('submit', function (event) {
        event.preventDefault()
        setTimeout(function () {
            exampleLoader.stop()
        }, 2000)
        })

        /*--------------------------------------------------------------------------------------*/
        $("#formAut").on('submit', function(e){ 
            e.preventDefault();
            var formData = new FormData(document.getElementById("formAut"));
            formData.append("dato", "valor");
            $.ajax({
                type: 'POST',
                url: 'AutPerfil',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        $("#AutperfilModal").modal('hide');
                        alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                        allUsersTable.ajax.reload();
                    } else {
                        $("#AutperfilModal").modal('hide');
                        allUsersTable.ajax.reload();
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    $("#AutperfilModal").modal('hide');
                    allUsersTable.ajax.reload();
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        function getNumbersInString(string) {
            var tmp = string.split("");
            var map = tmp.map(function(current) {
                if (!isNaN(parseInt(current))) {
                    return current;
                }
            });

            var numbers = map.filter(function(value) {
                return value != undefined;
            });

            return numbers.join("");
        }
    </script>
</body>
</html>