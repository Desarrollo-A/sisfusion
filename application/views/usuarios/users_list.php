<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

    <style>
        .boxIcon{
            width: 30px;
            height: 30px;
            display: flex;
            background-color: #e6f1fa;
            color: #003d82;
            border-radius: 27px;
            justify-content: center;
            align-items: center;
        }
        .boxInfoEsp{
            position: absolute;
            top: -13px;
            left: 0;
            font-size: 10px;
            height: 15px;
            width: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e6f1fa;
            border-radius: 27px;
            color: #003d82;
        }        
        #showPass {
            cursor: pointer;
            position: absolute;
            top: 44px;
            right: 15px;
        }
        .selectE{
            background-color: #eaeaea!important;
            border-radius: 27px!important;
            background-image: none!important;
        }
    </style>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>  

            <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>
                            <h4 class="modal-title" data-i18n="usuario-contrasena">Usuario y Contraseña :</h4>
                        </div>
                            <div class="modal-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" data-i18n="usuario">Usuario</label>
                                    </div>
                                    <input  class="form-control input-gral pl-1 pr-1" readonly type="text" id="usuarioPC" name="usuarioPC" value="">
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" data-i18n="contrasena">Contraseña</label>
                                    </div>
                                    <input  class="form-control input-gral pl-1 pr-1" readonly type="text" id="passPC" name="passPC" value="" >
                                </div>
                            </div>
                            <div class="modal-footer"></div>
                    </div>
                </div>    
            </div>
        
            <div class="modal fade" id="BajaUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>
                            <h4 class="modal-title" data-i18n="dar-baja">Baja del usuario: <b id="nameUs"></b></h4>
                        </div>
                        <form id="BajaUserForm" name="BajaUsersForm" method="post">
                            <div class="modal-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label"><span data-i18n="motivo">Motivo de baja </span> <small data-i18n="requerido">(requerido)</small></label>
                                        <textarea id="motivo" name="motivo" class="form-control" required></textarea>
                                        <input type="hidden" name="id_user" id="id_user">
                                        <input type="hidden" name="idrol" id="idrol">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple"onclick="CloseModalBaja()" data-i18n="cancelar">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btnS" data-i18n="aceptar">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="BajaConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="BajaConfirmM()" aria-hidden="true"><i class="material-icons">clear</i></button>
                            <h4 class="modal-title"><h4 id="msj"></h4><b id="nameUs2"></b>?</h4>
                        </div>
                        <form id="BajaConfirmForm" name="BajaConfirmForm" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="iduser" id="iduser">
                                <input type="hidden" name="id_rol" id="id_rol">
                                <input type="hidden" name="status" id="status">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" onclick="BajaConfirmM()" data-i18n="cancelar">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btnSub" data-i18n="aceptar">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="changesRegsUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"aria-hidden="true">
                                <i class="material-icons" onclick="cleanComments()">clear</i>
                            </button>
                            <h4 class="modal-title" data-i18n="consulta-informacion">Consulta información</h4>
                        </div>
                        <div class="modal-body">
                            <div role="tabpanel">
                                <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                    <li role="presentation" class="active">
                                        <a href="#changelogUsersTab" aria-controls="changelogUsersTab" role="tab" data-toggle="tab" data-i18n="bitacora-cambios">Bitácora de cambios</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="changelogUsersTab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-plain">
                                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                        <ul class="timeline-3" id="changelogUsers"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-i18n="cerrar">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>
                            <h4 class="modal-title" data-i18n="editar-informacion">Edita tu información</h4>
                        </div>
                        <form id="editUserForm" name="editUsersForm" method="post">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="nombre">Nombre (<span class="isRequired">*</span>)</label>
                                                <input id="name" name="name" onkeyup="javascript:this.value=this.value.toUpperCase();" onchange="validateInputs(this);" type="text" class="form-control input-gral" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="ap-paterno">Apellido paterno (<span class="isRequired">*</span>)</label>
                                                <input id="last_name" onkeyup="javascript:this.value=this.value.toUpperCase();" onchange="validateInputs(this);" name="last_name" type="text" class="form-control input-gral" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label" data-i18n="ap-materno">Apellido materno</label>
                                                <input id="mothers_last_name" onkeyup="javascript:this.value=this.value.toUpperCase();" onchange="validateInputs(this);" name="mothers_last_name" type="text" class="form-control input-gral">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group ">
                                                <label class="control-label">RFC (<small class="isRequired">*</small>)</label>
                                                <input id="rfc" name="rfc" onkeyup="javascript:this.value=this.value.toUpperCase();" onchange="validateInputs(this);" type="text" class="form-control input-gral" required maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label" data-i18n="forma-pago">Forma de pago (<small class="isRequired">*</small>)</label>
                                                <select class="selectpicker select-gral payment_method m-0" id="payment_method" name="payment_method" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required disabled></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group ">
                                                <label class="control-label" data-i18n="correo">Correo electrónico (<small class="isRequired">*</small>)</label>
                                                <input id="email" name="email" type="email" onkeyup="javascript:this.value=this.value.toUpperCase();" onchange="validateInputs(this);" class="form-control input-gral pl-1 pr-1" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group ">
                                                <label class="control-label" data-i18n="telefono">Teléfono celular (<small class="isRequired">*</small>) </label>
                                                <input id="phone_number" name="phone_number" type="number" class="form-control input-gral" required maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label" data-i18n="sede">Sede (<small class="isRequired">*</small>)</label>
                                                <select class="selectpicker select-gral m-0" id="headquarter" name="headquarter" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required onchange="cleadFieldsHeadquarterChange()"></select>
                                            </div>
                                        </div>
                                        <div class="col-estructura">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3" id="tipoMiembro_column">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label" data-i18n="tipo-miembro">Tipo de miembro (<small class="isRequired">*</small>)</label>
                                                <select class="selectpicker select-gral m-0" id="member_type" name="member_type" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required onchange="getLeadersList()"></select>
                                            </div>
                                        </div>
                                        <div class="simbolico_column"></div>
                                        <div class="fac_humano_column"></div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6">
                                            <div class="form-group overflow-hidden">
                                                <input type="hidden" name="rol_actual" id="rol_actual">
                                                <label class="control-label" data-i18n="lider">Líder (<small class="isRequired">*</small>)</label>
                                                <select class="selectpicker select-gral m-0" id="leader" name="leader" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                </div>
                                <!---LÍNEA DE VENTA--->
                                <div class="container-fluid" id="lineaVenta"></div>
                                <!--MULTIROL--->
                                <div id="btnmultirol" class="container-fluid"></div>
                                <input type="hidden" name="index" id="index" value="0">
                                <div class="container-fluid">
                                    <div class="row aligned-row" id="multirol"></div>
                                </div>
                                <!------------->
                                <div class="container-fluid mt-1" id="ch">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-end">
                                            <div class="boxIcon" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Sede capital humano y sucursal capital humano.<br/><br/>Son información que se solicita de manera adicional para mantener actualizado tanto el sistema de Capital Humano como CRM actualizados.">
                                                <i class="fas fa-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label ml-2" data-i18n="sede-capital-humano">Sede capital humano</label>
                                                <div class="boxInfoEsp">
                                                    <i class="fas fa-info" data-toggle="tooltip" data-placement="bottom" title="Sede de asignación del asesor"></i>
                                                </div>
                                                <select class="selectpicker select-gral m-0" id="sedech" name="sedech" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label ml-2" data-i18n="sucursal-capital-humano">Sucursal de capital humano</label>
                                                <div class="boxInfoEsp" data-toggle="tooltip" data-placement="bottom" title="Oficina en la que se encuentra ubicado el asesor">
                                                    <i class="fas fa-info"></i>
                                                </div>
                                                <select class="selectpicker select-gral m-0" id="sucursal" name="sucursal" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group m-0">
                                                <label class="control-label" data-i18n="nombre-usuario">Nombre de usuario (<small class="isRequired">*</small>)</label>
                                                <input id="username" name="username" type="text" class="form-control input-gral" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-0">
                                                <label class="control-label" data-i18n="contrasena">Contraseña</label>
                                                <input type="password" id="contrasena" name="contrasena" class="form-control input-gral" required="" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <span id="showPass" onclick="showPassword()">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                    <i class="fa fa-eye" aria-hidden="true" style="display:none;"></i>
                                                </span>
                                                <input id="id_usuario" name="id_usuario" type="hidden" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="containerMenu" class="mb-1 hide">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 mb-1">
                                            <label class="control-label" data-i18n="menu-usuario">Menú del usuario (<span class="isRequired">*</span>)</label>
                                            <div id="listadoHTML"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-end">
                                            <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal" data-i18n="cancelar">Cancelar</button>
                                            <button type="submit" id="btn_acept" class="btn btn-primary mt-1" data-i18n="aceptar">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
            <!-----MODAL PARA AVISO ELIMNAR ROL------->
            <div class="modal fade" id="modalDelRol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"data-keyboard="false">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h6>¿Esta seguro que que desea eliminar este rol?</h6>
                    </div>
                        <form id="deleteRol" name="deleteRol" method="post">
                            <div class="modal-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="hidden" name="idRU" id="idRU">
                                        <input type="hidden" name="indice" id="indice">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary" id="btnS">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <!---------------------------------------->
    
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" data-i18n="lista-usuarios">Lista de usuarios</h3>
                                <div class="material-datatables">
                                    <table id="all_users_datatable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ESTATUS</th>
                                                <th>ID</th>
                                                <th>NOMBRE</th>
                                                <th>CORREO</th>
                                                <th>TELÉFONO</th>
                                                <th>ROL</th>
                                                <th>TIPO</th>
                                                <th>SEDE</th>
                                                <th>JEFE DIRECTO</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </body>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/usuarios-1.1.0.js"></script>
    </html>