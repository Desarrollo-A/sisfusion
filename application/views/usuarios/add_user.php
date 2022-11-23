<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .boxContent .bootstrap-select button {
        background-color: transparent!important;
    }
</style>
<body>
    <div class="wrapper">
        <?php
        /*-------------------------------------------------------*/
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;  
        $this->load->view('template/sidebar', $datos);
        /*--------------------------------------------------------*/
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
                                <div class="row">
                                    <h3 class="card-title center-align">Agrega un miembro a nuestro equipo de trabajo</h3>
                                    <div class="toolbar">
                                        <form name="my_add_user_form" id="my_add_user_form">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">Nombre (requerido)</label>
                                                    <input id="name" name="name" type="text" class="form-control input-gral" required>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">Apellido paterno (requerido)</label>
                                                    <input id="last_name" name="last_name" type="text" class="form-control input-gral" required>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">Apellido materno</label>
                                                    <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control input-gral">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">RFC (requerido)</label>
                                                    <input id="rfc" name="rfc" type="text" class="form-control input-gral" required maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label label-gral">Forma de pago (requerido)</label>
                                                    <select id="payment_method" name="payment_method" class="form-control payment_method input-gral" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">Correo electrónico (requerido)</label>
                                                    <input id="email" name="email" type="email" class="form-control input-gral" required>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label label-gral">Teléfono celular (requerido)</label>
                                                    <input id="phone_number" name="phone_number" type="number" class="form-control input-gral" required maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label label-gral">Sede (requerido)</label>
                                                    <select id="headquarter" name="headquarter" class="form-control headquarter input-gral" required onchange="cleadFieldsHeadquarterChange()"></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label label-gral">Tipo de miembro (requerido)</label>
                                                    <select id="member_type" name="member_type" class="form-control member_type input-gral" required onchange="getLeadersList()"></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-1">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label label-gral">Lider (requerido)</label>
                                                    <select id="leader" name="leader" class="form-control input-gral" required></select>
                                                </div>
                                            </div>
                                            <div class="container-fluid">
                                                <div class="row aligned-row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
                                                        <div class="form-group label-floating select-is-empty">
                                                            <label class="control-label label-gral">Nombre de usuario (requerido)</label>
                                                            <input id="username" name="username" type="text" class="form-control input-gral" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
                                                        <div class="form-group label-floating select-is-empty p-0">
                                                            <label class="control-label label-gral">Contraseña (requerido)</label>
                                                            <input id="contrasena" name="contrasena" type="password" class="form-control input-gral" required="" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1 d-flex align-center">
                                                        <input class="m-0 mr-2" type="checkbox" onclick="showPassword()"> Mostrar contraseña
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-2 pl-0">
                                                    <button type="submit" class="btn-data-gral btn-s-blue btn-block" id="buscarBtn">Guardar</button>
                                                </div>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
</body>
