<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .center{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container .img{
        text-align:center;
    }
    .container .details{
        border-left:3px solid #ded4da;
    }
    .container .details p{
        font-size:15px;
        font-weight:bold;
    }
    .chat-list-box {
        width: 100%;
        background: #fff;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        border-radius: 5px;
    }
    .flat-icon li {
        display: inline-block;
        padding: 0px 8px;
        vertical-align: middle;
        position: relative;
        top: 7px;
    }
    .flat-icon a img {
        width: 22px;
        border-radius: unset !important;
    }
    ul.list-inline.text-left.d-inline-block.float-left {
        margin-bottom: 0;
    }
    .chat-list-box ul li img {
        border-radius: 50px;
    }
    .message-box {
        display: inline-block;
        width: 100%;
        background: #fff;
        box-shadow: 0px 10px 30px 0px rgba(50, 50, 50, 0.16);
    }
    .msg-box li {
        display:inline-block;
        padding-left: 10px;
    }
    .msg-box img {
        border-radius:50px;
    }
    .msg-box li span {
        padding-left:8px;
        color:#545454;
        font-weight:550;
    }
    .head-box {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .head-box ul li a {
        color:#fff;
    }
    .chat-person-list {
        overflow-y: auto;
        background-color: #fff;
        border-radius: 0 0 5px 5px;
    }
    .chat-person-list ul li {
        width:100%;
        padding-left: 15px;
        line-height: 50px;
    }
    .chat-person-list ul li img {
        width:60px;
        border-radius:50px;
    }
    span.chat-time {
        float: right;
        font-size: 12px;
    }
    .head-box-1 {
        display: flow-root;
        padding: 10px;
        background: #fff;
    }
    .head-box-1 ul li i {
        color:#fff;
        cursor:pointer;
    }
    .head-box-1 ul li span {
        color:#fff;
        position:relative;
        top:-10px;
    }
    .msg_history {
        padding: 10px;
        height:280px;
        overflow: overlay;
    }
    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }
    .timee {
        position: absolute;
        left: 115px;
        top: 30px;
        color: #fff;
    }
    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }
    .received_withd_msg {
        width: 57%;
    }
    .received_withd_msg p {
        background: rgba(0,123,255,.5) none repeat scroll 0 0;
        border-radius: 3px;
        color: #ffffff;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 22px;
        width: 100%;
        border-bottom-right-radius: 50px;
        border-top-left-radius: 50px;
    }
    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }
    .incoming_msg_img img {
        width: 100%;
        border-radius: 50px;
        float: left;
    }
    .outgoing_msg {
        overflow: hidden;
        margin: 10px 0 10px;
    }
    .sent_msg {
        float: right;
        width: 46%;
    }
    .sent_msg p {
        background: #ddd;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #333;
        padding: 5px 10px 5px 22px;
        width: 100%;
        border-bottom-right-radius: 50px;
        border-top-left-radius: 50px;
    }
    .chat-person-list ul li a {
        color: #545454;
        text-decoration: none;
    }
    .selectedConversation{
        background-color: #eaeaea!important;
    }
    .usersDisconnected .box-s{
        color: red!important;
    }
    .userConnected .box-s{
        color: green!important;
    }
    .selectedDisconnected{
        background-color: #eaeaea !important;
    }
    .height-100{
        height: 100%;
    }
    .height-90{
        height: 90%;
    }
    .height-75{
        height:75%;
    }
    .height-25{
        height:25%;
    }
    .height-10{
        height:10%;
    }
    .btn-close{
        background-color: transparent;
        border: none;
        padding: 0;
    }
    .btn-close i:hover{
        color: red;
    }
    .notificacion-red {
        background-color: #fff;
        -webkit-animation: blinkRed 0.5s infinite;
        -moz-animation: blinkRed 0.5s infinite;
        -ms-animation: blinkRed 0.5s infinite;
        -o-animation: blinkRed 0.5s infinite;
        animation: blinkRed 3s infinite;
    }
    @-webkit-keyframes blinkRed {
        from { background-color: #fff; }
        20% { color: #fff; }
        50% { background-color: #fa3c3c; color: #fff;}
        to { background-color: #fff; }
    }
    @-moz-keyframes blinkRed {
        from { background-color: #fff; }
        20% { color: #fff; }
        50% { background-color: #fa3c3c; color: #fff;}
        to { background-color: #fff; }
    }
    @-ms-keyframes blinkRed {
        from { background-color: #fff; }
        20% { color: #fff; }
        50% { background-color: #fa3c3c; color: #fff;}
        to { background-color: #fff; }
    }
    @-o-keyframes blinkRed {
        from { background-color: #fff; }
        20% { color: #fff; }
        50% { background-color: #fa3c3c; color: #fff;}
        to { background-color: #fff; }
    }
    @keyframes blinkRed {
        from { background-color: #fff; }
        20% { color: #fff; }
        50% { background-color: #fa3c3c; color: #fff;}
        to { background-color: #fff; }
    }
    .asesor_message{
        margin: 30px 20px 25px 20%;
        border-radius: 15px;
        background: #3c4858;
        color: #fff;
        padding: 5px 10px;
        display: inline-block;
        position: relative;
        text-align: left;
        max-width: 65%;
        float: right;
        word-wrap: break-word;
    }
    .cliente_message{
        margin: 5px 0px 24px 20px;
        border-radius: 15px;
        background: #0070d0;
        color: #fff;
        padding: 5px 10px;
        display: inline-block;
        position: relative;
        text-align: left;
        max-width: 65%;
        word-wrap: break-word;
    }
    .sb14:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 11px solid transparent;
        border-right: 16px solid #0070d0;
        border-top: 9px solid #0070d0;
        border-bottom: 21px solid transparent;
        left: -16px;
        top: 0px;
    }
    .li_time {
        position: absolute;
        margin: 3px 24px;
        font-size: 0.7em;
        bottom: 0%;
        list-style: none;

    }
    .sb15:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-top: 22px solid #3c4858;
        border-bottom: 0px solid transparent;
        border-right: 0px solid #3c4858;
        border-left: 25px solid transparent;
        right: -10px;
        top: -11px;
        transform: rotate(135deg);
    }
    .right_position {
        right: 0%;
    }
    .feebinfo {
        position:absolute;
        bottom:0;
        font-size: 0.8em;
    }
    .d-flex {
        display: flex;
    }
    .d-none {
        display:none;
    }
    .m-0 {
        margin: 0px;
    }
    .padding0 {
        padding: 0px;
    }
    .pl-0 {
        padding-left: 0px;
    }
    .pl-4 {
        padding-left: 40px;
    }
    .pr-0 {
        padding-right: 0px;
    }
    .pt-1 {
        padding-top:10px;
    }
    .pt-3{
        padding-top:30px;
    }
    .pb-1 {
        padding-bottom:10px;
    }
    .themeBtn {
        background: #71DBDA;
        color: #ffffff !important;
        display: inline-block;
        font-size: 15px;
        font-weight: 500;
        height: 30px;
        line-height: 0.2;
        padding: 18px 30px;
        text-transform: capitalize;
        border-radius: 1px;
        letter-spacing: 0.5px;
        border:0px !important;
        cursor:pointer;
        border-radius:100px;
    }
    .box-chat-all {
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
    }
    .box-send-btn {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-right: 9px;
    }
    .msg_send_btn {
        background: #048DD4 none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        font-size: 16px;
        height: 35px;
        width: 35px;
    }
    .sent_msg {
        float: right;
        width: 46%;
    }
    .type_msg {
        padding: 3px 0 3px 0;
        background-color: #fff;
        border-radius: 0 0 6px 6px;
        border-top:1px solid #eaeaea;
    }
    .input_msg_write textarea {
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        height: 100%;
        width: 100%;
        resize: none;
        padding: 5px;
    }
    /*------------------------------------
    Messages
    ------------------------------------*/
    .unread {
        cursor: pointer;
        background-color: #f4f4f4;
    }
    #perfil2 {
        padding: 0px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #103f75;
        border-radius: 5px 5px 0 0;
        font-weight: 400;
        color: white;
        height:100%;
    }
    .messages-box {
        max-height: 96%;
        overflow: auto;
    }
    .online-circle {
        border-radius: 5rem;
        width: 5rem;
        height: 5rem;
    }
    .messages-title {
        float: right;
        margin: 0px 5px;
    }
    .message-img {
        float: right;
        margin: 0px 5px;
    }
    .message-header {
        text-align: right;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    .text-editor {
        min-height: 18rem;
    }
    .messages-list li.messages-you .messages-title {
        float: left;
    }
    .messages-list li.messages-you .message-img {
        float: left;
    }
    .messages-list li.messages-you p {
        float: left;
        text-align: left;
    }
    .messages-list li.messages-you .message-header {
        text-align: left;
    }
    .messages-list li p {
        max-width: 60%;
        padding: 5px;
        border: #e6e7e9 1px solid;
    }
    .messages-list li.messages-me p {
        float: right;
    }
    .ql-editor p {
        font-size: 1rem;
    }
    .messages-p {
        height: auto;
        word-wrap: break-word;
    }
    .badgep {
        padding: 3px 6px;
        font-size: 13px;
        font-weight: 500;
        background-color: #333;
        border-radius: 10px;
    }
    .list-inline li {
        display: block!important;
    }
    .tab-pane {
        background-color: white;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        padding: 5px;
        border-radius: 5px;
    }
    .tab-pane h4 {
        justify-content: center;
        margin-bottom: 0px;
    }
    /*.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        background-color: #103f75;
    }*/

    .box-instructivo {
        background-color: #a5a5a5;
        color: #fff;
        border-radius: 5px;
        padding: 5px 10px;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        overflow: auto;
    }
    .box-ins-h {
        justify-content: center;
        align-items: center;
    }
    .box-ins-h p {
        font-size: 16px;
        letter-spacing: 3px;
        font-weight: 500;
    }
    .box-ins-h i {
        font-size: 24px;
        margin-right: 5px;
    }
    .no-btn{
        background-color: transparent;
        border: none;
        color: #545454;
    }
    .no-btn:hover{
        color:red;
    }
    .col-img{
        border-right: 2px solid #eaeaea
    }
    .flex-end{
        justify-content: flex-end;
    }
    #EditarPerfilForm .form-group{
        margin: 0!important;
    }
    /* Estilo del scroll en DIVS */
    /* El background del scroll */
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
        border-radius: 10px;
        background-color: #c1c1c1;
    }
    /* Color del HOVER de barra de desplazamiento */
    .scroll-styles::-webkit-scrollbar-thumb:hover {
        background-color: #A8A8A8;
    }
    /* END de estilos del scroll en DIVS */
    /* medias */
    @media only screen and (max-width: 600px) {
        .msg_send_btn{
            font-size: 12px;
            height: 35px;
            width: 35px;
        }
    }
    @media screen and (min-width: 990px) {
        .box-img{
            width: 145px;
            height: 145px;
            border-radius: 50%;
        }
    }
    @media screen and (max-width: 990px) {
        .box-img{
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }
        .col-img {
            border: none!important;
        }
    }

    /* END medias */
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

        if ($this->session->userdata('id_rol') == 7 && empty($permiso)) {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        if($this->session->userdata('id_rol') == 7 && $permiso[0]['estado'] != 1){
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-comments fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Perfil y conversaciones</h3>
                                    <p class="card-title pl-1">chat</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row pb-5">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-12 center col-img">
                                            <div class="box-img" style="background-image: url(../static/images/perfil/<?=$permiso[0]['id_usuario']?>/<?=$permiso[0]['foto']?>); background-position: center; background-repeat: no-repeat; background-size: cover;width: 150px; height: 150px; border-radius: 50%; margin: auto;">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9 pl-4">
                                            <div class="row">
                                                <div class="col-md-12 d-flex flex-end">
                                                    <button class="no-btn" data-toggle="modal" data-target="#EditarMiPerfil"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-md-12">
                                                    <?php
                                                    if ($permiso[0]['estatus'] == 3) {
                                                        echo '<b>Estatus</b><p>Off line</p>';
                                                    }elseif ($permiso[0]['estatus'] == 2) {
                                                        echo '<b>Estatus</b><p><span class="label label-warning" >Consulta</span></p>';
                                                    }elseif ($permiso[0]['estatus'] == 1) {
                                                        echo '<b>Estatus</b><p><span class="label label-success" >Online</span></p>';
                                                    }
                                                    elseif ($permiso[0]['estatus'] == 4) {
                                                        echo '<b>Estatus:</b><p><span class="label" style="background-color:#47F2C8;border-color:#47F2C8;" >Autorizado</span></p>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <p><b>Mensaje</b><br><i style="font-size: 18px">"<?=$permiso[0]['mensaje']?>"</i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" /> <!--beginDate-->
                                                            <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" /> <!--endDate-->
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                <span class="material-icons update-dataTable">search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tabla_chats" class="table-striped table-hover" style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th>ESTATUS</th>
                                                    <th>ID</th>
                                                    <th>SEDE</th>
                                                    <th>ID CHAT</th>
                                                    <th>FECHA CREACIÓN</th>
                                                    <th></th>
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


        <div class="container-fluid hide" id="box-principal" style="margin-top: 70px;">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-content pt-2 pb-2">
                        <div class="text-right">
                        </div>
                        <div class="row d-flex">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-12 center col-img">
                                <div class="box-img" style="background-image: url(../static/images/perfil/<?=$permiso[0]['id_usuario']?>/<?=$permiso[0]['foto']?>); background-position: center; background-repeat: no-repeat; background-size: cover;width: 150px; height: 150px; border-radius: 50%; margin: auto;">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-9 pl-4">
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-end">
                                        <button class="no-btn" data-toggle="modal" data-target="#EditarMiPerfil"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col-md-12">
                                        <?php
                                        if ($permiso[0]['estatus'] == 3) {
                                            echo '<b>Estatus</b><p>Off line</p>';
                                        }elseif ($permiso[0]['estatus'] == 2) {
                                            echo '<b>Estatus</b><p><span class="label label-warning" >Consulta</span></p>';
                                        }elseif ($permiso[0]['estatus'] == 1) {
                                            echo '<b>Estatus</b><p><span class="label label-success" >Online</span></p>';
                                        }
                                        elseif ($permiso[0]['estatus'] == 4) {
                                            echo '<b>Estatus:</b><p><span class="label" style="background-color:#47F2C8;border-color:#47F2C8;" >Autorizado</span></p>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12">
                                        <p><b>Mensaje</b><br><i style="font-size: 18px">"<?=$permiso[0]['mensaje']?>"</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-12"></div>
                            <div class="col-md-2">
                                <input type="date" name="fecha1" id="fecha1" class="form-control">
                            </div>
                            <div class="col-md-2" id="f2">
                                <input type="date" name="fecha2" id="fecha2" class="form-control">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabla_chats" class="table table-striped table-no-bordered table-hover" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th class="disabled-sorting text-right"><center>Estatus</center></th>
                                    <th class="disabled-sorting text-right"><center>ID</center></th>
                                    <th class="disabled-sorting text-right"><center>Sede</center></th>
                                    <th class="disabled-sorting text-right"><center>Id chat</center></th>
                                    <th class="disabled-sorting text-right"><center>Fecha creación</center></th>
                                    <th class="disabled-sorting text-right"><center></center></th>
                                    <th class="disabled-sorting text-right"><center>Acciones</center></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>

    <input type="hidden" name="foto" id="foto" value="<?=$permiso[0]['foto']?>">
    <input type="hidden" name="nom" id="nom" value="<?=$this->session->userdata('nombre')?>">

    <div class="modal fade" id="EditarMiPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" style="width: 24%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Editar perfil chat</h4>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="box-img" style="background-image: url(../static/images/perfil/<?=$permiso[0]['id_usuario']?>/<?=$permiso[0]['foto']?>); background-position: center; background-repeat: no-repeat; background-size: cover;width: 150px; height: 150px; border-radius: 50%; margin: auto;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                        <div class="row">
                            <div class="col-12 col-xs-12 col-md-12">
                                <p class="m-0">Mensaje de bienvenida</p>
                                <textarea class="form-control scroll-styles" name="mensajeE" id="mensajeE" rows="2" style="padding: 0 10px"><?=$permiso[0]['mensaje']?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-xs-12 col-md-12 pt-3">
                                <p class="m-0">Estatus</p>
                                <select class="form-control" id="estatusE" name="estatusE"/>
                                <?php
                                if ($permiso[0]['estatus'] == 3) {
                                    echo '<option value="1">En línea</option>';
                                    echo '<option value="2">Consulta</option>';
                                }
                                elseif ($permiso[0]['estatus'] == 2) {
                                    echo '<option value="2" selected>Consulta</option>';
                                    echo '<option value="1">En línea</option>';
                                }elseif ($permiso[0]['estatus'] == 1) {
                                    echo '<option value="1" selected>En línea</option>';
                                    echo '<option value="2">Consulta</option>';
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="idasesor" id="idasesor" value="<?=$permiso[0]['id_usuario']?>">
                        <input type="hidden" name="idasesorEp" id="idasesorEp" >
                        <input type="hidden" name="estatusA" id="estatusA" value="<?=$permiso[0]['estatus']?>">
                        <div class="row">
                            <div class="col-12 col-xs-12 col-md-12 pt-3 d-flex" style="justify-content: flex-end">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                                <button type="button" id="btnenviar" class="btn btn-primary" style="padding: 12px 30px!important; margin-left:  5px">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AlertaPermiso" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">No estas autorizado para acceder al chat en vivo!</h5>

                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="consultaModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 450px;">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="modal-title" id="exampleModalLongTitle">Chat</h5>
                            </div>
                            <div class="col-md-3" style="display: flex; align-items: center; justify-content: flex-end; padding-right: 0;">
                                <span class="btn-captura">
                                </span>
                                <button type="button" class="close" onclick="cargar();" data-dismiss="modal" aria-hidden="true">
                                    <i class="material-icons">clear</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div id="perfil"></div>
                        <div class="row  mb-4">
                            <div class="col-lg-4">
                                <div class="card" >
                                    <div id="perfil2" class="box-header-chat" style="padding-left:5%;padding-top:1%;"></div>
                                    <div class="card-body messages-box" style="height: 400px;" id="Scr">
                                        <ul class="" id="mensajesid">
                                        </ul>
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

<div class="modal fade in" id="maxSedes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-small ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
            </div>
            <div class="modal-body text-center">
                <h5><b>La sede ha alcanzado el límite de usuarios online permitidos para chatear.</b></h5>
                <p>¡Datos actualizados exitosamente!</p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-simple" data-dismiss="modal" onClick="window.location.reload();">Cerrar
                    <div class="ripple-container">
                        <div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);">
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>

<script type="text/javascript">
    let url = "<?=base_url()?>";
    let foto = "<?=$permiso[0]['foto']?>";
    let nombre = "<?=$permiso[0]['foto']?>";

    let usuario = <?=$this->session->userdata('id_usuario')?>;
    let estatusActual = $('#estatusA').val();


    $('#tabla_chats thead tr:eq(0) th').each(function (i) {
        if (i != 6) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" ' +
                'class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tabla_chats').DataTable().column(i).search() !== this.value) {
                    $('#tabla_chats').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    $(document).ready(function () {
        if(estatusActual == 3){
            actualizar();
        }

        function actualizar() {
            var parametros = {
                "val" : 2
            };

            $.ajax({
                type: 'POST',
                url: '<?=base_url()?>index.php/Chat/CambioSesion',
                data: parametros,
                success: function(data) {
                    document.location.reload();
                },
            });
        }

        //si el estatus es 4 dejarlo asi 
        function historialChat(fecha1,fecha2){
            chatsTable = $('#tabla_chats').DataTable({
                dom: "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'B><'col-xs-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    }
                ],
                ordering: false,
                paging: true,
                pagingType: "full_numbers",
                autoWidth: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                language: {
                    url: "../../static/spanishLoader.json"
                },
                destroy: true,
                columns: [
                    { data: function (d) {
                            return '<center><span class="label label-warning" >Activo</span><center>';

                        }
                    },
                    { data: function (d) {
                            return d.idchat;
                        }
                    },
                    { data: function (d) {
                            if(d.id_sede == 1){
                                return '<p>San Luis Potosí</p>';
                            }else  if(d.id_sede == 2){
                                return '<p>Querétaro</p>';
                            }else  if(d.id_sede == 3){
                                return '<p>Península</p>';
                            }else  if(d.id_sede == 4){
                                return '<p>Ciudad de México</p>';
                            }else  if(d.id_sede == 5){
                                return '<p>León</p>';
                            }else  if(d.id_sede == 6){
                                return '<p>Cancún</p>';
                            }else  if(d.id_sede == 7){
                                return '<p>United States</p>';
                            }
                            //return d.id_sede;
                        }
                    },
                    { data: function (d) {
                            return d.idgenerado;
                        }
                    },
                    { data: function (d) {
                            let fecha = d.fecha_creacion.split('.');
                            return fecha[0];
                        }
                    },

                    { data: function(d){
                            return d.conversacion;
                        }

                    },

                    { data: function (d) {
                            return '<button class="btn btn-success btn-round btn-fab btn-fab-mini consulta_chat" data-id-usuario="' + d.idgenerado+","+d.id_usuario +","+d.idchat+","+d.foto+","+d.nombre+' '+d.apellido_paterno+'" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C"><i class="material-icons" data-toggle="tooltip" data-placement="right" title="Consultar">visibility</i></button>';
                        }
                    }
                ],
                columnDefs: [{
                    targets: 5,
                    searchable: true,
                    visible: false
                }],
                "ajax": {
                    "url": "MisChatsConsulta/"+fecha1+'/'+fecha2,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                }
            });
        }

        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();
    });

    sp = { //  SELECT PICKER
        initFormExtendedDatetimepickers: function () {
            $('.datepicker').datetimepicker({
                format: 'MM/DD/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove',
                    inline: true
                }
            });
        }
    }

    function setInitialValues() {
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
        finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
        // console.log('Fecha inicio: ', finalBeginDate);
        // console.log('Fecha final: ', finalEndDate);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        fillTable(1, finalBeginDate, finalEndDate, 0);
    }

    function cargar() {
        document.getElementById("perfil").innerHTML = '';
        document.getElementById("perfil2").innerHTML = '';
        document.getElementById("mensajesid").innerHTML = '';

    }

    $(document).on('click', '.consulta_chat', function(e){

        idgenerado2 = $(this).attr("data-id-usuario");
        var datos = idgenerado2.split(",");
        let idgenerado = datos[0];
        let id_asesor = datos[1];
        let idchat = datos[2];
        $(".btn-captura").html("");
        $("#perfil2").html("");
        $("#mensajesid").html("");


        $('#perfil2').append(`<ul class="msg-box list-inline text-left d-inline-block float-left" style="margin-bottom:0px;"><br><li>ID: ${idgenerado}</li></ul>`);

        $('.btn-captura').append(`<button type="button" class="down_img" onclick="captura('${idgenerado}')" data-dismiss="modal" aria-hidden="true" style="background-color: transparent; border:none"><i class="material-icons" style="font-size: 20px;">file_download</i></button>`);


        var parametros = { "id" : idgenerado };
        $.ajax({
            type: 'POST',
            url: 'getMischats',
            data: parametros,
            beforeSend: function(){
                // Actions before send post
                $('#mensajesid').append('<div class="col col-xs-12" style="text-align:center"><h5>Cargando mensajes...</h5><br> <img src="<?=base_url()?>static/images/cargando_chat.gif"></div>');
            },
            success: function(datos) {
                $('#mensajesid').html('');
                console.log(JSON.parse(datos));
                let elements = JSON.parse(datos);
                for (var x = 0; x < elements.length; x++) {
                    if(elements[x]['de'] == id_asesor){
                        $('#mensajesid').append(`
                                                <div class="col-xs-12 padding0"><div class="asesor_message sb15">${elements[x]['mensaje']}</div><li class="li_time right_position">${elements[x]['fecha_creacion']}</li></div>`);

                    }
                    else{
                        $('#mensajesid').append(`<div class="col-xs-12 padding0"><li class="cliente_message sb14">${elements[x]['mensaje']}</li><li class="li_time">${elements[x]['fecha_creacion']}</li></div>`);
                    }
                }

                /*--------FIN DE CODIGO PARA CONSTRUIR EL CHAT----------------*/
            }
        });

        $("#consultaModal").modal();
    });

    $("#btnenviar").on('click', function(e){
        let mensaje = $('#mensajeE').val();
        let numeros =  getNumbersInString(mensaje);
        if(numeros.length > 2 || mensaje.indexOf('@') >= 0){
            //alert('nelson');
            alerts.showNotification("top", "right", "No se permite ingresar teléfonos ni correos en este campo.", "warning");
        }
        else{
            updateDatos();
        }
    });

    let v2;
    $("#file-uploadE").on('change', function(e){
        v2 = document.getElementById("file-uploadE").files[0].name;
    });

    function updateDatos() {
        let val=0;
        if (v2 == undefined || v2 == '') val =1;
        else val=2;

        var formData = new FormData(document.getElementById("EditarPerfilForm"));
        formData.append("dato", "valor");
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Chat/UpdatePerfilAs/'+val,
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                // alert(data);
                if (data == 1) {
                    $("#EditarMiPerfil").modal('hide');
                    setTimeout('document.location.reload()',1000);
                    alerts.showNotification("top", "right", "Se ha actualizado con éxito.", "success");
                }
                else if ( data == 2 ){
                    $("#EditarMiPerfil").modal('hide');
                    // setTimeout('document.location.reload()',1000);
                    // alerts.showNotification("top", "right", "Se ha actualizado con éxito.", "success");
                    // alerts.showNotification("top", "right", "Ya están cubiertos todos los chats permitidos para esta sede", "warning");
                    $("#maxSedes").modal('show');
                }
                else {
                    $("#EditarMiPerfil").modal('hide');
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                $("#EditarMiPerfil").modal('hide');
                //   $allUsersTable.ajax.reload();
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

    /*---------------------------------CAPTURA DE PANTALLA-----------------------------------------*/
    function captura(id){
        var div = document.getElementById("Scr");
        div.style.maxHeight = "100%";
        div.style.height="100%";
        $objetivo = document.querySelector("#Scr");

        html2canvas($objetivo)
            .then(enviarCapturaAServidor);
        alerts.showNotification("top", "right", "Captura correctamente", "info");
    }

    const enviarCapturaAServidor = canvas => {
        let enlace = document.createElement('a');
        enlace.download = "Captura de página web - Parzibyte.me.png";

        enlace.href = canvas.toDataURL();
        enlace.click();
        var div = document.getElementById("Scr");
        div.style.maxHeight = "400px";
        div.style.height="400px";
    };
    /*-----------------------------FIN DE CAPTURA---------------------------------------*/

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

    $(window).resize(function(){
        lista_clientes.columns.adjust();
    });


    function fillTable(typeTransaction, beginDate, endDate, where) {
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);

        chatsTable = $('#tabla_chats').DataTable({
            dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt><'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Conversaciones',
                    title:'Conversaciones',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ESTATUS';
                                        break;
                                    case 1:
                                        return 'ID';
                                        break;
                                    case 2:
                                        return 'SEDE';
                                    case 3:
                                        return 'ID CHAT';
                                        break;
                                    case 4:
                                        return 'FECHA CREACIÓN';
                                        break;
                                    case 5:
                                        return 'CONVERSACIÓN';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            ordering: false,
            paging: true,
            pagingType: "full_numbers",
            autoWidth: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "select": true,
            "scrollX":        true,
            pageLength: 10,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            columns: [
                { data: function (d) {
                        return '<center><span class="label label-warning" >Activo</span><center>';

                    }
                },
                { data: function (d) {
                        return d.idchat;
                    }
                },
                { data: function (d) {
                        if(d.id_sede == 1){
                            return '<p>San Luis Potosí</p>';
                        }else  if(d.id_sede == 2){
                            return '<p>Querétaro</p>';
                        }else  if(d.id_sede == 3){
                            return '<p>Península</p>';
                        }else  if(d.id_sede == 4){
                            return '<p>Ciudad de México</p>';
                        }else  if(d.id_sede == 5){
                            return '<p>León</p>';
                        }else  if(d.id_sede == 6){
                            return '<p>Cancún</p>';
                        }else  if(d.id_sede == 7){
                            return '<p>United States</p>';
                        }
                        //return d.id_sede;
                    }
                },
                { data: function (d) {
                        return d.idgenerado;
                    }
                },
                { data: function (d) {
                        let fecha = d.fecha_creacion.split('.');
                        return fecha[0];
                    }
                },

                { data: function(d){
                        return d.conversacion;
                    }

                },

                { data: function (d) {
                        return '<button class="btn-data btn-blueMaderas consulta_chat" data-id-usuario="' + d.idgenerado+","+d.id_usuario +","+d.idchat+","+d.foto+","+d.nombre+' '+d.apellido_paterno+'"><i class="fas fa-eye" title="Consultar"></i></button>';
                    }
                }
            ],
            columnDefs: [{
                targets: 5,
                searchable: true,
                visible: false
            }],
            "ajax": {
                "url": "MisChatsConsulta/",
                "type": "POST",
                cache: false,
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where
                }
            }
        });

        /*"url": "MisChatsConsulta/"+fecha1+'/'+fecha2,*/
    }

    $(document).on("click", "#searchByDateRange", function () {
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);
    });
</script>
</body>
</html>