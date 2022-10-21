<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contraloria extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Contraloria_model');
		$this->load->model('registrolote_modelo');
		$this->load->model('Clientes_model');
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		$this->load->model('General_model');
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->load->library('phpmailer_lib');
		$this->load->library('formatter');
		$this->validateSession();

		date_default_timezone_set('America/Mexico_City');
	}

	public function index()
	{
		if($this->session->userdata('perfil') == FALSE || ($this->session->userdata('perfil') != 'contraloria' && $this->session->userdata('perfil') != 'contraloriaCorporativa' && $this->session->userdata('perfil') != 'subdirectorContraloria' && $this->session->userdata('perfil') != 'direccionFinanzas'))
		{
			redirect(base_url().'login');
		}
		 /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
         $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/

		$this->load->view('template/header');
		// $this->load->view('template/inicio_contraloria_view',$datos);
		$this->load->view('template/home',$datos);
		$this->load->view('template/footer');
	}
 
	public function expediente_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("contraloria/vista_expediente_contraloria", $datos);
	}
	public function corrida_contraloria(){
		$datos=array();
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_corrida_contraloria");
	}
	public function documentacion_contraloria(){
		$this->validateSession();
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		//$this->load->view("contratacion/datos_cliente_documentos_contratacion_view",$datos);
		$this->load->view("contraloria/vista_documentacion_contraloria",$datos);
	}
	public function documentacion_contraloria_ds(){
        $this->validateSession();
        $datos=array();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        //$this->load->view("contratacion/datos_cliente_documentos_contratacion_view",$datos);
        $this->load->view("contraloria/vista_documentacion_contraloria_ds",$datos);
    }
	public function historial_pagos_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_historial_pagos_contraloria",$datos);
	}
	public function estatus_2_0_contraloria(){
	/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	/*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_2_0_contraloria",$datos);
	}
	public function estatus_2_contraloria(){
				/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
				$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
				/*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_2_contraloria",$datos);
	}
	public function estatus_5_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/vista_5_contraloria",$datos);
		
	}
	public function estatus_6_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_6_contraloria",$datos);
	}

	public function getCommissionPlans(){
        echo json_encode($this->Contraloria_model->getCommissionPlans()->result_array());
    }
    
	public function estatus_9_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_9_contraloria",$datos);
	}
	public function estatus_10_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_10_contraloria",$datos);
	}
	public function envio_RL_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_envio_RL_contraloria",$datos);
	}
	public function estatus_12_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_12_contraloria",$datos);
	}
	public function estatus_13_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_13_contraloria",$datos);
	}
	public function estatus_15_contraloria(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
	 	$this->load->view("contraloria/vista_15_contraloria",$datos);
	}

	public function getProyectoExpediente(){
      echo json_encode($this->Contraloria_model->getProyecto()->result_array());
	}
	public function listaClientes()
	{
		/*se carga la vista desde contratacion*/
		$this->validateSession();

	/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	/*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view",$datos);
	}
	public function inventario()
	{
		/*se carga la vista desde contratacion*/
		$this->validateSession();
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		// $datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}


	public function lista_proyecto(){
      echo json_encode($this->Contraloria_model->get_proyecto_lista()->result_array());
	}
	public function lista_condominio($proyecto){
      echo json_encode($this->Contraloria_model->get_condominio_lista($proyecto)->result_array());
	}

	public function lista_lote($condominio)
	{
		$residencial = 0;
		$data = $this->registrolote_modelo->getLotesGral($condominio,$residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
	public function lista_estatus($condominio){
      echo json_encode($this->Contraloria_model->get_lote_lista($condominio)->result_array());
	}
	public function get_lote_expediente($lote){
      echo json_encode($this->Contraloria_model->get_datos_lote_exp($lote)->result_array());
	}
	public function get_lote_historial_pagos($lote){
      echo json_encode($this->Contraloria_model->get_datos_lote_pagos($lote)->result_array());
	}

	public function getStatus2_0()
	{
//		echo json_encode($this->registrolote_modelo->registroStatusContratacion2_0()->result());
		$data = $this->registrolote_modelo->registroStatusContratacion2_0();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
	public function registroStatusContratacionAsistentes2()
	{
		$data = array();
		$data = $this->registrolote_modelo->registroStatusContratacion2();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getregistroStatus6ContratacionContraloria()
	{
		$data = array();
		$data = $this->Contraloria_model->registroStatusContratacion6();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getregistroStatus9ContratacionContraloria()
	{
		$datos = array();
		$datos = $this->Contraloria_model->registroStatusContratacion9();
		if($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function getregistroStatus10ContratacionContraloria()
	{
		$datos = array();
		$datos= $this->registrolote_modelo->registroStatusContratacion10();
		if($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}

	public function getregistroStatus13ContratacionContraloria() {
	
		$datos = array();
		$datos = $this->Contraloria_model->registroStatusContratacion13();

		if($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}

	}

	public function getregistroStatus15ContratacionContraloria(){
		$datos = array();
		$datos = $this->Contraloria_model->registroStatusContratacion15();
		if($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}


	public function getrecepcionContratos()
	{
		$datos = array();
		$datos = $this->Contraloria_model->registroStatusContratacion10v2();
		if ($datos != null) {
			echo json_encode($datos);
		}
		else {
			echo json_encode(array());
		}
	}

	public function getManagersVentas(){
        echo json_encode($this->Clientes_model->getManagersVentas()->result_array());
    }

    public function getCoordinatorsVentas(){
        echo json_encode($this->Clientes_model->getCoordinatorsVentas()->result_array());
    }

    public function getAdvisersVentas(){
        echo json_encode($this->Clientes_model->getAdvisersVentas()->result_array());
    }

    public function consultClients(){
        $this->validateSession();
     /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	 $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	 /*-------------------------------------------------------------------------------*/
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/vista_documentacion_contraloria_cl",$datos);
    }

    public function reasignClient(){
        $data = array(
            "id_gerente" => $_POST['id_gerente'],
            "id_coordinador" => $_POST['id_coordinador'],
            "id_asesor" => $_POST['id_asesor'],
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        $response = $this->Clientes_model->updateClient($data, $this->input->post("id_cliente"));
        echo json_encode($response);
    }


	 public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            redirect(base_url() . "index.php/login");
        }
    }

	public function getCorridasContraloria()
	{
		$data= $this->registrolote_modelo->corridaContraloria();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}

	}

	public function depositoSeriedad_SPU()
	{
		$this->validateSession();
      /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	  $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	  /*-------------------------------------------------------------------------------*/
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/ds_mariela",$datos);
	}
	function getLotesAll($condominio)
    {
        $data = $this->Contraloria_model->getLotes($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function getAllDsByLote($idLote)
	{
		$dato = $this->Contraloria_model->getAllDsByLote($idLote);
		if($dato != null) {
            echo json_encode($dato);
        }
        else
        {
            echo json_encode(array());
        }
	}



	public function sendMailRecepExp()
	{


		$idLote=$this->input->post('idLote');
		$nombreLote=$this->input->post('nombreLote');

		$datos= $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);

		$arregloAs =array();
		$arregloAs["asesor1"]=$datos["correo"];


		$listCheckVacio = array_filter($arregloAs, "strlen");
		$correosClean = implode(', ', $listCheckVacio);
		$array=explode(",",$correosClean);


		$mail = $this->phpmailer_lib->load();
		

		$mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

		foreach($array as $email)
		{
			$mail->addAddress($email);

		}

		$mail->Subject = utf8_decode('EXPEDIENTE INGRESADO-CIUDAD MADERAS');
		$mail->isHTML(true);


		$mailContent = utf8_decode("<html><head>
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
            <th>Fecha/Hora</th>   
          </tr> 
          <tr>   

                <td><center>" . $datos["nombreResidencial"] . "</center></td>
                <td><center>" . $datos["nombreCondominio"] . "</center></td>
                <td><center>" . $datos["nombreLote"] . "</center></td>
                <td><center>" . date("Y-m-d H:i:s") . "</center></td>
          </tr>
          </table></center>
        
        
        </td></tr>
    </table></body></html>");



		$mail->Body = $mailContent;


		$arreglo=array();
		$arreglo["idStatusContratacion"]=2;
		$arreglo["idMovimiento"]=84;
		$arreglo["usuario"]=$this->session->userdata('usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["comentario"]= "Ok recepción de expediente";


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
		$arreglo2["idStatusContratacion"]=2;
		$arreglo2["idMovimiento"]=84;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["usuario"]=$this->session->userdata('usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $datos["fechaVenc"];
		$arreglo2["idLote"]= $idLote;
		$arreglo2["idCondominio"]= $datos["idCondominio"];
		$arreglo2["idCliente"]= $datos["idCliente"];
		$arreglo2["comentario"]= "Ok recepción de expediente";

	
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote,$arreglo) && $this->registrolote_modelo->insertHistorialLotes($arreglo2)){
			$mail->send();
			echo 1;
		}
		else
		{
			echo 0;
		}
	}

	public function sendMailRechazoEst2_0() {

		$idLote=$this->input->post('idLote');
		$nombreLote=$this->input->post('nombreLote');
		$motivoRechazo=$this->input->post('motivoRechazo');


		$datos= $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);

		$arregloAs =array();
		$arregloAs["asesor1"]=$datos["correo"];



		$listCheckVacio = array_filter($arregloAs, "strlen");
		$correosClean = implode(', ', $listCheckVacio);
		$array=explode(",",$correosClean);


		$mail = $this->phpmailer_lib->load();
	

		$mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

		foreach($array as $email)
		{
			$mail->addAddress($email);

		}


		$mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-CONTRALORÍA (2. Integración de Expediente)');
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
		               <td><center>".$datos["nombreResidencial"]."</center></td>
		               <td><center>".$datos["nombreCondominio"]."</center></td>
		               <td><center>".$datos["nombreLote"]."</center></td>
		               <td><center>".$motivoRechazo."</center></td>
		               <td><center>".date("Y-m-d H:i:s")."</center></td>
		        </tr>
		        </table></center>
		      
		      
		      </td></tr>
		  </table></body></html>");

		$mail->Body = $mailContent;


		$arreglo=array();
		$arreglo["idStatusContratacion"]=2;
		$arreglo["idMovimiento"]=85;
		$arreglo["comentario"]=$motivoRechazo;
		$arreglo["usuario"]=$this->session->userdata('usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["fechaVenc"]= date("Y-m-d H:i:s");


		$arreglo2=array();
		$arreglo2["idStatusContratacion"]=2;
		$arreglo2["idMovimiento"]=85;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$motivoRechazo;
		$arreglo2["usuario"]=$this->session->userdata('usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= date("Y-m-d H:i:s");
		$arreglo2["idLote"]= $idLote;
		$arreglo2["idCondominio"]= $datos["idCondominio"];
		$arreglo2["idCliente"]= $datos["idCliente"];


		/*print_r($idLote);
		echo '<br><br>';
		print_r($arreglo);
		echo '<br><br>';
		print_r($arreglo2);
		echo '<br><br>';
		exit;*/
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote,$arreglo)
			&& $this->registrolote_modelo->insertHistorialLotes($arreglo2)){
			$mail->send();
			echo 1;
		}
		else
		{
			echo 0;
		}

	}



	/*reportes*/
	public function integracionExpediente()
	{
	/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	/*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/integracionExpediente",$datos);
	}

	public function getRevision2(){
		$data=array();
		$data = $this->registrolote_modelo->getRevision2();
		if ($data != null) {
			echo json_encode($data);
		  } else {
			echo json_encode(array());
		  }
	}

	public function expRevisados()
	{
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/expedientesRevisados",$datos);
	}

	public function getRevision5(){

		$datos = array(
			"one" => array(
				"idStatusContratacion" => 5,
				"idMovimiento" => 35,
			),
			"two" => array(
				"idStatusContratacion" => 5,
				"idMovimiento" => 75,
			)
		);

		/*$data=array();
		$data = $this->registrolote_modelo->getRevision5($datos);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}*/
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->registrolote_modelo->getRevision5($datos, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
	}

	public function estatus10()
	{
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/status10",$datos);
	}

	public function getRevision10(){
		/*$data=array();
		$data = $this->registrolote_modelo->getRevision10();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}*/
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data = $this->registrolote_modelo->getRevision10($typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
	}

	public function rechazoJuridico()
	{
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/rechazoJuridico",$datos);
	}
	public function getRevision7(){
		$data=array();
		$data = $this->registrolote_modelo->getRevision7();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}


	public function getregistroStatus5ContratacionContraloria()
	{
		$data = array();
		$data = $this->Contraloria_model->registroStatusContratacion5();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}


	public function editar_registro_lote_contraloria_proceceso5(){

		$idLote=$this->input->post('idLote');
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		
		$ubicacion=$this->input->post('ubicacion');
		$tipo_venta=$this->input->post('tipo_venta');
		
		
		
		$arreglo=array();
		$arreglo["idStatusContratacion"]= 5;
		$arreglo["idMovimiento"]=35;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["ubicacion"]= $ubicacion;
		$arreglo["tipo_venta"]= $tipo_venta;

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
		while($i <= 2) {
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
		while($i <= 2) {
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
		while($i <= 2) {
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
		$arreglo2["idStatusContratacion"]= 5;
		$arreglo2["idMovimiento"]=35;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $fechaVenc;
		$arreglo2["idLote"]= $idLote;  
		$arreglo2["idCondominio"]= $idCondominio;          
		$arreglo2["idCliente"]= $idCliente;          
		

		$validate = $this->Contraloria_model->validateSt5($idLote);

		if($validate == 1){
	
		   if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
		
		
		
		
public function get_sede(){
	echo json_encode($this->Contraloria_model->get_sede()->result_array());
  }

  public function get_tventa(){
	echo json_encode($this->Contraloria_model->get_tventa()->result_array());
  }




  public function editar_registro_loteRechazo_contraloria_proceceso5(){

	$idLote=$this->input->post('idLote');
	$idCondominio=$this->input->post('idCondominio');
	$nombreLote=$this->input->post('nombreLote');
	$idStatusContratacion=$this->input->post('idStatusContratacion');
	$idMovimiento=$this->input->post('idMovimiento');
	$idCliente=$this->input->post('idCliente');
	$comentario=$this->input->post('comentario');
	$perfil=$this->input->post('perfil');
	$modificado=date("Y-m-d H:i:s");


	$arreglo=array();
	$arreglo["idStatusContratacion"]= 1;
	$arreglo["idMovimiento"]=20; 
	$arreglo["comentario"]=$comentario;
	$arreglo["usuario"]=$this->session->userdata('id_usuario');
	$arreglo["perfil"]=$this->session->userdata('id_rol');
	$arreglo["modificado"]=date("Y-m-d H:i:s");
	$arreglo["fechaVenc"]= $modificado;


	$arreglo2=array();
	$arreglo2["idStatusContratacion"]=1;
	$arreglo2["idMovimiento"]=20;
	$arreglo2["nombreLote"]=$nombreLote;
	$arreglo2["comentario"]=$comentario;
	$arreglo2["usuario"]=$this->session->userdata('id_usuario');
	$arreglo2["perfil"]=$this->session->userdata('id_rol');
	$arreglo2["modificado"]=date("Y-m-d H:i:s");
	$arreglo2["fechaVenc"]= $modificado;
	$arreglo2["idLote"]= $idLote;  
	$arreglo2["idCondominio"]= $idCondominio;         
	$arreglo2["idCliente"]= $idCliente;    

	$datos= $this->Contraloria_model->getCorreoSt($idCliente);
	$lp = $this->Contraloria_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com');
	   $array = array_unique($correosClean);
	}
	
	$infoLote = $this->Contraloria_model->getNameLote($idLote);

 
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



  $mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)');
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


	$validate = $this->Contraloria_model->validateSt5($idLote);


	if($validate == 1){
			if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function editar_registro_lote_contraloria_proceceso6()
  {

	  $idLote = $this->input->post('idLote');
	  $idCondominio = $this->input->post('idCondominio');
	  $nombreLote = $this->input->post('nombreLote');
	  $idCliente = $this->input->post('idCliente');
	  $comentario = $this->input->post('comentario');
	  $modificado = date('Y-m-d H:i:s');
	  $fechaVenc = $this->input->post('fechaVenc');
	  $fechaVenStatus = $this->input->post('fechaVenStatus');
	  //quitar las cosas que le daban formato
      $charactersNoPermit = array('$',',');
	  $totalNeto = $this->input->post('totalNeto');
	  $totalNeto = str_replace($charactersNoPermit, '', $totalNeto);


	  $arreglo = array();
	  $arreglo["idStatusContratacion"] = 6;
	  $arreglo["idMovimiento"] = 36;
	  $arreglo["comentario"] = $comentario;
	  $arreglo["usuario"] = $this->session->userdata('id_usuario');
	  $arreglo["perfil"] = $this->session->userdata('id_rol');
	  $arreglo["modificado"] = date("Y-m-d H:i:s");
	  $arreglo["totalNeto"] = $totalNeto;



	  $horaActual = date('H:i:s');
	  $horaInicio = date("08:00:00");
	  $horaFin = date("16:00:00");
	  if ($horaActual > $horaInicio and $horaActual < $horaFin) {
		  $fechaAccion = date("Y-m-d H:i:s");
		  $hoy_strtotime2 = strtotime($fechaAccion);
		  $sig_fecha_dia2 = date('D', $hoy_strtotime2);
		  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
		  if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
			  $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
			  $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
			  $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
			  $sig_fecha_feriado2 == "25-12") {
			  $fecha = $fechaAccion;
			  $i = 0;
			  while ($i <= 2) {
				  $hoy_strtotime = strtotime($fecha);
				  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				  $sig_fecha_dia = date('D', $sig_strtotime);
				  $sig_fecha_feriado = date('d-m', $sig_strtotime);
				  if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					  $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					  $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					  $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
					  $sig_fecha_feriado == "25-12") {
				  } else {
					  $fecha = $sig_fecha;
					  $i++;
				  }
				  $fecha = $sig_fecha;
			  }
			  $arreglo["fechaVenc"] = $fecha;
		  } else {
			  $fecha = $fechaAccion;
			  $i = 0;
			  while ($i <= 1) {
				  $hoy_strtotime = strtotime($fecha);
				  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				  $sig_fecha_dia = date('D', $sig_strtotime);
				  $sig_fecha_feriado = date('d-m', $sig_strtotime);

				  if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					  $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					  $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					  $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
					  $sig_fecha_feriado == "25-12") {
				  } else {
					  $fecha = $sig_fecha;
					  $i++;
				  }
				  $fecha = $sig_fecha;
			  }
			  $arreglo["fechaVenc"] = $fecha;
		  }

	  } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

		  $fechaAccion = date("Y-m-d H:i:s");
		  $hoy_strtotime2 = strtotime($fechaAccion);
		  $sig_fecha_dia2 = date('D', $hoy_strtotime2);
		  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

		  if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
			  $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
			  $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
			  $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
			  $sig_fecha_feriado2 == "25-12") {
			  $fecha = $fechaAccion;
			  $i = 0;
			  while ($i <= 2) {
				  $hoy_strtotime = strtotime($fecha);
				  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				  $sig_fecha_dia = date('D', $sig_strtotime);
				  $sig_fecha_feriado = date('d-m', $sig_strtotime);
				  if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					  $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					  $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					  $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
					  $sig_fecha_feriado == "25-12") {
				  } else {
					  $fecha = $sig_fecha;
					  $i++;
				  }
				  $fecha = $sig_fecha;
			  }
			  $arreglo["fechaVenc"] = $fecha;
		  } else {
			  $fecha = $fechaAccion;
			  $i = 0;
			  while ($i <= 2) {
				  $hoy_strtotime = strtotime($fecha);
				  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				  $sig_fecha_dia = date('D', $sig_strtotime);
				  $sig_fecha_feriado = date('d-m', $sig_strtotime);

				  if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					  $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					  $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					  $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
					  $sig_fecha_feriado == "25-12") {
				  } else {
					  $fecha = $sig_fecha;
					  $i++;
				  }
				  $fecha = $sig_fecha;

			  }
			  $arreglo["fechaVenc"] = $fecha;

		  }
	  }
	  $arreglo2 = array();
	  $arreglo2["idStatusContratacion"] = 6;
	  $arreglo2["idMovimiento"] = 36;
	  $arreglo2["nombreLote"] = $nombreLote;
	  $arreglo2["comentario"] = $comentario;
	  $arreglo2["usuario"] = $this->session->userdata('id_usuario');
	  $arreglo2["perfil"] = $this->session->userdata('id_rol');
	  $arreglo2["modificado"] = date("Y-m-d H:i:s");
	  $arreglo2["fechaVenc"] = $fechaVenc;
	  $arreglo2["idLote"] = $idLote;
	  $arreglo2["idCondominio"] = $idCondominio;
	  $arreglo2["idCliente"] = $idCliente;
	  $ub_jur = $this->Contraloria_model->val_ub($idLote);
	  $id_sede_jur = '';
	  $assigned_location = $ub_jur[0]['ubicacion'];
	  if ($assigned_location == 2) { // EXPEDIENTES QUERÉTARO
		  $id_sede_jur = 2;
		  $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
		  $id_asig = $data_asig->contador;
		  $arreglo["asig_jur"] = $id_asig == 2765 ? 2876 : ($id_asig == 2876 ? 10463 : 2765);
	  } else if ($assigned_location == 4) { // EXPEDIENTES CIUDAD DE MÉXICO
		  $id_sede_jur = 4;
		  $data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
		  $id_asig = $data_asig->contador;

		  if ($id_asig == 2820)
			$assigned_user = 10437;
		  else if ($id_asig == 10437)
			$assigned_user = 2820;

		  $arreglo["asig_jur"] = $assigned_user;

		} else if ($assigned_location == 1) { // EXPEDIENTES SAN LUIS POTOSÍ
			$id_sede_jur = 1;
			$data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
        	$id_asig = $data_asig->contador;
			
			if ($id_asig == 5468)
				$assigned_user = 2764;
			else if ($id_asig == 2764)
				$assigned_user = 5468;

			$arreglo["asig_jur"] = $assigned_user;
		} else if ($assigned_location == 5) { // EXPEDIENTES LEÓN
			$id_sede_jur = 5;
			$data_asig = $this->Contraloria_model->get_id_asig($assigned_location);
        	$id_asig = $data_asig->contador;

			if ($id_asig == 6856)
				$assigned_user = 2800;
			else if ($id_asig == 2800)
				$assigned_user = 11129;
			else if ($id_asig == 11129)
				$assigned_user = 6856;
			
			$arreglo["asig_jur"] = $assigned_user;
		}
	  
	  $validate = $this->Contraloria_model->validateSt6($idLote);

	  if ($validate == 1) {
		  if ($this->Contraloria_model->updateSt($idLote, $arreglo, $arreglo2) == TRUE) {
			  ($assigned_location == 1 || $assigned_location == 2 || $assigned_location == 4 || $assigned_location == 5) ? $this->Contraloria_model->update_asig_jur($arreglo["asig_jur"], $id_sede_jur) : '';
			  $data['message'] = 'OK';
			  echo json_encode($data);
		  } else {
			  $data['message'] = 'ERROR';
			  echo json_encode($data);
		  }
	  } else {
		  $data['message'] = 'FALSE';
		  echo json_encode($data);
	  }
  }



public function editar_registro_loteRechazo_contraloria_proceceso6(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('motivoRechazo');
    $perfil=$this->input->post('perfil');
    $modificado=date("Y-m-d H:i:s");


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 1;
    $arreglo["idMovimiento"]=63; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaVenc"]= $modificado;


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=1;
    $arreglo2["idMovimiento"]=63;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;    


	$datos= $this->Contraloria_model->getCorreoSt($idCliente);

	$lp = $this->Contraloria_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com');
	   $array = array_unique($correosClean);
	}

	$infoLote = $this->Contraloria_model->getNameLote($idLote);


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


  $mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-CONTRALORÍA (6. CORRIDA ELABORADA)');
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


	$validate = $this->Contraloria_model->validateSt6($idLote);

	if($validate == 1){
		if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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



public function editar_registro_loteRevision_contraloria_proceceso6(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');    
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');



    $arreglo=array();
    $arreglo["idStatusContratacion"]=6;
    $arreglo["idMovimiento"]=6;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
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

    while($i <= 2) {
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

    while($i <= 2) {
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
    while($i <= 2) {
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
    $arreglo2["idStatusContratacion"]=6;
    $arreglo2["idMovimiento"]=6;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;     

		$validate = $this->Contraloria_model->validateSt6($idLote);

		if($validate == 1){
			if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function editar_registro_loteRevision_contraloria5_Acontraloria6(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');

	
    $arreglo=array();
    $arreglo["idStatusContratacion"]=5;
    $arreglo["idMovimiento"]=75;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
	$arreglo["modificado"]=date("Y-m-d H:i:s");
	

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=5;
    $arreglo2["idMovimiento"]=75;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;     


	$validate = $this->Contraloria_model->validateSt5($idLote);


	if($validate == 1){
			if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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




  public function editar_registro_loteRechazo_contraloria_proceceso5_2(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');



    $arreglo=array();
    $arreglo["idStatusContratacion"]= 1;
    $arreglo["idMovimiento"]=92; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=1;
    $arreglo2["idMovimiento"]=92;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;    


	$datos= $this->Contraloria_model->getCorreoSt($idCliente);

	$lp = $this->Contraloria_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com');
	   $array = array_unique($correosClean);
	}

	$infoLote = $this->Contraloria_model->getNameLote($idLote);

 
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

  $mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)');
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
	

	$validate = $this->Contraloria_model->validateSt5($idLote);


	if($validate == 1){
			if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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





  public function editar_registro_loteRevision_contraloria6_AJuridico7(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=6;
    $arreglo["idMovimiento"]=76;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=6;
    $arreglo2["idMovimiento"]=76;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;     


	$validate = $this->Contraloria_model->validateSt6($idLote);

	if($validate == 1){
		if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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





  



  public function editar_registro_lote_contraloria_proceceso9(){

	$idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
    $fechaVenc=$this->input->post('fechaVenc');
    $totalNeto2=$this->input->post('totalNeto2');
    $charactersNoPermit = array('$',',');
    $totalNeto2 = str_replace($charactersNoPermit, '', $totalNeto2);

    $arreglo=array();
    $arreglo["idStatusContratacion"]=9;
    $arreglo["idMovimiento"]=39;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]= $this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaVenc"]= $modificado;
    $arreglo["totalNeto2"]=$totalNeto2;

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=9;
    $arreglo2["idMovimiento"]=39;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;         
    $arreglo2["idCliente"]= $idCliente;          


	$validate = $this->Contraloria_model->validateSt9($idLote);

	$this->Contraloria_model->validate90Dias($idLote,$idCliente,$this->session->userdata('id_usuario'));

	if($validate == 1){
		if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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







  public function editar_registro_loteRechazo_contraloria_proceceso9(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 7;
    $arreglo["idMovimiento"]=64; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
	$arreglo["status8Flag"]=0;

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=7;
    $arreglo2["idMovimiento"]=64;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;    

	$validate = $this->Contraloria_model->validateSt9($idLote);

	if($validate == 1){
		if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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



  public function registro_lote_contraloria_proceceso10(){

	  $folio = array();
	  $folio["variable"] = $this->Contraloria_model->findCount();

	  if ($folio <> NULL) {
		  foreach ($folio as $folioUpd) {
			  $folioUp = array();
			  $folioUp["contador"] = $folioUpd->contador + 1;

			  if ($_POST <> NULL) {

				  $misDatosJSON = json_decode($_POST['datos']);

				  $f = 0;
				  $a = 0;

				  foreach ($misDatosJSON as list($b)) {

					  $info = array();
					  $info["lotes"] = $this->Contraloria_model->selectRegistroPorContrato($b);

					  if ($info["lotes"] <> NULL) {

						  foreach ($info as $fila) {

							  $updateStatus10 = array();
							  $updateStatus10["idStatusContratacion"] = 10;
							  $updateStatus10["idMovimiento"] = 40;
							  $updateStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
							  $updateStatus10["usuario"] = $this->session->userdata('id_usuario');
							  $updateStatus10["perfil"] = $this->session->userdata('id_rol');
							  $updateStatus10["modificado"] = date("Y-m-d H:i:s");
							  $updateStatus10["fechaRL"] = date('Y-m-d H:i:s');


							  $histStatus10 = array();
							  $histStatus10["idStatusContratacion"] = 10;
							  $histStatus10["idMovimiento"] = 40;
							  $histStatus10["nombreLote"] = $fila->nombreLote;
							  $histStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
							  $histStatus10["usuario"] = $this->session->userdata('id_usuario');
							  $histStatus10["perfil"] = $this->session->userdata('id_rol');
							  $histStatus10["modificado"] = date("Y-m-d H:i:s");
							  $histStatus10["fechaVenc"] = $fila->fechaVenc;
							  $histStatus10["idLote"] = $fila->idLote;
							  $histStatus10["idCondominio"] = $fila->idCondominio;
							  $histStatus10["idCliente"] = $fila->id_cliente;
							  $histStatus10["folioContrato"] = $folioUpd->contador + 1;


							  $arrayAacuse = array();
							  $arrayAacuse["primerNombre"] = $fila->nombre;
							  $arrayAacuse["apellidoPaterno"] = $fila->apellido_paterno;
							  $arrayAacuse["apellidoMaterno"] = $fila->apellido_materno;
							  $arrayAacuse["razonSocial"] = $fila->rfc;
							  $arrayAacuse["code"] = $b;
							  $arrayAacuse["mod"] = date("Y-m-d H:i:s");
							  $arrayAacuse["contratoUrgente"] = $fila->contratoUrgente;
							  // $arrayAacuse["nombreGerente"] = $fila->gerente;
							  // $arrayAacuse["nombreAsesor"] = $fila->asesor;
							  // $arrayAacuse["observacionContratoUrgente"] = $fila->observacionContratoUrgente;

							  $dato3 = array();
							  $dato3["numContrato"] = $b;
							  $dato3["fechaRecepcion"] = date('Y-m-d H:i:s');


							  if ($this->Contraloria_model->updateSt10($b,$updateStatus10,$histStatus10,$dato3,1, $folioUp) == TRUE) {
								 $a = $a+1;
							  } else {
								 $a;
							  }
							  $acuse = array();
							  $i = 0;
							  foreach ($arrayAacuse as $nombre) {
								  $acuse[] = $nombre;
								  $i++;
							  }
						  }
					  } else {
						$f = $f+1;
					  }
				  }


				  if($f >= 1){
					$data['message'] = 'NODETECTED';
					echo json_encode($data);
				  } else {

					if($a >= 1){
						$data['message'] = 'OK';
						echo json_encode($data);
					  } else {
						$data['message'] = 'ERROR';
						echo json_encode($data);
					  }
	
				  }


			  } else {
				$data['message'] = 'VOID';
				echo json_encode($data);
			  }
		  }
	  }
  }

  public function registroStatus12ContratacionRepresentante(){

	  $datos = array();
	  $datos = $this->Contraloria_model->registroStatusContratacion12();

	  if($datos != null) {
		  echo json_encode($datos);
	  } else {
		  echo json_encode(array());
	  }

  }





    public function insertContratosFirmados(){

        if($_POST <> NULL){

            $f = 0;
            $a = 0;

            $misDatosJSON = json_decode($_POST['datos']);

            foreach ($misDatosJSON as list($b)) {

                $data=array();
                $data["lotes"]= $this->Contraloria_model->selectRegistroPorContratoStatus12($b);


                if($data["lotes"] <> NULL) {

                    $arreglo=array();
                    $arreglo["idStatusContratacion"]=12;
                    $arreglo["idMovimiento"]=42;
                    $arreglo["comentario"]="Contrato Recibido con firma de RL";
                    $arreglo["usuario"]=$this->session->userdata('id_usuario');
                    $arreglo["perfil"]=$this->session->userdata('id_rol');
                    $arreglo["modificado"]=date("Y-m-d H:i:s");
                    $arreglo["firmaRL"]= "FIRMADO";


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



                    $dato3=array();
                    $dato3["numContrato"]= $b;
                    $dato3["fechaFirma"]= date('Y-m-d H:i:s');




                    foreach ($data as $fila) {

                        $dato=array();
                        $dato["idStatusContratacion"]= 12;
                        $dato["idMovimiento"]=42;
                        $dato["nombreLote"]=$fila->nombreLote;
                        $dato["comentario"]= "Contrato Recibido con firma de RL";
                        $dato["usuario"]=$this->session->userdata('id_usuario');
                        $dato["perfil"]=$this->session->userdata('id_rol');
                        $dato["modificado"]=date("Y-m-d H:i:s");



                        $horaInicio = date("08:00:00");
                        $horaFin = date("16:00:00");

                        $arregloFechas = array();

                        $fechaAccion = $fila->fechaRL;
                        $hoy_strtotime2 = strtotime($fechaAccion);
                        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
                        $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
                        $time = date('H:i:s', $hoy_strtotime2);

                        if ($time > $horaInicio and $time < $horaFin) {

                            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                                $sig_fecha_feriado2 == "25-12" ) {


                                $fecha = $fechaAccion;

                                $i = 0;
                                while($i <= 4) {
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
                                        $arregloFechas[$i] = $sig_fecha;
                                        $i++;
                                    }
                                    $fecha = $sig_fecha;
                                }

                                $dato["fechaVenc"]= end($arregloFechas);


                            }else{

                                $fecha = $fechaAccion;

                                $i = 0;
                                while($i <= 3) {
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
                                        $arregloFechas[$i] = $sig_fecha;
                                        $i++;
                                    }
                                    $fecha = $sig_fecha;
                                }


                                $dato["fechaVenc"]= end($arregloFechas);


                            }
                        }

                        elseif ($time < $horaInicio || $time > $horaFin) {


                            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                                $sig_fecha_feriado2 == "25-12" ) {


                                $fecha = $fechaAccion;

                                $i = 0;
                                while($i <= 4) {
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
                                        $arregloFechas[$i] = $sig_fecha;
                                        $i++;
                                    }
                                    $fecha = $sig_fecha;
                                }

                                $dato["fechaVenc"]= end($arregloFechas);


                            }else{

                                $fecha = $fechaAccion;

                                $i = 0;
                                while($i <= 4) {
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
                                        $arregloFechas[$i] = $sig_fecha;
                                        $i++;
                                    }
                                    $fecha = $sig_fecha;
                                }


                                $dato["fechaVenc"]= end($arregloFechas);

                            }
                        }


                        $dato["idLote"]= $fila->idLote;
                        $dato["idCondominio"]= $fila->idCondominio;
                        $dato["idCliente"]= $fila->id_cliente;


                        if ($this->Contraloria_model->updateSt12($b,$arreglo,$dato,$dato3) == TRUE) {
                            $a = $a+1;
                        } else {
                            $a;
                        }

                    }
                }

                else {
                    $f = $f+1;
                }

            }

            if($f >= 1){
                $data['message'] = 'NODETECTED';
                echo json_encode($data);
            } else {

                if($a >= 1){
                    $data['message'] = 'OK';
                    echo json_encode($data);
                } else {
                    $data['message'] = 'ERROR';
                    echo json_encode($data);
                }

            }

        }else{

            $data['message'] = 'VOID';
            echo json_encode($data);
        }

    }
	
	


	public function editar_registro_lote_contraloria_proceceso13(){

		$idLote=$this->input->post('idLote');
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
	
		$arreglo=array();
		$arreglo["idStatusContratacion"]=13;
		$arreglo["idMovimiento"]=43;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
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
		while($i <= 6) {
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
		while($i <= 5) {
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
		while($i <= 6) {
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
		while($i <= 6) {
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
		$arreglo2["idStatusContratacion"]=13;
		$arreglo2["idMovimiento"]=43;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $fechaVenc;
		$arreglo2["idLote"]= $idLote;  	
		$arreglo2["idCondominio"]= $idCondominio;          
		$arreglo2["idCliente"]= $idCliente;   
	
		$validate = $this->Contraloria_model->validateSt13($idLote);

		if($validate == 1){
				if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
	
	
	



public function editar_registro_lote_contraloria_proceceso15(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');

    $arreglo=array();
    $arreglo["idStatusContratacion"]=15;
    $arreglo["idMovimiento"]=45;
    $arreglo["comentario"]=$comentario;
    $arreglo["idStatusLote"]=2;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaVenc"]= $modificado;


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=15;
    $arreglo2["idMovimiento"]=45;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;   
	

		$validate = $this->Contraloria_model->validateSt15($idLote);

		if($validate == 1){
				if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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



  public function editar_registro_loteRechazo_contraloria_proceceso15(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 13;
    $arreglo["idMovimiento"]=68; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaVenc"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=13;
    $arreglo2["idMovimiento"]=68;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;   


		$validate = $this->Contraloria_model->validateSt15($idLote);

		if($validate == 1){
				if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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






  public function liberacion_contraloria(){
	/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	/*-------------------------------------------------------------------------------*/
	$this->load->view('template/header');
	$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
	$this->load->view("contraloria/vista_liberacion_contraloria", $datos);
}


public function app_lib(){
	$res =  $this->Contraloria_model->aplicaLiberaciones($this->input->post('idResidencial'));  
	if($res == true){
		$data['message'] = 'OK';
		echo json_encode($data);
	}else {
		$data['message'] = 'FALSE';
		echo json_encode($data);
    }

}



public function return1(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');    
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');



    $arreglo=array();
    $arreglo["idStatusContratacion"]=6;
    $arreglo["idMovimiento"]=95;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
	$arreglo["modificado"]=date("Y-m-d H:i:s");

	
    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=6;
    $arreglo2["idMovimiento"]=95;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente;     

		$validate = $this->Contraloria_model->validateSt6($idLote);

		if($validate == 1){
			if ($this->Contraloria_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function changeUb(){

	$idLote=$this->input->post('idLote');
	$ubicacion=$this->input->post('ubicacion');

	$validate = $this->Contraloria_model->update_sede($idLote, $ubicacion);

		if ($validate == TRUE){
				$data['message'] = 'OK';
				echo json_encode($data);
			}else{
				$data['message'] = 'ERROR';
				echo json_encode($data);
		}


  }


	public function inventario_c()
	{
		$this->validateSession();
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contraloria/datos_lote_contratacion_c_view", $datos);
	}
	
	public function msni() {
		$this->validateSession();
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/

		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contraloria/vista_msni", $datos);
	}


	public function getMsni($typeTransaction, $key){
		$msni = $this->Contraloria_model->getMsni($typeTransaction, $key);
		if ($msni != NULL){
			echo json_encode($msni);
		}else{
			echo json_encode();
		}
	}

	public function update_msni(){
	    $typeTranscation = $this->input->post('typeTransaction');
        $arrayMsi = json_decode($this->input->post('file_msni'));
//	    print_r($this->input->post('idResidencial'));
//	    echo '<br>';
//	    echo '<br>';
//	    print_r(json_decode($this->input->post('typeTransaction')));
//        echo'<br>';
        //si es tipo de transaccion es = a 1
        //quiere decir que la actualizacion es por condominios
        //si es 0: quiere decir que es por los lotes subidos
//        echo 'lotes a actualizar<br>';
        $array_update = array();
        switch ($typeTranscation){
            case 1:
                foreach ($arrayMsi as $index => $result){
                    $data = $this->Contraloria_model->getLotes($arrayMsi[$index]->ID);
                    foreach ($data as $resultado){
                        $array_push=array(
                            'idLote' => $resultado['idLote'],
                            'msi' => $result->MSNI
                        );
                        array_push($array_update, $array_push);
                    }
                }
                break;
            case 0:
                foreach ($arrayMsi as $result){
                    $array_push=array(
                        'idLote' => $result->ID,
                        'msi' => $result->MSNI
                    );
                    array_push($array_update, $array_push);
                }
                break;
        }

       $resultado = $this->General_model->updateBatch("lotes", $array_update, "idLote"); // MJ: SE MANDA CORRER EL UPDATE BATCH

        if($resultado){
            $data['message'] = 'OK';
        }else{
            $data['message'] = 'ERROR';
        }
		echo json_encode($data);
	}

	public function generalClientsReport()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("contraloria/general_clients_report", $datos);
    }

    public function getGeneralClientsReport(){
        $data['data'] = $this->Contraloria_model->getGeneralClientsReport()->result_array();
        echo json_encode($data);
    }

    
    public function returnToStatusFourteen()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("contraloria/returnToStatusFourteen", $datos);
    }

    function getClientsInStatusFifteen($idCondominio)
    {
        $data['data'] = $this->Contraloria_model->getClientsInStatusFifteen($idCondominio)->result_array();
        echo json_encode($data);
    }

    function getInfoReturnStatus15()
    {
        $idLote = $this->input->post("idLote");
        $datos = $this->Contraloria_model->selectRegistroLoteCaja($idLote);
        echo json_encode($datos);
    }

    function updateReturnStatus15()
    {
        if (isset($_POST) && !empty($_POST)) {
            $idLote = $this->input->post('idLote');
            $idCondominio = $this->input->post('idCondominio');
            $nombreLote = $this->input->post('nombreLote');
            $idCliente = $this->input->post('idCliente');
            $comentario = $this->input->post('comentario');
            $arreglo = array();
            $arreglo["idStatusContratacion"] = 14;
            $arreglo["idMovimiento"] = 80;
            $arreglo["comentario"] = $comentario;
            $arreglo["usuario"] = $this->session->userdata('id_usuario');
            $arreglo["perfil"] = $this->session->userdata('id_rol');
            $arreglo["idStatusLote"] = 3;
            $arreglo["modificado"] = date("Y-m-d H:i:s");
            $arreglo["fechaVenc"] = date("Y-m-d H:i:s");
            $arreglo2 = array();
            $arreglo2["idStatusContratacion"] = 14;
            $arreglo2["idMovimiento"] = 80;
            $arreglo2["comentario"] = $comentario;
            $arreglo2["usuario"] = $this->session->userdata('id_usuario');
            $arreglo2["perfil"] = $this->session->userdata('id_rol');
            $arreglo2["modificado"] = date("Y-m-d H:i:s");
            $arreglo2["fechaVenc"] = date("Y-m-d H:i:s");
            $arreglo2["idLote"] = $idLote;
            $arreglo2["nombreLote"] = $nombreLote;
            $arreglo2["idCondominio"] = $idCondominio;
            $arreglo2["idCliente"] = $idCliente;
            if ($this->Contraloria_model->editaRegistroLoteCaja($idLote, $arreglo)) {
                $this->Contraloria_model->insertHistorialLotes($arreglo2);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    function getLotesAllAssistant($condominio)
    {
        $data = $this->Contraloria_model->getLotesAllAssistant($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function depositoSeriedadAssistant()
	{
		$this->validateSession();
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("contraloria/ds_assistant",$datos);
	}

	public function expedienteAssistant(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("contraloria/vista_expediente_assistant", $datos);
	}

	function getLotesAllTwo($condominio)
    {
        $data = $this->Contraloria_model->getLotesTwo($condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    } 

    public function getLiberacionesInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $data['data'] = $this->Contraloria_model->getLiberacionesInformation($this->input->post("idCondominio"))->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

   

    public function status9Report()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("contraloria/status9Report", $datos);
    }

    public function getInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $data['data'] = $this->Contraloria_model->getInformation($beginDate, $endDate)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function removeMark(){
        $data = array("observacionContratoUrgente" => NULL, "usuario" => $this->session->userdata('id_usuario'));
        $adata = array("id_parametro" => $this->input->post("idLote"), "tipo" => "update", "anterior" => 1, "nuevo" => "", "col_afect" => "observacionContratoUrgente", "tabla" => "lotes", "creado_por" => $this->session->userdata('id_usuario'));
        $this->Contraloria_model->addRecord("auditoria", $adata); // MJ: LLEVA 2 PARÁMETROS $table, $data
        $response = $this->Contraloria_model->updateRecord("lotes", $data, "idLote", $this->input->post("idLote")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
        echo json_encode($response);
    }


	  public function Documentacion_loteclient(){
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }

        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();

        $this->load->view('template/header');
        $this->load->view("contraloria/vista_documentacion_contraloria_cl_lote", $datos);
    }


	public function updateLotesStatusLiberacion(){
        for ($i = 0; $i < count($this->input->post("idLote")); $i++) {
            $updateArrayData[] = array(
                'idLote' => $_POST['idLote'][$i],
                'observacionContratoUrgente' => 1,
                'usuario' => $this->session->userdata('id_usuario')
            );
            $insertArray[$i] = array(
            	'id_parametro' => $_POST['idLote'][$i],
                'tipo' => 'update',
                'anterior' => '',
                'nuevo' => '1',
                'col_afect' => 'observacionContratoUrgente',
                'tabla' => 'lotes',
                'creado_por' => $this->session->userdata('id_usuario')
            );
        }
        $response = $this->db->update_batch('lotes', $updateArrayData, 'idLote');
        $this->db->insert_batch('auditoria',$insertArray);
        echo json_encode($response);
    }


    public function setData()
    {

				$json = json_decode($this->input->post("jsonInfo"));

			//print_r($json);
			//echo "---------";
			//print_r($json[1]->ID_LOTE);

			$insertArrayData = array();
			$updateArrayData = array();
                $updateArrayData = array();

			
			//	$updateAuditoriaData = array("fecha_modificacion" => date("Y-m-d H:i:s"), "modificado_por" => $this->session->userdata('id_usuario'));
             //   $insertAuditoriaData = array("fecha_creacion" => date("Y-m-d H:i:s"), "creado_por" => $this->session->userdata('id_usuario'));

                for ($i = 0; $i < count($json); $i++) { // MJ: SE ARMAN ARRAYS PARA INSERTAR | ACTUALIZAR SEGÚN SEA EL CASO
					$commonData = array();
					$commonData2 = array();

                        $commonData +=  array("idLote" => $json[$i]->ID_LOTE);
                        $commonData +=  array("observacionContratoUrgente" => 1);
                        $commonData +=  array("usuario" => $this->session->userdata('id_usuario'));

						
                        $commonData2 +=  array("id_parametro" => $json[$i]->ID_LOTE);
                        $commonData2 +=  array("tipo" => 'update');
                        $commonData2 +=  array("anterior" => '');
                        $commonData2 +=  array("nuevo" => 1);
                        $commonData2 +=  array("col_afect" => 'observacionContratoUrgente');
						$commonData2 +=  array("tabla" => 'lotes');
						$commonData2 +=  array("creado_por" => $this->session->userdata('id_usuario'));
						
                        array_push($insertArrayData, $commonData2);
						array_push($updateArrayData, $commonData); 
                }
              

				//print_r($insertArrayData);

				$response = $this->db->update_batch('lotes', $updateArrayData, 'idLote');
       			 $this->db->insert_batch('auditoria',$insertArrayData);

					echo json_encode($response);



    }

	public function lotes_apartados(){
		$this->validateSession();
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		if ($this->session->userdata('id_usuario') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		switch($this->session->userdata('id_usuario')){
			case '2807': //Mariela Sánchez Sánchez
			case '2826': //Ana Laura García Tovar
			case '2767': //Irene Vallejo
				$this->load->view('template/header');
	 			$this->load->view("contraloria/vista_lotes_precio_enganche",$datos);
				break;
			case '2754': //Gabriela Hernández Tovar
				$this->load->view('template/header');
	 			$this->load->view("contraloria/vista_lotes_enganche_sede",$datos);
				break;
			case '2749': //Ariadna Martínez
				$this->load->view('template/header');
	 			$this->load->view("contraloria/vista_lotes_sede",$datos);
				break;
			case '1297': //María de Jesús
			case '826': //Victor Hugo
				$this->load->view('template/header');
				$this->load->view("contraloria/vista_lotes_apartados",$datos);
				break;
			default:
				echo '<script>alert("ACCESO DENEGADO"); window.location.href="' . base_url() . '";</script>';
				break;
		}
        /*-------------------------------------------------------------------------------*/
	}

    /**al día de hoy**/
    public function backExp(){
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view("contraloria/checarExpediente", $datos);
    }


	public function get_lote_historial($lote){
		echo json_encode($this->Contraloria_model->get_datos_lotes($lote)->result_array());
	}

	public function get_lote_apartado(){
		$idLote = $_GET['idLote'];

		$data = $this->Contraloria_model->get_datos_lotes($idLote)->row();

		if($data != null)
			echo json_encode($data);
		else
			echo json_encode(array());
	}

	public function lista_lote_apartado($condominio)
	{
		$residencial = 0;
		$data = $this->registrolote_modelo->getLotesApartado($condominio,$residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function updateLote(){
		$idLote = $_POST['idLote'];

		$data = $this->Contraloria_model->get_datos_lotes($idLote);
		$data = array(
			"totalNeto2" => $this->formatter->removeNumberFormat($_POST['preciodesc']),
			"totalNeto" => $this->formatter->removeNumberFormat($_POST['enganches']), 
			"ubicacion" => $this->input->post("ubicacion_sede"));

		$response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
		echo json_encode($response);
	}

	public function lista_sedes(){
		echo json_encode($this->Contraloria_model->get_sedes_lista()->result_array());
	}

	public function updateLotePrecioEnganche(){
		$idLote = $_POST['idLote'];

		$data = $this->Contraloria_model->get_datos_lotes($idLote);
		$data = array(
			"totalNeto2" => $this->formatter->removeNumberFormat($_POST['preciodesc']),
			"totalNeto" => $this->formatter->removeNumberFormat($_POST['enganches']));

		$response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
		echo json_encode($response);
	}

	public function updateLoteEngancheSede(){
		$idLote = $_POST['idLote'];

		$data = $this->Contraloria_model->get_datos_lotes($idLote);
		$data = array(
			"totalNeto" => $this->formatter->removeNumberFormat($_POST['enganches']),
			"ubicacion" => $this->input->post("ubicacion_sede"));

		$response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
		echo json_encode($response);
	}

	public function updateLoteSede(){
		$idLote = $_POST['idLote'];

		$data = $this->Contraloria_model->get_datos_lotes($idLote);
		$data = array( 
			"ubicacion" => $this->input->post("ubicacion_sede"));

		$response = $this->General_model->updateRecord('lotes', $data, 'idLote', $idLote);
		echo json_encode($response);
	}

	public function reporte_diario(){
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		$this->load->view("contraloria/vista_reporte_diario",$datos);
		
	}

	public function getRegistroDiario()
	{
		$data = array();
		$data = $this->Contraloria_model->registroDiario();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getRegistroDiarioPorFecha($fecha_inicio)
	{
		//$fecha_inicio = $_GET['fecha'];
		$data = array();
		$data = $this->Contraloria_model->registroDiarioPorFecha($fecha_inicio);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
}