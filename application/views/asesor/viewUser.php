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
                                <h3 class="card-title center-align">Contraseña</h3>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="all_password_datatable" class="table-striped table-hover" style="text-align:center;"></table>
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

    <script>
        $(document).ready(function() {
            function changePassword() {
                $idUser = $this->session->userdata('id_usuario');
                
                $data = $this->Usuarios_modelo->getPersonalInformation()->result();

                $key = "";
                $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.;:/*-";
                $max = strlen($pattern)-1;
                for($i = 0; $i < $length; $i++){
                    $key .= substr($pattern, mt_rand(0,$max), 1);

                    $pass = return $key;
                }

                $data = array (
                    "contrasena" => encriptar($pass)
                );

                $response = $this->Usuarios_modelo->updatePersonalInformation($data, $this->session->userdata('id_usuario'));
            }
            setInterval(changePassword,60000);
        });
    </script>

</body>

<?php $this->load->view('template/footer'); ?>

<script src="<?= base_url() ?>dist/js/controllers/usuarios-1.1.0.js"></script>

</html>
