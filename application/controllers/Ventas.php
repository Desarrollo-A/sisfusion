<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ventas extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Ventas_modelo', 'Statistics_model', 'asesor/Asesor_model'));
        $this->load->library(array('get_menu', 'Jwt_actions','permisos_sidebar'));
		$this->load->helper(array('url','form'));
        $this->jwt_actions->authorize('3515', $_SERVER['HTTP_HOST']);
		$this->load->database('default');
        $this->validateSession();
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
        
	}

    public function validateSession() {
        if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

	public function index() {
                $this->load->view('template/header');
                $this->load->view("template/home");
                $this->load->view('template/footer');
	}

    
    public function gestorOficinas(){
        $this->load->view('template/header');
        $this->load->view("ventasAsistentes/gestorOficinas_view");
    }

    public function editDireccionOficce(){
        if (isset($_POST) && !empty($_POST)) {
            $idDireccion = $this->input->post("idDireccion");
            $direccionOffice = $this->input->post("direccionOffice");

            $data = $this->Ventas_modelo->editDireccionOficce($idDireccion, $direccionOffice);
            if($data == true)
                echo json_encode(1);
            else
                echo json_encode(0);
        }else{
            echo json_encode(array());
        }
    }

    public function addDireccionOficce(){
        if (isset($_POST) && !empty($_POST)) {
            $direccion = $this->input->post("newOffice");
            $idSede = $this->input->post("idSede");
            $inicio = (int)$this->input->post("inicio");
            $fin = (int)$this->input->post("fin");
            $data = $this->Ventas_modelo->addDireccionOficce($direccion, $idSede, $inicio, $fin);
            
            if($data == true)
                echo json_encode(1);
            else
                echo json_encode(0);
        }else{
            echo json_encode(array());
        }
    }

    public function statusOffice(){
        if (isset($_POST) && !empty($_POST)) {
            $direccion = $this->input->post("idDireccionS");
            $status = $this->input->post("status");
            $data = $this->Ventas_modelo->statusOffice($direccion, $status);
            
            if($data == true)
                echo json_encode(1);
            else
                echo json_encode(0);
        }else{
            echo json_encode(array());
        }
    }
}
