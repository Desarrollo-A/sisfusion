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

    public function particulares(){
        $this->load->view('template/header');
        $this->load->view("liberaciones/particulares_view");
    }

    public function rescision(){
        $this->load->view('template/header');
        $this->load->view("liberaciones/rescision_view");
    }

    public function bloqueados(){
        $this->load->view('template/header');
        $this->load->view("liberaciones/bloqueo_view");
    }

    public function sinContrato(){
        $this->load->view('template/header');
        $this->load->view("liberaciones/sin_contrato_view");
    }

    /* QUERIES */
    public function lista_proyectos() {
        echo json_encode($this->Liberaciones_model->lista_proyectos()->result_array());
    }

    public function lista_condominios($proyecto) {
        echo json_encode($this->Liberaciones_model->lista_condominios($proyecto)->result_array());
    }

    public function lista_lotes($condominio, $tipoVenta) {
        $data = $this->Liberaciones_model->lista_lotes($condominio, $tipoVenta)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
    
    // Solo para los que inician proceso de liberacion.
    public function getLotesParaLiberacion(){
        $tipoVenta = $this->input->post('tipoVenta');
        $lotes = $this->input->post('lotes');
        $idProcesoTipoLiberacion = $this->input->post('idProcesoTipoLiberacion');

        $filtroLotes = '';
        if (isset($lotes)) $filtroLotes = "AND lo.idLote IN (".$lotes.")";
 
        $condicion = '';
        if ($idProcesoTipoLiberacion == 133) { // Filtro de acuerdo al concepto de liberación: En este caso Particulares.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IS NULL)" .$filtroLotes; // POSTVENTA
        }
        if ($idProcesoTipoLiberacion == 134) { // Filtro de acuerdo al concepto de liberación: En este caso Rescisión.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IS NULL)" .$filtroLotes; // POSTVENTA
        }
        $data = $this->Liberaciones_model->getLotesParaLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion);

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    // Obtener los lotes en el proceso de liberación de su area del usuario para avanzarlo o rechazarlo.
    public function getLotesPendientesLiberacion(){
        $tipoVenta = $this->input->post('tipoVenta');
        $idProcesoTipoLiberacion = $this->input->post('idProcesoTipoLiberacion');
 
        $condicion = '';
        if ($idProcesoTipoLiberacion == 133) { // Filtro de acuerdo al concepto de liberación: En este caso Particulares.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IN (1, 3))"; // POSTVENTA
            if ($this->session->userdata('id_rol') == 17) $condicion = "AND (pl.proceso_lib = (2))"; // CONTRALORÍA
            if ($this->session->userdata('id_rol') == 12) $condicion = "AND (pl.proceso_lib = (4))"; // CAJAS
        }
        if ($idProcesoTipoLiberacion == 134) { // Filtro de acuerdo al concepto de liberación: En este caso Rescisión.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IN (1))"; // POSTVENTA
            if ($this->session->userdata('id_rol') == 17) $condicion = "AND (pl.proceso_lib = (2))"; // CONTRALORÍA
            if ($this->session->userdata('id_rol') == 11) $condicion = "AND (pl.proceso_lib = (3))"; // ADMINISTRACIÓN
            // if ($this->session->userdata('id_rol') == 2)  $condicion = "AND (pl.proceso_lib = (4))"; // VENTAS SUBDIRECTOR
            if ($this->session->userdata('id_rol') == 2)  $condicion = "AND (pl.proceso_lib = (4)) AND re.sede_residencial IN (".$this->session->userdata('id_sede').")"; // VENTAS SUBDIRECTOR
            if ($this->session->userdata('id_rol') == 12) $condicion = "AND (pl.proceso_lib = (5))"; // CAJAS
        }
        $data = $this->Liberaciones_model->getLotesPendientesLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion);

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    // Consultar los lotes que no estan en su proceso pero estan en un proceso de liberación con otra area.
    public function getLotesEnProcesoLiberacion(){
        $tipoVenta = $this->input->post('tipoVenta');
        $idProcesoTipoLiberacion = $this->input->post('idProcesoTipoLiberacion');
 
        $condicion = '';
        if ($idProcesoTipoLiberacion == 133) { // Filtro de acuerdo al concepto de liberación: En este caso Particulares.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib NOT IN (1, 3))"; // POSTVENTA
            if ($this->session->userdata('id_rol') == 17) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (2))"; // CONTRALORÍA
            if ($this->session->userdata('id_rol') == 12) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (4))"; // CAJAS
        }
        if ($idProcesoTipoLiberacion == 134) { // Filtro de acuerdo al concepto de liberación: En este caso Rescisión.
            if ($this->session->userdata('id_rol') == 55) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib NOT IN (1))"; // POSTVENTA
            if ($this->session->userdata('id_rol') == 17) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (2))"; // CONTRALORÍA
            if ($this->session->userdata('id_rol') == 11) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (3))"; // ADMINISTRACIÓN
            // if ($this->session->userdata('id_rol') == 2)  $condicion = "AND (pl.proceso_lib = (4))"; // VENTAS SUBDIRECTOR
            if ($this->session->userdata('id_rol') == 2)  $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (4)) AND re.sede_residencial IN (".$this->session->userdata('id_sede').")"; // VENTAS SUBDIRECTOR
            if ($this->session->userdata('id_rol') == 12) $condicion = "AND (pl.proceso_lib IS NOT NULL AND pl.proceso_lib <> (5))"; // CAJAS
        }
        $data = $this->Liberaciones_model->getLotesEnProcesoLiberacion($idProcesoTipoLiberacion, $tipoVenta, $condicion);

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }
    
    public function obtenerDocumentacionPorLiberacion(){
        $catalogo = $this->input->post('catalogo');

        $data = $this->Liberaciones_model->obtenerDocumentacionPorLiberacion($catalogo);
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function actualizaLiberacionLote(){
        // Datos que se necesitan
        $idLote           = $this->input->post('idLote');
        $id_cliente       = $this->input->post('id_cliente');
        $rescision        = $this->input->post('rescision');
        $autorizacion_DG  = $this->input->post('autorizacion_DG');
        $proceso_lib      = $this->input->post('proceso_lib');
        $estatus_lib      = $this->input->post('estatus_lib');
        $concepto         = $this->input->post('concepto');
        $comentario       = $this->input->post('comentario');
        $precioLiberacion = $this->input->post('precioLiberacion');
        $plazo            = $this->input->post('plazo');


        // Datos a insertar en proce
        $data = array(
            'idLote'             => $idLote,
            'id_cliente'         => $id_cliente,
            'rescision'          => $rescision,
            'autorizacion_DG'    => $autorizacion_DG,
            'proceso_lib'        => $proceso_lib, // Con que area se encuentra, 1 postventa, 2 contraloria, y asi
            'estatus_lib'        => $estatus_lib, // 1 avance, 2 rechazo, 3 correccion
            'concepto'           => $concepto,    // 1 particulaes, 2 bloqueo, 3 etc..
            'comentario'         => $comentario,
            'precioLiberacion'   => $precioLiberacion,
            'plazo'              => $plazo,
            'estatus'            => 1,
            'creado_por'         => $this->session->userdata('id_usuario'),
            'fecha_creacion'     => date('Y-m-d h:i:s'),
            'modificado_por'     => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d h:i:s'),
        );

        $result = $this->General_model->addRecord('proceso_liberaciones', $data);
        if ($result){
            echo json_encode(array("code" => 200, "msg" => "El proceso de liberación se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
        }else {
            echo json_encode(array("code" => 500, "msg" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
        }
    }

    public function registrarDocumentoEnArbol(){
        $movimiento     = $this->input->post('movimiento');
        $expediente    = $this->input->post('expediente');
        $idCliente      = $this->input->post('idCliente');
        $idCondominio   = $this->input->post('idCondominio');
        $idLote         = $this->input->post('idLote');
        $tipo_doc       = $this->input->post('tipo_doc');

        
        $dataII = array(
            'movimiento'         => $movimiento,
            'expediente'         => $expediente,
            'modificado'         => date('Y-m-d h:i:s'),
            'status'             => 1,
            'idCliente'          => $idCliente, // Con que area se encuentra, 1 postventa, 2 contraloria, y asi
            'idCondominio'       => $idCondominio, // 1 avance, 2 rechazo, 3 correccion
            'idLote'             => $idLote,    // 1 particulaes, 2 bloqueo, 3 etc..
            'idUser'             => $this->session->userdata('id_usuario'),
            'tipo_documento'     => 0,
            'id_autorizacion'    => 0,
            'tipo_doc'           => $tipo_doc,
            'estatus_validacion' => 0,
            'bucket'             => 1,
        );

        $result = $this->General_model->addRecord('historial_documento', $dataII);
        $lastId = $this->db->insert_id();
        
        if ($result){
            echo json_encode(array("code" => 200, "msg" => "El registro se ha ingresado de manera exitosa.", "documentId" => $lastId), JSON_UNESCAPED_UNICODE);
        }else {
            echo json_encode(array("code" => 500, "msg" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
        }
    }

    public function historialLiberacionLote(){
        if (isset($_POST) && !empty($_POST)) {
            $idLote = $_POST['idLote'];
            $tipoVenta = $_POST['tipoVenta'];
            $idProcesoTipoLiberacion = $_POST['idProcesoTipoLiberacion'];

            $response = $this->Liberaciones_model->historialLiberacionLote($idProcesoTipoLiberacion, $tipoVenta, $idLote)->result_array();
            echo json_encode($response);
        } else {
            echo json_encode(array());
        }
    }
}
