<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <style>
            .boxContent .bootstrap-select button {
                background-color: transparent!important;
            }
            .form-group{
                margin: 0px;
            }
            .btn-group{
                margin: 0px;
            }
            label.control-label{
                margin: 0;
            }
            #showPass {
                cursor: pointer;
                position: absolute;
                top: 35px;
                right: 30px;
            }
        </style>
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
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <label class="control-label">Nombre (<span class="isRequired">*</span>)</label>
                                                <input id="name" name="name" type="text" class="form-control input-gral" required>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <label class="control-label">Apellido paterno (<span class="isRequired">*</span>)</label>
                                                <input id="last_name" name="last_name" type="text" class="form-control input-gral" required>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <label class="control-label">Apellido materno</label>
                                                <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control input-gral">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <label class="control-label">Correo electrónico (<span class="isRequired">*</span>)</label>
                                                <input id="email" name="email" type="email" class="form-control input-gral" required>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                                <label class="control-label">Forma de pago (<span class="isRequired">*</span>)</label>
                                                <select id="payment_method" name="payment_method" class="form-control payment_method input-gral pl-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
                                                <label class="control-label">Teléfono celular (<span class="isRequired">*</span>)</label>
                                                <input id="phone_number" name="phone_number" type="number" class="form-control input-gral" required maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden mb-1">
                                                <label class="control-label">Sede (<span class="isRequired">*</span>)</label>
                                                <select id="headquarter" name="headquarter" class="form-control headquarter input-gral pl-0" required onchange="cleadFieldsHeadquarterChange()" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden mb-1">
                                                <label class="control-label">Tipo de miembro (<span class="isRequired">*</span>)</label>
                                                <select id="member_type" name="member_type" class="form-control member_type input-gral pl-0" required onchange="getLeadersList()" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
                                                <label class="control-label">Lider (<span class="isRequired">*</span>)</label>
                                                <select id="leader" name="leader" class="form-control input-gral" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
                                                <label class="control-label">Nombre de usuario (<span class="isRequired">*</span>)</label>
                                                <input id="username" name="username" type="text" class="form-control input-gral" autocomplete="off" required>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
                                                <label class="control-label">Contraseña (<span class="isRequired">*</span>)</label>
                                                <input type="password" id="contrasena" name="contrasena" class="form-control input-gral" required="" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                                                <span id="showPass" onclick="showPassword()">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                    <i class="fa fa-eye" aria-hidden="true" style="display:none;"></i>
                                                </span>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 mb-1 d-flex justify-end">
                                                <div class="w-20">
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
