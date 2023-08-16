<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends CI_Controller {
	public function __construct() {
		parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->model(array('Chat_modelo'));
                $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
                $this->load->model('Clientes_model');
                
                     //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
                     $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
        $this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        $this->load->library('phpmailer_lib');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

	public function index()
	{
		if($this->session->userdata('id_rol') == FALSE)
		{
			redirect(base_url().'login');
		}
	}
    public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            //echo "<script>console.log('No hay sesión iniciada');</script>";
            redirect(base_url() . "index.php/login");
        }
    }

    public function getNationality(){
        echo json_encode($this->Clientes_model->getNationality()->result_array());
    }

    public function getEstados(){
            echo json_encode($this->Clientes_model->getEstados()->result_array());
        }

public function UserChat()
{
if ($this->session->userdata('id_rol') == 19) {
    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
        $datos['online'] = $this->Chat_modelo->OnlineSG($this->session->userdata('id_sede'))->result();
        $datos['consulta'] = $this->Chat_modelo->ConsultaSG($this->session->userdata('id_sede'))->result();
        $datos['offline'] = $this->Chat_modelo->OfflineSG($this->session->userdata('id_sede'))->result();   
}

elseif ($this->session->userdata('id_rol') != 20 || $this->session->userdata('id_rol') != 28 || $this->session->userdata('id_rol') != 18) {


        if ($this->session->userdata('id_rol') == 28 || $this->session->userdata('id_rol') == 18) {
            $datos['online'] = $this->Chat_modelo->OnlineAdmin()->result();
        $datos['consulta'] = $this->Chat_modelo->ConsultaAdmin()->result();
        $datos['offline'] = $this->Chat_modelo->OfflineAdmin()->result();
        }else{
            $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
$datos['online'] = $this->Chat_modelo->Online($this->session->userdata('id_sede'))->result();
        $datos['consulta'] = $this->Chat_modelo->Consulta($this->session->userdata('id_sede'))->result();
        $datos['offline'] = $this->Chat_modelo->Offline($this->session->userdata('id_sede'))->result();
        }
}else if($this->session->userdata('id_rol') == 20){
    $datos['online'] = $this->Chat_modelo->OnlineSG($this->session->userdata('id_sede'))->result();
    $datos['consulta'] = $this->Chat_modelo->ConsultaSG($this->session->userdata('id_sede'))->result();
    $datos['offline'] = $this->Chat_modelo->OfflineSG($this->session->userdata('id_sede'))->result();
}
        

        if(!empty($datos['permiso']) && $this->session->userdata('id_rol') == 20){
            
            if($this->session->userdata('id_rol') == 20 && $datos['permiso'][0]['estado'] ==0){
              echo '        
                <html>
                    <head>
                        <!-- Bootstrap core CSS     -->
                        <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                        <!--  Material Dashboard CSS    -->
                        <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                        <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                        <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                        <!--     Fonts and icons     -->
                        <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                        <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                        <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                        <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                        <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
                    
                    
                        <!--Ciudad Maderas Estilos-->
                        <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
                    
                        <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
                    </head>
                    <body>
                            <!--AVISO MODAL ACCESO DENEGADO-->
                            <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                <div class="modal-dialog modal-small ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4><span class="material-icons">lock</span><br>
                                                No tiene acceso a este módulo</h4>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </body>
                   
                   <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
                <script>
                    $("#showAvisoNoAccess").modal();
                </script>
                </html>
            ';
            }else
            {
                $this->load->view('template/header');
                $this->load->view("Chat/UserChat", $datos);
            }
        }
        if ($this->session->userdata('id_rol') == 28 || $this->session->userdata('id_rol') == 18) {
           $this->load->view('template/header');
           $this->load->view("Chat/UserChat", $datos);
        }
        if (empty($datos['permiso']) && $this->session->userdata('id_rol') == 20) {
            if($this->session->userdata('id_rol') == 20 && empty($datos['permiso'])){
              echo '        
                <html>
                    <head>
                        <!-- Bootstrap core CSS     -->
                        <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                        <!--  Material Dashboard CSS    -->
                        <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                        <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                        <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                        <!--     Fonts and icons     -->
                        <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                        <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                        <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                        <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                        <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
                    
                    
                        <!--Ciudad Maderas Estilos-->
                        <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
                    
                        <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
                    </head>
                    <body>
                            <!--AVISO MODAL ACCESO DENEGADO-->
                            <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                <div class="modal-dialog modal-small ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4><span class="material-icons">lock</span><br>
                                                No tiene acceso a este módulo</h4>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </body>
                   
                   <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
                <script>
                    $("#showAvisoNoAccess").modal();
                </script>
                </html>
            ';
            }else
            {
                $this->load->view('template/header');
                $this->load->view("Chat/UserChat", $datos);
            }

        }
        if (!empty($datos['permiso']) && $this->session->userdata('id_rol') == 19) {
            if($this->session->userdata('id_rol') == 19 && $datos['permiso'][0]['estado'] ==0){
              echo '        
                <html>
                    <head>
                        <!-- Bootstrap core CSS     -->
                        <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                        <!--  Material Dashboard CSS    -->
                        <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                        <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                        <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                        <!--     Fonts and icons     -->
                        <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                        <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                        <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                        <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                        <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
                    
                    
                        <!--Ciudad Maderas Estilos-->
                        <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
                    
                        <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
                    </head>
                    <body>
                            <!--AVISO MODAL ACCESO DENEGADO-->
                            <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                <div class="modal-dialog modal-small ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4><span class="material-icons">lock</span><br>
                                                No tiene acceso a este módulo</h4>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </body>
                   
                   <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
                <script>
                    $("#showAvisoNoAccess").modal();
                </script>
                </html>
            ';
            }else
            {
                $this->load->view('template/header');
                $this->load->view("Chat/UserChat", $datos);
            }
        }
        if (empty($datos['permiso']) && $this->session->userdata('id_rol') == 19) {
            if($this->session->userdata('id_rol') == 19 && empty($datos['permiso'])){
              echo '        
                <html>
                    <head>
                        <!-- Bootstrap core CSS     -->
                        <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                        <!--  Material Dashboard CSS    -->
                        <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                        <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                        <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                        <!--     Fonts and icons     -->
                        <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                        <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                        <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                        <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                        <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
                    
                    
                        <!--Ciudad Maderas Estilos-->
                        <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
                    
                        <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
                    </head>
                    <body>
                            <!--AVISO MODAL ACCESO DENEGADO-->
                            <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                <div class="modal-dialog modal-small ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4><span class="material-icons">lock</span><br>
                                                No tiene acceso a este módulo</h4>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </body>
                   
                   <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
                <script>
                    $("#showAvisoNoAccess").modal();
                </script>
                </html>
            ';
            }else
            {
                $this->load->view('template/header');
                $this->load->view("Chat/UserChat", $datos);
            }
        }
         

}
    public function Perfil()
    {
        $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();

        $this->load->view('template/header');
        $this->load->view("Chat/Perfil", $datos);

    }
    public function ChatVivo()
    {
           $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();

           $this->load->view('template/header');
           $this->load->view("Chat/ChatVivo", $datos);

    }
    public function HistorialAdmin()
    {
        $this->load->view('template/header');
        $this->load->view("Chat/historialChat");
    }
    public function HistorialProspeccion()
    {
        $this->load->view('template/header');
        $this->load->view("Chat/HistorialGte");
    }

    public function Busqueda(){
    $nombre = $this->input->post("buscar");
    $valor = $this->input->post("estatus");
    $datos = array();
    $datosUser = array();

        if ($valor == 1) {
            switch ($this->session->userdata('id_rol')) {
                case 19:
                    $datosUser= $this->Chat_modelo->usuarios_onlineSGBusqueda($this->session->userdata('id_sede'),$nombre)->result_array();  
                break;
                case 20:
                    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
                    $datosUser = $this->Chat_modelo->usuarios_onlineBusqueda($this->session->userdata('id_sede'),$nombre)->result_array();   
                break;
                case 28:
                    $datosUser = $this->Chat_modelo->usuarios_onlineAdminBusqueda($nombre)->result_array(); 
                break;
            }
        }
        elseif($valor == 2){
            switch ($this->session->userdata('id_rol')) {
                case 19:
                    $datosUser = $this->Chat_modelo->consultaSGBusqueda($this->session->userdata('id_sede'),$nombre)->result_array();   
                break;
                case 20:
                    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();

                    $datosUser = $this->Chat_modelo->ConsultaBusqueda($this->session->userdata('id_sede'),$nombre)->result_array();
                break;
                case 28:
                    $datosUser = $this->Chat_modelo->ConsultaAdminBusqueda($nombre)->result_array(); 
                break;
            }
        }
        elseif($valor == 3){
            switch ($this->session->userdata('id_rol')) {
                case 19:
                    $datosUser = $this->Chat_modelo->OfflineSGBusqueda($this->session->userdata('id_sede'),$nombre)->result_array(); 
                break;
                case 20:
                    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
                    $datosUser = $this->Chat_modelo->OfflineBusqueda($this->session->userdata('id_sede'),$nombre)->result_array();
                break;
                case 28:
                    $datosUser = $this->Chat_modelo->OfflineAdminBusqueda($nombre)->result_array();
                break;
            }
        }

    /**---------------------------- */
    $estatus=0;
    $vista=0;
    $usuarios =  $datosUser;
    for ($i=0; $i < count($usuarios); $i++) { 

        if($usuarios[$i]['estatus'] == 1 && $usuarios[$i]['id_rol'] == 7){
            $estatus=1;
        }

        echo '
        <div class="col-lg-3 col-md-4 col-sm-4 col-6">
            <div class="card" style="margin-bottom:0">
                <div class="container-fluid p-3" style="height: 375px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-img" style="background-image: url(' . base_url() . 'static/images/perfil/'.$usuarios[$i]['id_usuario'].'/'.$usuarios[$i]['foto'].'); background-position: center; background-repeat: no-repeat; background-size: cover;width: 150px; height: 150px; border-radius: 50%; margin: auto;">
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <h3 style="font-size:16px; height: 50px; line-height: 18px"><b>'.$usuarios[$i]['nombre']. ' ' .$usuarios[$i]['apellido_paterno']. ' '.$usuarios[$i]['apellido_materno'].'</b></h3>
                            <p class="title">'.$usuarios[$i]['sede'].'</p>';
                            if ($usuarios[$i]['estatus'] == 3) {
                                $vista =3;
                                echo '<p><span class="label label-danger">Offline</span></p>';
                            }
                            elseif ($usuarios[$i]['estatus'] == 2) {
                                $vista =2;
                                echo '<p><span class="label label-warning">Consulta</span></p>';  
                                $vista =1;
                            }
                            elseif ($usuarios[$i]['estatus'] == 1) {
                                echo '<p><span class="label label-danger" style="background:#27AE60">Online</span></p>';
                                if($usuarios[$i]['id_rol'] == 7){
                                    echo '<a href="#" data-toggle="modal" data-target="#exampleModal_'.$i.'"  title="Cerrar sesión"><i class="material-icons" style="color:red;">power_settings_new</i></a>';
                                }
                            }
                            
                            echo '<div class="modal fade" id="exampleModal_<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cerrar sesión</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">¿ Seguro que deseas cerrar la sesión de '.$usuarios[$i]["nombre"].' ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="button" onclick="Cerrarsesion('.$usuarios[$i]['id_usuario'].','.$i.');" class="btn btn-primary">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin: 24px 0;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    }



    /*-----------------------*/

}
    public function UsersOnline($valor){
        if ($valor == 1) {
            switch ($this->session->userdata('id_rol')) {
                case 19:
                    $datos['usuarios'] = $this->Chat_modelo->usuarios_onlineSG($this->session->userdata('id_sede'))->result_array();
                break;
                case 20:
                    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
                    $datos['usuarios'] = $this->Chat_modelo->usuarios_online($this->session->userdata('id_sede'))->result_array();
                break;
                case 28:
                    $datos['usuarios'] = $this->Chat_modelo->usuarios_onlineAdmin()->result_array();
                break;
            }

            }
            elseif($valor == 2){
                switch ($this->session->userdata('id_rol')) {
                    case 19:
                        $datos['usuarios'] = $this->Chat_modelo->consultaSG($this->session->userdata('id_sede'))->result_array();   
                    break;
                    case 20:
                        $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
                        $datos['usuarios'] = $this->Chat_modelo->Consulta($this->session->userdata('id_sede'))->result_array();
                    break;
                    case 28:
                        $datos['usuarios'] = $this->Chat_modelo->ConsultaAdmin()->result_array(); 
                    break;
                }
        }
        elseif($valor == 3){
            switch ($this->session->userdata('id_rol')) {
                case 19:
                    $datos['usuarios'] = $this->Chat_modelo->OfflineSG($this->session->userdata('id_sede'))->result_array(); 
                break;
                case 20:
                    $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
                    $datos['usuarios'] = $this->Chat_modelo->Offline($this->session->userdata('id_sede'))->result_array();
                break;
                case 28:
                    $datos['usuarios'] = $this->Chat_modelo->OfflineAdmin()->result_array();
                break;
            }
        }
        $this->load->view('template/header');
        $this->load->view("Chat/UsersOnline", $datos); 
    }

public function Chat()
{
        $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
        $datos['carpetas'] = $this->Chat_modelo->getAllFoldersPDF()->result_array();    
        $permiso_estado = (count($datos['permiso']) <= 0 ) ? '' : $datos['permiso'][0]['estado']; 
        if ($this->session->userdata('id_rol') == 7 && empty($datos['permiso'])) {
        echo '        
        <html>
            <head>
                <!-- Bootstrap core CSS     -->
                <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                <!--  Material Dashboard CSS    -->
                <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                <!--     Fonts and icons     -->
                <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
            
                <!--Ciudad Maderas Estilos-->
                <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
            
                <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
            </head>
            <body>
                    <!--AVISO MODAL ACCESO DENEGADO-->
                    <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-small ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                </div>
                                <div class="modal-body text-center">
                                    <h4><span class="material-icons">lock</span><br>
                                        No tiene acceso a este módulo</h4>
                                </div>
                                <div class="modal-footer text-center">
                                    <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </body>
          <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
            <script>
            $("#showAvisoNoAccess").modal();
        </script>
        </html>
        ';
    }
    if($this->session->userdata('id_rol') == 7 && $permiso_estado != 1){
        echo '        
        <html lang="es_mx"  ng-app="CRM">
            <head>
                <!-- Bootstrap core CSS     -->
                <link href="'.base_url().'dist/css/bootstrap.min.css" rel="stylesheet" />
                <!--  Material Dashboard CSS    -->
                <link href="'.base_url().'dist/css/material-dashboard.css" rel="stylesheet" />
                <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                <link href="'.base_url().'dist/css/demo.css" rel="stylesheet" />
                <!--     Fonts and icons     -->
                <link href="'.base_url().'dist/css/font-awesome.css" rel="stylesheet" />
                <link href="'.base_url().'dist/css/google-roboto-300-700.css" rel="stylesheet" />
                <link href="'.base_url().'static/yadcf/jquery.datatables.yadcf.css" rel="stylesheet" type="text/css"/>
                <!--<link href="<?=base_url()?>dist/css/shadowbox.css" rel="stylesheet" />
                <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>-->
            
                <!--Ciudad Maderas Estilos-->
                <link href="'.base_url().'dist/css/cdm-styles.css" rel="stylesheet">
            
                <link href="'.base_url().'dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
            </head>
            <body>
                    <!--AVISO MODAL ACCESO DENEGADO-->
                    <div class="modal fade in" id="showAvisoNoAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-small ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                </div>
                                <div class="modal-body text-center">
                                    <h4><span class="material-icons">lock</span><br>
                                        No tiene acceso a este módulo</h4>
                                </div>
                                <div class="modal-footer text-center">
                                    <a href="'.base_url().'" class="btn btn-primary"  style="padding: 12px 30px!important; margin-left: 5px">Aceptar</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </body>
           
           <script src="'.base_url().'dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/jquery-ui.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/material.min.js" type="text/javascript"></script>
            <script src="'.base_url().'dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
        <script>
            $("#showAvisoNoAccess").modal();
        </script>
        </html>


        ';
    }
    else{
        $this->load->view('template/header');
        $this->load->view("Chat/Chat", $datos);
    }    

}

    public function HistorialGte()
    {
        $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
        $this->load->view('template/header');
        $this->load->view("Chat/HistorialGte", $datos);
    }
    public function ConfiguracionChat()
    {
        if($this->session->userdata('id_rol') != 28 && $this->session->userdata('id_rol') != 18){
            $datos['permiso'] = $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();

        }

        $this->load->view('template/header');
        $this->load->view("Chat/ConfiguracionChat", $datos);
    }
public function UserChats()
{
        $data["data"] = $this->Chat_modelo->UserChats($this->session->userdata('id_sede'))->result_array();

        echo json_encode($data);
        
}
public function MisChats()
{
        $data  = $this->Chat_modelo->MisChats($this->session->userdata('id_usuario'))->result();

        echo json_encode($data);
        
}
public function MisChatsConsulta()
{

    if (isset($_POST) && !empty($_POST)) {
        $typeTransaction = $this->input->post("typeTransaction");
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        $where = $this->input->post("where");
        $data['data']  = $this->Chat_modelo->MisChatsConsulta($this->session->userdata('id_usuario'),$typeTransaction, $beginDate, $endDate, $where)->result_array();
        echo json_encode($data);
    } else {
        json_encode(array());
    }

    //$data['data']  = $this->Chat_modelo->MisChatsConsulta($this->session->userdata('id_usuario'), $fecha1,$fecha2)->result_array();
    //echo json_encode($data);
        
}
/*public function MisChatsConsulta($fecha1,$fecha2)
{
        $data['data']  = $this->Chat_modelo->MisChatsConsulta($this->session->userdata('id_usuario'), $fecha1,$fecha2)->result_array();

        echo json_encode($data);
        
}*/
public function MisChatsConsultaAS()
{
    if ($this->session->userdata('id_rol') == 19) {
         $data['data']  = $this->Chat_modelo->MisChatsConsultaAS($this->session->userdata('id_sede'))->result_array();

     }     
        echo json_encode($data);
        
}
public function HistorialChatAdmin($fecha1,$fecha2,$sede)
{


         $data['data']  = $this->Chat_modelo->HistorialChatAdmin($fecha1,$fecha2,$sede)->result_array();
        echo json_encode($data);
        
}
public function historialGere()
{
         $data['data']  = $this->Chat_modelo->historialGere($this->session->userdata('id_sede'))->result_array();
        echo json_encode($data);        
}
public function ConfiguracionAdmin()
{
         $data['data']  = $this->Chat_modelo->ConfiguracionAdmin()->result_array();
        echo json_encode($data);        
}
public function ConfiguracionGte()
{
         $data['data']  = $this->Chat_modelo->ConfiguracionGte($this->session->userdata('id_sede'))->result_array();
        echo json_encode($data);        
}
public function ConfiguracionSuper($sedes)
{
    $sedes = str_replace('%20', '', $sedes);
    $data['data']  = $this->Chat_modelo->ConfiguracionSuper($sedes)->result_array();
    echo json_encode($data);        
}
public function historialAdminPros($fecha1,$fecha2, $sede)
{
    
      
    $data['data']  = $this->Chat_modelo->historialAdminPros($fecha1,$fecha2, $sede)->result_array();
    
        echo json_encode($data);        
}
public function NotificacionChat($id)
{
        $datos  = $this->Chat_modelo->NotificacionChat($id,$this->session->userdata('id_usuario'))->result_array();

        echo json_encode($datos);
        
}
function guardarCaptura(){

    date_default_timezone_set('America/Mexico_City');
    $payload = json_decode(file_get_contents("php://input"));
    if (!$payload) {
        exit("!No hay payload!");
    }

    $captura = $payload->captura;
    $id = $payload->id;


    // Aquí obtener más datos si existen...

    // Quitar "data:image..." de la cadena
    $capturaLimpia = str_replace("data:image/png;base64,", "", urldecode($captura));
    //Venía codificada pero sólo la codificamos así para que viajara por la red,
    //ahora la decodificamos y
    //guardamos el contenido dentro de un archivo
    $imagenDecodificada = base64_decode($capturaLimpia);

    //Calcular un nombre único
    // Nota: el nombre podría enviarse con la carga útil desde JS
    $nombreImagenGuardada = "static/documentos/cliente/evidencia/capturaChat_".Date('Ymd').$id.".png";
    //Escribir el archivo
    file_put_contents($nombreImagenGuardada, $imagenDecodificada);
    echo $nombreImagenGuardada;
}

public function NotificacionChatSide()
{
        $datos  = $this->Chat_modelo->NotificacionChatSide($this->session->userdata('id_usuario'))->result();

        echo json_encode($datos);
        
}
 public function getMischats()
    {
        
        $data = $this->Chat_modelo->getMischats($this->input->post("id"))->result_array();
        //echo var_dump($data);
        echo json_encode($data);
    }
    public function getMischatsActual()
    {
        
        $data = $this->Chat_modelo->getMischatsActual($this->input->post("mensaje"),$this->input->post("id"))->result_array();
        //echo var_dump($data);
        echo json_encode($data);
    }
    public function SaveNumeroChat()
    {
        $data = [
            'numero' => $this->input->post("num_chatS"),
        ];
                 $response = $this->Chat_modelo->SaveNumeroChat($data,$this->input->post("idC"));
          echo json_encode($response);
        
    }

    public function ResponderMsj()
    {

date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d H:i:s");
      $data = [
    'mensaje' => $this->input->post("RespuestaMsj"),
    'de' => $this->session->userdata('id_usuario'),
    'para' => $this->input->post("paraid"),
    'id_chat' => $this->input->post("idchatt"),
    'fecha_creacion' => $hoy


   
]; 

 $response = $this->Chat_modelo->saveMsj($data);


 $datos = ['fecha_modificacion' => $hoy];
 $va = $this->Chat_modelo->ActualizarFechaChat($datos,$this->input->post("idchatt"));
echo json_encode($response);
        


    }

    public function ActualizarFechaChat($id)
   {
    date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d H:i:s");
    $data = [
    'fecha_modificacion' => $hoy,
];
         $response = $this->Chat_modelo->ActualizarFechaChat($data,$this->input->post("id"));
  echo json_encode($response);
   }

   public function CambioSesion()
   {

    $data = [
    'estatus' => $this->input->post("val"),
];

$response = $this->Chat_modelo->CambioSesion($data,$this->session->userdata('id_usuario'));	
echo json_encode($response);
   }

    public function FinalizarChat()
{
    
  $estado = ['estatus' => 0];

      $response = $this->Chat_modelo->FinalizarChat($estado,$this->input->post("idchatt"));
      $datos= $this->Chat_modelo->Tiene_permisos($this->session->userdata('id_usuario'))->result_array();
if($datos[0]['chat_activos'] > 0){

    $response = $this->Chat_modelo->DisminuirActivo($this->session->userdata('id_usuario')); 
}


      echo json_encode($response);  
}
public function FinalizarSesion()
{
    date_default_timezone_set('America/Mexico_City');
    $hoy = date("Y-m-d H:i:s");
    $hoy2 = date("Y-m-d 00:00:00");
  $estado = ['estatus' => 3,
            'chat_activos' => 0,
            'bloqueado' => 0];
  $estado2 = ['estatus' => 0];
  $estado3 = ['visto' => 1,
  'recibido' => 0];
$estado4 = ['fecha_salida' => $hoy];
      $response = $this->Chat_modelo->FinalizarSesionPerfil($estado,$this->session->userdata('id_usuario')); 
      $response = $this->Chat_modelo->FinalizarSesionChat($estado2,$this->session->userdata('id_usuario'));
      $response = $this->Chat_modelo->FinalizarSesionMsj($estado3,$this->session->userdata('id_usuario'));

      echo json_encode($response);  
}

public function MensajeArchivo()
    {

date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d H:i:s");

      $data = [
    'mensaje' => $this->input->post("id"),
    'de' => $this->session->userdata('id_usuario'),
    'para' => $this->input->post("paraid"),
    'liga' => 1,
    'id_chat' => $this->input->post("idchatt"),
    'fecha_creacion' => $hoy
   
]; 

 $response = $this->Chat_modelo->saveMsjArch($data);
echo json_encode($response);
        

    }
public function savePerfil()
{
$fileTmpPath = $_FILES['file-upload']['tmp_name'];
$fileName = $_FILES['file-upload']['name'];
$fileSize = $_FILES['file-upload']['size'];
$fileType = $_FILES['file-upload']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$newFileName = md5($fileName) . '.' . $fileExtension;


   // echo $fileTmpPath = $_FILES['file-upload']['name'];
$data = [
    'estatus' => 3,
    'foto' => $newFileName,
    'num_chat' => $this->input->post("num_chat"),
    'chat_activos' => 0,
    'mensaje' => $this->input->post("mensaje"),
    'tipo' => 1,
    'fecha_creacion' => date("Y-m-d H:i:s"),
    'id_usuario' => $this->input->post("idasesor"),
    'estado' => 1
];
$uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
$uploadFileDir2 = './static/images/perfil/'.$this->input->post("idasesor").'/';


if (file_exists($uploadFileDir)) {
    $dest_path = $uploadFileDir2 . $newFileName;
    //$dest_path = $uploadFileDirNew . $newFileName;
    move_uploaded_file($fileTmpPath, $dest_path);
    
} else {
    $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
    mkdir("".$uploadFileDir."", 0777,true);

 $dest_path = $uploadFileDirNew . $newFileName;
//$dest_path = $uploadFileDirNew . $newFileName;
move_uploaded_file($fileTmpPath, $dest_path);

}
 $response = $this->Chat_modelo->savePerfil($data);
echo json_encode($response);
        
}

public function EstadoPerfil()
{
  $estado = ['estado' => $this->input->post('estadoE')];

      $response = $this->Chat_modelo->EstadoPerfil($estado,$this->input->post("idasesorE")); 
      echo json_encode($response);  
}
public function CerrarSesionChat()
{
  $estado = ['estatus' => $this->input->post('estadoE')];

      $response = $this->Chat_modelo->CerrarSesionChat($estado,$this->input->post("idasesorE")); 
      echo json_encode($response);  
}

public function BloquearUsuario()
{
  $estado = ['bloqueado' => $this->input->post('bloqueado')];

      $response = $this->Chat_modelo->BloquearUsuario($estado,$this->input->post("idasesorB")); 
      echo json_encode($response);  
}
public function getInfoPerfilGte($id_asesor){
        $data = $this->Chat_modelo->getInfoPerfilGte($id_asesor);
        echo json_encode($data);
    }
    public function getInfoPerfil(){
        $id_asesor = $this->session->userdata('id_usuario');
    if($id_asesor == 2042){
        $data =array( array(
           'idperfil'=> 0,
            'estatus'=> 1,
             'num_chat'=> 0,
             'id_sede'=> array("1","2","3","4","5","6"),
             'id_usuario'=> 2048,
             'foto'=>'ddd.png',
             'idperfil'=> 0,
             'mensaje'=> "Cobranza",
             'nombre'=> "Josselin Nualart",
             "id_rol" => 28
        ));
    
    }else if($id_asesor == 1980){
        $data =array( array(
            'idperfil'=> 0,
             'estatus'=> 1,
              'num_chat'=> 0,
              'id_sede'=> array("1","2","3","4","5","6"),
              'id_usuario'=> 1980,
              'foto'=>'ddd.png',
              'idperfil'=> 0,
              'mensaje'=> "MKTD&TI",
              'nombre'=> "FABIÁN ALEJANDRO",
              "id_rol" => 18
         ));
    }
    else if($id_asesor != 2042 && $id_asesor != 1980){
        $data = $this->Chat_modelo->getInfoPerfil($id_asesor);
        if( $data[0]['id_rol'] != 7)
            $data[0]['id_sede'] = explode ( ',', $data[0]['id_sede'] );
        
    }
        
            echo json_encode($data);
        }
   public function UpdateVisto()
   {
    $data = [
    'visto' => 1,
];
         $response = $this->Chat_modelo->UpdateVisto($data,$this->input->post("id"));
  echo json_encode($response);
   }


    public function AutPerfil()
   {
    $data = [
    'estatus' => 4,
];
         $response = $this->Chat_modelo->AutPerfil($data,$this->input->post("idasesorAut"));
  echo json_encode($response);
   }



   public function UpdateRecibido()
   {
    $data = [
    'recibido' => 0,
];
         $response = $this->Chat_modelo->UpdateRecibido($data,$this->input->post("id"));
  echo json_encode($response);
   }

   public function UpdateRecibidoSide(){
       $data = ['recibido' => 0];
       $response = $this->Chat_modelo->UpdateRecibidoSide($data,$this->session->userdata('id_usuario'));
  echo json_encode($response);
   }


public function UpdatePerfilAs($val){
    date_default_timezone_set('America/Mexico_City');
    $hoy = date("Y-m-d H:i:s");

    if($this->input->post("estatusE") == 0){
        if ($val == 2) {

            $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
            $cadena = "./static/images/Perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");
            if (file_exists($uploadFileDir) ) {
                if(file_exists($cadena)){
                        unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                }
            } else {
                $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                mkdir("".$uploadFileDir."", 0777,true);
            }


            $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                $fileName = $_FILES['file-uploadE']['name'];
                $fileSize = $_FILES['file-uploadE']['size'];
                $fileType = $_FILES['file-uploadE']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = md5($fileName) . '.' . $fileExtension;
                $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                $dest_path = $uploadFileDir . $newFileName;


                $dest_path = $uploadFileDir . $newFileName;
                move_uploaded_file($fileTmpPath, $dest_path);
                $data = [
                    'mensaje' => $this->input->post("mensajeE"),
                    'foto' => $newFileName
                ];

                $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                echo json_encode($response);
                $this->session->set_userdata('asesor_guardia', 0);
                }else{
                        $data = [
                            'mensaje' => $this->input->post("mensajeE")
                        ];

              $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
              $response == 1 ? $response = 2 : $response = 0;
              echo json_encode($response);
                }
    }else if( $this->input->post("estatusE") == 1){

        if($this->session->userdata('id_rol') != 7)
        {

            if ($val == 2) {

                $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                $cadena = "./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");

                if (is_readable ($uploadFileDir) ) {

                    if(file_exists($cadena)){
                            unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));

                    }


                } else {
                    $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                    mkdir("".$uploadFileDir."", 0777,true);
                }
                $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                $fileName = $_FILES['file-uploadE']['name'];
                $fileSize = $_FILES['file-uploadE']['size'];
                $fileType = $_FILES['file-uploadE']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = md5($fileName) . '.' . $fileExtension;
                  $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                $dest_path = $uploadFileDir . $newFileName;

                $dest_path = $uploadFileDir . $newFileName;
                move_uploaded_file($fileTmpPath, $dest_path);


                    $data = [
                        'mensaje' => $this->input->post("mensajeE"),
                        'foto' => $newFileName,
                        'estatus' => $this->input->post("estatusE"),

                    ];

                  $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                  echo json_encode($response);
                  $this->session->set_userdata('asesor_guardia', 1);

                    }else{
                            $data = [
                                'mensaje' => $this->input->post("mensajeE"),
                                'estatus' => $this->input->post("estatusE")
                            ];

                  $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                  echo json_encode($response);
                    }
        }
        else{

            $respuestaCon  = $this->Chat_modelo->ConfiguracionGte($this->session->userdata('id_sede'))->result_array();
            $respuestaCuantos  = $this->Chat_modelo->CuantosOnline($this->session->userdata('id_sede'))->result_array();
            if($respuestaCon[0]['numero'] == $respuestaCuantos[0]['cuantos']){
                if ($val == 2) {
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                    $cadena = "./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");
                    if (is_readable ($uploadFileDir) ) {
                        if(file_exists($cadena)){
                                unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                        }
                    } else {
                        $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                        mkdir("".$uploadFileDir."", 0777,true);
                    }
                    $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                    $fileName = $_FILES['file-uploadE']['name'];
                    $fileSize = $_FILES['file-uploadE']['size'];
                    $fileType = $_FILES['file-uploadE']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $newFileName = md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                    $dest_path = $uploadFileDir . $newFileName;
                    $dest_path = $uploadFileDir . $newFileName;
                    move_uploaded_file($fileTmpPath, $dest_path);
                        $data = [
                            'mensaje' => $this->input->post("mensajeE"),
                            'foto' => $newFileName
                        ];
                    $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                 echo json_encode($response);
        }
        else{
                $data = [
                    'mensaje' => $this->input->post("mensajeE")
                ];
                $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                $response == 1 ? $response = 2 : $response = 0;
                echo json_encode($response);
        }

            }else if($respuestaCon[0]['numero'] > $respuestaCuantos[0]['cuantos']){

                if ($val == 2) {
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                    $cadena = "./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");
                    if (is_readable ($uploadFileDir) ) {

                        if(file_exists($cadena)){
                                unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                        }
                    } else {
                        $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                        mkdir("".$uploadFileDir."", 0777,true);
                    }
                    $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                    $fileName = $_FILES['file-uploadE']['name'];
                    $fileSize = $_FILES['file-uploadE']['size'];
                    $fileType = $_FILES['file-uploadE']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $newFileName = md5($fileName) . '.' . $fileExtension;
                      $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                    $dest_path = $uploadFileDir . $newFileName;
                    $dest_path = $uploadFileDir . $newFileName;
                    move_uploaded_file($fileTmpPath, $dest_path);
                        $data = [
                            'mensaje' => $this->input->post("mensajeE"),
                            'foto' => $newFileName,
                            'estatus' => $this->input->post("estatusE"),

                        ];
                      $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                      echo json_encode($response);
                        }else{
                                $data = [
                                    'mensaje' => $this->input->post("mensajeE"),
                                    'estatus' => $this->input->post("estatusE")
                                ];

                      $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                      echo json_encode($response);
                        }
            }

        }
    }
    else if($this->input->post('estatusE') == 2){
        if($this->session->userdata('id_rol') != 7)
        {
            if ($val == 2) {
                $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                $cadena = "./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");
                if (is_readable ($uploadFileDir) ) {
                    if(file_exists($cadena)){
                        unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                    }
                } else {
                    $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                    mkdir("".$uploadFileDir."", 0777,true);
                }
                $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                $fileName = $_FILES['file-uploadE']['name'];
                $fileSize = $_FILES['file-uploadE']['size'];
                $fileType = $_FILES['file-uploadE']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = md5($fileName) . '.' . $fileExtension;
                $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                $dest_path = $uploadFileDir . $newFileName;
                $dest_path = $uploadFileDir . $newFileName;
                move_uploaded_file($fileTmpPath, $dest_path);
                $data = [
                    'mensaje' => $this->input->post("mensajeE"),
                    'foto' => $newFileName,
                    'estatus' => $this->input->post("estatusE"),
                ];
                $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                echo json_encode($response);
            }else{
                $data = [
                    'mensaje' => $this->input->post("mensajeE"),
                    'estatus' => $this->input->post("estatusE")
                ];
                $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                echo json_encode($response);
            }
        }
        else{
            $respuestaCon  = $this->Chat_modelo->ConfiguracionGte($this->session->userdata('id_sede'))->result_array();
            $respuestaCuantos  = $this->Chat_modelo->CuantosOnline($this->session->userdata('id_sede'))->result_array();
            if($respuestaCon[0]['numero'] == $respuestaCuantos[0]['cuantos'])
            {
                if ($val == 2) {

                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                    $cadena = "./static/images/Perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");

                    if (is_readable ($uploadFileDir) ) {

                        if(file_exists($cadena)){
                            unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                        }
                    } else {
                        $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                        mkdir("".$uploadFileDir."", 0777,true);
                    }
                    $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                    $fileName = $_FILES['file-uploadE']['name'];
                    $fileSize = $_FILES['file-uploadE']['size'];
                    $fileType = $_FILES['file-uploadE']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $newFileName = md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                    $dest_path = $uploadFileDir . $newFileName;
                    $dest_path = $uploadFileDir . $newFileName;
                    move_uploaded_file($fileTmpPath, $dest_path);
                    $data = [
                        'mensaje' => $this->input->post("mensajeE"),
                        'foto' => $newFileName
                    ];
                    $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                    echo json_encode($response);
                }else{
                    $data = [
                        'mensaje' => $this->input->post("mensajeE"),
                        'estatus' => $this->input->post("estatusE")
                    ];
                    $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                    echo json_encode($response);
                }
            }else if($respuestaCon[0]['numero'] > $respuestaCuantos[0]['cuantos']){
                if ($val == 2) {
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor");
                    $cadena = "./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE");
                    if (is_readable ($uploadFileDir) ) {
                        if(file_exists($cadena)){
                            unlink("./static/images/perfil/".$this->input->post("idasesor")."/".$this->input->post("filenameE"));
                        }
                    } else {
                        $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesor").'/';
                        mkdir("".$uploadFileDir."", 0777,true);
                    }
                    $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
                    $fileName = $_FILES['file-uploadE']['name'];
                    $fileSize = $_FILES['file-uploadE']['size'];
                    $fileType = $_FILES['file-uploadE']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $newFileName = md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesor")."/";
                    $dest_path = $uploadFileDir . $newFileName;
                    $dest_path = $uploadFileDir . $newFileName;
                    move_uploaded_file($fileTmpPath, $dest_path);
                    $data = [
                        'mensaje' => $this->input->post("mensajeE"),
                        'foto' => $newFileName,
                        'estatus' => $this->input->post("estatusE"),
                    ];
                    $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                    echo json_encode($response);
                }else{
                    $data = [
                        'mensaje' => $this->input->post("mensajeE"),
                        'estatus' => $this->input->post("estatusE")
                    ];
                    $response = $this->Chat_modelo->updatePerfilAs($data,$this->session->userdata('id_usuario'));
                    echo json_encode($response);
                }
            }

        }
    }
}

public function VerificarProspecto()
{
    date_default_timezone_set('America/Mexico_City');
    $id = $this->input->post('id');
      $response = $this->Chat_modelo->VerificarProspecto($id,$this->session->userdata('id_usuario'))->result_array();
      if(!empty($response)){
        echo json_encode(1);
      }else{
        echo json_encode(0);
      }
}

public function UpdatePerfil($val)
{
    if ($val == 2) {    
        $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesorEp");
        $cadena = "./static/images/perfil/".$this->input->post("idasesorEp")."/".$this->input->post("filenameE");
        if (is_readable($uploadFileDir) ) {
            if(file_exists($cadena)){
                   unlink("./static/images/perfil/".$this->input->post("idasesorEp")."/".$this->input->post("filenameE"));               
            }
        } else {
            $uploadFileDirNew = './static/images/perfil/'.$this->input->post("idasesorEp").'/';
            mkdir("".$uploadFileDir."", 0777,true);
        }
   
        $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
        $fileName = $_FILES['file-uploadE']['name'];
        $fileSize = $_FILES['file-uploadE']['size'];
        $fileType = $_FILES['file-uploadE']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5($fileName) . '.' . $fileExtension;
          $uploadFileDir = './static/images/perfil/'.$this->input->post("idasesorEp")."/";
        $dest_path = $uploadFileDir . $newFileName;


        $dest_path = $uploadFileDir . $newFileName;
        move_uploaded_file($fileTmpPath, $dest_path);

        $data = [
            'foto' => $newFileName,
            'num_chat' => $this->input->post("num_chatE"),
            'mensaje' => $this->input->post("mensajeE"),
            'id_usuario' => $this->input->post("idasesorEp")
        ];

  $response = $this->Chat_modelo->updatePerfil($data,$this->input->post("idasesorEp"));
  echo json_encode($response);

    }else{
         $data = [
    'num_chat' => $this->input->post("num_chatE"),
    'mensaje' => $this->input->post("mensajeE"),
    'id_usuario' => $this->input->post("idasesorEp")
        ];

  $response = $this->Chat_modelo->updatePerfil($data,$this->input->post("idasesorEp"));
  echo json_encode($response);   
    }
}
 public function saveProspectChat(){
    date_default_timezone_set('America/Mexico_City');
    $verificar = $this->Chat_modelo->VerificarProspecto($_POST['idchatt2'],$this->session->userdata('id_usuario'))->result_array();
    if(empty($verificar)){
        $plazaVenta = 0;
        switch($this->session->userdata("id_sede")){
            case 1:
                $plazaVenta = 4;
                break;
            case 2:
                $plazaVenta = 1;
                break;   
            case 3:
                $plazaVenta = 5;
                break;
            case 4:
                $plazaVenta = 2;
                break;
            case 5:
                $plazaVenta = 3;
                break;
            case 6:
                $plazaVenta = 7;
                break;
            default:
                break;
        }
        $data = array(
            "nombre" => $_POST['nombre'],
            "apellido_paterno" => $_POST['app'],
            "correo" => $_POST['correo'],
            "telefono" => $_POST['tel'],
            "personalidad_juridica" => 2,
            "lugar_prospeccion" => 6,
            "medio_publicitario" => '',
            "otro_lugar" => "Chat",
            "plaza_venta" => $plazaVenta,
            "nacionalidad" => $_POST['nationality'],
            "observaciones" => $_POST['obs'],
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "fecha_vencimiento" => date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")."+ 30 days")),
            "estado_civil" => 7,
            "regimen_matrimonial" => 5,
            "originario_de" => $_POST['estado'] != '' ? $_POST['estado'] : null,
            "id_sede" => $this->session->userdata('id_sede'),
            "id_asesor" => $this->session->userdata('id_usuario'),
             "id_coordinador" => in_array($this->session->userdata('id_rol'), array("3","9","6", "20", "19")) ? $this->session->userdata('id_usuario') : $this->session->userdata('id_lider'), // si es gerente o coordinador, se infiere que el coordinador son ellos mismos, de lo contrario es su líder directo,
            "id_gerente" => in_array($this->session->userdata('id_rol'), array("3", "19")) ? $this->session->userdata('id_usuario') : ( in_array($this->session->userdata('id_rol'), array("9","6","20")) ? $this->session->userdata('id_lider') : $this->session->userdata('id_lider_2') ),// si es gerente el genrente es el mismo, si es coordinador el gerente es su jefe directo y si es asesor el gerente es el líder de su líder
            "origen" => 1
            );


        $response = $this->Chat_modelo->saveProspectChat($data);
      //  echo json_encode($response);

        $respuesta = $this->Chat_modelo->ultimoProspecto(1,$this->session->userdata('id_usuario'))->result_array();
        $documento =  array(
            'id_prospecto' => $respuesta[0]['id_prospecto'],
            'id_usuario' => $this->session->userdata('id_usuario'),
            'nombre' =>  'capturaChat_'.Date('Ymd').$_POST['idchatt2'].'.png',
            'fecha_creacion' => date("Y-m-d H:i:s"),
            'tipo' => 1,
            'id_Chat' => $_POST['idchatt2']
        );

        $response = $this->Chat_modelo->saveEvidencia($documento);

    }
    else{
        $documento =  array(
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['app'],
            'correo' => $_POST['correo'],
            'telefono' => $_POST['tel'],
            "nacionalidad" => $_POST['nationality'],
            "observaciones" => $_POST['obs']
        );

        $response = $this->Chat_modelo->UpdateProspectoChat($documento,$verificar[0]['id_prospecto']);    
    }
        echo json_encode($response);
    }

    public function getSedes($id_sede){
        $data = $this->Chat_modelo->getSedes($id_sede);
        echo json_encode( $data);
    }

    public function getSedesByUser(){
        if($this->session->userdata('id_rol') == 28){
            $data = $this->Chat_modelo->getSedesList();
        }elseif($this->session->userdata('id_rol') == 19){
            $data = $this->Chat_modelo->getSedesByUser($this->session->userdata('id_usuario'),$this->session->userdata('id_rol'));
        }else{
            $data = $this->Chat_modelo->getSedesByUser($this->session->userdata('id_usuario'),$this->session->userdata('id_rol'));

        }
        echo json_encode( $data);
    }

    public function checkIfIsGuarrior($id_usuario){
        $data = $this->Chat_modelo->checkIfIsGuarrior($id_usuario);

        $myarray = array();
        $myarray[0]['info'] = 'DW SESSION OK';

        if(count($data) >= 1){
            $this->session->set_userdata('asesor_guardia', 1);
            echo json_encode($myarray); 
        }
       
    }

    public function sendCorreo(){
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $origen = $_POST['origen'];
        $sede = $_POST['sede'];

        if($sede == 1)
            $sedeName = "San Luis Potosí";
        else if($sede == 2)
            $sedeName = "Querétaro";
        else if($sede == 3)
            $sedeName = "Mérida";
        else if($sede == 4)
            $sedeName = "Ciudad de México";
        else if($sede == 5)
            $sedeName = "León";
        else if($sede == 6)
            $sedeName = "Cancún";
        else
            $sedeName = "Sin especificar";

        $data2 = array(
            "id_sede" => $sede,
            "correo" => $correo,
            "telefono" => $telefono,
            "nombre" => $nombre,
            "origen" => $origen,
            "fecha_creacion" => date("Y-m-d H:i:s")
        );
        $this->Chat_modelo->insertRegistroLp($data2);
    }

    public function getCorreos($sede){
        $data = $this->Chat_modelo->getCorreos($sede);
        return $data;
    }
}