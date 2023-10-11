<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Resguardos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Resguardos_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions', 'phpmailer_lib','permisos_sidebar'));
    $this->load->database('default');
    $this->jwt_actions->authorize('6512', $_SERVER['HTTP_HOST']);
    $this->validateSession();

    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
  }

  public function index(){
    redirect(base_url());
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function retiros() {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("resguardos/retiros-view");
      }

  public function getRetiros($user,$opc)
  {
    $data["data"] = $this->Resguardos_model->getRetiros($user,$opc)->result_array();
    echo json_encode($data);
  }

  public function getListaRetiros($id)
  {
      echo json_encode($this->Resguardos_model->getListaRetiros($id)->result_array());
  }

  public function actualizarRetiro(){
  
    $opcion =  $this->input->post("opcion");
    $id = $this->input->post("id_descuento");
    $data = [];
    if($opcion == 'Autorizar'){
      $data = ['estatus' => 2];
    }elseif($opcion == 'Borrar'){
      $motivo =  $this->input->post("motivodelete");
      $data = ['estatus' => 3,
              'motivodel' => $motivo];
    }elseif($opcion == 'Rechazar'){
      $motivo =  $this->input->post("motivodelete");
      $data = ['estatus' => 4,
              'motivodel' => $motivo];
    }elseif($opcion == 'Actualizar'){
      $monto =  $this->input->post("monto");
      $concepto = $this->input->post("conceptos");
      $estado = $this->input->post("estatus");
 
      $data = ['monto' => $monto,
                'conceptos' => $concepto,
                'estatus' => $estado];
    }
    
    $respuesta =  $this->Resguardos_model->actualizarRetiro($data,$id,$opcion);
    echo json_encode($respuesta);
  }
  
  public function getDisponibleResguardoP($user,$opc = ''){
    if($opc == ''){
      $datos = $this->Resguardos_model->getDisponibleResguardo($user)->result_array();
      $extras = $this->Resguardos_model->getDisponibleExtras($user)->result_array();
      $suma =$datos[0]['suma'];
    }else{
      $datos = $this->Resguardos_model->getDisponibleResguardo($user)->result_array();
      $suma =($datos[0]['suma']);
    }
    echo json_encode($suma);
  }
  
  public function getDisponibleResguardo($user){
    $datos = $this->Resguardos_model->getDisponibleResguardo($user)->result_array();
    $extras = $this->Resguardos_model->getDisponibleExtras($user)->result_array();
    $pagado = $this->Resguardos_model->getAplicadoResguardo($user)->result_array();
    $disponible = ($datos[0]['suma'] + $extras[0]['extras']) - $pagado[0]['aplicado'];
    echo json_encode($disponible);
  }


}
 