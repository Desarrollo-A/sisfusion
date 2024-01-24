<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Ajuste extends CI_Controller
{
  private $gph;
  public function __construct()
  {

    parent::__construct();
    $this->load->model('Ajuste_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','phpmailer_lib','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));

  }

    public function index() {
        if($this->session->userdata('perfil') == FALSE || ($this->session->userdata('perfil') != 'contraloria' && $this->session->userdata('perfil') != 'contraloriaCorporativa' && $this->session->userdata('perfil') != 'subdirectorContraloria' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'direccionFinanzas' && $this->session->userdata('perfil') != 'ejecutivoContraloriaJR'))
        {
            redirect(base_url().'login');
        }
        $this->load->view('template/header');
        $this->load->view('template/home');
        $this->load->view('template/footer');
    }
  
    public function AjusteCorte() {
        $resultados = $this->Ajuste_model->banderaAutorizacionesCorte();
        
        $id_usuario = $resultados['id_usuario'];;
        $bandera = $resultados['bandera'];
        
        $permisos_edicion = ($this->session->userdata('id_usuario') == $id_usuario && $bandera == 1) ? 1 : 0;
        
        $data['permisos_edicion'] = $permisos_edicion;
    
        $this->load->view('template/header');
        $this->load->view("ajuste/Ajuste-view", $data);
    }
    
  
    public function getDatosFechas(){
        $respuesta = $this->Ajuste_model->getDatosFechas()->result_array();
        echo json_encode($respuesta);
    }

    public function editarFecha() {
        $idFechaCorte = $this->input->post('idFechaCorte');
        $nuevaFechaInicio = $this->input->post('nuevaFechaInicio');
        $nuevaFechaFinGeneral = $this->input->post('nuevaFechaFinGeneral');
        $nuevaFechaTijuana = $this->input->post('nuevaFechaTijuana');
    
        $this->Ajuste_model->editarFecha($idFechaCorte, $nuevaFechaInicio, $nuevaFechaFinGeneral,$nuevaFechaTijuana);
    
    }
        


  
    public function autorizacion_fechas() {
        $this->load->view('template/header');
        $this->load->view("ajuste/administracion/autorizacion_modificar_corte_view");
    }
    public function getautorizaciones() {
        $respuesta = $this->Ajuste_model->autorizaciones()->result_array();
        echo json_encode($respuesta);
    }
        
    public function editarAutorizacion() {
        $bandera = $this->input->post('bandera');
        $id_autorizacion = $this->input->post('id_autorizacion');


        $data = array(
            'bandera' => $bandera,
        );
        $update = $this->Ajuste_model->editarAutorizacion($id_autorizacion, $data);
        // var_dump( $update);
        if($update){
            $respuesta =  array(
              "response_code" => 200, 
              "response_type" => 'success',
              "message" => "Autorización actualizado");
          } else{
            $respuesta =  array(
              "response_code" => 400, 
              "response_type" => 'error',
              "message" => "Autorización no actualizado, inténtalo más tarde ");
          }
        echo json_encode($respuesta);
    }
        
}