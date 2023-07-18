<?php

 if (!defined('BASEPATH')) exit('No direct script access allowed');

class Juridico extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Juridico_model');
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		$this->load->model('Contraloria_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		$this->load->library(array('session','form_validation'));
		 //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->load->library('email');
		$this->validateSession();

		date_default_timezone_set('America/Mexico_City');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('perfil') != 'juridico')
		{
			redirect(base_url() . 'login');
		}
		$this->load->view('template/header');
		$this->load->view('template/home');
		$this->load->view('template/footer');
	}


		public function getStatus7ContratacionJuridico() {

			if(isset($_POST) && !empty($_POST))
			$data = $this->Juridico_model->registroStatusContratacion7($this->input->post("typeTransaction"), $this->input->post("beginDate"), $this->input->post("endDate"), $this->input->post("idResidencial"),$this->input->post("idCondominio"));
            else
                $data = $this->Juridico_model->registroStatusContratacion7();

		//$data = $this->Juridico_model->registroStatusContratacion7();
  
		$dataPer=array();
		for($i=0;$i< count($data);$i++)
		{
			$dataPer[$i]['idLote']=$data[$i]->idLote;
			$dataPer[$i]['idCondominio']=$data[$i]->idCondominio;
			$dataPer[$i]['id_cliente']=$data[$i]->id_cliente;
			$dataPer[$i]['fechaApartado']=$data[$i]->fechaApartado;
			$dataPer[$i]['nombre']=$data[$i]->nombre;
			$dataPer[$i]['apellido_paterno']=$data[$i]->apellido_paterno;
			$dataPer[$i]['apellido_materno']=$data[$i]->apellido_materno;
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
			$dataPer[$i]['vl']=$data[$i]->vl;
  			$dataPer[$i]['etapa']=$data[$i]->etapa;
			$dataPer[$i]['user']=$this->session->userdata('id_usuario');
			$dataPer[$i]['juridico']=$data[$i]->juridico;
			$dataPer[$i]['nombreSede']=$data[$i]->nombreSede;

			$proyecto = str_replace(' ', '',$data[$i]->nombreResidencial);
			$cluster = strtoupper($data[$i]->nombreCondominio);
			$string = str_replace("ñ", "N", $cluster);
			$arr = explode("_",$string);
			$clusterClean = implode("",$arr);
			$lote = str_replace(' ', '', $clusterClean);
			$numeroLote = preg_replace('/[^0-9]/','',$data[$i]->nombreLote);
			$dataPer[$i]['cbbtton'] = $proyecto.$lote.$numeroLote;


			$horaActual = date('H:i:s');
			$horaInicio = date("08:00:00");
			$horaFin = date("16:00:00");
			
		
			$arregloFechas = array();
			
			if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			
			
			$fechaAccion = $data[$i]->modificado;	
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
		
			
			if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 	
				 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				 $sig_fecha_feriado2 == "25-12") {
			
				
	
			$fecha = $fechaAccion;		
			$z = 0;
				while($z <= 2) {
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
							$arregloFechas[$z]= $sig_fecha;
							 $z++;
						  } 
				$fecha = $sig_fecha;
					   }

				$d= end($arregloFechas);
				$dataPer[$i]['fechaVenc2']=$d;
			
				   }else{

			
			$fecha = $fechaAccion;
			
			$z = 0;
				while($z <= 1) {
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
							$arregloFechas[$z]= $sig_fecha;
							 $z++;
						  } 
				$fecha = $sig_fecha;
					   }

			   $d= end($arregloFechas);
				$dataPer[$i]['fechaVenc2']=$d;
			
				   }
		
			} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {			
			
			$fechaAccion = $data[$i]->modificado;
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			
			if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
				 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				 $sig_fecha_feriado2 == "25-12") {
			
				$fecha = $fechaAccion;
			
			
			$z = 0;
				while($z <= 2) {
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
							$arregloFechas[$z]= $sig_fecha;
							 $z++;
						  } 
				$fecha = $sig_fecha;
					   }
			
				$d= end($arregloFechas);
				$dataPer[$i]['fechaVenc2']=$d;
				   }else{
			
			
			
			$fecha = $fechaAccion;

			$z = 0;
			
				while($z <= 2) {
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
							$arregloFechas[$z]= $sig_fecha;
							 $z++;
						  } 
				$fecha = $sig_fecha;
					   }
				$d= end($arregloFechas);
				$dataPer[$i]['fechaVenc2']=$d;			
				   }
			
			}



			$data_c = $this->Juridico_model->getCop($data[$i]->id_cliente);
			
			
			if (empty($data_c)) {
				
				 $dataPer[$i]['n_cop']= 0;			

			} else {
				$z='';

					foreach ($data_c as $cop){
							$z.= '-'.$cop["nombre"].' '.$cop["apellido_paterno"].' '.$cop["apellido_materno"].'<br>';
					}
	 
					$dataPer[$i]['nombret']= $data[$i]->nombre.' '.$data[$i]->apellido_paterno.' '.$data[$i]->apellido_materno;
					$dataPer[$i]['nombrec'] = $z;

		
			}




		}
  
		if($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}
  


	public function editar_registro_lote_juridico_proceceso7(){

		$idLote=$this->input->post('idLote');
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		$numContrato=$this->input->post('numContrato');
	
	
		$arreglo=array();
		$arreglo["idStatusContratacion"]= 7;
		$arreglo["idMovimiento"]= 37;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["numContrato"]=$numContrato;
		$arreglo["fechaSolicitudValidacion"] = date('Y-m-d H:i:s');
	
	
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
		while($i <= 16) {
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

		while($i <= 15) {
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

		while($i <= 16) {
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
	
		while($i <= 16) {
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
		$arreglo2["idStatusContratacion"]= 7;
		$arreglo2["idMovimiento"]=37;	
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $fechaVenc;
		$arreglo2["idLote"]= $idLote;
		$arreglo2["idCondominio"]= $idCondominio;          
		$arreglo2["idCliente"]= $idCliente;          
	

	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
	
	
public function editar_registro_loteRevision_juridico_proceceso7(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
    $fechaVenc=$this->input->post('fechaVenc');
	$arreglo["status8Flag"] = 0;

    $arreglo=array();
    $arreglo["idStatusContratacion"]= 7;
    $arreglo["idMovimiento"]=7;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]= 7;
    $arreglo2["idMovimiento"]=7;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote; 
    $arreglo2["idCondominio"]= $idCondominio;          
    $arreglo2["idCliente"]= $idCliente; 


	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function editar_registro_loteRechazo_juridico_proceceso7(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 5;
    $arreglo["idMovimiento"]=22; 
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["fechaVenc"]=$modificado;


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=5;
    $arreglo2["idMovimiento"]=22;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario   "]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $modificado;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;    
	


		$validate = $this->Juridico_model->validateSt7($idLote);

		if($validate == 1){
			if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function sendMailRechazoEst3() {

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");


      $valida_tl = $this->Contraloria_model->checkTipoVenta($idLote);

      if($valida_tl[0]['tipo_venta'] == 1){
          $idStatusContratacion = 1;
          $idMovimiento = 109;
      }else{
          $idStatusContratacion = 1;
          $idMovimiento = 82;
      }

	$arreglo=array();
	$arreglo["idStatusContratacion"]=$idStatusContratacion;
	$arreglo["idMovimiento"]=$idMovimiento;
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
	$arreglo2["idStatusContratacion"]=$idStatusContratacion;
	$arreglo2["idMovimiento"]=$idMovimiento;
	$arreglo2["nombreLote"]=$nombreLote;
	$arreglo2["comentario"]=$comentario;
	$arreglo2["usuario"]=$this->session->userdata('id_usuario');
	$arreglo2["perfil"]=$this->session->userdata('id_rol');
	$arreglo2["modificado"]=date("Y-m-d H:i:s");
	$arreglo2["fechaVenc"]= date("Y-m-d H:i:s");
	$arreglo2["idLote"]= $idLote;  
	$arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;

	    // $datos= $this->Juridico_model->getCorreoSt($idCliente);
      // $lp = $this->Juridico_model->get_lp($idLote);
      // $correosEntregar = [];

      // if(empty($lp)){
      //    $correos = array_unique(explode(',', $datos[0]["correos"]));
      // } else {
      //    $correos = array_unique(explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com'));
      // }

      // foreach($correos as $email)
      // {
      // 	if(trim($email) != 'gustavo.mancilla@ciudadmaderas.com'){
      // 		if (trim($email) != ''){
      //            if(trim($email) == 'diego.perez@ciudadmaderas.com'){
      //                array_push($correosEntregar, 'analista.comercial@ciudadmaderas.com');
      //            } else {
      //                array_push($correosEntregar, $email);
      //            }
      // 		}
      // 	}
      // }

	$infoLote = (array)$this->Juridico_model->getNameLote($idLote);

    $encabezados = [
        'nombreResidencial' =>  'PROYECTO',
        'nombre'            =>  'CONDOMINIO',
        'nombreLote'        =>  'LOTE',
        'motivoRechazo'     =>  'MOTIVO DE RECHAZO',
        'fechaHora'         =>  'FECHA/HORA'
    ];

    $contenido[] = array_merge($infoLote, ['motivoRechazo' => $comentario, 'fechaHora' => date("Y-m-d H:i:s")]);

    $this->email
        ->initialize()
        ->from('Ciudad Maderas')
        ->to('tester.ti2@ciudadmaderas.com')
        // ->to($correosEntregar)
        ->subject('EXPEDIENTE RECHAZADO-JURÍDICO (7. ELABORACIÓN DE CONTRATO)')
        ->view($this->load->view('mail/juridico/rechazo-est3', [
            'encabezados' => $encabezados,
            'contenido' => $contenido,
            'comentario' => $comentario
        ], true));

    $validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
				if($this->email->send()){
					$data['message_email'] = 'OK';
				}else{
					$data['message_email'] = $this->email->print_debugger();
				}
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
  

  public function editar_registro_loteRevision_juridico7_Asistentes8(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=7;
    $arreglo["idMovimiento"]=77;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
	$arreglo["status8Flag"] = 0;

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=7;
    $arreglo2["idMovimiento"]=77;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;     
	

	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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

	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			redirect(base_url() . "index.php/login");
		}
	}




  public function changeUb(){

	$idLote=$this->input->post('idLote');
	$ubicacion=$this->input->post('ubicacion');

	$validate = $this->Juridico_model->update_sede($idLote, $ubicacion);

		if ($validate == TRUE){
				$data['message'] = 'OK';
				echo json_encode($data);
			}else{
				$data['message'] = 'ERROR';
				echo json_encode($data);
		}


  }
  


  public function return1_jac(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=5;
    $arreglo["idMovimiento"]=94;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");

    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=5;
    $arreglo2["idMovimiento"]=94;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;  
    $arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;     
	

	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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


  public function return2_jaa() {

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");


      $valida_tventa = $this->Asesor_model->getTipoVenta($idLote);//se valida el tipo de venta para ver si se va al nuevo status 3 (POSTVENTA)
      if($valida_tventa[0]['tipo_venta'] == 1 ){
          if($valida_tventa[0]['idStatusContratacion'] == 6 && $valida_tventa[0]['idMovimiento']==112){
              $statusContratacion = 1;
              $idMovimiento = 109;
          }
      }else{
          $statusContratacion = 1;
          $idMovimiento = 96;
      }

	$arreglo=array();
	$arreglo["idStatusContratacion"]=$statusContratacion;
	$arreglo["idMovimiento"]=$idMovimiento;
	$arreglo["comentario"]=$comentario;
	$arreglo["usuario"]=$this->session->userdata('id_usuario');
	$arreglo["perfil"]=$this->session->userdata('id_rol');
	$arreglo["modificado"]=date("Y-m-d H:i:s");		
	
	$arreglo2=array();
	$arreglo2["idStatusContratacion"]=$statusContratacion;
	$arreglo2["idMovimiento"]=$idMovimiento;
	$arreglo2["nombreLote"]=$nombreLote;
	$arreglo2["comentario"]=$comentario;
	$arreglo2["usuario"]=$this->session->userdata('id_usuario');
	$arreglo2["perfil"]=$this->session->userdata('id_rol');
	$arreglo2["modificado"]=date("Y-m-d H:i:s");
	$arreglo2["fechaVenc"]= date("Y-m-d H:i:s");
	$arreglo2["idLote"]= $idLote;  
	$arreglo2["idCondominio"]= $idCondominio;          
	$arreglo2["idCliente"]= $idCliente;          
  

	$datos= $this->Juridico_model->getCorreoSt($idCliente);

	// $lp = $this->Juridico_model->get_lp($idLote);
    // $correosEntregar = [];

	// if(empty($lp)){
	//    $correos = array_unique(explode(',', $datos[0]["correos"]));
	// } else {
	//    $correos = array_unique(explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderas.com,cobranza.mktd@ciudadmaderas.com'));
	// }

      // foreach($correos as $email)
      // {
      // 	if(trim($email) != 'gustavo.mancilla@ciudadmaderas.com'){
      // 		if (trim($email) != ''){
      //            if(trim($email) == 'diego.perez@ciudadmaderas.com'){
      //                array_push($correosEntregar, 'analista.comercial@ciudadmaderas.com');
      //            } else {
      //                array_push($correosEntregar, $email);
      //            }
      // 		}
      // 	}
      // }

	$infoLote = (array)$this->Juridico_model->getNameLote($idLote);

    $encabezados = [
      'nombreResidencial' =>  'PROYECTO',
      'nombre'            =>  'CONDOMINIO',
      'nombreLote'        =>  'LOTE',
      'motivoRechazo'     =>  'MOTIVO DE RECHAZO',
      'fechaHora'         =>  'FECHA/HORA'
    ];

    $contenido[] = array_merge($infoLote, ['motivoRechazo' => $comentario, 'fechaHora' => date("Y-m-d H:i:s")]);

    $this->email
      ->initialize()
      ->from('Ciudad Maderas')
      ->to('tester.ti2@ciudadmaderas.com')
      // ->to($correosEntregar)
      ->subject('EXPEDIENTE RECHAZADO-JURÍDICO (7. ELABORACIÓN DE CONTRATO)')
      ->view($this->load->view('mail/juridico/return1-jaa', [
          'encabezados' => $encabezados,
          'contenido' => $contenido,
          'comentario' => $comentario
      ], true));

	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
			if($this->email->send()){
				$data['message_email'] = 'OK';
			}else{
				$data['message_email'] = $this->email->print_debugger();
			}
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
  
  
  public function get_users_reassing(){
	  $data = $this->Juridico_model->get_users_reassing();
	  echo json_encode($data);
  }

  public function changeUs(){
	$iduser=$this->input->post('user');
	$idLote=$this->input->post('idlote');

	$data = $this->Juridico_model->changeUs($iduser, $idLote);
	echo json_encode($data);

  }
}
?>