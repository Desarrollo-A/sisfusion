<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Caja extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model(array('Caja_model', 'General_model'));
		$this->load->library(array('session','form_validation', 'Jwt_actions', 'permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		$this->jwt_actions->authorize('0739', $_SERVER['HTTP_HOST']);
		$this->validateSession();
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

	public function index() {
		if($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '12')
			redirect(base_url().'login');
		$this->load->view('template/header');
		$this->load->view('template/home');
		$this->load->view('template/footer');
	}

	public function validateSession() {
		if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
			redirect(base_url() . "index.php/login");
	}

	public function reporteLotesBloqueado(){
		$this->load->view('template/header');
		$this->load->view("caja/reporteLotesBloqueados_view");
	}

	public function getReporteLotesBloqueados() {
        $data = $this->Caja_model->getReporteLotesBloqueados();
        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

	public function clausulasLotesParticulares(){
		$this->load->view('template/header');
		$this->load->view("caja/clausulasLotesParticulares_view");
	}

	public function getLotesParticulares() {
        $data = $this->Caja_model->getLotesParticulares();
        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

	public function addEditClausulas() {
        $id_clausula = $this->input->post('id_clausula');
        $idLote = $this->input->post('idLote');
        $clausulas = $this->input->post('clausulas');
		if ($id_clausula != 0) {
			$dataToUpdate = array('estatus'=> 0, "fecha_modificacion" => date("Y-m-d H:i:s"), "modificado_por" => $this->session->userdata('id_usuario'));
			$responseUpdate = $this->General_model->updateRecord("clausulas", $dataToUpdate, "id_clausula", $id_clausula); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
		}
		$dataToInsert = array(
			'id_lote'=> $idLote,
			'nombre'=> $clausulas,
			'estatus'=> 1,
			"fecha_creacion" => date("Y-m-d H:i:s"),
			"creado_por" => $this->session->userdata('id_usuario'),
			"fecha_modificacion" => date("Y-m-d H:i:s"), 
			"modificado_por" => $this->session->userdata('id_usuario')
		);        
		$responseInsert = $this->General_model->addRecord("clausulas", $dataToInsert); // MJ: LLEVA 2 PARÁMETROS $table, $data
        if ($responseInsert == TRUE)
			echo json_encode(array("status" => 1, "message" => "Registro guardado con éxito."), JSON_UNESCAPED_UNICODE);
		else
			echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
    }

	public function EditVentaParticular(){

		$tipo_venta = $this->input->post('tipo_venta');
        $id_usuario = $this->session->userdata('id_usuario');
        $idLote=$this->input->post('idLote');

		$dataToUpdate = array("tipo_venta"=> $tipo_venta, "usuario" => $this->session->userdata('id_usuario'));
        $responseUpdate = $this->General_model->updateRecord("lotes", $dataToUpdate, "idLote", $idLote);

		$dataToUpdate2 = array('estatus'=> 0);
        $responseUpdate2 = $this->General_model->updateRecord("clausulas", $dataToUpdate2, "id_lote", $idLote);

            $data['message'] = 'OK';
            echo json_encode($data);
	}
}
