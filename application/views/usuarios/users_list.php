<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div>
    <div class="wrapper">
        <?php
        $this->load->view('template/sidebar', "");
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Lista de usuarios</h3>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="all_users_datatable" class="table-striped table-hover"
                                               style="text-align:center;"><!--table table-bordered table-hover -->
                                            <thead>
                                            <tr>
                                                <th class="disabled-sorting">ESTATUS</th>
                                                <th class="disabled-sorting text-right">
                                                    <center>ID</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>NOMBRE</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>CORREO</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>TELÉFONO</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>TIPO</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>SEDE</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>JEFE DIRECTO</center>
                                                </th>
                                                <th class="disabled-sorting text-right">
                                                    <center>ACCIONES</center>
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"
                                     data-keyboard="false">
                                    <div class="modal-dialog modal-lg   ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Edita tu información</h4>
                                            </div>
                                            <form id="editUserForm" name="editUsersForm" method="post">
                                                <div class="modal-body">
                                                    <div class="col-sm-6">
                                                        <div class="form-group label-floating div_name">
                                                            <label class="control-label">Nombre
                                                                <small>(requerido)</small></label>
                                                            <input id="name" name="name" type="text"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating div_last_name">
                                                            <label class="control-label">Apellido paterno <small>(requerido)</small></label>
                                                            <input id="last_name" name="last_name" type="text"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating div_mothers_last_name">
                                                            <label class="control-label">Apellido materno</label>
                                                            <input id="mothers_last_name" name="mothers_last_name"
                                                                   type="text" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating div_rfc">
                                                            <label class="control-label">RFC <small>(requerido)</small></label>
                                                            <input id="rfc" name="rfc" type="text" class="form-control"
                                                                   required maxlength="13"
                                                                   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating select-is-empty div_payment_method">
                                                            <label class="control-label">Forma de pago <small>(requerido)</small></label>
                                                            <select id="payment_method" name="payment_method"
                                                                    class="form-control payment_method" required
                                                                    disabled="true"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group label-floating div_email">
                                                            <label class="control-label">Correo electrónico <small>(requerido)</small></label>
                                                            <input id="email" name="email" type="email"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group label-floating div_phone_number">
                                                            <label class="control-label">Teléfono celular <small>(requerido)</small></label>
                                                            <input id="phone_number" name="phone_number" type="number"
                                                                   class="form-control" required maxlength="10"
                                                                   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating select-is-empty div_headquarter">
                                                            <label class="control-label">Sede <small>(requerido)</small></label>
                                                            <select id="headquarter" name="headquarter"
                                                                    class="form-control headquarter" required
                                                                    onchange="cleadFieldsHeadquarterChange()"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group label-floating select-is-empty div_membertype">
                                                            <label class="control-label">Tipo de miembro <small>(requerido)</small></label>
                                                            <select id="member_type" name="member_type"
                                                                    class="form-control member_type" required
                                                                    onchange="getLeadersList()"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group label-floating select-is-empty div_leader">
                                                            <input type="hidden" name="rol_actual" id="rol_actual">
                                                            <label class="control-label">Líder
                                                                <small>(requerido)</small></label>
                                                            <select id="leader" name="leader" class="form-control"
                                                                    required></select>
                                                        </div>
                                                    </div>
                                                    <div id="ch">
                                                        <p><b>Los siguientes campos (SEDE CAPITAL HUMANO y SUCURSAL
                                                                CAPITAL HUMANO) son información que se solicita de
                                                                manera adicional para mantener actualizado tanto el
                                                                sistema de Capital Humano como CRM actualizados.</b></p>
                                                        <p><b>Llenado: SEDE CAPITAL HUMANO (sede de asignación del
                                                                asesor), SUCURSAL CAPITAL HUMANO (Oficina en la que se
                                                                encuentra ubicado el asesor).</b></p>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating select-is-empty div_leader">
                                                                <label class="control-label">SEDE CAPITAL HUMANO</label>
                                                                <select id="sedech" name="sedech"
                                                                        class="form-control sedech"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating select-is-empty div_leader">
                                                                <label class="control-label">SUCURSAL CAPITAL HUMANO (no
                                                                    requerido)</label>
                                                                <select id="sucursal" name="sucursal"
                                                                        class="form-control sucursal"></select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombre de usuario <small>(requerido)</small></label>
                                                            <input id="username" name="username" type="text"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Contraseña
                                                                <small>(requerido)</small></label>
                                                            <input id="contrasena" name="contrasena" type="password"
                                                                   class="form-control" required="" maxlength="10"
                                                                   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <input type="checkbox" onclick="showPassword()"
                                                                   style="margin-top: 60px"> Mostrar contraseña
                                                            <input id="id_usuario" name="id_usuario" type="hidden"
                                                                   class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                                    <button type="button" class="btn btn-danger btn-simple"
                                                            data-dismiss="modal">Cancelar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!------------------------------------->
                                <div class="modal fade" id="BajaUser" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"
                                     data-keyboard="false">
                                    <div class="modal-dialog modal-lg   ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Baja del usuario: <b id="nameUs"></b></h4>
                                            </div>
                                            <form id="BajaUserForm" name="BajaUsersForm" method="post">
                                                <div class="modal-body">
                                                    <div class="col-sm-6">
                                                        <div class="form-group label-floating div_name">
                                                            <label class="control-label">Motivo de baja <small>(requerido)</small></label>
                                                            <textarea id="motivo" name="motivo" class="form-control"
                                                                      required></textarea>
                                                            <input type="hidden" name="id_user" id="id_user">
                                                            <input type="hidden" name="idrol" id="idrol">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="btnS">Aceptar
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-simple"
                                                            onclick="CloseModalBaja()">Cancelar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="BajaConfirm" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"
                                     data-keyboard="false">
                                    <div class="modal-dialog modal-md   ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" onclick="BajaConfirmM()"
                                                        aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title"><h4 id="msj"></h4><b id="nameUs2"></b>?</h4>
                                            </div>
                                            <form id="BajaConfirmForm" name="BajaConfirmForm" method="post">
                                                <div class="modal-body">

                                                    <input type="hidden" name="iduser" id="iduser">
                                                    <input type="hidden" name="id_rol" id="id_rol">
                                                    <input type="hidden" name="status" id="status">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" id="btnSub">Aceptar
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-simple"
                                                            onclick="BajaConfirmM()">Cancelar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------->
                                <div class="modal fade" id="changesRegsUsers" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"
                                     data-keyboard="false">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">
                                                    <i class="material-icons" onclick="cleanComments()">clear</i>
                                                </button>
                                                <h4 class="modal-title">Consulta información</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div role="tabpanel">
                                                    <!-- Nav tabs -->
                                                    <ul class="nav nav-tabs" role="tablist"
                                                        style="background: #003d82;">
                                                        <li role="presentation" class="active"><a
                                                                    href="#changelogUsersTab"
                                                                    aria-controls="changelogUsersTab" role="tab"
                                                                    data-toggle="tab">Bitácora de cambios</a></li>
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active"
                                                             id="changelogUsersTab">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="card card-plain">
                                                                        <div class="card-content">
                                                                            <ul class="timeline timeline-simple"
                                                                                id="changelogUsers"></ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    Aceptar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content hide">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="block full">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header card-header-icon"
                                                 data-background-color="goldMaderas">
                                                <i class="material-icons">list</i>
                                            </div>
                                            <div class="card-content">
                                                <div class="row">
                                                    <h4 class="card-title">Lista de usuarios</h4>
                                                    <div class="table-responsive">
                                                        <table id="all_users_datatable"
                                                               class="table table-striped table-no-bordered table-hover"
                                                               style="text-align:center;">
                                                            <!--table table-bordered table-hover -->
                                                            <thead>
                                                            <tr>
                                                                <th class="disabled-sorting">Estatus</th>
                                                                <th class="disabled-sorting">
                                                                    <center>ID</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Nombre</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Correo</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Teléfono</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Tipo</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Sede</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Jefe directo</center>
                                                                </th>
                                                                <th class="disabled-sorting">
                                                                    <center>Acciones</center>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                        </table>

                                                        <div class="modal fade" id="editUserModal" tabindex="-1"
                                                             role="dialog" aria-labelledby="myModalLabel"
                                                             aria-hidden="true" data-backdrop="static"
                                                             data-keyboard="false">
                                                            <div class="modal-dialog modal-lg   ">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-hidden="true">
                                                                            <i class="material-icons">clear</i>
                                                                        </button>
                                                                        <h4 class="modal-title">Edita tu
                                                                            información</h4>
                                                                    </div>
                                                                    <form id="editUserForm" name="editUsersForm"
                                                                          method="post">
                                                                        <div class="modal-body">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group label-floating div_name">
                                                                                    <label class="control-label">Nombre
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="name" name="name"
                                                                                           type="text"
                                                                                           class="form-control"
                                                                                           required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating div_last_name">
                                                                                    <label class="control-label">Apellido
                                                                                        paterno
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="last_name"
                                                                                           name="last_name" type="text"
                                                                                           class="form-control"
                                                                                           required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating div_mothers_last_name">
                                                                                    <label class="control-label">Apellido
                                                                                        materno</label>
                                                                                    <input id="mothers_last_name"
                                                                                           name="mothers_last_name"
                                                                                           type="text"
                                                                                           class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating div_rfc">
                                                                                    <label class="control-label">RFC
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="rfc" name="rfc"
                                                                                           type="text"
                                                                                           class="form-control" required
                                                                                           maxlength="13"
                                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating select-is-empty div_payment_method">
                                                                                    <label class="control-label">Forma
                                                                                        de pago
                                                                                        <small>(requerido)</small></label>
                                                                                    <select id="payment_method"
                                                                                            name="payment_method"
                                                                                            class="form-control payment_method"
                                                                                            required
                                                                                            disabled="true"></select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group label-floating div_email">
                                                                                    <label class="control-label">Correo
                                                                                        electrónico
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="email" name="email"
                                                                                           type="email"
                                                                                           class="form-control"
                                                                                           required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <div class="form-group label-floating div_phone_number">
                                                                                    <label class="control-label">Teléfono
                                                                                        celular
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="phone_number"
                                                                                           name="phone_number"
                                                                                           type="number"
                                                                                           class="form-control" required
                                                                                           maxlength="10"
                                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating select-is-empty div_headquarter">
                                                                                    <label class="control-label">Sede
                                                                                        <small>(requerido)</small></label>
                                                                                    <select id="headquarter"
                                                                                            name="headquarter"
                                                                                            class="form-control headquarter"
                                                                                            required
                                                                                            onchange="cleadFieldsHeadquarterChange()"></select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group label-floating select-is-empty div_membertype">
                                                                                    <label class="control-label">Tipo de
                                                                                        miembro
                                                                                        <small>(requerido)</small></label>
                                                                                    <select id="member_type"
                                                                                            name="member_type"
                                                                                            class="form-control member_type"
                                                                                            required
                                                                                            onchange="getLeadersList()"></select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group label-floating select-is-empty div_leader">
                                                                                    <label class="control-label">Líder
                                                                                        <small>(requerido)</small></label>
                                                                                    <select id="leader" name="leader"
                                                                                            class="form-control"
                                                                                            required></select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Nombre
                                                                                        de usuario
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="username" name="username"
                                                                                           type="text"
                                                                                           class="form-control"
                                                                                           required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Contraseña
                                                                                        <small>(requerido)</small></label>
                                                                                    <input id="contrasena"
                                                                                           name="contrasena"
                                                                                           type="password"
                                                                                           class="form-control"
                                                                                           required="" maxlength="10"
                                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="form-group">
                                                                                    <input type="checkbox"
                                                                                           onclick="showPassword()"
                                                                                           style="margin-top: 60px">
                                                                                    Mostrar contraseña
                                                                                    <input id="id_usuario"
                                                                                           name="id_usuario"
                                                                                           type="hidden"
                                                                                           class="form-control">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary">Aceptar
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-danger btn-simple"
                                                                                    data-dismiss="modal">Cancelar
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="changesRegsUsers" tabindex="-1"
                                                             role="dialog" aria-labelledby="myModalLabel"
                                                             aria-hidden="true" data-backdrop="static"
                                                             data-keyboard="false">

                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-hidden="true">
                                                                            <i class="material-icons"
                                                                               onclick="cleanComments()">clear</i>
                                                                        </button>
                                                                        <h4 class="modal-title">Consulta
                                                                            información</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div role="tabpanel">
                                                                            <!-- Nav tabs -->
                                                                            <ul class="nav nav-tabs" role="tablist"
                                                                                style="background: #003d82;">
                                                                                <li role="presentation" class="active">
                                                                                    <a href="#changelogUsersTab"
                                                                                       aria-controls="changelogUsersTab"
                                                                                       role="tab" data-toggle="tab">Bitácora
                                                                                        de cambios</a></li>
                                                                            </ul>
                                                                            <!-- Tab panes -->
                                                                            <div class="tab-content">
                                                                                <div role="tabpanel"
                                                                                     class="tab-pane active"
                                                                                     id="changelogUsersTab">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="card card-plain">
                                                                                                <div class="card-content">
                                                                                                    <ul class="timeline timeline-simple"
                                                                                                        id="changelogUsers"></ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary"
                                                                                data-dismiss="modal">Aceptar
                                                                        </button>
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
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('template/footer_legend'); ?>

        </div>
    </div>
</div>
</body>

<?php $this->load->view('template/footer'); ?>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/js/controllers/datatables/datatables.min.css"/>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/datatables.min.js"></script>-->

<script src="<?= base_url() ?>dist/js/controllers/usuarios-1.1.0.js"></script>
<script>userId = <?= $this->session->userdata('id_usuario') ?>;</script>

</html>
