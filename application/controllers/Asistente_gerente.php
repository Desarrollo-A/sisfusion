<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asistente_gerente extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('VentasAsistentes_model');
		$this->load->model('registrolote_modelo');
				$this->load->model('asesor/Asesor_model');
 		$this->load->library(array('session','form_validation'));
       //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
       $this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->load->library('phpmailer_lib');
		$this->validateSession();

		date_default_timezone_set('America/Mexico_City');
	}


	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '6') {
			redirect(base_url() . 'login');
		}
		$this->load->view('template/header');
		$this->load->view('ventasAsistentes/ventasAsistentes_view');
		$this->load->view('template/footer');
	}

	public function registrosClienteVentasAsistentes(){
		/*menu function*/           
     	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view",$datos);
	}
	public function registroEstatus8VentasAsistentes()
	{
		$this->validateSession();

	 	/*menu function*/                     
   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_status8Contratacion_asistentes_view",$datos);
	}
	public function registroEstatus14VentasAsistentes(){
		$this->validateSession();
		 /*menu function*/                    
     	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_status14Contratacion_asistentes_view",$datos);
	}
	public function registroEstatus7VentasAsistentes(){
		/*menu function*/           
	   	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_7_ventasAsistentes_view",$datos);
	}
	public function consultaDS()
	{
		$this->validateSession();
        $datos=array();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_documentacion_contraloria_ds",$datos);
	}
	public function registroEstatus9VentasAsistentes(){
		/*menu function*/                    
   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view('contratacion/report_historial_view',$datos);
	}
	public function registrosClienteDocumentosventasAsistentes(){
		  	/*menu function*/                 
    	  	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		  	$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
			$this->load->view('template/header');
			$this->load->view("contratacion/datos_cliente_documentos_contratacion_view",  $datos);
	}

	public function inventario()
	{
		/*menu function*/                   
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}

	public function inventarioDisponible()
	{
		/*menu function*/                   
   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_inventarioDventas_view", $datos);
	}

	public function legalRejections()
    {
        /*menu function*/                    
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("contratacion/legal_rejections", $datos);
    }
    
    public function getLegalRejections() {
        $data=array();
        $data = $this->VentasAsistentes_model->getLegalRejections();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function registrosClienteAutorizacionAsistentes(){
		/*menu function*/                     
       	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_cliente_autorizacion_ventasAsistentes_view",$datos);
	}
	public function catalogoAsesores()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/cat_asesor_view");
	}
	public function registroContratoVentasAsistentes(){
 		/*menu function*/                
 		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_cliente_contrato_ventasAsistentes_view",$datos);
	}
	public function nueva_Solicitud(){
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/vista_solicitud_comision");
	}
	public function hitorial_Comisiones(){
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/vista_historial_comisiones");
	}
	public function lista_proyecto(){
      echo json_encode($this->VentasAsistentes_model->get_proyecto_lista()->result_array());
	}
	public function lista_condominio($proyecto){
      echo json_encode($this->VentasAsistentes_model->get_condominio_lista($proyecto)->result_array());
	}
	public function lista_lote($condominio){
      echo json_encode($this->VentasAsistentes_model->get_lote_lista($condominio)->result_array());
	}
	public function get_lote_autorizacion($lote){
      echo json_encode($this->VentasAsistentes_model->get_datos_lote_aut($lote)->result_array());
	}
	public function get_lote_contrato($lote){
      echo json_encode($this->VentasAsistentes_model->get_datos_lote_cont($lote)->result_array());
	}

	public function invDispAsesor()
	{
	 	/*menu function*/                     
   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
      	$this->load->view('template/header');
        $this->load->view("asesor/inventario_disponible",$datos);
	}

	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			redirect(base_url() . "index.php/login");
		}
	}

	public function getStatus8ContratacionAsistentes() {
		$data=array();
		$data = $this->VentasAsistentes_model->registroStatusContratacion8();

			if($data != null) {
				echo json_encode($data);
			} else {
				echo json_encode(array());
			}

	}

	public function editar_registro_lote_asistentes_proceceso8(){
		$idLote=$this->input->post('idLote');	
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		$arreglo=array();	
		$arreglo["idStatusContratacion"]=8;
		$arreglo["idMovimiento"]=38;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
	
		$arreglo2=array();
		$arreglo2["idStatusContratacion"]=8;
		$arreglo2["idMovimiento"]=38;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;	
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $fechaVenc;
		$arreglo2["idLote"]= $idLote;  
		$arreglo2["idCondominio"]= $idCondominio;          	
		$arreglo2["idCliente"]= $idCliente;        
		
	
		$validate = $this->VentasAsistentes_model->validateSt8($idLote);
		if($validate == 1){
		if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
			$data['message'] = 'OK';
			echo json_encode($data);
			}else{
				$data['message'] = 'ERROR';
				echo json_encode($data);
			}
		}else {
			$data['message'] = 'FALSE';
			echo json_encode($data);
		}

}
	
public function editar_registro_loteRechazo_asistentes_proceceso8(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
	$modificado=date("Y-m-d H:i:s");
	

    $arreglo=array();
    $arreglo["idStatusContratacion"]= 6;
    $arreglo["idMovimiento"]=23; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=6;
    $arreglo2["idMovimiento"]=23;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;    


	$validate = $this->VentasAsistentes_model->validateSt8($idLote);

	if($validate == 1){

	if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
		$data['message'] = 'OK';
		echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
	}


  }


  public function editar_registro_loteRechazoAstatus2_asistentes_proceceso8(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");

    $arreglo=array();
    $arreglo["idStatusContratacion"]= 1;
    $arreglo["idMovimiento"]=73; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=1;
    $arreglo2["idMovimiento"]=73;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;    



	$datos= $this->VentasAsistentes_model->getCorreoSt($idCliente);

	$lp = $this->VentasAsistentes_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com');
	   $array = array_unique($correosClean);
	}


	$infoLote = $this->VentasAsistentes_model->getNameLote($idLote);


  $mail = $this->phpmailer_lib->load();
 
  
  $mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

  foreach($array as $email)
  {
    if(trim($email)!= 'gustavo.mancilla@ciudadmaderas.com'){
      if (trim($email) != ''){ 
        $mail->addAddress($email);
      }
    }

    if(trim($email) == 'diego.perez@ciudadmaderas.com'){
      $mail->addAddress('analista.comercial@ciudadmaderas.com');
    }
  }


  $mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-VENTAS (8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE)');
  $mail->isHTML(true);

  $mailContent = utf8_decode( "<html><head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>	
  <title>AVISO DE BAJA </title>
  <style media='all' type='text/css'>
      .encabezados{
          text-align: center;
          padding-top:  1.5%;
          padding-bottom: 1.5%;
      }
      .encabezados a{
          color: #234e7f;
          font-weight: bold;
      }
      
      .fondo{
          background-color: #234e7f;
          color: #fff;
      }
      
      h4{
          text-align: center;
      }
      p{
          text-align: right;
      }
      strong{
          color: #234e7f;
      }
  </style>
</head>
<body>
  <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'>
      <tr colspan='3'><td class='navbar navbar-inverse' align='center'>
          <table width='750px' cellspacing='0' cellpadding='3' class='container'>
              <tr class='navbar navbar-inverse encabezados'><td>
                  <img src='https://www.ciudadmaderas.com/assets/img/logo.png' width='100%' class='img-fluid'/><p><a href='#'>SISTEMA DE CONTRATACIÓN</a></p>
              </td></tr>
          </table>
      </td></tr>
      <tr><td border=1 bgcolor='#FFFFFF' align='center'>  
      <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
        <tr class='active'>
          <th>Proyecto</th>
          <th>Condominio</th> 
          <th>Lote</th>   
          <th>Motivo de rechazo</th>   
          <th>Fecha/Hora</th>   
        </tr> 
        <tr>   
			   <td><center>".$infoLote->nombreResidencial."</center></td>
			   <td><center>".$infoLote->nombre."</center></td>
			   <td><center>".$infoLote->nombreLote."</center></td>
			   <td><center>".$comentario."</center></td>
			   <td><center>".date("Y-m-d H:i:s")."</center></td>

        </tr>
        </table></center>
      
      
      </td></tr>
  </table></body></html>");

  $mail->Body = $mailContent;


	$validate = $this->VentasAsistentes_model->validateSt8($idLote);

	if($validate == 1){

	if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
   	    $mail->send();
		$data['message'] = 'OK';
		echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
	}


  }


  public function editar_registro_loteRevision_asistentesAadministracion11_proceceso8(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=8;
    $arreglo["idMovimiento"]=67;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaSolicitudValidacion"]=$modificado;


$horaActual = date('H:i:s');
$horaInicio = date("08:00:00");
$horaFin = date("16:00:00");


if ($horaActual > $horaInicio and $horaActual < $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;

$i = 0;

    while($i <= 1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);
  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }

       $arreglo["fechaVenc"]= $fecha;

       }else{

$fecha = $fechaAccion;
$i = 0;

    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);

    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
    }

} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;
$i = 0;

    while($i <= 1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }

       $arreglo["fechaVenc"]= $fecha;

       }else{

$fecha = $fechaAccion;

$i = 0;
    while($i <= 1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
     $arreglo["fechaVenc"]= $fecha;
    }
}

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=8;
    $arreglo2["idMovimiento"]=67;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente; 
	$validate = $this->VentasAsistentes_model->validateSt8($idLote);

	if($validate == 1){

	if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
		$data['message'] = 'OK';
		echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
	}
  }


  public function getStatCont14() {
	  $data=array();
	  $data = $this->VentasAsistentes_model->registroStatusContratacion14();

	  if($data != null) {
		  echo json_encode($data);
	  } else {
		  echo json_encode(array());
	  }
  }




  public function editar_registro_lote_asistentes_proceceso14(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=14;
    $arreglo["idMovimiento"]=44;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]= $this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");

$horaActual = date('H:i:s');
$horaInicio = date("08:00:00");
$horaFin = date("16:00:00");

if ($horaActual > $horaInicio and $horaActual < $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;
$i = 0;

    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{
$fecha = $fechaAccion;
$i = 0;
    while($i <= -1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }
} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;

$i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{
$fecha = $fechaAccion;
$i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
     $arreglo["fechaVenc"]= $fecha;
       }
}

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=14;
    $arreglo2["idMovimiento"]=44;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;  
	

		$validate = $this->VentasAsistentes_model->validateSt14($idLote);

		if($validate == 1){

		if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
			$data['message'] = 'OK';
			echo json_encode($data);

			}else{
				$data['message'] = 'ERROR';
				echo json_encode($data);
			}

		}else {
			$data['message'] = 'FALSE';
			echo json_encode($data);
		}

  }





public function editar_registro_loteRevision_asistentes_proceceso14(){
  
	$idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
	$fechaVenc=$this->input->post('fechaVenc');
	
    $arreglo=array();
    $arreglo["idStatusContratacion"]=14;
    $arreglo["idMovimiento"]=69;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]= $this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');


    $arreglo["modificado"]=date("Y-m-d H:i:s");

$horaActual = date('H:i:s');
$horaInicio = date("08:00:00");
$horaFin = date("16:00:00");

if ($horaActual > $horaInicio and $horaActual < $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;

$i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{

$fecha = $fechaAccion;
$i = 0;

    while($i <= -1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }

} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;
$i = 0;

    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{
$fecha = $fechaAccion;
$i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              } 
    $fecha = $sig_fecha;
           }
     $arreglo["fechaVenc"]= $fecha;
       }
}

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=14;
    $arreglo2["idMovimiento"]=69;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote; 
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente; 


	$validate = $this->VentasAsistentes_model->validateSt14($idLote);

	if($validate == 1){

	if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
		$data['message'] = 'OK';
		echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
	}



  }



public function editar_registro_loteRevision_asistentes_proceceso8(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
    $fechaVenc=$this->input->post('fechaVenc');

    $arreglo=array();
    $arreglo["idStatusContratacion"]=8;
    $arreglo["idMovimiento"]=65;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=8;
    $arreglo2["idMovimiento"]=65;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote; 
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente; 




	$validate = $this->VentasAsistentes_model->validateSt8($idLote);

	if($validate == 1){

	if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
		$data['message'] = 'OK';
		echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
	}
}


public function setVar($var)
{
    $this->session->set_userdata('datauserjava', $var);
    echo $this->session->userdata('datauserjava');
}

 
}
