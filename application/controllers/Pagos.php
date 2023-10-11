<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Pagos extends CI_Controller
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
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('4141', $_SERVER['HTTP_HOST']);
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

   public function revision_asimilados()
   {
     switch($this->session->userdata('id_rol')){
       case '31':
           $this->load->view('template/header');
           $this->load->view("pagos/revision_asimilados_intmex_view");
       break;

       default:
           $this->load->view('template/header');
           $this->load->view("pagos/revision_asimilados_view");
       break;
     }
   }



   public function acepto_internomex_asimilados(){
    $sol = $this->input->post('idcomision');  

     $consulta_comisiones = $this->Pagos_model->consulta_comisiones( $sol );
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

            $up_b = $this->Pagos_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
            $ins_b = $this->Pagos_model->insert_phc($data);

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

  

    public function getBonosPorUserContra($estado)
    {
  
      $dat = $this->Pagos_model->getBonosPorUserContra($estado);
      for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
    }


    public function bonos_historial()
    {
        $this->load->view('template/header');
        $this->load->view("pagos/bonos_historial_view");
    }

    

     public function getDatosNuevasAContraloria(){

      $proyecto = $this->input->post('proyecto');  

      $condominio = $this->input->post('condominio');  


      $dat =  $this->Pagos_model->getDatosNuevasAContraloria($proyecto,$condominio);
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }


    function despausar_solicitud(){
      $respuesta = array( FALSE );
      // <input type="hidden" name="value_pago" value="2">
      if($this->input->post("value_pago")){
        $validate = $this->input->post("value_pago");
    
        switch($validate){
            case 1:
              $respuesta = array($this->Pagos_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
            break;    
            case 2:
              $respuesta = array($this->Pagos_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
            break;
            case 3:
              $validate =  $this->Pagos_model->registroComisionAsimilados();
            // echo $validate->row()->registro_comision.' *COMISION'.$validate->row()->registro_comision;
            if($validate->row()->registro_comision == 7){
              $respuesta = FALSE;
               // echo 'no entra';
            }else{
              // echo 'si entra';
             $respuesta = array($this->Pagos_model->update_estatus_edit($this->input->post("id_pago_i"), $this->input->post("observaciones")));
           }
            break;
        }  
      }
      echo json_encode( $respuesta );
    }


    public function getComments($id_pago ){

      // $id_pago = $this->input->post("id_pago");
 

      echo json_encode($this->Pagos_model->getComments($id_pago));
  }
  
  public function revision_remanente()
  {
    switch($this->session->userdata('id_rol')){
      case '31':
          $this->load->view('template/header');
          $this->load->view("pagos/revision_remanente_intmex_view");
      break;

      default:
          $this->load->view('template/header');
          $this->load->view("pagos/revision_remanente_view");
      break;
    }
  }
  
  public function lista_usuarios(){
    $rol = $this->input->post("rol");
    $forma_pago = $this->input->post("forma_pago");
    $respuesta = $this->Pagos_model->get_lista_usuarios($rol,$forma_pago);
    echo json_encode($respuesta);
  }
  public function getDesarrolloSelectINTMEX(){

      $value = $this->input->post("desarrollo");
      if($value == ''){
      echo json_encode($this->Pagos_model->getDesarrolloSelectINTMEX()->result_array());
  
    }else{
      echo json_encode($this->Pagos_model->getDesarrolloSelectINTMEX($value)->result_array());
  
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

      $up_b = $this->Pagos_model->update_acepta_INTMEX($id_pago_i);
      $ins_b = $this->Pagos_model->insert_phc($data);

    if($up_b == true && $ins_b == true){
    $data_response = 1;
    echo json_encode($data_response);
    } else {
    $data_response = 0;
    echo json_encode($data_response);
    }
  }
  


  public function getPagosByProyect($proyect, $formap){
    if(empty($proyect)){
      echo json_encode($this->Pagos_model->getPagosByProyect());
  
    }else{
      echo json_encode($this->Pagos_model->getPagosByProyect($proyect,$formap));
  
    }
  }

  public function pago_internomex(){
    $id_pago_is = $this->input->post('idcomision');  

    $consulta_comisiones = $this->Pagos_model->consultaComisiones($id_pago_is);

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
            
            $up_b = $this->Pagos_model->update_acepta_INTMEX($id_pago_i);
            $ins_b = $this->Pagos_model->insert_phc($data);
      
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
  
  function refresh_solicitud(){
    $respuesta = array( FALSE );
    if($this->input->post("id_pago_i")){
       $respuesta = array( $this->Pagos_model->update_estatus_refresh( $this->input->post("id_pago_i")));
    }
    echo json_encode( $respuesta );
  }

  public function getReporteEmpresa(){
      echo json_encode($this->Pagos_model->report_empresa());
  }

  
  public function acepto_internomex_remanente(){
    $sol=$this->input->post('idcomision');  
    $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
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
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A    ' 
            );
             array_push($data,$row_arr);
          }
          // var_dump($id_pago_i );
          $id_pago_i = rtrim($id_pago_i, $sep);
            $arrayUpdateControlaria = array(
              'estatus' => 8,
              'modificado_por' => $id_user_Vl
            );
            $up_b = $this->Pagos_model->update_acepta_contraloria($arrayUpdateControlaria , $id_pago_i);
            $ins_b = $this->Pagos_model->insert_phc($data);
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
 
  public function getDatosNuevasRContraloria(){
    $proyecto = $this->input->post('proyecto');  
    $condominio =   $this->input->post('condominio');  
    $dat =  $this->Pagos_model->getDatosNuevasRContraloria($proyecto,$condominio);
    for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

  
 public function lista_roles()
 {
   echo json_encode($this->Pagos_model->get_lista_roles());
 }


  function getDatosDocumentos($id_comision, $id_pj){
    echo json_encode($this->Pagos_model->getDatosDocumentos($id_comision, $id_pj)->result_array());
  }

  public function getDatosFactura($uuid, $id_res){
    if($uuid){
        $consulta_sol = $this->Pagos_model->factura_comision($uuid, $id_res)->row();
        if (!empty($consulta_sol)) {
            $datos['datos_solicitud'] = $this->Pagos_model->factura_comision($uuid, $id_res)->row(); 
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
  

  public function revision_factura()
  {
    switch($this->session->userdata('id_rol')){
      case '31':
          $this->load->view('template/header');
          $this->load->view("pagos/revision_factura_intmex_view");
      break;

      default:
          $this->load->view('template/header');
          $this->load->view("pagos/revision_factura_view");
      break;
    }
  }

 
  function pausar_solicitud(){
    $respuesta = array( FALSE );
    if($this->input->post("id_pago")){
       $respuesta = array( $this->Comisiones_model->update_estatus_pausa( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
    }
    echo json_encode( $respuesta );
  }




    public function getDatosNuevasFContraloria(){
     $proyecto = $this->input->post("proyecto");
     $condominio = $this->input->post("condominio");
      $dat =  $this->Pagos_model->getDatosNuevasFContraloria($proyecto,$condominio)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
    }
    function pausar_solicitudM(){
      $respuesta = array( FALSE );
      if($this->input->post("id_pago")){
         $respuesta = array( $this->Pagos_model->update_estatus_pausaM( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
      }
      echo json_encode( $respuesta );
    }

    public function revision_xml()
    {
      switch($this->session->userdata('id_rol')){
        case '31':
            $this->load->view('template/header');
            $this->load->view("pagos/revision_xml_intmex_view");
        break;

        default:
            $this->load->view('template/header');
            $this->load->view("pagos/revision_xml_view");
        break;
      }
    }


  public function SubirPDF(){
    if($this->input->post('opc') == 3){
      $idpago = $this->input->post('id2');
    }
    elseif( $this->input->post('opc') == 2 ){
      //ya no aplica
      $uuid = $this->input->post('uuid2');
      $motivo = $this->input->post('motivo');
      $datos = $this->Pagos_model->RegresarFactura($uuid,$motivo);
      //echo $this->input->post('uuid2');
      if($datos == true){
        echo json_encode(1);
      }
      else{
        echo json_encode(0);
      }
    }
    else if($this->input->post('opc') == 1){
      $uploadFileDir = './UPLOADS/PDF/';
      date_default_timezone_set('America/Mexico_City');
      $datos = explode(".",$this->input->post('xmlfile'));
      $uuid = $this->input->post('uuid');
      $nombrefile = $datos[0];
      //$hoy = date("Y-m-d");
      $datos = $this->Pagos_model->BanderaPDF($uuid);
      $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
      $fileName = $_FILES['file-uploadE']['name'];
      $fileSize = $_FILES['file-uploadE']['size'];
      $fileType = $_FILES['file-uploadE']['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));
      $newFileName = $nombrefile . '.' . $fileExtension;
      $uploadFileDir = './UPLOADS/PDF/';
      $dest_path = $uploadFileDir . $newFileName;
      $dest_path = $uploadFileDir . $newFileName;
      move_uploaded_file($fileTmpPath, $dest_path);
      echo json_encode(1);
    }
    elseif($this->input->post('opc') == 4){
      $id_user = $this->input->post('id_user');
      $motivo = $this->input->post('motivo');
      $uuid =$this->input->post('uuid2');
      $datos = $this->Pagos_model->GetPagosFacturas($uuid)->result_array();
      $resultado = array("resultado" => TRUE);
      if( (isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
        $this->db->trans_begin();
        $responsable = $id_user;
        $resultado = TRUE;
        if( isset( $_FILES ) && !empty($_FILES) ){
          $config['upload_path'] = './UPLOADS/XMLS/';
          $config['allowed_types'] = 'xml';
          $this->load->library('upload', $config);
          $resultado = $this->upload->do_upload("xmlfile2");
          if( $resultado ){
            $xml_subido = $this->upload->data();
            $datos_xml = $this->Pagos_model->leerxml( $xml_subido['full_path'], TRUE );
            $nuevo_nombre = date("my")."_";
            $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
            $nuevo_nombre .= date("Hms")."_";
            $nuevo_nombre .= rand(4, 100)."_";
            $nuevo_nombre .= substr($datos_xml["uuidV"], -5)."_REFACTURA".".xml";
            rename( $xml_subido['full_path'], "./UPLOADS/XMLS/".$nuevo_nombre );
            $datos_xml['nombre_xml'] = $nuevo_nombre;
            for ($i=0; $i <count($datos) ; $i++) { 
              if(!empty($datos[$i]['id_comision'])){
                $id_com =  $datos[$i]['id_comision'];
                $this->Pagos_model->update_refactura($id_com, $datos_xml,$id_user,$datos[$i]['id_factura']);
                //$this->Comisiones_model->update_acepta_solicitante($id_com);
              $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'CONTRALORÍA REFACTURÓ, MOTIVO: ".$motivo." ')");
              }
            }
          }
          else{
            $resultado["mensaje"] = $this->upload->display_errors();
          }
        }
        if ( $resultado === FALSE || $this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $resultado = array("resultado" => FALSE);
        }
        else{
            $this->db->trans_commit();
            $resultado = array("resultado" => TRUE);
        }
      }
          //$this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
      if($resultado){
        echo json_encode( 1 );
      }else{
        echo json_encode(0);
      }
    }
    //$response = $this->Usuarios_modelo->SaveCumplimiento($this->session->userdata('id_usuario'),$newFileName);
  }

    public function getDatosNuevasXContraloria(){
      $proyecto = $this->input->post('proyecto');
      $condominio = $this->input->post('condominio');
      $dat =  $this->Pagos_model->getDatosNuevasXContraloria($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
          $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }
    
    public function GetDescripcionXML($xml){
      error_reporting(0);
      $xml=simplexml_load_file("".base_url()."UPLOADS/XMLS/".$xml."") or die("Error: Cannot create object");
      $cuantos = count($xml-> xpath('//cfdi:Concepto'));
      $UUID = $xml->xpath('//@UUID')[0];
      $fecha = $xml -> xpath('//cfdi:Comprobante')[0]['Fecha'];
      $folio = $xml -> xpath('//cfdi:Comprobante')[0]['Folio'];
      if($folio[0] == null){
        $folio = '*';
      }
      $total = $xml -> xpath('//cfdi:Comprobante')[0]['Total'];
      $cadena = '';
      for($i=0;$i< $cuantos; $i++ ){
        $cadena = $cadena .' '. $xml -> xpath('//cfdi:Concepto')[$i]['Descripcion']; 
      }
      $arr[0]= $UUID[0];
      $arr[1]=  $fecha[0];
      $arr[2]=  $folio[0];
      $arr[3]=  $total;
      $arr[4]=  $cadena;
      echo json_encode($arr);
    }



    public function cargaxml2($id_user = ''){

      $user =   $usuarioid =$this->session->userdata('id_usuario');
      $this->load->model('Usuarios_modelo');
    
      if(empty($id_user)){
        $RFC = $this->Usuarios_modelo->getPersonalInformation()->result_array();
    
      }else{
        $RFC = $this->Usuarios_modelo->getPersonalInformation2($id_user)->result_array();
    
      }
     
    $respuesta = array( "respuesta" => array( FALSE, "HA OCURRIDO UN ERROR") );
    if( isset( $_FILES ) && !empty($_FILES) ){
        $config['upload_path'] = './UPLOADS/XMLS/';
        $config['allowed_types'] = 'xml';
        //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
        $this->load->library('upload', $config);
        if( $this->upload->do_upload("xmlfile") ){
            $xml_subido = $this->upload->data()['full_path'];
            $datos_xml = $this->Pagos_model->leerxml( $xml_subido, TRUE );
            if( $datos_xml['version'] >= 3.3){
              $responsable_factura = $this->Pagos_model->verificar_uuid( $datos_xml['uuidV'] );
              if($responsable_factura->num_rows()>=1){
                $respuesta['respuesta'] = array( FALSE, "ESTA FACTURA YA SE SUBIÓ ANTERIORMENTE AL SISTEMA");
              }
              else{
    
                if($datos_xml['rfcreceptor'][0]=='ICE211215685'){//VALIDAR UNIDAD
           
                if($datos_xml['claveProdServ'][0]=='80131600' || (($user == 6578 || $user == 11180 || $user == 11759) && $datos_xml['claveProdServ'][0]=='83121703')){//VALIDAR UNIDAD
                  $diasxmes = date('t');
                   $fecha1 = date('Y-m-').'0'.(($diasxmes - $diasxmes) +1);
                   $fecha2 = date('Y-m-').$diasxmes;
                  if($datos_xml['fecha'][0] >= $fecha1 && $datos_xml['fecha'][0] <= $fecha2){
    
                if($datos_xml['rfcemisor'][0] == $RFC[0]['rfc']){
                if($datos_xml['regimenFiscal'][0]=='612' || ( ($user == 6578 || $user == 11180 || $user == 11759) && $datos_xml['regimenFiscal'][0]=='601')){//VALIDAR REGIMEN FISCAL
                if($datos_xml['formaPago'][0]=='03' || $datos_xml['formaPago'][0]=='003'){//VALIDAR FORMA DE PAGO Transferencia electrónica de fondos
                if($datos_xml['usocfdi'][0]=='G03'){//VALIDAR USO DEL CFDI
                if($datos_xml['metodoPago'][0]=='PUE'){//VALIDAR METODO DE PAGO
                if($datos_xml['claveUnidad'][0]=='E48'){//VALIDAR UNIDAD
                  $respuesta['respuesta'] = array( TRUE );
                  $respuesta['datos_xml'] = $datos_xml;
                }else{
                  $respuesta['respuesta'] = array( FALSE, "LA UNIDAD NO ES 'E48 (UNIDAD DE SERVICIO)', VERIFIQUE SU FACTURA.");
                }//FINAL DE UNIDAD
                }else{
                  $respuesta['respuesta'] = array( FALSE, "EL METODO DE PAGO NO ES 'PAGO EN UNA SOLA EXHIBICIÓN (PUE)', VERIFIQUE SU FACTURA.");
                }//FINAL DE METODO DE PAGO
                }else{
                  $respuesta['respuesta'] = array( FALSE, "EL USO DEL CFDI NO ES 'GASTOS EN GENERAL (G03)', VERIFIQUE SU FACTURA.");
                }//FINAL DE USO DEL CFDI
                }else{
                  $respuesta['respuesta'] = array( FALSE, "LA FORMA DE PAGO NO ES 'TRANSFERENCIA ELECTRÓNICA DE FONDOS (03)', VERIFIQUE SU FACTURA.");
                }//FINAL DE FORMA DE PAGO
                }else{
                  $respuesta['respuesta'] = array( FALSE, "EL REGIMEN NO ES, 'PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES (612)");
                }//FINAL DE REGIMEN FISCAL
                }else{
                $respuesta['respuesta'] = array( FALSE, "ESTA FACTURA NO CORRESPONDE A TU RFC.");
                }//FINAL DE RFC VALIDO
              }else{
                $respuesta['respuesta'] = array( FALSE, "FECHA INVALIDA, SOLO SE ACEPTAN FACTURAS CON FECHA DE ESTE MES, VERIFICA TU XML");
              }          
                }else{
                $respuesta['respuesta'] = array( FALSE, "LA CLAVE DE TU FACTURA NO CORRESPONDE A 'VENTA DE PROPIEDADES Y EDIFICIOS' (80131600).");
              }
    
              }else{
                $respuesta['respuesta'] = array( FALSE, "EL RFC NO CORRESPONDE A INTERNOMEX, DEBE SER ICE211215685");
              }
    
            }
            }else{
              $respuesta['respuesta'] = array( FALSE, "LA VERSION DE LA FACTURA ES INFERIOR A LA 3.3, SOLICITE UNA REFACTURACIÓN");
            }
            unlink( $xml_subido );
          }
          else{
            $respuesta['respuesta'] = array( FALSE, $this->upload->display_errors());
          }
        }
        echo json_encode( $respuesta );
      }

      public function carga_listado_factura(){
        echo json_encode( $this->Pagos_model->get_solicitudes_factura( $this->input->post("idResidencial"), $this->input->post("id_usuario") ) );
    }

    function enviar_solicitud(){
      $respuesta = array( FALSE );
      if($this->input->post("id_usuario")){
         $respuesta = array( $this->Comisiones_model->update_estatus_facturas( $this->input->post("id_usuario"), $this->input->post("id_residencial")));
      }
      echo json_encode( $respuesta );
    }
    
    public function pagosExtranjero()
    {
      switch($this->session->userdata('id_rol')){
          case '31':
            $this->load->view('template/header');
        
            $this->load->view("pagos/pagos_extranjero_intmex_view");
            break;

        default:
            $this->load->view('template/header');
            $this->load->view("pagos/pagos_extranjero_view");
        break;
      }

    }

    public function getDatosNuevasEContraloria(){
      $proyecto =  $this->input->post("proyecto");
      $condominio =  $this->input->post("condominio");
      $dat =  $this->Pagos_model->getDatosNuevasEContraloria($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }

    public function nueva_mktd_comision(){

      $respuesta = "";
  
      $valores_pagos =  $this->input->post("valores_pago_i");
      $values_send = $valores_pagos;
      $num_plan =  $this->input->post("num_plan");
      $array_up = explode(",", $valores_pagos);
  
        $abono_mktd = $this->input->post("abono_mktd[]");
        $pago_mktd = $this->input->post("pago_mktd");
        $empresa = $this->input->post("empresa");
        $id_usuario = $this->input->post("user_mktd[]");
     
      for($i=0;$i<sizeof($abono_mktd);$i++){
        if($abono_mktd[$i] > 0){
        $respuesta =  $this->Pagos_model->nueva_mktd_comision($values_send,$id_usuario[$i],$abono_mktd[$i],$pago_mktd,$this->session->userdata('id_usuario'), $num_plan,$empresa);
        }
      }
  
       for($i=0;$i<sizeof($array_up);$i++){
        $respuesta =  $this->Pagos_model->updatePagoInd($array_up[$i]);
        // echo $array_up[$i];
       }
      
  
       
    echo json_encode($respuesta);
    }

    public function revision_mktd()
    {
      switch($this->session->userdata('id_rol')){
        case '31':
            $this->load->view('template/header');
            $this->load->view("pagos/revision_intmexmktd_view");
        break;

        default:
            $this->load->view('template/header');
            $this->load->view("pagos/revision_mktd_view");
        break;
      }

    }
    public function getComprobantesExtranjero()
    {
        $data = $this->Pagos_model->getComprobantesExtranjero();
        echo json_encode(array('data' => $data));
    }

    public function save_new_mktd(){

      $respuesta = array( FALSE );
      if($this->input->post("fecha_inicio")){
    
       // echo "si entro";
       
       $fecha_inicio = $this->input->post("fecha_inicio");
       $arrayuser = $this->input->post("userMKTDSelect[]");
       $puesto = $this->input->post("puesto[]");
       $arrayporc = $this->input->post("porcentajeUserMk[]");
       $arrayplaza = $this->input->post("plazaMKTDSelect[]");
       $arraysede = $this->input->post("sedeMKTDSelect[]");
       $arrayestatus = $this->input->post("estatusMk[]");
     
      $query_max = $this->db->query("SELECT MAX(numero_plan) AS nummax FROM porcentajes_mktd");
      $new_max = intval($query_max->row()->nummax)+1;
    
    
      $query_max = $this->db->query("UPDATE planes_mktd SET fin_plan = '".$fecha_inicio."' WHERE id_plan = ".($new_max-1)."");
      $query_max = $this->db->query("INSERT INTO planes_mktd (fecha_plan, fin_plan, fecha_creacion) VALUES('".$fecha_inicio."', NULL, GETDATE())");
      $id = $this->db->insert_id();
    
    
       for($i=0;$i<sizeof($arrayuser);$i++){
         if($arraysede[$i]=='2' AND $puesto[$i]!='19' AND $puesto[$i]!='20'){
          $this->db->query("INSERT INTO porcentajes_mktd(numero_plan, id_sede, id_plaza, id_usuario, porcentaje, fecha_inicio, estatus, activo, fecha_creacion, rol) VALUES (".$id.", 0, ".$arrayplaza[$i].", ".$arrayuser[$i].", ".$arrayporc[$i].", '".$fecha_inicio."', 1, 1, GETDATE(), '".$puesto[$i]."')");
    
         }
         else{
          $this->db->query("INSERT INTO porcentajes_mktd(numero_plan, id_sede, id_plaza, id_usuario, porcentaje, fecha_inicio, estatus, activo, fecha_creacion, rol) VALUES (".$id.", ".$arraysede[$i].", ".$arrayplaza[$i].", ".$arrayuser[$i].", ".$arrayporc[$i].", '".$fecha_inicio."', 1, 1, GETDATE(),'".$puesto[$i]."')");
         }
    
     
      }
     
     
       $respuesta = array( TRUE );
    
    
    }
    echo json_encode( $respuesta );
      }

      public function getFormasPago()
      {
          $data = $this->Pagos_model->getFormasPago();
          echo json_encode($data);
      }

      public function enviadas_internomex()
      {
        $this->load->view('template/header');
        $this->load->view("pagos/enviadas_intmex_view");
      }
  
      public function getDatosEnviadasInternomex(){
        $proyecto = $this->input->post("proyecto");
        $condominio = $this->input->post("condominio");
        $formaPago = $this->input->post("formaPago");
        $dat =  $this->Pagos_model->getDatosEnviadasInternomex($proyecto, $condominio, $formaPago)->result_array();
        for( $i = 0; $i < count($dat); $i++ ){
          $dat[$i]['pa'] = 0;
        }
        echo json_encode( array( "data" => $dat));
      }
      

      public function revision_especial()
      {
        switch($this->session->userdata('id_rol')){
          case '31':
              $this->load->view('template/header');
              $this->load->view("pagos/revision_remanente_intmex_view");
          break;
          default:
            $this->load->view('template/header');
            $this->load->view("pagos/revision_especial_view");
          break;
        }
  
      }


      public function acepto_internomex_especial(){
        $this->load->model("Comisiones_model");
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
       
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
                  'comentario' =>  'CONTRALORÍA MARCO COMO PAGADA' 
                );
                 array_push($data,$row_arr);
    
    
              }
              $id_pago_i = rtrim($id_pago_i, $sep);
          
                $up_b = $this->Pagos_model->update_contraloria_especial($id_pago_i);
                $ins_b = $this->Pagos_model->insert_phc($data);
          
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

      public function getDatosEspecialRContraloria(){
        $dat =  $this->Pagos_model->getDatosEspecialRContraloria()->result_array();
       for( $i = 0; $i < count($dat); $i++ ){
           $dat[$i]['pa'] = 0;
       }
       echo json_encode( array( "data" => $dat));
      }
  
      public function getHistorialAbono2($id)
      {
        echo json_encode($this->Pagos_model->getHistorialAbono2($id)->result_array());
      }

      public function getCommissionsByMktdUser(){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $estatus = $this->input->post("estatus");
            $data['data'] = $this->Pagos_model->getCommissionsByMktdUser($estatus,$typeTransaction, $beginDate, $endDate, $where)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }


    public function getEstatusPagosMktd()
    {
      $datos = $this->Pagos_model->getEstatusPagosMktd();
      if ($datos != null) {
        echo json_encode($datos);
      } else {
        echo json_encode(array());
      }
    }

    public function getDatosRevisionMktd2($mes=0,$anio=0,$estatus=0){

      if($mes == 0 ){
        $dat =  $this->Pagos_model->getDatosRevisionMktd2()->result_array();
      }else{
  
        if($mes < 10){
          $mes = '0'.$mes;
        }
  
        $dat =  $this->Pagos_model->getDatosRevisionMktd2($mes,$anio,$estatus)->result_array();
      }
  
      //print_r($dat);
  
  
     for( $i = 0; $i < count($dat); $i++ ){
      $comentario='BONO NUSKAH - MKTD 5 MENSUALIDADES';
      $comentario2='BONO MARKETING - COMISIONES SIN EVIDENCIA DISPERSADO A 12 MESES ENTRE TODOS LOS INVOLUCRADOS';
  
      if($mes == 0 && $anio == 0 && $estatus == 0){
        $BonoPagado2 = $this->Pagos_model->getBonoXUser2($dat[$i]['id_usuario'],$comentario)->result_array();
        $BonoPagado3 = $this->Pagos_model->getBonoXUser2($dat[$i]['id_usuario'],$comentario2)->result_array();
  
      }else{
        
        $BonoPagado2 = $this->Pagos_model->getBonoXUser2($dat[$i]['id_usuario'],$comentario,$mes,$anio,$estatus)->result_array();
        $BonoPagado3 = $this->Pagos_model->getBonoXUser2($dat[$i]['id_usuario'],$comentario2,$mes,$anio,$estatus)->result_array();
  
      }
     if(count($BonoPagado2) == 0){
      $dat[$i]['nus'] = 0;
  
     }else{
      $dat[$i]['nus'] = $BonoPagado2[0]['impuesto1'];
  
     }
  
  
  
  
      if(count($BonoPagado3) == 0){
        $dat[$i]['mktd'] = 0;
    
       }else{
        $dat[$i]['mktd'] = $BonoPagado3[0]['impuesto1'];
    
       }
      //$dat[$i]['mktd'] = $BonoPagado3[0]['impuesto1'];
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }


    function getDatosSumaMktd($sede, $plen, $empresa, $res){
      echo json_encode($this->Pagos_model->getDatosSumaMktd($sede, $plen, $empresa, $res)->result_array());
    }

    public function getDatosRevisionMktd(){
      $dat =  $this->Pagos_model->getDatosRevisionMktd()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
  
     
    public function acepto_contraloria_MKTD(){
      $this->load->model("Comisiones_model");
      $sol=$this->input->post('idcomision');  
      $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where estatus = 13");
     
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
        
              $up_b = $this->Comisiones_model->update_acepta_contraloria($id_pago_i);
              $up_c = $this->Comisiones_model->update_mktd_contraloria($id_pago_i);
              $ins_b = $this->Comisiones_model->insert_phc($data);
        
        if($up_b == true && $up_c == true && $ins_b == true){
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
    
    function getDatosColabMktd($sede, $plan){
      echo json_encode($this->Pagos_model->getDatosColabMktd($sede, $plan)->result_array());
    }


    public function getDatosNuevasmkContraloria(){
      $dat =  $this->Pagos_model->getDatosNuevasmkContraloria()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }



    public function getCommissionsByMktdUserReport(){
      if (isset($_POST) && !empty($_POST)) {
          $typeTransaction = $this->input->post("typeTransaction");
          $fechaInicio = explode('/', $this->input->post("beginDate"));
          $fechaFin = explode('/', $this->input->post("endDate"));
          $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
          $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
          $where = $this->input->post("where");
          $estatus = $this->input->post("estatus");
          $data['data'] = $this->Pagos_model->getCommissionsByMktdUserReport($estatus,$typeTransaction, $beginDate, $endDate, $where)->result_array();
          echo json_encode($data);
      } else {
          json_encode(array());
      }
  }


  public function getMktdRol(){
    echo json_encode($this->Pagos_model->getMktdRol()->result_array());
  }
  

  public function getLotesOrigenmk($user)
  {
    echo json_encode($this->Pagos_model->getLotesOrigenmk($user)->result_array());
  }



  public function getInformacionDataMK($lote)
  {
    echo json_encode($this->Pagos_model->getInformacionDataMK($lote)->result_array());
  }





  public function saveDescuentoMK($valor)
  {

 
  $datos =  $this->input->post("idloteorigen[]");
  $descuento = $this->input->post("monto");
  $usuario = $this->input->post("usuarioid");
  $comentario = $this->input->post("comentario");
  $pagos_aplica = 0;
  

    $cuantos = count($datos);
 
    if($cuantos > 1){
     // echo var_dump( $datos);

      $sumaMontos = 0;
      for($i=0; $i <$cuantos ; $i++) { 
        
        if($i == $cuantos-1){

          $formatear = explode(",",$datos[$i]);
          $id = $formatear[0]; 
          $monto = $formatear[1];
          $pago_neodata = $formatear[2];

         $montoAinsertar = $descuento - $sumaMontos;
         $Restante = $monto - $montoAinsertar;

 

         $comision = $this->Pagos_model->obtenerIDMK($id)->result_array();
 
          $dat =  $this->Pagos_model->update_descuentoMK($id,$montoAinsertar,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_aplica);
          $dat =  $this->Pagos_model->insertar_descuentoMK($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor, $comision[0]['id_list'],$comision[0]['empresa']);
         
        }else{

          $formatear = explode(",",$datos[$i]);
           $id=$formatear[0];
          $monto = $formatear[1]; 
 
         $dat = $this->Pagos_model->update_descuentoMK($id,0,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario, $pagos_aplica);
         $sumaMontos = $sumaMontos + $monto;
        }

  
      }
 

    }else{

      // echo "entra a else 2";
         $formatear = explode(",",$datos[0]);
         $id = $formatear[0];
         $monto = $formatear[1];
         $pago_neodata = $formatear[2];
         $montoAinsertar = $monto - $descuento;
         $Restante = $monto - $montoAinsertar;

         $comision = $this->Pagos_model->obtenerIDMK($id)->result_array();
          
          $dat =  $this->Pagos_model->update_descuentoMK($id,$descuento,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario,0);
          $dat =  $this->Pagos_model->insertar_descuentoMK($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor, $comision[0]['id_list'],$comision[0]['empresa']);
 

    }
    echo json_encode($dat);
    
    
    }
 






    public function pago_internomex_MKTD(){
      $this->load->model("Comisiones_model");
      $sol=$this->input->post('idcomision');  
      $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where estatus = 8 AND id_usuario = 4394");
     
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
                'comentario' =>  'INTERNOMEX APLICO PAGO' 
              );
               array_push($data,$row_arr);
            }
            $id_pago_i = rtrim($id_pago_i, $sep);
        
              $up_b = $this->Pagos_model->update_acepta_INTMEX($id_pago_i);
              $up_b = $this->Pagos_model->update_mktd_INTMEX($id_pago_i);
              $ins_b = $this->Pagos_model->insert_phc($data);
        
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



}

