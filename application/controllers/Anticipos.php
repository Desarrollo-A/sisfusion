<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Anticipos extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Anticipos_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email', 'Jwt_actions', 'Formatter','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->jwt_actions->authorize('9717','2807', $_SERVER['HTTP_HOST']);
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index(){
        redirect(base_url());
    }


    public function anticipos_historial(){

            $this->load->view('template/header');
            $this->load->view("anticipos/anticipos_historial_view");
    
        }

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function historial_Anticipo(){
        switch($this->session->userdata('id_rol')){
        case '31':
          $this->load->view('template/header');
          $this->load->view("anticipos/anticipos_internomex_view");
        break;
    
        default:
          $this->load->view('template/header');
          $this->load->view("anticipos/anticipos_view");
        break;
        }
    }

    public function getAnticipos(){

        $data = $this->Anticipos_model->getAnticipos()->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }    

    public function actualizarEstatus() {

        $comentario = $this->input->post('comentario');
        $id_usuario = $this->input->post('id_usuario');
        $id_anticipo = $this->input->post('id_anticipo');
        $procesoAnt = $this->input->post('procesoAnt');
        $monto = $this->input->post('monto');
        $numeroPagos = $this->input->post('numeroPagos');
        $procesoTipo = $this->input->post('procesoTipo');
        $pago = $this->input->post('pago');
        $montoP = $this->input->post('montoPrestadoParcialidad');
        $montoPEntero = intval($montoP);

        $creado_por = $this->session->userdata("id_rol");

        if($procesoAnt == 7){

            
        }


        $result_2 = null;
        $result_3 = null;
        $success = false;
    
        $result_5 = null;
        $result_6 = null;

        //parcialidades
        $nombreSwitch = $this->input->post('nombreSwitch');
        $catalogo = $this->input->post('tipo_pago_anticipo');
        $numeroPagosParcialidad = $this->input->post('numeroPagosParcialidad');
    
        // Internomexx
        if ($this->session->userdata('id_rol') == 31) {

            $comentario = "Se acepta el pago, por parte de internomex";
            $procesoAntInternomex = $this->input->post('procesoAntInternomex');
            $procesoAntInternomexFinal = $this->input->post('procesoAntInternomexFinal');

            $numero_mensualidades = $this->input->post('numero_mensualidades');
            // $mP = intval($numero_mensualidades);

            if (empty($procesoAntInternomex) && !empty($procesoAntInternomexFinal)) {
                $result_2 = $this->Anticipos_model->updateHistorial($id_anticipo, $id_usuario, $comentario, $procesoAntInternomexFinal);
            } elseif (!empty($procesoAntInternomex) && empty($procesoAntInternomexFinal)) {
                $result_2 = $this->Anticipos_model->updateHistorial($id_anticipo, $id_usuario, $comentario, $procesoAntInternomex);
            }

            $mP=$numero_mensualidades;
            
            if ($mP == "null") {
                $mP = "null";
            }else {
                $mP = (int)$mP;
            }
            
            if ($mP == "0") {

                $result = $this->Anticipos_model->updateMensualidad0($id_anticipo);

            }else {
            

                if ($procesoAntInternomex == "1") {

                    if ($mP == "null") {

                        $res = null;
                        $result = $this->Anticipos_model->updateMontoTotal($id_anticipo, $res, $procesoAntInternomex);
                    } else {
                        
                        $res = ($mP - 1);
                        $result = $this->Anticipos_model->updateMontoTotal($id_anticipo, $res, $procesoAntInternomex);
                    }
                } else {
                    $result = $this->Anticipos_model->updateMontoTotal($id_anticipo, $mP, $procesoAntInternomex);
                }
            }
            

            $success = ($result != null); 
            
        } else {

            $result = $this->Anticipos_model->updateEstatusD($procesoAnt, $id_anticipo);
            $result_3 = 1;
            $result_2 = $this->Anticipos_model->updateHistorial($id_anticipo, $id_usuario, $comentario, $procesoAnt);
    
            if($procesoAnt == 0){
                
            } else {

                
                if ($procesoTipo == 0 ) {

                    $result_3 = $this->Anticipos_model->relacion_anticipo_prestamo($id_anticipo, $procesoTipo);

                } else {
                    $result_3 = $this->Anticipos_model->autPrestamoAnticipo($id_usuario, $monto, $numeroPagos, $pago, $comentario, $pago, $creado_por, $procesoTipo);
                    $result_4 = $this->Anticipos_model->relacion_anticipo_prestamo($id_anticipo, $procesoTipo);

                }
            }
            
            $success = ($result != null && $result_2 != null && $result_3 != null);
        }
    
        $response = array(
            'success' => $success,
            'result' => $result,
            'result_2' => $result_2,
            'result_3' => $result_3,
            'result_5' => $result_5,
            'result_6' => $result_6
        );
    
        echo json_encode($response);
    }


    public function regresoInternomex() {
        $id_usuario = $this->input->post('id_usuario');
        $id_anticipo = $this->input->post('id_anticipo');
        $procesoParcialidad = intval($this->input->post('procesoParcialidad'));
    
        if ($procesoParcialidad == 1) {
            $result = $this->Anticipos_model->regresoInternomex($id_anticipo, $id_usuario, $procesoParcialidad);
        } else {
            $result = $this->Anticipos_model->regresoInternomex($id_anticipo, $id_usuario, $procesoParcialidad);
        }
    
        echo json_encode(['result' => $result]);
    }
    


    public function datosCatalogos(){

        echo json_encode($this->Anticipos_model->datosCatalogos());
        
    }

    public function addEmpresa(){
        $id_anticipo = $this->input->post('id_anticipo');
        $id_usuario = $this->input->post('id_usuario');
        $empresa     = $this->input->post('empresaParcia');
        
        // $response = array(
        //     'id_anticipo' => $id_anticipo,
        //     'empresa' => $empresa
        // );
        $Anticipo_Respuesta   =  $this->Anticipos_model->addEmpresa($id_anticipo,$empresa);
        if($Anticipo_Respuesta){
            $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "Se agregó la empresa");
        } else{
            $respuesta =  array(
            "response_code" => 411, 
            "response_type" => 'error',
            "message" => "Error en insertar en empresa, inténtalo más tarde ");
        }
        echo json_encode($respuesta);
        
    }

    public function fillAnticipos() {
        echo json_encode($this->Anticipos_model->getTipoAnticipo()->result_array());
    }
    
}