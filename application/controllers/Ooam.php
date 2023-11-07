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



}



