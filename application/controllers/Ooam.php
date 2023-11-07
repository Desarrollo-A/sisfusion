<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Ooam extends CI_Controller
{
  public function __construct() {
    {
        parent::__construct();
        $this->load->model('Comisiones_model');
        $this->load->model('asesor/Asesor_model');
        $this->load->model('Usuarios_modelo');
        $this->load->model('PagoInvoice_model');
        $this->load->model('General_model');
        $this->load->model('Ooam_model');
        $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->jwt_actions->authorize('1998', $_SERVER['HTTP_HOST']);
        $this->validateSession();
    
          $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
          $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
          $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
           $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
      }
    }
    
       public function validateSession() {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
          redirect(base_url() . "index.php/login");
      }
 
    public function getRevisionAsimiladosOOAM(){

        $proyecto = $this->input->post('proyecto');  
        $condominio = $this->input->post('condominio');  
  
        $dat =  $this->Ooam_model->getRevisionAsimiladosOOAM($proyecto,$condominio);
       for( $i = 0; $i < count($dat); $i++ ){
           $dat[$i]['montoOOAM'] = 0;
       }
       echo json_encode( array( "data" => $dat));
      }

      public function dispersion() {
        if ($this->session->userdata('id_rol') == FALSE)
            redirect(base_url());
            
            // $datos["controversias"] = $this->Ooam_model->getMotivosControversia();
            $this->load->view('template/header');
            $this->load->view("ooam/dispersion_ooam_view");
      }


    public function getRevisionRemanenteOOAM(){

        $proyecto = $this->input->post('proyecto');  
        $condominio = $this->input->post('condominio');  
  
        $dat =  $this->Ooam_model->getRevisionRemanenteOOAM($proyecto,$condominio);
       for( $i = 0; $i < count($dat); $i++ ){
           $dat[$i]['montoOOAM'] = 0;
       }
       echo json_encode( array( "data" => $dat));
      }


      public function getRevisionFacturasOOAM(){

        $proyecto = $this->input->post('proyecto');  
        $condominio = $this->input->post('condominio');  
  
        $dat =  $this->Ooam_model->getRevisionFacturasOOAM($proyecto,$condominio);
       for( $i = 0; $i < count($dat); $i++ ){
           $dat[$i]['montoOOAM'] = 0;
       }
       echo json_encode( array( "data" => $dat));
      }



      
   public function acepto_internomex_asimilados(){
    $sol = $this->input->post('idcomision');  

     $consulta_comisiones = $this->Ooam_model->consulta_comisiones( $sol );
      if( $consulta_comisiones != FALSE){

        $id_user_Vl = $this->session->userdata('id_usuario');
          $sep = ',';
          $id_pago_i = '';
          $data=array();
          foreach ($consulta_comisiones as $row) {
            $id_pago_i .= implode($sep, $row);
            $id_pago_i .= $sep;
            $row_arr=array(
              'id_pago_i' => $row['id_pago_i'],
              'id_usuario' =>  $id_user_Vl,
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
            );
             array_push($data,$row_arr);
          }
          $id_pago_i = rtrim($id_pago_i, $sep);
            
            $arrayUpdateControlaria = array(
              'estatus' => 8,
              'modificado_por' => $id_user_Vl
            );

            $up_b = $this->Ooam_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
            $ins_b = $this->Ooam_model->insert_phc($data);

      if($up_b == true && $ins_b == true){
        $data_response = 1;
        echo json_encode($data_response);
      } else {
        $data_response = 0;
        echo json_encode($data_response);
      }
      }
      else{
        $data_response = 0;
      echo json_encode($data_response);
      }
  }

  public function acepto_internomex_remanente(){
    $sol = $this->input->post('idcomision');  

     $consulta_comisiones = $this->Ooam_model->consulta_comisiones( $sol );
      if( $consulta_comisiones != FALSE){

        $id_user_Vl = $this->session->userdata('id_usuario');
          $sep = ',';
          $id_pago_i = '';
          $data=array();
          foreach ($consulta_comisiones as $row) {
            $id_pago_i .= implode($sep, $row);
            $id_pago_i .= $sep;
            $row_arr=array(
              'id_pago_i' => $row['id_pago_i'],
              'id_usuario' =>  $id_user_Vl,
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
            );
             array_push($data,$row_arr);
          }
          $id_pago_i = rtrim($id_pago_i, $sep);
            
            $arrayUpdateControlaria = array(
              'estatus' => 8,
              'modificado_por' => $id_user_Vl
            );

            $up_b = $this->Ooam_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
            $ins_b = $this->Ooam_model->insert_phc($data);

      if($up_b == true && $ins_b == true){
        $data_response = 1;
        echo json_encode($data_response);
      } else {
        $data_response = 0;
        echo json_encode($data_response);
      }
      }
      else{
        $data_response = 0;
      echo json_encode($data_response);
      }
  }



  public function getComments($id_pago ){

    echo json_encode($this->Ooam_model->getComments($id_pago));
}

function setPausaPagosOOAM(){
    $respuesta = array( FALSE );
    if($this->input->post("id_pago")){
      $respuesta = array( $this->Ooam_model->setPausaPagosOOAM( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
    }
    echo json_encode( $respuesta );
  }

  public function getDataDispersionOOAM() {
    $data['data'] = $this->Ooam_model->getDataDispersionOOAM()->result_array();
    echo json_encode($data);
  }


  public function getMontoDispersadoDates(){
    $fechaInicio = explode('/', $this->input->post("fecha1"));
    $fechaFin = explode('/', $this->input->post("fecha2"));
    $fecha1 = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
    $fecha2 = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
  
    $datos["datos_monto"] = $this->Ooam_model->getMontoDispersadoDates($fecha1, $fecha2)->result_array();
    $datos["datos_pagos"] = $this->Ooam_model->getPagosDispersadoDates($fecha1, $fecha2)->result_array();
    $datos["datos_lotes"] = $this->Ooam_model->getLotesDispersadoDates($fecha1, $fecha2)->result_array();
  
    echo json_encode($datos);
  
  }

  function getDatosAbonadoDispersion($idlote){
    echo json_encode($this->Ooam_model->getDatosAbonadoDispersion($idlote)->result_array());
  }
  
  function getDatosAbonadoSuma11($idlote){
    echo json_encode($this->Ooam_model->getDatosAbonadoSuma11($idlote)->result_array());
  }


  
  public function InsertNeo(){
    $lote_1 =  $this->input->post("idLote");
    $bonificacion =  $this->input->post("bonificacion");
    $responses = $this->Comisiones_model->validateDispersionCommissions($lote_1);
    
      $this->db->trans_begin();
      $lote_1 =  $this->input->post("idLote");
      $pending_1 =  $this->input->post("pending");
      $abono_nuevo = $this->input->post("abono_nuevo[]");
      $id_usuario = $this->input->post("id_usuario[]");
      $id_comision = $this->input->post("id_comision[]");
      $pago = $this->input->post("pago_neo");

      $suma = 0;
      $replace = [",","$"];
      
      for($i=0;$i<sizeof($id_comision);$i++){
        $var_n = str_replace($replace,"",$abono_nuevo[$i]);
          $respuesta = $this->Ooam_model->insert_dispersion_individual($id_comision[$i], $id_usuario[$i], $var_n, $pago);
      }
      
      for($i=0;$i<sizeof($abono_nuevo);$i++){
        $var_n = str_replace($replace,"",$abono_nuevo[$i]);
        $suma = $suma + $var_n;
      }
      
      $resta = $pending_1 - $pago;
      if($suma > 0){
        $respuesta = $this->Ooam_model->UpdateLoteDisponible($lote_1);
        $respuesta = $this->Ooam_model->update_pago_dispersion($suma, $lote_1, $pago);
      }

      if ($respuesta === FALSE || $this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $respuesta = false;
      }else{
        $this->db->trans_commit();
        $respuesta = true;
      }
    
 
  echo json_encode( $respuesta );
  }



  
  public function lotes(){
    $lotes = $this->Ooam_model->lotes();
    
    $pagos = $this->Ooam_model->pagos();
    
    $monto = $this->Ooam_model->monto();

    $dispersion[ "lotes"] = $lotes->nuevo_general; 
    $dispersion["pagos"] = $pagos->nuevo_general;
    $dispersion["monto"] = $monto->nuevo_general;

    echo json_encode(  $dispersion);
    }
 

}



