<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contratacion extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contratacion_model');
        $this->load->model('registrolote_modelo');
         $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }


	public function index()
    {
        if ($this->session->userdata('id_rol') == false || $this->session->userdata('id_rol') != '16') {
            redirect(base_url() . 'login');
        }
        $this->load->view('template/header');
        $this->load->view('template/home');
        $this->load->view('template/footer');
    }

    public function lista_proyecto() {
    	$this->validateSession();
        echo json_encode($this->Contratacion_model->get_proyecto_lista()->result_array());
    }

    public function lista_condominio($proyecto) {
    	$this->validateSession();
        echo json_encode($this->Contratacion_model->get_condominio_lista($proyecto)->result_array());
    }

    public function lista_lotes($condominio){
      echo json_encode($this->Contratacion_model->get_lote_lista($condominio)->result_array());
    }

    public function lista_estatus() {
    	$this->validateSession();
        echo json_encode($this->Contratacion_model->get_estatus_lote()->result_array());
    }

    public function get_inventario($estatus, $condominio, $proyecto) {
        ini_set('max_execution_time', 900);
        set_time_limit(900);
        ini_set('memory_limit','2048M');
		$this->validateSession();
		$data = $this->Contratacion_model->getInventarioData($estatus, $condominio, $proyecto);
		if($data!=null)
            print_r(json_encode($data));
        else
		    print_r(json_encode(array()));
		exit;
    }

    public function obtener_liberacion($idLote)
    {
    	$this->validateSession();
        echo json_encode($this->Contratacion_model->get_datos_historial($idLote)->result_array());
    }

    public function historialProcesoLoteOp($idLote)
    {
        $response= $this->registrolote_modelo->historialProcesoFin($idLote);
       // echo json_encode($response);
        if($response != null) {
            echo json_encode($response);
        } else {
            echo json_encode(array());
        }
    }

    public function expedientesIngresados()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view('contratacion/expedientesIngresados');
	}
	public function corridasElaboradas()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view('contratacion/corridasElaboradas');
	}
	public function inventario()
	{
		$datos = array();
		$datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->Asesor_model->get_proyecto_lista();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}

	public function getCorridasElaboradas()
	{
		$this->validateSession();
		$datos = array(
			'idStatusContratacion' => 6,
			'idMovimiento' => 36
		);

		$data=array();
		$data = $this->Contratacion_model->get_expedientesIngresados($datos);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getExpedientesIngresados()
	{

		$datos = array(
			'idStatusContratacion' => 2,
			'idMovimiento' => 84
		);

		$data=array();
		$data = $this->Contratacion_model->get_expedientesIngresados($datos);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
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

    public function getCoSallingAdvisers($idLote=null) {
        $idLote = is_null($idLote) ? $this->input->post("idLote") : $idLote;
        // ME TRAIGO EL ID DEL CLIENTEE
        $data = $this->Contratacion_model->getClient($idLote)->result_array();
        // EVALUO QUE EL ID DEL CLIENTE NO SEA 0 O NULO, EN ESE CASO YA NO VOY BUSCO EN VENTAS COMPARTIDAS
        if (!empty($data) && $data[0]['idCliente'] != NULL && $data[0]['idCliente'] != 0)
            $finalAnswer = $this->Contratacion_model->getCoSallingAdvisers($data[0]['idCliente']);
        else // BUSCO VENTAS COMPARTIDAS ACTIVAS
            $finalAnswer = array();
        
        if ($finalAnswer != null)
            echo json_encode($finalAnswer);
        else 
            echo json_encode(array());
    }

    public function getClauses($idLote) {
        echo json_encode($this->Contratacion_model->getClauses($idLote)->result_array());
    }

    public function getInventoryByLote($idLote)
    {
        $this->validateSession();
        echo json_encode($this->Contratacion_model->getInventoryBylote($idLote)->result_array());
    }

    public function completeInventory ()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contraloria/completeInventory");
	}

    public function getCatalogosParaUltimoEstatus() {
    	$this->validateSession();
        echo json_encode($this->Contratacion_model->getCatalogosParaUltimoEstatus()->result_array());
    }

    public function downloadCompleteInventory () {
        if (isset($_POST) && !empty($_POST)) {
            $data['data'] = $this->Contratacion_model->getCompleteInventory($this->input->post("id_sede"))->result_array();
            echo json_encode($data);
        } else
            echo json_encode(array());
    }
    
    public function sedesPorDesarrollos() {
        $this->validateSession();
        echo json_encode($this->Contratacion_model->getSedesPorDesarrollos()->result_array());
    }
    
}
