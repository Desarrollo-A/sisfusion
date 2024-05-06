<?php ini_set('display_errors', 1);
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Liberaciones extends CI_Controller{
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model', 'caja_model_outside', 'Contraloria_model', 'Clientes_model', 'Liberaciones_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'permisos_sidebar', 'Formatter'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
		//$this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		//$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        //$this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
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

    public function seguimiento(){
        $this->load->view('template/header');
        $this->load->view("liberaciones/seguimiento_view");
    }

    /* QUERIES */
    
    public function getLotesParaLiberacion(){
        $data = $this->Liberaciones_model->getLotesParaLiberacion();

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function obtenerDocumentacionPorLiberacion(){
        $catalogo = $this->input->post('catalogo');

        $data = $this->Liberaciones_model->obtenerDocumentacionPorLiberacion($catalogo);
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function iniciaLiberacionLote(){
        // Datos a insertar en
        $data = array(
            'idLote' => $this->input->post('idLote'),
            'id_cliente' => $this->input->post('id_cliente'),
            'rescision' => $this->input->post('rescision'),
            'autorizacion_DG' => $this->input->post('autorizacion_DG'),
            'proceso_lib' => $this->input->post('proceso_lib'), // Con que area se encuentra, 1 postventa, 2 contraloria, y asi
            'estatus_lib' => $this->input->post('estatus_lib'), // 1 avance, 2 rechazo, 3 correccion
            'concepto' => $this->input->post('concepto'), // 1 particulaes, 2 bloqueo, 3 etc..
            'comentario' => $this->input->post('comentario'),
            'comentario' => $this->input->post('comentario'),
            'estatus' => 1,
            'creado_por' => $this->session->userdata('id_usuario'),
            'fecha_creacion' => date('Y-m-d h:i:s'),
            'modificado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d h:i:s'),
        );

        $result = $this->General_model->addRecord('proceso_liberaciones', $data);
        if ($result){
            echo json_encode(array("status" => 200, "error" => "El registro se ha ingresado de manera exitosa."), JSON_UNESCAPED_UNICODE);
        }else {
            echo json_encode(array("status" => 400, "error" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
        }
    }

    function generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente, $archivo){
        //esta funcion genera un nombre apartir de los parametros de nombreResidencial, $nombreCondominio,
        //nombreLote y $idCliente quedando como el sig. ejemplo: CMMSLP_MON01_22122020_38479_508.pdf
        $aleatorio = rand(100,1000);
        $proyecto = str_replace(' ', '', $nombreResidencial);
        $condominio = str_replace(' ', '', $nombreCondominio);
        $condom = substr($condominio, 0, 3);
        $cond= strtoupper($condom);
        $numeroLote = preg_replace('/[^0-9]/','', $nombreLote);
        $date= date('dmY');
        $composicion = $proyecto."_".$cond.$numeroLote."_".$date;
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        $expediente=  $composicion.'_'.$idCliente.'_'.$aleatorio.'.'.$extension;
        return $expediente;
    }
}
