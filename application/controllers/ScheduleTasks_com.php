<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ScheduleTasks_com extends CI_Controller
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


// ScheduleTasks_com/CleanMonthly

  public function CleanMonthly(){ //CRON JOB 1 DE CADA MES
    $this->db->query("UPDATE descuentos_universidad SET estatus = 4, pagos_activos = 0 WHERE estatus IN(2) AND id_descuento IN (SELECT du.id_descuento FROM descuentos_universidad du INNER JOIN usuarios us ON us.id_usuario = du.id_usuario INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario GROUP BY du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, pci2.abono_pagado, du.pagado_caja, du.monto, du.id_descuento HAVING(pci2.abono_pagado + du.pagado_caja - du.monto) >-1 and (pci2.abono_pagado + du.pagado_caja - du.monto) <1 )");
   $this->db->query("UPDATE descuentos_universidad SET estatus = 1, pagos_activos = pagos_activos + 1 WHERE estatus IN (1,2) and pagos_activos < 7");
   // -- $this->db->query("UPDATE descuentos_universidad SET pagos_activos = 0 WHERE estatus IN (3)");
    $this->db->query("UPDATE opinion_cumplimiento SET estatus = 0  WHERE estatus IN (1,2)");

    }

 


    public function topar_bandera_neo(){

      $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote IN (SELECT id_lote FROM pago_comision WHERE pendiente = 0 AND bandera NOT IN (7,0) AND registro_comision not in (8) )");
      $this->db->query("UPDATE pago_comision SET bandera = 7 WHERE id_lote IN (SELECT id_lote FROM pago_comision WHERE pendiente = 0 AND bandera NOT IN (7,0))");
      $this->db->query("UPDATE pago_comision set bandera = 7 where id_lote in (select idLote from lotes where idLote in (select id_lote from pago_comision where pendiente < 1 and bandera not in (0,7)) and registro_comision = 7)");
      }
      
  // ScheduleTasks_com/LlenadoPlan

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
  
    public function limpiar_bandera_neo(){
  //limpiar liquidas y pasar de 55 a 1
      $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote IN (SELECT id_lote FROM pago_comision WHERE pendiente = 0 AND bandera NOT IN (7,0)) AND registro_comision not in (8) ");
      $this->db->query("UPDATE pago_comision SET bandera = 7 WHERE id_lote IN (SELECT id_lote FROM pago_comision WHERE pendiente = 0 AND bandera NOT IN (7,0))");
      $this->db->query("UPDATE pago_comision set bandera = 7 where id_lote in (select idLote from lotes where idLote in (select id_lote from pago_comision where pendiente < 1 and bandera not in (7,0)) and registro_comision = 7)");
      $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE id_lote in (select idLote from lotes where registro_comision = 1 and idStatusContratacion = 15) and bandera = 55 and abonado<(total_comision-100) and abonado < (ultimo_pago-100)");
      $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE id_lote in (select idLote from lotes where registro_comision = 8) and bandera NOT IN (0)");
      $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE bandera IN (55)");

      LlenadoPlan();
  
  }




// ScheduleTasks_com/activar_bandera_neo
public function activar_bandera_neo(){
    $QUERY_V = $this->db->query("SELECT MAX(idResidencial) DATA_V FROM residenciales ");
    $DAT = $QUERY_V->row()->DATA_V;
    // $DAT = 1;

    // for($j = 11; $j < 12; $j++){
    for($j = 1; $j < $DAT+1; $j++){
        // echo $j.' j++<br>';
        $datos = $this->ComisionesNeo_model->getLotesPagados($j)->result_array();

        if(count($datos) > 0)
        {
            $data = array();
            $final_data = array();

            for($i = 0; $i < COUNT($datos); $i++){

                $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
                if(!empty($data)){

                    if($data[$i]->Marca == 1){
                        // echo $datos[$i]['referencia'].' LOTE OK<br>';

                        if($data[$i]->Aplicado > ($datos[$i]['ultimo_pago']+100)){
                            $this->ComisionesNeo_model->UpdateBanderaPagoComision($datos[$i]['id_lote'], $data[$i]->Bonificado);
                            $contador ++;
                        }else{
                            // echo $datos[$i]['id_lote'].' LOTE incorrecta<br>';
                            $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                        }
                        
                     }else{
                    // echo $datos[$i]['id_lote'].' Marca incorrecta<br>';
                    $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                 }

                }else{
                    // echo $datos[$i]['id_lote'].' NO incorrecta<br>';
                    $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                 }
            }
        }else{
            echo NULL;
        }
    }
    // validar para los que tiene mas abono
    $this->ComisionesNeo_model->UpdateBanderaPagoComisionAnticipo();
}

 

}
