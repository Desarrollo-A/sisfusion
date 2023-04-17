<?php

use application\helpers\email\administracion\Elementos_Correos_Admin;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Administracion extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Administracion_model');
		$this->load->model('registrolote_modelo');

		$this->load->library(array('session', 'form_validation'));
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		//LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
         $this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url', 'form', 'email/administracion/elementos_correo', 'email/plantilla_dinamica_correo'));
		$this->load->database('default');
        $this->load->library('phpmailer_lib');
        date_default_timezone_set('America/Mexico_City');
		$this->validateSession();
	}


	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '11' && $this->session->userdata('id_rol') != '34' 
			&& $this->session->userdata('id_rol') != '23' && $this->session->userdata('id_rol') != '35' 
			&& $this->session->userdata('id_rol') != '26' && $this->session->userdata('id_rol') != '41' 
			&& $this->session->userdata('id_rol') != '39' && $this->session->userdata('id_rol') != '31' 
			&& $this->session->userdata('id_rol') != '49' && $this->session->userdata('id_rol') != '50' 
			&& $this->session->userdata('id_rol') != '40' && $this->session->userdata('id_rol') != '54' 
			&& $this->session->userdata('id_rol') != '58' &&
            $this->session->userdata('id_rol') != '10' && $this->session->userdata('id_rol') != '18' &&
            $this->session->userdata('id_rol') != '19' && $this->session->userdata('id_rol') != '20' &&
            $this->session->userdata('id_rol') != '21' && $this->session->userdata('id_rol') != '28' &&
            $this->session->userdata('id_rol') != '33' && $this->session->userdata('id_rol') != '25' &&
            $this->session->userdata('id_rol') != '25' && $this->session->userdata('id_rol') != '27' &&
            $this->session->userdata('id_rol') != '30' && $this->session->userdata('id_rol') != '36' &&
            $this->session->userdata('id_rol') != '22' && $this->session->userdata('id_rol') != '53' &&
            $this->session->userdata('id_rol') != '8' && $this->session->userdata('id_rol') != '23' &&
            $this->session->userdata('id_rol') != '12' && $this->session->userdata('id_rol') != '61' &&
			$this->session->userdata('id_rol') != '63' && $this->session->userdata('id_rol') != '64' && 
			$this->session->userdata('id_rol') != '65' && $this->session->userdata('id_rol') != '66' && 
			$this->session->userdata('id_rol') != '69' && $this->session->userdata('id_rol') != '68' && 
			$this->session->userdata('id_rol') != '70' && $this->session->userdata('id_rol') != '71' &&
			$this->session->userdata('id_rol') != '72' && $this->session->userdata('id_rol') != '73' && $this->session->userdata('id_rol') != '74' && $this->session->userdata('id_rol') != '75' && $this->session->userdata('id_rol') != '76' && $this->session->userdata('id_rol') != '77' && $this->session->userdata('id_rol') != '78' && $this->session->userdata('id_rol') != '79' && $this->session->userdata('id_rol') != '80' && $this->session->userdata('id_rol') != '81' && $this->session->userdata('id_rol') != '82' && $this->session->userdata('id_rol') != '83' && $this->session->userdata('id_rol') != '84'
        ) {
			redirect(base_url() . 'login');
		}

		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		/*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		// $this->load->view('administracion/inicio_administracion_view',$datos);
		$this->load->view('template/home',$datos);
		$this->load->view('template/footer');
	}

	public function lista_cliente_administracion(){
		    /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
			$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
			/*-------------------------------------------------------------------------------*/		
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view",$datos);
	}

	public function documentacion_administracion(){
		    /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
			$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
			/*-------------------------------------------------------------------------------*/
	
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_documentos_contratacion_view", $datos);//datos_cliente_contratacion_view
	}

	public function datos_estatus_11_datos(){
		$data = $this->Administracion_model->get_datos_lote_11();
		$dataPer= array();
		for($i=0;$i< count($data);$i++)
		{
			$dataPer[$i]['idLote']=$data[$i]->idLote;
			$dataPer[$i]['idCondominio']=$data[$i]->idCondominio;
			$dataPer[$i]['id_cliente']=$data[$i]->id_cliente;
			$dataPer[$i]['nombreCliente']=$data[$i]->nombreCliente;
			$dataPer[$i]['nombreLote']=$data[$i]->nombreLote;
			$dataPer[$i]['idStatusContratacion']=$data[$i]->idStatusContratacion;
			$dataPer[$i]['idMovimiento']=$data[$i]->idMovimiento;
			$dataPer[$i]['modificado']=$data[$i]->modificado;
			$dataPer[$i]['rfc']=$data[$i]->rfc;
			$dataPer[$i]['comentario']=$data[$i]->comentario;
			$dataPer[$i]['fechaVenc']=$data[$i]->fechaVenc;
			$dataPer[$i]['perfil']=$data[$i]->perfil;
			$dataPer[$i]['nombreResidencial']=$data[$i]->nombreResidencial;
			$dataPer[$i]['nombreCondominio']=$data[$i]->nombreCondominio;
			$dataPer[$i]['ubicacion']=$data[$i]->ubicacion;
			$dataPer[$i]['gerente']=$data[$i]->gerente;
			$dataPer[$i]['asesor']=$data[$i]->asesor;
			$dataPer[$i]['coordinador']=$data[$i]->coordinador;
			$dataPer[$i]['tipo_venta']=$data[$i]->tipo_venta;
			$dataPer[$i]['descripcion']=$data[$i]->descripcion;
			$dataPer[$i]['totalNeto']=$data[$i]->totalNeto;
			$dataPer[$i]['vl']=$data[$i]->vl;
			$dataPer[$i]['nombreSede']=$data[$i]->nombreSede;
			$horaInicio = date("08:00:00");
			$horaFin = date("16:00:00");
			$arregloFechas = array();  
			$fechaAccion = $data[$i]->fechaSolicitudValidacion;  
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			$time = date('H:i:s', $hoy_strtotime2);
			



			if($data[$i]->fechaSolicitudValidacion=='' || empty($data[$i]->fechaSolicitudValidacion)){
				$dataPer[$i]['fechaVenc2'] = 'N/A';
			}else{
				if ($time > $horaInicio and $time < $horaFin) {
					if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
						$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
						$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
						$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
						$sig_fecha_feriado2 == "25-12") {

						$fecha = $fechaAccion;

						$z = 0;
						while ($z <= 1) {
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
								$arregloFechas[$z] = $sig_fecha;
								$z++;
							}
							$fecha = $sig_fecha;
						}

						$d = end($arregloFechas);
						$dataPer[$i]['fechaVenc2'] = $d;

					} else {

						$fecha = $fechaAccion;
						$z = 0;
						while ($z <= 0) {
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
								$arregloFechas[$z] = $sig_fecha;
								$z++;
							}
							$fecha = $sig_fecha;
						}

						$d = end($arregloFechas);
						$dataPer[$i]['fechaVenc2'] = $d;

					}
				}
				elseif ($time < $horaInicio || $time > $horaFin) {

					if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
						$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
						$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
						$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
						$sig_fecha_feriado2 == "25-12"){

						$fecha = $fechaAccion;

						$z = 0;
						while ($z <= 1) {
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
								$arregloFechas[$z] = $sig_fecha;
								$z++;
							}
							$fecha = $sig_fecha;
						}

                      $d = end($arregloFechas);
                      $dataPer[$i]['fechaVenc2'] = $d;

					}
					else {
						$fecha = $fechaAccion;

						$z = 0;
						while ($z <= 1) {
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
								$arregloFechas[$z] = $sig_fecha;
								$z++;
							}
							$fecha = $sig_fecha;
						}

						$d = end($arregloFechas);
						$dataPer[$i]['fechaVenc2'] = $d;
					}
				}
			}
		}
		if($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}
	public function inventario()/*this is the function*/
	{
		/*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		/*-------------------------------------------------------------------------------*/
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$datos["rol"] = $this->session->userdata('id_rol');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}

	public function registroStatus11ContratacionAdministracion() {
		$this->load->view('template/header');
		$this->load->view('administracion/datos_status11Contratacion_administracion_view');
	}

	public function editar_registro_lote_administracion_proceceso11(){
		$idLote=$this->input->post('idLote');	
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		$totalValidado=$this->input->post('totalValidado');
	
	
		$arreglo=array();
		$arreglo["idStatusContratacion"]=11;
		$arreglo["idMovimiento"]=41;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");	
		$arreglo["validacionEnganche"]= "VALIDADO";
		$arreglo["totalValidado"]= str_replace(array('$', ','),'', $totalValidado);
	
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");

		if ($horaActual > $horaInicio and $horaActual < $horaFin) {

		$fechaAccion = date("Y-m-d H:i:s");
		$hoy_strtotime2 = strtotime($fechaAccion);
		$sig_fecha_dia2 = date('D', $hoy_strtotime2);
		$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

		if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
			$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" || $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
			$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" || $sig_fecha_feriado2 == "25-12"){
			
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
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" || $sig_fecha_feriado == "25-12") {}
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
					$sig_fecha_feriado == "25-12") {}
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
			$arreglo2["idStatusContratacion"]=11;	
			$arreglo2["idMovimiento"]=41;
			$arreglo2["nombreLote"]=$nombreLote;
			$arreglo2["comentario"]=$comentario;
			$arreglo2["usuario"]=$this->session->userdata('id_usuario');
			$arreglo2["perfil"]=$this->session->userdata('id_rol');
			$arreglo2["modificado"]=date("Y-m-d H:i:s");
			$arreglo2["fechaVenc"]= $fechaVenc;
			$arreglo2["idLote"]= $idLote; 	
			$arreglo2["idCondominio"]= $idCondominio;          
			$arreglo2["idCliente"]= $idCliente;    
		

			$validate = $this->Administracion_model->validateSt11($idLote);


			if($validate == 1){

			if ($this->Administracion_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
	public function editar_registro_loteRechazo_administracion_proceceso11(){

		$idLote=$this->input->post('idLote');	 
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$user=$this->input->post('user');
		$perfil=$this->input->post('perfil'); 
		$modificado=date("Y-m-d H:i:s");
	

		$arreglo=array(); 
		$arreglo["idStatusContratacion"]= 7;
		$arreglo["idMovimiento"]=66; 
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["fechaVenc"]=date("Y-m-d H:i:s");
		$arreglo["status8Flag"] = 0;
	
		$arreglo2=array();
		$arreglo2["idStatusContratacion"]=7;
		$arreglo2["idMovimiento"]=66;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $modificado;
		$arreglo2["idLote"]= $idLote;  
		$arreglo2["idCondominio"]= $idCondominio;          
		$arreglo2["idCliente"]= $idCliente;


		$nombre = $this->session->userdata('nombre');
		$apellido_paterno = $this->session->userdata('apellido_paterno');
		$apellido_materno = $this->session->userdata('apellido_materno');

		$nombre_rechazador = $nombre." ".$apellido_paterno." ".$apellido_materno;

		$data_send = $this->Administracion_model->getInfoToMail($idCliente, $idLote);

		$data_ag = $this->Administracion_model->getAssisGte($idCliente);
		
		/*************************************************************************************
		 * Armado de parámetros a mandar a plantilla para creación de correo electrónico	 *
		 ************************************************************************************/
		$correos_entregar = array();
		// if(count($data_ag)>0){
		// 	foreach ($data_ag as $item=>$value){
		// 		array_push($correos_entregar, $value['correo']);
		// 	}
		// }

		$datos_etiquetas =array(
			'comentario' => $comentario,
			'id_cliente' => $idCliente,
			'id_lote' => $idLote
		);

		$datos_correo[0] = array(
			"nombreResidencial"	=> $data_send->nombreResidencial,
			"nombreCondominio"	=> $data_send->nombreCondominio,
			"nombreLote"		=> $data_send->nombreLote,
			"nombreCliente"		=> $data_send->nombreCliente,
			"nombreRechaza"		=> $nombre_rechazador,
			"fechaApartado"		=> $data_send->fechaApartado,
			"fechaRechazo"		=> $modificado,
		);

		#PROVICIONAL TESTING
		array_push($correos_entregar, 'programador.analista18@ciudadmaderas.com');
		//$correos_entregar[1] = 'mariadejesus.garduno@ciudadmaderas.com';

		$elementos_correo = array(	"setFrom" => Elementos_Correos_Admin::SET_FROM_EMAIL,
									"Subject" => Elementos_Correos_Admin::ASUNTO_CORREO_TABLA_RECHAZO_ADMIN_PROC_11. ' ' .$comentario);

		$comentario_general = Elementos_Correos_Admin::EMAIL_RECHAZO_ADMIN_PROC_11.'<br><br>'. $comentario;
		$datos_encabezados_tabla = Elementos_Correos_Admin::ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_ADMIN_PROC_11;

		$plantilla_correo = new plantilla_dinamica_correo;
		/********************************************************************************************************************************************/
		
		$validate = $this->Administracion_model->validateSt11($idLote);

		if($validate == 1){
		if ($this->Administracion_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
			$data['message'] = 'OK';
			$data_enviar_mail = $plantilla_correo->crearPlantillaCorreo($correos_entregar, $elementos_correo, $datos_correo, 
																		$datos_encabezados_tabla, $datos_etiquetas, $comentario_general);
			if ($data_enviar_mail > 0) {
				$data['status_msg'] = 'Correo enviado correctamente';
			} else {
				$data['status_msg'] = 'Correo no enviado '.$data_enviar_mail;
			}
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

	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			//echo "<script>console.log('No hay sesión iniciada');</script>";
			redirect(base_url() . "index.php/login");
		}
	}
	
	public function get_data_asignacion($idLote){
        $data = $this->Administracion_model->get_data_asignacion($idLote);
        echo json_encode($data);
    }
 
	public function get_edo_lote(){
        $data = $this->Administracion_model->get_edo_lote();
        echo json_encode($data);
    }
 
	public function get_des_lote(){
        $data = $this->Administracion_model->get_des_lote();
        echo json_encode($data);
	}
	

	public function update_asignacion(){
		$idLote=$this->input->post('idLote');	 
		$id_desarrollo=$this->input->post('id_desarrollo');
		$id_estado=$this->input->post('id_estado');	 
		
		$data=array();
		$data["id_desarrollo_n"]=$id_desarrollo;
		$data["id_estado"]=$id_estado;
		
		if ($this->Administracion_model->update_asignacion($idLote,$data) == TRUE){ 
			$data['message'] = 'OK';
			echo json_encode($data);
		}else{
			$data['message'] = 'ERROR';
			echo json_encode($data);
		}

    }

    public function status11Validado(){
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("administracion/validadoStatus11", $datos);
    }

    public function getDateStatus11(){
	    $data = $this->Administracion_model->getDateStatus11();
	    if($data == TRUE){
            $response['message'] = 'OK';
        }else{
            $response['message'] = 'ERROR';
        }
        echo json_encode($data);
    }

	public function repAdministracion(){
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("administracion/vista_reporte_admin", $datos);
	}
	public function getRepoAdmin($idResidencial){
		$data = $this->Administracion_model->getRepAdmon($idResidencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}
}




