<style>
    .buttons-html5 {
        margin-right: 10px;
    }
</style>
<div>
    <div class="wrapper">
        <?php
/*-------------------------------------------------------*/
$datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
            $this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
        /*
            $dato= array(
                'actualizaPrecio' => 0,
                'actualizaReferencia' => 0,
                'acuserecibidos' => 0,
                'autorizacionesReport' => 0,
                'clubMaderasReport' => 0,
                'altaCluster' => 0,
                'altaLote' => 0,
                'aparta' => 0,
                'asesores' => 0,
                'autorizacion' => 0,
                'asignarVentas' => 0,
                'bulkload' => 0,
                'cambiarAsesor' => 0,
                'comhistorial' => 0,
                'consDepositoSeriedad' => 0,
                'asignarVentas' => 0,
                'comnuevas' => 0,
                'consulta12Status' => 0,
                'consulta9Status' => 0,
                'contrato' => 0,
                'coOwners' => 0,
                'corrida' => 0,
                'corridaF' => 0,
                'corridasElaboradas' => 0,
                'disponibles' => 0,
                'documentacion' => 0,
                'DS' => 0,
                'DSConsult' => 0,
                'enviosRL' => 0,
                'estatus10' => 0,
                'estatus10Report' => 0,
                'estatus12' => 0,
                'estatus13' => 0,
                'estatus14' => 0,
                'estatus15' => 0,
                'estatus2' => 0,
                'estatus20' => 0,
                'estatus5' => 0,
                'estatus6' => 0,
                'estatus7' => 0,
                'estatus8' => 0,
                'estatus9' => 0,
                'expediente' => 0,
                'expedientesIngresados' => 0,
                'expRevisados' => 0,
                'gerentesAsistentes' => 0,
                'histComisiones' => 0,
                'historialPagos' => 0,
                'home' => 0,
                'integracionExpediente' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 0,
                'liberacion' => 0,
                'listaCliente' => 0,
                'lotes45dias' => 0,
                'lotesContratados' => 0,
                'manual' => 0,
                'nuevasComisiones' => 0,
                'pagosCancelados' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'prospectosMktd' => 0,
                'rechazoJuridico' => 0,
                'references' => 0,
                'sharedSales' => 0,
                'status11' => 0,
                'status14' => 0,
                'status3' => 0,
                'status7' => 0,
                'status8' => 0,
                'ultimoStatus' => 0,
                'usuarios' => 0,
                'listaAsesores' => 0,
                'altaUsuarios' => 0,
                'listaUsuarios' => 1,
                'clientsList' => 0,
                'consDepositoSeriedad' => 0,
                'busquedaDetallada' =>0
            );
        $this->load->view('template/sidebar', $dato);
*/
        ?>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Lista de usuarios</h4>
                                                <div class="table-responsive">
                                                    <table id="all_users_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="disabled-sorting text-right">Estatus</th>
                                                            <th class="disabled-sorting text-right">ID</th>
                                                            <th class="disabled-sorting text-right">Nombre</th>
                                                            <th class="disabled-sorting text-right">Correo</th>
                                                            <th class="disabled-sorting text-right">Teléfono</th>
                                                            <th class="disabled-sorting text-right">Tipo</th>
                                                            <th class="disabled-sorting text-right">Jefe directo</th>
                                                            <th class="disabled-sorting text-right">Acciones</th>
                                                        </tr>
                                                        </thead>
                                                    </table>

                                                    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                        <div class="modal-dialog modal-lg   ">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Edita tu información</h4>
                                                                </div>
                                                                <form id="editUserForm" name="editUsersForm" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group label-floating div_name">
                                                                                <label class="control-label">Nombre <small>(requerido)</small></label>
                                                                                <input id="name" name="name" type="text" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating div_last_name">
                                                                                <label class="control-label">Apellido paterno <small>(requerido)</small></label>
                                                                                <input id="last_name" name="last_name" type="text" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating div_mothers_last_name">
                                                                                <label class="control-label">Apellido materno</label>
                                                                                <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating div_rfc">
                                                                                <label class="control-label">RFC <small>(requerido)</small></label>
                                                                                <input id="rfc" name="rfc" type="text" class="form-control" required maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating select-is-empty div_payment_method">
                                                                                <label class="control-label">Forma de pago <small>(requerido)</small></label>
                                                                                <select id="payment_method" name="payment_method" class="form-control payment_method" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <div class="form-group label-floating div_email">
                                                                                <label class="control-label">Correo electrónico <small>(requerido)</small></label>
                                                                                <input id="email" name="email" type="email" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <div class="form-group label-floating div_phone_number">
                                                                                <label class="control-label">Teléfono celular <small>(requerido)</small></label>
                                                                                <input id="phone_number" name="phone_number" type="number" class="form-control" required maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating select-is-empty div_headquarter">
                                                                                <label class="control-label">Sede <small>(requerido)</small></label>
                                                                                <select id="headquarter" name="headquarter" class="form-control headquarter" required onchange="cleadFieldsHeadquarterChange()"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group label-floating select-is-empty div_membertype">
                                                                                <label class="control-label">Tipo de miembro <small>(requerido)</small></label>
                                                                                <select id="member_type" name="member_type" class="form-control member_type" required onchange="getLeadersList()"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group label-floating select-is-empty div_leader">
                                                                                <label class="control-label">Líder <small>(requerido)</small></label>
                                                                                <select id="leader" name="leader" class="form-control" required></select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Nombre de usuario <small>(requerido)</small></label>
                                                                                <input id="username" name="username" type="text" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Contraseña <small>(requerido)</small></label>
                                                                                <input id="contrasena" name="contrasena" type="password" class="form-control" required="" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-group">
                                                                                <input type="checkbox" onclick="showPassword()" style="margin-top: 60px"> Mostrar contraseña
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
<script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
</html>
