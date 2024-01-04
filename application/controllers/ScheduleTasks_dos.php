<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ScheduleTasks_dos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->load->model('ComisionesNeo_model');
  }

  public function index()
  {
    redirect(base_url());
  }

// ScheduleTasks_dos/LlenadoPlan
//ESTE CRON SE UTILIZA PARA ASIGNARLE UN PLAN DE COMISION A CADA LOTE QUE LLEGA DISPONIBLE PARA COMISIONAR, EL PLAN SE ASIGNA SEGUN LA PRIORIDAD Y LAS CONDICIONES QUE TIENE CADA PLAN

  public function LlenadoPlan(){ //CRON diario

    $QUERY_V = $this->db->query("SELECT MAX(prioridad) DATA_V FROM plan_comision");
    $DAT = $QUERY_V->row()->DATA_V;

    for($j = 0; $j < $DAT+1; $j++){
        // echo '<BR>PRIORIDAD '.$j;
        $datos = $this->ComisionesNeo_model->getPrioridad($j)->result_array();

        if(count($datos) > 0)
        {
            $data = array();
            for($i = 0; $i < COUNT($datos); $i++){
                $data[$i] = $this->ComisionesNeo_model->updatePlan($j, $datos[$i]['id_plan']);
            }
        }else{
            echo NULL;
        }
    }
}


}
