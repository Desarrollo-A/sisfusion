<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar', $dato); ?>

    <style>
        .label-inf {
            color: #333;
        }
        select:invalid {
            border: 2px dashed red;
        }

    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="block full">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                        <i class="material-icons">list</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <h4 class="card-title">Copropietarios</h4>
                                            <div class="table-responsive">
                                                <div class="material-datatables">
                                                    <table id="prospects-datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                            <tr>
<!--                                                                <th class="disabled-sorting text-right"></th>-->
                                                                <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                                <th class="disabled-sorting text-right"><center>Prospecto</center></th>
                                                                <th class="disabled-sorting text-right"><center>Asesor</center></th>
                                                                <th class="disabled-sorting text-right"><center>Coordinador</center></th>
                                                                <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                                <th class="disabled-sorting text-right"><center>Fecha creación</center></th>
                                                                <th class="disabled-sorting text-right"><center>Fecha vencimiento</center></th>
                                                                <th class="disabled-sorting text-right"><center>Acciones</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <!--<tfoot>
                                                            <tr>
                                                                <th><center>ID</center></th>
                                                                <th><center>Nombre</center></th>
                                                                <th><center>Correo</center></th>
                                                                <th><center>Teléfono</center></th>
                                                                <th><center>Lugar prospección</center></th>
                                                                <th><center>Asesor</center></th>
                                                                <th><center>Fecha creación</center></th>
                                                                <th class="text-right"><center>Acciones</center></th>
                                                            </tr>
                                                        </tfoot>-->
                                                    </table>

                                                    <div class="modal fade" id="myCommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Ingresa tus comentarios</h4>
                                                                </div>
                                                                <form id="my-comment-form" name="my-comment-form" method="post">
                                                                    <div class="modal-body">
                                                                        <textarea class="form-control" type="text" name="observations" id="observations" autofocus></textarea>
                                                                        <input type="hidden" name="id_prospecto" id="id_prospecto">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="mySuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Éxito</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>La actualización se ha concluido correctamente.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn"    style="background-color: #4caf50;" onclick="reloadPage()">Aceptar</button>
                                                                    <button type="button" class="btn"    style="background-color: #4caf50;" onclick="reloadPage()">Aceptar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="myEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Manten la información actualizada</h4>

                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="js-title-step"></h4>
                                                                </div>
                                                                <form id="my-edit-form" name="my-edit-form" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="row" data-step="1" data-title="Acerca de">
                                                                            <div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Nacionalidad<small> (requerido)</small></label>
                                                                                        <select id="nationality" name="nationality" class="form-control nationality"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Personalidad jurídica<small> (requerido)</small></label>
                                                                                        <select id="legal_personality" name="legal_personality" class="form-control legal_personality"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-curp">
                                                                                        <label class="control-label">CURP</label>
                                                                                        <input id="curp" name="curp" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-rfc">
                                                                                        <label class="control-label">RFC</label>
                                                                                        <input id="rfc" name="rfc" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group label-floating div-name">
                                                                                        <label class="control-label">Nombre / Razón social<small> (requerido)</small></label>
                                                                                        <input id="name" name="name" type="text" class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-last-name">
                                                                                        <label class="control-label">Apellido paterno</label>
                                                                                        <input id="last_name" name="last_name" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-mothers-last-name">
                                                                                        <label class="control-label">Apellido materno</label>
                                                                                        <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-group label-floating div-date-birth">
                                                                                        <label class="control-label">Fecha de nacimiento</label>
                                                                                        <input id="date_birth" name="date_birth" type="date" class="form-control" onchange="getAge(2)">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-group label-floating div-company-antiquity">
                                                                                        <label class="control-label">Edad</label>
                                                                                        <input id="company_antiquity" name="company_antiquity" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-email">
                                                                                        <label class="control-label">Correo electrónico<small> (requerido)</small></label>
                                                                                        <input id="email" name="email" type="email" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-phone-number">
                                                                                        <label class="control-label">Teléfono celular<small> (requerido)</small></label>
                                                                                        <input id="phone_number" name="phone_number" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-phone-number2">
                                                                                        <label class="control-label">Teléfono casa</label>
                                                                                        <input id="phone_number2" name="phone_number2" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Estado civil</label>
                                                                                        <select id="civil_status" name="civil_status" class="form-control civil_status" onchange="validateCivilStatus(2)"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Régimen matrimonial</label>
                                                                                        <select id="matrimonial_regime" name="matrimonial_regime" class="form-control matrimonial_regime" onchange="validateMatrimonialRegime(2)"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-spouce">
                                                                                        <label class="control-label">Cónyugue</label>
                                                                                        <input id="spouce" name="spouce" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-street-name">
                                                                                        <label class="control-label">Originario de</label>
                                                                                        <input id="from" name="from" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-ext-number">
                                                                                        <label class="control-label">Domicilio particular</label>
                                                                                        <input id="home_address" name="home_address" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-3">La casa donde vive es</div>
                                                                                <div class="col-lg-10 col-lg-offset-2 align-center">
                                                                                    <div class="radio"></div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="own" name="lives_at_home" type="radio" value="1"> Propia</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="rented" name="lives_at_home" type="radio" value="2""> Rentada</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="paying" name="lives_at_home" type="radio" value="3"> Pagándose</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="family" name="lives_at_home" type="radio" value="4"> Familiar</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="other" name="lives_at_home" type="radio" value="5"> Otro</label>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="row hide" data-step="2" data-title="Empleo">
                                                                            <div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-occupation">
                                                                                        <label class="control-label">Ocupación</label>
                                                                                        <input id="occupation" name="occupation" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-company">
                                                                                        <label class="control-label">Empresa</label>
                                                                                        <input id="company" name="company" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-position">
                                                                                        <label class="control-label">Puesto</label>
                                                                                        <input id="position" name="position" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-antiquity">
                                                                                        <label class="control-label">Antigüedad (años)</label>
                                                                                        <input id="antiquity" name="antiquity" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-company-residence">
                                                                                        <label class="control-label">Domicilio</label>
                                                                                        <input id="company_residence" name="company_residence" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row hide" data-step="3" data-title="Prospección">
                                                                            <div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Lugar de prospección<small> (requerido)</small></label>
                                                                                        <select id="prospecting_place" name="prospecting_place" class="form-control prospecting_place"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-specify">
                                                                                        <label class="control-label">Específique cuál</label>
                                                                                        <input id="specify" name="specify" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Específique cuál</label>
                                                                                        <select id="specify_mkt" name="specify" class="form-control">
                                                                                            <option value="default" id="sm" disabled selected>Seleccione una opción</option>
                                                                                            <option value="01 800">01 800</option>
                                                                                            <option value="Chat">Chat</option>
                                                                                            <option value="Contacto web">Contacto web</option>
                                                                                            <option value="Facebook">Facebook</option>
                                                                                            <option value="WhatsApp">WhatsApp</option>
                                                                                            <option value="Recomendado">Recomendado</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">¿Qué publicidad recuerda?<small> (requerido)</small></label>
                                                                                        <select id="advertising" name="advertising" class="form-control advertising"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Plaza de venta<small> (requerido)</small></label>
                                                                                        <select id="sales_plaza" name="sales_plaza" class="form-control sales_plaza"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-observations">
                                                                                        <label class="control-label">Observaciones</label>
                                                                                        <textarea type="text" id="observation" name="observation" class="form-control"></textarea>
                                                                                        <input type="hidden" name="id_prospecto_ed" id="id_prospecto_ed">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <!--<button type="submit" class="btn btn-primary">Aceptar</button>
                                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>-->
                                                                        <!--<button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>-->
                                                                        <div class="pull-left">
                                                                            <button type="button" class="btn btn-default js-btn-step" data-orientation="previous"></button>
                                                                        </div>
                                                                        <div class="pull-right">
                                                                            <button type="button" class="btn btn-green js-btn-step" data-orientation="next" style="background-color: #2E86C1;"></button>
                                                                            <button type="submit" class="btn btn-green" style="background-color: #4caf50;">Finalizar</button>
                                                                            <!--<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>-->
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="myCoOwnerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Ingresa los datos del copropietario que se asociará a este registro.</h4>

                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="js-title-step"></h4>
                                                                </div>
                                                                <form id="my-coowner-form" name="my_coowner_form" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="row" data-step="1" data-title="Acerca de">
                                                                            <div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating select-is-empty" show-errors>
                                                                                        <label class="control-label">Nacionalidad<small> (requerido)</small></label>
                                                                                        <select id="nationality_co" name="nationality_co" class="form-control nationality ng-invalid ng-invalid-required" required></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Personalidad jurídica<small> (requerido)</small></label>
                                                                                        <select id="legal_personality_co" name="legal_personality_co" class="form-control legal_personality" required></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-rfc">
                                                                                        <label class="control-label">RFC</label>
                                                                                        <input id="rfc_co" name="rfc_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <div class="form-group label-floating div-name">
                                                                                        <label class="control-label">Nombre / Razón social<small> (requerido)</small></label>
                                                                                        <input id="name_co" name="name_co" type="text" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-last-name">
                                                                                        <label class="control-label">Apellido paterno</label>
                                                                                        <input id="last_name_co" name="last_name_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-mothers-last-name">
                                                                                        <label class="control-label">Apellido materno</label>
                                                                                        <input id="mothers_last_name_co" name="mothers_last_name_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-group label-floating div-date-birth">
                                                                                        <label class="control-label">Fecha de nacimiento</label>
                                                                                        <input id="date_birth_co" name="date_birth_co" type="date" class="form-control" onchange="getAge(3)">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <div class="form-group label-floating div-company-antiquity">
                                                                                        <label class="control-label">Edad</label>
                                                                                        <input id="company_antiquity_co" name="company_antiquity_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-email">
                                                                                        <label class="control-label">Correo electrónico<small> (requerido)</small></label>
                                                                                        <input id="email_co" name="email_co" type="email_co" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-phone-number">
                                                                                        <label class="control-label">Teléfono celular<small> (requerido)</small></label>
                                                                                        <input id="phone_number_co" name="phone_number_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating div-phone-number2">
                                                                                        <label class="control-label">Teléfono casa</label>
                                                                                        <input id="phone_number2_co" name="phone_number2_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Estado civil</label>
                                                                                        <select id="civil_status_co" name="civil_status_co" class="form-control civil_status"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <div class="form-group label-floating select-is-empty">
                                                                                        <label class="control-label">Régimen matrimonial</label>
                                                                                        <select id="matrimonial_regime_co" name="matrimonial_regime_co" class="form-control matrimonial_regime"></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-spouce">
                                                                                        <label class="control-label">Cónyugue</label>
                                                                                        <input id="spouce_co" name="spouce_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-street-name">
                                                                                        <label class="control-label">Originario de</label>
                                                                                        <input id="from_co" name="from_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-ext-number">
                                                                                        <label class="control-label">Domicilio particular</label>
                                                                                        <input id="home_address_co" name="home_address_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>

                                                                                <br>
                                                                                <div class="col-sm-3">La casa donde vive es</div>
                                                                                <div class="col-lg-10 col-lg-offset-2 align-center">
                                                                                    <div class="radio"></div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="own_co" name="lives_at_home_co" type="radio" value="1"> Propia</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="rented_co" name="lives_at_home_co" type="radio" value="2""> Rentada</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="paying_co" name="lives_at_home_co" type="radio" value="3"> Pagándose</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="family_co" name="lives_at_home_co" type="radio" value="4"> Familiar</label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label><input id="other_co" name="lives_at_home_co" type="radio" value="5"> Otro</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row hide" data-step="2" data-title="Empleo">
                                                                            <div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-occupation">
                                                                                        <label class="control-label">Ocupación</label>
                                                                                        <input id="occupation_co" name="occupation_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-company">
                                                                                        <label class="control-label">Empresa</label>
                                                                                        <input id="company_co" name="company_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="form-group label-floating div-position">
                                                                                        <label class="control-label">Puesto</label>
                                                                                        <input id="position_co" name="position_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <div class="form-group label-floating div-antiquity">
                                                                                        <label class="control-label">Antigüedad</label>
                                                                                        <input id="antiquity_co" name="antiquity_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-company-residence">
                                                                                        <label class="control-label">Domicilio</label>
                                                                                        <input id="company_residence_co" name="company_residence_co" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group label-floating div-observations">
                                                                                        <input type="hidden" name="id_prospecto_ed_co" id="id_prospecto_ed_co">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="pull-left">
                                                                            <button type="button" class="btn btn-default js-btn-step" data-orientation="previous"></button>
                                                                        </div>
                                                                        <div class="pull-right">
                                                                            <button type="button" class="btn btn-green js-btn-step" data-orientation="next" style="background-color: #2E86C1;"></button>
                                                                            <button type="submit" class="btn btn-green" style="background-color: #4caf50;">Finalizar</button>
                                                                        </div>
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
                                                                            <li role="presentation" class="active"><a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">General</a></li>
                                                                            <li role="presentation"><a href="#commentsTab" aria-controls="commentsTab" role="tab" data-toggle="tab">Comentarios</a></li>
                                                                            <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                                                                        </ul>
                                                                        <!-- Tab panes -->
                                                                        <div class="tab-content">
                                                                            <div role="tabpanel" class="tab-pane active" id="generalTab">
                                                                                <div class="row">
                                                                                    <div class="col-sm-3">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Personalidad jurídica</label>
                                                                                            <input id="legal-personality-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Nacionalidad</label>
                                                                                            <input id="nationality-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">CURP</label>
                                                                                            <input id="curp-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">RFC</label>
                                                                                            <input id="rfc-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Nombre / Razón social</label>
                                                                                            <input id="name-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Correo electrónico</label>
                                                                                            <input id="email-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Teléfono</label>
                                                                                            <input id="phone-number-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Lugar de prospección</label>
                                                                                            <input id="prospecting-place-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Medio publicitario</label>
                                                                                            <input id="advertising-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Plaza de venta</label>
                                                                                            <input id="sales-plaza-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Asesor</label>
                                                                                            <input id="asesor-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Coordinador</label>
                                                                                            <input id="coordinador-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">Gerente</label>
                                                                                            <input id="gerente-lbl" type="text" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                    <!--<div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label">Asesor</label>
                                                                                                <input id="phone-asesor-lbl" type="text" class="form-control" disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-4">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label">Coordinador</label>
                                                                                                <input id="phone-coordinador-lbl" type="text" class="form-control" disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-4">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label">Gerente</label>
                                                                                                <input id="phone-gerente-lbl" type="text" class="form-control" disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>-->
                                                                                <div class="row">
                                                                                    <input type="hidden" id="id-prospecto-lbl" name="id_prospecto_lbl">
                                                                                </div>
                                                                            </div>
                                                                            <div role="tabpanel" class="tab-pane" id="commentsTab">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="card card-plain">
                                                                                            <div class="card-content">
                                                                                                <ul class="timeline timeline-simple" id="comments-list"></ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div role="tabpanel" class="tab-pane" id="changelogTab">
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
                                                                    <button type="button" class="btn btn-primary" onclick="printProspectInfo()"><i class="material-icons">cloud_download</i> Descargar pdf</button>
                                                                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
                                                                    <!--<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>-->
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
    </div>
	<?php $this->load->view('template/footer_legend');?>
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
<script src="<?php base_url()?>dist/js/jquery.validate.js"></script>


<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/prospects-list-1.1.0.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

</html>
