<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Direcciones extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Direcciones_model'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();

        $val = $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession() {
        if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view("template/home");
        $this->load->view('template/footer');
    }

    public function direccionesInfo(){
        $this->load->view('template/header');
        $this->load->view("Direcciones/Direcciones_view");
    } 

    public function getOnlyEstados()
    {
        $data = $this->Direcciones_model->getEstadoInfo()->result_array();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }      
    }

    public function getOnlyHoraInicial()
    {
        $data = $this->Direcciones_model->getTimeInfo()->result_array();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }      
    }

    public function getOnlyHoraFinal()
    {
        $data = $this->Direcciones_model->getLastTimeInfo()->result_array();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }      
    }

    public function AddEditDireccion(){
		
        $dataPost = $_POST;

		if(!empty($dataPost["id_direccionM"])){

            $update = $this->Direcciones_model->editarDireccion($dataPost);
            if ($update == TRUE) {
                $response['message'] = 'SUCCESS';
                echo json_encode(1);
            } else {
                $response['message'] = 'ERROR';
                echo json_encode(0);
            }
    
        }else{
            $insert = $this->Direcciones_model->insertarCampo($dataPost);
            if ($insert == TRUE) {
                $response['message'] = 'SUCCESS';
                echo json_encode(1);
            } else {
                $response['message'] = 'ERROR';
                echo json_encode(0);
            }
        } 
	}
    
    public function getDireccionesAll()
    {
        $data = $this->Direcciones_model->getDirecciones()->result_array();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }      
    }

    public function borrarOpcion(){

		$dataPost = $_POST;
		$datos["id_direccion"] = $dataPost['id_direccion']; 
        $datos["estatus_n"] = $dataPost['estatus_n'];
		$update = $this->Direcciones_model->borrarDirecciones($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		}
	}

    


}