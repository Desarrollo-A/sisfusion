<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Pagos_casas extends CI_Controller
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
    $this->load->model('Pagos_model');
    $this->load->model('Pagos_casas_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('9898', $_SERVER['HTTP_HOST']);
    $this->validateSession();

    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
    redirect(base_url() . "index.php/login");
    }

    function pausar_solicitudM(){
        $respuesta = array( FALSE );
        if($this->input->post("id_pago")){
            $respuesta = array( $this->Pagos_casas_model->update_estatus_pausaM( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
        }
        echo json_encode( $respuesta );
    }
    
    public function getCondominioDesc($residenciales){
        $data = $this->Asesor_model->getCondominioDesc($residenciales);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getDatosNuevasAsimiladosCasas(){

        if($this->session->userdata('id_rol') == 31){
            $filtro1 = $this->input->post('puesto');  
            $filtro2 = $this->input->post('usuario'); 
        
        }else{
            $filtro1 = $this->input->post('proyecto');  
            $filtro2 = $this->input->post('condominio'); 
        }

        $dat =  $this->Pagos_casas_model->getDatosNuevasAsimiladosCasas($filtro1,$filtro2);

        for( $i = 0; $i < count($dat); $i++ ){
            $dat[$i]['pa'] = 0;
        }
        echo json_encode( array( "data" => $dat));
    }   


    public function carga_listado_factura(){
      echo json_encode( $this->Pagos_casas_model->get_solicitudes_factura( $this->input->post("idResidencial"), $this->input->post("id_usuario") ) );
    }


    public function updateRevisionaInternomex(){
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_casas_ind where id_pago_i IN (".$sol.")");
            if( $consulta_comisiones->num_rows() > 0 ){
            $consulta_comisiones = $consulta_comisiones->result_array();
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
                $up_b = $this->Pagos_casas_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
                $ins_b = $this->Pagos_casas_model->insert_phc($data);
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

      public function getDatosNuevasFacturasCasas(){
        $proyecto = $this->input->post('proyecto');  
        $condominio =   $this->input->post('condominio');  
        $dat =  $this->Pagos_casas_model->getDatosNuevasFacturasCasas($proyecto,$condominio);
        for( $i = 0; $i < count($dat); $i++ ){
          $dat[$i]['pa'] = 0;
        }
        echo json_encode( array( "data" => $dat));
      }

      public function getDatosNuevasRemanenteCasas(){
        $proyecto = $this->input->post('proyecto');  
        $condominio = $this->input->post('condominio');
        $dat =  $this->Pagos_casas_model->getDatosNuevasRemanenteCasas($proyecto,$condominio);
        for( $i = 0; $i < count($dat); $i++ ){
          $dat[$i]['pa'] = 0;
        }
        echo json_encode( array( "data" => $dat));
      }
    
    

      public function getDatosNuevasXContraloria(){
        $proyecto = $this->input->post('proyecto');
        $condominio = $this->input->post('condominio');
        $dat =  $this->Pagos_casas_model->getDatosNuevasXContraloria($proyecto,$condominio)->result_array();
        for( $i = 0; $i < count($dat); $i++ ){
            $dat[$i]['pa'] = 0;
        }
        echo json_encode( array( "data" => $dat));
      }
      
      public function GetDescripcionXML($xml){
        error_reporting(0);
        $xml=simplexml_load_file("".base_url()."UPLOADS/XMLS_CASAS/".$xml."") or die("Error: Cannot create object");
        $cuantos = count($xml->xpath('//cfdi:Concepto'));
        $UUID = $xml->xpath('//@UUID')[0];
        $fecha = $xml->xpath('//cfdi:Comprobante')[0]['Fecha'];
        $folio = $xml->xpath('//cfdi:Comprobante')[0]['Folio'];
        if($folio[0] == null){
          $folio = '*';
        }
        $total = $xml->xpath('//cfdi:Comprobante')[0]['Total'];
        $cadena = '';
        for($i=0;$i< $cuantos; $i++ ){
          $cadena = $cadena.' '.$xml->xpath('//cfdi:Concepto')[$i]['Descripcion']; 
        }
        $arr[0]= $UUID[0];
        $arr[1]=  $fecha[0];
        $arr[2]=  $folio[0];
        $arr[3]=  $total;
        $arr[4]=  $cadena;
        echo json_encode($arr);
      }

      public function descargar_XML(){
        if( $this->session->userdata('id_rol') == 31 ){
          $filtro = " pci.estatus IN (8) ";
        } else{
          $filtro = " pci.estatus IN (4,8) ";
        }
        
        $facturas_disponibles = array();
        $facturas_disponibles = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) 
        from factura_casas fa
        INNER JOIN pago_casas_ind pci ON fa.id_comision = pci.id_pago_i
        WHERE $filtro
        GROUP BY fa.nombre_archivo
        ORDER BY fa.nombre_archivo");
        
        if( $facturas_disponibles->num_rows() > 0 ){
          $this->load->library('zip');
          $nombre_documento = 'FACTURAS_INTERNOMEX_'.date("YmdHis").'.zip';
          foreach( $facturas_disponibles->result() as $row ){
            $this->zip->read_file( './UPLOADS/XMLS_CASAS/'.$row->nombre_archivo );
          }
          
          $this->zip->archive( $nombre_documento );
          $this->zip->download( $nombre_documento );
        }else{

          echo "<script>alert('HA OCURRIDO UN ERROR');</script>";
        }
      }

        public function getReporteEmpresa(){
          echo json_encode($this->Pagos_casas_model->report_empresa());
        }

        public function getDatosFactura($uuid, $id_res){
            if($uuid){
                $consulta_sol = $this->Pagos_casas_model->factura_comision($uuid, $id_res)->row();
                if (!empty($consulta_sol)) {
                    $datos['datos_solicitud'] = $this->Pagos_casas_model->factura_comision($uuid, $id_res)->row(); 
                }
                else {
                    $datos['datos_solicitud'] = array('0', FALSE);
                } 
            }
            else{
                $datos['datos_solicitud'] = array('0', FALSE);
            }
            echo json_encode( $datos );
          }
          
          public function lista_usuarios(){
            $rol = $this->input->post("rol");
            $forma_pago = $this->input->post("forma_pago");
            $respuesta = $this->Pagos_casas_model->get_lista_usuarios($rol,$forma_pago);
            echo json_encode($respuesta);
          }

        
          public function getPagosByProyect($proyect, $formap){
    
            if(empty($proyect)){
              echo json_encode($this->Pagos_casas_model->getPagosByProyect());
            }else{
              echo json_encode($this->Pagos_casas_model->getPagosByProyect($proyect,$formap));
            }
          }


          function IntMexPagadosByProyect(){
            date_default_timezone_set('America/Mexico_City');
            $idsessionado = $this->session->userdata('id_usuario');
            $idsPagos = $this->input->post("ids");
            $sep = ',';
            $id_pago_i = '';
            //$cadena_equipo = '';
            $data = array();
              for($i=0; $i <count($idsPagos) ; $i++) { 
                $id_pago_i = implode(",", $idsPagos);
                // $id_pago_i .= implode($sep, $idsPagos);
                //  $id_pago_i .= $sep;
                $row_arr=array(
                  'id_pago_i' => $idsPagos[$i],
                  'id_usuario' =>  $idsessionado,
                  'fecha_movimiento' => date('Y-m-d H:i:s'),
                  'estatus' => 1,
                  'comentario' =>  'INTERNOMEX APLICO PAGO' 
                );
                array_push($data,$row_arr);
              }
              Ini_set('max_execution_time', 0);
        
              $up_b = $this->Pagos_casas_model->update_acepta_INTMEX($id_pago_i);
              $ins_b = $this->Pagos_casas_model->insert_phc($data);
        
            if($up_b == true && $ins_b == true){
              $data_response = 1;
              echo json_encode($data_response);
            } else {
              $data_response = 0;
              echo json_encode($data_response);
            }
          }
        
          public function getDesarrolloSelectINTMEX(){

            $value = $this->input->post("desarrollo");
            if($value == ''){
            echo json_encode($this->Pagos_casas_model->getDesarrolloSelectINTMEX()->result_array());
          }else{
            echo json_encode($this->Pagos_casas_model->getDesarrolloSelectINTMEX($value)->result_array());
          }
        }

        public function pago_internomex(){
          $id_pago_is = $this->input->post('idcomision');  
          $consulta_comisiones = $this->Pagos_casas_model->consultaComisiones($id_pago_is);
                
          if( $consulta_comisiones != 0 ){
            $id_user_Vl = $this->session->userdata('id_usuario');
            $sep = ',';
            $id_pago_i = '';
            $data=array();
        
            foreach ($consulta_comisiones as $row) {
              $id_pago_i .= implode($sep, $row);
              $id_pago_i .= $sep;
        
              $row_arr=array(
              'id_pago_i' => $row['id_pago_i'],
              'id_usuario' =>   $this->session->userdata('id_usuario'),
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'INTERNOMEX APLICÓ PAGO' 
              );
              array_push($data,$row_arr);
            }

            $id_pago_i = rtrim($id_pago_i, $sep);
            $up_b = $this->Pagos_casas_model->update_acepta_INTMEX($id_pago_i);
            $ins_b = $this->Pagos_casas_model->insert_phc($data);
              
            if($up_b == true && $ins_b == true){
              $data_response = 1;
              echo json_encode($data_response);
            } else {
              $data_response = 0;
              echo json_encode($data_response);
            }
                    
          }else{
            $data_response = 0;
            echo json_encode($data_response);
          }
          
        }


          function despausar_solicitud(){
            $respuesta = array( FALSE );
            // <input type="hidden" name="value_pago" value="2">
            if($this->input->post("value_pago")){
              $validate = $this->input->post("value_pago");
          
              switch($validate){
                  case 1:
                    $respuesta = array($this->Pagos_casas_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
                  break;    
                  case 2:
                    $respuesta = array($this->Pagos_casas_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
                  break;
                  case 3:
                    $validate =  $this->Pagos_casas_model->registroComisionAsimilados();
                  // echo $validate->row()->registro_comision.' *COMISION'.$validate->row()->registro_comision;
                  if($validate->row()->registro_comision == 7){
                    $respuesta = FALSE;
                      // echo 'no entra';
                  }else{
                    // echo 'si entra';
                  $respuesta = array($this->Pagos_casas_model->update_estatus_edit($this->input->post("id_pago_i"), $this->input->post("observaciones")));
                  }
                  break;
              }  
            }
            echo json_encode( $respuesta );
          }

          function refresh_solicitud(){
            $respuesta = array( FALSE );
            if($this->input->post("id_pago_i")){
              $respuesta = array( $this->Pagos_casas_model->update_estatus_refresh( $this->input->post("id_pago_i")));
            }
            echo json_encode( $respuesta );
          }
          function pausar_solicitud(){
            $respuesta = array( FALSE );
            if($this->input->post("id_pago")){
              $respuesta = array( $this->Pagos_casas_model->update_estatus_pausa( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
            }
            echo json_encode( $respuesta );
          }


        
        public function getComments($id_pago ){
            echo json_encode($this->Pagos_casas_model->getComments($id_pago));
        }

        public function pago_internomexBono(){
          $id_pago_is = $this->input->post('idcomision');  
          $consulta_comisiones = $this->Pagos_casas_model->consultaComisionesBono($id_pago_is);
                
          if( $consulta_comisiones != 0 ){
            $id_user_Vl = $this->session->userdata('id_usuario');
            $sep = ',';
            $id_pago_bono = '';
            $data=array();
        
            foreach ($consulta_comisiones as $row) {
              $id_pago_bono .= implode($sep, $row);
              $id_pago_bono .= $sep;
        
              $row_arr=array(
              'id_pago_i' => $row['id_pago_bono'],
              'id_usuario' =>   $this->session->userdata('id_usuario'),
              'fecha_movimiento' => date('Y-m-d H:i:s'),
              'estatus' => 1,
              'comentario' =>  'INTERNOMEX APLICÓ PAGO' 
              );
              array_push($data,$row_arr);
            }

            $id_pago_bono = rtrim($id_pago_bono, $sep);
            $up_b = $this->Pagos_casas_model->update_acepta_INTMEX_Bono($id_pago_bono);
            $ins_b = $this->Pagos_casas_model->insert_phc_Bono($data);
              
            if($up_b == true && $ins_b == true){
              $data_response = 1;
              echo json_encode($data_response);
            } else {
              $data_response = 0;
              echo json_encode($data_response);
            }
                    
          }else{
            $data_response = 0;
            echo json_encode($data_response);
          }
          
        }

        public function getCommentsBono($id_pago ){
          echo json_encode($this->Pagos_casas_model->getCommentsBono($id_pago));
        }

        public function getDatosRevisionBonos(){
          $dat =  $this->Pagos_casas_model->getDatosRevisionBonos()->result_array();
          for( $i = 0; $i < count($dat); $i++ ){
            $dat[$i]['pa'] = 0;
          }
          echo json_encode( array( "data" => $dat));
        }

        function getDatosSumaMktd($sede, $plen, $empresa, $res){
          echo json_encode($this->Pagos_casas_model->getDatosSumaMktd($sede, $plen, $empresa, $res)->result_array());
        }

        public function updateRevisionBonoaInternomex(){
          $sol=$this->input->post('idcomision');  
          $consulta_comisiones = $this->db->query("SELECT id_pago_bono FROM pago_comision_bono where id_pago_bono IN (".$sol.")");
              if( $consulta_comisiones->num_rows() > 0 ){
              $consulta_comisiones = $consulta_comisiones->result_array();
              $id_user_Vl = $this->session->userdata('id_usuario');
              $sep = ',';
              $id_pago_bono = '';
              $data=array();
              foreach ($consulta_comisiones as $row) {
                  $id_pago_bono .= implode($sep, $row);
                  $id_pago_bono .= $sep;
      
                  $row_arr=array(
                    'id_pago_i' => $row['id_pago_bono'],
                    'id_usuario' =>  $id_user_Vl,
                    'fecha_movimiento' => date('Y-m-d H:i:s'),
                    'estatus' => 1,
                    'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
                  );
                    array_push($data,$row_arr);
                }
                $id_pago_bono = rtrim($id_pago_bono, $sep);
                  $arrayUpdateControlaria = array(
                    'estatus' => 8,
                    'modificado_por' => $id_user_Vl
                  );
                  $up_b = $this->Pagos_casas_model->update_acepta_contraloria_Bono($arrayUpdateControlaria , $id_pago_bono);
                  $ins_b = $this->Pagos_casas_model->insert_phc_Bono($data);
            if($up_b == true && $ins_b == true){
              $data_response = 1;
              echo json_encode($data_response);
            } else {
              $data_response = 0;
              echo json_encode($data_response);
            }
            }
            else{
              $data_response = 3;
            echo json_encode($data_response);
            }
        }

        function pausar_solicitud_Bono(){
          $respuesta = array( FALSE );
          if($this->input->post("id_pago")){
              $respuesta = array( $this->Pagos_casas_model->update_estatus_pausa_bono( $this->input->post("id_pago_bono"), $this->input->post("observaciones")));
          }
          echo json_encode( $respuesta );
      }

      function despausar_solicitud_Bono_casas(){
        $respuesta = array( FALSE );
        if($this->input->post("value_pago")){
          $validate = $this->input->post("value_pago");
      
          switch($validate){
              case 1:
                $respuesta = array($this->Pagos_casas_model->pausar_Bono($this->input->post("id_pago_bono"), $this->input->post("observaciones"), $this->input->post("estatus") ));
              break;    
              case 2:
                $respuesta = array($this->Pagos_casas_model->despausar_Bono($this->input->post("id_pago_bono"), $this->input->post("observaciones"), $this->input->post("estatus")));
              break;
          }  
        }
        echo json_encode( $respuesta );
      }

} //LLAVE FIN 