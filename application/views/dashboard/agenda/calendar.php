<?php
    include('configGoogle.php');
    //This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
    $login_button = '';

    if(isset($_GET["code"])){
        //It will Attempt to exchange a code for an valid authentication token.
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

        //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
        if(!isset($token['error'])){
            //Set the access token used for requests
            $google_client->setAccessToken($token['access_token']);

            //Store "access_token" value in $_SESSION variable for future use.
            $this->session->set_userdata('access_token', $token['access_token']);


            //Create Object of Google Service OAuth 2 class
            $google_service = new Google_Service_Oauth2($google_client);

            //Get user profile data from google
            $data = $google_service->userinfo->get();

            //Below you can find Get profile data and store into $_SESSION variable
            if(!empty($data['given_name'])){
                $_SESSION['user_first_name'] = $data['given_name'];
            }

            if(!empty($data['family_name'])){
                $_SESSION['user_last_name'] = $data['family_name'];
            }

            if(!empty($data['email'])){
                $_SESSION['user_email_address'] = $data['email'];
            }

            if(!empty($data['gender'])){
                $_SESSION['user_gender'] = $data['gender'];
            }

            if(!empty($data['picture'])){
                $_SESSION['user_image'] = $data['picture'];
            }
        }
    }

    //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
    if(!isset($_SESSION['access_token'])){
        //Create a URL to obtain user authorization
        $login_button = '<a href="'.$google_client->createAuthUrl().'"><i class="fab fa-google"></i></a>';
    }

?>

    <link href="<?= base_url() ?>dist/css/calendarDashboard.css" rel="stylesheet"/>
    
    <div class="card">
        <div class="card-content">
            <div class="container-fluid">
                <div class="row mb-2 selects">
                <!-- Subdirector -->
                <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden pl-0">
                        <label class="label-gral">Gerente</label>
                        <select class="selectpicker select-gral m-0" id="gerente" name="gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un gerente" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                <!-- Subdirector y Gerente -->
                <?php if( $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 ) { ?>
                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                    <?php } else  { ?> 
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden pl-0" >
                    <?php } ?>
                        <label class="label-gral" id="labelCoord" style="display:none">Coordinador</label>
                        <select class="selectpicker select-gral m-0" id="coordinador" name="coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un coordinador" data-size="7" data-container="body"></select> 
                    </div>
                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden pr-0">
                    <?php } else  { ?> 
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden pr-0">
                    <?php } ?>
                        <label class="label-gral" id="labelAses" style="display:none">Asesor</label>
                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un asesor" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                <!-- Coordinador -->
                <?php if( $this->session->userdata('id_rol') == 9 ) { ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden p-0 mb-1">
                        <label class="label-gral">Asesor</label>
                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un asesor" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                    <?php
                        if($login_button == ''){
                            echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                            echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                            echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                            echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                            echo '<h3><a href="logout.php">Logout</h3></div>';
                        }
                        else{
                            echo '<div align="center">'.$login_button . '</div>';
                        }
                    ?>
                        <div id='calendar'></div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <div class="boxCodigos d-flex">
                            <div class="boxStatus d-flex">
                                <i class="fas fa-circle codeFinish"></i>
                                <p class="m-0">Cita finalizada</p>
                            </div>
                            <div class="boxStatus d-flex">
                                <i class="fas fa-circle codeOpen"></i>
                                <p class="m-0">Cita abierta</p>
                            </div>
                            <div class="boxStatus d-flex">
                                <i class="fas fa-square codeAdviser"></i>
                                <p class="m-0">Evento de asesor de ventas</p>
                            </div>
                            <div class="boxStatus d-flex">
                                <i class="fas fa-square codeManager"></i>
                                <p class="m-0">Evento de coordinador</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/dashboardCalendar.js"></script>