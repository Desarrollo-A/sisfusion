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
    $this->db->query("UPDATE descuentos_universidad SET estatus = 4, pagos_activos = 0 WHERE estatus IN(0,1,2) AND id_descuento IN (SELECT du.id_descuento FROM descuentos_universidad du INNER JOIN usuarios us ON us.id_usuario = du.id_usuario INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario GROUP BY du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, pci2.abono_pagado, du.pagado_caja, du.monto, du.id_descuento HAVING(pci2.abono_pagado + du.pagado_caja - du.monto) >-1 and (pci2.abono_pagado + du.pagado_caja - du.monto) <1 )");
    $this->db->query("UPDATE descuentos_universidad SET estatus = 1, pagos_activos = pagos_activos + 1 WHERE estatus IN (1,2) and pagos_activos < 7");
    $this->db->query("UPDATE descuentos_universidad SET estatus = 1, pagos_activos = 1 WHERE estatus = 5 AND YEAR(GETDATE()) = YEAR(fecha_modificacion) AND MONTH(GETDATE()) = MONTH(fecha_modificacion)");
    // $this->db->query("UPDATE descuentos_universidad SET pagos_activos = 0 WHERE estatus IN (3)");
    $this->db->query("UPDATE opinion_cumplimiento SET estatus = 0  WHERE estatus IN (1,2)");
    $this->db->query("UPDATE cp_usuarios SET estatus = 0 WHERE estatus IN (1)");
    $this->db->query("UPDATE pago_comision_ind SET abono_neodata = 0 WHERE id_comision in (SELECT id_comision FROM comisiones WHERE estatus = 0 and rol_generado not in (38))");
    $this->db->query("UPDATE facturas set id_comision = 0 where total = 0 and id_comision not in (0)");
    
}

//EDITAR EL TOTAL COMISION EN BANDERAS
public function flag(){
    $datos = $this->ComisionesNeo_model->getFlag()->result_array();
    if(count($datos) > 0){
        $data = array();
        for($i = 0; $i < COUNT($datos); $i++){
            $data[$i] = $this->ComisionesNeo_model->updateFlag($datos[$i]['id_lote'], $datos[$i]['total'], $datos[$i]['bandera']);
            echo 'L0: '.$datos[$i]['id_lote'].'<BR>';
        }
    }else{
        echo NULL;
    }
}
 
//EDITAR EL ABONADO EN BANDERAS
public function flagAbonado(){
    $datos = $this->ComisionesNeo_model->getFlagAbonado()->result_array();
    if(count($datos) > 0){
        $data = array();
        for($i = 0; $i < COUNT($datos); $i++){
            $data[$i] = $this->ComisionesNeo_model->updateFlagAbonado($datos[$i]['id_lote'], $datos[$i]['abonado'], $datos[$i]['bandera']);
            echo 'AB: '.$datos[$i]['id_lote'].' '.$datos[$i]['bandera'].'<BR>';
        }
    }else{
        echo NULL;
    }
}
 
//EDITAR EL PENDIENTE EN BANDERAS
public function flagPendiente(){
    $datos = $this->ComisionesNeo_model->getFlagPendiente()->result_array();
    if(count($datos) > 0){
        $data = array();
        for($i = 0; $i < COUNT($datos); $i++){
            $data[$i] = $this->ComisionesNeo_model->updateFlagPendiente($datos[$i]['id_lote'], $datos[$i]['bandera']);
            echo 'PE: '.$datos[$i]['id_lote'].' '.$datos[$i]['bandera'].'<BR>';
        }
    }else{
        echo NULL;
    }
}

// public function flagPendienteDistintos(){
//     $this->ComisionesNeo_model->updateFlagPendienteDistintos()->result_array();
// }

// ScheduleTasks_com/topar_bandera_neo
public function topar_bandera_neo(){
    $this->flag();
    $this->flagAbonado();
    // $this->flagPendienteDistintos();
    $this->flagPendiente();

    //UPDATE BANDERA QUE DEBEN ESTAR EN 7 Y ESTAN EN OTRO ESTATUS
    $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE registro_comision not in (8) AND idLote IN (SELECT id_lote FROM pago_comision WHERE pendiente BETWEEN -1 AND 1 AND bandera NOT IN (7,0))");
    $this->db->query("UPDATE pago_comision SET bandera = 7 WHERE pendiente BETWEEN -1 AND 1 AND bandera NOT IN (7,0)");

    //UPDATE BANDERA QUE DEBEN ESTAR EN ACTIVAS Y NO EN LIQUIDADAS
    $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE registro_comision not in (8) AND idLote IN (SELECT id_lote FROM pago_comision WHERE pendiente > 2 AND bandera IN (7))");
    $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE pendiente > 2 AND bandera IN (7)");
}

public function LlenadoPlan(){ //CRON diario
    $this->db->query("DELETE FROM comisiones where id_usuario = 0");
    $this->db->query("DELETE FROM pago_comision_ind where estatus = 0 and abono_neodata = 0");
    $this->db->query("DELETE from comisiones where porcentaje_decimal = 0 and id_comision not in (select id_comision from pago_comision_ind)");

    $QUERY_V = $this->db->query("SELECT MAX(prioridad) DATA_V FROM plan_comision");
    $DAT = $QUERY_V->row()->DATA_V;
    for($j = 0; $j < $DAT+1; $j++){
        $datos = $this->ComisionesNeo_model->getPrioridad($j)->result_array();
        if(count($datos) > 0){
            $data = array();
            for($i = 0; $i < COUNT($datos); $i++){
                $data[$i] = $this->ComisionesNeo_model->updatePlan($j, $datos[$i]['id_plan']);
            }
        }else{
            echo NULL;

        }
    }
}

//REGRESAR SOLO SI TIENEN MAS DE $100 PESOS, DE 1 A 55 Y LAS QUE SON RECISIONES DE CONTRATO
public function limpiar_bandera_neo(){
    $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE bandera IN (55)");
    $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE id_lote in (select idLote from lotes where registro_comision = 1 and idStatusContratacion = 15) and bandera IN (1,55) and abonado<(total_comision-100) and abonado < (ultimo_pago-100)");
    $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE id_lote in (select idLote from lotes where registro_comision = 8) and bandera NOT IN (0)");
    $this->db->query("UPDATE pago_comision SET bandera = 7 where pendiente <2 and bandera not in (7) and total_comision not in (0)");
    $this->db->query("UPDATE lotes SET registro_comision = 7 where registro_comision not in (7) and idLote in (select id_lote from pago_comision where bandera in (7))");

    $this->db->query("UPDATE pago_comision SET bandera = 0 WHERE bandera = 10");
    $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE bandera IN (15,11)");
    $this->db->query("UPDATE pago_comision SET bandera = 7 WHERE bandera = 17");

    $this->LlenadoPlan();
}

// ScheduleTasks_com/activar_bandera_neo
public function activar_bandera_neo(){
    $QUERY_V = $this->db->query("SELECT MAX(idResidencial) DATA_V FROM residenciales ");
    $DAT = $QUERY_V->row()->DATA_V;

    for($j = 1; $j < $DAT+1; $j++){
        $datos = $this->ComisionesNeo_model->getLotesPagados($j)->result_array();
        
        if(count($datos) > 0){
            $data = array();
            $final_data = array();
            
            for($i = 0; $i < COUNT($datos); $i++){
                $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
                if(!empty($data)){
                    if($data[$i]->Marca == 1){
                        if($data[$i]->Aplicado > ($datos[$i]['ultimo_pago']+100)){
                            $this->ComisionesNeo_model->UpdateBanderaPagoComision($datos[$i]['id_lote'], $data[$i]->Bonificado, $data[$i]->FechaAplicado, $data[$i]->fpoliza, $data[$i]->Aplicado);
                            $contador ++;
                        }else{
                            $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                        }
                    }else{
                        $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                    }
                }else{
                    $this->ComisionesNeo_model->UpdateBanderaPagoComisionNO($datos[$i]['id_lote']);
                }
            }

            //  for($i = 0; $i < COUNT($datos); $i++){
            //     $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
            //     if(!empty($data)){
            //         if($data[$i]->Marca == 1){
            //                  $this->ComisionesNeo_model->UpdateBanderaPagoComision2($datos[$i]['id_lote'], $data[$i]->Bonificado, $data[$i]->fpoliza, $data[$i]->Aplicado);
            //                 $contador ++;
            //         }else{
            //              echo NULL;
            //         }
            //     }else{
            //          echo NULL;
            //     }
            // }

        }else{
            echo NULL;
        }
    }
    $this->ComisionesNeo_model->UpdateBanderaPagoComisionAnticipo();
    //$this->ComisionesNeo_model->UpdateBanderaPagoComisionNewNeo();
}

}
