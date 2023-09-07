<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reestructura extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
		$this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
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

	public function reubicarCliente(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reubicarCliente_view");
	}	

	public function getListaClientesReubicar(){
        $data = $this->Reestructura_model->getListaClientesReubicar();
        echo json_encode($data);
	}

	public function getProyectosDisponibles(){
		$data = $this->Reestructura_model->getProyectosDisponibles();
        echo json_encode($data);
	}

	public function getCondominiosDisponibles(){
        $idProyecto = $this->input->post('idProyecto');

		$data = $this->Reestructura_model->getCondominiosDisponibles($idProyecto);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

	public function getLotesDisponibles(){
		$idCondominio = $this->input->post('idCondominio');

		$data = $this->Reestructura_model->getLotesDisponibles($idCondominio);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

    function moverArchivos($idLoteAnterior, $idLoteNuevo, $idClienteAnterior, $idClienteNuevo)
    {
        $loteNuevoInfo = $this->Reestructura_model->obtenerLotePorId($idLoteNuevo);
        $docAnterior = $this->Reestructura_model->obtenerDocumentacionActiva($idLoteAnterior, $idClienteAnterior);
        $docPorReubicacion = $this->Reestructura_model->obtenerDocumentacionPorReubicacion($loteNuevoInfo->personalidad_juridica);
        $documentacion = [];
        $modificado = date('Y-m-d H:i:s');

        foreach ($docAnterior as $doc) {
            $documentacion[] = [
                'movimiento' => $doc['movimiento'],
                'expediente' => $doc['expediente'],
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['tipo_doc'],
                'estatus_validacion' => 0
            ];
        }

        foreach ($docPorReubicacion as $doc) {
            $documentacion[] = [
                'movimiento' => $doc['nombre'],
                'expediente' => NULL,
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['id_opcion'],
                'estatus_validacion' => 0
            ];
        }

        if (!file_exists("static/documentos/contratacion-reubicacion/$loteNuevoInfo->nombreLote/")) {
            $result = mkdir("static/documentos/contratacion-reubicacion/$loteNuevoInfo->nombreLote", 0777, TRUE);
            if (!$result) {
                echo 'No se pudo crear el folder';
                return;
            }
        }

        $this->General_model->insertBatch('historial_documento', $documentacion);

        echo 'Salió todo fine';
    }
}
