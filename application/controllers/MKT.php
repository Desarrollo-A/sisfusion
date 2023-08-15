<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MKT extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if( !$this->session->userdata("id_usuario") )
			redirect("Login", "refresh");
		else
			// $this->load->model('Model_Estadisticas');
		$this->load->model(array('Ventas_modelo', 'Statistics_model', 'registrolote_modelo', 'asesor/Asesor_model', 'Model_Estadisticas'));
				$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
				  //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
				  $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

	public function index(){
		if($this->session->userdata("id_rol")== '18' || $this->session->userdata("id_rol")== '28'){
			$datos['tprospectos'] = $this->Statistics_model->getProspectsNumber()->result();
			$datos['pvigentes'] = $this->Statistics_model->getCurrentProspectsNumber()->result();
			$datos['pnovigentes'] = $this->Statistics_model->getNonCurrentProspectsNumber()->result();
			$datos['tclientes'] = $this->Statistics_model->getClientsNumber()->result();
			$datos['monthlyProspects'] = $this->Statistics_model->getMonthlyProspects()->result();
			$datos['dataSlp'] = $this->Statistics_model->getDataPerSede(1)->result();
			$datos['dataQro'] = $this->Statistics_model->getDataPerSede(2)->result();
			$datos['dataPen'] = $this->Statistics_model->getDataPerSede(3)->result();
			$datos['dataCdmx'] = $this->Statistics_model->getDataPerSede(4)->result();
			$datos['dataLeo'] = $this->Statistics_model->getDataPerSede(5)->result();
			$datos['dataCan'] = $this->Statistics_model->getDataPerSede(6)->result();
			$this->load->view('template/header');;
			$this->load->view("clientes/vista_estadisticas_mkt", $datos);
		} else if($this->session->userdata("inicio_sesion")["id_rol"] == '12'){
			$this->load->view("v_Clientes_SM");
		}

	}

	public function get_lugares(){
		$lugares = $this->Model_Estadisticas->get_mkt_dig();

		$json_entregar = array();
		if($lugares->num_rows() > 0){
			foreach($lugares->result() as $row_lugares){
				$json_entregar[] = array("id_lugares" => $row_lugares->otro_lugar, "nombre_lugares" => $row_lugares->lugares);
			}
		}

		echo json_encode($json_entregar);
	}

	public function get_sedes(){
		$sedes = $this->Model_Estadisticas->get_sedes();

		$json_entregar = array();
		if($sedes->num_rows() > 0){
			foreach($sedes->result() as $row_sedes){
				$json_entregar[] = array("id_sedes" => $row_sedes->id_sede, "nombre_sedes" => $row_sedes->sede);
			}
		}

		echo json_encode($json_entregar);
	}

	public function get_total_mkt(){
		$clientes = $this->Model_Estadisticas->get_total_mkt()->result();
		echo json_encode($clientes);
	}

	public function get_asesores(){
		$request = json_decode(file_get_contents("php://input"));
		$sede = $request->sede;
		$asesores = $this->Model_Estadisticas->get_asesores_sede($sede)->result();
		echo json_encode($asesores);
	}

	public function get_chart_complete(){
		$request = json_decode(file_get_contents("php://input"));
		$lugar = $request->lugar;
		$sede = $request->sede;
		$asesor = $request->asesor;
		$fecha_ini = date("Y/m/d",strtotime($request->fecha_ini));
		$fecha_fin = date("Y/m/d",strtotime($request->fecha_fin));
		if($lugar == "Todos"){
			$clientes = $this->Model_Estadisticas->get_chartmkt3($asesor, $sede, $fecha_ini, $fecha_fin)->result();
		}
		else{
			$clientes = $this->Model_Estadisticas->get_chartmkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin)->result();
		}

		echo json_encode($clientes);
	}

	public function get_chart_mkt(){
		$request = json_decode(file_get_contents("php://input"));
		$lugar = $request->lugar;
		$sede = $request->sede;
		$fecha_ini = date("Y/m/d",strtotime($request->fecha_ini));
		$fecha_fin = date("Y/m/d",strtotime($request->fecha_fin));
		if($sede == "Todas"){
			if($lugar == "Todos"){ //sede y lugar = todos
				$clientes = $this->Model_Estadisticas->get_chartmkt5($fecha_ini, $fecha_fin)->result();
			}
			else{ //sede = todos, lugar prosp. específico
				$clientes = $this->Model_Estadisticas->get_chartmkt4($lugar, $fecha_ini, $fecha_fin)->result();
			}
		}
		else{
			if($lugar != "Todos"){ // sede y lugar de prospección específico
				$clientes = $this->Model_Estadisticas->get_chartmkt1($sede, $lugar, $fecha_ini, $fecha_fin)->result();
			}
			else{ //sede especifica, lugar prosp. todos
				$clientes = $this->Model_Estadisticas->get_chartmkt6($sede, $fecha_ini, $fecha_fin)->result();
			}
		}

		echo json_encode($clientes);
	}

	public function get_report_complete(){
		$request = json_decode(file_get_contents("php://input"));
		$lugar = $request->lugar;
		$sede = $request->sede;
		$asesor = $request->asesor;
		$fecha_ini = date("Y/m/d",strtotime($request->fecha_ini));
		$fecha_fin = date("Y/m/d",strtotime($request->fecha_fin));
		if($lugar == "Todos"){ //lugar todos, sede especifica y asesor especifico
			$clientes = $this->Model_Estadisticas->get_repomkt3($asesor, $sede, $fecha_ini, $fecha_fin)->result();
		}
		else{
			$clientes = $this->Model_Estadisticas->get_repomkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin)->result();
		}

		echo json_encode($clientes);
	}

	public function get_report_mkt(){
		$request = json_decode(file_get_contents("php://input"));
		$lugar = $request->lugar;
		$sede = $request->sede;
		$fecha_ini = date("Y/m/d",strtotime($request->fecha_ini));
		$fecha_fin = date("Y/m/d",strtotime($request->fecha_fin));
		if($sede == "Todas"){
			if($lugar == "Todos"){ //sede y lugar = todos
				$clientes = $this->Model_Estadisticas->get_repomkt5($fecha_ini, $fecha_fin)->result();
			}
			else{ //sede = todos, lugar prosp. específico
				$clientes = $this->Model_Estadisticas->get_repomkt4($lugar, $fecha_ini, $fecha_fin)->result();
			}
		}
		else{
			if($lugar != "Todos"){ // sede y lugar de prospección específico
				$clientes = $this->Model_Estadisticas->get_repomkt1($sede, $lugar, $fecha_ini, $fecha_fin)->result();
			}
			else{ //sede especifica, lugar prosp. todos PENDIENTE
				$clientes = $this->Model_Estadisticas->get_repomkt6($sede, $fecha_ini, $fecha_fin)->result();
			}
		}

		echo json_encode($clientes);
	}

	public function inventario()
	{
		ini_set('max_execution_time', 900);
		set_time_limit(900);
		ini_set('memory_limit','2048M');
		$datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->Asesor_model->get_proyecto_lista();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}



	public function documentsByLote()
	{
        $datos = [
            'residencial' => $this->registrolote_modelo->getResidencialQro(),
            'tieneAcciones' => 0,
            'tipoFiltro' => 2
        ];
        $this->load->view('template/header');
        $this->load->view("documentacion/documentacion_view", $datos);
	}


}
