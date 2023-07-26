<!DOCTYPE html>
<html lang="es" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ciudad Maderas | Sistema de Contratación</title>
    <!-- Tell the browser to be responsive to screen width -->

    <link rel="shortcut icon" href="<?= base_url() ?>static/images/arbol_cm.png"/>


    <?php
    if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '7' && $this->session->userdata('id_rol') != '3' && $this->session->userdata('id_rol') != '9' && $this->session->userdata('id_rol') != '16' && $this->session->userdata('id_rol') != '6' && $this->session->userdata('id_rol') != '2' && $this->session->userdata('id_rol') != '5' && $this->session->userdata('id_rol') != '33' && $this->session->userdata('id_rol') != '17' && $this->session->userdata('id_rol') != '19' && $this->session->userdata('id_rol') != '20'  && $this->session->userdata('id_rol') != '13' && $this->session->userdata('id_rol') != '32') {
        redirect(base_url() . 'login');
    }
    ?>


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url() ?>dist/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url() ?>dist/bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
          href="<?= base_url() ?>dist/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>dist/css/AdminLTE.min.css">


    <link rel="stylesheet" href="<?= base_url() ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="<?= base_url() ?>dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">


    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/dataTables.buttons.min.js") ?>"></script>
    <script type="text/javascript"
            src="<?= base_url("static/angular/datatable/angular-datatables.buttons.js") ?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/angular-datatables.min.js") ?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.html5.min.js") ?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.colVis.min.js") ?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.flash.min.js") ?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.print.min.js") ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?= base_url("static/angular/datatable/buttons.dataTables.min.css") ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
    <script type="text/javascript" src="<?= base_url("static/js/angularjs-dropdown-multiselect.js") ?>"></script>


    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/angular.checklist-model/0.1.3/checklist-model.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>


    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;800&display=swap" rel="stylesheet">
    <style type="text/css">
        .contenedorinputs {
            position: relative;
        }

        ul li {
            list-style: none;
            display: block;
            padding-bottom: 2em;
        }

        .inputradio {
            opacity: 0; /* Ocultamos el input verdadero con opacity: 0 */
            width: 20px;
            height: 20px;
            position: absolute;
            left: 0px;
        }

        .inputfalso {
            border: 5px solid #dedede;
            border-radius: 10%;
            display: inline-block;
            height: 20px;
            position: absolute;
            left: 0px;
            width: 21px;
            z-index: -1;
        }

        input[type="checkbox"]:checked + span:after {
            content: "✔";
            position: absolute;
            text-indent: 2px;
            top: -5px;
            left: -2px;
            color: black;
        }


        legend {
            background-color: #103f75;
            color: #fff;
            padding: 3px 6px;
        }

        .output {
            font: 1rem 'Fira Sans', sans-serif;
        }

        .foreach {
            background: #337ab7bd;
            height: 22em;
            width: auto;
            border-radius: 10px;
            padding: 10px;
            font-size: 15px;
            color: #fff;
            margin-bottom: 30px;
            overflow-y: auto;
        }

    </style>
    <style type="text/css">


        .panel-pricing {
            -moz-transition: all .3s ease;
            -o-transition: all .3s ease;
            -webkit-transition: all .3s ease;
        }

        .panel-pricing:hover {
            box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
        }

        .panel-pricing .panel-heading {
            padding: 20px 10px;
        }

        .panel-pricing .panel-heading .fa {
            margin-top: 10px;
            font-size: 58px;
        }

        .panel-pricing .list-group-item {
            color: #777777;
            border-bottom: 1px solid rgba(250, 250, 250, 0.5);
        }

        .panel-pricing .list-group-item:last-child {
            border-bottom-right-radius: 0px;
            border-bottom-left-radius: 0px;
        }

        .panel-pricing .list-group-item:first-child {
            border-top-right-radius: 0px;
            border-top-left-radius: 0px;
        }

        .panel-pricing .panel-body {
            background-color: #f0f0f0;
            font-size: 40px;
            color: #777777;
            padding: 20px;
            margin: 0px;
        }


        /*nuevos estilos*/
        .loader,
        .loader:before,
        .loader:after {
            background: #ffffff;
            -webkit-animation: load1 1s infinite eas    e-in-out;
            animation: load1 1s infinite ease-in-out;
            width: 1em;
            height: 4em;
        }

        .loader {
            color: #ffffff;
            text-indent: -9999em;
            margin: 88px auto;
            position: relative;
            font-size: 11px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        .loader:before,
        .loader:after {
            position: absolute;
            top: 0;
            content: '';
        }

        .loader:before {
            left: -1.5em;
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .loader:after {
            left: 1.5em;
        }

        @-webkit-keyframes load1 {
            0%,
            80%,
            100% {
                box-shadow: 0 0;
                height: 4em;
            }
            40% {
                box-shadow: 0 -2em;
                height: 5em;
            }
        }

        @keyframes load1 {
            0%,
            80%,
            100% {
                box-shadow: 0 0;
                height: 4em;
            }
            40% {
                box-shadow: 0 -2em;
                height: 5em;
            }
        }

        .bkLoading {
            backdrop-filter: blur(8px) !important;
            background-color: RGB(0 0 0/42%);
            /* background-image: linear-gradient(to bottom, #000, #000); */
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            z-index: 3;
            padding-top: 200px;
            color: white;
            font-weight: 300;
            /* opacity: 0.7; */
            /* display: none;


                    /* display:none; */
        }

        .center-align {
            text-align: center;
            font-size: 2em;
            font-weight: lighter;
        }

        .hide {
            display: none;
        }
        label{
            font-family: 'Open Sans', sans-serif;
            font-weight: 500;
        }
        span{
            font-family: 'Open Sans', sans-serif;
            font-weight: 500;
        }
        input select{
            font-family: 'Open Sans', sans-serif;
        }
        .form-control {
            font-family: 'Open Sans', sans-serif;
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
            box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
        /*Terminan los nuevos estilos*/


        .skeleton_descuento{
            height: 350px;
            padding: 10px;
            border:1px solid #dedfe1;
            margin-bottom: 20px;
        }
        .desc_container_title{
            height: 39px;
            width: 85%;
            margin-bottom: 10px;
        }
        .subtitle_skeleton{
            height: 23px;
            width: 65%;
            margin-bottom: 20px;
        }

        .disccount{
            height: 60px;
            width: 100%;
            margin-bottom: 10px;
        }


        .head-section:empty, .profile-img-section:empty, .text1:empty, .text2:empty, .text3:empty, .text4:empty, .desc_container_title:empty,
        .subtitle_skeleton:empty, .disccount:empty{
            animation: loading 1.1s infinite linear;
            background: #dedfe1;
            background-image: -webkit-linear-gradient(to right, #dedfe1 0%, #f2f3f5 20%, #dedfe1 40%, #dedfe1 100%);
            background-image: linear-gradient(to right, #dedfe1 0%, #f2f3f5 20%, #dedfe1 40%, #dedfe1 100%);
            background-repeat: no-repeat;
        }
        @keyframes loading {

            0% {

                background-position: -100px;

            }

            100% {

                background-position: 200px;

            }

        }

        .btn-circle {
            width: 50px;
            height: 50px;
            padding: 6px 0px;
            border-radius: 30px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
            background-color: rgb(52,199,89);
            color: #fff;
            border: 0px;
            transition-duration: 0.3s;
            margin:4px;
        }
        .btn-circle:hover{
            background-color: rgb(54,166,77);
            color: #fff;
            transition-duration: 0.3s;
        }
        .btn-float{
            float: right;
            bottom: 2%;
            right: 3%;
            position: fixed;
        }
        .blue{
            background-color:#337ab7;
        }
        .blue:hover{
            background-color: #003e97;
        }
        .dark-blue{
            background-color:#c98700;
        }
        .dark-blue:hover{
            background-color: #845300;
        }
        .pill-msi{
            border-radius: 24px;
            background-color: rgb(48, 209, 88);
            color: white;
            padding: 2px 13px;
        }
        .infoBank{
            font-size: 1.3em;
            color: #103f75;
            font-weight: 600;
        }
        .table-data-bank tr td{
            text-align: center;
            word-wrap:break-word;
            padding:10px;

        }
    </style>
</head>
<body class="hold-transition register-page" ng-controller="myController">


<div class="bkLoading hide" id="loaderDiv">
    <div class="center-align" style="font-family: 'Open Sans', sans-serif;padding-top:11%">
        <img src="<?= base_url() ?>static/images/logo.svg" style="width:35%;"><br>
        Este proceso puede demorar algunos segundos, espere por favor ...
    </div>
    <div class="inner">
        <div class="load-container load1">
            <div class="loader">
            </div>
        </div>
    </div>
</div>


<div class="wrapper">

    <?php
        if($data_corrida->idResidencial == 17 || $data_corrida->idResidencial == 28){
            $casasLote = 1;
        }else{
            $casasLote = 0;
        }
    ?>
    <section class="content">
        <div class="row">
            <div class="col-xs-10 col-md-offset-1">
                <div class="box">
                    <div class="box-body">
                        <div id="exportthis">
                            <button onclick="javascript:window.history.back();  " class="btn"><i
                                        class="fa fa-chevron-left"></i> Regresar
                            </button>
                            <!--
                            <button ng-click="exportc()" class="btn btn-primary">Imprimir carátula</button>
                            <button ng-click="exportcf()" class="btn btn-success">Imprimir carátula + Corrida
                                Financiera
                            </button>-->
                            <?php #print_r($data_corrida);  ?>

                            <table align="center" width="100%" cellpadding="8" cellspacing="8">
                                <tr>
                                    <td align="right">&nbsp&nbsp</td>
                                    <td rowspan=4 align="left"><img src="https://maderascrm.gphsis.com/static/images/logo_ciudadmaderasAct.jpg" style=" max-width: 55%; height: auto;padding:20px"></td>
                                    <td rowspan=4 align="right"><p style="font-size: 1.5em;font-family: 'Open Sans', sans-serif;letter-spacing: 5px"> CORRIDA FINANCIERA<BR></p><small style="font-size: 1.5em; font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif; color: #777;"></small>
                                    <td align="right">&nbsp&nbsp</td>
                                </tr>
                            </table>
                            <!--<form method="post" action="<?= base_url() ?>index.php/registroLote/genera_corrida/" enctype="multipart/form-data" id="corrida" name="corrida">  -->
                            <!-- ///////////////////////////////////////////// -->
                            <fieldset>
                                <legend>


                                    <section class="content-header"
                                             style="font-family: 'Open Sans', sans-serif;font-weight: lighter;letter-spacing: 5px;">
                                        INFORMACIÓN:
                                    </section>
                                </legend>
                                <div id="areaImprimir">

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>Nombre: </label>
                                            <input type="text" ng-model="nombre" id="nombre" required="text"
                                                   class="form-control" disabled>
                                            <p id="nombretext" style="color:red;"></p>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Edad: </label>
                                            <select ng-model="age" id="edad"
                                                    class="form-control" ng-change="getAge(age)">
                                                <option value=""> - Selecciona la edad -</option>
                                                <option ng-repeat="age in ages"  ng-value="age.age">{{age.age}}
                                            </select>
                                            <p id="edadtext" style="color:red;"></p>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Teléfono:</label>
                                            <!-- <input type="text" ng-model="telefono" class="form-control"> -->
                                            <input type="tel" ng-model="telefono" class="form-control"
                                                   placeholder="442-256-5963" maxlength="12" disabled>
                                            <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"-->
                                            <small>Formato: 442-485-6978</small><br><br>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label>Email:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">@</span>
                                                <input type="text" ng-model="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>Proyecto:</label>
                                        <!--ng-options="item.descripcion for item in residencial"-->
                                        <select ng-model="proyecto"
                                                ng-change="onSelectChangep(proyecto)" class="form-control" disabled>
                                            <option value=""> - Selecciona un Proyecto -</option>
                                            <option ng-repeat="residencial in residencial"  ng-value="residencial.idResidencial"
                                                    ng-selected="(residencial.idResidencial== <?php echo $data_corrida->idResidencial;?>) ? selected : ''">{{residencial.nombreResidencial}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Condominio:</label>
                                        <!--ng-options="item.nombre for item in condominios"-->
                                        <select ng-model="condominio"
                                                ng-change="onSelectChangec(condominio)" class="form-control"
                                                style="text-transform: uppercase;" disabled>
                                            <option value=""> - Selecciona un Condominio -</option>
                                            <option ng-repeat="condominios in condominios "  ng-value="condominios.idCondominio"
                                                    ng-selected="(condominios.idCondominio== <?php echo $data_corrida->idCondominio;?>) ? selected : ''">{{condominios.nombre}}</option>
                                        </select>
                                    </div>
                                    <div class="<?php if($casasLote == 1 ) { echo 'col-md-2'; } else{echo 'col-md-3';} ?> form-group">
                                        <label>Lote:</label>
                                        <!-- ng-options="item.nombreLote for item in lotes" -->
                                        <select ng-model="lote" id="lote"
                                                ng-change="onSelectChangel(lote)" class="form-control" disabled>
                                            <option value = ""> - Selecciona un Lote - </option>
                                            <option ng-repeat="lotes in lotes "  ng-value="lotes.idLote"
                                                    ng-selected="(lotes.idLote== <?php echo $data_corrida->id_lote;?>) ? selected : ''">{{lotes.nombreLote}}</option>
                                        </select>
                                        <p id="lotetext" style="color: red;"></p>
                                    </div>
                                    <div class="col-md-2 form-group <?php if($casasLote == 1 ) { echo ''; } else{echo 'hide';} ?> " id="tcasa">
                                        <label>Tipo casa:</label>
                                        <select ng-model="tipo_casa" id="tipo_casa"  class="form-control" disabled>
                                            <option  ng-repeat="tipo_casas in tipo_casas"  ng-value="tipo_casas.id"
                                                     ng-selected="(tipo_casas.id == <?php echo $data_corrida->tipo_casa;?>) ? selected : ''">{{tipo_casas.nombre}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Plan:</label>
                                        <select ng-model="plan" class="form-control" id="planSL" ng-change="payPlan()" disabled>
                                            <option value=""> - Selecciona un plan -</option>
                                            <option value="Crédito" ng-selected="<?php echo ($data_corrida->plan_corrida =='Crédito') ? 'selected' : '' ?>" > Crédito</option>
                                            <option value="Contado" ng-selected="<?php echo ($data_corrida->plan_corrida =='Contado') ? 'selected' : '' ?>" > Contado</option>
                                        </select>
                                        <p id="plantext" style="color: red;"></p>
                                    </div>
                                    <div class="<?php if($casasLote == 1 ) { echo 'col-md-1'; } else{echo 'col-md-2';} ?> form-group">
                                        <label>Años:</label>
                                        <!-- ng-options="item.yearplan for item in yearsplan" -->
                                        <select ng-model="yearplan" id="yearplan" class="form-control" ng-change="getAgePlan()">
                                            <option value=""> - Selecciona los años -</option>
                                            <option ng-repeat="yearsplan in yearsplan "  ng-value="yearsplan.yearplan"
                                                    ng-selected="(yearsplan.yearplan== <?php echo $data_corrida->anio;?>) ? selected : ''">{{yearsplan.yearplan}}</option>
                                        </select>
                                        <p id="aniotext" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label>Gerente:</label>
                                        <select ng-model="gerente" id="gerente"

                                                ng-change="onSelectChangegerente(gerente)" class="form-control" disabled>
                                            <option value=""> - Selecciona un Gerente -</option>
                                            <option ng-repeat="gerentes in gerentes"  ng-value="gerentes.idGerente"
                                                    ng-selected="(gerentes.idGerente == <?php echo $data_corrida->id_gerente; ?>) ? selected : ''">{{gerentes.nombreGerente}}</option>
                                        </select>
                                        <p id="gerentetext" style="color: red;"></p>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Coordinador:</label>
                                        <!--ng-options="item.nombreCoordinador for item in coordinadores"-->
                                        <select ng-model="coordinador"
                                                ng-change="onSelectChangecoord(coordinador)" class="form-control"
                                                style="text-transform: uppercase;" disabled>
                                            <option value=""> - Selecciona un Coordinador -</option>
                                            <option ng-repeat="coordinadores in coordinadores"  ng-value="coordinadores.idCoordinador"
                                                    ng-selected="(coordinadores.idCoordinador== <?php echo $data_corrida->id_coordinador;?>) ? selected : ''">{{coordinadores.nombreCoordinador}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Asesor:</label>
                                        <!--ng-options="item.nombreAsesor for item in asesores"-->
                                        <select ng-model="asesor" id="asesor"
                                                class="form-control" disabled>
                                            <option value="" > - Selecciona un Asesor -</option>
                                            <option ng-repeat="asesores in asesores"  ng-value="asesores.idAsesor"
                                                    ng-selected="(asesores.idAsesor== <?php echo $data_corrida->id_asesor;?>) ? selected : ''">{{asesores.nombreAsesor}}</option>
                                        </select>
                                        <p id="asesortext" style="color: red;"></p>
                                    </div>

                                    <!-- <div class="col-md-4 form-group" >
                <label>Gerente: </label>
                <select ng-model="gerente" ng-options="item.nombreGerente for item in gerentes" ng-change="onSelectChangecoord(coordinador)" class="form-control">
                  <option value = ""> - Selecciona un Gerente - </option>
                </select>
              </div >
              <div class="col-md-4 form-group" >
                <label>Coordinador: </label>
                <select ng-model="coordinador" ng-options= "item.nombreCoordinador for item in coordinadores" ng-change="onSelectChangeasesor(asesor)" class="form-control">
                  <option value = ""> - Selecciona un Coordinador - </option>
                </select>
              </div >

              <div class="col-md-4 form-group" >
                <label>Asesor: </label>
                <select ng-model="asesor" ng-options= "item.nombreAsesor for item in asesores" class="form-control">
                  <option value = ""> - Selecciona un Asesor - </option>
                </select>
              </div > -->
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label>Superficie:</label>
                                        <div class="input-group">
                                            <input type="text" ng-model="superficie" class="form-control"
                                                   ng-readonly="true">
                                            <span class="input-group-addon" id="basic-addon1">m2</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Precio m2:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">$</span>
                                            <!-- <input type="text" ng-model="preciom2" class="form-control" value="{{preciom2 | currency}}" ng-readonly="true"> -->
                                            <input type="hidden" ng-model="preciom2" class="form-control"
                                                   value="{{preciom2 | currency}}" ng-readonly="true">
                                            <input class="form-control" ng-readonly="true"
                                                   value="{{preciom2 | currency:''}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Total:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">$</span>
                                            <input type="hidden" ng-model="total" class="form-control"
                                                   value="{{total | currency}}" ng-readonly="true">
                                            <input class="form-control" ng-readonly="true"
                                                   value="{{total | currency:''}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group hide">
                                        <label>Porcentaje:</label>
                                        <div class="input-group">
                                            <input type="text" ng-model="porcentajeInv" class="form-control"
                                                   value="{{porcentaje | currency}}" ng-readonly="true">
                                            <span class="input-group-addon" id="basic-addon1">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Fecha:</label>
                                        <input type="date" ng-model="CurrentDate" class="form-control"
                                               value="{{CurrentDate | date:'dd-MM-yyyy'}}" ng-readonly="true">
                                    </div>
                                    <div class="col-md-2 form-group" >
                                        <div id="labelFA">
                                            <label>Fecha Apartado:</label>
                                            <input type="date" ng-model="fechaApartado" class="form-control" value="{{fechaApartado | date:'yyyy-MM-dd'}}" ng-readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Enganche:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">$</span>
                                            <input type="hidden" ng-model="enganche" class="form-control"
                                                   value="{{enganche | currency}}" ng-readonly="true">
                                            <input class="form-control" ng-readonly="true"
                                                   value="{{enganche | currency:''}}"/>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="col-md-12 form-group">
                                            <label>Enganche (%): </label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">%</span>
                                                <input type="number" ng-model="porcentaje" max="100" id="porcentajeEnganche"
                                                       min="1" class="form-control" ng-change="selectPorcentajeEnganche()"
                                                       string-to-number limit-to-max>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Enganche cantidad ($): </label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">$</span>
                                                <input ng-model="cantidad" id="cantidadEnganche" type="number"
                                                       class="form-control" min="1" ng-change="resultCantidad()"
                                                       string-to-number>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Días para pagar Enganche: </label>
                                        <!-- ng-options="item.day for item in diasEnganche" -->
                                        <select ng-model="day" id="day"
                                                class="form-control" ng-change="daysEng(); ChengecheckEngDif">
                                            <option value=""> - Selecciona los días de enganche -</option>
                                            <option ng-repeat="diasEnganche in diasEnganche "  ng-value="diasEnganche.day"
                                                    ng-selected="(diasEnganche.day == '<?php echo $data_corrida->dias_pagar_enganche;?>') ? selected : ''">{{diasEnganche.day}}</option>
                                        </select>
                                    </div>





                                    <!--<div ng-if="checkEngDif">-->
                                    <div class="col-md-2 form-group">
                                        <label>Apartado ($):</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">$</span>
                                            <input input-currency ng-model="apartado" class="form-control" id="aptdo">
                                        </div>
                                    </div>


                                    <div class="col-md-3 form-group">
                                        <label>Meses a diferir:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">#</span>
                                            <!--ng-options="item for item in diasDiferidos"-->
                                            <select ng-model="mesesdiferir"
                                                    class="form-control" ng-change="changeDaysEng()" id="msdif">
                                                <option value=""> - Selecciona los años -</option>
                                                <option ng-repeat="diasDiferidos in diasDiferidos "  ng-value="diasDiferidos"
                                                        ng-selected="(diasDiferidos == '<?php echo $data_corrida->meses_diferir;?>') ? selected : ''">{{diasDiferidos}}</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <!--</div>-->

                                </div>

                            </fieldset>
                            <fieldset>
                                <legend>
                                    <section class="content-header"
                                             style="font-family: 'Open Sans', sans-serif;font-weight: lighter;letter-spacing: 5px;">
                                        DESCUENTOS DISPONIBLES:
                                    </section>
                                </legend>


                                <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                                        <label>Descuentos meses anteriores:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-tag"></i></span>
                                            <select ng-model="mesesAnteriores"
                                                    ng-options="item.nombre for item in planesAnteriores"
                                                    class="form-control" id="mesesAnteriores" ng-change="changeDescuento()">
                                                <option value=""> - Selecciona descuento -</option>
                                                <!--
                                                <option value="1262"> OCTUBRE 2021</option>
                                                <option value="1263"> NOVIEMBRE 2021</option>
                                                <option value="1264"> DICIEMBRE 2021</option>
                                                <option value="1265"> ENERO 2022</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="skeleton">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="skeleton_descuento">
                                                <div class="desc_container_title"></div>
                                                <div class="subtitle_skeleton"></div>
                                                <br>
                                                <div class="disccount"></div>
                                                <div class="disccount"></div>
                                                <div class="disccount"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="skeleton_descuento">
                                                <div class="desc_container_title"></div>
                                                <div class="subtitle_skeleton"></div>
                                                <br>
                                                <div class="disccount"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="skeleton_descuento">
                                                <div class="desc_container_title"></div>
                                                <div class="subtitle_skeleton"></div>
                                                <br>
                                                <div class="disccount"></div>
                                                <div class="disccount"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4" id="repeater_descs" ng-if="(paquetes.length>0)" ng-model="id" ng-repeat="paquete in paquetes">
                                        <div class="foreach">
                                            <input type="radio" id="checkPack" name="checkPack" required="required"
                                                   ng-model="paquete.id_paquete" />
                                            <span>Plan {{paquete.descripcion}} </span>
                                            <div ng-repeat="descuento in paquete.response | orderBy:'-apply'">

                                                <div ng-if="descuento.apply == 1">
                                                    <li class="list-group-item">
                                                        <input type="checkbox" checklist-model="selected.descuentos"
                                                               checklist-value="descuento"
                                                               ng-change="selectDescuentos(descuento, checked)"
                                                               ng-disabled="paquete.id_paquete"
                                                               id="paquete.id_paquete" ng-checked="descuento.estatus == 1 ? true : false"/>
                                                        <!-- ng-checked="checkedStatus"-->

                                                        <span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2"
                                                              style="color:#000;">{{descuento.porcentaje}}% </span>
                                                        <span ng-if="descuento.id_condicion == 3 || descuento.id_condicion == 4"
                                                              style="color:#000;">{{descuento.porcentaje | currency }} </span>
                                                        <span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2 || descuento.id_condicion == 3" class="animate-if" style="color:#000;">Descuento al total.</span>
                                                        <span ng-if="descuento.id_condicion == 4" class="animate-if"
                                                              style="color:#000;">Descuento al total por m2.</span>

                                                        <span ng-if="descuento.id_condicion == 7" class="animate-if"
                                                              style="color:#000;">Enganche diferido sin descontar MSI</span>
                                                        <span ng-if="descuento.msi_descuento > 0 && descuento.id_condicion != 13" class="animate-if pill-msi"
                                                              style="color:#000;">{{descuento.msi_descuento}} MSI adicional</span>
                                                        <span ng-if="descuento.id_condicion == 12" style="color:#000;">  Bono de {{descuento.porcentaje | currency}} al m<sup>2</sup></span>
                                                        <span ng-if="descuento.msi_descuento > 0 && descuento.id_condicion == 13" class="animate-if" style="color:#000;">{{descuento.msi_descuento}} MSI adicionales</span>
                                                    </li>
                                                </div>

                                                <div ng-if="day == 15"  >
                                                    <div ng-if="descuento.apply == 0">
                                                        <li class="list-group-item">
                                                            <input type="checkbox" checklist-model="selected.descuentos"
                                                                   checklist-value="descuento"
                                                                   ng-change="selectDescuentos(descuento, checked)"
                                                                   ng-disabled="paquete.id_paquete"
                                                                   ng-checked="descuento.estatus == 1 ? true : false"/>
                                                            <span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2"
                                                                  style="color:#000;">{{descuento.porcentaje}}% </span>
                                                            <span ng-if="descuento.id_condicion == 3 || descuento.id_condicion == 4"
                                                                  style="color:#000;">{{descuento.porcentaje | currency }} </span>
                                                            <span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2 || descuento.id_condicion == 3"
                                                                  class="animate-if" style="color:#000;" >Descuento al Enganche.</span>
                                                            <span ng-if="descuento.id_condicion == 4" class="animate-if"
                                                                  style="color:#000;">Descuento al total por m2.</span>

                                                            <span ng-if="descuento.id_condicion == 7" class="animate-if"
                                                                  style="color:#000;">Enganche diferido sin descontar MSI</span>
                                                            <span ng-if="descuento.id_condicion == 12" style="color:#000;">  Bono de {{descuento.porcentaje | currency}} al m<sup>2</sup></span>
                                                            <span ng-if="descuento.msi_descuento > 0 && descuento.id_condicion == 13" class="animate-if" style="color:#000;">{{descuento.msi_descuento}} MSI adicionales</span>



                                                        </li>
                                                    </div>
                                                </div>


                                                <div ng-if="descuento.apply == null">
                                                    <li class="list-group-item">
                                                        <input type="checkbox" checklist-model="selected.descuentos"
                                                               checklist-value="descuento"
                                                               ng-change="selectDescuentos(descuento, checked)"
                                                               ng-disabled="paquete.id_paquete"
                                                               id="paquete.id_paquete" ng-checked="checkedStatus"/>
                                                        <span ng-if="descuento.id_condicion == 6" class="animate-if"
                                                              style="color:#000;">Primera Mensualidad Enero.</span>
                                                        <span ng-if="descuento.id_condicion == 8" class="animate-if"
                                                              style="color:#000;">Primera Mensualidad Octubre.</span>
                                                    </li>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-if="(paquetes.length<=0)">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center-align border-primary"
                                             style="padding:15px 0px; border:1px solid #a3a3a3;margin-bottom:40px;margin-top:30px">
                                            <h4>Actualemente no tiene descuentos agregados, selecciona un paquete para agregar descuentos</h4>
                                        </div>
                                    </div>

                                </div>


                            </fieldset>

                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <tr>
                                    <td class="text-center">
                                        <label type="text">Lote</label><br>
                                        <label type="text"><b>{{nombreLote}}</b></label><br>
                                    </td>
                                    <td class="text-center">
                                        <label type="text">Plan(años)</label><br>
                                        <label type="text"><b>{{age_plan}}</b></label><br>
                                    </td>
                                    </td>
                                    <td class="text-center">
                                        <label type="text">Precio Lista</label><br>
                                        <label type="text"><b>{{precioTotal | currency }}</b></label><br>
                                    </td>
                                    <td class="text-center">
                                        <label type="text">Superficie</label><br>
                                        <label type="text"><b>{{superficie}}</b></label><br>
                                    </td>
                                    <td class="text-center" colspan="2">
                                        <label type="text">Precio m<sup>2 </sup></label><br>
                                        <label type="text"><b>{{preciom2F | currency }}</b></label><br>
                                    </td>
                                </tr>


                                <!---->
                                <tr align="center">
                                    <td colspan="6"><label type="text">Descuentos</label></td>
                                </tr>

                                <tr align="center">
                                    <td><label type="text">Porcentaje y/o monto</label></td>
                                    <td><label type="text">Precio final m2</label></td>
                                    <td><label type="text">Precio total final</label></td>
                                    <td><label type="text">Ahorros</label></td>
                                </tr>

                                <tr ng-repeat="i in decFin">
                                    <td style="color:#27AE60" class="text-center">
                                        <b>
                                            <span ng-if="i.id_condicion == 1 || i.id_condicion == 2" style="font-weight: 600">{{i.porcentaje}}% </span>
                                            <span ng-if="i.id_condicion == 3 || i.id_condicion == 4" style="font-weight: 600">{{i.porcentaje | currency }} </span>
                                            <span ng-if="i.id_condicion == 6" style="font-weight: 600"> Primera Mensualidad Enero {{i.porcentaje}} </span>
                                            <span ng-if="i.id_condicion == 7" style="font-weight: 600"> Enganche diferido 3 meses </span>

                                            <span ng-if="i.id_condicion == 8" style="font-weight: 600"> Primera Mensualidad Octubre </span>
                                            <span ng-if="i.id_condicion == 9" style="font-weight: 600"> Primera Mensualidad Mayo </span>
                                            <span ng-if="i.id_condicion == 10" style="font-weight: 600"> Primera Mensualidad Septiembre </span>
                                            <span ng-if="i.id_condicion == 12" style="font-weight: 600">  Bono de {{i.porcentaje | currency}} al m<sup>2</sup></span>
                                            <span ng-if="i.id_condicion == 13" style="font-weight: 600"> {{i.msi_adicionales}} MSI adicionales</span>



                                        </b>
                                    </td>

                                    <td style="color:#2E86C1" class="text-center">
                                        <b>
                                            <span ng-if="i.id_condicion == 1 || i.id_condicion == 2 || i.id_condicion == 3 || i.id_condicion == 4 || i.id_condicion == 5 || i.id_condicion == 7 || i.id_condicion == 12  || i.id_condicion == 13" style="font-weight: 600"> {{ i.pm | currency }} </span>
                                            <span ng-if="i.id_condicion == 6" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 8" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 12" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 13" style="font-weight: 600"> </span>

                                        </b>
                                    </td>

                                    <td style="color:#2E86C1" class="text-center">
                                        <b>
                                            <span ng-if="i.id_condicion == 1 || i.id_condicion == 2 || i.id_condicion == 3 || i.id_condicion == 4 || i.id_condicion == 5 || i.id_condicion == 7 || i.id_condicion == 12 || i.id_condicion == 13" style="font-weight: 600"> {{ i.pt | currency }} </span>
                                            <span ng-if="i.id_condicion == 6" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 8" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 12" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 13" style="font-weight: 600"> </span>

                                        </b>
                                    </td>

                                    <td style="color:#27AE60" class="text-center">
                                        <b>

                                            <span ng-if="i.id_condicion == 1 || i.id_condicion == 2 || i.id_condicion == 3 || i.id_condicion == 4 || i.id_condicion == 5 || i.id_condicion == 7 || i.id_condicion == 12 || i.id_condicion == 13" style="font-weight: 600"> {{ i.ahorro | currency }} </span>
                                            <span ng-if="i.id_condicion == 6" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 8" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 12" style="font-weight: 600"> </span>
                                            <span ng-if="i.id_condicion == 13" style="font-weight: 600"> </span>

                                        </b>
                                    </td>

                                </tr>
                                <!---->


                                <tr align="center">
                                    <td colspan="6"><label type="text">Enganche diferido</label></td>
                                </tr>

                                <tr align="center">
                                    <td><label type="text">Fecha</label></td>
                                    <td><label type="text">Pago #</label></td>
                                    <td><label type="text">Total</label></td>
                                </tr>
                                <tr ng-repeat="i in rangEd">

                                    <td class="text-center">{{ i.fecha | date:'dd-mm-yyyy'}}</td>
                                    <td class="text-center">{{ i.pago }}</td>
                                    <td class="text-center">{{ i.total | currency }}</td>

                                </tr>


                                <tr align="center">
                                    <td colspan="9">
                                        <label type="text">Saldo</label><br>
                                        <label type="text"><b>{{saldoFinal | currency }}</b></label>
                                        <BR><BR>
                                        <label type="text" style="font-size:30px"><b>PRECIO FINAL</b></label><br>
                                        <label type="text" style="font-size:30px"><b>{{precioFinal | currency}}</b></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td float="center" colspan="2" class="text-center"><b><label
                                                    type="text">Enganche</label></b></td>
                                    <td float="center" colspan="4" class="text-center"><b><label type="text">Mensualidades</label></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label type="text">Días pago enganche</label></td>
                                    <td><label type="text"><b> {{ daysEnganche }} </b></label></td>
                                    <td><b><label type="text"></label></b><label type="text">Mensualidades SIN
                                            interés</label></td>
                                    <td><b><label type="text"></label>{{ finalMesesp1 }}&nbsp&nbsp&nbsp</b> {{ totalPrimerPlan | currency }}
                                    </td>
                                    <td><label type="text">Primer mensualidad</label></td>
                                    <td><b><label type="text" id="dias">{{ fechaPM }}</b></label></td>
                                </tr>
                                <tr>
                                    <td><label type="text" for="fecha">Fecha Límite </label></td>
                                    <td><label type="text" id="fecha"><b> {{fechaEng}} </b></label></td>

                                    <td ng-if="casaFlag == 0"><label type="text6">Mensualidades con interés (1% S.S.I.) </label></td>
                                    <td ng-if="casaFlag == 1"><label type="text6">Mensualidades con interés (1.108% S.S.I.) </label></td>
<!--                                    <td><b><label type="text" id="mPlan2" name="mPlan2"></label></b><label type="text6">Mensualidades con interés (1% S.S.I.) </label></td>-->
                                    <td><b><label type="text">{{ finalMesesp2 }}&nbsp&nbsp&nbsp</b> {{ totalSegundoPlan
                                        | currency }}</label></td>
                                </tr>
                                <tr>
                                    <td><label type="text" for="fecha">Pago Enganche</label></td>
                                    <td>
                                        <label type="text"><b>{{engancheFinal | currency }}</b></label><br>
                                    </td>
                                    <td ng-if="casaFlag == 0"><b><label type="text" id="mPlan3" name="mPlan3"></label></b><label type="text6">Mensualidades con interés (1.25% S.S.I.) </label></td>
                                    <td ng-if="casaFlag == 1"><label type="text6">Mensualidades con interés (1.108% S.S.I.) </label></td>
                                    <td><b><label type="text">{{ finalMesesp3 }}&nbsp&nbsp&nbsp</b> {{ totalTercerPlan |
                                        currency }}</label></td>
                                </tr>
                            </table>
                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <tr>
                                    <td colspan="3"><label type="text2">DATOS BANCARIOS</label></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table width="100%" class="table-data-bank">
                                            <tr>
                                                <td>
                                                    <b>Banco:</b><br>
                                                    <label type="text" class="infoBank">{{banco}}</label>
                                                </td>
                                                <td>
                                                    <b>Razón Social:</b><br>
                                                    <label type="text" class="infoBank">{{rsocial}}</label>
                                                </td>
                                                <td>
                                                    <b>Cuenta:</b><br>
                                                    <label type="text" class="infoBank">{{cuenta}}</label>
                                                </td>
                                                <td>
                                                    <b>CLABE:</b><br>
                                                    <label type="text" class="infoBank">{{clabe}}</label>
                                                </td>
                                                <td>
                                                    <b>Referencia:</b><br>
                                                    <label type="text" class="infoBank">{{referencia}}</label>
                                                </td>
                                            </tr>
                                        </table>
<!--                                        <b>Banco:</b> <label type="text" class="infoBank">{{banco}}</label>-->
<!--                                        <b>Razón Social:</b> <label type="text" class="infoBank">{{rsocial}}</label>-->
<!--                                        <b>Cuenta:</b> <label type="text" class="infoBank">{{cuenta}}</label>-->
<!--                                        <b>CLABE:</b> <label type="text" class="infoBank">{{clabe}}</label>-->
<!--                                        <p>-->
<!--                                            <b>Referencia:</b> <label type="text" class="infoBank">{{referencia}}</label>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td><label type="text">ASESOR</label></td>
                                    <td colspan="2"><label type="text">{{asesor.nombreAsesor}}</label></td>
                                </tr>
                                <tr>
                                    <td><label type="text">OBSERVACIONES</label></td>
                                    <td colspan="2"><input type="text" ng-model="observaciones" class="form-control"
                                                           placeholder="Describa algunas observaciones "></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><label type="text2"><p>
                                                Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin
                                                previo aviso. Esta simulación constituye un ejercicio numérico que no
                                                implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales,
                                                CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se
                                                aplican "escalonados", primero uno y luego el siguiente. Para Compra
                                                Múltiple: familiares que comprueben parentesco, amigos o socios.
                                            </p></label></td>
                                </tr>
                            </table>


                        </div>

                        <table datatable="ng"
                               class="table table-striped table-bordered table-hover table-condensed text-center"
                               dt-options="dtoptions" dt-columns="dtColumns" dt-column-defs="dtColumnDefs">
                            <!--   <thead>-->
                            <!--<tr>-->
                            <!--    <th>Fechas</th>-->
                            <!--    <th>Pago #</th>-->
                            <!--    <th>Capital</th>-->
                            <!--    <th>Intereses</th>-->
                            <!--    <th>Total</th>-->
                            <!--    <th>Saldo</th>-->
                            <!--</tr>-->
                            <!--                  </thead>-->
                            <!--                  <tbody>-->


                            <!--  <tr ng-repeat= "i in rangEds">-->

                            <!--      <td>{{ i.fecha | date:'dd-mm-yyyy'}}</td>-->
                            <!--      <td>{{ i.pago }}</td>              -->
                            <!--      <td>{{ i.capital | currency }}</td>-->
                            <!--      <td>{{ i.interes | currency }}</td>-->
                            <!--      <td>{{ i.total | currency }}</td>-->
                            <!--      <td>{{ i.saldo | currency }}</td>-->
                            <!--  </tr>-->

                            <!--  <tr ng-repeat= "i in range">-->

                            <!--      <td>{{ i.fecha | date:'dd-mm-yyyy'}}</td>-->
                            <!--      <td>{{ i.pago }}</td>              -->
                            <!--      <td>{{ i.capital | currency }}</td>-->
                            <!--      <td>{{ i.interes | currency }}</td>-->
                            <!--      <td>{{ i.total | currency }}</td>-->
                            <!--      <td>{{ i.saldo | currency }}</td>-->

                            <!--  </tr>-->
                            <!--</table>-->

                            <!--<table class="table table-striped table-bordered table-hover table-condensed text-center">-->
                            <!--  <tr>-->
                            <!--      <th>Fechas</th>-->
                            <!--      <th>Pago #</th>-->
                            <!--      <th>Capital</th>-->
                            <!--      <th>Intereses</th>-->
                            <!--      <th>Total</th>-->
                            <!--      <th>Saldo</th>-->
                            <!--  </tr>-->
                            <!--  <tr ng-repeat= "i in range2">-->

                            <!--      <td>{{ i.fecha | date:'dd-MM-yyyy'}}</td>-->
                            <!--      <td>{{ i.pago }}</td>              -->
                            <!--      <td>{{ i.capital | currency }}</td>-->
                            <!--      <td>{{ i.interes | currency }}</td>-->
                            <!--      <td>{{ i.total | currency }}</td>-->
                            <!--      <td>{{ i.saldo | currency }}</td>-->

                            <!--  </tr>-->
                            <!--</table> -->
                            <!--<table class="table table-striped table-bordered table-hover table-condensed text-center">-->
                            <!--  <tr>-->
                            <!--      <th>Fechas</th>-->
                            <!--      <th>Pago #</th>-->
                            <!--      <th>Capital</th>-->
                            <!--      <th>Intereses</th>-->
                            <!--      <th>Total</th>-->
                            <!--      <th>Saldo</th>-->
                            <!--  </tr>-->
                            <!--  <tr ng-repeat= "i in range3">-->

                            <!--      <td>{{ i.fecha | date:'dd-MM-yyyy'}}</td>-->
                            <!--      <td>{{ i.pago }}</td>              -->
                            <!--      <td>{{ i.capital | currency }}</td>-->
                            <!--      <td>{{ i.interes | currency }}</td>-->
                            <!--      <td>{{ i.total | currency }}</td>-->
                            <!--      <td>{{ i.saldo | currency }}</td>-->

                            <!--  </tr>-->
                            <!--</tbody>-->
                        </table>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 center-align">
                            <!--<button class="btn btn-success" href="#" ng-click="updateCorrida()">Actualizar</button>-->
                            <!--<button class="btn btn-success" href="#" ng-click="saveCorrida()">Crear nueva</button>-->
                        </div>
                        <div style="float: right;bottom: 2%;right: 3%;position: fixed;display: inline-flex;align-content: center;
                            flex-wrap: wrap;flex-direction: column;">

                            <button class="btn-circle blue" ng-click="printCover()"
                                    data-toggle="tooltip" title="Imprimir Carátula"><i class="fas fa-print fa-lg"></i></button>
                            <button class="btn-circle dark-blue" ng-click="printCoverCF()"
                                    data-toggle="tooltip" title="Imprimir Carátula + Corrida Financiera"><i class="fas fa-money-check-alt fa-lg"></i></button>
                            <button class="btn-circle" ng-click="updateCorrida()"
                                    data-toggle="tooltip" title="Guardar"><i class="fa fa-save fa-lg fa-lg"></i></button>
                        </div>


                        <!--                        <button class="btn-circle btn-float" ng-click="updateCorrida()"><i class="fa fa-save fa-lg"></i></button>-->
                        <!--                        <button class="btn-circle btn-float" ng-click="updateCorrida()"><i class="fa fa-save fa-lg"></i></button>-->
                    </div>


                </div>
            </div>

        </div>
    </section>


    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        /*------------------------------------------------------*/
        const selectElement = document.querySelector('#planSL');

        selectElement.addEventListener('change', (event) => {
            let cod = document.getElementById("planSL").value;
            if (cod == 'Contado') {
                $("#yearplan").val($("#yearplan").data("default-value"));
                ;
            }

        });
        /*-----------------------------------------------*/

        var myApp = angular.module('myApp', ['checklist-model', 'datatables', 'datatables.buttons']);


        myApp.directive('stringToNumber', function () {
            return {
                require: 'ngModel',
                link: function (scope, element, attrs, ngModel) {
                    ngModel.$parsers.push(function (value) {
                        return '' + value;
                    });
                    ngModel.$formatters.push(function (value) {
                    });
                }
            };
        });


        myApp.directive('inputCurrency', ['$locale', '$filter', function ($locale, $filter) {

            // For input validation
            var isValid = function (val) {
                return angular.isNumber(val) && !isNaN(val);
            };

            // Helper for creating RegExp's
            var toRegExp = function (val) {
                var escaped = val.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                return new RegExp(escaped, 'g');
            };

            // Saved to your $scope/model
            var toModel = function (val) {

                // Locale currency support
                var decimal = toRegExp($locale.NUMBER_FORMATS.DECIMAL_SEP);
                var group = toRegExp($locale.NUMBER_FORMATS.GROUP_SEP);
                var currency = toRegExp($locale.NUMBER_FORMATS.CURRENCY_SYM);

                // Strip currency related characters from string
                val = val.replace(decimal, '').replace(group, '').replace(currency, '').trim();

                return parseInt(val, 10);
            };

            // Displayed in the input to users
            var toView = function (val) {
                return $filter('currency')(val, '$', 0);
            };

            // Link to DOM
            var link = function ($scope, $element, $attrs, $ngModel) {
                $ngModel.$formatters.push(toView);
                $ngModel.$parsers.push(toModel);
                $ngModel.$validators.currency = isValid;

                $element.on('keyup', function () {
                    $ngModel.$viewValue = toView($ngModel.$modelValue);
                    $ngModel.$render();
                });
            };

            return {
                restrict: 'A',
                require: 'ngModel',
                link: link
            };
        }]);


        myApp.controller('myController', function ($scope,$compile, $http, $window, DTOptionsBuilder, DTColumnBuilder) {

            var descuentosAplicados = [];
            chargeInnitialInfo();

            // var range=[];
            // var range2=[];
            // var range3=[];

            // $scope.range= 0;
            // $scope.range2= 0;
            // $scope.range3= 0;


            function chargeInnitialInfo(){
                $scope.nombre = '<?php echo $data_corrida->nombre;?>';
                $scope.age = <?php echo $data_corrida->edad;?>;
                $scope.telefono = '<?php echo $data_corrida->telefono;?>';
                $scope.email = '<?php echo $data_corrida->correo;?>';
                $scope.lote = <?php echo $data_corrida->id_lote;?>;
                $scope.plan = '<?php echo $data_corrida->plan_corrida;?>';
                $scope.yearplan = <?php echo $data_corrida->anio;?>;
                $scope.gerente = <?php echo $data_corrida->id_gerente;?>;
                $scope.asesor = <?php echo $data_corrida->id_asesor; ?>;
                $scope.tipo_casas = [{id: "1",nombre: "Stella"}, {id: '2', nombre: 'Aura'}];
                var datos = [];



                $.ajax({
                    url: "<?=base_url()?>index.php/Corrida/getResidencialDisponible",
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    beforeSend:function(){
                        $('#loaderDiv').removeClass('hide');
                    },
                    success : function (response) {
                        // console.log(JSON.parse(response));
                        $scope.residencial = JSON.parse(response);
                        $('#loaderDiv').addClass('hide');
                    }
                });

                /*$http.post('<?=base_url()?>index.php/Asesor/getinfoLoteDisponible',{lote: <?=$data_corrida->id_lote?>, tipo_casa: <?=$data_corrida->tipo_casa?>}).then(
                    function (response) {


                        //Reinicia los valores del arreglo que trae descuentos
                        descuentosAplicados=[];
                        $scope.selected = {};
                        $scope.porcentaje = $scope.porcentajeEng = 0;
                        $scope.descDateEnero = 0;
                        $scope.noPagomensualidad = 0;
                        $scope.descMSI = 0;

                        $scope.descDateOctubre = 0;


                        $scope.descDateEneroMerida = 0;
                        $scope.descDateMayoMerida = 0;
                        $scope.descDateSeptiembreMerida = 0;

                        $scope.descDateEneroMeridaC = 0;
                        $scope.descDateMayoMeridaC = 0;
                        $scope.descDateSeptiembreMeridaC = 0;


                        $scope.descDateEneroLM1 = 0;
                        $scope.descDateEneroLM2 = 0;
                        $scope.descDateEneroLM3 = 0;
                        $scope.descDateSepLM4 = 0;


                        $scope.descDateEneroLM1C = 0;
                        $scope.descDateEneroLM2C = 0;
                        $scope.descDateSepLM3C = 0;
                        $scope.descDateSepLM4C = 0;



                        $scope.descDateEneroL1 = 0;
                        $scope.descDateEneroL2 = 0;
                        $scope.descDateEneroL3 = 0;
                        $scope.descDateEneroL4 = 0;
                        $scope.descDateSepL1 = 0;


                        $scope.descDateEneroL5 = 0;
                        $scope.descDateEneroL6 = 0;
                        $scope.descDateEneroL7 = 0;
                        $scope.descDateSepL2 = 0;
                        $scope.descDateSepL3 = 0;

                        $scope.descDateEneroL8 = 0;
                        $scope.descDateEneroL9 = 0;
                        $scope.descDateSepL4 = 0;
                        $scope.descDateSepL5 = 0;



                        $scope.descDateEneroAllQro1 = 0;
                        $scope.descDateEneroAllQro2 = 0;
                        $scope.descDateSepAllQro1 = 0;
                        $scope.descDateSepAllQro2 = 0;
                        $scope.descDateMayoAllQro1 = 0;
                        $scope.descDateMayoAllQro2 = 0;


                        $scope.descDateMayoSLP = 0;

                        $scope.engancheCincoMil = 0;
                        $scope.engancheVeintiCincoMilMerida = 0;

                        $scope.engancheCincoMilLM = 0;
                        $scope.engancheVeintiCincoMilLM = 0;
                        $scope.engancheCincoMilL1 = 0;
                        $scope.engancheCincoMilL2 = 0;
                        $scope.engancheVeintiCincoMilL = 0;


                        $scope.helpMxMerida1 = 0;
                        $scope.helpMxMerida2 = 0;
                        $scope.helpMxMerida3 = 0;
                        $scope.helpMxMerida4 = 0;

                        $scope.descDateEneroS1YS2 = 0;
                        $scope.descDateEng0S1YS2 = 0;

                        $scope.engancheDiezMilLSLP = 0;




                        $scope.cinco_milM = 0;
                        $scope.veinteJ_milM = 0;
                        $scope.diez_milM = 0;

                        $scope.cinco_milL = 0;
                        $scope.diez_milL = 0;
                        $scope.veinticinco_milL = 0;

                        $scope.cinco_milLM = 0;
                        $scope.veinticinco_milLM = 0;
                        $scope.veinticinco_milLM2 = 0;


                        $scope.ceroQ1 = 0;
                        $scope.ceroQ2 = 0;
                        $scope.ceroQ3 = 0;
                        $scope.ceroQ4 = 0;


                        $scope.cyd_slp1 = 0;
                        $scope.cyd_slp2 = 0;

                        $scope.cincoCSLP = 0;
                        $scope.cincoCL = 0;


                        $scope.selectDescuentos = function(descuento, checked){

                            var idx = descuentosAplicados.indexOf(descuento);
                            // console.log('Tienes un número negativo ' +idx);
                            if (idx >= 0 && !checked) {
                                descuentosAplicados.splice(idx, 1);
                                $scope.descApply = descuentosAplicados;


                                for(var descuentos of $scope.descApply){

                                    if(descuentos.id_paquete == 261 || descuentos.id_paquete == 151 || descuentos.id_paquete == 368 || descuentos.id_paquete == 369 || descuentos.id_paquete == 263 || descuentos.id_paquete == 268 || descuentos.id_paquete == 269
                                        || descuentos.id_paquete == 265 || descuentos.id_paquete == 270 || descuentos.id_paquete == 271 || descuentos.id_paquete == 272 || descuentos.id_paquete == 273 || descuentos.id_paquete == 274
                                        || descuentos.id_paquete == 275 || descuentos.id_paquete == 276 || descuentos.id_paquete == 278 || descuentos.id_paquete == 279 || descuentos.id_paquete == 280 || descuentos.id_paquete == 281


                                        || descuentos.id_paquete == 283 || descuentos.id_paquete == 284 || descuentos.id_paquete == 285 || descuentos.id_paquete == 286 || descuentos.id_paquete == 287


                                        || descuentos.id_paquete == 289 || descuentos.id_paquete == 290 || descuentos.id_paquete == 291 || descuentos.id_paquete == 292 || descuentos.id_paquete == 293
                                        || descuentos.id_paquete == 295 || descuentos.id_paquete == 296 || descuentos.id_paquete == 297 || descuentos.id_paquete == 298



                                        || descuentos.id_paquete == 300 || descuentos.id_paquete == 301 || descuentos.id_paquete == 302 || descuentos.id_paquete == 303
                                        || descuentos.id_paquete == 304 || descuentos.id_paquete == 305

                                        || descuentos.id_paquete == 262

                                        || descuentos.id_paquete == 277 || descuentos.id_paquete == 282 || descuentos.id_paquete == 288 || descuentos.id_paquete == 294
                                        || descuentos.id_paquete == 299 || descuentos.id_paquete == 307 || descuentos.id_paquete == 308 || descuentos.id_paquete == 309 || descuentos.id_paquete == 310

                                        || descuentos.id_paquete == 311 || descuentos.id_paquete == 312
                                        || descuentos.id_paquete == 313


                                        || descuentos.id_paquete == 267
                                        || descuentos.id_paquete == 351
                                        || descuentos.id_paquete == 354


                                        || descuentos.id_paquete == 317
                                        || descuentos.id_paquete == 320
                                        || descuentos.id_paquete == 324

                                        || descuentos.id_paquete == 329
                                        || descuentos.id_paquete == 333


                                        || descuentos.id_paquete == 360
                                        || descuentos.id_paquete == 361
                                        || descuentos.id_paquete == 362
                                        || descuentos.id_paquete == 365

                                        || descuentos.id_paquete == 366
                                        || descuentos.id_paquete == 367

                                        || descuentos.id_paquete == 370
                                        || descuentos.id_paquete == 373
                                        || descuentos.id_paquete == 378


                                    ){
                                        if(descuentos.id_paquete == 261){
                                            $scope.descDateEnero = 1;
                                        } else if (descuentos.id_paquete == 151){
                                            $scope.noPagomensualidad = 1;
                                        } else if (descuentos.id_paquete == 368 || descuentos.id_paquete == 369){
                                            $scope.descMSI = 1;
                                        } else if (descuentos.id_paquete == 263){
                                            $scope.descDateOctubre = 1;
                                        } else if (descuentos.id_paquete == 268){
                                            $scope.descDateSeptiembreMerida = 1;
                                        } else if (descuentos.id_paquete == 269){
                                            $scope.descDateMayoMerida = 1;
                                            $scope.engancheCincoMil = 1;

                                        } else if (descuentos.id_paquete == 265){
                                            $scope.descDateEneroMerida = 1;
                                        } else if (descuentos.id_paquete == 270){
                                            $scope.descDateEneroMeridaC = 1;
                                        } else if (descuentos.id_paquete == 271){
                                            $scope.descDateSeptiembreMeridaC = 1;
                                        } else if (descuentos.id_paquete == 272){
                                            $scope.descDateMayoMeridaC = 1;
                                            $scope.engancheVeintiCincoMilMerida = 1;

                                        }


                                        else if (descuentos.id_paquete == 273){
                                            $scope.descDateEneroLM1 = 1;
                                        } else if (descuentos.id_paquete == 274){
                                            $scope.descDateEneroLM2 = 1;
                                        } else if (descuentos.id_paquete == 275){
                                            $scope.descDateEneroLM3 = 1;
                                        } else if (descuentos.id_paquete == 276){
                                            $scope.descDateSepLM4 = 1;
                                        }


                                        else if (descuentos.id_paquete == 278){
                                            $scope.descDateEneroLM1C = 1;
                                        } else if (descuentos.id_paquete == 279){
                                            $scope.descDateEneroLM2C = 1;
                                        } else if (descuentos.id_paquete == 280){
                                            $scope.descDateSepLM3C = 1;
                                        } else if (descuentos.id_paquete == 281){
                                            $scope.descDateSepLM4C = 1;
                                        }


                                        else if (descuentos.id_paquete == 283){
                                            $scope.descDateEneroL1 = 1;
                                        } else if (descuentos.id_paquete == 284){
                                            $scope.descDateEneroL2 = 1;
                                        } else if (descuentos.id_paquete == 285){
                                            $scope.descDateEneroL3 = 1;
                                        } else if (descuentos.id_paquete == 286){
                                            $scope.descDateEneroL4 = 1;
                                        }	else if (descuentos.id_paquete == 287){
                                            $scope.descDateSepL1 = 1;
                                        }




                                        else if (descuentos.id_paquete == 289){
                                            $scope.descDateEneroL5 = 1;
                                        } else if (descuentos.id_paquete == 290){
                                            $scope.descDateEneroL6 = 1;
                                        } else if (descuentos.id_paquete == 291){
                                            $scope.descDateEneroL7 = 1;
                                        } else if (descuentos.id_paquete == 292){
                                            $scope.descDateSepL2 = 1;
                                        }	else if (descuentos.id_paquete == 293){
                                            $scope.descDateSepL3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 295){
                                            $scope.descDateEneroL8 = 1;
                                        } else if (descuentos.id_paquete == 296){
                                            $scope.descDateEneroL9 = 1;
                                        } else if (descuentos.id_paquete == 297){
                                            $scope.descDateSepL4 = 1;
                                        } else if (descuentos.id_paquete == 298){
                                            $scope.descDateSepL5 = 1;
                                        }




                                        else if (descuentos.id_paquete == 300){
                                            $scope.descDateEneroAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 301){
                                            $scope.descDateEneroAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 302){
                                            $scope.descDateSepAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 303){
                                            $scope.descDateSepAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 304){
                                            $scope.descDateMayoAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 305){
                                            $scope.descDateMayoAllQro2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 262){
                                            $scope.descDateMayoSLP = 1;
                                        }

                                        else if (descuentos.id_paquete == 277){

                                            $scope.engancheCincoMilLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 282){
                                            $scope.engancheVeintiCincoMilLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 288){
                                            $scope.engancheCincoMilL1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 294){
                                            $scope.engancheCincoMilL2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 299){
                                            $scope.engancheVeintiCincoMilL = 1;
                                        }

                                        else if (descuentos.id_paquete == 307){
                                            $scope.helpMxMerida1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 308){
                                            $scope.helpMxMerida2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 309){
                                            $scope.helpMxMerida3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 310){
                                            $scope.helpMxMerida4 = 1;
                                        }

                                        else if (descuentos.id_paquete == 311){
                                            $scope.descDateEneroS1YS2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 312){
                                            $scope.descDateEng0S1YS2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 313){
                                            $scope.engancheDiezMilLSLP = 1;
                                        }


                                        else if (descuentos.id_paquete == 267){
                                            $scope.cinco_milM = 1;
                                        }

                                        else if (descuentos.id_paquete == 351){
                                            $scope.veinteJ_milM = 1;
                                        }

                                        else if (descuentos.id_paquete == 354){
                                            $scope.diez_milM = 1;
                                        }



                                        else if (descuentos.id_paquete == 317){
                                            $scope.cinco_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 320){
                                            $scope.diez_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 324){
                                            $scope.veinticinco_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 329){
                                            $scope.cinco_milLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 333){
                                            $scope.veinticinco_milLM = 1;
                                        }





                                        else if (descuentos.id_paquete == 360){
                                            $scope.ceroQ1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 361){
                                            $scope.ceroQ2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 362){
                                            $scope.ceroQ3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 365){
                                            $scope.ceroQ4 = 1;
                                        }



                                        else if (descuentos.id_paquete == 366){
                                            $scope.cyd_slp1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 367){
                                            $scope.cyd_slp2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 370){
                                            $scope.cincoCSLP = 1;
                                        }

                                        else if (descuentos.id_paquete == 373){
                                            $scope.veinticinco_milLM2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 378){
                                            $scope.cincoCL = 1;
                                        }

                                    } else if (descuentos.id_paquete != 261 || descuentos.id_paquete != 151 || descuentos.id_paquete != 368 || descuentos.id_paquete != 369 || descuentos.id_paquete != 263 || descuentos.id_paquete != 268
                                        || descuentos.id_paquete != 269 || descuentos.id_paquete != 265 || descuentos.id_paquete != 270 || descuentos.id_paquete != 271 || descuentos.id_paquete != 272
                                        || descuentos.id_paquete != 273 || descuentos.id_paquete != 274 || descuentos.id_paquete != 275 || descuentos.id_paquete != 276
                                        || descuentos.id_paquete != 278 || descuentos.id_paquete != 279 || descuentos.id_paquete != 280 || descuentos.id_paquete != 281

                                        || descuentos.id_paquete != 283 || descuentos.id_paquete != 284 || descuentos.id_paquete != 285 || descuentos.id_paquete != 286 || descuentos.id_paquete != 287



                                        || descuentos.id_paquete != 289 || descuentos.id_paquete != 290 || descuentos.id_paquete != 291 || descuentos.id_paquete != 292 || descuentos.id_paquete != 293
                                        || descuentos.id_paquete != 295 || descuentos.id_paquete != 296 || descuentos.id_paquete != 297 || descuentos.id_paquete != 298


                                        || descuentos.id_paquete != 300 || descuentos.id_paquete != 301 || descuentos.id_paquete != 302 || descuentos.id_paquete != 303
                                        || descuentos.id_paquete != 304 || descuentos.id_paquete != 305

                                        || descuentos.id_paquete != 262

                                        || descuentos.id_paquete != 277 || descuentos.id_paquete != 282 || descuentos.id_paquete != 288 || descuentos.id_paquete != 294
                                        || descuentos.id_paquete != 299 || descuentos.id_paquete != 307 || descuentos.id_paquete != 308 || descuentos.id_paquete != 309 || descuentos.id_paquete != 310

                                        || descuentos.id_paquete != 311 || descuentos.id_paquete != 312
                                        || descuentos.id_paquete != 313

                                        || descuentos.id_paquete != 267
                                        || descuentos.id_paquete != 351
                                        || descuentos.id_paquete != 354


                                        || descuentos.id_paquete != 317
                                        || descuentos.id_paquete != 320
                                        || descuentos.id_paquete != 324

                                        || descuentos.id_paquete != 329
                                        || descuentos.id_paquete != 333



                                        || descuentos.id_paquete != 360
                                        || descuentos.id_paquete != 361
                                        || descuentos.id_paquete != 362
                                        || descuentos.id_paquete != 365

                                        || descuentos.id_paquete != 366
                                        || descuentos.id_paquete != 367

                                        || descuentos.id_paquete != 370
                                        || descuentos.id_paquete != 373
                                        || descuentos.id_paquete != 378

                                    ) {
                                        $scope.descDateEnero = 0;
                                        $scope.noPagomensualidad = 0;
                                        $scope.descMSI = 0;
                                        $scope.descDateOctubre = 0;
                                        $scope.descDateMayoMerida = 0;
                                        $scope.descDateSeptiembreMerida = 0;
                                        $scope.descDateEneroMerida = 0;
                                        $scope.descDateEneroMeridaC = 0;
                                        $scope.descDateMayoMeridaC = 0;
                                        $scope.descDateSeptiembreMeridaC = 0;
                                        $scope.descDateEneroLM1 = 0;
                                        $scope.descDateEneroLM2 = 0;
                                        $scope.descDateEneroLM3 = 0;
                                        $scope.descDateSepLM4 = 0;

                                        $scope.descDateEneroLM1C = 0;
                                        $scope.descDateEneroLM2C = 0;
                                        $scope.descDateSepLM3C = 0;
                                        $scope.descDateSepLM4C = 0;

                                        $scope.descDateEneroL1 = 0;
                                        $scope.descDateEneroL2 = 0;
                                        $scope.descDateEneroL3 = 0;
                                        $scope.descDateEneroL4 = 0;
                                        $scope.descDateSepL1 = 0;


                                        $scope.descDateEneroL5 = 0;
                                        $scope.descDateEneroL6 = 0;
                                        $scope.descDateEneroL7 = 0;
                                        $scope.descDateSepL2 = 0;
                                        $scope.descDateSepL3 = 0;

                                        $scope.descDateEneroL8 = 0;
                                        $scope.descDateEneroL9 = 0;
                                        $scope.descDateSepL4 = 0;
                                        $scope.descDateSepL5 = 0;


                                        $scope.descDateEneroAllQro1 = 0;
                                        $scope.descDateEneroAllQro2 = 0;
                                        $scope.descDateSepAllQro1 = 0;
                                        $scope.descDateSepAllQro2 = 0;
                                        $scope.descDateMayoAllQro1 = 0;
                                        $scope.descDateMayoAllQro2 = 0;

                                        $scope.descDateMayoSLP = 0;

                                        $scope.engancheCincoMil = 0;
                                        $scope.engancheVeintiCincoMilMerida = 0;


                                        $scope.engancheCincoMilLM = 0;
                                        $scope.engancheVeintiCincoMilLM = 0;
                                        $scope.engancheCincoMilL1 = 0;
                                        $scope.engancheCincoMilL2 = 0;
                                        $scope.engancheVeintiCincoMilL = 0;

                                        $scope.helpMxMerida1 = 0;
                                        $scope.helpMxMerida2 = 0;
                                        $scope.helpMxMerida3 = 0;
                                        $scope.helpMxMerida4 = 0;

                                        $scope.descDateEneroS1YS2 = 0;
                                        $scope.descDateEng0S1YS2 = 0;

                                        $scope.engancheDiezMilLSLP = 0;


                                        $scope.cinco_milM = 0;
                                        $scope.veinteJ_milM = 0;
                                        $scope.diez_milM = 0;


                                        $scope.cinco_milL = 0;
                                        $scope.diez_milL = 0;
                                        $scope.veinticinco_milL = 0;

                                        $scope.cinco_milLM = 0;
                                        $scope.veinticinco_milLM = 0;


                                        $scope.ceroQ1 = 0;
                                        $scope.ceroQ2 = 0;
                                        $scope.ceroQ3 = 0;
                                        $scope.ceroQ4 = 0;

                                        $scope.cyd_slp1 = 0;
                                        $scope.cyd_slp2 = 0;

                                        $scope.cincoCSLP = 0;
                                        $scope.veinticinco_milLM2 = 0;
                                        $scope.cincoCL = 0;


                                    }

                                }

                                if($scope.descApply.length == 0){
                                    $scope.descDateEnero = 0;
                                    $scope.noPagomensualidad = 0;
                                    $scope.descMSI = 0;
                                    $scope.descDateOctubre = 0;
                                    $scope.descDateMayoMerida = 0;
                                    $scope.descDateSeptiembreMerida = 0;
                                    $scope.descDateEneroMerida = 0;
                                    $scope.descDateEneroMeridaC = 0;
                                    $scope.descDateMayoMeridaC = 0;
                                    $scope.descDateSeptiembreMeridaC = 0;
                                    $scope.descDateEneroLM1 = 0;
                                    $scope.descDateEneroLM2 = 0;
                                    $scope.descDateEneroLM3 = 0;
                                    $scope.descDateSepLM4 = 0;

                                    $scope.descDateEneroLM1C = 0;
                                    $scope.descDateEneroLM2C = 0;
                                    $scope.descDateSepLM3C = 0;
                                    $scope.descDateSepLM4C = 0;

                                    $scope.descDateEneroL1 = 0;
                                    $scope.descDateEneroL2 = 0;
                                    $scope.descDateEneroL3 = 0;
                                    $scope.descDateEneroL4 = 0;
                                    $scope.descDateSepL1 = 0;

                                    $scope.descDateEneroL5 = 0;
                                    $scope.descDateEneroL6 = 0;
                                    $scope.descDateEneroL7 = 0;
                                    $scope.descDateSepL2 = 0;
                                    $scope.descDateSepL3 = 0;

                                    $scope.descDateEneroL8 = 0;
                                    $scope.descDateEneroL9 = 0;
                                    $scope.descDateSepL4 = 0;
                                    $scope.descDateSepL5 = 0;

                                    $scope.descDateEneroAllQro1 = 0;
                                    $scope.descDateEneroAllQro2 = 0;
                                    $scope.descDateSepAllQro1 = 0;
                                    $scope.descDateSepAllQro2 = 0;
                                    $scope.descDateMayoAllQro1 = 0;
                                    $scope.descDateMayoAllQro2 = 0;

                                    $scope.descDateMayoSLP = 0;

                                    $scope.engancheCincoMil = 0;
                                    $scope.engancheVeintiCincoMilMerida = 0;


                                    $scope.engancheCincoMilLM = 0;
                                    $scope.engancheVeintiCincoMilLM = 0;
                                    $scope.engancheCincoMilL1 = 0;
                                    $scope.engancheCincoMilL2 = 0;
                                    $scope.engancheVeintiCincoMilL = 0;

                                    $scope.helpMxMerida1 = 0;
                                    $scope.helpMxMerida2 = 0;
                                    $scope.helpMxMerida3 = 0;
                                    $scope.helpMxMerida4 = 0;

                                    $scope.descDateEneroS1YS2 = 0;
                                    $scope.descDateEng0S1YS2 = 0;

                                    $scope.engancheDiezMilLSLP = 0;


                                    $scope.cinco_milM = 0;
                                    $scope.veinteJ_milM = 0;
                                    $scope.diez_milM = 0;

                                    $scope.cinco_milL = 0;
                                    $scope.diez_milL = 0;
                                    $scope.veinticinco_milL = 0;

                                    $scope.cinco_milLM = 0;
                                    $scope.veinticinco_milLM = 0;


                                    $scope.ceroQ1 = 0;
                                    $scope.ceroQ2 = 0;
                                    $scope.ceroQ3 = 0;
                                    $scope.ceroQ4 = 0;

                                    $scope.cyd_slp1 = 0;
                                    $scope.cyd_slp2 = 0;

                                    $scope.cincoCSLP = 0;
                                    $scope.veinticinco_milLM2 = 0;
                                    $scope.cincoCL = 0;


                                }

                            }

                            if (idx < 0 && checked) {
                                descuentosAplicados.push(descuento);
                                $scope.descApply = descuentosAplicados;
                                for(var descuentos of $scope.descApply){

                                    if(descuentos.id_paquete == 261 || descuentos.id_paquete == 151 || descuentos.id_paquete == 368 || descuentos.id_paquete == 369 || descuentos.id_paquete == 263 || descuentos.id_paquete == 268 || descuentos.id_paquete == 269
                                        || descuentos.id_paquete == 265 || descuentos.id_paquete == 270 || descuentos.id_paquete == 271 || descuentos.id_paquete == 272 || descuentos.id_paquete == 273 || descuentos.id_paquete == 274
                                        || descuentos.id_paquete == 275 || descuentos.id_paquete == 276 || descuentos.id_paquete == 278 || descuentos.id_paquete == 279 || descuentos.id_paquete == 280 || descuentos.id_paquete == 281

                                        || descuentos.id_paquete == 283 || descuentos.id_paquete == 284 || descuentos.id_paquete == 285 || descuentos.id_paquete == 286 || descuentos.id_paquete == 287

                                        || descuentos.id_paquete == 289 || descuentos.id_paquete == 290 || descuentos.id_paquete == 291 || descuentos.id_paquete == 292 || descuentos.id_paquete == 293
                                        || descuentos.id_paquete == 295 || descuentos.id_paquete == 296 || descuentos.id_paquete == 297 || descuentos.id_paquete == 298


                                        || descuentos.id_paquete == 300 || descuentos.id_paquete == 301 || descuentos.id_paquete == 302 || descuentos.id_paquete == 303
                                        || descuentos.id_paquete == 304 || descuentos.id_paquete == 305

                                        || descuentos.id_paquete == 262

                                        || descuentos.id_paquete == 277 || descuentos.id_paquete == 282 || descuentos.id_paquete == 288 || descuentos.id_paquete == 294
                                        || descuentos.id_paquete == 299 || descuentos.id_paquete == 307 || descuentos.id_paquete == 308 || descuentos.id_paquete == 309 || descuentos.id_paquete == 310


                                        || descuentos.id_paquete == 311 || descuentos.id_paquete == 312
                                        || descuentos.id_paquete == 313


                                        || descuentos.id_paquete == 267
                                        || descuentos.id_paquete == 351
                                        || descuentos.id_paquete == 354

                                        || descuentos.id_paquete == 317
                                        || descuentos.id_paquete == 320
                                        || descuentos.id_paquete == 324


                                        || descuentos.id_paquete == 329
                                        || descuentos.id_paquete == 333


                                        || descuentos.id_paquete == 360
                                        || descuentos.id_paquete == 361
                                        || descuentos.id_paquete == 362
                                        || descuentos.id_paquete == 365

                                        || descuentos.id_paquete == 366
                                        || descuentos.id_paquete == 367

                                        || descuentos.id_paquete == 370
                                        || descuentos.id_paquete == 373
                                        || descuentos.id_paquete == 378

                                    ){
                                        if(descuentos.id_paquete == 261){
                                            $scope.descDateEnero = 1;
                                        } else if (descuentos.id_paquete == 151){
                                            $scope.noPagomensualidad = 1;
                                        } else if (descuentos.id_paquete == 368 || descuentos.id_paquete == 369){
                                            $scope.descMSI = 1;
                                        } else if (descuentos.id_paquete == 263){
                                            $scope.descDateOctubre = 1;
                                        } else if (descuentos.id_paquete == 268){
                                            $scope.descDateSeptiembreMerida = 1;
                                        } else if (descuentos.id_paquete == 269){
                                            $scope.descDateMayoMerida = 1;
                                            $scope.engancheCincoMil = 1;


                                        } else if (descuentos.id_paquete == 265){
                                            $scope.descDateEneroMerida = 1;
                                        } else if (descuentos.id_paquete == 270){
                                            $scope.descDateEneroMeridaC = 1;
                                        } else if (descuentos.id_paquete == 271){
                                            $scope.descDateSeptiembreMeridaC = 1;
                                        } else if (descuentos.id_paquete == 272){
                                            $scope.descDateMayoMeridaC = 1;
                                            $scope.engancheVeintiCincoMilMerida = 1;

                                        }

                                        else if (descuentos.id_paquete == 273){
                                            $scope.descDateEneroLM1 = 1;
                                        } else if (descuentos.id_paquete == 274){
                                            $scope.descDateEneroLM2 = 1;
                                        } else if (descuentos.id_paquete == 275){
                                            $scope.descDateEneroLM3 = 1;
                                        } else if (descuentos.id_paquete == 276){
                                            $scope.descDateSepLM4 = 1;
                                        }

                                        else if (descuentos.id_paquete == 278){
                                            $scope.descDateEneroLM1C = 1;
                                        } else if (descuentos.id_paquete == 279){
                                            $scope.descDateEneroLM2C = 1;
                                        } else if (descuentos.id_paquete == 280){
                                            $scope.descDateSepLM3C = 1;
                                        } else if (descuentos.id_paquete == 281){
                                            $scope.descDateSepLM4C = 1;
                                        }




                                        else if (descuentos.id_paquete == 283){
                                            $scope.descDateEneroL1 = 1;
                                        } else if (descuentos.id_paquete == 284){
                                            $scope.descDateEneroL2 = 1;
                                        } else if (descuentos.id_paquete == 285){
                                            $scope.descDateEneroL3 = 1;
                                        } else if (descuentos.id_paquete == 286){
                                            $scope.descDateEneroL4 = 1;
                                        }	else if (descuentos.id_paquete == 287){
                                            $scope.descDateSepL1 = 1;
                                        }





                                        else if (descuentos.id_paquete == 289){
                                            $scope.descDateEneroL5 = 1;
                                        } else if (descuentos.id_paquete == 290){
                                            $scope.descDateEneroL6 = 1;
                                        } else if (descuentos.id_paquete == 291){
                                            $scope.descDateEneroL7 = 1;
                                        } else if (descuentos.id_paquete == 292){
                                            $scope.descDateSepL2 = 1;
                                        }	else if (descuentos.id_paquete == 293){
                                            $scope.descDateSepL3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 295){
                                            $scope.descDateEneroL8 = 1;
                                        } else if (descuentos.id_paquete == 296){
                                            $scope.descDateEneroL9 = 1;
                                        } else if (descuentos.id_paquete == 297){
                                            $scope.descDateSepL4 = 1;
                                        } else if (descuentos.id_paquete == 298){
                                            $scope.descDateSepL5 = 1;
                                        }


                                        else if (descuentos.id_paquete == 300){
                                            $scope.descDateEneroAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 301){
                                            $scope.descDateEneroAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 302){
                                            $scope.descDateSepAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 303){
                                            $scope.descDateSepAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 304){
                                            $scope.descDateMayoAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 305){
                                            $scope.descDateMayoAllQro2 = 1;
                                        }


                                        else if (descuentos.id_paquete == 262){
                                            $scope.descDateMayoSLP = 1;
                                        }

                                        else if (descuentos.id_paquete == 277){

                                            $scope.engancheCincoMilLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 282){
                                            $scope.engancheVeintiCincoMilLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 288){
                                            $scope.engancheCincoMilL1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 294){
                                            $scope.engancheCincoMilL2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 299){
                                            $scope.engancheVeintiCincoMilL = 1;
                                        }


                                        else if (descuentos.id_paquete == 307){
                                            $scope.helpMxMerida1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 308){
                                            $scope.helpMxMerida2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 309){
                                            $scope.helpMxMerida3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 310){
                                            $scope.helpMxMerida4 = 1;
                                        }


                                        else if (descuentos.id_paquete == 311){
                                            $scope.descDateEneroS1YS2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 312){
                                            $scope.descDateEng0S1YS2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 313){
                                            $scope.engancheDiezMilLSLP = 1;
                                        }




                                        else if (descuentos.id_paquete == 267){
                                            $scope.cinco_milM = 1;
                                        }
                                        else if (descuentos.id_paquete == 351){
                                            $scope.veinteJ_milM = 1;
                                        }

                                        else if (descuentos.id_paquete == 354){
                                            $scope.diez_milM = 1;
                                        }



                                        else if (descuentos.id_paquete == 317){
                                            $scope.cinco_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 320){
                                            $scope.diez_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 324){
                                            $scope.veinticinco_milL = 1;
                                        }

                                        else if (descuentos.id_paquete == 329){
                                            $scope.cinco_milLM = 1;
                                        }

                                        else if (descuentos.id_paquete == 333){
                                            $scope.veinticinco_milLM = 1;
                                        }




                                        else if (descuentos.id_paquete == 360){
                                            $scope.ceroQ1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 361){
                                            $scope.ceroQ2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 362){
                                            $scope.ceroQ3 = 1;
                                        }

                                        else if (descuentos.id_paquete == 365){
                                            $scope.ceroQ4 = 1;
                                        }


                                        else if (descuentos.id_paquete == 366){
                                            $scope.cyd_slp1 = 1;
                                        }

                                        else if (descuentos.id_paquete == 367){
                                            $scope.cyd_slp2 = 1;
                                        }

                                        else if (descuentos.id_paquete == 370){
                                            $scope.cincoCSLP = 1;
                                        }
                                        else if (descuentos.id_paquete == 373){
                                            $scope.veinticinco_milLM2 = 1;
                                        }
                                        else if (descuentos.id_paquete == 378){
                                            $scope.cincoCL = 1;
                                        }

                                    } else if (descuentos.id_paquete != 261 || descuentos.id_paquete != 151 || descuentos.id_paquete != 368 || descuentos.id_paquete != 369 || descuentos.id_paquete != 263 || descuentos.id_paquete != 268
                                        || descuentos.id_paquete != 269 || descuentos.id_paquete != 265 || descuentos.id_paquete != 270 || descuentos.id_paquete != 271 || descuentos.id_paquete != 272
                                        || descuentos.id_paquete != 273 || descuentos.id_paquete != 274 || descuentos.id_paquete != 275 || descuentos.id_paquete != 276
                                        || descuentos.id_paquete != 278 || descuentos.id_paquete != 279 || descuentos.id_paquete != 280 || descuentos.id_paquete != 281

                                        || descuentos.id_paquete != 283 || descuentos.id_paquete != 284 || descuentos.id_paquete != 285 || descuentos.id_paquete != 286 || descuentos.id_paquete != 287


                                        || descuentos.id_paquete != 289 || descuentos.id_paquete != 290 || descuentos.id_paquete != 291 || descuentos.id_paquete != 292 || descuentos.id_paquete != 293
                                        || descuentos.id_paquete != 295 || descuentos.id_paquete != 296 || descuentos.id_paquete != 297 || descuentos.id_paquete != 298

                                        || descuentos.id_paquete != 300 || descuentos.id_paquete != 301 || descuentos.id_paquete != 302 || descuentos.id_paquete != 303
                                        || descuentos.id_paquete != 304 || descuentos.id_paquete != 305

                                        || descuentos.id_paquete != 262

                                        || descuentos.id_paquete != 277 || descuentos.id_paquete != 282 || descuentos.id_paquete != 288 || descuentos.id_paquete != 294
                                        || descuentos.id_paquete != 299 || descuentos.id_paquete != 307 || descuentos.id_paquete != 308 || descuentos.id_paquete != 309 || descuentos.id_paquete != 310


                                        || descuentos.id_paquete != 311 || descuentos.id_paquete != 312
                                        || descuentos.id_paquete != 313

                                        || descuentos.id_paquete != 267
                                        || descuentos.id_paquete != 351
                                        || descuentos.id_paquete != 354


                                        || descuentos.id_paquete != 317
                                        || descuentos.id_paquete != 320
                                        || descuentos.id_paquete != 324

                                        || descuentos.id_paquete != 329
                                        || descuentos.id_paquete != 333


                                        || descuentos.id_paquete != 360
                                        || descuentos.id_paquete != 361
                                        || descuentos.id_paquete != 362
                                        || descuentos.id_paquete != 365


                                        || descuentos.id_paquete != 366
                                        || descuentos.id_paquete != 367

                                        || descuentos.id_paquete != 370
                                        || descuentos.id_paquete != 373
                                        || descuentos.id_paquete != 378

                                    ) {
                                        $scope.descDateEnero = 0;
                                        $scope.noPagomensualidad = 0;
                                        $scope.descMSI = 0;
                                        $scope.descDateOctubre = 0;
                                        $scope.descDateMayoMerida = 0;
                                        $scope.descDateSeptiembreMerida = 0;
                                        $scope.descDateEneroMerida = 0;
                                        $scope.descDateEneroMeridaC = 0;
                                        $scope.descDateMayoMeridaC = 0;
                                        $scope.descDateSeptiembreMeridaC = 0;
                                        $scope.descDateEneroLM1 = 0;
                                        $scope.descDateEneroLM2 = 0;
                                        $scope.descDateEneroLM3 = 0;
                                        $scope.descDateSepLM4 = 0;


                                        $scope.descDateEneroLM1C = 0;
                                        $scope.descDateEneroLM2C = 0;
                                        $scope.descDateSepLM3C = 0;
                                        $scope.descDateSepLM4C = 0;

                                        $scope.descDateEneroL1 = 0;
                                        $scope.descDateEneroL2 = 0;
                                        $scope.descDateEneroL3 = 0;
                                        $scope.descDateEneroL4 = 0;
                                        $scope.descDateSepL1 = 0;

                                        $scope.descDateEneroL5 = 0;
                                        $scope.descDateEneroL6 = 0;
                                        $scope.descDateEneroL7 = 0;
                                        $scope.descDateSepL2 = 0;
                                        $scope.descDateSepL3 = 0;

                                        $scope.descDateEneroL8 = 0;
                                        $scope.descDateEneroL9 = 0;
                                        $scope.descDateSepL4 = 0;
                                        $scope.descDateSepL5 = 0;


                                        $scope.descDateEneroAllQro1 = 0;
                                        $scope.descDateEneroAllQro2 = 0;
                                        $scope.descDateSepAllQro1 = 0;
                                        $scope.descDateSepAllQro2 = 0;
                                        $scope.descDateMayoAllQro1 = 0;
                                        $scope.descDateMayoAllQro2 = 0;


                                        $scope.descDateMayoSLP = 0;
                                        $scope.engancheCincoMil = 0;
                                        $scope.engancheVeintiCincoMilMerida = 0;

                                        $scope.engancheCincoMilLM = 0;
                                        $scope.engancheVeintiCincoMilLM = 0;
                                        $scope.engancheCincoMilL1 = 0;
                                        $scope.engancheCincoMilL2 = 0;
                                        $scope.engancheVeintiCincoMilL = 0;


                                        $scope.helpMxMerida1 = 0;
                                        $scope.helpMxMerida2 = 0;
                                        $scope.helpMxMerida3 = 0;
                                        $scope.helpMxMerida4 = 0;

                                        $scope.descDateEneroS1YS2 = 0;
                                        $scope.descDateEng0S1YS2 = 0;
                                        $scope.engancheDiezMilLSLP = 0;

                                        $scope.cinco_milM = 0;
                                        $scope.veinteJ_milM = 0;
                                        $scope.diez_milM = 0;


                                        $scope.cinco_milL = 0;
                                        $scope.diez_milL = 0;
                                        $scope.veinticinco_milL = 0;

                                        $scope.cinco_milLM = 0;
                                        $scope.veinticinco_milLM = 0;


                                        $scope.ceroQ1 = 0;
                                        $scope.ceroQ2 = 0;
                                        $scope.ceroQ3 = 0;
                                        $scope.ceroQ4 = 0;

                                        $scope.cyd_slp1 = 0;
                                        $scope.cyd_slp2 = 0;


                                        $scope.cincoCSLP = 0;

                                        $scope.veinticinco_milLM2 = 0;
                                        $scope.cincoCL = 0;


                                    }

                                }

                            }
                            //  console.log("El valor del indez del arreglo es: "+idx);
                            calcularCF();
                        }
                        //Termina Reinicia los valores del arreglo que trae descuentos
                        console.log("contrucción: ", parseInt(tipo_casa.total_const));
                        console.log("terreno: ", response.data[0].total);
                        console.log("Total const+terreno: ", (parseInt(tipo_casa.total_const )+ response.data[0].total));
                        $scope.superficie = response.data[0].sup;
                        $scope.preciom2 = response.data[0].precio;
                        $scope.total = response.data[0].total;
                        $scope.porcentajeInv = response.data[0].porcentaje;
                        $scope.enganche = response.data[0].enganche;
                        $scope.CurrentDate = new Date();

                        $scope.nombreLote = response.data[0].nombreLote;
                        $scope.precioTotal = response.data[0].total;
                        $scope.superficie = response.data[0].sup;
                        $scope.preciom2 = response.data[0].precio;

                        $scope.banco = response.data[0].banco;
                        $scope.rsocial = response.data[0].empresa;
                        $scope.cuenta = response.data[0].cuenta;
                        $scope.clabe = response.data[0].clabe;
                        $scope.referencia = response.data[0].referencia;
                        $scope.msni = response.data[0].msni;
                        calcularCF();


                        //Reset vars from eng days
                        var apartado = angular.element( document.querySelector( '#aptdo' ) );
                        var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );
                        var checkPack = angular.element( document.querySelector('#checkPack') );
                        var cehboxInterno = angular.element( document.querySelector('#paquete.id_paquete') );
                        var porcentajeEnganche = angular.element( document.querySelector('#porcentajeEnganche') );
                        var cantidadEnganche   =  angular.element( document.querySelector('#cantidadEnganche') );
                        $scope.diasEnganche=[{day: 7}, {day: 25}, {day: 'Diferido'}];
                        $scope.cantidad="";
                        porcentajeEnganche.val('10');
                        apartado.val('0');
                        $scope.porcentajeEng = "10";
                        cantidadEnganche.val(response.data[0].enganche);
                        mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');


                        calcularCF();

                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                        $http.post('<?=base_url()?>index.php/corrida/descuentos',{lote: response.data[0].idLote}).then(

                            function(paquetes){
                                $scope.paquetes = paquetes.data;
                                localStorage.setItem('allPackages', JSON.stringify(paquetes.data));
                            },
                            function(paquetes){
                            });
////////////////////////////////////////////////////////////////////////////////////////////////////////

                    },
                    function (response) {
                    });
                    haciendoo...*/


                $http.post('<?=base_url()?>index.php/corrida/getCoordinadorByID', {coordinador: <?php echo $data_corrida->id_coordinador;?>}).then(
                    function (response) {
                        $scope.coordinadores = response.data;
                    },
                    function (response) {
                    });

                $http.post('<?=base_url()?>index.php/corrida/getAsesorByID', {asesor: <?php echo $data_corrida->id_asesor;?>}).then(
                    function (response) {
                        $scope.asesores = response.data;
                    },
                    function (response) {
                    });

                $scope.provFTRE = function(){
                    calcularCF();
                };
                
                $http.post('<?=base_url()?>index.php/corrida/getCondominioDisponibleA', {residencial: <?php echo $data_corrida->idResidencial;?>}).then(
                    function (response) {

                        $scope.condominios = response.data;

                        $http.post('<?=base_url()?>index.php/queryInventario/getLoteDisponibleA', {condominio: <?php echo $data_corrida->idCondominio;?>}).then(
                            function (response) {
                                // $scope.lotes.push(response.data);
                                $scope.lotes = response.data.map(function (task, index, array) {
                                    return {nombreLote:task.nombreLote, idLote:task.idLote};
                                });
                                // console.log($scope.lotes);


                                $http.post('<?=base_url()?>index.php/queryInventario/getLotesToEdit', {id_lote: <?php echo $data_corrida->id_lote;?>, tipo_casa:<?=($data_corrida->tipo_casa != null) ?  $data_corrida->tipo_casa : '{}' ?>}).then(
                                    function(response){
                                        $scope.lotes.push(response.data[0]);


                                        $scope.superficie = <?php echo $data_corrida->sup;?>;
                                        $scope.preciom2 = <?php echo $data_corrida->precio_m2_final;?>;
                                        $scope.total = <?php echo $data_corrida->total;?>;
                                        $scope.porcentajeInv = <?php echo $data_corrida->porcentaje;?>;
                                        $scope.observaciones = <?php echo $data_corrida->observaciones; ?>

                                        const dateCurrent = '<?php echo $data_corrida->fecha_creacion;?>';
                                        var nueva=dateCurrent.split(" ")[0].split("-").reverse().join("-");
                                        var fecha_final =  nueva.split("-").reverse().join("-");
                                        $scope.CurrentDate = new Date('"'+fecha_final+'"');

                                        $scope.enganche = <?php echo $data_corrida->cantidad_enganche; ?>;
                                        //angular.element(document.querySelector('#porcentajeEnganche')).val(<?php //echo $data_corrida->porcentaje_enganche; ?>//);
                                        //angular.element(document.querySelector('#cantidadEnganche')).val(<?php //echo $data_corrida->pago_enganche; ?>//);
                                        var apartado = angular.element(document.querySelector('#aptdo'));
                                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));
                                        apartado.val(<?php echo $data_corrida->apartado;?>);
                                        //mesesdiferidos.val(<?php //echo $data_corrida->meses_diferiruyhg ?>//);

                                        $scope.age_plan = <?php echo $data_corrida-> anio?>;
                                        $scope.fechaPM = ' <?php echo $data_corrida-> primer_mensualidad?>';
                                        console.log('fecha_inicio_mensualidad', $scope.fechaPM);

                                        // $scope.age_plan = $scope.yearplan.yearplan;
                                        descuentosAplicados = [];
                                        $scope.selected = {};
                                        $scope.porcentaje = $scope.porcentajeEng = 0;
                                        $scope.descDateEnero = 0;
                                        $scope.noPagomensualidad = 0;
                                        $scope.descMSI = 0;

                                        $scope.descDateOctubre = 0;


                                        $scope.descDateEneroMerida = 0;
                                        $scope.descDateMayoMerida = 0;
                                        $scope.descDateSeptiembreMerida = 0;

                                        $scope.descDateEneroMeridaC = 0;
                                        $scope.descDateMayoMeridaC = 0;
                                        $scope.descDateSeptiembreMeridaC = 0;


                                        $scope.descDateEneroLM1 = 0;
                                        $scope.descDateEneroLM2 = 0;
                                        $scope.descDateEneroLM3 = 0;
                                        $scope.descDateSepLM4 = 0;


                                        $scope.descDateEneroLM1C = 0;
                                        $scope.descDateEneroLM2C = 0;
                                        $scope.descDateSepLM3C = 0;
                                        $scope.descDateSepLM4C = 0;


                                        $scope.descDateEneroL1 = 0;
                                        $scope.descDateEneroL2 = 0;
                                        $scope.descDateEneroL3 = 0;
                                        $scope.descDateEneroL4 = 0;
                                        $scope.descDateSepL1 = 0;


                                        $scope.descDateEneroL5 = 0;
                                        $scope.descDateEneroL6 = 0;
                                        $scope.descDateEneroL7 = 0;
                                        $scope.descDateSepL2 = 0;
                                        $scope.descDateSepL3 = 0;

                                        $scope.descDateEneroL8 = 0;
                                        $scope.descDateEneroL9 = 0;
                                        $scope.descDateSepL4 = 0;
                                        $scope.descDateSepL5 = 0;


                                        $scope.descDateEneroAllQro1 = 0;
                                        $scope.descDateEneroAllQro2 = 0;
                                        $scope.descDateSepAllQro1 = 0;
                                        $scope.descDateSepAllQro2 = 0;
                                        $scope.descDateMayoAllQro1 = 0;
                                        $scope.descDateMayoAllQro2 = 0;


                                        $scope.descDateMayoSLP = 0;

                                        $scope.engancheCincoMil = 0;
                                        $scope.engancheVeintiCincoMilMerida = 0;

                                        $scope.engancheCincoMilLM = 0;
                                        $scope.engancheVeintiCincoMilLM = 0;
                                        $scope.engancheCincoMilL1 = 0;
                                        $scope.engancheCincoMilL2 = 0;
                                        $scope.engancheVeintiCincoMilL = 0;


                                        $scope.helpMxMerida1 = 0;
                                        $scope.helpMxMerida2 = 0;
                                        $scope.helpMxMerida3 = 0;
                                        $scope.helpMxMerida4 = 0;

                                        $scope.descDateEneroS1YS2 = 0;
                                        $scope.descDateEng0S1YS2 = 0;

                                        $scope.engancheDiezMilLSLP = 0;


                                        $scope.cinco_milM = 0;
                                        $scope.veinteJ_milM = 0;
                                        $scope.diez_milM = 0;

                                        $scope.cinco_milL = 0;
                                        $scope.diez_milL = 0;
                                        $scope.veinticinco_milL = 0;

                                        $scope.cinco_milLM = 0;
                                        $scope.veinticinco_milLM = 0;
                                        $scope.veinticinco_milLM2 = 0;


                                        $scope.ceroQ1 = 0;
                                        $scope.ceroQ2 = 0;
                                        $scope.ceroQ3 = 0;
                                        $scope.ceroQ4 = 0;


                                        $scope.cyd_slp1 = 0;
                                        $scope.cyd_slp2 = 0;

                                        $scope.cincoCSLP = 0;
                                        $scope.cincoCL = 0;


                                        $scope.superficie = response.data[0].sup;
                                        $scope.preciom2 = response.data[0].precio;
                                        $scope.total = response.data[0].total;
                                        $scope.porcentajeInv = response.data[0].porcentaje;
                                        $scope.enganche = response.data[0].enganche;
                                        $scope.CurrentDate = new Date();

                                        $scope.nombreLote = response.data[0].nombreLote;
                                        $scope.precioTotal = response.data[0].total;
                                        $scope.superficie = response.data[0].sup;
                                        $scope.preciom2 = response.data[0].precio;

                                        $scope.banco = response.data[0].banco;
                                        $scope.rsocial = response.data[0].empresa;
                                        $scope.cuenta = response.data[0].cuenta;
                                        $scope.clabe = response.data[0].clabe;
                                        $scope.referencia = response.data[0].referencia;
                                        $scope.msni = parseInt(response.data[0].msni);
                                        /*setTimeout(function(){
                                            calcularCF();
                                        }, 1000)*/
                                        setAgePlan(<?php echo $data_corrida->edad;?>);
                                    }
                                );

                                $http.post('<?=base_url()?>index.php/Corrida/getPaquetesByCondominio', {id_condominio: <?php echo $data_corrida->idCondominio;?>, id_corrida: <?php echo $data_corrida->id_corrida;?>}).then(
                                    function(response){
                                        // console.log("response: ", response);
                                        // console.log("response: ", response.data.length);
                                        if(response.data.length!=undefined){
                                            $scope.planesAnteriores = response.data;
                                            let qw = JSON.parse(localStorage.getItem('plan_actual'));
                                            // console.log("Que onda xdxd", qw);
                                            // console.log("BLABLABLA: ", $scope.planesAnteriores);
                                            $scope.planesAnteriores.push(qw[0]);
                                        }
                                        // console.log(qw[0]);
                                    }
                                );


                                $http.post('<?=base_url()?>index.php/Asesor/getinfoLoteDisponibleE', {lote: <?php echo $data_corrida->id_lote;?>, tipo_casa:<?=($data_corrida->tipo_casa != null) ?  $data_corrida->tipo_casa : '{}' ?>}).then(
                                    function (response) {
                                        // console.log("zcsdzdzds: ", response);




                                        // $scope.superficie = response.data[0].sup;
                                        // $scope.preciom2 = response.data[0].precio;
                                        // $scope.total = response.data[0].total;
                                        // $scope.porcentajeInv = response.data[0].porcentaje;
                                        // $scope.enganche = response.data[0].enganche;
                                        // $scope.CurrentDate = new Date();
                                        //
                                        // $scope.nombreLote = response.data[0].nombreLote;
                                        // $scope.precioTotal = response.data[0].total;
                                        // $scope.superficie = response.data[0].sup;
                                        // $scope.preciom2 = response.data[0].precio;
                                        //console.log('CAMARA MIS PERRRRRRRRRRROS: ', <?php //echo $data_corrida->tipo_casa; ?>//);
                                        $scope.casaFlag = (<?php echo $data_corrida->tipo_casa; ?>==0) ? 0 : 1;
                                        $scope.banco = response.data[0].banco;
                                        $scope.rsocial = response.data[0].empresa;
                                        $scope.cuenta = response.data[0].cuenta;
                                        $scope.clabe = response.data[0].clabe;
                                        $scope.referencia = response.data[0].referencia;
                                        $scope.msni = parseInt(response.data[0].msni);
                                        // calcularCF(); NO NECESARIO
                                        console.log('Fecha Apartado:', '<?php echo $data_corrida->fechaApartadoCF;?>');
                                        console.log('Fecha Apartado ii:', '<?php echo $data_corrida->fechaApartado;?>');


                                        let fechaApartadoProcess = ('<?php echo $data_corrida->fechaApartadoCF;?>' == 0) ? ('<?php echo $data_corrida->fechaApartado;?>'==null ? 0 : '<?php echo $data_corrida->fechaApartado;?>'): '<?php echo $data_corrida->fechaApartadoCF;?>';

                                        let fecha_pre = (fechaApartadoProcess==0) ? new Date() : new Date(fechaApartadoProcess);
                                        let dia_final = (fecha_pre.getDate() < 10 ) ? '0'+fecha_pre.getDate() : fecha_pre.getDate();
                                        let mes_final = ((fecha_pre.getMonth()-1) < 10) ? '0'+(fecha_pre.getMonth()-1) : (fecha_pre.getMonth()-1);
                                        let fecha_final = fecha_pre.getFullYear()+'-'+ mes_final +'-'+ dia_final;
                                        $scope.fechaApartado = fecha_pre;
                                        console.log('te digo', $scope.fechaApartado);


                                        // $scope.fechaApartado = (fechaApartadoProcess != undefined || fechaApartadoProcess !='NULL' || fechaApartadoProcess !='') ? response.data[0].fechaApartado : fechaApartadoProcess;


                                        if((response.data[0].idStatusContratacion==2 || response.data[0].idStatusContratacion==5) && (response.data[0].idMovimiento==35 || response.data[0].idMovimiento==22 || response.data[0].idMovimiento==62 || response.data[0].idMovimiento==75 || response.data[0].idMovimiento==94) && (<?php echo $this->session->userdata('id_rol');?> == 32 || <?php echo $this->session->userdata('id_rol');?> == 17)){//colocamos las validaciones cuando venga el estatus en esa actual vista
                                            console.log('Vamos a hacerlo', response.data[0].idStatusLote);
                                            document.getElementById("labelFA").innerHTML = '<label><span class="required-label" style="color:#32D74C;vertical-align: text-bottom;">&bull;</span> Fecha Apartado:</label>';
                                            document.getElementById("labelFA").innerHTML += '<input type="date" ng-model="fechaApartado" ng-change="provFTRE()" class="form-control" value="{{$scope.fechaApartado | date:\'yyyy-MM-dd\'}}" id="fechaApartado">\n';
                                            $compile( document.getElementById('labelFA') )($scope);
                                        }else{
                                            $('#fechaApartado').attr('readonly',true);
                                            document.getElementById("labelFA").innerHTML = '<label>Fecha Apartado</label>';
                                            document.getElementById("labelFA").innerHTML += '<input type="date" ng-model="fechaApartado" class="form-control" value="{{$scope.fechaApartado | date:\'yyyy-MM-dd\'}}" ng-readonly="true" id="fechaApartado">\n';
                                            $compile( document.getElementById('labelFA') )($scope);
                                        }


                                        /*Reset vars from eng days*/
                                        var apartado = angular.element(document.querySelector('#aptdo'));
                                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));
                                        var checkPack = angular.element(document.querySelector('#checkPack'));
                                        var cehboxInterno = angular.element(document.querySelector('#paquete.id_paquete'));
                                        var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
                                        var cantidadEnganche = angular.element(document.querySelector('#cantidadEnganche'));
                                        $scope.diasEnganche = [{day: 15}, {day: 30}, {day: 'Diferido'}];
                                        $scope.cantidad = <?php echo $data_corrida->cantidad_enganche;?>;
                                        porcentajeEnganche.val(<?php echo $data_corrida->porcentaje_enganche;?>);
                                        // apartado.val('0');
                                        $scope.day = '<?php echo $data_corrida->dias_pagar_enganche;?>';
                                        $scope.porcentaje = <?php echo $data_corrida->porcentaje_enganche;?>;
                                        $scope.porcentajeEng = <?php echo $data_corrida->porcentaje_enganche;?>;
                                        cantidadEnganche.val(<?php echo $data_corrida->cantidad_enganche;?>);
                                        // mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');
                                        $scope.apartado = <?php ($data_corrida->apartado!= '') ?  $data_corrida->apartado: '0';  ?>
                                            apartado.val(<?php ($data_corrida->apartado!= '') ?  $data_corrida->apartado: '0';  ?>);
                                        $scope.mesesdiferir = <?php echo $data_corrida->meses_diferir;?>;




                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        /*$http.post('<?=base_url()?>index.php/corrida/descuentos', {lote: response.data[0].idLote}).then(
                                            function (paquetes) {
                                                // $scope.paquetes = paquetes.data;
                                            },
                                            function (paquetes) {
                                            });
                                        $scope.descuentosCurrents = <?php echo $data_corrida->detalle_paquete;?>;*/

                                        // console.log("descuentos: ", $scope.descuentosCurrents);


                                        $http.post('<?=base_url()?>index.php/corrida/descuentosCCF', {id_cxl:<?php echo $data_corrida->id_cxl;?>}).then(
                                            function (paquetes) {
                                                $scope.paquetes = paquetes.data;
                                                console.log("Paquetes data: ", $scope.paquetes);
                                                localStorage.setItem('allPackages', JSON.stringify(paquetes.data));
                                                console.log('$scope.paquetes: ', $scope.paquetes.length);

                                                if($scope.paquetes.length>0){
                                                    //hay paquetes
                                                    let marker_determiner = '';
                                                    let position_in_array;
                                                    let paquetes_current_finish='';
                                                    $scope.paquetes.map(function (task, index, array) {

                                                        position_in_array = (index+1);
                                                        if($scope.paquetes.length == position_in_array){marker_determiner = '';}else{marker_determiner = ','}
                                                        paquetes_current_finish += task.id_paquete + marker_determiner;
                                                        /**/task.response.map(function(tarea, indice, arreglo){
                                                            if(tarea.estatus == 1 ){//&& tarea.apply==1

                                                                // console.log("Descuento aplicado "+indice+" ID: "+tarea.id_descuento);
                                                                // console.log("arreglo[indice]: ", arreglo[indice]);
                                                                // selectDescuentos(arreglo[indice], true);
                                                                var idx = descuentosAplicados.indexOf(arreglo[indice]);
                                                                // console.log("YES I DO: ", task.id_paquete);
                                                                if (idx >= 0 && !true) {
                                                                    descuentosAplicados.splice(idx, 1);
                                                                    $scope.descApply = descuentosAplicados;
                                                                }

                                                                if (idx < 0 && true) {
                                                                    descuentosAplicados.push(arreglo[indice]);
                                                                    $scope.descApply = descuentosAplicados;
                                                                }
                                                                // console.log("$scope.descApply: ", $scope.descApply);
                                                                // calcularCF();
                                                            }
                                                        });
                                                    });

                                                    let cfr = [];
                                                    $scope.current_plan = {
                                                        fecha_fin: '',
                                                        fecha_inicio : '',
                                                        id_condominio : <?php echo $data_corrida->idCondominio;?>,
                                                        id_pxc : 0,
                                                        nombre : 'Descuentos actules de la corrida <?php echo $data_corrida->id_corrida?>',
                                                        id_paquete : paquetes_current_finish,
                                                    };
                                                    cfr[0]=$scope.current_plan;
                                                    localStorage.setItem('plan_actual', JSON.stringify(cfr));
                                                    // console.log("$scope.current_plan:  ", varalv);
                                                }else{
                                                    //no hay paquetes aún así ejecuta la corrida
                                                    // calcularCF();
                                                    console.log('olv');
                                                }
                                                console.log("FINISH");
                                                console.log("$scope.day: ", $scope.day );
                                                console.log("$scope.apartado: ", $scope.apartado );
                                                console.log("$scope.mesesdiferir: ", $scope.mesesdiferir );
                                                $scope.changeDaysEng();



                                            },
                                            function (paquetes) {
                                            });
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////

                                    },
                                    function (response) {
                                    });



                            },
                            function (response) {
                            });

                    },
                    function (response) {
                    });



                // console.log("Datos: ", datos);
                // console.log("Lotes: ", $scope.lotes);
                /*$scope.gerente = 'ADRIANA MAÑAS';
                $scope.nombre = '<?php echo $data_corrida->nombre;?>';
                $scope.nombre = '<?php echo $data_corrida->nombre;?>';*/
            }

            // $scope.$watch('fechaApartado', function() {
            //     calcularCF();
            // }, true);

            function setAgePlan(currentAge){
                $scope.age_view = $scope.age.age;
                let age = currentAge;
                if (age <= 60) {


                    $scope.yearsplan = [{yearplan: 20}, {yearplan: 19}, {yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 61) {

                    $scope.yearsplan = [{yearplan: 19}, {yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 62) {

                    $scope.yearsplan = [{yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 63) {

                    $scope.yearsplan = [{yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 64) {

                    $scope.yearsplan = [{yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 65) {

                    $scope.yearsplan = [{yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]
                } else if (age == 66) {

                    $scope.yearsplan = [{yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 67) {

                    $scope.yearsplan = [{yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 68) {

                    $scope.yearsplan = [{yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 69) {

                    $scope.yearsplan = [{yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 70) {

                    $scope.yearsplan = [{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 71) {

                    $scope.yearsplan = [{yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 72) {

                    $scope.yearsplan = [{yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 73) {

                    $scope.yearsplan = [{yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 74) {

                    $scope.yearsplan = [{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 75) {

                    $scope.yearsplan = [{yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 76) {

                    $scope.yearsplan = [{yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 77) {

                    $scope.yearsplan = [{yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 78) {

                    $scope.yearsplan = [{yearplan: 2}, {yearplan: 1}]

                } else if (age == 79 || age == 80) {

                    $scope.yearsplan = [{yearplan: 1}]

                }
            }



            // $scope.mesesdiferir = 0;

            $scope.resultCantidad = function () {
                $scope.uno = parseFloat($scope.cantidad);
                $scope.dos = ($scope.uno / $scope.total);
                $scope.result = ($scope.dos * parseFloat(100));
                $scope.cantidadFR = parseFloat($scope.result.toFixed(6));
                $scope.porcentajeEng = $scope.cantidadFR;

                //comienza nueva funcion
                var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
                var cantidadEnganche = angular.element(document.querySelector('#cantidadEnganche'));
                var r1 = $scope.total;
                var cantidadToGetP = ((100 * cantidadEnganche.val()) / r1);
                porcentajeEnganche.val(parseFloat(cantidadToGetP).toFixed(2));
                $scope.porcentaje = parseFloat(cantidadToGetP).toFixed(2);
                //termina nueva sección

                if(porcentajeEnganche.val() == 10 || porcentajeEnganche.val() == 5){
                    document.getElementById("day").disabled = false;
                    document.getElementById("aptdo").disabled = false;
                    document.getElementById("msdif").disabled = false;
                }else{
                    document.getElementById("day").disabled = true;
                    document.getElementById("aptdo").disabled = true;
                    document.getElementById("msdif").disabled = true;
                }
                calcularCF();
            };

            $scope.changeDescuento = function (){
                let selectedMonth = $scope.mesesAnteriores;
                console.log('get descuentos from this value: ', selectedMonth.id_pxc);
                // let cpf = localStorage.getItem('plan_actual');
                // console.log(JSON.parse(cpf));


                if(selectedMonth.id_pxc>0){
                    $scope.paquetes = [];
                    descuentosAplicados = [];
                    $scope.descApply = undefined;
                    angular.element("#skeleton").removeClass('hide');
                    calcularCF();
                    $http.post('<?=base_url()?>index.php/corrida/getDescsByCondominio', {id_condominio:<?php echo $data_corrida->idCondominio;?>, id_pxc:selectedMonth.id_pxc}).then(
                        function (paquetes) {
                            //Superficie
                            /**
                             * 1.-Mayor a
                             * 2.-Rango
                             * 3.-Cualquiera
                             */
                            let paquetesRes = paquetes.data;
                            let paquetes_final= [];
                            let currentSup = $scope.superficie;
                            console.log('Original: ', paquetesRes);
                            paquetesRes.map((element, index)=>{
                                if(element.aplicable_a == 1){
                                    if(element.sup1 > currentSup){
                                        paquetes_final.push(element);
                                    }
                                }else if(element.aplicable_a == 2){
                                    if(currentSup >= element.sup1 && currentSup <= element.sup2){
                                        paquetes_final.push(element);
                                    }
                                }else if(element.aplicable_a == 3){
                                    paquetes_final.push(element);
                                }else{
                                    paquetes_final=[];
                                }
                                // console.log("Paquete ",index, ': ', element);
                            });

                            console.log("Response: ", paquetes_final);
                            angular.element("#skeleton").addClass('hide');
                            localStorage.setItem('allPackages', JSON.stringify(paquetes_final));//original: paquetes.data
                            $scope.paquetes = paquetes_final;//original: paquetes.data

                            //esto no se ejecuta porque no se cargan automaticamente los descuentos
                            /**/
                            /**/


                        });
                }
                else{
                    $scope.paquetes = [];
                    descuentosAplicados = [];
                    $scope.descApply = undefined;
                    angular.element("#skeleton").removeClass('hide');
                    $http.post('<?=base_url()?>index.php/corrida/descuentosCCF', {id_cxl:<?php echo $data_corrida->id_cxl;?>}).then(
                        function (paquetes) {

                            localStorage.setItem('allPackages', JSON.stringify(paquetes.data));
                            $scope.paquetes = paquetes.data;
                            if(paquetes.data.length > 0){
                                $scope.paquetes.map(function (task, index, array) {


                                    /**/task.response.map(function(tarea, indice, arreglo){
                                        if(tarea.estatus == 1 ){//&& tarea.apply==1

                                            // console.log("Descuento aplicado "+indice+" ID: "+tarea.id_descuento);
                                            // console.log("arreglo[indice]: ", arreglo[indice]);
                                            // selectDescuentos(arreglo[indice], true);
                                            var idx = descuentosAplicados.indexOf(arreglo[indice]);
                                            // console.log("YES I DO: ", task.id_paquete);
                                            if (idx >= 0 && !true) {
                                                descuentosAplicados.splice(idx, 1);
                                                $scope.descApply = descuentosAplicados;
                                            }

                                            if (idx < 0 && true) {
                                                descuentosAplicados.push(arreglo[indice]);
                                                $scope.descApply = descuentosAplicados;
                                            }
                                            // console.log("$scope.descApply: ", $scope.descApply);
                                            calcularCF();
                                            angular.element("#skeleton").addClass('hide');
                                        }
                                    });
                                });
                            }else{
                                calcularCF();
                                angular.element("#skeleton").addClass('hide');
                            }

                            /*FALTA AGREGAR AL ARBOL DE DOCUMENTOS*/






                        },
                        function (paquetes) {

                        });
                }


            };


            $scope.selected = {};

            $scope.porcentaje = $scope.porcentajeEng = 0;

            $scope.selectDescuentos = function (descuento, checked) {
                // console.log("Descuento: ", descuento);
                // console.log("Checked: ", checked);
                console.log("paquetes_back: ", descuento);

                // $scope.msni = $scope.msni + 2;

                var idx = descuentosAplicados.indexOf(descuento);
                if (idx >= 0 && !checked) {
                    descuentosAplicados.splice(idx, 1);
                    $scope.descApply = descuentosAplicados;
                    console.log("TEST: ", descuento);
                }

                if (idx < 0 && checked) {
                    descuentosAplicados.push(descuento);
                    $scope.descApply = descuentosAplicados;
                    console.log("TEST II: ", descuento);

                }
                console.log("$scope.descApply: ", $scope.descApply);

                calcularCF();

            }


            function calcularCF() {



                ///////////////////////////////////////


                var applyTotal = descuentosAplicados.filter(function (condicion) {
                    console.log("inside applyTotal CF: ", condicion);
                    return condicion.apply == '1';
                });
                // console.log(applyTotal);


                var orderTotal = applyTotal.sort((a, b) => a.prioridad - b.prioridad)


                //////////////////////////////////////

                var applyEnganche = descuentosAplicados.filter(function (condicion) {
                    return condicion.apply == '0';
                });

                var orderEnganche = applyEnganche.sort((a, b) => a.prioridad - b.prioridad)


                ///////////////////////////////////////////


                var porcentaje1 = 0;
                var porcentaje2 = 0;
                var porcentajeDeEnganche = $scope.porcentajeEng;
                var r1 = $scope.total;
                var descEng = 0;
                var enganche = 0;
                var supLote = $scope.superficie;
                var msi = parseInt($scope.msni);


                ////////////////////////////// VARIABLES DESCRIPCION DE DESCUENTOS

                var a = 0;
                var b = 0;
                var c = 0;
                var e = 0;
                var f = 0;
                var g = 0;
                var tot = $scope.total;
                var arreglo = [];
                var arreglo2 = [];
                var ultimoAhorro = 0;
                var ultimoAhorropt = 0;
                var ultimoAhorropm = 0;


                ////////////////////////// FIN VARIABLES DESCRIPCION DE DESCUENTOS
                console.log("ENGANCHE SISTEMA: ", (r1 * (porcentajeDeEnganche / 100)));
                console.log("ENGANCHE EN CF ACTUAL: ", <?php echo $data_corrida->pago_enganche; ?>);


                if (porcentajeDeEnganche === 0 && orderEnganche.length === 0 && orderTotal.length === 0) {

                    r1

                    $scope.decFin = [];

                }
                else if (porcentajeDeEnganche != 0 && orderEnganche.length === 0 && orderTotal.length === 0) {


                    $scope.decFin = [];

                    enganche =  (r1 * (porcentajeDeEnganche / 100)); /*<?php echo $data_corrida->pago_enganche; ?>*/
                    r1 = (r1 - enganche);


                }
                else if (porcentajeDeEnganche != 0 && orderEnganche.length > 0 && orderTotal.length === 0) {

                    enganche = (r1 * (porcentajeDeEnganche / 100)); /*<?php echo $data_corrida->pago_enganche; ?>*/
                    r1 = (r1 - enganche);

                    angular.forEach(orderEnganche, function (item, index) {
                        console.log('item: ', item);
                        porcentaje1 = (item.porcentaje / 100);
                        porcentaje2 = (enganche * porcentaje1);

                        descEng = porcentaje2;


                        ////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////
                        if (item.eng_top == 1) {
                            if (descEng > 20000) {
                                descEng = 20000;
                                enganche = (enganche - descEng);
                            } else {
                                descEng = porcentaje2;
                                enganche = (enganche - descEng);
                            }
                        } else {
                            descEng = porcentaje2;
                            enganche = (enganche - descEng);
                        }
                        ////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////


                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
                        a += descEng;
                        b = (tot - a);
                        c = (b / supLote);
                        arreglo.push({
                            ahorro: a,
                            pm: c,
                            pt: b,
                            td: 2,
                            porcentaje: item.porcentaje,
                            id_condicion: item.id_condicion
                        });
                        $scope.decFin = arreglo;
                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

                    });

                }
                ////////////////////////////////////////////////////////////
                else if (porcentajeDeEnganche === '0' && orderEnganche.length === 0 && orderTotal.length > 0) {
                    console.log("2");
                    angular.forEach(orderTotal, function (item, index) {

                        if (item.id_condicion == 1 || item.id_condicion == 2) {
                            porcentaje1 = (item.porcentaje / 100);
                            porcentaje2 = (r1 * porcentaje1);
                            r1 -= porcentaje2;
                            msi = msi + item.msi_descuento;
                        }

                        if (item.id_condicion == 3) {
                            porcentaje2 = parseFloat(item.porcentaje);
                            r1 = (r1 - porcentaje2);
                            msi = msi + item.msi_descuento;
                        }


                        if (item.id_condicion == 4) {
                            porcentaje1 = (item.porcentaje);
                            porcentaje2 = (supLote * porcentaje1);
                            r1 -= porcentaje2;
                            msi = msi + item.msi_descuento;
                        }

                        // if(item.id_condicion == 5){
                        // porcentaje1 = (item.porcentaje);
                        // porcentaje2 = (supLote * porcentaje1);
                        // r1 = (parseFloat(r1) + porcentaje2);
                        // }

                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
                        a += porcentaje2;
                        b = (tot - a);
                        c = (b / supLote);
                        arreglo.push({
                            ahorro: a,
                            pm: c,
                            pt: b,
                            td: 1,
                            porcentaje: item.porcentaje,
                            id_condicion: item.id_condicion,
                            msiExtra: item.msi_descuento
                        });
                        $scope.decFin = arreglo;

                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

                    });

                }
                else if (porcentajeDeEnganche != 0 && orderEnganche.length === 0 && orderTotal.length > 0) {

                    console.log('HEY');
                    /*primera validación donde se implemento los msi del paquete*/

                    angular.forEach(orderTotal, function (item, index) {
                        console.log("item: ", item);

                        if (item.id_condicion == 1 || item.id_condicion == 2) {
                            porcentaje1 = (item.porcentaje / 100);
                            porcentaje2 = (r1 * porcentaje1);
                            r1 -= porcentaje2;
                            msi = parseInt(msi + item.msi_descuento);
                        }

                        if (item.id_condicion == 3) {
                            porcentaje2 = parseFloat(item.porcentaje);
                            r1 = (r1 - porcentaje2);
                            msi = parseInt(msi + item.msi_descuento);
                        }


                        if (item.id_condicion == 4) {
                            porcentaje1 = (item.porcentaje);
                            porcentaje2 = (supLote * porcentaje1);
                            r1 -= porcentaje2;
                            msi = parseInt(msi + item.msi_descuento);
                        }
                        //aqui se agrega la validación la operación del bono
                        if(item.id_condicion == 12){
                            console.log('condicion 12');
                            // descuentoM2 = montoBono/supLote
                            porcentaje1 = item.porcentaje;
                            porcentaje2 = (porcentaje1 / supLote);
                            r1 = (r1 - porcentaje1);
                        }
                        if(item.id_condicion == 13){
                            //     console.log('condicion 12 ', item.porcentaje);
                            //     // descuentoM2 = montoBono/supLote
                            console.log('condicion 13');

                            porcentaje1 = (item.porcentaje);
                            porcentaje2 = (supLote * porcentaje1);
                            r1 = (r1 - porcentaje2);
                            msi = parseInt(msi + item.msi_descuento);
                            //     console.log("condicion12 alv: ", r1);
                        }


                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
                        if(item.id_condicion==12){
                            console.log('descuento de chuy');
                            a +=  porcentaje1;
                            b = r1;
                            // d = (tot - porcentaje2);
                            e = b/supLote;
                            c -=  porcentaje2;
                        }else{
                            console.log('logica normal');
                            a +=  porcentaje2;
                            b = (tot - a);
                            c = (b/supLote);
                        }
                        arreglo.push({
                            ahorro: a,
                            pm: (item.id_condicion==12 && orderTotal.length==1) ? e : c,
                            pt: b,
                            td: 1,
                            porcentaje: item.porcentaje,
                            id_condicion: item.id_condicion,
                            msiExtra: item.msi_descuento
                        });
                        $scope.decFin = arreglo;

                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////


                    });


                    if ($scope.engancheCincoMil == 1 || $scope.engancheVeintiCincoMilMerida == 1 || $scope.engancheCincoMilLM == 1 || $scope.engancheVeintiCincoMilLM == 1
                        || $scope.engancheCincoMilL1 == 1 || $scope.engancheCincoMilL2 == 1 || $scope.engancheVeintiCincoMilL == 1 || $scope.descDateMayoAllQro1 == 1 || $scope.descDateMayoAllQro2 == 1
                        || $scope.descDateEng0S1YS2 == 1 || $scope.engancheDiezMilLSLP == 1 || $scope.cinco_milM == 1 || $scope.veinteJ_milM == 1 || $scope.diez_milM == 1
                        || $scope.cinco_milL == 1 || $scope.diez_milL == 1 || $scope.veinticinco_milL == 1
                        || $scope.cinco_milLM == 1 || $scope.veinticinco_milLM == 1 || $scope.ceroQ1 == 1 || $scope.ceroQ2 == 1
                        || $scope.ceroQ3 == 1 || $scope.ceroQ4 == 1 || $scope.cyd_slp1 == 1 || $scope.cyd_slp2 == 1 || $scope.cincoCSLP == 1
                        || $scope.veinticinco_milLM2 == 1 || $scope.cincoCL == 1) {

                        var cantidadEngancheCincoMil = angular.element(document.querySelector('#cantidadEnganche'));
                        enganche = (cantidadEngancheCincoMil.val() * 1);
                        r1 = (r1 - enganche);


                    } else if ($scope.engancheCincoMil == 0 && $scope.engancheVeintiCincoMilMerida == 0 && $scope.engancheCincoMilLM == 0
                        && $scope.engancheVeintiCincoMilLM == 0 && $scope.engancheCincoMilL1 == 0 && $scope.engancheCincoMilL2 == 0 && $scope.engancheVeintiCincoMilL == 0
                        && $scope.descDateMayoAllQro1 == 0 && $scope.descDateMayoAllQro2 == 0 && $scope.descDateEng0S1YS2 == 0 && $scope.engancheDiezMilLSLP == 0
                        && $scope.cinco_milM == 0 && $scope.veinteJ_milM == 0 && $scope.diez_milM == 0
                        && $scope.cinco_milL == 0 && $scope.diez_milL == 0 && $scope.veinticinco_milL == 0
                        && $scope.cinco_milLM == 0 && $scope.veinticinco_milLM == 0 && $scope.ceroQ1 == 0 && $scope.ceroQ2 == 0
                        && $scope.ceroQ3 == 0 && $scope.ceroQ4 == 0 && $scope.cyd_slp1 == 0 && $scope.cyd_slp2 == 0 && $scope.cincoCSLP == 0
                        && $scope.veinticinco_milLM2 == 0 && $scope.cincoCL == 0) {

                        enganche = (r1 * (porcentajeDeEnganche / 100));
                        //enganche = <?php //echo $data_corrida->pago_enganche; ?>//; /*(r1 * (porcentajeDeEnganche / 100))*/
                        r1 = (r1 - enganche);
                    }


                }
                else if (porcentajeDeEnganche != 0 && orderEnganche.length > 0 && orderTotal.length > 0) {

                    angular.forEach(orderTotal, function (item, index) {

                        if (item.id_condicion == 1 || item.id_condicion == 2) {
                            porcentaje1 = (item.porcentaje / 100);
                            porcentaje2 = (r1 * porcentaje1);
                            r1 -= porcentaje2;
                            msi = parseInt(msi + item.msi_descuento);

                        }


                        if (item.id_condicion == 3) {
                            porcentaje2 = parseFloat(item.porcentaje);
                            r1 = (r1 - porcentaje2);
                            msi = parseInt(msi + item.msi_descuento);
                        }


                        if (item.id_condicion == 4) {
                            porcentaje1 = (item.porcentaje);
                            porcentaje2 = (supLote * porcentaje1);
                            r1 -= porcentaje2;
                            msi = parseInt(msi + item.msi_descuento);
                        }

                        if(item.id_condicion == 12){
                            // descuentoM2 = montoBono/supLote
                            porcentaje1 = item.porcentaje;
                            porcentaje2 = (porcentaje1 / supLote);
                            r1 -= porcentaje1;
                        }
                        if(item.id_condicion == 13){
                            porcentaje1 = (item.porcentaje);
                            porcentaje2 = (supLote * porcentaje1);
                            r1 -= porcentaje2;
                            msi = parseInt(msi + item.msi_descuento);
                        }

                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
                        if(item.id_condicion == 12){
                            a +=  porcentaje1;
                            b = r1;
                            e = b/supLote;
                            c -=  porcentaje2;
                        }else{
                            a +=  porcentaje2;
                            b = r1;
                            c = (b/supLote);
                        }
                        arreglo.push({
                            ahorro: a,
                            pm: c,
                            pt: b,
                            td: 1,
                            porcentaje: item.porcentaje,
                            id_condicion: item.id_condicion,
                            msiExtra: item.msi_descuento
                        });
                        $scope.add = arreglo;
                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

                    });


                    enganche = (r1 * (porcentajeDeEnganche / 100));
                    //enganche = <?php //echo $data_corrida->pago_enganche; ?>//; /*(r1 * (porcentajeDeEnganche / 100))*/
                    r1 = (r1 - enganche);

                    angular.forEach(orderEnganche, function (item, index) {
                        porcentaje1 = (item.porcentaje / 100);
                        porcentaje2 = (enganche * porcentaje1);
                        descEng = porcentaje2;

                        ////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////
                        if (item.eng_top == 1) {
                            if (descEng > 20000) {
                                descEng = 20000;
                                enganche = (enganche - descEng);
                            } else {
                                descEng = porcentaje2;
                                enganche = (enganche - descEng);
                            }
                        } else {
                            descEng = porcentaje2;
                            enganche = (enganche - descEng);
                        }
                        ////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////


                        $scope.desc2 = ($scope.desc1 + descEng);
                        $scope.desc1t2 = ($scope.desc1t - descEng);
                        $scope.desc1m2 = ($scope.desc1t2 / supLote);


                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

                        ultimoAhorro = $scope.add[$scope.add.length - 1].ahorro;
                        ultimoAhorropt = $scope.add[$scope.add.length - 1].pt;
                        ultimoAhorropm = $scope.add[$scope.add.length - 1].pm;
                        e = (ultimoAhorro + descEng);
                        f = (ultimoAhorropt - descEng);
                        g = (f / supLote);
                        arreglo2.push({
                            ahorro: e,
                            pm: g,
                            pt: f,
                            td: 2,
                            porcentaje: item.porcentaje,
                            id_condicion: item.id_condicion
                        });
                        $scope.add2 = arreglo2;
                        $scope.decFin = $scope.add.concat($scope.add2);

                        ///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

                    });
                }


                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                var ini;
                var ini2;
                var ini3;

                //INICIO FECHA
                var day;
                var month;
                var yearc;
                if($scope.fechaApartado==null){
                    day = new Date( '<?php echo $data_corrida->primer_mensualidad; ?>').getDate()+1;
                    month = (new Date( '<?php echo $data_corrida->primer_mensualidad; ?>').getMonth() + 1);
                    yearc = new Date( '<?php echo $data_corrida->primer_mensualidad; ?>').getFullYear();
                    console.log('$scope.fechaApartado null', $scope.fechaApartado);
                }else{

                    <?php

                        if($data_corrida->tipoPM == 3){?>
                        day = new Date( '<?php echo $data_corrida->fechaInicioPM; ?>').getDate()+1;
                        month = (new Date('<?php echo $data_corrida->fechaInicioPM; ?>').getMonth() + 1);
                        yearc = new Date('<?php echo $data_corrida->fechaInicioPM; ?>').getFullYear();
                        <?php }else{?>
                        day = new Date('<?php echo $data_corrida->primer_mensualidad; ?>').getDate()+1;
                        month = (new Date('<?php echo $data_corrida->primer_mensualidad; ?>').getMonth() + 1);
                        yearc = new Date('<?php echo $data_corrida->primer_mensualidad; ?>').getFullYear();
                        console.log(<?php echo $data_corrida->primer_mensualidad; ?>);
                    <?php }?>
                    

                }



                /*if (month == 1) {
                    day = '0' + 1;
                }
                if (month == 2) {
                    day = '0' + 2;
                }
                if (month == 3) {
                    day = '0' + 3;
                }
                if (month == 4) {
                    day = '0' + 6;


                }
                if (month == 5) {

                    if ($scope.descDateEnero == 0 && $scope.descDateOctubre == 0 && $scope.descDateMayoMerida == 0 && $scope.descDateSeptiembreMerida == 0 && $scope.descDateEneroMerida == 0
                        && $scope.descDateEneroMeridaC == 0 && $scope.descDateMayoMeridaC == 0 && $scope.descDateSeptiembreMeridaC == 0 && $scope.descDateEneroLM1 == 0 && $scope.descDateEneroLM2 == 0
                        && $scope.descDateEneroLM3 == 0 && $scope.descDateSepLM4 == 0 && $scope.descDateEneroLM1C == 0 && $scope.descDateEneroLM2C == 0 && $scope.descDateSepLM3C == 0 && $scope.descDateSepLM4C == 0
                        && $scope.descDateEneroL1 == 0 && $scope.descDateEneroL2 == 0 && $scope.descDateEneroL3 == 0 && $scope.descDateEneroL4 == 0 && $scope.descDateSepL1 == 0


                        && $scope.descDateEneroL5 == 0 && $scope.descDateEneroL6 == 0 && $scope.descDateEneroL7 == 0 && $scope.descDateSepL2 == 0 && $scope.descDateSepL3 == 0
                        && $scope.descDateEneroL8 == 0 && $scope.descDateEneroL9 == 0 && $scope.descDateSepL4 == 0 && $scope.descDateSepL5 == 0


                        && $scope.descDateEneroAllQro1 == 0 && $scope.descDateEneroAllQro2 == 0 && $scope.descDateSepAllQro1 == 0 && $scope.descDateSepAllQro2 == 0
                        && $scope.descDateMayoAllQro1 == 0 && $scope.descDateMayoAllQro2 == 0

                        && $scope.descDateMayoSLP == 0 && $scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0


                        && $scope.engancheCincoMilLM == 0 && $scope.engancheVeintiCincoMilLM == 0 && $scope.engancheCincoMilL1 == 0 && $scope.engancheCincoMilL2 == 0 && $scope.engancheVeintiCincoMilL == 0

                        && $scope.descDateEneroS1YS2 == 0

                    ) {
                        day = '0' + 7;
                    } else if ($scope.descDateEnero == 1 || $scope.descDateEneroMerida == 1 || $scope.descDateEneroMeridaC == 1 || $scope.descDateEneroLM1 == 1 || $scope.descDateEneroLM2 == 1
                        || $scope.descDateEneroLM3 == 1 || $scope.descDateEneroLM1C == 1 || $scope.descDateEneroLM2C == 1

                        || $scope.descDateEneroL1 == 1 || $scope.descDateEneroL2 == 1 || $scope.descDateEneroL3 == 1 || $scope.descDateEneroL4 == 1

                        || $scope.descDateEneroL5 == 1 || $scope.descDateEneroL6 == 1 || $scope.descDateEneroL7 == 1 || $scope.descDateEneroL8 == 1
                        || $scope.descDateEneroL9 == 1

                        || $scope.descDateEneroAllQro1 == 1 || $scope.descDateEneroAllQro2 == 1

                        || $scope.descDateEneroS1YS2 == 1

                    ) {
                        day = '0' + 1;
                    } else if ($scope.descDateOctubre == 1) {
                        day = 14;
                    } else if ($scope.descDateMayoMerida == 1 || $scope.descDateMayoMeridaC == 1 || $scope.descDateMayoAllQro1 == 1 || $scope.descDateMayoAllQro2 == 1 || $scope.descDateMayoSLP == 1 || $scope.helpMxMerida1 == 1 || $scope.helpMxMerida2 == 1 || $scope.helpMxMerida3 == 1 || $scope.helpMxMerida4 == 1) {
                        day = '0' + 7;
                    } else if ($scope.descDateSeptiembreMerida == 1 || $scope.descDateSeptiembreMeridaC == 1 || $scope.descDateSepLM4 == 1 || $scope.descDateSepLM3C == 1 || $scope.descDateSepLM4C == 1 || $scope.descDateSepL1 == 1

                        || $scope.descDateSepL2 == 1 || $scope.descDateSepL3 == 1 || $scope.descDateSepL4 == 1 || $scope.descDateSepL5 == 1

                        || $scope.descDateSepAllQro1 == 1 || $scope.descDateSepAllQro2 == 1

                    ) {
                        day = 13;
                    } else if ($scope.engancheCincoMilLM == 1 || $scope.engancheVeintiCincoMilLM == 1 || $scope.engancheCincoMilL1 == 1 || $scope.engancheCincoMilL2 == 1 || $scope.engancheVeintiCincoMilL == 1) {
                        day = '0' + 8;
                    }


                }
                if (month == 6) {
                    day = '0' + 8;
                }
                if (month == 7) {
                    day = 11;
                }
                if (month == 8) {


                    if ($scope.cinco_milLM == 0) {
                        day = 12;
                    } else if ($scope.cinco_milLM == 1) {
                        day = 13;
                    }

                }
                if (month == 9) {
                    day = 13;
                }
                if (month == 10) {
                    day = 14;
                }
                if (month == 11) {

                    if ($scope.descMSI == 1) {
                        day = '0' + 3;
                    } else if ($scope.descMSI == 0) {
                        day = 16;
                    }

                }
                if (month == 12) {
                    day = 17;
                }*/


                if ($scope.descDateEnero == 0 && $scope.descDateOctubre == 0 && $scope.descDateMayoMerida == 0 && $scope.descDateSeptiembreMerida == 0 && $scope.descDateEneroMerida == 0
                    && $scope.descDateEneroMeridaC == 0 && $scope.descDateMayoMeridaC == 0 && $scope.descDateSeptiembreMeridaC == 0 && $scope.descDateEneroLM1 == 0 && $scope.descDateEneroLM2 == 0
                    && $scope.descDateEneroLM3 == 0 && $scope.descDateSepLM4 == 0 && $scope.descDateEneroLM1C == 0 && $scope.descDateEneroLM2C == 0 && $scope.descDateSepLM3C == 0 && $scope.descDateSepLM4C == 0
                    && $scope.descDateEneroL1 == 0 && $scope.descDateEneroL2 == 0 && $scope.descDateEneroL3 == 0 && $scope.descDateEneroL4 == 0 && $scope.descDateSepL1 == 0

                    && $scope.descDateEneroL5 == 0 && $scope.descDateEneroL6 == 0 && $scope.descDateEneroL7 == 0 && $scope.descDateSepL2 == 0 && $scope.descDateSepL3 == 0
                    && $scope.descDateEneroL8 == 0 && $scope.descDateEneroL9 == 0 && $scope.descDateSepL4 == 0 && $scope.descDateSepL5 == 0

                    && $scope.descDateEneroAllQro1 == 0 && $scope.descDateEneroAllQro2 == 0 && $scope.descDateSepAllQro1 == 0 && $scope.descDateSepAllQro2 == 0
                    && $scope.descDateMayoAllQro1 == 0 && $scope.descDateMayoAllQro2 == 0


                    && $scope.descDateMayoSLP == 0 && $scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0


                    && $scope.engancheCincoMilLM == 0 && $scope.engancheVeintiCincoMilLM == 0 && $scope.engancheCincoMilL1 == 0 && $scope.engancheCincoMilL2 == 0 && $scope.engancheVeintiCincoMilL == 0

                    && $scope.descDateEneroS1YS2 == 0 && $scope.cinco_milLM == 0

                    && $scope.descMSI == 0 && $scope.veinteJ_milM == 0 && $scope.cinco_milM == 0 && $scope.veinticinco_milLM2 == 0


                ) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 3);
                } else if ($scope.descDateEnero == 1 || $scope.descDateEneroMerida == 1 || $scope.descDateEneroMeridaC == 1 || $scope.descDateEneroLM1 == 1 || $scope.descDateEneroLM2 == 1
                    || $scope.descDateEneroLM3 == 1 || $scope.descDateEneroLM1C == 1 || $scope.descDateEneroLM2C == 1
                    || $scope.descDateEneroL1 == 1 || $scope.descDateEneroL2 == 1 || $scope.descDateEneroL3 == 1 || $scope.descDateEneroL4 == 1

                    || $scope.descDateEneroL5 == 1 || $scope.descDateEneroL6 == 1 || $scope.descDateEneroL7 == 1 || $scope.descDateEneroL8 == 1 || $scope.descDateEneroL9 == 1
                    || $scope.descDateEneroAllQro1 == 1 || $scope.descDateEneroAllQro2 == 1

                    || $scope.descDateEneroS1YS2 == 1

                ) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 9);
                } else if ($scope.descDateOctubre == 1) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 6);
                } else if ($scope.descDateMayoMerida == 1 || $scope.descDateMayoMeridaC == 1 || $scope.descDateMayoAllQro1 == 1 || $scope.descDateMayoAllQro2 == 1 || $scope.descDateMayoSLP == 1 || $scope.helpMxMerida1 == 1 || $scope.helpMxMerida2 == 1 || $scope.helpMxMerida3 == 1 || $scope.helpMxMerida4 == 1) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 1);
                } else if ($scope.descDateSeptiembreMerida == 1 || $scope.descDateSeptiembreMeridaC == 1 || $scope.descDateSepLM4 == 1 || $scope.descDateSepLM3C == 1 || $scope.descDateSepLM4C == 1 || $scope.descDateSepL1 == 1

                    || $scope.descDateSepL2 == 1 || $scope.descDateSepL3 == 1 || $scope.descDateSepL4 == 1 || $scope.descDateSepL5 == 1
                    || $scope.descDateSepAllQro1 == 1 || $scope.descDateSepAllQro2 == 1

                ) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 5);
                } else if ($scope.engancheCincoMilLM == 1 || $scope.engancheVeintiCincoMilLM == 1 || $scope.engancheCincoMilL1 == 1 || $scope.engancheCincoMilL2 == 1 || $scope.engancheVeintiCincoMilL == 1
                    || $scope.cinco_milLM == 1) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 2);
                } else if ($scope.descMSI == 1) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 5);
                } else if ($scope.veinteJ_milM == 1 || $scope.cinco_milM == 1 || $scope.veinticinco_milLM2 == 1) {
                    var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date($scope.fechaApartado).getMonth() + 2) : (new Date($scope.fechaApartado).getMonth() + 2);
                }


                //FIN FECHA


                /////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////

                if ($scope.day && $scope.apartado && $scope.mesesdiferir > 0) {

                    var engd = (enganche - $scope.apartado);
                    var engd2 = (engd / $scope.mesesdiferir);
                    var saldoDif = ($scope.precioFinal - $scope.apartado);

                    var rangEd = [];
                    for (var e = 0; e < $scope.mesesdiferir; e++) {

                        if (mes == 13) {
                            mes = '01';
                            yearc++;
                        }
                        if (mes == 2) {
                            mes = '02';
                        }
                        if (mes == 3) {
                            mes = '03';
                        }
                        if (mes == 4) {
                            mes = '04';
                        }
                        if (mes == 5) {
                            mes = '05';
                        }
                        if (mes == 6) {
                            mes = '06';
                        }
                        if (mes == 7) {
                            mes = '07';
                        }
                        if (mes == 8) {
                            mes = '08';
                        }
                        if (mes == 9) {
                            mes = '09';
                        }
                        if (mes == 10) {
                            mes = '10';
                        }
                        if (mes == 11) {
                            mes = '11';
                        }
                        if (mes == 12) {
                            mes = '12';
                        }

                        $scope.dateCf = day + '-' + mes + '-' + yearc;

                        if (e == 0) {
                            $scope.fechaPM = $scope.dateCf;
                        }

                        rangEd.push({
                            "fecha": $scope.dateCf,
                            "pago": ($scope.descMSI == 0) ? (e + 1) : (0),
                            "capital": engd2,
                            "interes": 0,
                            "total": engd2,
                            "saldo": saldoDif -= engd2,

                        });
                        mes++;
                    }

                    $scope.rangEd = rangEd;

                }

                /////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////


                $scope.infoLote = {

                    precioTotal: r1,
                    yPlan: $scope.age_plan,
                    msn: msi,/*$scope.msni*/
                    meses: ($scope.age_plan * 12),
                    mesesSinInteresP1: msi,/*$scope.msni*/
                    mesesSinInteresP2: 120,
                    mesesSinInteresP3: 60,
                    interes_p1: 0,
                    interes_p2: ($scope.casaFlag==1) ? 0.011083333 : 0.01,
                    interes_p3: ($scope.casaFlag==1) ? 0.011083333 : 0.0125,
                    contadorInicial: 0,
                    capital: ($scope.mesesdiferir > 0) ? (r1 / (($scope.age_plan * 12) - $scope.mesesdiferir)) : (r1 / ($scope.age_plan * 12)),
                    fechaActual: $scope.date = new Date(),
                    engancheF: enganche
                }

                console.log("/**********DATA CORRIDA**************/");
                console.log($scope.infoLote);


                $scope.engancheFinal = ($scope.infoLote.engancheF);
                console.log('ENGANCHE: ', $scope.engancheFinal);
                $scope.saldoFinal = $scope.infoLote.precioTotal;
                $scope.precioFinal = ($scope.infoLote.precioTotal + $scope.infoLote.engancheF);

                $scope.preciom2F = ($scope.preciom2);

                /*console.log("scope.engancheFinal: ", $scope.engancheFinal);
                console.log("scope.saldoFinal: ", $scope.saldoFinal);
                console.log("scope.precioFinal: ", $scope.precioFinal);
                console.log("scope.preciom2F: ", $scope.preciom2F);*/

                /////////// TABLES DE 1 A 3 AÑOS ////////////


                if ($scope.infoLote.meses >= 12 && $scope.infoLote.meses <= 36) {

                    var range = [];

                    if ($scope.descMSI == 0) {
                        ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
                    } else if ($scope.descMSI == 1) {
                        ini = $scope.infoLote.contadorInicial;
                    }


                    //////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 1) {

                        ini = $scope.infoLote.contadorInicial;

                        if ($scope.noPagomensualidad == 1) {


                            ////////////////////////////////////////////////////////////////////////////////////


                            var rangePlanc = [];


                            for (var i = ini; i < 12; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }

                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                rangePlanc.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": 0,
                                    "interes": 0,
                                    "total": 0,
                                    "saldo": $scope.saldoFinal,

                                });
                                mes++;

                                $scope.finalMesesp1PlanC = rangePlanc.length;
                                ini = rangePlanc.length;
                            }


                            $scope.rangePlanc = rangePlanc;

                            ////////////////////////////////////////////////////////////////////////////////////


                            for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }

                                $scope.dateCf = day + '-' + mes + '-' + yearc;

                                if (i == 12) {
                                    $scope.fechaPM = $scope.dateCf;
                                }


                                range.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": $scope.infoLote.capital,
                                    "interes": 0,
                                    "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                    "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                                });
                                mes++;

                                if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                    $scope.total2 = $scope.infoLote.precioTotal;
                                    $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

                                }

                                $scope.finalMesesp1 = range.length;
                                ini2 = (range.length + rangePlanc.length);
                            }
                            $scope.range = range;

                            //////////

                            $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) - 1);

                            var range2 = [];

                            for (var i = ini2; i < ($scope.infoLote.meses + 12); i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }


                                $scope.dateCf = day + '-' + mes + '-' + yearc;

                                $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                                $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                                range2.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                    "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                    "total": $scope.p2,
                                    "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                                });
                                mes++;


                                if (i == ($scope.infoLote.meses - 1)) {
                                    $scope.totalSegundoPlan = $scope.p2;

                                }
                                $scope.finalMesesp2 = (range2.length);
                            }
                            $scope.range2 = range2;


                            // $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
                            // $scope.alphaNumeric = $scope.dani.concat($scope.range2);
                            // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                            $scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);


                            $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                    {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                    {
                                        extend: 'print',
                                        text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                        titleAttr: 'Imprimir'
                                    },
                                    {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                    {
                                        extend: 'pdfHtml5',
                                        text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                        titleAttr: 'PDF',
                                        title: '',
                                        customize: function (doc) {
                                            //pageMargins [left, top, right, bottom]
                                            doc.pageMargins = [140, 40, 10, 50];
                                            doc.alignment = 'center';

                                        }
                                    },
                                ]
                            ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                        }


                    }

                    //////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 0) {


                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }

                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }

                            if($scope.casaFlag==1) {
                                let meses_restantes = $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1;
                                // console.log("LA DIVI: ", meses_restantes);
                                // console.log("INTERES: ", $scope.infoLote.interes_p2);

                                let param1 = $scope.infoLote.mesesSinInteresP1;
                                let param2 = Math.pow((1 / (1 + 0)), 1);
                                let var1 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes)) - 1;
                                let var2 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes) * $scope.infoLote.interes_p2);

                                // console.log("param1: ", param1);
                                // console.log("param2: ", param2);
                                // console.log("var1: ", var1);
                                // console.log("var2: ", var2);

                                let var3 = var1 / var2;
                                // console.log("var3: ", var3);

                                let F = (param1 * param2) + (var3);
                                console.log("F: ", F);
                                let mensualidad = $scope.saldoFinal / F;
                                // console.log("Mensualidad: " + mensualidad);
                                // console.log("$scope.precioFinal: ", $scope.infoLote);

                                $scope.infoLote.capital = mensualidad;
                            }

                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
                            }

                            $scope.finalMesesp1 = range.length;

                            if ($scope.descMSI == 0) {
                                ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            } else if ($scope.descMSI == 1) {
                                ini2 = range.length;

                            }


                        }
                        $scope.range = range;

                        //////////

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini2; i < $scope.infoLote.meses; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;

                            $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                            });
                            mes++;


                            if (i == ($scope.infoLote.meses - 1)) {
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);
                        }
                        $scope.range2 = range2;


                        // $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
                        // $scope.alphaNumeric = $scope.dani.concat($scope.range2);
                        // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 0) {

                        $scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
                            / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini; i < $scope.infoLote.meses; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;

                            $scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal - $scope.capital2)),

                            });
                            mes++;

                            if (i == ($scope.infoLote.meses - 1)) {
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);
                        }
                        $scope.range2 = range2;

                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
                        // $scope.alphaNumeric = $scope.range2;


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 36) {


                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {


                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }

                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }


                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

                            }

                            $scope.finalMesesp1 = range.length;


                            //    if($scope.descMSI == 0){
                            //       ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            //    } else if($scope.descMSI == 1){
                            //       ini2 = range.length;

                            //    }


                        }
                        $scope.range = range;

                        //////////

                        // $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
                        // $scope.alphaNumeric = $scope.dani.concat($scope.range2);
                        // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range);


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                }

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


                /////////// TABLES X 4 A 10 AÑOS ////////////


                if ($scope.infoLote.meses >= 48 && $scope.infoLote.meses <= 120) {

                    var range = [];


                    if ($scope.descMSI == 0) {
                        ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
                    } else if ($scope.descMSI == 1) {
                        ini = $scope.infoLote.contadorInicial;
                    }

                    //////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 1) {

                        ini = $scope.infoLote.contadorInicial;


                        if ($scope.noPagomensualidad == 1) {


                            ////////////////////////////////////////////////////////////////////////////////////


                            var rangePlanc = [];


                            for (var i = ini; i < 12; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }

                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                rangePlanc.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": 0,
                                    "interes": 0,
                                    "total": 0,
                                    "saldo": $scope.saldoFinal,

                                });
                                mes++;

                                $scope.finalMesesp1PlanC = rangePlanc.length;
                                ini = rangePlanc.length;
                            }


                            $scope.rangePlanc = rangePlanc;

                            ////////////////////////////////////////////////////////////////////////////////////


                            for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }


                                $scope.dateCf = day + '-' + mes + '-' + yearc;

                                if (i == 12) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                                range.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": $scope.infoLote.capital,
                                    "interes": 0,
                                    "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                    "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                                });
                                mes++;

                                if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                    $scope.total2 = $scope.infoLote.precioTotal;
                                    $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

                                }

                                $scope.finalMesesp1 = range.length;
                                ini2 = (range.length + rangePlanc.length);


                            }
                            $scope.range = range;

                            //////////

                            $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) - 1);

                            var range2 = [];


                            for (var i = ini2; i < ($scope.infoLote.meses + 12); i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }


                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                                $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                                range2.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                    "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                    "total": $scope.p2,
                                    "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                                });

                                mes++;

                                if (i == ($scope.infoLote.meses - 1)) {
                                    $scope.totalSegundoPlan = $scope.p2;

                                }
                                $scope.finalMesesp2 = (range2.length);


                            }
                            $scope.range2 = range2;


                            $scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);

                            // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                            $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                    {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                    {
                                        extend: 'print',
                                        text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                        titleAttr: 'Imprimir'
                                    },
                                    {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                    {
                                        extend: 'pdfHtml5',
                                        text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                        titleAttr: 'PDF',
                                        title: '',
                                        customize: function (doc) {
                                            //pageMargins [left, top, right, bottom]
                                            doc.pageMargins = [140, 40, 10, 50];
                                            doc.alignment = 'center';

                                        }
                                    },
                                ]
                            ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                        }


                    }

                    //////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 0) {

                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }
                            if($scope.casaFlag==1) {
                                let meses_restantes = $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1;
                                // console.log("LA DIVI: ", meses_restantes);
                                // console.log("INTERES: ", $scope.infoLote.interes_p2);

                                let param1 = $scope.infoLote.mesesSinInteresP1;
                                let param2 = Math.pow((1 / (1 + 0)), 1);
                                let var1 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes)) - 1;
                                let var2 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes) * $scope.infoLote.interes_p2);

                                // console.log("param1: ", param1);
                                // console.log("param2: ", param2);
                                // console.log("var1: ", var1);
                                // console.log("var2: ", var2);

                                let var3 = var1 / var2;
                                // console.log("var3: ", var3);

                                let F = (param1 * param2) + (var3);
                                console.log("F: ", F);
                                let mensualidad = $scope.saldoFinal / F;
                                // console.log("Mensualidad: " + mensualidad);
                                // console.log("$scope.precioFinal: ", $scope.infoLote);

                                $scope.infoLote.capital = mensualidad;
                            }

                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

                            }
                            $scope.finalMesesp1 = (range.length);

                            if ($scope.descMSI == 0) {
                                ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            } else if ($scope.descMSI == 1) {
                                ini2 = range.length;

                            }


                        }
                        $scope.range = range;

                        //////////

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];


                        for (var i = ini2; i < $scope.infoLote.meses; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                            });

                            mes++;

                            if (i == ($scope.infoLote.meses - 1)) {
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);


                        }
                        $scope.range2 = range2;


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

                        // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 0) {

                        $scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
                            / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini; i < $scope.infoLote.meses; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;

                            $scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal - $scope.capital2)),

                            });
                            mes++;

                            if (i == ($scope.infoLote.meses - 1)) {
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);
                        }
                        $scope.range2 = range2;


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);

                        // $scope.alphaNumeric = $scope.range2;


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 36) {

                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }


                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }

                            if($scope.casaFlag==1) {
                                let meses_restantes = $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1;
                                // console.log("LA DIVI: ", meses_restantes);
                                // console.log("INTERES: ", $scope.infoLote.interes_p2);

                                let param1 = $scope.infoLote.mesesSinInteresP1;
                                let param2 = Math.pow((1 / (1 + 0)), 1);
                                let var1 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes)) - 1;
                                let var2 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes) * $scope.infoLote.interes_p2);

                                // console.log("param1: ", param1);
                                // console.log("param2: ", param2);
                                // console.log("var1: ", var1);
                                // console.log("var2: ", var2);

                                let var3 = var1 / var2;
                                // console.log("var3: ", var3);

                                let F = (param1 * param2) + (var3);
                                console.log("F: ", F);
                                let mensualidad = $scope.saldoFinal / F;
                                // console.log("Mensualidad: " + mensualidad);
                                // console.log("$scope.precioFinal: ", $scope.infoLote);

                                $scope.infoLote.capital = mensualidad;
                            }

                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

                            }
                            $scope.finalMesesp1 = (range.length);

                            if ($scope.descMSI == 0) {
                                ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            } else if ($scope.descMSI == 1) {
                                ini2 = range.length;

                            }


                        }
                        $scope.range = range;

                        //////////

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];


                        for (var i = ini2; i < $scope.infoLote.meses; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                            });

                            mes++;

                            if (i == ($scope.infoLote.meses - 1)) {
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);


                        }
                        $scope.range2 = range2;


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

                        // $scope.alphaNumeric = $scope.range.concat($scope.range2);


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                }


                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                /////////// TABLES X 11 A 15 AÑOS ////////////


                if ($scope.infoLote.meses >= 132 && $scope.infoLote.meses <= 240) {


                    var range = [];


                    if ($scope.descMSI == 0) {
                        ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
                    } else if ($scope.descMSI == 1) {
                        ini = $scope.infoLote.contadorInicial;
                    }
                    // console.log("$scope.descMSI: ", $scope.descMSI);


                    //////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 1) {

                        ini = $scope.infoLote.contadorInicial;


                        if ($scope.noPagomensualidad == 1) {


                            ////////////////////////////////////////////////////////////////////////////////////


                            var rangePlanc = [];


                            for (var i = ini; i < 12; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }

                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                rangePlanc.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": 0,
                                    "interes": 0,
                                    "total": 0,
                                    "saldo": $scope.saldoFinal,

                                });
                                mes++;

                                $scope.finalMesesp1PlanC = rangePlanc.length;
                                ini = rangePlanc.length;
                            }


                            $scope.rangePlanc = rangePlanc;

                            ////////////////////////////////////////////////////////////////////////////////////


                            for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }


                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }


                                $scope.dateCf = day + '-' + mes + '-' + yearc;

                                if (i == 12) {
                                    $scope.fechaPM = $scope.dateCf;

                                }


                                range.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": $scope.infoLote.capital,
                                    "interes": 0,
                                    "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                    "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                                });
                                mes++;

                                if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                    $scope.total2 = $scope.infoLote.precioTotal;
                                    $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


                                }


                                $scope.finalMesesp1 = range.length;
                                ini2 = (range.length + rangePlanc.length);


                            }
                            $scope.range = range;

                            //////////

                            $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) - 1);

                            var range2 = [];

                            for (var i = ini2; i < 120; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }


                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                                $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                                range2.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i + 1,
                                    "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                    "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                    "total": $scope.p2,
                                    "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                                });
                                mes++;


                                if (i == 119) {
                                    $scope.total3 = $scope.total2;
                                    $scope.totalSegundoPlan = $scope.p2;

                                }
                                $scope.finalMesesp2 = (range2.length);

                            }
                            $scope.range2 = range2;


                            //////////


                            $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, ($scope.infoLote.meses + 12) - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, ($scope.infoLote.meses + 12) - 120) - 1);


                            var range3 = [];

                            for (var i = 121; i < ($scope.infoLote.meses + 12) + 1; i++) {

                                if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                    if (mes == 13) {

                                        mes = '01';
                                        yearc++;

                                    } else if (mes == 14) {

                                        mes = '02';
                                        yearc++;

                                    } else if (mes == 15) {

                                        mes = '03';
                                        yearc++;

                                    }


                                }

                                if (mes == 2) {
                                    mes = '02';
                                }
                                if (mes == 3) {
                                    mes = '03';
                                }
                                if (mes == 4) {
                                    mes = '04';
                                }
                                if (mes == 5) {
                                    mes = '05';
                                }
                                if (mes == 6) {
                                    mes = '06';
                                }
                                if (mes == 7) {
                                    mes = '07';
                                }
                                if (mes == 8) {
                                    mes = '08';
                                }
                                if (mes == 9) {
                                    mes = '09';
                                }
                                if (mes == 10) {
                                    mes = '10';
                                }
                                if (mes == 11) {
                                    mes = '11';
                                }
                                if (mes == 12) {
                                    mes = '12';
                                }

                                $scope.dateCf = day + '-' + mes + '-' + yearc;


                                $scope.interes_plan3 = $scope.total3 * ($scope.infoLote.interes_p3);
                                $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
                                var interes_3 = ($scope.interes_plan3 = ($scope.total3 * $scope.infoLote.interes_p3));
                                var saldoFinal_3 = ($scope.total3 = ($scope.total3 - $scope.capital2));

                                range3.push({

                                    "fecha": $scope.dateCf,
                                    "pago": i,
                                    "capital": ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
                                    "interes": (interes_3 <= 0) ? Math.abs(interes_3) : interes_3,
                                    "total": $scope.p3,
                                    "saldo": (saldoFinal_3 <= 0) ? Math.abs(saldoFinal_3) : saldoFinal_3,

                                });
                                mes++;


                                if (i == 122) {
                                    $scope.totalTercerPlan = $scope.p3;

                                }
                                $scope.finalMesesp3 = (range3.length);

                            }

                            $scope.range3 = range3;


                            $scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2).concat($scope.range3);


                            // $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

                            $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                    {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                    {
                                        extend: 'print',
                                        text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                        titleAttr: 'Imprimir'
                                    },
                                    {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                    {
                                        extend: 'pdfHtml5',
                                        text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                        titleAttr: 'PDF',
                                        title: '',
                                        customize: function (doc) {
                                            //pageMargins [left, top, right, bottom]
                                            doc.pageMargins = [140, 40, 10, 50];
                                            doc.alignment = 'center';

                                        }
                                    },
                                ]
                            ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                        }


                    }

                    //////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////


                    if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35 && $scope.noPagomensualidad == 0) {


                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }


                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }

                            if($scope.casaFlag==1) {
                                let meses_restantes = $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1;
                                // console.log("LA DIVI: ", meses_restantes);
                                // console.log("INTERES: ", $scope.infoLote.interes_p2);

                                let param1 = $scope.infoLote.mesesSinInteresP1;
                                let param2 = Math.pow((1 / (1 + 0)), 1);
                                let var1 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes)) - 1;
                                let var2 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes) * $scope.infoLote.interes_p2);

                                // console.log("param1: ", param1);
                                // console.log("param2: ", param2);
                                // console.log("var1: ", var1);
                                // console.log("var2: ", var2);

                                let var3 = var1 / var2;
                                // console.log("var3: ", var3);

                                let F = (param1 * param2) + (var3);
                                console.log("F: ", F);
                                let mensualidad = $scope.saldoFinal / F;
                                // console.log("Mensualidad: " + mensualidad);
                                // console.log("$scope.precioFinal: ", $scope.infoLote);

                                $scope.infoLote.capital = mensualidad;
                            }

                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


                            }

                            if ($scope.descMSI == 0) {
                                ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            } else if ($scope.descMSI == 1) {
                                ini2 = range.length;

                            }


                            $scope.finalMesesp1 = (range.length);

                        }
                        $scope.range = range;

                        //////////

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini2; i < 120; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                            });
                            mes++;


                            if (i == 119) {
                                $scope.total3 = $scope.total2;
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);

                        }
                        $scope.range2 = range2;


                        //////////


                        $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);


                        var range3 = [];

                        for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }

                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan3 = $scope.total3 * ($scope.infoLote.interes_p3);
                            $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
                            var intereses_4 = ($scope.interes_plan3 = ($scope.total3 * $scope.infoLote.interes_p3));
                            var saldo_4 = ($scope.total3 = ($scope.total3 - $scope.capital2));

                            range3.push({

                                "fecha": $scope.dateCf,
                                "pago": i,
                                "capital": ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
                                "interes": (intereses_4 <= 0) ? Math.abs(intereses_4) : intereses_4,
                                "total": $scope.p3,
                                "saldo": (saldo_4 <= 0) ? Math.abs(saldo_4) : saldo_4,

                            });
                            mes++;


                            if (i == 122) {
                                $scope.totalTercerPlan = $scope.p3;

                            }
                            $scope.finalMesesp3 = (range3.length);

                        }

                        $scope.range3 = range3;

                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

                        // $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 0) {

                        $scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
                            / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini; i < 120; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;

                            $scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal - $scope.capital2)),

                            });
                            mes++;

                            if (i == 119) {
                                $scope.total3 = $scope.infoLote.precioTotal;
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);

                        }
                        $scope.range2 = range2;


                        //////////

                        $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);

                        var range3 = [];

                        for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }

                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan3 = $scope.total3 * ($scope.infoLote.interes_p3);
                            $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
                            var interesFinal = ($scope.interes_plan3 = ($scope.total3 * $scope.infoLote.interes_p3));
                            var saldoFinal = ($scope.total3 = ($scope.total3 - $scope.capital2));

                            range3.push({

                                "fecha": $scope.dateCf,
                                "pago": i,
                                "capital": ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
                                "interes": (interesFinal <= 0) ? Math.abs(interesFinal) : interesFinal,
                                "total": $scope.p3,
                                "saldo": (saldoFinal <= 0) ? Math.abs(saldoFinal) : saldoFinal,

                            });
                            mes++;


                            if (i == 122) {
                                $scope.totalTercerPlan = $scope.p3;

                            }
                            $scope.finalMesesp3 = (range3.length);

                        }

                        $scope.range3 = range3;


                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2).concat($scope.range3);

                        //$scope.alphaNumeric = $scope.range2.concat($scope.range3);


                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                    if ($scope.infoLote.mesesSinInteresP1 == 36) {


                        for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }


                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            if ($scope.helpMxMerida1 == 0 && $scope.helpMxMerida2 == 0 && $scope.helpMxMerida3 == 0 && $scope.helpMxMerida4 == 0) {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida1 == 1 || $scope.helpMxMerida3 == 1) {
                                if (i == 8) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            } else if ($scope.helpMxMerida2 == 1 || $scope.helpMxMerida4 == 1) {

                                if (i == 4) {
                                    $scope.fechaPM = $scope.dateCf;
                                }

                            } else {
                                if (i == 0) {
                                    $scope.fechaPM = $scope.dateCf;
                                }
                            }


                            if($scope.casaFlag==1) {
                                let meses_restantes = $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1;
                                // console.log("LA DIVI: ", meses_restantes);
                                // console.log("INTERES: ", $scope.infoLote.interes_p2);

                                let param1 = $scope.infoLote.mesesSinInteresP1;
                                let param2 = Math.pow((1 / (1 + 0)), 1);
                                let var1 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes)) - 1;
                                let var2 = (Math.pow((1 + $scope.infoLote.interes_p2), meses_restantes) * $scope.infoLote.interes_p2);

                                // console.log("param1: ", param1);
                                // console.log("param2: ", param2);
                                // console.log("var1: ", var1);
                                // console.log("var2: ", var2);

                                let var3 = var1 / var2;
                                // console.log("var3: ", var3);

                                let F = (param1 * param2) + (var3);
                                console.log("F: ", F);
                                let mensualidad = $scope.saldoFinal / F;
                                // console.log("Mensualidad: " + mensualidad);
                                // console.log("$scope.precioFinal: ", $scope.infoLote);

                                $scope.infoLote.capital = mensualidad;
                            }
                            range.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": $scope.infoLote.capital,
                                "interes": 0,
                                "total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
                                "saldo": $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

                            });
                            mes++;

                            if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
                                $scope.total2 = $scope.infoLote.precioTotal;
                                $scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


                            }

                            if ($scope.descMSI == 0) {
                                ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

                            } else if ($scope.descMSI == 1) {
                                ini2 = range.length;

                            }


                            $scope.finalMesesp1 = (range.length);

                        }
                        $scope.range = range;

                        //////////

                        $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);

                        var range2 = [];

                        for (var i = ini2; i < 120; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }


                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan2 = $scope.total2 * ($scope.infoLote.interes_p2);
                            $scope.capital2 = ($scope.p2 - $scope.interes_plan2);

                            range2.push({

                                "fecha": $scope.dateCf,
                                "pago": i + 1,
                                "capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
                                "interes": ($scope.interes_plan2 = ($scope.total2 * $scope.infoLote.interes_p2)),
                                "total": $scope.p2,
                                "saldo": ($scope.total2 = ($scope.total2 - $scope.capital2)),

                            });
                            mes++;


                            if (i == 119) {
                                $scope.total3 = $scope.total2;
                                $scope.totalSegundoPlan = $scope.p2;

                            }
                            $scope.finalMesesp2 = (range2.length);

                        }
                        $scope.range2 = range2;


                        //////////


                        $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);


                        var range3 = [];

                        for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

                            if ((mes == 13) || (mes == 14) || (mes == 15)) {


                                if (mes == 13) {

                                    mes = '01';
                                    yearc++;

                                } else if (mes == 14) {

                                    mes = '02';
                                    yearc++;

                                } else if (mes == 15) {

                                    mes = '03';
                                    yearc++;

                                }


                            }

                            if (mes == 2) {
                                mes = '02';
                            }
                            if (mes == 3) {
                                mes = '03';
                            }
                            if (mes == 4) {
                                mes = '04';
                            }
                            if (mes == 5) {
                                mes = '05';
                            }
                            if (mes == 6) {
                                mes = '06';
                            }
                            if (mes == 7) {
                                mes = '07';
                            }
                            if (mes == 8) {
                                mes = '08';
                            }
                            if (mes == 9) {
                                mes = '09';
                            }
                            if (mes == 10) {
                                mes = '10';
                            }
                            if (mes == 11) {
                                mes = '11';
                            }
                            if (mes == 12) {
                                mes = '12';
                            }

                            $scope.dateCf = day + '-' + mes + '-' + yearc;


                            $scope.interes_plan3 = $scope.total3 * ($scope.infoLote.interes_p3);
                            $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
                            var interes_2 = ($scope.interes_plan3 = ($scope.total3 * $scope.infoLote.interes_p3));
                            var saldoFinal_2 = ($scope.total3 = ($scope.total3 - $scope.capital2));

                            range3.push({

                                "fecha": $scope.dateCf,
                                "pago": i,
                                "capital": ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
                                "interes": (interes_2 <= 0) ? Math.abs(interes_2) : interes_2,
                                "total": $scope.p3,
                                "saldo": (saldoFinal_2 <= 0) ? Math.abs(saldoFinal_2) : saldoFinal_2,

                            });
                            mes++;


                            if (i == 122) {
                                $scope.totalTercerPlan = $scope.p3;

                            }
                            $scope.finalMesesp3 = (range3.length);

                        }

                        $scope.range3 = range3;

                        $scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
                        $scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

                        // $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

                        $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        //pageMargins [left, top, right, bottom]
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';

                                    }
                                },
                            ]
                        ).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


                    }


                }


                ////    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            }


            $scope.paquetes = [];

            $scope.ages = [{age: 18}, {age: 19}, {age: 20}, {age: 21}, {age: 22}, {age: 23}, {age: 24}, {age: 25}, {age: 26}, {age: 27}, {age: 28}, {age: 29}, {age: 30}, {age: 31}, {age: 32}, {age: 33}, {age: 34}, {age: 35}, {age: 36}, {age: 37}, {age: 38}, {age: 39}, {age: 40}, {age: 41}, {age: 42}, {age: 43}, {age: 44}, {age: 45}, {age: 46}, {age: 47}, {age: 48}, {age: 49}, {age: 50}, {age: 51}, {age: 52}, {age: 53}, {age: 54}, {age: 55}, {age: 56}, {age: 57}, {age: 58}, {age: 59}, {age: 60}, {age: 61}, {age: 62}, {age: 63}, {age: 64}, {age: 65}, {age: 66}, {age: 67}, {age: 68}, {age: 69}, {age: 70}, {age: 71}, {age: 72}, {age: 73}, {age: 74}, {age: 75}, {age: 76}, {age: 77}, {age: 78}, {age: 79}, {age: 80}]


            $scope.diasEnganche = [{day: 15}, {day: 30}, {day: 'Diferido'}];

            $scope.diasDiferidos = [1, 2, 3, 4, 5, 6];


            $scope.daysEng = function () {
                $scope.daysEnganche = $scope.day;
                console.log("$scope.daysEnganche: ", $scope.daysEnganche);

                var TuFecha = new Date();
                var dias = parseInt($scope.daysEnganche);
                TuFecha.setDate(TuFecha.getDate() + dias);
                if ($scope.day != 'Diferido') {
                    $scope.fechaEng = TuFecha.getDate() + '-' + (TuFecha.getMonth() + 1) + '-' + TuFecha.getFullYear();
                    var apartado = angular.element(document.querySelector('#aptdo'));
                    var mesesdiferidos = angular.element(document.querySelector('#msdif'));

                    $('#aptdo').prop("disabled", true);
                    $('#msdif').prop("disabled", true);
                    if ($scope.day == 25 || $scope.day == 7) {
                        $scope.rangEd = [];
                        $scope.validaEngDif = [];
                        $('#aptdo').val("");
                        $scope.mesesdiferir = 0;
                        if ($scope.selected.descuentos) {
                            var descLenght = $scope.selected.descuentos.length;
                            for (i = 0; i <= descLenght - 1; i++) {
                                if ($scope.selected.descuentos[i]['id_condicion'] == 2) {
                                    $scope.selected.descuentos[i] = [];
                                }
                            }
                        }

                        calcularCF();
                        var finalLenght = $scope.decFin.length;
                        for (i = 0; i <= finalLenght - 1; i++) {
                            if ($scope.decFin[i]["td"] == 2) {
                                $scope.decFin[i] = "";
                                var finalLenght = descuentosAplicados.length;
                                for (i = 0; i <= finalLenght - 1; i++) {
                                    if (descuentosAplicados[i]["id_condicion"] == 2) {
                                        descuentosAplicados[i] = [];
                                        calcularCF();
                                    } else {
                                    }
                                }
                            } else {
                            }
                        }
                    }else{

                        $scope.fechaEng = '';
                        $scope.mesesdiferir = 0;
                        $scope.apartado = 0;
                        $scope.rangEd = [];
                    }
                } else {
                    $scope.fechaEng = 'Fecha Indefinida';
                    if ($scope.day == 'Diferido') {
                        var apartado = angular.element(document.querySelector('#aptdo'));
                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));

                        $('#aptdo').prop("disabled", false);
                        $('#msdif').prop("disabled", false);
                        var finalLenght = $scope.decFin.length;
                        for (i = 0; i <= finalLenght - 1; i++) {
                            if ($scope.decFin[i]["td"] == 2) {
                                $scope.decFin[i] = "";
                                var finalLenght = descuentosAplicados.length;
                                for (i = 0; i <= finalLenght - 1; i++) {
                                    if (descuentosAplicados[i]["id_condicion"] == 2) {
                                        descuentosAplicados[i] = [];
                                        calcularCF();
                                    } else {
                                    }
                                }
                            } else {
                            }
                        }
                    }
                }

            };


            $scope.ChengecheckEngDif = function () {
                calcularCF();
            }


            $scope.changeDaysEng = function () {
                console.log('I"ll execute: ');
                calcularCF();
            };


            $scope.getAge = function (age) {
                $scope.age_view = $scope.age.age;
                console.log("Doing in getAge: ", age);
                if (age <= 60) {


                    $scope.yearsplan = [{yearplan: 20}, {yearplan: 19}, {yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 61) {

                    $scope.yearsplan = [{yearplan: 19}, {yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 62) {

                    $scope.yearsplan = [{yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 63) {

                    $scope.yearsplan = [{yearplan: 17}, {yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 64) {

                    $scope.yearsplan = [{yearplan: 16}, {yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 65) {

                    $scope.yearsplan = [{yearplan: 15}, {yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]
                } else if (age == 66) {

                    $scope.yearsplan = [{yearplan: 14}, {yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 67) {

                    $scope.yearsplan = [{yearplan: 13},
                        {yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 68) {

                    $scope.yearsplan = [{yearplan: 12}, {yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 69) {

                    $scope.yearsplan = [{yearplan: 11}, {yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 70) {

                    $scope.yearsplan = [{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 71) {

                    $scope.yearsplan = [{yearplan: 9}, {yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 72) {

                    $scope.yearsplan = [{yearplan: 8}, {yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 73) {

                    $scope.yearsplan = [{yearplan: 7}, {yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 74) {

                    $scope.yearsplan = [{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 75) {

                    $scope.yearsplan = [{yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


                } else if (age == 76) {

                    $scope.yearsplan = [{yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 77) {

                    $scope.yearsplan = [{yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

                } else if (age == 78) {

                    $scope.yearsplan = [{yearplan: 2}, {yearplan: 1}]

                } else if (age == 79 || age == 80) {

                    $scope.yearsplan = [{yearplan: 1}]

                }


            };

            $scope.getAgePlan = function () {
                $scope.age_plan = $scope.yearplan;
                console.log("$scope.age_plan: ", $scope.age_plan);
                calcularCF();
            };


            $scope.selectPorcentajeEnganche = function () {
                $scope.porcentajeEng = $scope.porcentaje;

                /*nuevo*/
                var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
                var cantidadEnganche = angular.element(document.querySelector('#cantidadEnganche'));
                var r1 = $scope.total;
                if (porcentajeEnganche.val() >= 0 && porcentajeEnganche.val() <= 100) {
                    var engToShow = (r1 * (porcentajeEnganche.val() / 100));
                    cantidadEnganche.val(parseFloat(engToShow).toFixed(2));
                    $scope.cantidad = parseFloat(engToShow).toFixed(2);
                }
                /*termina nuevo*/

                if(porcentajeEnganche.val() == 10 || porcentajeEnganche.val() == 5){
                    document.getElementById("day").disabled = false;
                    document.getElementById("aptdo").disabled = false;
                    document.getElementById("msdif").disabled = false;
                }else{
                    document.getElementById("day").disabled = true;
                    document.getElementById("aptdo").disabled = true;
                    document.getElementById("msdif").disabled = true;
                }
                calcularCF();
            };


            /*$http.get("<?=base_url()?>index.php/Corrida/getResidencialDisponible").then(
                function (data) {
                    $scope.residencial = data.data;
                },
                function (data) {
                });*/




            $scope.onSelectChangep = function (proyecto) {
                console.log(proyecto);
                $http.post('<?=base_url()?>index.php/corrida/getCondominioDisponibleA', {residencial: proyecto}).then(
                    function (response) {

                        var apartado = angular.element(document.querySelector('#aptdo'));
                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));
                        var checkPack = angular.element(document.querySelector('#checkPack'));
                        var cehboxInterno = angular.element(document.querySelector('#paquete.id_paquete'));

                        $scope.condominios = response.data;
                        $scope.lotes = "";
                        $scope.plan = "";
                        $scope.diasEnganche = [{day: 15}, {day: 30}, {day: 'Diferido'}]
                        $scope.porcentaje = "";
                        $scope.cantidad = "";
                        apartado.val('0');
                        mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');
                        $scope.superficie = "";
                        $scope.preciom2 = "";
                        $scope.total = "";
                        $scope.porcentajeInv = "";
                        $scope.CurrentDate = "";
                        $scope.enganche = "";
                        $scope.paquetes = "";

                        $scope.nombreLote = "";
                        $scope.preciom2 = "";
                        $scope.preciom2F = "";
                        $scope.saldoFinal = "";
                        $scope.precioTotal = "";
                        $scope.precioFinal = "";
                        $scope.age_plan = "";
                        $scope.daysEnganche = "";
                        $scope.fechaEng = "";
                        $scope.engancheFinal = "";
                        $scope.totalPrimerPlan = "";
                        $scope.fechaPM = "";
                        $scope.totalSegundoPlan = "";
                        $scope.finalMesesp1 = "";
                        $scope.finalMesesp2 = "";
                        $scope.finalMesesp3 = "";
                        $scope.banco = "";
                        $scope.rsocial = "";
                        $scope.cuenta = "";
                        $scope.clabe = "";
                        $scope.referencia = "";
                        $scope.totalTercerPlan = "";

                        if (checkPack) {
                            var r1 = 0;
                            var a = 0;
                            var b = 0;
                            var porcentaje2 = 0;
                            var arreglo = [];
                            var arreglo2 = [];
                            var porcentajeDeEnganche = $scope.porcentajeEng;
                            $scope.decFin = [];
                            enganche = 0;
                            r1 = (r1 - enganche);
                            a += porcentaje2;
                            b = (0 - a);
                            c = (b / 0);
                            arreglo.push({ahorro: a, pm: c, pt: b});
                            $scope.decFin = arreglo;
                            if (descuentosAplicados) {
                                descuentosAplicados = [];
                            }
                        }


                        if (!$scope.alphaNumeric) {
                        } else {
                            $scope.alphaNumeric = [];
                            $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';
                                    }
                                },]).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
                        }
                    },
                    function (response) {
                    });
            }

            $scope.onSelectChangec = function (condominio) {
                console.log(condominio);
                $http.post('<?=base_url()?>index.php/queryInventario/getLoteDisponibleA', {condominio: condominio.idCondominio}).then(
                    function (response) {
                        $scope.lotes = response.data;

                        var apartado = angular.element(document.querySelector('#aptdo'));
                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));
                        var checkPack = angular.element(document.querySelector('#checkPack'));
                        var cehboxInterno = angular.element(document.querySelector('#paquete.id_paquete'));

                        $scope.plan = "";
                        $scope.diasEnganche = [{day: 15}, {day: 30}, {day: 'Diferido'}]
                        $scope.porcentaje = "";
                        $scope.cantidad = "";
                        apartado.val('0');
                        mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');
                        $scope.superficie = "";
                        $scope.preciom2 = "";
                        $scope.total = "";
                        $scope.porcentajeInv = "";
                        $scope.CurrentDate = "";
                        $scope.enganche = "";
                        $scope.paquetes = "";

                        $scope.nombreLote = "";
                        $scope.preciom2 = "";
                        $scope.preciom2F = "";
                        $scope.saldoFinal = "";
                        $scope.precioTotal = "";
                        $scope.precioFinal = "";
                        $scope.age_plan = "";
                        $scope.daysEnganche = "";
                        $scope.fechaEng = "";
                        $scope.engancheFinal = "";
                        $scope.totalPrimerPlan = "";
                        $scope.fechaPM = "";
                        $scope.totalSegundoPlan = "";
                        $scope.finalMesesp1 = "";
                        $scope.finalMesesp2 = "";
                        $scope.finalMesesp3 = "";
                        $scope.banco = "";
                        $scope.rsocial = "";
                        $scope.cuenta = "";
                        $scope.clabe = "";
                        $scope.referencia = "";
                        $scope.totalTercerPlan = "";

                        if (checkPack) {
                            var r1 = 0;
                            var a = 0;
                            var b = 0;
                            var porcentaje2 = 0;
                            var arreglo = [];
                            var arreglo2 = [];
                            var porcentajeDeEnganche = $scope.porcentajeEng;
                            $scope.decFin = [];
                            enganche = 0;
                            r1 = (r1 - enganche);
                            a += porcentaje2;
                            b = (0 - a);
                            c = (b / 0);
                            arreglo.push({ahorro: a, pm: c, pt: b});
                            $scope.decFin = arreglo;
                            if (descuentosAplicados) {
                                descuentosAplicados = [];
                            }

                        }
                        if (!$scope.alphaNumeric) {
                        } else {
                            $scope.alphaNumeric = [];
                            $scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
                                {extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
                                {
                                    extend: 'print',
                                    text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                                    titleAttr: 'Imprimir'
                                },
                                {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
                                {
                                    extend: 'pdfHtml5',
                                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
                                    titleAttr: 'PDF',
                                    title: '',
                                    customize: function (doc) {
                                        doc.pageMargins = [140, 40, 10, 50];
                                        doc.alignment = 'center';
                                    }
                                },]).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
                        }
                    },
                    function (response) {
                    });
            }
            $scope.onSelectChangel = function (lote) {
                console.log(lote);
                /**/$http.post('<?=base_url()?>index.php/Asesor/getinfoLoteDisponibleE', {lote: lote}).then(
                    function (response) {



                        //Reinicia los valores del arreglo que trae descuentos
                        descuentosAplicados = [];
                        $scope.selected = {};
                        $scope.porcentaje = $scope.porcentajeEng = 0;
                        $scope.descDateEnero = 0;
                        $scope.noPagomensualidad = 0;
                        $scope.descMSI = 0;

                        $scope.descDateOctubre = 0;


                        $scope.descDateEneroMerida = 0;
                        $scope.descDateMayoMerida = 0;
                        $scope.descDateSeptiembreMerida = 0;

                        $scope.descDateEneroMeridaC = 0;
                        $scope.descDateMayoMeridaC = 0;
                        $scope.descDateSeptiembreMeridaC = 0;


                        $scope.descDateEneroLM1 = 0;
                        $scope.descDateEneroLM2 = 0;
                        $scope.descDateEneroLM3 = 0;
                        $scope.descDateSepLM4 = 0;


                        $scope.descDateEneroLM1C = 0;
                        $scope.descDateEneroLM2C = 0;
                        $scope.descDateSepLM3C = 0;
                        $scope.descDateSepLM4C = 0;


                        $scope.descDateEneroL1 = 0;
                        $scope.descDateEneroL2 = 0;
                        $scope.descDateEneroL3 = 0;
                        $scope.descDateEneroL4 = 0;
                        $scope.descDateSepL1 = 0;


                        $scope.descDateEneroL5 = 0;
                        $scope.descDateEneroL6 = 0;
                        $scope.descDateEneroL7 = 0;
                        $scope.descDateSepL2 = 0;
                        $scope.descDateSepL3 = 0;

                        $scope.descDateEneroL8 = 0;
                        $scope.descDateEneroL9 = 0;
                        $scope.descDateSepL4 = 0;
                        $scope.descDateSepL5 = 0;


                        $scope.descDateEneroAllQro1 = 0;
                        $scope.descDateEneroAllQro2 = 0;
                        $scope.descDateSepAllQro1 = 0;
                        $scope.descDateSepAllQro2 = 0;
                        $scope.descDateMayoAllQro1 = 0;
                        $scope.descDateMayoAllQro2 = 0;


                        $scope.descDateMayoSLP = 0;

                        $scope.engancheCincoMil = 0;
                        $scope.engancheVeintiCincoMilMerida = 0;

                        $scope.engancheCincoMilLM = 0;
                        $scope.engancheVeintiCincoMilLM = 0;
                        $scope.engancheCincoMilL1 = 0;
                        $scope.engancheCincoMilL2 = 0;
                        $scope.engancheVeintiCincoMilL = 0;


                        $scope.helpMxMerida1 = 0;
                        $scope.helpMxMerida2 = 0;
                        $scope.helpMxMerida3 = 0;
                        $scope.helpMxMerida4 = 0;

                        $scope.descDateEneroS1YS2 = 0;
                        $scope.descDateEng0S1YS2 = 0;

                        $scope.engancheDiezMilLSLP = 0;


                        $scope.cinco_milM = 0;
                        $scope.veinteJ_milM = 0;
                        $scope.diez_milM = 0;

                        $scope.cinco_milL = 0;
                        $scope.diez_milL = 0;
                        $scope.veinticinco_milL = 0;

                        $scope.cinco_milLM = 0;
                        $scope.veinticinco_milLM = 0;
                        $scope.veinticinco_milLM2 = 0;


                        $scope.ceroQ1 = 0;
                        $scope.ceroQ2 = 0;
                        $scope.ceroQ3 = 0;
                        $scope.ceroQ4 = 0;


                        $scope.cyd_slp1 = 0;
                        $scope.cyd_slp2 = 0;

                        $scope.cincoCSLP = 0;
                        $scope.cincoCL = 0;


                        $scope.selectDescuentos = function (descuento, checked) {

                            var idx = descuentosAplicados.indexOf(descuento);
                            // console.log('Tienes un número negativo ' +idx);
                            if (idx >= 0 && !checked) {
                                descuentosAplicados.splice(idx, 1);
                                $scope.descApply = descuentosAplicados;


                                for (var descuentos of $scope.descApply) {

                                    if (descuentos.id_paquete == 261 || descuentos.id_paquete == 151 || descuentos.id_paquete == 368 || descuentos.id_paquete == 369 || descuentos.id_paquete == 263 || descuentos.id_paquete == 268 || descuentos.id_paquete == 269
                                        || descuentos.id_paquete == 265 || descuentos.id_paquete == 270 || descuentos.id_paquete == 271 || descuentos.id_paquete == 272 || descuentos.id_paquete == 273 || descuentos.id_paquete == 274
                                        || descuentos.id_paquete == 275 || descuentos.id_paquete == 276 || descuentos.id_paquete == 278 || descuentos.id_paquete == 279 || descuentos.id_paquete == 280 || descuentos.id_paquete == 281


                                        || descuentos.id_paquete == 283 || descuentos.id_paquete == 284 || descuentos.id_paquete == 285 || descuentos.id_paquete == 286 || descuentos.id_paquete == 287


                                        || descuentos.id_paquete == 289 || descuentos.id_paquete == 290 || descuentos.id_paquete == 291 || descuentos.id_paquete == 292 || descuentos.id_paquete == 293
                                        || descuentos.id_paquete == 295 || descuentos.id_paquete == 296 || descuentos.id_paquete == 297 || descuentos.id_paquete == 298


                                        || descuentos.id_paquete == 300 || descuentos.id_paquete == 301 || descuentos.id_paquete == 302 || descuentos.id_paquete == 303
                                        || descuentos.id_paquete == 304 || descuentos.id_paquete == 305

                                        || descuentos.id_paquete == 262

                                        || descuentos.id_paquete == 277 || descuentos.id_paquete == 282 || descuentos.id_paquete == 288 || descuentos.id_paquete == 294
                                        || descuentos.id_paquete == 299 || descuentos.id_paquete == 307 || descuentos.id_paquete == 308 || descuentos.id_paquete == 309 || descuentos.id_paquete == 310

                                        || descuentos.id_paquete == 311 || descuentos.id_paquete == 312
                                        || descuentos.id_paquete == 313


                                        || descuentos.id_paquete == 267
                                        || descuentos.id_paquete == 351
                                        || descuentos.id_paquete == 354


                                        || descuentos.id_paquete == 317
                                        || descuentos.id_paquete == 320
                                        || descuentos.id_paquete == 324

                                        || descuentos.id_paquete == 329
                                        || descuentos.id_paquete == 333


                                        || descuentos.id_paquete == 360
                                        || descuentos.id_paquete == 361
                                        || descuentos.id_paquete == 362
                                        || descuentos.id_paquete == 365

                                        || descuentos.id_paquete == 366
                                        || descuentos.id_paquete == 367

                                        || descuentos.id_paquete == 370
                                        || descuentos.id_paquete == 373
                                        || descuentos.id_paquete == 378


                                    ) {
                                        if (descuentos.id_paquete == 261) {
                                            $scope.descDateEnero = 1;
                                        } else if (descuentos.id_paquete == 151) {
                                            $scope.noPagomensualidad = 1;
                                        } else if (descuentos.id_paquete == 368 || descuentos.id_paquete == 369) {
                                            $scope.descMSI = 1;
                                        } else if (descuentos.id_paquete == 263) {
                                            $scope.descDateOctubre = 1;
                                        } else if (descuentos.id_paquete == 268) {
                                            $scope.descDateSeptiembreMerida = 1;
                                        } else if (descuentos.id_paquete == 269) {
                                            $scope.descDateMayoMerida = 1;
                                            $scope.engancheCincoMil = 1;

                                        } else if (descuentos.id_paquete == 265) {
                                            $scope.descDateEneroMerida = 1;
                                        } else if (descuentos.id_paquete == 270) {
                                            $scope.descDateEneroMeridaC = 1;
                                        } else if (descuentos.id_paquete == 271) {
                                            $scope.descDateSeptiembreMeridaC = 1;
                                        } else if (descuentos.id_paquete == 272) {
                                            $scope.descDateMayoMeridaC = 1;
                                            $scope.engancheVeintiCincoMilMerida = 1;

                                        } else if (descuentos.id_paquete == 273) {
                                            $scope.descDateEneroLM1 = 1;
                                        } else if (descuentos.id_paquete == 274) {
                                            $scope.descDateEneroLM2 = 1;
                                        } else if (descuentos.id_paquete == 275) {
                                            $scope.descDateEneroLM3 = 1;
                                        } else if (descuentos.id_paquete == 276) {
                                            $scope.descDateSepLM4 = 1;
                                        } else if (descuentos.id_paquete == 278) {
                                            $scope.descDateEneroLM1C = 1;
                                        } else if (descuentos.id_paquete == 279) {
                                            $scope.descDateEneroLM2C = 1;
                                        } else if (descuentos.id_paquete == 280) {
                                            $scope.descDateSepLM3C = 1;
                                        } else if (descuentos.id_paquete == 281) {
                                            $scope.descDateSepLM4C = 1;
                                        } else if (descuentos.id_paquete == 283) {
                                            $scope.descDateEneroL1 = 1;
                                        } else if (descuentos.id_paquete == 284) {
                                            $scope.descDateEneroL2 = 1;
                                        } else if (descuentos.id_paquete == 285) {
                                            $scope.descDateEneroL3 = 1;
                                        } else if (descuentos.id_paquete == 286) {
                                            $scope.descDateEneroL4 = 1;
                                        } else if (descuentos.id_paquete == 287) {
                                            $scope.descDateSepL1 = 1;
                                        } else if (descuentos.id_paquete == 289) {
                                            $scope.descDateEneroL5 = 1;
                                        } else if (descuentos.id_paquete == 290) {
                                            $scope.descDateEneroL6 = 1;
                                        } else if (descuentos.id_paquete == 291) {
                                            $scope.descDateEneroL7 = 1;
                                        } else if (descuentos.id_paquete == 292) {
                                            $scope.descDateSepL2 = 1;
                                        } else if (descuentos.id_paquete == 293) {
                                            $scope.descDateSepL3 = 1;
                                        } else if (descuentos.id_paquete == 295) {
                                            $scope.descDateEneroL8 = 1;
                                        } else if (descuentos.id_paquete == 296) {
                                            $scope.descDateEneroL9 = 1;
                                        } else if (descuentos.id_paquete == 297) {
                                            $scope.descDateSepL4 = 1;
                                        } else if (descuentos.id_paquete == 298) {
                                            $scope.descDateSepL5 = 1;
                                        } else if (descuentos.id_paquete == 300) {
                                            $scope.descDateEneroAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 301) {
                                            $scope.descDateEneroAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 302) {
                                            $scope.descDateSepAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 303) {
                                            $scope.descDateSepAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 304) {
                                            $scope.descDateMayoAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 305) {
                                            $scope.descDateMayoAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 262) {
                                            $scope.descDateMayoSLP = 1;
                                        } else if (descuentos.id_paquete == 277) {

                                            $scope.engancheCincoMilLM = 1;
                                        } else if (descuentos.id_paquete == 282) {
                                            $scope.engancheVeintiCincoMilLM = 1;
                                        } else if (descuentos.id_paquete == 288) {
                                            $scope.engancheCincoMilL1 = 1;
                                        } else if (descuentos.id_paquete == 294) {
                                            $scope.engancheCincoMilL2 = 1;
                                        } else if (descuentos.id_paquete == 299) {
                                            $scope.engancheVeintiCincoMilL = 1;
                                        } else if (descuentos.id_paquete == 307) {
                                            $scope.helpMxMerida1 = 1;
                                        } else if (descuentos.id_paquete == 308) {
                                            $scope.helpMxMerida2 = 1;
                                        } else if (descuentos.id_paquete == 309) {
                                            $scope.helpMxMerida3 = 1;
                                        } else if (descuentos.id_paquete == 310) {
                                            $scope.helpMxMerida4 = 1;
                                        } else if (descuentos.id_paquete == 311) {
                                            $scope.descDateEneroS1YS2 = 1;
                                        } else if (descuentos.id_paquete == 312) {
                                            $scope.descDateEng0S1YS2 = 1;
                                        } else if (descuentos.id_paquete == 313) {
                                            $scope.engancheDiezMilLSLP = 1;
                                        } else if (descuentos.id_paquete == 267) {
                                            $scope.cinco_milM = 1;
                                        } else if (descuentos.id_paquete == 351) {
                                            $scope.veinteJ_milM = 1;
                                        } else if (descuentos.id_paquete == 354) {
                                            $scope.diez_milM = 1;
                                        } else if (descuentos.id_paquete == 317) {
                                            $scope.cinco_milL = 1;
                                        } else if (descuentos.id_paquete == 320) {
                                            $scope.diez_milL = 1;
                                        } else if (descuentos.id_paquete == 324) {
                                            $scope.veinticinco_milL = 1;
                                        } else if (descuentos.id_paquete == 329) {
                                            $scope.cinco_milLM = 1;
                                        } else if (descuentos.id_paquete == 333) {
                                            $scope.veinticinco_milLM = 1;
                                        } else if (descuentos.id_paquete == 360) {
                                            $scope.ceroQ1 = 1;
                                        } else if (descuentos.id_paquete == 361) {
                                            $scope.ceroQ2 = 1;
                                        } else if (descuentos.id_paquete == 362) {
                                            $scope.ceroQ3 = 1;
                                        } else if (descuentos.id_paquete == 365) {
                                            $scope.ceroQ4 = 1;
                                        } else if (descuentos.id_paquete == 366) {
                                            $scope.cyd_slp1 = 1;
                                        } else if (descuentos.id_paquete == 367) {
                                            $scope.cyd_slp2 = 1;
                                        } else if (descuentos.id_paquete == 370) {
                                            $scope.cincoCSLP = 1;
                                        } else if (descuentos.id_paquete == 373) {
                                            $scope.veinticinco_milLM2 = 1;
                                        } else if (descuentos.id_paquete == 378) {
                                            $scope.cincoCL = 1;
                                        }

                                    } else if (descuentos.id_paquete != 261 || descuentos.id_paquete != 151 || descuentos.id_paquete != 368 || descuentos.id_paquete != 369 || descuentos.id_paquete != 263 || descuentos.id_paquete != 268
                                        || descuentos.id_paquete != 269 || descuentos.id_paquete != 265 || descuentos.id_paquete != 270 || descuentos.id_paquete != 271 || descuentos.id_paquete != 272
                                        || descuentos.id_paquete != 273 || descuentos.id_paquete != 274 || descuentos.id_paquete != 275 || descuentos.id_paquete != 276
                                        || descuentos.id_paquete != 278 || descuentos.id_paquete != 279 || descuentos.id_paquete != 280 || descuentos.id_paquete != 281

                                        || descuentos.id_paquete != 283 || descuentos.id_paquete != 284 || descuentos.id_paquete != 285 || descuentos.id_paquete != 286 || descuentos.id_paquete != 287


                                        || descuentos.id_paquete != 289 || descuentos.id_paquete != 290 || descuentos.id_paquete != 291 || descuentos.id_paquete != 292 || descuentos.id_paquete != 293
                                        || descuentos.id_paquete != 295 || descuentos.id_paquete != 296 || descuentos.id_paquete != 297 || descuentos.id_paquete != 298


                                        || descuentos.id_paquete != 300 || descuentos.id_paquete != 301 || descuentos.id_paquete != 302 || descuentos.id_paquete != 303
                                        || descuentos.id_paquete != 304 || descuentos.id_paquete != 305

                                        || descuentos.id_paquete != 262

                                        || descuentos.id_paquete != 277 || descuentos.id_paquete != 282 || descuentos.id_paquete != 288 || descuentos.id_paquete != 294
                                        || descuentos.id_paquete != 299 || descuentos.id_paquete != 307 || descuentos.id_paquete != 308 || descuentos.id_paquete != 309 || descuentos.id_paquete != 310

                                        || descuentos.id_paquete != 311 || descuentos.id_paquete != 312
                                        || descuentos.id_paquete != 313

                                        || descuentos.id_paquete != 267
                                        || descuentos.id_paquete != 351
                                        || descuentos.id_paquete != 354


                                        || descuentos.id_paquete != 317
                                        || descuentos.id_paquete != 320
                                        || descuentos.id_paquete != 324

                                        || descuentos.id_paquete != 329
                                        || descuentos.id_paquete != 333


                                        || descuentos.id_paquete != 360
                                        || descuentos.id_paquete != 361
                                        || descuentos.id_paquete != 362
                                        || descuentos.id_paquete != 365

                                        || descuentos.id_paquete != 366
                                        || descuentos.id_paquete != 367

                                        || descuentos.id_paquete != 370
                                        || descuentos.id_paquete != 373
                                        || descuentos.id_paquete != 378

                                    ) {
                                        $scope.descDateEnero = 0;
                                        $scope.noPagomensualidad = 0;
                                        $scope.descMSI = 0;
                                        $scope.descDateOctubre = 0;
                                        $scope.descDateMayoMerida = 0;
                                        $scope.descDateSeptiembreMerida = 0;
                                        $scope.descDateEneroMerida = 0;
                                        $scope.descDateEneroMeridaC = 0;
                                        $scope.descDateMayoMeridaC = 0;
                                        $scope.descDateSeptiembreMeridaC = 0;
                                        $scope.descDateEneroLM1 = 0;
                                        $scope.descDateEneroLM2 = 0;
                                        $scope.descDateEneroLM3 = 0;
                                        $scope.descDateSepLM4 = 0;

                                        $scope.descDateEneroLM1C = 0;
                                        $scope.descDateEneroLM2C = 0;
                                        $scope.descDateSepLM3C = 0;
                                        $scope.descDateSepLM4C = 0;

                                        $scope.descDateEneroL1 = 0;
                                        $scope.descDateEneroL2 = 0;
                                        $scope.descDateEneroL3 = 0;
                                        $scope.descDateEneroL4 = 0;
                                        $scope.descDateSepL1 = 0;


                                        $scope.descDateEneroL5 = 0;
                                        $scope.descDateEneroL6 = 0;
                                        $scope.descDateEneroL7 = 0;
                                        $scope.descDateSepL2 = 0;
                                        $scope.descDateSepL3 = 0;

                                        $scope.descDateEneroL8 = 0;
                                        $scope.descDateEneroL9 = 0;
                                        $scope.descDateSepL4 = 0;
                                        $scope.descDateSepL5 = 0;


                                        $scope.descDateEneroAllQro1 = 0;
                                        $scope.descDateEneroAllQro2 = 0;
                                        $scope.descDateSepAllQro1 = 0;
                                        $scope.descDateSepAllQro2 = 0;
                                        $scope.descDateMayoAllQro1 = 0;
                                        $scope.descDateMayoAllQro2 = 0;

                                        $scope.descDateMayoSLP = 0;

                                        $scope.engancheCincoMil = 0;
                                        $scope.engancheVeintiCincoMilMerida = 0;


                                        $scope.engancheCincoMilLM = 0;
                                        $scope.engancheVeintiCincoMilLM = 0;
                                        $scope.engancheCincoMilL1 = 0;
                                        $scope.engancheCincoMilL2 = 0;
                                        $scope.engancheVeintiCincoMilL = 0;

                                        $scope.helpMxMerida1 = 0;
                                        $scope.helpMxMerida2 = 0;
                                        $scope.helpMxMerida3 = 0;
                                        $scope.helpMxMerida4 = 0;

                                        $scope.descDateEneroS1YS2 = 0;
                                        $scope.descDateEng0S1YS2 = 0;

                                        $scope.engancheDiezMilLSLP = 0;


                                        $scope.cinco_milM = 0;
                                        $scope.veinteJ_milM = 0;
                                        $scope.diez_milM = 0;


                                        $scope.cinco_milL = 0;
                                        $scope.diez_milL = 0;
                                        $scope.veinticinco_milL = 0;

                                        $scope.cinco_milLM = 0;
                                        $scope.veinticinco_milLM = 0;


                                        $scope.ceroQ1 = 0;
                                        $scope.ceroQ2 = 0;
                                        $scope.ceroQ3 = 0;
                                        $scope.ceroQ4 = 0;

                                        $scope.cyd_slp1 = 0;
                                        $scope.cyd_slp2 = 0;

                                        $scope.cincoCSLP = 0;
                                        $scope.veinticinco_milLM2 = 0;
                                        $scope.cincoCL = 0;


                                    }

                                }

                                if ($scope.descApply.length == 0) {
                                    $scope.descDateEnero = 0;
                                    $scope.noPagomensualidad = 0;
                                    $scope.descMSI = 0;
                                    $scope.descDateOctubre = 0;
                                    $scope.descDateMayoMerida = 0;
                                    $scope.descDateSeptiembreMerida = 0;
                                    $scope.descDateEneroMerida = 0;
                                    $scope.descDateEneroMeridaC = 0;
                                    $scope.descDateMayoMeridaC = 0;
                                    $scope.descDateSeptiembreMeridaC = 0;
                                    $scope.descDateEneroLM1 = 0;
                                    $scope.descDateEneroLM2 = 0;
                                    $scope.descDateEneroLM3 = 0;
                                    $scope.descDateSepLM4 = 0;

                                    $scope.descDateEneroLM1C = 0;
                                    $scope.descDateEneroLM2C = 0;
                                    $scope.descDateSepLM3C = 0;
                                    $scope.descDateSepLM4C = 0;

                                    $scope.descDateEneroL1 = 0;
                                    $scope.descDateEneroL2 = 0;
                                    $scope.descDateEneroL3 = 0;
                                    $scope.descDateEneroL4 = 0;
                                    $scope.descDateSepL1 = 0;

                                    $scope.descDateEneroL5 = 0;
                                    $scope.descDateEneroL6 = 0;
                                    $scope.descDateEneroL7 = 0;
                                    $scope.descDateSepL2 = 0;
                                    $scope.descDateSepL3 = 0;

                                    $scope.descDateEneroL8 = 0;
                                    $scope.descDateEneroL9 = 0;
                                    $scope.descDateSepL4 = 0;
                                    $scope.descDateSepL5 = 0;

                                    $scope.descDateEneroAllQro1 = 0;
                                    $scope.descDateEneroAllQro2 = 0;
                                    $scope.descDateSepAllQro1 = 0;
                                    $scope.descDateSepAllQro2 = 0;
                                    $scope.descDateMayoAllQro1 = 0;
                                    $scope.descDateMayoAllQro2 = 0;

                                    $scope.descDateMayoSLP = 0;

                                    $scope.engancheCincoMil = 0;
                                    $scope.engancheVeintiCincoMilMerida = 0;


                                    $scope.engancheCincoMilLM = 0;
                                    $scope.engancheVeintiCincoMilLM = 0;
                                    $scope.engancheCincoMilL1 = 0;
                                    $scope.engancheCincoMilL2 = 0;
                                    $scope.engancheVeintiCincoMilL = 0;

                                    $scope.helpMxMerida1 = 0;
                                    $scope.helpMxMerida2 = 0;
                                    $scope.helpMxMerida3 = 0;
                                    $scope.helpMxMerida4 = 0;

                                    $scope.descDateEneroS1YS2 = 0;
                                    $scope.descDateEng0S1YS2 = 0;

                                    $scope.engancheDiezMilLSLP = 0;


                                    $scope.cinco_milM = 0;
                                    $scope.veinteJ_milM = 0;
                                    $scope.diez_milM = 0;

                                    $scope.cinco_milL = 0;
                                    $scope.diez_milL = 0;
                                    $scope.veinticinco_milL = 0;

                                    $scope.cinco_milLM = 0;
                                    $scope.veinticinco_milLM = 0;


                                    $scope.ceroQ1 = 0;
                                    $scope.ceroQ2 = 0;
                                    $scope.ceroQ3 = 0;
                                    $scope.ceroQ4 = 0;

                                    $scope.cyd_slp1 = 0;
                                    $scope.cyd_slp2 = 0;

                                    $scope.cincoCSLP = 0;
                                    $scope.veinticinco_milLM2 = 0;
                                    $scope.cincoCL = 0;


                                }

                            }

                            if (idx < 0 && checked) {
                                descuentosAplicados.push(descuento);
                                $scope.descApply = descuentosAplicados;
                                for (var descuentos of $scope.descApply) {

                                    if (descuentos.id_paquete == 261 || descuentos.id_paquete == 151 || descuentos.id_paquete == 368 || descuentos.id_paquete == 369 || descuentos.id_paquete == 263 || descuentos.id_paquete == 268 || descuentos.id_paquete == 269
                                        || descuentos.id_paquete == 265 || descuentos.id_paquete == 270 || descuentos.id_paquete == 271 || descuentos.id_paquete == 272 || descuentos.id_paquete == 273 || descuentos.id_paquete == 274
                                        || descuentos.id_paquete == 275 || descuentos.id_paquete == 276 || descuentos.id_paquete == 278 || descuentos.id_paquete == 279 || descuentos.id_paquete == 280 || descuentos.id_paquete == 281

                                        || descuentos.id_paquete == 283 || descuentos.id_paquete == 284 || descuentos.id_paquete == 285 || descuentos.id_paquete == 286 || descuentos.id_paquete == 287

                                        || descuentos.id_paquete == 289 || descuentos.id_paquete == 290 || descuentos.id_paquete == 291 || descuentos.id_paquete == 292 || descuentos.id_paquete == 293
                                        || descuentos.id_paquete == 295 || descuentos.id_paquete == 296 || descuentos.id_paquete == 297 || descuentos.id_paquete == 298


                                        || descuentos.id_paquete == 300 || descuentos.id_paquete == 301 || descuentos.id_paquete == 302 || descuentos.id_paquete == 303
                                        || descuentos.id_paquete == 304 || descuentos.id_paquete == 305

                                        || descuentos.id_paquete == 262

                                        || descuentos.id_paquete == 277 || descuentos.id_paquete == 282 || descuentos.id_paquete == 288 || descuentos.id_paquete == 294
                                        || descuentos.id_paquete == 299 || descuentos.id_paquete == 307 || descuentos.id_paquete == 308 || descuentos.id_paquete == 309 || descuentos.id_paquete == 310


                                        || descuentos.id_paquete == 311 || descuentos.id_paquete == 312
                                        || descuentos.id_paquete == 313


                                        || descuentos.id_paquete == 267
                                        || descuentos.id_paquete == 351
                                        || descuentos.id_paquete == 354

                                        || descuentos.id_paquete == 317
                                        || descuentos.id_paquete == 320
                                        || descuentos.id_paquete == 324


                                        || descuentos.id_paquete == 329
                                        || descuentos.id_paquete == 333


                                        || descuentos.id_paquete == 360
                                        || descuentos.id_paquete == 361
                                        || descuentos.id_paquete == 362
                                        || descuentos.id_paquete == 365

                                        || descuentos.id_paquete == 366
                                        || descuentos.id_paquete == 367

                                        || descuentos.id_paquete == 370
                                        || descuentos.id_paquete == 373
                                        || descuentos.id_paquete == 378

                                    ) {
                                        if (descuentos.id_paquete == 261) {
                                            $scope.descDateEnero = 1;
                                        } else if (descuentos.id_paquete == 151) {
                                            $scope.noPagomensualidad = 1;
                                        } else if (descuentos.id_paquete == 368 || descuentos.id_paquete == 369) {
                                            $scope.descMSI = 1;
                                        } else if (descuentos.id_paquete == 263) {
                                            $scope.descDateOctubre = 1;
                                        } else if (descuentos.id_paquete == 268) {
                                            $scope.descDateSeptiembreMerida = 1;
                                        } else if (descuentos.id_paquete == 269) {
                                            $scope.descDateMayoMerida = 1;
                                            $scope.engancheCincoMil = 1;


                                        } else if (descuentos.id_paquete == 265) {
                                            $scope.descDateEneroMerida = 1;
                                        } else if (descuentos.id_paquete == 270) {
                                            $scope.descDateEneroMeridaC = 1;
                                        } else if (descuentos.id_paquete == 271) {
                                            $scope.descDateSeptiembreMeridaC = 1;
                                        } else if (descuentos.id_paquete == 272) {
                                            $scope.descDateMayoMeridaC = 1;
                                            $scope.engancheVeintiCincoMilMerida = 1;

                                        } else if (descuentos.id_paquete == 273) {
                                            $scope.descDateEneroLM1 = 1;
                                        } else if (descuentos.id_paquete == 274) {
                                            $scope.descDateEneroLM2 = 1;
                                        } else if (descuentos.id_paquete == 275) {
                                            $scope.descDateEneroLM3 = 1;
                                        } else if (descuentos.id_paquete == 276) {
                                            $scope.descDateSepLM4 = 1;
                                        } else if (descuentos.id_paquete == 278) {
                                            $scope.descDateEneroLM1C = 1;
                                        } else if (descuentos.id_paquete == 279) {
                                            $scope.descDateEneroLM2C = 1;
                                        } else if (descuentos.id_paquete == 280) {
                                            $scope.descDateSepLM3C = 1;
                                        } else if (descuentos.id_paquete == 281) {
                                            $scope.descDateSepLM4C = 1;
                                        } else if (descuentos.id_paquete == 283) {
                                            $scope.descDateEneroL1 = 1;
                                        } else if (descuentos.id_paquete == 284) {
                                            $scope.descDateEneroL2 = 1;
                                        } else if (descuentos.id_paquete == 285) {
                                            $scope.descDateEneroL3 = 1;
                                        } else if (descuentos.id_paquete == 286) {
                                            $scope.descDateEneroL4 = 1;
                                        } else if (descuentos.id_paquete == 287) {
                                            $scope.descDateSepL1 = 1;
                                        } else if (descuentos.id_paquete == 289) {
                                            $scope.descDateEneroL5 = 1;
                                        } else if (descuentos.id_paquete == 290) {
                                            $scope.descDateEneroL6 = 1;
                                        } else if (descuentos.id_paquete == 291) {
                                            $scope.descDateEneroL7 = 1;
                                        } else if (descuentos.id_paquete == 292) {
                                            $scope.descDateSepL2 = 1;
                                        } else if (descuentos.id_paquete == 293) {
                                            $scope.descDateSepL3 = 1;
                                        } else if (descuentos.id_paquete == 295) {
                                            $scope.descDateEneroL8 = 1;
                                        } else if (descuentos.id_paquete == 296) {
                                            $scope.descDateEneroL9 = 1;
                                        } else if (descuentos.id_paquete == 297) {
                                            $scope.descDateSepL4 = 1;
                                        } else if (descuentos.id_paquete == 298) {
                                            $scope.descDateSepL5 = 1;
                                        } else if (descuentos.id_paquete == 300) {
                                            $scope.descDateEneroAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 301) {
                                            $scope.descDateEneroAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 302) {
                                            $scope.descDateSepAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 303) {
                                            $scope.descDateSepAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 304) {
                                            $scope.descDateMayoAllQro1 = 1;
                                        } else if (descuentos.id_paquete == 305) {
                                            $scope.descDateMayoAllQro2 = 1;
                                        } else if (descuentos.id_paquete == 262) {
                                            $scope.descDateMayoSLP = 1;
                                        } else if (descuentos.id_paquete == 277) {

                                            $scope.engancheCincoMilLM = 1;
                                        } else if (descuentos.id_paquete == 282) {
                                            $scope.engancheVeintiCincoMilLM = 1;
                                        } else if (descuentos.id_paquete == 288) {
                                            $scope.engancheCincoMilL1 = 1;
                                        } else if (descuentos.id_paquete == 294) {
                                            $scope.engancheCincoMilL2 = 1;
                                        } else if (descuentos.id_paquete == 299) {
                                            $scope.engancheVeintiCincoMilL = 1;
                                        } else if (descuentos.id_paquete == 307) {
                                            $scope.helpMxMerida1 = 1;
                                        } else if (descuentos.id_paquete == 308) {
                                            $scope.helpMxMerida2 = 1;
                                        } else if (descuentos.id_paquete == 309) {
                                            $scope.helpMxMerida3 = 1;
                                        } else if (descuentos.id_paquete == 310) {
                                            $scope.helpMxMerida4 = 1;
                                        } else if (descuentos.id_paquete == 311) {
                                            $scope.descDateEneroS1YS2 = 1;
                                        } else if (descuentos.id_paquete == 312) {
                                            $scope.descDateEng0S1YS2 = 1;
                                        } else if (descuentos.id_paquete == 313) {
                                            $scope.engancheDiezMilLSLP = 1;
                                        } else if (descuentos.id_paquete == 267) {
                                            $scope.cinco_milM = 1;
                                        } else if (descuentos.id_paquete == 351) {
                                            $scope.veinteJ_milM = 1;
                                        } else if (descuentos.id_paquete == 354) {
                                            $scope.diez_milM = 1;
                                        } else if (descuentos.id_paquete == 317) {
                                            $scope.cinco_milL = 1;
                                        } else if (descuentos.id_paquete == 320) {
                                            $scope.diez_milL = 1;
                                        } else if (descuentos.id_paquete == 324) {
                                            $scope.veinticinco_milL = 1;
                                        } else if (descuentos.id_paquete == 329) {
                                            $scope.cinco_milLM = 1;
                                        } else if (descuentos.id_paquete == 333) {
                                            $scope.veinticinco_milLM = 1;
                                        } else if (descuentos.id_paquete == 360) {
                                            $scope.ceroQ1 = 1;
                                        } else if (descuentos.id_paquete == 361) {
                                            $scope.ceroQ2 = 1;
                                        } else if (descuentos.id_paquete == 362) {
                                            $scope.ceroQ3 = 1;
                                        } else if (descuentos.id_paquete == 365) {
                                            $scope.ceroQ4 = 1;
                                        } else if (descuentos.id_paquete == 366) {
                                            $scope.cyd_slp1 = 1;
                                        } else if (descuentos.id_paquete == 367) {
                                            $scope.cyd_slp2 = 1;
                                        } else if (descuentos.id_paquete == 370) {
                                            $scope.cincoCSLP = 1;
                                        } else if (descuentos.id_paquete == 373) {
                                            $scope.veinticinco_milLM2 = 1;
                                        } else if (descuentos.id_paquete == 378) {
                                            $scope.cincoCL = 1;
                                        }

                                    } else if (descuentos.id_paquete != 261 || descuentos.id_paquete != 151 || descuentos.id_paquete != 368 || descuentos.id_paquete != 369 || descuentos.id_paquete != 263 || descuentos.id_paquete != 268
                                        || descuentos.id_paquete != 269 || descuentos.id_paquete != 265 || descuentos.id_paquete != 270 || descuentos.id_paquete != 271 || descuentos.id_paquete != 272
                                        || descuentos.id_paquete != 273 || descuentos.id_paquete != 274 || descuentos.id_paquete != 275 || descuentos.id_paquete != 276
                                        || descuentos.id_paquete != 278 || descuentos.id_paquete != 279 || descuentos.id_paquete != 280 || descuentos.id_paquete != 281

                                        || descuentos.id_paquete != 283 || descuentos.id_paquete != 284 || descuentos.id_paquete != 285 || descuentos.id_paquete != 286 || descuentos.id_paquete != 287


                                        || descuentos.id_paquete != 289 || descuentos.id_paquete != 290 || descuentos.id_paquete != 291 || descuentos.id_paquete != 292 || descuentos.id_paquete != 293
                                        || descuentos.id_paquete != 295 || descuentos.id_paquete != 296 || descuentos.id_paquete != 297 || descuentos.id_paquete != 298

                                        || descuentos.id_paquete != 300 || descuentos.id_paquete != 301 || descuentos.id_paquete != 302 || descuentos.id_paquete != 303
                                        || descuentos.id_paquete != 304 || descuentos.id_paquete != 305

                                        || descuentos.id_paquete != 262

                                        || descuentos.id_paquete != 277 || descuentos.id_paquete != 282 || descuentos.id_paquete != 288 || descuentos.id_paquete != 294
                                        || descuentos.id_paquete != 299 || descuentos.id_paquete != 307 || descuentos.id_paquete != 308 || descuentos.id_paquete != 309 || descuentos.id_paquete != 310


                                        || descuentos.id_paquete != 311 || descuentos.id_paquete != 312
                                        || descuentos.id_paquete != 313

                                        || descuentos.id_paquete != 267
                                        || descuentos.id_paquete != 351
                                        || descuentos.id_paquete != 354


                                        || descuentos.id_paquete != 317
                                        || descuentos.id_paquete != 320
                                        || descuentos.id_paquete != 324

                                        || descuentos.id_paquete != 329
                                        || descuentos.id_paquete != 333


                                        || descuentos.id_paquete != 360
                                        || descuentos.id_paquete != 361
                                        || descuentos.id_paquete != 362
                                        || descuentos.id_paquete != 365


                                        || descuentos.id_paquete != 366
                                        || descuentos.id_paquete != 367

                                        || descuentos.id_paquete != 370
                                        || descuentos.id_paquete != 373
                                        || descuentos.id_paquete != 378

                                    ) {
                                        $scope.descDateEnero = 0;
                                        $scope.noPagomensualidad = 0;
                                        $scope.descMSI = 0;
                                        $scope.descDateOctubre = 0;
                                        $scope.descDateMayoMerida = 0;
                                        $scope.descDateSeptiembreMerida = 0;
                                        $scope.descDateEneroMerida = 0;
                                        $scope.descDateEneroMeridaC = 0;
                                        $scope.descDateMayoMeridaC = 0;
                                        $scope.descDateSeptiembreMeridaC = 0;
                                        $scope.descDateEneroLM1 = 0;
                                        $scope.descDateEneroLM2 = 0;
                                        $scope.descDateEneroLM3 = 0;
                                        $scope.descDateSepLM4 = 0;


                                        $scope.descDateEneroLM1C = 0;
                                        $scope.descDateEneroLM2C = 0;
                                        $scope.descDateSepLM3C = 0;
                                        $scope.descDateSepLM4C = 0;

                                        $scope.descDateEneroL1 = 0;
                                        $scope.descDateEneroL2 = 0;
                                        $scope.descDateEneroL3 = 0;
                                        $scope.descDateEneroL4 = 0;
                                        $scope.descDateSepL1 = 0;

                                        $scope.descDateEneroL5 = 0;
                                        $scope.descDateEneroL6 = 0;
                                        $scope.descDateEneroL7 = 0;
                                        $scope.descDateSepL2 = 0;
                                        $scope.descDateSepL3 = 0;

                                        $scope.descDateEneroL8 = 0;
                                        $scope.descDateEneroL9 = 0;
                                        $scope.descDateSepL4 = 0;
                                        $scope.descDateSepL5 = 0;


                                        $scope.descDateEneroAllQro1 = 0;
                                        $scope.descDateEneroAllQro2 = 0;
                                        $scope.descDateSepAllQro1 = 0;
                                        $scope.descDateSepAllQro2 = 0;
                                        $scope.descDateMayoAllQro1 = 0;
                                        $scope.descDateMayoAllQro2 = 0;


                                        $scope.descDateMayoSLP = 0;
                                        $scope.engancheCincoMil = 0;
                                        $scope.engancheVeintiCincoMilMerida = 0;

                                        $scope.engancheCincoMilLM = 0;
                                        $scope.engancheVeintiCincoMilLM = 0;
                                        $scope.engancheCincoMilL1 = 0;
                                        $scope.engancheCincoMilL2 = 0;
                                        $scope.engancheVeintiCincoMilL = 0;


                                        $scope.helpMxMerida1 = 0;
                                        $scope.helpMxMerida2 = 0;
                                        $scope.helpMxMerida3 = 0;
                                        $scope.helpMxMerida4 = 0;

                                        $scope.descDateEneroS1YS2 = 0;
                                        $scope.descDateEng0S1YS2 = 0;
                                        $scope.engancheDiezMilLSLP = 0;

                                        $scope.cinco_milM = 0;
                                        $scope.veinteJ_milM = 0;
                                        $scope.diez_milM = 0;


                                        $scope.cinco_milL = 0;
                                        $scope.diez_milL = 0;
                                        $scope.veinticinco_milL = 0;

                                        $scope.cinco_milLM = 0;
                                        $scope.veinticinco_milLM = 0;


                                        $scope.ceroQ1 = 0;
                                        $scope.ceroQ2 = 0;
                                        $scope.ceroQ3 = 0;
                                        $scope.ceroQ4 = 0;

                                        $scope.cyd_slp1 = 0;
                                        $scope.cyd_slp2 = 0;


                                        $scope.cincoCSLP = 0;

                                        $scope.veinticinco_milLM2 = 0;
                                        $scope.cincoCL = 0;


                                    }

                                }

                            }
                            //console.log("El valor del indez del arreglo es: "+idx);
                            calcularCF();
                        }
                        //Termina Reinicia los valores del arreglo que trae descuentos


                        $scope.superficie = response.data[0].sup;
                        $scope.preciom2 = response.data[0].precio;
                        $scope.total = response.data[0].total;
                        $scope.porcentajeInv = response.data[0].porcentaje;
                        $scope.enganche = response.data[0].enganche;
                        $scope.CurrentDate = new Date();

                        $scope.nombreLote = response.data[0].nombreLote;
                        $scope.precioTotal = response.data[0].total;
                        $scope.superficie = response.data[0].sup;
                        $scope.preciom2 = response.data[0].precio;

                        $scope.banco = response.data[0].banco;
                        $scope.rsocial = response.data[0].empresa;
                        $scope.cuenta = response.data[0].cuenta;
                        $scope.clabe = response.data[0].clabe;
                        $scope.referencia = response.data[0].referencia;
                        $scope.msni = parseInt(response.data[0].msni);
                        calcularCF();


                        //*Reset vars from eng days
                        var apartado = angular.element(document.querySelector('#aptdo'));
                        var mesesdiferidos = angular.element(document.querySelector('#msdif'));
                        var checkPack = angular.element(document.querySelector('#checkPack'));
                        var cehboxInterno = angular.element(document.querySelector('#paquete.id_paquete'));
                        var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
                        var cantidadEnganche = angular.element(document.querySelector('#cantidadEnganche'));
                        $scope.diasEnganche = [{day: 15}, {day: 30}, {day: 'Diferido'}];
                        $scope.cantidad = "";
                        porcentajeEnganche.val('10');
                        apartado.val('0');
                        $scope.porcentajeEng = "10";
                        cantidadEnganche.val(response.data[0].enganche);
                        mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');


                        calcularCF();

                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                        $http.post('<?=base_url()?>index.php/corrida/descuentos', {lote: response.data[0].idLote}).then(
                            function (paquetes) {
                                $scope.paquetes = paquetes.data;
                            },
                            function (paquetes) {
                            });
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////

                    },
                    function (response) {
                    });
            }

            $http.post("<?=base_url()?>index.php/corrida/getGerenteByID", {gerente: <?=$data_corrida->id_gerente?>}).then(
                function (data) {
                    $scope.gerentes = data.data;
                },
                function (data) {
                });

            $scope.onSelectChangegerente = function (gerente) {
                $http.post('<?=base_url()?>index.php/corrida/getCoordinadorByID', {coordinador: coordinador.idCoordinador}).then(
                    function (response) {
                        $scope.coordinadores = response.data;
                    },
                    function (response) {
                    });
            }

            $scope.onSelectChangecoord = function (coordinador) {
                $http.post('<?=base_url()?>index.php/corrida/getAsesor', {coordinador: coordinador.idCoordinador}).then(
                    function (response) {
                        $scope.asesores = response.data;
                    },
                    function (response) {
                    });
            }


            $scope.payPlan = function () {
                var planPay = $scope.plan;
                var yearplan = angular.element(document.querySelector('#yearplan'));
                var day = angular.element(document.querySelector('#day'));
                var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
                var cantidadEnganche = angular.element(document.querySelector('#cantidadEnganche'));
                var aptdo = angular.element(document.querySelector('#aptdo'));
                var msdif = angular.element(document.querySelector('#msdif'));
                if (planPay == 'Crédito') {
                    yearplan.prop('disabled', false);
                    day.prop('disabled', false);
                    porcentajeEnganche.val($scope.porcentajeInv);
                    porcentajeEnganche.prop('disabled', false);
                    cantidadEnganche.val($scope.enganche);
                    cantidadEnganche.prop('disabled', false);
                    aptdo.prop('disabled', true);
                    msdif.prop('disabled', true);
                    $scope.engancheFinal = ($scope.infoLote.engancheF);
                    $scope.porcentajeEng = 10;
                    calcularCF();
                } else if (planPay == 'Contado') {
                    yearplan.prop('disabled', true);
                    day.prop('disabled', true);
                    porcentajeEnganche.val("");
                    porcentajeEnganche.prop('disabled', true);
                    cantidadEnganche.val("");
                    cantidadEnganche.prop('disabled', true);
                    aptdo.prop('disabled', true);
                    msdif.prop('disabled', true);
                    $scope.engancheFinal = "";
                    $scope.porcentajeEng = 0;
                    calcularCF();
                }
            }


            $scope.exportc = function () {

                var nombre = ($scope.nombre == undefined) ? 0 : $scope.nombre;
                var id_lote = ($scope.lote == undefined) ? 0 : $scope.lote.idLote;
                var edad = ($scope.age == undefined) ? 0 : $scope.age.age;
                var telefono = ($scope.telefono == undefined) ? 0 : $scope.telefono;
                var correo = ($scope.email == undefined) ? 0 : $scope.email;
                var asesor = ($scope.asesor == undefined) ? 0 : $scope.asesor.idAsesor;
                var coordinador = ($scope.coordinador == undefined) ? 0 : $scope.coordinador.idCoordinador;
                var gerente = ($scope.gerente == undefined) ? 0 : $scope.gerente.idGerente;
                var plan = ($scope.plan == undefined) ? 0 : $scope.plan;

                //-------
                var anio2 = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;

                if (plan == 'Crédito') {
                    var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;
                } else if (plan == 'Contado') {
                    var anio = 'Activo';
                }

                var dias_pagar_enganche = ($scope.day == undefined) ? 0 : $scope.day.day;
                var porcentaje_enganche = ($scope.porcentaje == undefined) ? 0 : $scope.porcentaje;
                var cantidad_enganche = ($scope.cantidad == undefined) ? 0 : $scope.cantidad;
                var meses_diferir = ($scope.mesesdiferir == undefined) ? 0 : $scope.mesesdiferir;
                var apartado = ($scope.apartado == undefined) ? 0 : $scope.apartado;

                var paquete = ($scope.descApply == undefined) ? 0 : $scope.descApply[0].id_paquete;


                if (paquete > 0) {
                    var paqueteEach = $scope.descApply;


                    if (paqueteEach.length == 1) {
                        if (paqueteEach[0].apply == null) {

                            var opcion_paquete = 0;
                            var precio_m2_final = $scope.preciom2;

                        } else {
                            var joinDesc = [];

                            for (var descuentos of paqueteEach) {
                                joinDesc.push(descuentos.id_descuento);
                            }
                            var cadenaDesc = joinDesc.join(',');
                            var opcion_paquete = cadenaDesc;
                            var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;
                        }

                    } else {

                        var joinDesc = [];
                        for (var descuentos of paqueteEach) {
                            joinDesc.push(descuentos.id_descuento);
                        }
                        var cadenaDesc = joinDesc.join(',');
                        var opcion_paquete = cadenaDesc;
                        var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;


                    }


                } else if (paquete == 0) {
                    var opcion_paquete = 0;
                    var precio_m2_final = $scope.preciom2;
                }

                if (id_lote > 0) {

                    var saldoc = $scope.saldoFinal;
                    var precioFinalc = $scope.precioFinal;
                    var fechaEngc = ($scope.fechaEng == undefined) ? 0 : $scope.fechaEng
                    var engancheFinalc = $scope.engancheFinal;
                    var msi_1p = ($scope.totalPrimerPlan == undefined) ? 0 : $scope.totalPrimerPlan;
                    var msi_2p = ($scope.totalSegundoPlan == undefined) ? 0 : $scope.totalSegundoPlan;
                    var msi_3p = ($scope.totalTercerPlan == undefined) ? 0 : $scope.totalTercerPlan;
                    var primer_mensualidad = $scope.fechaPM;
                    var allDescuentos = $scope.decFin;

                    var finalMesesp1 = ($scope.finalMesesp1 == 0 || $scope.finalMesesp1 == undefined) ? 0 : $scope.finalMesesp1;
                    var finalMesesp2 = ($scope.finalMesesp2 == 0 || $scope.finalMesesp2 == undefined) ? 0 : $scope.finalMesesp2;
                    var finalMesesp3 = ($scope.finalMesesp3 == 0 || $scope.finalMesesp3 == undefined) ? 0 : $scope.finalMesesp3;


                }
                var observaciones = ($scope.observaciones == undefined) ? "" : $scope.observaciones;


                var loaderDiv = angular.element(document.querySelector('#loaderDiv'));

                if (nombre == 0 || edad == 0 || id_lote ==   0 || plan == 0 || anio2 == 0 || gerente == 0 || asesor == 0) {


                    $.confirm({
                        title: '¡Alerta!',
                        content: '¡Asegúrese de llenar los campos marcados' + '!',
                        typeAnimated: true,
                        icon: 'fa fa-warning',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'orange',
                        buttons: {
                            cancel: {
                                text: 'OK',
                                action: function () {
                                    toastr.success('¡Ahora! Cotizemos.');
                                }
                            }
                        }
                    });


                    if (nombre == 0) {
                        document.getElementById("nombretext").innerHTML = 'Requerido';
                        $('#nombre').css("border-color", "red");
                    }
                    /*else{
                  document.getElementById("nombretext").innerHTML ='';
                  $('#nombre').css("border-color", "");
                 } */
                    if (edad == 0) {
                        document.getElementById("edadtext").innerHTML = 'Requerido';
                        $('#edad').css("border-color", "red");
                    }
                    if (id_lote == 0) {
                        document.getElementById("lotetext").innerHTML = 'Requerido';
                        $('#lote').css("border-color", "red");
                    }
                    if (plan == 0) {
                        document.getElementById("plantext").innerHTML = 'Requerido';
                        $('#planSL').css("border-color", "red");
                    }

                    if (gerente == 0) {
                        document.getElementById("gerentetext").innerHTML = 'Requerido';
                        $('#gerente').css("border-color", "red");
                    }

                    if (asesor == 0) {
                        document.getElementById("asesortext").innerHTML = 'Requerido';
                        $('#asesor').css("border-color", "red");
                    }

                    if (anio2 == 0) {
                        document.getElementById("aniotext").innerHTML = 'Requerido';
                        $('#yearplan').css("border-color", "red");
                    }


                } else {

                    anio = (anio == 'Activo') ? '0' : anio;


                    $http.post('<?=base_url()?>index.php/corrida/editar_ds', {
                        nombre: nombre,
                        id_lote: id_lote,
                        edad: edad,
                        telefono: telefono,
                        correo: correo,
                        asesor: asesor,
                        gerente: gerente,
                        plan: plan,
                        anio: anio,
                        dias_pagar_enganche: dias_pagar_enganche,
                        porcentaje_enganche: porcentaje_enganche,
                        cantidad_enganche: cantidad_enganche,
                        meses_diferir: meses_diferir,
                        apartado: apartado,
                        paquete: paquete,
                        opcion_paquete: opcion_paquete,
                        precio_m2_final: precio_m2_final,
                        saldoc: saldoc,
                        precioFinalc: precioFinalc,
                        fechaEngc: fechaEngc,
                        engancheFinalc: engancheFinalc,
                        msi_1p: msi_1p,
                        msi_2p: msi_2p,
                        msi_3p: msi_3p,
                        primer_mensualidad: primer_mensualidad,
                        allDescuentos: allDescuentos,
                        finalMesesp1: finalMesesp1,
                        finalMesesp2: finalMesesp2,
                        finalMesesp3: finalMesesp3,
                        observaciones: observaciones
                    }).then(
                        function (response) {

                            if (response.data.message == 'OK') {

                                var data = $scope.alphaNumeric;
                                var id_corrida = response.data[0].id_corrida;

                                $http.post('<?=base_url()?>index.php/corrida/insertCorrida', {
                                    data: data,
                                    id_corrida: id_corrida
                                }).then(
                                    function (data) {

                                        $window.open("<?=base_url()?>index.php/corrida/caratula/" + id_corrida);
                                        loaderDiv.addClass('hide');

                                    },
                                    function (response) {
                                    });

                                toastr.success('Corrida guardada exitosamente');
                                loaderDiv.removeClass('hide');

                            } else if (response.data.message == 'ERROR') {
                                toastr.error('Error al guardar corrida');
                            }
                        },
                        function () {
                        });

                }

            }


            $scope.exportcf = function () {

                var nombre = ($scope.nombre == undefined) ? 0 : $scope.nombre;
                var id_lote = ($scope.lote == undefined) ? 0 : $scope.lote.idLote;
                var edad = ($scope.age == undefined) ? 0 : $scope.age.age;
                var telefono = ($scope.telefono == undefined) ? 0 : $scope.telefono;
                var correo = ($scope.email == undefined) ? 0 : $scope.email;
                var asesor = ($scope.asesor == undefined) ? 0 : $scope.asesor.idAsesor;
                var coordinador = ($scope.coordinador == undefined) ? 0 : $scope.coordinador.idCoordinador;
                var gerente = ($scope.gerente == undefined) ? 0 : $scope.gerente.idGerente;
                var plan = ($scope.plan == undefined) ? 0 : $scope.plan;
                var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;

                if (plan == 'Crédito') {
                    var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;
                } else if (plan == 'Contado') {
                    var anio = 'Activo';
                }

                var dias_pagar_enganche = ($scope.day == undefined) ? 0 : $scope.day;
                var porcentaje_enganche = ($scope.porcentaje == undefined) ? 0 : $scope.porcentaje;
                var cantidad_enganche = ($scope.cantidad == undefined) ? 0 : $scope.cantidad;
                var meses_diferir = ($scope.mesesdiferir == undefined) ? 0 : $scope.mesesdiferir;
                var apartado = ($scope.apartado == undefined) ? 0 : $scope.apartado;

                var paquete = ($scope.descApply == undefined) ? 0 : $scope.descApply[0].id_paquete;

                if (paquete > 0) {
                    var paqueteEach = $scope.descApply;


                    if (paqueteEach.length == 1) {
                        if (paqueteEach[0].apply == null) {

                            var opcion_paquete = 0;
                            var precio_m2_final = $scope.preciom2;

                        } else {
                            var joinDesc = [];

                            for (var descuentos of paqueteEach) {
                                joinDesc.push(descuentos.id_descuento);
                            }
                            var cadenaDesc = joinDesc.join(',');
                            var opcion_paquete = cadenaDesc;
                            var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;
                        }

                    } else {

                        var joinDesc = [];
                        for (var descuentos of paqueteEach) {
                            joinDesc.push(descuentos.id_descuento);
                        }
                        var cadenaDesc = joinDesc.join(',');
                        var opcion_paquete = cadenaDesc;
                        var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;


                    }


                } else if (paquete == 0) {
                    var opcion_paquete = 0;
                    var precio_m2_final = $scope.preciom2;
                }

                if (id_lote > 0) {

                    var saldoc = $scope.saldoFinal;
                    var precioFinalc = $scope.precioFinal;
                    var fechaEngc = ($scope.fechaEng == undefined) ? 0 : $scope.fechaEng
                    var engancheFinalc = $scope.engancheFinal;
                    var msi_1p = ($scope.totalPrimerPlan == undefined) ? 0 : $scope.totalPrimerPlan;
                    var msi_2p = ($scope.totalSegundoPlan == undefined) ? 0 : $scope.totalSegundoPlan;
                    var msi_3p = ($scope.totalTercerPlan == undefined) ? 0 : $scope.totalTercerPlan;
                    var primer_mensualidad = $scope.fechaPM;
                    var allDescuentos = $scope.decFin;

                    var finalMesesp1 = ($scope.finalMesesp1 == 0 || $scope.finalMesesp1 == undefined) ? 0 : $scope.finalMesesp1;
                    var finalMesesp2 = ($scope.finalMesesp2 == 0 || $scope.finalMesesp2 == undefined) ? 0 : $scope.finalMesesp2;
                    var finalMesesp3 = ($scope.finalMesesp3 == 0 || $scope.finalMesesp3 == undefined) ? 0 : $scope.finalMesesp3;


                }
                var observaciones = ($scope.observaciones == undefined) ? 0 : $scope.observaciones;

                var loaderDiv = angular.element(document.querySelector('#loaderDiv'));

                if (nombre == 0 || edad == 0 || id_lote == 0 || plan == 0 || anio == 0 || gerente == 0 || asesor == 0) {


                    $.confirm({
                        title: '¡Alerta!',
                        content: '¡Asegúrese de llenar los campos marcados' + '!',
                        typeAnimated: true,
                        icon: 'fa fa-warning',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'orange',
                        buttons: {
                            cancel: {
                                text: 'OK',
                                action: function () {
                                    toastr.success('¡Ahora! Cotizemos.');
                                }
                            }
                        }
                    });


                    if (nombre == 0) {
                        document.getElementById("nombretext").innerHTML = 'Requerido';
                        $('#nombre').css("border-color", "red");
                    }
                    /*else{
                  document.getElementById("nombretext").innerHTML ='';
                  $('#nombre').css("border-color", "");
                 } */
                    if (edad == 0) {
                        document.getElementById("edadtext").innerHTML = 'Requerido';
                        $('#edad').css("border-color", "red");
                    }
                    if (id_lote == 0) {
                        document.getElementById("lotetext").innerHTML = 'Requerido';
                        $('#lote').css("border-color", "red");
                    }
                    if (plan == 0) {
                        document.getElementById("plantext").innerHTML = 'Requerido';
                        $('#planSL').css("border-color", "red");
                    }

                    if (gerente == 0) {
                        document.getElementById("gerentetext").innerHTML = 'Requerido';
                        $('#gerente').css("border-color", "red");
                    }

                    if (asesor == 0) {
                        document.getElementById("asesortext").innerHTML = 'Requerido';
                        $('#asesor').css("border-color", "red");
                    }

                    if (anio == 0) {
                        document.getElementById("aniotext").innerHTML = 'Requerido';
                        $('#yearplan').css("border-color", "red");
                    }


                } else {

                    anio = (anio == 'Activo') ? '0' : anio;

                    $http.post('<?=base_url()?>index.php/corrida/editar_ds', {
                        nombre: nombre,
                        id_lote: id_lote,
                        edad: edad,
                        telefono: telefono,
                        correo: correo,
                        asesor: asesor,
                        gerente: gerente,
                        plan: plan,
                        anio: anio,
                        dias_pagar_enganche: dias_pagar_enganche,
                        porcentaje_enganche: porcentaje_enganche,
                        cantidad_enganche: cantidad_enganche,
                        meses_diferir: meses_diferir,
                        apartado: apartado,
                        paquete: paquete,
                        opcion_paquete: opcion_paquete,
                        precio_m2_final: precio_m2_final,
                        saldoc: saldoc,
                        precioFinalc: precioFinalc,
                        fechaEngc: fechaEngc,
                        engancheFinalc: engancheFinalc,
                        msi_1p: msi_1p,
                        msi_2p: msi_2p,
                        msi_3p: msi_3p,
                        primer_mensualidad: primer_mensualidad,
                        allDescuentos: allDescuentos,
                        finalMesesp1: finalMesesp1,
                        finalMesesp2: finalMesesp2,
                        finalMesesp3: finalMesesp3,
                        observaciones: observaciones
                    }).then(
                        function (response) {

                            if (response.data.message == 'OK') {

                                var data = $scope.alphaNumeric;
                                var id_corrida = response.data[0].id_corrida;

                                $http.post('<?=base_url()?>index.php/corrida/insertCorrida', {
                                    data: data,
                                    id_corrida: id_corrida
                                }).then(
                                    function (data) {

                                        $window.open("<?=base_url()?>index.php/corrida/caratulacf/" + id_corrida);
                                        loaderDiv.addClass('hide');

                                    },
                                    function (response) {
                                    });
                                toastr.success('Corrida guardada exitosamente');
                                loaderDiv.removeClass('hide');

                            } else if (response.data.message == 'ERROR') {
                                toastr.error('Error al guardar corrida');
                            }
                        },
                        function () {
                        });

                }

            }


            $scope.dtoptions = DTOptionsBuilder;


            $scope.dtColumns = [
                DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
                DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
                DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
                    return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
                }),
                DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
                    return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
                }),
                DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
                    return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
                }),
                DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
                    return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
                })
            ];


            /***********
             * MARCADOR CHACHA NUEVAS FUNCIONES
             * ***************/
            $scope.printCover = function(){
                let id_corrida = <?php echo $data_corrida->id_corrida;?>;
                toastr.success('Generando carátula...');
                $window.open("<?=base_url()?>index.php/corrida/caratula/" + id_corrida);
            }
            $scope.printCoverCF = function(){
                let id_corrida = <?php echo $data_corrida->id_corrida;?>;
                toastr.success('Generando carátula...');
                $window.open("<?=base_url()?>index.php/corrida/caratulacf/" + id_corrida);
            }
            $scope.updateCorrida = function () {

                console.log('actualiza la corrida');
                console.log('$scope.descApply: ', $scope.descApply);


                var nombre = ($scope.nombre == undefined) ? 0 : $scope.nombre;
                var id_lote = ($scope.lote == undefined) ? 0 : $scope.lote;
                var edad = ($scope.age == undefined) ? 0 : $scope.age
                var telefono = ($scope.telefono == undefined) ? 0 : $scope.telefono;
                var correo = ($scope.email == undefined) ? 0 : $scope.email;
                var asesor = ($scope.asesor == undefined) ? 0 : $scope.asesor;
                var coordinador = ($scope.coordinador == undefined) ? 0 : $scope.coordinador;
                var gerente = ($scope.gerente == undefined) ? 0 : $scope.gerente;
                var plan = ($scope.plan == undefined) ? 0 : $scope.plan;
                var fechaApartadoI = ($scope.fechaApartado == undefined) ? 0 : $scope.fechaApartado;


                //-------
                var anio2 = ($scope.yearplan == undefined) ? 0 : $scope.yearplan;

                if (plan == 'Crédito') {
                    var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan;
                } else if (plan == 'Contado') {
                    var anio = 'Activo';
                }

                console.log("nombre: ", $scope.nombre);
                console.log("edad: ", $scope.age);
                console.log("id_lote: ", $scope.lote);
                console.log("plan: ", $scope.plan);
                console.log("anio2: ", anio2);
                console.log("gerente: ", $scope.gerente);
                console.log("asesor: ", $scope.asesor);
                console.log("Telefono: ", $scope.telefono);


                var dias_pagar_enganche = ($scope.day == undefined) ? 0 : $scope.day;
                var porcentaje_enganche = ($scope.porcentaje == undefined) ? 0 : $scope.porcentaje;
                var cantidad_enganche = ($scope.cantidad == undefined) ? 0 : $scope.cantidad;
                var meses_diferir = ($scope.mesesdiferir == undefined) ? 0 : $scope.mesesdiferir;
                var apartado = ($scope.apartado == undefined) ? 0 : $scope.apartado;

                var paquete = ($scope.descApply == undefined || $scope.descApply.length == 0) ? 0 : $scope.descApply[0].id_paquete;

                console.log("dias_pagar_enganche: ", dias_pagar_enganche);
                console.log("porcentaje_enganche: ", porcentaje_enganche);
                console.log("cantidad_enganche: ", cantidad_enganche);
                console.log("meses_diferir: ", meses_diferir);
                console.log("apartado: ", apartado);
                console.log("paquete: ", paquete);


                if (paquete > 0) {
                    var paqueteEach = $scope.descApply;

                    if (paqueteEach.length == 1) {
                        if (paqueteEach[0].apply == null) {

                            var opcion_paquete = 0;
                            var precio_m2_final = $scope.preciom2;

                        } else {
                            var joinDesc = [];

                            for (var descuentos of paqueteEach) {
                                joinDesc.push(descuentos.id_descuento);
                            }
                            var cadenaDesc = joinDesc.join(',');
                            var opcion_paquete = cadenaDesc;
                            // var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;
                            const closest = $scope.decFin.reduce(
                                (acc, loc) =>
                                    acc.pm < loc.pm
                                        ? acc
                                        : loc
                            )
                            var precio_m2_final = closest.pm;
                            console.log("pa poner el verdadero ELSE: ", closest.pm);
                        }

                    } else {

                        var joinDesc = [];
                        for (var descuentos of paqueteEach) {
                            joinDesc.push(descuentos.id_descuento);
                        }
                        var cadenaDesc = joinDesc.join(',');
                        var opcion_paquete = cadenaDesc;
                        // var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;
                        const closest = $scope.decFin.reduce(
                            (acc, loc) =>
                                acc.pm < loc.pm
                                    ? acc
                                    : loc
                        )
                        var precio_m2_final = closest.pm;
                        console.log("pa poner el verdadero ELSE: ", closest.pm);

                    }


                } else if (paquete == 0) {
                    var opcion_paquete = 0;
                    var precio_m2_final = $scope.preciom2;
                }
                console.log("opcion_paquete: ", opcion_paquete);
                if (id_lote > 0) {
                    var saldoc = $scope.saldoFinal;
                    var precioFinalc = $scope.precioFinal;
                    var fechaEngc = ($scope.fechaEng == undefined) ? 0 : $scope.fechaEng
                    var engancheFinalc = $scope.engancheFinal;
                    var msi_1p = ($scope.totalPrimerPlan == undefined) ? 0 : $scope.totalPrimerPlan;
                    var msi_2p = ($scope.totalSegundoPlan == undefined) ? 0 : $scope.totalSegundoPlan;
                    var msi_3p = ($scope.totalTercerPlan == undefined) ? 0 : $scope.totalTercerPlan;
                    var primer_mensualidad = $scope.fechaPM;
                    var allDescuentos = $scope.decFin;

                    var finalMesesp1 = ($scope.finalMesesp1 == 0 || $scope.finalMesesp1 == undefined) ? 0 : $scope.finalMesesp1;
                    var finalMesesp2 = ($scope.finalMesesp2 == 0 || $scope.finalMesesp2 == undefined) ? 0 : $scope.finalMesesp2;
                    var finalMesesp3 = ($scope.finalMesesp3 == 0 || $scope.finalMesesp3 == undefined) ? 0 : $scope.finalMesesp3;


                }
                var observaciones = ($scope.observaciones == undefined) ? 0 : $scope.observaciones;

                var loaderDiv = angular.element(document.querySelector('#loaderDiv'));

                if (nombre == 0 || edad == 0 || id_lote == 0 || plan == 0 || anio2 == 0 || gerente == 0 || asesor == 0) {




                    $.confirm({
                        title: '¡Alerta!',
                        content: '¡Asegúrese de llenar los campos marcados' + '!',
                        typeAnimated: true,
                        icon: 'fa fa-warning',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'orange',
                        buttons: {
                            /*cancel: {
                                text: 'OK',
                                action: function () {
                                    toastr.success('¡Ahora! Cotizemos.');
                                }
                            }*/
                        }
                    });


                    if (nombre == 0) {
                        document.getElementById("nombretext").innerHTML = 'Requerido';
                        $('#nombre').css("border-color", "red");
                    }
                    if (edad == 0) {
                        document.getElementById("edadtext").innerHTML = 'Requerido';
                        $('#edad').css("border-color", "red");
                    }
                    if (id_lote == 0) {
                        document.getElementById("lotetext").innerHTML = 'Requerido';
                        $('#lote').css("border-color", "red");
                    }
                    if (plan == 0) {
                        document.getElementById("plantext").innerHTML = 'Requerido';
                        $('#planSL').css("border-color", "red");
                    }

                    if (gerente == 0) {
                        document.getElementById("gerentetext").innerHTML = 'Requerido';
                        $('#gerente').css("border-color", "red");
                    }

                    if (asesor == 0) {
                        document.getElementById("asesortext").innerHTML = 'Requerido';
                        $('#asesor').css("border-color", "red");
                    }

                    if (anio2 == 0) {
                        document.getElementById("aniotext").innerHTML = 'Requerido';
                        $('#yearplan').css("border-color", "red");
                    }


                }
                else {

                    anio = (anio == 'Activo') ? '0' : anio;


                    $http.post('<?=base_url()?>index.php/corrida/update_financialR', {
                        nombre: nombre,
                        id_corrida: <?php echo $data_corrida->id_corrida; ?>,
                        id_lote: id_lote,
                        edad: edad,
                        telefono: telefono,
                        correo: correo,
                        asesor: asesor,
                        gerente: gerente,
                        plan: plan,
                        anio: anio,
                        dias_pagar_enganche: dias_pagar_enganche,
                        porcentaje_enganche: porcentaje_enganche,
                        cantidad_enganche: cantidad_enganche,
                        meses_diferir: meses_diferir,
                        apartado: apartado,
                        paquete: paquete,
                        opcion_paquete: opcion_paquete,
                        precio_m2_final: precio_m2_final,
                        saldoc: saldoc,
                        precioFinalc: precioFinalc,
                        fechaEngc: fechaEngc,
                        engancheFinalc: engancheFinalc,
                        msi_1p: msi_1p,
                        msi_2p: msi_2p,
                        msi_3p: msi_3p,
                        primer_mensualidad: primer_mensualidad,
                        allDescuentos: allDescuentos,
                        finalMesesp1: finalMesesp1,
                        finalMesesp2: finalMesesp2,
                        finalMesesp3: finalMesesp3,
                        observaciones: observaciones,
                        allPackages: localStorage.getItem('allPackages'),
                        descApply: ($scope.descApply != undefined) ? $scope.descApply : null,
                        status: <?php echo $data_corrida->status;?>,
                        fechaApartado: fechaApartadoI
                    }).then(
                        function (response) {

                            if (response.data.message == 'OK') {
                                loaderDiv.removeClass('hide');
                                var data = $scope.alphaNumeric;
                                var id_corrida = response.data.id_corrida;

                                $http.post('<?=base_url()?>index.php/corrida/updateCorrida', {
                                    /*aqui se debe de actualizar la corrida*/
                                    data: data,
                                    id_corrida: id_corrida,
                                    status: <?php echo $data_corrida->corridaStatus;?>,
                                    id_lote: id_lote
                                }).then(
                                    function (data) {
                                        console.log("que onda es el then de response: ", data);

                                        if(data.data.message == 'OK'){
                                            // toastr.success('Generando caratula...');
                                            //$window.open("<?//=base_url()?>//index.php/corrida/caratulacf/" + id_corrida);
                                            // loaderDiv.addClass('hide');
                                            toastr.success('Corrida guardada exitosamente');
                                            loaderDiv.addClass('hide');
                                        }
                                        /**/

                                    },
                                    function (response) {
                                    });

                                // toastr.success('Corrida guardada exitosamente');
                                // loaderDiv.removeClass('hide');

                            } else if (response.data.message == 'ERROR') {
                                toastr.error('Error al guardar corrida');
                                console.log('camaraaaaaa');
                            }
                        },
                        function () {
                        });

                }

            }
        }); /*controlador que cierra*/


        function printDiv(nombreDiv) {
            window.print();
            return true;
        }


        /*------------------*/

        $("#nombre").keypress(function () {
            document.getElementById("nombretext").innerHTML = '';
            $('#nombre').css("border-color", "");
        });

        $("#edad").change(function () {
            document.getElementById("edadtext").innerHTML = '';
            $('#edad').css("border-color", "");
        });

        $("#lote").change(function () {
            document.getElementById("lotetext").innerHTML = '';
            $('#lote').css("border-color", "");
        });

        $("#planSL").change(function () {
            document.getElementById("plantext").innerHTML = '';
            $('#planSL').css("border-color", "");
        });

        $("#gerente").change(function () {
            document.getElementById("gerentetext").innerHTML = '';
            $('#gerente').css("border-color", "");
        });

        $("#asesor").change(function () {
            document.getElementById("asesortext").innerHTML = '';
            $('#asesor').css("border-color", "");
        });

        $("#yearplan").change(function () {
            document.getElementById("aniotext").innerHTML = '';
            $('#yearplan').css("border-color", "");
        });

        /*---------------*/


    </script>


</body>


</html>
