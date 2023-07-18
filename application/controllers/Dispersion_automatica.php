<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Dispersion_automatica extends CI_Controller
{
  private $gph;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Comisiones_model');
    $this->load->model('asesor/Asesor_model');
    $this->load->model('Usuarios_modelo');
    $this->load->model('PagoInvoice_model');
    $this->load->model('General_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('780', $_SERVER['HTTP_HOST']);
    $this->validateSession();
   }

  public function index(){
    redirect(base_url());
  }
  
  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function prueba  (){
  
    $QUERY_V = $this->db->query("SELECT MAX(idResidencial) DATA_V FROM residenciales ");
    $DAT = $QUERY_V->row()->DATA_V;

    var_dump($DAT);

    // for($j = 1; $j < $DAT+1; $j++){
    //     $datos = $this->ComisionesNeo_model->getLotesPagados($j)->result_array();
        
    //     if(count($datos) > 0){
    //         $data = array();
    //         $final_data = array();
            
    //     }
    //   }

    $informacion_de_dispersion = array();

    // if(count($informacion_de_dispersion) > 0){
 
    //   // switch (){

    //   // }




    // }
    echo ('Dispersión automatica');

  }






  

}