
<!DOCTYPE html>
    <html lang="es_mx"  ng-app="bodyeffect">
<head>
 
<head>
<?php 
setlocale(LC_ALL,"es_ES");
?>
 

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ciudad Maderas | </title>
    <!-- Tell the browser to be responsive to screen width -->

    <link rel="shortcut icon" href="<?=base_url()?>static/images/arbol_cm.png" />


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url()?>dist/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url()?>dist/bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url()?>dist/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?=base_url()?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

<script src="<?=base_url()?>dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<!-- <script src="<?=base_url()?>dist/js/bootstrap.min.js" type="text/javascript"></script> -->
<script src="<?=base_url()?>dist/js/material.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/jquery.validate.min.js"></script>
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<script src="<?=base_url()?>dist/js/chartist.min.js"></script>
<script src="<?=base_url()?>dist/js/jquery.bootstrap-wizard.js"></script>
<script src="<?=base_url()?>dist/js/bootstrap-notify.js"></script>
<script src="<?=base_url()?>dist/js/jquery.sharrre.js"></script>
<script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>dist/js/jquery-jvectormap.js"></script>
<script src="<?=base_url()?>dist/js/nouislider.min.js"></script>
<script src="<?=base_url()?>dist/js/jquery.select-bootstrap.js"></script>
 <script src="<?=base_url()?>dist/js/sweetalert2.js"></script>
<script src="<?=base_url()?>dist/js/jasny-bootstrap.min.js"></script>
<script src="<?=base_url()?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/jquery.tagsinput.js"></script>
<script src="<?=base_url()?>dist/js/material-dashboard.js"></script>
<script src="<?=base_url()?>dist/js/demo.js"></script>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/dataTables.buttons.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/angular-datatables.buttons.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/angular-datatables.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.html5.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.colVis.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.flash.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.print.min.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("static/angular/datatable/dataTables.editor.min.js")?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?= base_url("static/angular/datatable/buttons.dataTables.min.css")?>">
    <link rel="stylesheet" href="<?= base_url("static/angular/datatable/editor.dataTables.min.css")?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
    <script type="text/javascript" src="<?= base_url("dist/js/angularjs-dropdown-multiselect.js")?>"></script>
    <script type="text/javascript" src="<?= base_url("dist/js/calcularAC.js")?>"></script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/angular.checklist-model/0.1.3/checklist-model.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <!-- <script src="<?= base_url("dist/js/select2.full.min.js")?>"></script> -->
    
 
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        .contenedorinputs {
            position: relative;
        }
        ul li{
            list-style: none;
            display: block;
            padding-bottom: 2em;
        }
        .inputradio{
            opacity: 0; /* Ocultamos el input verdadero con opacity: 0 */
            width: 20px;
            height: 20px;
            position: absolute;
            left: 0px;
        }
        .inputfalso{
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
            background-color: #296D5D;
            color: #fff;
            padding: 3px 6px;
        }

        .output {
            font: 1rem 'Fira Sans', sans-serif;
        }

        .foreach {
            background: #4C9B79;
            height: 15.5em;
            width:auto;
            border-radius: 10px;
            padding:10px;
            font-size:15px;
            color:#fff;
            margin-bottom: 30px;

        }
        .btn-circle.btn-xl {
            width: 70px;
            height: 70px;
            padding: 10px 16px;
            border-radius: 35px;
            font-size: 24px;
            line-height: 1.33;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }
        .float-right
        {
            position:fixed;
            bottom: 5%;
            right: 3%;
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
            -webkit-animation: load1 1s infinite ease-in-out;
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

        .bkLoading
        {
            /* background:#000; *//*b3b3b3*/
            background-image: linear-gradient(to bottom, #000, #000);
            position:absolute;
            top:0%;
            left:0%;
            width:100%;
            height:100%;
            z-index:3;
            padding-top:200px;
            color:white;
            font-weight:300;
            opacity: 0.5;


            /* display:none; */
        }
        .center-align
        {
            text-align:center;
            font-size:2em;
            font-weight:lighter;
        }
        .hide
        {
            display:none;
        }
        /*Terminan los nuevos estilos*/

    </style>
 