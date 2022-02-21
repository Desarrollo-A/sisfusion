<meta charset='utf-8'>
<meta name="viewport" 
content="width=device-width, height=device-height, initial-scale=1">

<style>
.chat-list-box {
        width: 100%;
        background: #fff;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        border-radius: 5px;
    }
    ul.list-inline.text-left.d-inline-block.float-left {
        margin-bottom: 0;
    }
    .head-box {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .head-box .i-out{
        font-size: 18px;
        border: none;
        background-color: white;
        display: flex;
        padding: 0;
        align-items: center;
    }
    .head-box .i-out:hover{
        font-size:22px;
        color: red;
    }
    .chat-person-list{
        overflow-y: auto;
        background-color: #fff;
        border-radius: 0 0 5px 5px;
    }
    .chat-person-list ul li {
        width:100%;
        padding-left: 15px;
        line-height: 50px;
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
    .w-100{
        width:100%;
    }
    .w-90{
        width:90%;
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
        border-radius: 15px 0 15px 15px;
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
        border: 12px solid;
        border-color: #0070d0 transparent transparent transparent;
        left: -10px;
        top: 0px;
    }
    .li_time
    {
        position: absolute;
        margin: 3px 24px;
        font-size: 0.7em;
        bottom: 0%;
    }
    .sb15:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border: 12px solid;
        border-color: #3c4858 transparent transparent transparent;
        right: -10px;
        top: -0px;
    }
    .right_position{
        right: 0%;
    }
    .feebinfo{
        position:absolute;
        bottom:0;
        font-size: 0.8em;
    }
    .justify-end{
        justify-content: flex-end;
    }
    .align-center{
        align-items:center;
    }
    .d-flex{
        display: flex;
    }
    .d-none{
        display:none;
    }
    .m-0{
        margin: 0px;
    }
    .ml-1{
        margin-left: 10px;
    }
    .padding0 {
        padding: 0px;
    }
    .pl-0{
        padding-left: 0px;
    }
    .pr-0{
        padding-right: 0px;
    }
    .pt-1{
        padding-top:10px;
    }
    .pt-2{
        padding-top:20px;
    }
    .pb-1{
        padding-bottom:10px;
    }
    .themeBtn {
        background-color: #AEA16E;
        color: #ffffff !important;
        font-size: 15px;
        font-weight: 400;
        padding: 10px 30px;
        border: 0px !important;
        border-radius: 30px
    }
    .themeBtn2 {
        background-color: #aeaeae;
        color: #ffffff !important;
        font-size: 15px;
        font-weight: 400;
        padding: 10px 30px;
        border: 0px !important;
        border-radius: 30px
    }
    .box-chat-all{
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
    }
    .box-send-btn{
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
    .type_msg{
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
    textarea{
        resize: none;
    }
    .box-btns{
        display: flex;
        align-items: flex-end;
        padding-bottom: 10px;
        width: 100%;
        justify-content: flex-end;
    }
    /*------------------------------------
Messages
------------------------------------*/
    #box-header-chat{
        padding: 5px 0;
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
        padding: 0 12px;
    }
    .badgep{
        padding: 3px 6px;
        font-size: 13px;
        font-weight: 500;
        background-color: #333;
        border-radius: 10px;
    }
    .list-inline li{
        display: block!important;
    }
    .tab-pane{
        background-color: white;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        padding: 5px;
        border-radius: 5px;
    }
    .tab-pane h4{
        justify-content: center;
        margin-bottom: 0px;
    }
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        background-color: #103f75;
        border-radius:5px;
    }
    .box-instructivo{
        background-color: #a5a5a5;
        color: #fff;
        border-radius: 5px;
        padding: 5px 10px;
        box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
        overflow: auto;
    }
    .box-ins-h{
        justify-content: center;
        align-items: center;
    }
    .box-ins-h p{
        font-size: 16px;
        letter-spacing: 3px;
        font-weight: 500;
    }
    .box-ins-h i{
        font-size: 24px;
        margin-right: 5px;
    }
    /* Estilo del scroll en DIVS */
    /* El background del scroll */
    .scroll-styles::-webkit-scrollbar-track{
        border-radius: 10px;
        background-color: transparent;
    }
    /* El background del scroll (border)*/
    .scroll-styles::-webkit-scrollbar{
        width: 9px;
        background-color: transparent;
    }
    /* Color de la barra de desplazamiento */
    .scroll-styles::-webkit-scrollbar-thumb{
        border-radius: 10px;
        background-color: #c1c1c1;
    }
    /* Color del HOVER de barra de desplazamiento */
    .scroll-styles::-webkit-scrollbar-thumb:hover{
        background-color: #A8A8A8;
    }
    /* END de estilos del scroll en DIVS */

    /*---formulario----*/
    .formul{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #C2C2C2;
        box-shadow: 1px 1px 4px #EBEBEB;
        -moz-box-shadow: 1px 1px 4px #EBEBEB;
        -webkit-box-shadow: 1px 1px 4px #EBEBEB;
        border-radius: 9px;
        -webkit-border-radius:9px;
        -moz-border-radius: 9px;
        padding: 5px;
        outline: none;
        width: 100%;
    }
    .formul:focus{
        border: 1px solid grey;
    }
    #box-mobile{
        display: none;
    }
    .link_chat{
        color: #80bdff;
    }
    .link_chat:hover{
        color: #bbbbbb;
        border-bottom: 1px solid #bbbbbb;
    }
    /*---END formulario----*/

    @media (max-width: 992px) {
        #box-principal{
            display: none;
        }
        #box-mobile{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #box-mobile p{
            font-size: 16px;
            font-weight: 500;
        }
    }

    @media (min-width: 992px){
        #formprospect textarea{
            height: 45px!important;
        }
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

        if ($this->session->userdata('id_rol') == 7 && empty($permiso)) {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
            print_r("hola agaaaain");
        }
        if($this->session->userdata('id_rol') == 7 && $permiso[0]['estado'] != 1){
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
        ?>
        <!-- modal para cerrar conversación -->
        <div class="modal fade in" id="closeConversation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-small ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5>¿Cerrar conversación? </h5>
                        <p style="font-size: 0.8em">Podrás consultar está conversación el apartado de historial.</p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-simple" data-dismiss="modal">Cancelar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                        <button type="button" class="btn btn-success btn-simple" id="btn_confirma_borrado">Si</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal para cerrar sesion y todas las conversaciones -->
        <div class="modal fade in" id="closeAllChats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-small ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5>¿Finalizar sesión? </h5>
                        <p style="font-size: 0.8em">Se cerrarán y guardarán todas las conversaciones.</p>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-simple" data-dismiss="modal">Cancelar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                        <button type="button" class="btn btn-success btn-simple" id="btn_confirma_borrado_all">Si</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="advertencia_lead" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-small ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5>Debe de realizar la captura de evidencia del lead antes de guardar los datos del mismo</h5>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-simple" data-dismiss="modal">Aceptar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" id="box-principal" style="height:calc(100vh - 188px); margin-top: 70px;">
            <input type="hidden" name="foto" id="foto" value="<?=$permiso[0]['foto']?>">
            <input type="hidden" name="nom" id="nom" value="<?=$this->session->userdata('nombre')?>">
            <input type="hidden" name="idasesor" id="idasesor" value="<?=$this->session->userdata('id_usuario')?>">

            <div class="container-fluid height-100 pt-1 pb-1">
                <div class="row pb-1 height-100">
                    <div class="col-md-3 col-lg-3 height-100 pr-0">
                        <div class="container-fluid height-100 padding0">
                            <div class="row height-100">
                                <div class="col-md-12 height-75">
                                    <div class="chat-list-box height-100">
                                        <div class="head-box" style="height:10%">
                                        <div class="row w-100 height-100 d-flex align-center">
                                                <div class="col-md-10 d-flex justify-center">
                                                    <p style="margin: 0" id="mischats"></p>
                                                </div>
                                                <div class="col-md-2 d-flex justify-end height-100">
                                                    <button class="i-out btn_session_chat" data-asesor="<?=$this->session->userdata("id_usuario") ?>">
                                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div><!-- END head-box-->
                                        <div class="row" style="height:1%">
                                            <div class="col-md-12" style="display:flex; justify-content:center">
                                                <hr style="width: 90%; margin:0 0 5px 0">
                                            </div>
                                        </div>
                                        <div class="row" style="height:89%">
                                            <div class="col-md-12 height-100">
                                                <div class="chat-person-list scroll-styles height-100   ">
                                                    <ul class="list-inline" id="chats">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- END row -->
                                    </div><!-- END chat-list-box -->
                                </div><!-- END col-md-12 -->
                                <!-- <div class="col-md-12 height-25 pt-1">
                                    <div class="row height-100">
                                        <div class="col-md-12 height-100">
                                            <div class="box-instructivo height-100 scroll-styles">
                                                <div class="box-ins-h d-flex" style="height:18%">
                                                    <i class="fa fa-info-circle"></i>
                                                    <p class=" p-inst m-0">Instructivo</p>
                                                </div>
                                                <div class="box-steps scroll-styles" style="height:8%">
                                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                                    <p>Accusantium animi modi minima assumenda, non voluptas itaque dignissimos!</p>
                                                    <p>Non voluptas itaque dignissimos</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>END col-md-12 -->
                            </div><!-- END row -->
                        </div><!--END container fluid -->
                    </div> <!-- END col-md-3 -->

                    <div class="col-lg-5 col-md-5 height-100">
                        <div class="box-chat-all height-100">
                            <div class="row height-100">
                                <div class="col-md-12 height-90">
                                    <div class="card m-0 height-100" style="border-radius: 6px 6px 0 0; box-shadow:none">
                                        <div class="row height-100">
                                            <div class="col-md-12" style="height:7%">
                                                <div id="box-header-chat">
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="height:93%;">
                                                <div class="messages-box scroll-styles" id="scrolll" >
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END card -->
                                </div><!-- END col-md-12 -->
                                <div class="col-md-12 height-10">
                                    <div class="type_msg height-100">
                                        <div class="input_msg_write height-100">
                                            <input type="hidden" name="ultimomsj" id="ultimomsj">
                                            <form method="post" id="ResponderMsj" class="height-100">
                                                <input type="hidden" name="idchatt" id="idchatt">
                                                <input type="hidden" name="paraid" id="paraid">
                                                <div class="container-fluid height-100">
                                                    <div class="row height-100">
                                                        <div class="col-md-10 padding0 height-100">
                                                            <textarea class="write_msg scroll-styles" id="RespuestaMsj" name="RespuestaMsj" required="" placeholder="Escriba su respuesta"></textarea>
                                                        </div>
                                                        <div class="col-md-2 padding0 height-100">
                                                            <div class="box-send-btn height-100">
                                                                <button class="msg_send_btn" type="submit">
                                                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <input type="hidden" name="todosloschats" id="todosloschats">
                                </div>
                            </div><!-- END row -->
                        </div><!-- END box-chat-all -->
                    </div><!-- END col-lg-4 -->

                    <div class="col-lg-4 col-md-4 height-100">
                        <div class="box-container-b d-none height-100">
                            <ul class="nav nav-pills height-10">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#formulario" role="tab" aria-controls="pills-formulario" aria-selected="false">Formulario prospecto</a>
                                </li>
                            </ul>
                            <div class="tab-content height-90">
                                <div class="tab-pane fade height-100" id="formulario" role="tabpanel" aria-labelledby="formulario_pros_tab">
                                    <h4 class="d-flex" id="form_title_id"></h4>
                                    <form id="formprospect" method="post" style="height: calc(100% - 33px);">
                                        <div class="container-fluid height-90">
                                            <div class="row pt-2">
                                                <div class="col-md-6 col-sm-12">
                                                    <span>Nombre</span><span style="color: red;">*</span>
                                                    <input type="text" name="nombre" required="text" id="nombre"  class="formul" placeholder="Nombre del prospecto">
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <span>Apellido</span>
                                                    <input type="text" name="app" id="app" class="formul" placeholder="Apellido del prospecto">
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-6 col-sm-12">
                                                    <span>Correo</span>
                                                    <input type="email" name="correo" id="correo" class="formul" placeholder="Correo">
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <span>Teléfono</span><span style="color: red;">*</span>
                                                    <input type="number"  name="tel" id="tel" class="formul" placeholder="Teléfono">
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-12 col-sm-12">
                                                    <span>Observaciones</span>
                                                    <textarea class="formul scroll-styles" rows="4" name="obs" id="obs" placeholder="Observaciones"></textarea>
                                                    <input type="hidden" name="nomCaptura" id="nomCaptura">
                                                    <input type="hidden" name="idchatt2" id="idchatt2">
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-6 col-sm-12">
                                                    <span class="control-label">Nacionalidad</span>
                                                    <select id="nationality" name="nationality" class="formul nationality"></select>
                                                </div>
                                                <div class="col-md-6 col-sm-12" id="aquiva">
                                                </div>
                                            </div>
                                            <div class="row pt-1">
                                                <div class="col-md-12 col-sm-12">
                                                    <p style="color: red; font-size:12px"><b>(*)</b> Requerido</p>
                                                </div>
                                            </div>
                                        </div><!-- END container-fluid-->
                                        <div class="container-fluid height-10">
                                            <div class="row height-100">
                                                <div class="col-md-12 col-sm-12 height-100">
                                                    <div class="box-btns height-100">
                                                        <button type="submit" class="themeBtn2"  name="btnprospecto" id="btnprospecto" disabled>Guardar</button><br><br>
                                                        <button type="button" class="themeBtn ml-1" id="btnCapturar" name="btnCapturar" >Captura</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- END container-fluid-->
                                    </form><!-- END form prospecto -->
                                </div><!-- END tab formulario -->
                            </div><!-- END tab-content -->
                        </div><!-- END box-container-b-->
                    </div><!-- END col-lg-5 -->
                </div><!-- END row -->
            </div><!-- END container -->
        </div><!-- END container-fluid -->
        <div class="container-fluid" id="box-mobile" style="height:calc(100vh - 188px); margin-top: 70px;">
            <div class="w-90">
                <p>Este apartado es exclusivo para acceder a través de una computadora.</p>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div><!-- END container-->
</div><!-- END wrapper-->
</div><!-- END div_principal -->
</div>
</div>

<div class="modal fade" id="carpetasE" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" >
            <div class="modal-header modal-sm">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <center><br>
                    <h5 >Debe ingresar al menos un teléfono para continuar.</h5>
                </center>
            </div>

            <div class="modal-footer"><br><br>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>

            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AlertaPermisoF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h5 class="modal-title" id="exampleModalLongTitleF">¿Seguro que deseas finalizar tu sesion en el chat?</h5>
            <form id="finchat">
                <input type="hidden" name="idnewchat" id="idnewchat">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ConfirmarSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLongTitleF">¿Seguro que desea finalizar su sesion?</h5>
                <form id="finSesion">

            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Aceptar</button>
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" name="pivote" id="pivote">

<style>
.bkLoading
{
   /* background:#000; *//*b3b3b3*/
   background-image: linear-gradient(to bottom, #000, #000);
   position:absolute;
   top:0%;
   left:0%;
   width:100%;
   height:100%;
   z-index:99999;
   padding-top:200px;
   color:white;
   font-weight:300;
   opacity: 0.5;


   /* display:none; */
}

.lds-dual-ring.hidden {
    display: none;
}
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 5% auto;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: #103f75;
    z-index: 9999999;
    opacity: 0.4;
    transition: all 0.5s;
    display: flex;
    align-items: center;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

</style>
<div id="loaderDiv" class="lds-dual-ring hidden overlay"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- footer directo -->
    <!--   Core JS Files   -->
    <script src="<?=base_url()?>dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>dist/js/material.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!--<script src="--><?//=base_url()?><!--dist/bower_components/select2/dist/js/select2.full.min.js"></script>-->
    <!-- Forms Validations Plugin -->
    <script src="<?=base_url()?>dist/js/jquery.validate.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?=base_url()?>dist/js/moment.min.js"></script>
    <!--  Charts Plugin -->
    <script src="<?=base_url()?>dist/js/chartist.min.js"></script>
    <!--  Plugin for the Wizard -->
    <script src="<?=base_url()?>dist/js/jquery.bootstrap-wizard.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<?=base_url()?>dist/js/bootstrap-notify.js"></script>
    <!--   Sharrre Library    -->
    <script src="<?=base_url()?>dist/js/jquery.sharrre.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
    <!-- Vector Map plugin -->
    <script src="<?=base_url()?>dist/js/jquery-jvectormap.js"></script>
    <!-- Sliders Plugin -->
    <script src="<?=base_url()?>dist/js/nouislider.min.js"></script>
    <!-- Select Plugin -->
    <script src="<?=base_url()?>dist/js/jquery.select-bootstrap.js"></script>
    <!--  DataTables.net Plugin    -->
    <script src="<?=base_url()?>dist/js/jquery.datatables.js"></script>
    <!-- Sweet Alert 2 plugin -->
    <script src="<?=base_url()?>dist/js/sweetalert2.js"></script>
    <!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="<?=base_url()?>dist/js/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin    -->
    <script src="<?=base_url()?>dist/js/fullcalendar.min.js"></script>
    <!-- TagsInput Plugin -->
    <script src="<?=base_url()?>dist/js/jquery.tagsinput.js"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="<?=base_url()?>dist/js/material-dashboard2.js"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?=base_url()?>dist/js/demo.js"></script>

    <script src="<?=base_url()?>dist/js/alerts.js"></script>

    <script src="<?=base_url()?>dist/js/funciones-generales.js"></script>

    <script src="<?=base_url()?>dist/js/controllers/select2/select2.full.min.js"></script>
    <?php #$this->load->view('template/footer');?>
<!-- TErmina footer directo -->
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        console.log("tamaño: "+$(window).width());

        let textOfChatHeader=document.getElementById('box-header-chat').textContent;
        textOfChatHeader = textOfChatHeader.trim();
        if(textOfChatHeader=='')
        {
            document.getElementById("RespuestaMsj").disabled = true;
            $('.msg_send_btn').attr('disabled', true);
            $('.msg_send_btn').css('background', 'grey');
        }
        $(document).on('click', '#chats li', function () {
            // console.log('click en un li de chat');
            textOfChatHeader = document.getElementById('box-header-chat').textContent;
            console.log(textOfChatHeader);
            if(textOfChatHeader=='')
            {
                document.getElementById("RespuestaMsj").disabled = true;
                $('.msg_send_btn').attr('disabled', true);
                $('.msg_send_btn').css('background', 'grey');
            }else {
                document.getElementById("RespuestaMsj").disabled = false;
                $('.msg_send_btn').attr('disabled', false);
                $('.msg_send_btn').css('background', '#048DD4');
            }
        });
    });

    
    let url3 = '<?=base_url()?>static/documentos/carpetas/';

    $("#nationality").change(function() {
        var parent = $(this).val();
        //alert(parent);
        if(parent == 0){
            document.getElementById("aquiva").innerHTML ='';
            let label = document.createElement("span");
            let select = document.createElement("select");

            label.setAttribute("class","control-label");
            select.setAttribute("id", "estado");
            select.setAttribute("name","estado");
            select.setAttribute("class","formul estadosmx");

            let txtp = document.createTextNode('Estado');
            label.appendChild(txtp);
            document.getElementById("aquiva").appendChild(label);
            document.getElementById("aquiva").appendChild(select);

            $.getJSON("getEstados").done( function( data ){
                $(".estadosmx").append($('<option selected>').val("").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id_estado'];
                    var name = data[i]['nombre'];
                    $(".estadosmx").append($('<option>').val(name).text(name));
                }
            });
        }
        else{
            document.getElementById("aquiva").innerHTML ='';

            let label = document.createElement("span");
            label.setAttribute("class","control-label");
            let input = document.createElement("input");
            input.setAttribute("type","text");
            input.setAttribute("id", "estado");
            input.setAttribute("name","estado");
            input.setAttribute("class","formul");

            let txtp = document.createTextNode('Estado');
            label.appendChild(txtp);

            document.getElementById("aquiva").appendChild(label);
            document.getElementById("aquiva").appendChild(input);
        }
    });

    // Fill the select of nationality
    $.getJSON("getNationality").done( function( data ){
        /*$(".nationality").append($('<option disabled selected>').val("").text("Seleccione una opción"));*/
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".nationality").append($('<option>').val(id).text(name));
        }
    });
    document.getElementById("aquiva").innerHTML ='';
    let label = document.createElement("span");
    let select = document.createElement("select");

    label.setAttribute("class","control-label");
    select.setAttribute("id", "estado");
    select.setAttribute("name","estado");
    select.setAttribute("class","formul estadosmx");



    let txtp = document.createTextNode('Estado');
    label.appendChild(txtp);

    document.getElementById("aquiva").appendChild(label);
    document.getElementById("aquiva").appendChild(select);
    $.getJSON("getEstados").done( function( data ){
        $(".estadosmx").append($('<option selected>').val("").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_estado'];
            var name = data[i]['nombre'];
            $(".estadosmx").append($('<option>').val(name).text(name));
        }
    });

    let url = "<?=base_url()?>";

    $("#formprospect").on('submit', function(e){
        $('#loaderDiv').removeClass('hidden');

        e.preventDefault();
        if ($('#correo').val().length == 0 && $('#tel').val().length == 0) {
            $("#carpetasE").modal();
        }
        else if ($('#correo').val().length != 0 && $('#tel').val().length == 0) {
            document.getElementById('btnprospecto').disabled=true;
            save();
        }

        else if ($('#correo').val().length == 0 && $('#tel').val().length != 0) {  
            document.getElementById('btnprospecto').disabled=true;          
            save();
        }
        else if($('#correo').val().length != 0 && $('#tel').val().length != 0){
            document.getElementById('btnprospecto').disabled=true;
            save();
        }
    });

    function save() {
        document.getElementById('btnprospecto').disabled=true;
        var formData = new FormData(document.getElementById("formprospect"));
        formData.append("dato", "valor");
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Chat/saveProspectChat',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    $('#loaderDiv').addClass('hidden');

                    $('#btnprospecto').removeClass("themeBtn").addClass( "themeBtn2" );
                    document.getElementById("formprospect").reset();
                    //$("#carpetas").modal('hide');
                    alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                    document.getElementById('btnprospecto').disabled=true;
                    //$('#btnprospecto').removeClass("themeBtn").addClass( "themeBtn2" );

                    //$('#btnprospecto').addClass("themeBtn2");

                    document.getElementById('btnprospecto').setAttribute("title", "Debe tomar la captura primero");
                    document.getElementById('btnCapturar').disabled=false;
                }
                else if(data == 0){
                    $('#loaderDiv').addClass('hidden');

                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    document.getElementById('btnprospecto').disabled=false;
                    //$('#btnprospecto').removeClass("themeBtn").addClass("themeBtn2");
                   //$('#btnprospecto').addClass("themeBtn");
                }
                else if (data == 4) {
                    $('#loaderDiv').addClass('hidden');

                    $('#btnprospecto').removeClass("themeBtn").addClass( "themeBtn2" );
                    document.getElementById('btnprospecto').disabled=true;
                   // $('#btnprospecto').removeClass("themeBtn").addClass( "themeBtn2" );
                  //  $('#btnprospecto').addClass("themeBtn2");
                 
                    document.getElementById("formprospect").reset();                    
                    alerts.showNotification("top", "right", "El registro se actualizó exitosamente.", "success");
                   document.getElementById('btnCapturar').disabled=false;
                    document.getElementById('btnprospecto').setAttribute("title", "Debe tomar la captura primero");
                    
                }
            },
            error: function(){
                $('#loaderDiv').addClass('hidden');

                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

    $("#btnfinalizar").on('click', function(e){
        e.preventDefault();
        if ($('#idchatt').val() == undefined || $('#idchatt').val() == '') {
            document.getElementById("exampleModalLongTitle").innerHTML ='Debe seleccionar una conversación!';
            $("#AlertaPermiso").modal('show');
        }
        else{
            document.getElementById("exampleModalLongTitleF").innerHTML ='¿Seguro que desea finalizar esta conversación?';
            $("#AlertaPermisoF").modal('show');
        }
    });

    $("#finchat").on('submit', function(e){
        e.preventDefault();
        if ($('#idchatt').val() == undefined || $('#idchatt').val() == '') {
            document.getElementById("exampleModalLongTitle").innerHTML ='Debe seleccionar una conversación!';
            $("#AlertaPermiso").modal('show');
        }else{
            let parametros = {
                "idchatt" : $('#idchatt').val()
            };

            $.ajax({
                type: 'POST',
                url: '<?=base_url()?>/usuarios/FinalizarChat',
                data: parametros,
                beforeSend: function(){
                    // Actions before send post
                },
                success: function(data) {
                    if (data == 1) {
                        cargar_chats();
                        document.getElementById("mensajesid").innerHTML = '';
                        $("#AlertaPermisoF").modal('hide');
                        alerts.showNotification("top", "right", "Chat finalizado", "info");
                    }
                    else {
                        $("#AlertaPermisoF").modal('hide');
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    $("#AlertaPermisoF").modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    });

    $("#btnfinSesion").on('click', function(e){
        e.preventDefault();
        $("#ConfirmarSesion").modal('show');
    });

    $("#finSesion").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>/usuarios/FinalizarSesion',
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    document.getElementById("exampleModalLongTitleF").innerHTML = '';
                    $("#ConfirmarSesion").modal('hide');
                    alerts.showNotification("top", "right", "Chat finalizado", "info");
                }
                else {
                    $("#ConfirmarSesion").modal('hide');
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                $("#ConfirmarSesion").modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    /*---------------------------------CAPTURA DE PANTALLA-----------------------------------------*/
    const $boton = document.querySelector("#btnCapturar"), // El botón que desencadena
        $objetivo = document.body; // A qué le tomamos la foto

    const enviarCapturaAServidor = canvas => {
        let id = $('#idchatt').val();
        // Cuando se resuelva la promesa traerá el canvas
        // Convertir la imagen a Base64
        let imagenComoBase64 = canvas.toDataURL();
        // Codificarla, ya que a veces aparecen errores si no se hace
        imagenComoBase64 = encodeURIComponent(imagenComoBase64);

        // La carga útil como JSON
        const payload = {
            "captura": imagenComoBase64,
            "id":  ''+id
            // Aquí más datos...
        };
        // Aquí la ruta en donde enviamos la foto. Podría ser una absoluta o relativa
        const ruta = "<?=base_url()?>index.php/Chat/guardarCaptura";
        fetch(ruta, {
            method: "POST",
            body: JSON.stringify(payload),
            headers: {
                "Content-type": "application/x-www-form-urlencoded",
            }
        })
        .then(resultado => {
            // A los datos los decodificamos como texto plano
            return resultado.text()
        })
        .then(nombreDeLaFoto => {
            // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
           
            if({nombreDeLaFoto} != null || {nombreDeLaFoto} != undefined || {nombreDeLaFoto} != '' ){
                console.log({
                nombreDeLaFoto
            }); 

            $('#loaderDiv').addClass('hidden');
                alerts.showNotification("top", "right", "Captura realizada con éxito", "info");
                    document.getElementById('btnCapturar').disabled=true;
                    document.getElementById('btnprospecto').disabled=false;
                    $('#btnprospecto').removeClass("themeBtn2").addClass( "themeBtn" );
            }else{
                $('#loaderDiv').addClass('hidden');
                alerts.showNotification("top", "right", "Ocurrió un error, vuelva a tomar la captura por favor", "danger");
                console.log('ERROR');
            }
           
            let nombreFoto = nombreDeLaFoto.split('/');
            $('#nomCaptura').val(nombreFoto[4]);
        });
    };

    // Agregar el listener al botón
    $boton.addEventListener("click", () => {
        $('#loaderDiv').removeClass('hidden');
        let id = $('#idchatt').val();
        let formData = {
            "id":id
        }

        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Chat/VerificarProspecto',
            data: formData,
            //dataType: 'json',
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if(data == 1){
                    $('#loaderDiv').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se ha tomado una captura de esta conversación.", "warning");
                }else{
                    html2canvas($objetivo) // Llamar a html2canvas y pasarle el elemento
                        .then(enviarCapturaAServidor); // Cuando se resuelva, enviarla al servidor
                    alerts.showNotification("top", "right", "Captura realizada con éxito", "info");
                    document.getElementById('btnCapturar').disabled=true;
                    document.getElementById('btnprospecto').disabled=false;
                    $('#btnprospecto').removeClass("themeBtn2").addClass( "themeBtn" );
                }

            }
        })
    });

    /*-----------------------------FIN DE CAPTURA---------------------------------------*/
</script>
<script src="../dist/js/socket.io.js"></script>
<script>
    //consultas al servidor con ajax
    let urlimg = "<?=base_url()?>";
    let perfil;
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>index.php/Chat/getInfoPerfil',
        dataType: 'json',
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            perfil = data;
            $('#paraimg').val(urlimg+'static/images/perfil/'+perfil[0].id_usuario+'/'+perfil[0].foto);
        },
        async: false
    })
    var mySound = new Audio('../static/nuevo.mp3');
    // var firstSound = new Audio('../static/entrada.mp3');
    // firstSound.load();
    mySound.load();

    let im = '<?=base_url()?>static/images/perfil/'+perfil[0].id_usuario+'/'+perfil[0].foto;
    console.log(im);


    if ($(window).width() > 996){
        var socket = io('https://chatcomercial.gphsis.com/', {query:{
            "user":1,
            "maxChats": perfil[0].num_chat,
            "status": perfil[0].estatus,
            "sede" : perfil[0].id_sede,
            "customID": perfil[0].id_usuario,
            "nombre": perfil[0].nombre,
            "msgb":perfil[0].mensaje,
            "img":im,
            "emisor":1
        }
        });

        socket.customID = perfil[0].id_usuario;
        var form = document.getElementById('ResponderMsj');
        var input = document.getElementById('RespuestaMsj');
        let id;
        let feedback = $("#feedback");
        let mischats = document.getElementById('mischats');
        let color = perfil[0].estatus == 1 ? 'green' : (perfil[0].estatus == 2 ? 'orange':'red');
        mischats.innerHTML = `<i class="fa fa-circle box-s" aria-hidden="true" style="color:${color} !important; margin-right:10px"></i>MIS CHATS`;
        //eventos
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (input.value) {
                socket.emit('chat message', {msg:input.value, id:id});
                input.value = '';
            }
        });

        $(document).on('click','.users', function(){
            // firstSound.pause();
            // firstSound.currentTime = 0;
            mySound.pause();
            mySound.currentTime = 0;
            id = (this).id;
            $('#idchatt').val(id);
            $('#idchatt2').val(id);
            $(".box-container-b").removeClass('d-none');
            $('.nav-pills a[href="#formulario"]').tab('show');

            var form_title_id = document.getElementById('form_title_id');
            form_title_id.textContent = 'Lead: '+id;

            var header_chat = document.getElementById('box-header-chat');
            header_chat.innerHTML = "<p class='m-0'>Lead: " +id+ "</p>";
            var last_msg = (this).getAttribute('data-lastmsg');
            $("#"+id).removeClass("notificacion-red");
            $('.messages-list').hide();
            $('.users').removeClass('selectedDisconnected');
            $('.users').removeClass('selectedConversation');
            var messages = document.getElementById('mensajes_'+id);
            var conversation = document.getElementById(id);
            if(conversation.getAttribute('data-connected') == 'true'){
                conversation.classList.add("selectedConversation");
                conversation.classList.add("userConnected");
            }else{
                conversation.classList.add("selectedDisconnected");
                conversation.classList.add("usersDisconnected");
            }
            // conversation.textContent = 'Lead:'+id;
            conversation.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-2' style='padding: 0; display:flex; justify-content:center'><div><i class='fa fa-user-circle' aria-hidden='true' style='font-size: 20px;'></i><i class='fa fa-circle box-s' aria-hidden='true' style='position: absolute; transform: translate(-7px, 26px);'></i></div></div><div class='col-md-10' style='padding:0'><div class='container-fluid'><div class='row' style='display:flex; align-items-center'><div class='col-md-11' style='padding: 0; display:flex; justify-content: center'><div><p style='margin: 0; font-size: 12px;'><b>Lead: " +id+ "</b></p><p style='font-size: 12px; margin:0; margin-top:-30px'><i id='typing_gral_"+id+"'>Último mensaje " + last_msg + "</i></p></div></div><div class='col-md-1' style='padding: 0; display:flex; justify-content:center'><button class='btn-close btnfinalizar' data-currentChat = '" +id+ "'><i class='fa fa-times-circle' aria-hidden='true'></i></button></div></div></div></div></div></div></div>";
            conversation.setAttribute('data-unseen', 0);
            messages.style.display = "block";
        });

        $(document).on('click', '.btnfinalizar', function(){
            var $itself = $(this);
            var id_chat=$itself.attr('data-currentChat');
            console.log(id_chat);
            $('#closeConversation').modal();


            var btn_borrar =  document.getElementById('btn_confirma_borrado');
            btn_borrar.setAttribute('data-currentChat',id_chat);
            // socket.emit('disconnect_chat', {id:id_chat});
        });

        $(document).on('click', "#btn_confirma_borrado", function()
        {
            var $itself = $(this);
            var id_chat=$itself.attr('data-currentChat');
            console.log(id_chat);
            socket.emit('disconnect_chat', {id:id_chat});
        });

        //funciones del chat
        socket.on('chat message', function(data) {
            console.log("message");
            //La última hora de mensaje enviado
            var last_msg = (data.time).substr((data.time).indexOf(' ')+1);
            $('#container_'+data.id).html(' ');
            var div_general = document.createElement('div');
            var item = document.createElement('li');
            var time = document.createElement('li');

            item.textContent = urlify(data.msg);
            time.textContent = data.time;
            div_general.className = 'col-xs-12 padding0';
            if(data.emisor == 1)
            {
                item.className = 'asesor_message';
                item.className += ' sb15';
                time.className = 'li_time';
                time.className += ' right_position';
            }
            else {
                item.className = 'cliente_message';
                item.className += ' sb14';
                time.className = 'li_time';
            }
            var messages = document.getElementById('mensajes_'+data.id);
            var conversation = document.getElementById(data.id);

            if(id != data.id){
                // firstSound.pause();
                // firstSound.currentTime = 0;
                mySound.pause();
                mySound.currentTime = 0;
                if((messages.getElementsByTagName('li')).length == 0){
                    // firstSound.play();
                }else{
                    mySound.play();
                }
                let count = conversation.getAttribute('data-unseen');
                count++;
                conversation.textContent = 'Lead:'+data.id+' '+count;
                conversation.setAttribute('data-unseen', count);
                conversation.setAttribute('data-lastmsg', last_msg);
                conversation.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-2' style='padding: 0; display:flex; justify-content:center'><div><span class='new badgep' style='color: white;background: #416ed2'>"+ count +"</span><i class='fa fa-circle box-s' aria-hidden='true' style='color:green; position: absolute; transform: translate(-8px, 28px);'></i></div></div><div class='col-md-10' style='padding:0'><div class='container-fluid'><div class='row' style='display:flex; align-items-center'><div class='col-md-11' style='padding: 0; display:flex; justify-content: center'><div><p style='margin: 0; font-size: 12px;'><b>Lead: "+data.id+"</b></p><p style='font-size: 12px; margin:0; margin-top:-28px'><i id='typing_gral_"+data.id+"'>Último mensaje " + last_msg + "</i></p></div></div><div class='col-md-1' style='padding: 0; display:flex; justify-content:center'><button class='btn-close btnfinalizar' data-currentChat = '" + data.id + "'><i class='fa fa-times-circle' aria-hidden='true'></i></button></div></div></div></div></div></div>";
                conversation.classList.add("notificacion-red");
            }
            else{
                document.getElementById("typing_gral_"+data.id).innerHTML = "Último mensaje "+last_msg;
            }

            div_general.appendChild(item);
            div_general.appendChild(time);
            messages.appendChild(div_general);
            // window.scrollTo(0, document.body.scrollHeight);

            var objDiv = document.getElementById("scrolll");
            objDiv.scrollTop = objDiv.scrollHeight;


                        //notificacions
            if(data.emisor != 3 || data.emisor != 1)
            {
                var sessionNotificacion;
                if (localStorage.getItem("dataNotificaciones") === null) {
                    console.log('no, no existe');
                    localStorage.setItem("dataNotificaciones", "[]");
                    localStorage.setItem("contadorNotificaciones", 1);
                    sessionNotificacion = localStorage.getItem("dataNotificaciones");
                    sessionNotificacion =  JSON.parse(sessionNotificacion);
                    sessionNotificacion.push(JSON.stringify(data));
                    localStorage.setItem("dataNotificaciones", "[" + sessionNotificacion + "]");
                }
                else
                {
                    var arrayManejo=[];
                    var numeroNotificaciones;
                    // console.log('si, ya existia y se le agrega el nuevo valor xd');
                    arrayManejo = JSON.parse(localStorage.getItem('dataNotificaciones')) || [];
                    numeroNotificaciones = JSON.parse(localStorage.getItem('contadorNotificaciones'));
                    if(data.emisor==0)
                    {
                        numeroNotificaciones = (numeroNotificaciones+1);
                    }

                    arrayManejo.push(data);

                    localStorage.setItem("dataNotificaciones", JSON.stringify(arrayManejo));
                    localStorage.setItem("contadorNotificaciones", numeroNotificaciones);
                }
            }





            setTimeout(function () {
                var sessionNotify = localStorage.getItem("dataNotificaciones");
                var sessionContador = localStorage.getItem("contadorNotificaciones");
                sessionNotify = JSON.parse(sessionNotify);
                // console.log(sessionNotify);
                // console.log(sessionContador);

                sendNotify(sessionNotify, sessionContador);
            }, 500);
        });

        socket.on('getCookiesRooms', function(data){
            console.log("getCookiesRooms");
            console.log(data);
            var elements = data.cuartosAsesor;
            var current_asesor = <?=$this->session->userdata('id_usuario')?>;
            for(var x=0;x<elements.length;x++){
                if(elements[x].asesor == current_asesor)
                {
                    if((elements[x].messages).length > 0){
                        var last_msg = elements[x].messages[(elements[x].messages).length-1].time;
                        last_msg = (last_msg).substr((last_msg).indexOf(' ')+1);
                    }else{
                        var last_msg = 'null';
                    }
                    var li = document.createElement('li');
                    var div = document.createElement('ul');
                    var typing_container = document.createElement('div');
                    typing_container.setAttribute("id", "container_"+elements[x].id);
                    div.id = 'mensajes_'+elements[x].id;
                    li.id= elements[x].id;
                    li.setAttribute("data-connected", elements[x].conectado);
                    li.setAttribute("data-unseen", 0);
                    li.setAttribute('data-lastmsg', last_msg);
                    li.classList.add("users");
                    li.tabIndex= x+1;
                    div.classList.add("list-unstyled","messages-list");
                    div.style.display = "none";
                    typing_container.classList.add('feebinfo');

                    // Set text of element
                    li.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-2' style='padding: 0; display:flex; justify-content:center';><div><i class='fa fa-user-circle' aria-hidden='true' style='font-size: 20px;'></i><i class='fa fa-circle box-s' aria-hidden='true' style='position: absolute; transform: translate(-7px, 26px);'></i></div></div><div class='col-md-10' style='padding:0'><div class='container-fluid'><div class='row' style='display:flex; align-items-center'><div class='col-md-11 d-flex' style='padding: 0; display:flex; justify-content: center'><div><p style='margin: 0; font-size: 12px;'><b>" +elements[x].name+ "</b></p><p style='font-size: 12px; margin:0; margin-top:-30px'><i class='typing_gral"+elements[x].id+"'>Último mensaje " + last_msg +"</i></p></div></div><div class='col-md-1' style='padding: 0; display:flex; justify-content:center'><button class='btn-close btnfinalizar' data-currentChat = '" + elements[x].name + "'><i class='fa fa-times-circle' aria-hidden='true'></i></button></div></div></div></div></div></div>";
                    if(elements[x].conectado == false){
                        li.classList.add("usersDisconnected");
                    }else{
                        li.classList.add("userConnected");
                    }
                    // Append this element to its parent
                    if(document.getElementById('mensajes_'+elements[x].id) == null){
                        document.getElementById('chats').appendChild(li);
                        document.getElementById('scrolll').appendChild(div);

                        for(var y = 0;y<(elements[x].messages).length;y++){
                            var div_general = document.createElement('div');
                            var item = document.createElement('div');
                            var time = document.createElement('li');
                            item.textContent = elements[x].messages[y].msg;
                            time.textContent = elements[x].messages[y].time;
                            div_general.className = 'col-xs-12 padding0';
                            if(elements[x].messages[y].emisor == 1)
                            {
                                item.className = 'asesor_message';
                                item.className += ' sb15';
                                time.className = 'li_time';
                                time.className += ' right_position';
                            }
                            else {
                                item.className = 'cliente_message';
                                item.className += ' sb14';
                                time.className = 'li_time';
                            }
                            var messages = document.getElementById('mensajes_'+elements[x].id);
                            div_general.appendChild(item);
                            div_general.appendChild(time);
                            messages.appendChild(div_general);
                        }
                        messages.appendChild(typing_container);
                    }
                }

            }
        });

        socket.on('getRooms', function(data){
            console.log("getRooms");
            console.log(data.cuartosRedis);
            var elements= data.cuartosRedis;
            for(var x=0;x<elements.length;x++){
                if(document.getElementById(elements[x].id)){
                    var li =  document.getElementById(elements[x].id);
                    li.setAttribute('data-connected',elements[x].conectado);
                    if(elements[x].conectado == false){
                        $("#"+elements[x].id).removeClass("userConnected");
                        $("#"+elements[x].id).addClass("usersDisconnected");
                    }
                    else{
                        $("#"+elements[x].id).removeClass("usersDisconnected");
                        $("#"+elements[x].id).addClass("userConnected");
                    }
                }
            }

            if(elements[elements.length-1].asesor == socket.customID && (document.getElementById(elements[elements.length-1].id) == null)){
                console.log("entra aqui");
                var li = document.createElement('li');
                var div = document.createElement('ul');
                div.id = 'mensajes_'+elements[elements.length-1].id;
                li.id= elements[elements.length-1].id;
                li.setAttribute("data-connected", elements[elements.length-1].conectado);
                li.setAttribute("data-unseen", 0);
                li.classList.add("users");
                li.tabIndex= elements.length;
                div.classList.add("list-unstyled","messages-list");
                div.style.display = "none";
                // Set text of element
                li.textContent = elements[elements.length-1].name;
                // Append this element to its parent
                document.getElementById('chats').appendChild(li);
                document.getElementById('scrolll').appendChild(div);

                var typing_container = document.createElement('div');
                typing_container.setAttribute("id", "container_"+elements[elements.length-1].id);
                typing_container.classList.add('feebinfo');
                div.appendChild(typing_container);
            }
        });

        //Emit typing
        $('#RespuestaMsj').on("keypress", e => {
            let keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode != '13'){
                var id_chat=$('#idchatt').val();
                // socket.emit('typing', {id:id});
                // socket.emit('typing', {username: null, socketID:id});
                socket.emit('typing', {socketID:id_chat, emisor:1})
            
            }
        });

        socket.on('typing', (data) => {
            $('#container_'+data.socketID).html("<p style='margin:0px; color: #103f75; padding-left:5px; font-weight:500'><i>" + data.username + " está escribiendo..." + "</i></p>");
            setTimeout(function(){$('#container_'+data.socketID).html(' ');}, 2500);
        });

        socket.on('asesor_disconnected', (data) =>{
            console.log(data);
            var messages = document.getElementById('mensajes_'+data.data.id);
            var html_code = '';
            messages.innerHTML += html_code;

            var mensajes_conversacion = document.getElementById("mensajes_"+data.data.id);
            mensajes_conversacion.remove();
            var chat_especifico = document.getElementById(data.data.id);
            chat_especifico.remove();
            $('#closeConversation').modal('hide');
        });

        socket.on('asesor_disconnected_all', (elementcv2) =>{
            console.log(elementcv2);

            var messages = document.getElementById('mensajes_'+elementcv2.elementcv2.id);
            var html_code = '';
            messages.innerHTML += html_code;

            var mensajes_conversacion = document.getElementById("mensajes_"+elementcv2.elementcv2.id);
            mensajes_conversacion.remove();
            var chat_especifico = document.getElementById(elementcv2.elementcv2.id);
            chat_especifico.remove();
            closesessionChat();
            $('#closeConversation').modal('hide');
        });

        socket.on('onlyCloseSession', (array_close_session)=>{
            console.log(array_close_session);
            closesessionChat();
        });

        $(document).on('click', '.btn_session_chat', function () {
            var  $itself = $(this);
            var id_asesor=$itself.attr('data-asesor');
            $('#btn_confirma_borrado_all').attr('data-asesor', id_asesor);
            $('#btn_confirma_borrado_all').attr('data-socket', socket.id);
            $('#closeAllChats').modal();
            console.log('click en btn_session_chat');
        });

        $(document).on('click', '#btn_confirma_borrado_all', function () {
            /**/var $itself = $(this);
            var id_asesor=$itself.attr('data-asesor');
            var socketid=$itself.attr('data-socket');
            console.log(id_asesor);
            socket.emit('close_all_chats',{
                socketid,
                id_asesor
            });
            $('#closeAllChats').modal('hide');
        });


        socket.on('close_all_chats', (data) =>{
            console.log(data);
        });

        function closesessionChat(){
            let formData = {
                "estadoE":3,
                "idasesorE":<?php echo $this->session->userdata('id_usuario');?>
            }
            $.ajax({
                type: 'POST',
                url: '<?=base_url()?>index.php/Chat/CerrarSesionChat',
                data: formData,
                success: function(data) {
                    //$("#midiv").load("<?=base_url()?>Usuarios/UsersOnline/"+1);
                    setTimeout('document.location.reload()',10);
                    socket.emit('getAsesores', { Ase:id});
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        $('#RespuestaMsj').on("keydown", function(e) { 
            // if (e.shiftKey && e.which  == 13) {              
            // }
            /*if(e.keyCode == 13){
                if (input.value  && $('#RespuestaMsj').val().trim().length > 0 ) 
                  {
                     socket.emit('chat message', {msg:input.value, id:id});
                     input.value = '';
                  }
            }*/
            if (e.shiftKey && e.which  == 13) {
                e.preventDefault();
                return false;
            }else if(e.keyCode == 13){
                e.preventDefault();
                if ($('#RespuestaMsj').val() && $('#RespuestaMsj').val().trim().length > 0 )
                {
                    socket.emit('chat message', {msg:$('#RespuestaMsj').val(), id:id});
                    $('#RespuestaMsj').val('');
                    $('#RespuestaMsj').removeAttr('value');
                }
            }
        });
    }

    function urlify(text) {
        var urlRegex = /(((https?:\/\/)|(www\.))[^\s]+)/g;
        //var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function(url,b,c) {
            var url2 = (c == 'www.') ?  'http://' +url : url;
            return '<a class="link_chat" href="' +url2+ '" target="_blank">' + url + '</a>';
        })
    }


        /*notificaciones*/
    function sendNotify(data, numeroNot)
    {
            // console.log(data);
            $('#cpoNtallSys').empty();

            if(data.length >0)
            {
                if(data[data.length-1]['emisor'] == "0")
                {
                    $('#numberMsgAllSys').append('<span class="notification">'+numeroNot+'</span>');
                    window.document.title = "MaderasCRM | Ciudad Maderas Nuevo mensaje("+numeroNot+")";
                    var  w=0;
                    for(var t=(data.length-1); t>=0; t--)
                    {
                        if(data[t]['emisor'] == "0")
                        {
                            if(w <= 10 )
                            {
                                $('#cpoNtallSys').append('<li style="border-bottom: 1px solid #ddd;"><a href="<?=base_url()?>Chat/Chat#'+data[t]['id']+'" style="white-space: pre-wrap;"><span style="font-size:0.8em">lead: '+data[t]['id']+' dice</span>: <i>'+data[t]['msg']+'</i><br><small>'+data[t]['time']+'</small></a></li>');
                            }
                            w++;
                        }
                    }
                    $('#cpoNtallSys').append('<div style="background:black;color:white;text-align:center;position:sticky;height:40px;width:100%;bottom:2%; padding: 10px 0px;"><a style="color:white" href="<?=base_url()?>Chat/Chat">IR A MENSAJES</i></a></div>');
                }
                else if(data[data.length-1]['emisor'] == 1)
                {
                    // alerts.showNotification("top", "right", "¡Nuevo cliente en chat!", "success");
                    // mySound.play();
                    $('#cpoNtallSys').append('<li style="background:black;color:white;text-align:center"><a style="color:white" href="<?=base_url()?>Chat/Chat">NUEVO CHAT '+data[(data.length-1)]["id"]+'</i></a></li>');
                    console.log(data);
                    var  w=0;
                    for(var t=(data.length-1); t>=0; t--)
                    {
                        if(data[t]['emisor'] == "0")
                        {
                            if(w <= 10 )
                            {
                                $('#cpoNtallSys').append('<li style="border-bottom: 1px solid #ddd;"><a href="<?=base_url()?>Chat/Chat#'+data[t]['id']+'" style="white-space: pre-wrap;"><span style="font-size:0.8em">lead: '+data[t]['id']+' dice</span>: <i>'+data[t]['msg']+'</i><br><small>'+data[t]['time']+'</small></a></li>');
                            }
                            w++;
                        }
                    }
                    $('#cpoNtallSys').append('<div style="background:black;color:white;text-align:center;position:sticky;height:40px;width:100%;bottom:2%; padding: 10px 0px;"><a style="color:white" href="<?=base_url()?>Chat/Chat">IR A MENSAJES</i></a></div>');
                }
            }
    }
    $(document).ready(function () {
        //cleanRepMsg();

        let currentNot = (localStorage.getItem("contadorNotificaciones") === null) ? 0 : localStorage.getItem("contadorNotificaciones");<?php #echo #$this->session->userdata('mensajes_count');?>;
        var totalData = JSON.parse((localStorage.getItem("dataNotificaciones") === null) ? 0 : localStorage.getItem("dataNotificaciones")); <?php #print_r(json_encode($this->session->userdata('msg_data')))?>;

         console.log(totalData);

        if(totalData.length >0)
        {
            // console.log('llegue hasta qui alv');
            // console.log(totalData[0]);
            // if(totalData[totalData.length-1]['emisor'] == "0")
            // {
            if(currentNot > 0)
            {
                $('#numberMsgAllSys').append('<span class="notification">'+currentNot+'</span>');
                window.document.title += " ("+currentNot+" mensaje(s) sin leer)";
            }

            var  w=1;
            for(var t=(totalData.length-1); t>=0; t--)
            {

                if(totalData[t]['emisor'] == "0")
                {
                    if(w <= 10 )
                    {
                        $('#cpoNtallSys').append('<li style="border-bottom: 1px solid #ddd;"><a href="<?=base_url()?>Chat/Chat#'+totalData[t]['id']+'" style="white-space: pre-wrap;"><span style="font-size:0.8em">lead: '+totalData[t]['id']+' dice</span>: <i>'+totalData[t]['msg']+'</i><br><small>'+totalData[t]['time']+'</small></a></li>');
                    }
                    w++;
                }

            }
            $('#cpoNtallSys').append('<div style="background:black;color:white;text-align:center;position:sticky;height:40px;width:100%;bottom:2%; padding: 10px 0px;"><a style="color:white" href="<?=base_url()?>Chat/Chat">IR A MENSAJES</i></a></div>');
            // }
        }
        else
        {
            $('#cpoNtallSys').append('<div style="background:black;color:white;text-align:center;position:sticky;height:40px;width:100%;bottom:2%; padding: 10px 0px;"><a style="color:white" href="<?=base_url()?>Chat/Chat">IR A MENSAJES</i></a></div>');
        }
    });

    $(document).on('click', '#numberMsgAllSys', function () {
        /*
          let currentNot2 = <?php echo $this->session->userdata('mensajes_count');?>;
        var totalData2 = <?php print_r(json_encode($this->session->userdata('msg_data')))?>;
        */
        /*******************************/
        $('#numberMsgAllSys').html('<i class="material-icons">chat</i>');
        // $('#cpoNtallSys').html('');
        window.document.title = 'MaderasCRM | Ciudad Maderas';

        cleanVarNt();
    });

    function cleanVarNt()
    {
        localStorage.removeItem('contadorNotificaciones');
    }
    $(document).on('click', '#cerrar_sesionsb21', function () {
        localStorage.clear();
    });
</script>
</body>
</html>