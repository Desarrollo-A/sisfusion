<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Casas_comisiones extends CI_Controller
{
  private $gph;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Casas_comisiones_model');
    // $this->load->model('Comisiones_model');
    // $this->load->model('Contratacion_model');
    // $this->load->model('asesor/Asesor_model');
    // $this->load->model('Usuarios_modelo');
    // $this->load->model('PagoInvoice_model');
    // $this->load->model('General_model');
    // $this->load->model('Seguro_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('3030', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
    
   }

  public function index(){
    redirect(base_url());
  }
  

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }
  
  
  // public function solicitudes_casas_comisiones(){
  //   $datos = array();
  //   $datos["opn_cumplimiento"] = $this->Casas_comisiones_model->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
  //   $this->load->view('template/header');
  //   switch($this->session->userdata('id_rol')){
  //     case '1':
  //     case '2':
  //       if (in_array($this->session->userdata('id_usuario'),[13546, 13549, 13589])) // ALEJANDRO GONZÁLEZ DÁVALOS
  //         $this->load->view("casas_comisiones/solicitudes_casas_comisiones", $datos);
  //       else
  //       //   $this->load->view("ventas/comisiones_colaboradorRigel", $datos);
  //     break;
  //     default:
  //         $this->load->view("casas_comisiones/solicitudes_casas_comisiones", $datos);
  //     break;
  //   }
  // }

  public function historial_casas_comisiones()
  {
    $this->load->view('template/header');
    $this->load->view("casas_comisiones/historial_casas_comisiones");    
  }

  public function getTotalComisionAsesor()
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Comisiones_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }

  public function insertar_codigo_postal(){
    $cp = $this->input->post('cp');
    $nuevoCp = $this->input->post('nuevoCp');
    $respuesta = $this->Solicitudes_casas_model->insertar_codigo_postal($cp, $nuevoCp);
  }
  

  public function consulta_codigo_postal(){
    $resolt = $this->Solicitudes_casas_comisiones->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
    echo json_encode($resolt);
  }

  public function SubirPDFExtranjero($id = '')
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $nombre = $this->session->userdata('nombre');
        $opc = 0;

        if ($id != '') {
            $opc = 1;
            $id_usuario = $this->input->post("id_usuario");
            $nombre = $this->input->post("nombre");
        }

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");


        $fileTmpPath = $_FILES['file-upload-extranjero']['tmp_name'];
        $fileName = $_FILES['file-upload-extranjero']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $nombre . $hoy . md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './static/documentos/extranjero/';

        $dest_path = $uploadFileDir . $newFileName;
        move_uploaded_file($fileTmpPath, $dest_path);


        $response = $this->Casas_comisiones_model->SaveCumplimiento($id_usuario, $newFileName, $opc);
        echo json_encode($response);
    }

  public function getFechaCorteActual(){
    $tipoUsuario =  $this->session->userdata('tipo');
    $diaActual = date('d'); 
    $data = array(
      "fechasCorte" => $this->Casas_comisiones_model->getFechaCorteActual($tipoUsuario,$diaActual)
      );
    echo json_encode($data);
  }

  public function lista_proyecto() {
    $this->validateSession();
    echo json_encode($this->Casas_comisiones_model->get_proyecto_lista()->result_array());
  }
  // Revisar despues la modificacion
  public function lista_condominio($proyecto) {
    $this->validateSession();
      echo json_encode($this->Contratacion_model->get_condominio_lista($proyecto)->result_array());
  }
  // 

  public function acepto_comisiones_user(){
    $formaPagoInvalida = [2,3,4,5];
    $diaActual = date('d'); 
    $id_user_Vl = $this->session->userdata('id_usuario');
    $formaPagoUsuario = $this->session->userdata('forma_pago');
    $sol=$this->input->post('idcomision');  
    $consulta_comisiones = $this->db->query("SELECT pci.id_pago_i FROM pago_comision_ind pci LEFT JOIN usuarios u ON u.id_usuario=pci.id_usuario WHERE pci.id_pago_i IN (".$sol.")");
    $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 ELSE 0 END) tipo,forma_pago FROM usuarios WHERE id_usuario IN (".$id_user_Vl.")")->result_array();

    if(in_array($consultaTipoUsuario[0]['forma_pago'],$formaPagoInvalida)){ //EL COMISIONISTA SI TIENE UNA FORMA DE PAGO VALIDA Y CONTINUA CON EL PROCESO DE ENVIO DE COMISIONES
      $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
      $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
      $filtro = ($consultaTipoUsuario[0]['tipo'] == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($consultaTipoUsuario[0]['forma_pago'] == 2 && $consultaTipoUsuario[0]['tipo'] == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
      $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND corteOoam = ".$consultaTipoUsuario[0]['tipo']." AND mes = $mesActual  $filtro")->result_array();
      $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;
      
      if( $consulta_comisiones->num_rows() > 0 && $consultaFechasCorte ){
        $validar_sede = $this->session->userdata('id_sede');
        $fecha_actual = strtotime($obtenerFechaSql);
        $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
        $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
        
        if($formaPagoUsuario == 3){
          $consultaCP = $this->Solicitudes_casas_model->consulta_codigo_postal($id_user_Vl)->result_array();
        }

        if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) || ($id_user_Vl == 7689)){
          if( $formaPagoUsuario == 3 && ( $this->input->post('cp') == '' || $this->input->post('cp') == 'undefined' ) ){
            $data_response = 3;
            echo json_encode($data_response);
          } else if( $formaPagoUsuario == 3 && ( $this->input->post('cp') != '' || $this->input->post('cp') != 'undefined' ) &&  $consultaCP[0]['estatus'] == 0 ){
            $data_response = 4;
            echo json_encode($data_response);
          } else{
            $consulta_comisiones = $consulta_comisiones->result_array();
            $sep = ',';
            $id_pago_i = '';
            $data=array();
            $pagoInvoice = array();

            foreach ($consulta_comisiones as $row) {
              $id_pago_i .= implode($sep, $row);
              $id_pago_i .= $sep;

              $row_arr=array(
                'id_pago_i' => $row['id_pago_i'],
                'id_usuario' =>  $id_user_Vl,
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'estatus' => 1,
                'comentario' =>  'COLABORADOR ENVÍO A CONTRALORÍA' 
              );
              array_push($data,$row_arr);

              if ($formaPagoUsuario == 5) { // Pago extranjero
                $pagoInvoice[] = array(
                  'id_pago_i' => $row['id_pago_i'],
                  'nombre_archivo' => $opinionCumplimiento->archivo_name,
                  'estatus' => 1,
                  'modificado_por' => $id_user_Vl,
                  'fecha_registro' => date('Y-m-d H:i:s')
                );
              }
            }

            $id_pago_i = rtrim($id_pago_i, $sep);
            $up_b = $this->Casas_comisiones_model->update_acepta_solicitante($id_pago_i);
            $ins_b = $this->Casas_comisiones_model->insert_phc($data);
            $this->Casas_comisiones_model->changeEstatusOpinion($id_user_Vl);
            if ($formaPagoUsuario == 5) {
              $this->Casas_comisiones_model->insertMany($pagoInvoice);
            }
              
            if($up_b == true && $ins_b == true){
              $data_response = 1;
              echo json_encode($data_response);
            } else {
              $data_response = 0;
              echo json_encode($data_response);
            } 
          }
        } else {
          $data_response = 2;
          echo json_encode($data_response);
        }
      } else{
        $data_response = 0;
        echo json_encode($data_response);
      }
    }else{ //EL COMISIONISTA NO TIENE UNA FORMA DE PAGO VALIDA Y TERMINA CON EL PROCESO DE ENVIO DE COMISIONES
      $data_response = 5;
      echo json_encode($data_response);
    } 
  }

  public function getDatosComisionesAsesor($a)
  {
    $dat =  $this->Casas_comisiones_model->getDatosComisionesAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
      $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
  }

  // Revisar después la modificacion ---------------------------------
  public function getGeneralStatusFromNeodata($proyecto, $condominio){
  
    $this->load->model('ComisionesNeo_model');
  
    $datos = $this->ComisionesNeo_model->getLotesByAdviser($proyecto, $condominio);
    if(COUNT($datos) > 0){
      $data = array();
      $final_data = array();
      $contador = 0;
      for($i = 0; $i < COUNT($datos); $i++){
        $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
        $final_data[$contador] = $this->ComisionesNeo_model->getLoteInformation($datos[$i]['idLote']);
        $final_data[$contador]->reason = $data[$i]->Marca;
        $contador ++;
        }
      if (COUNT($final_data) > 0) {
          echo json_encode(array("data" => $final_data));
      } else {
          echo json_encode(array("data" => ''));
      }
    }
      else{
        echo json_encode(array("data" => ''));
      }
  }
  // ----------------------------------------------------------------

  public function EnviarDesarrollos(){
    if($this->input->post("desarrolloSelect2") == 1000){
      $formaPago = $this->Casas_comisiones_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
      if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
          $respuesta = $this->Casas_comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,1);
        }else{
          $respuesta = $this->Casas_comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,2);
        }
    }else{
      $formaPago = $this->Casas_comisiones_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
      if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
        $respuesta = $this->Casas_comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),3);
      }else{
        $respuesta = $this->Casas_comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),4);
      }
    }
    echo json_encode($respuesta);
  }

  function getDatosProyecto($idlote,$id_usuario = ''){
    if($id_usuario == ''){
      echo json_encode($this->Casas_comisiones_model->getDatosProyecto($idlote)->result_array());
  
    }else{
      echo json_encode($this->Casas_comisiones_model->getDatosProyecto($idlote,$id_usuario)->result_array());
  
    }
  }

  public function cargaxml2($id_user = ''){

    $user =   $usuarioid =$this->session->userdata('id_usuario');
    $this->load->model('Usuarios_modelo');
  
    if(empty($id_user)){
      // Se revisa despues para cambiar----------------------------------------------------
      $RFC = $this->Usuarios_modelo->getPersonalInformation()->result_array();
  
    }else{
      $RFC = $this->Usuarios_modelo->getPersonalInformation2($id_user)->result_array();
  
    }

    // -----------------------------------------------------------------------------------
   
    $respuesta = array( "respuesta" => array( FALSE, "HA OCURRIDO UN ERROR") );
    if( isset( $_FILES ) && !empty($_FILES) ){
        $config['upload_path'] = './UPLOADS/XMLS/';
        $config['allowed_types'] = 'xml';
        //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
        $this->load->library('upload', $config);
        if( $this->upload->do_upload("xmlfile") ){
            $xml_subido = $this->upload->data()['full_path'];
            $datos_xml = $this->Solicitudes_casas_model->leerxml( $xml_subido, TRUE );
            if( $datos_xml['version'] >= 3.3){
              $responsable_factura = $this->Solicitudes_casas_model->verificar_uuid( $datos_xml['uuidV'] );
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
                  $respuesta['respuesta'] = array( FALSE, "LA UNIDAD NO ES 'E48 (UNIDAD DE SERVICIO)', VERIFIQUE SU FACTURA.");
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
 
 function borrar_factura(){
  $respuesta = array( FALSE );
  if($this->input->post("delete_fact")){
     $respuesta = array( $this->Solicitudes_casas_model->borrar_factura( $this->input->post("delete_fact")));
  }
  echo json_encode( $respuesta );
  }

  public function guardar_solicitud2($usuario = ''){
    if($usuario != ''){
      $usuarioid = $usuario;
    }else{
      $usuarioid = $this->session->userdata('id_usuario');
    }
    $validar_sede =  $this->session->userdata('id_sede');


    $diaActual = date('d'); 
    $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 ELSE 0 END) tipo,forma_pago FROM usuarios WHERE id_usuario IN (".$this->session->userdata('id_usuario').")")->result_array();
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $filtro = ($consultaTipoUsuario[0]['tipo'] == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($consultaTipoUsuario[0]['forma_pago'] == 2 && $consultaTipoUsuario[0]['tipo'] == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE corteOoam = ".$consultaTipoUsuario[0]['tipo']." AND mes = $mesActual  $filtro")->result_array();


    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
    $fecha_actual = strtotime($obtenerFechaSql);
    $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
    $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
    
    if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) ) {
      

      $datos = explode(",",$this->input->post('pagos'));
      $resultado = array("resultado" => TRUE);
      if((isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
        $this->db->trans_begin();
        $resultado = TRUE;
        
        if( isset( $_FILES ) && !empty($_FILES) ){
          $config['upload_path'] = './UPLOADS/XMLS/';
          $config['allowed_types'] = 'xml';
          $this->load->library('upload', $config);
          $resultado = $this->upload->do_upload("xmlfile");
          
          if( $resultado ){
            $xml_subido = $this->upload->data();
            $datos_xml = $this->Solicitudes_comisiones_model->leerxml( $xml_subido['full_path'], TRUE );
            $total = (float)$this->input->post('total');
            $totalXml = (float)$datos_xml['total'];
            
            if (($total + .50) >= $totalXml && ($total - .50) <= $totalXml) {
              $nuevo_nombre = date("my")."_";
              $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
              $nuevo_nombre .= date("Hms")."_";
              $nuevo_nombre .= rand(4, 100)."_";
              $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
              rename( $xml_subido['full_path'], "./UPLOADS/XMLS/".$nuevo_nombre );
              $datos_xml['nombre_xml'] = $nuevo_nombre;
              ini_set('max_execution_time', 0);
              for ($i=0; $i <count($datos) ; $i++) { 
                if(!empty($datos[$i])){
                  $id_com =  $datos[$i];
                  $this->Solicitudes_casas_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                  $this->Solicitudes_casas_model->update_acepta_solicitante($id_com);
                  $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A CONTRALORÍA')");
                }
              }
            } else {
              $this->db->trans_rollback();
              echo json_encode(4);
              return;
            }
          } else{
            $resultado["mensaje"] = $this->upload->display_errors();
          }
        }
        
        if($resultado === FALSE || $this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $resultado = array("resultado" => FALSE);
        }else{
          $this->db->trans_commit();
          $resultado = array("resultado" => TRUE);
        }
      }
      // Se queda pendiente para cambiar
      $this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
      // ---------------------------------
      echo json_encode( $resultado );
    }else{
      echo json_encode(3);
    }
  }

  // ----------------------------- controlador de historial_casas --------------------------------

  public function nombreTipo(){
    $this->validateSession();
    echo json_encode($this->Contratacion_model->getNombreTipo()->result_array());
  }

  public function getDatosHistorialPago($proyecto = null,$condominio = null, $tipo= null ) {      
    $dat =  $this->Casas_comisiones_model->getDatosHistorialPago($proyecto,$condominio,$tipo)->result_array();
    echo json_encode( array( "data" => $dat));
  }

  public function getDatosHistorialCancelacion($proyecto,$condominio){
    $dat =  $this->Casas_comisiones_model->getDatosHistorialCancelacion($proyecto,$condominio)->result_array();
    echo json_encode( array( "data" => $dat));
  }
  
  function despausar_solicitud(){
    $respuesta = array( FALSE );
    // <input type="hidden" name="value_pago" value="2">
    if($this->input->post("value_pago")){
      $validate = $this->input->post("value_pago");
  
      switch($validate){
        case 1:
          $respuesta = array($this->Casas_omisiones_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
          break;
  
          case 2:
          $respuesta = array($this->Casas_comisiones_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
          break;
  
          case 3:
  
          $validate =  $this->db->query("SELECT registro_comision from lotes l where l.idLote in (select c.id_lote from comisiones c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_comision_ind p WHERE p.id_pago_i = ".$this->input->post("id_pago_i")."))");
  
          // echo $validate->row()->registro_comision.' *COMISION'.$validate->row()->registro_comision;
          if($validate->row()->registro_comision == 7){
            $respuesta = FALSE;
             // echo 'no entra';
          }else{
            // echo 'si entra';
           $respuesta = array($this->Casas_comisiones_model->update_estatus_edit($this->input->post("id_pago_i"), $this->input->post("observaciones")));
         }
          break;
      }  
    }
    echo json_encode( $respuesta );
  }

  function inforReporteAsesor(){
  $id_asesor = $this->session->userdata('id_usuario');

    $data['data']= $this->Casas_comisiones_model->inforReporteAsesor($id_asesor);
    if ($data != null) {
      echo json_encode($data);
    } else {
      echo json_encode(array());
    }
    exit;
  }

  public function getAllComisionesByUser(){
    $user = $this->session->userdata('id_usuario');
    $year = $_POST['anio'];
    $data = $this->Suma_model->getAllComisionesByUser($user, $year);
    echo json_encode($data);
  }

  public function getHistorialDescuentosPorUsuario() {      
    echo json_encode(array( "data" => $this->Casas_comisiones_model->getHistorialDescuentosPorUsuario()));
  }

}