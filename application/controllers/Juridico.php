<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Juridico extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Juridico_model');
				$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
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
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('perfil') != 'juridico')
		{
			redirect(base_url() . 'login');
		}
	 /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
	 $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
	 /*-------------------------------------------------------------------------------*/
		$this->load->view('template/header');
		// $this->load->view('juridico/inicio_juridico_view',$datos);
		$this->load->view('template/home',$datos);
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
    $arreglo2["comentario"]=$comentario;
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

	

	$arreglo=array();
	$arreglo["idStatusContratacion"]=3;
	$arreglo["idMovimiento"]=82;
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
	$arreglo2["idStatusContratacion"]=3;
	$arreglo2["idMovimiento"]=82;
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

	$lp = $this->Juridico_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderass.com,cobranza.mktd@ciudadmaderass.com');
	   $array = array_unique($correosClean);
	}

	$infoLote = $this->Juridico_model->getNameLote($idLote);


   
	$mail = $this->phpmailer_lib->load();
	$mail->isSMTP();
	$mail->Host     = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'no-reply@ciudadmaderas.com';
	$mail->Password = 'Va7<*V8PP';
	$mail->SMTPSecure = 'ssl';
	$mail->Port     = 465;
	
	$mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
  
  foreach($array as $email)
  {
	if(trim($email)!= 'gustavo.mancilla@ciudadmaderas.com'){
		if (trim($email) != ''){ 
			$mail->addAddress($email);
		}
	}
  }

  
  
	$mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-JURÍDICO (7. ELABORACIÓN DE CONTRATO)');
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



	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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

	$arreglo=array();
	$arreglo["idStatusContratacion"]=1;
	$arreglo["idMovimiento"]=96;
	$arreglo["comentario"]=$comentario;
	$arreglo["usuario"]=$this->session->userdata('id_usuario');
	$arreglo["perfil"]=$this->session->userdata('id_rol');
	$arreglo["modificado"]=date("Y-m-d H:i:s");		
	
	$arreglo2=array();
	$arreglo2["idStatusContratacion"]=1;
	$arreglo2["idMovimiento"]=96;
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

	$lp = $this->Juridico_model->get_lp($idLote);

	if(empty($lp)){
	   $correosClean = explode(',', $datos[0]["correos"]);
	   $array = array_unique($correosClean);
	} else {
	   $correosClean = explode(',', $datos[0]["correos"].','.'ejecutivo.mktd@ciudadmaderass.com,cobranza.mktd@ciudadmaderass.com');
	   $array = array_unique($correosClean);
	}


	$infoLote = $this->Juridico_model->getNameLote($idLote);


   
	$mail = $this->phpmailer_lib->load();
	$mail->isSMTP();
	$mail->Host     = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'no-reply@ciudadmaderas.com';
	$mail->Password = 'Va7<*V8PP';
	$mail->SMTPSecure = 'ssl';
	$mail->Port     = 465;
	
	$mail->setFrom('no-reply@ciudadmaderas.com', 'Ciudad Maderas');
  
  foreach($array as $email)
  {
	if(trim($email)!= 'gustavo.mancilla@ciudadmaderas.com'){
		if (trim($email) != ''){ 
			$mail->addAddress($email);
		}
	}
  }

  
  
	$mail->Subject = utf8_decode('EXPEDIENTE RECHAZADO-JURÍDICO (7. ELABORACIÓN DE CONTRATO)');
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


	$validate = $this->Juridico_model->validateSt7($idLote);

	if($validate == 1){
		if ($this->Juridico_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
