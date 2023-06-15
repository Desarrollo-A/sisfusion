<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>

    .buttons-html5 {
        margin-right: 10px;
    }

    ul.timeline-3 {
        list-style-type: none;
        position: relative;
        height: 300px; /* Establece la altura del contenedor */
        overflow: auto;
    }
    ul.timeline-3:before {
        content: " ";
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }
    ul.timeline-3 > li {
        margin: 20px 0;
        padding-left: 20px;
    }
    ul.timeline-3 > li:before {
        content: " ";
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #0a548b;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

    .scroll-styles::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: transparent;
    }

    /* El background del scroll (border)*/
    .scroll-styles::-webkit-scrollbar {
        width: 9px;
        background-color: transparent;
    }

    /* Color de la barra de desplazamiento */
    .scroll-styles::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
    }

    /* Color del HOVER de barra de desplazamiento */
    .scroll-styles::-webkit-scrollbar-thumb:hover {
        background-color: #929292;
    }

</style>
<div>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>


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
                                        <table id="all_users_datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ESTATUS</th>
                                                    <th>ID</th>
                                                    <th>NOMBRE</th>
                                                    <th>CORREO</th>
                                                    <th>TELÉFONO</th>
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
        </div>

        <div class="modal fade" id="changesRegsUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                            <h4 class="modal-title">Bitácora de cambios</h4>
                        </div>
                        <div class="modal-body">                      
                                <div class="container-fluid p-0" id="changelogTab">
                                    <div class="row">
                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <ul class="timeline-3 scroll-styles" id="changelog"></ul>
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
</script>
<script src="<?= base_url() ?>dist/js/controllers/Usuarios/users_list_comptroller.js"></script>




</html>
