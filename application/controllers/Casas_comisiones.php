<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Casas_comisiones extends CI_Controller
{
  private $gph;
  public $hoy,$creadoPor;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Casas_comisiones_model');
    // $this->load->model('Comisiones_model');
    $this->load->model('Contratacion_model');
    // $this->load->model('asesor/Asesor_model');
    $this->load->model('Usuarios_modelo');
    // $this->load->model('PagoInvoice_model');
    $this->load->model('General_model');
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
    $this->hoy = date("Y-m-d H:i:s");
    $this->creadoPor = $this->session->userdata('id_usuario');
   }

  public function index(){
    redirect(base_url());
  }
  

  public function dispersionBonos(){
    $this->load->view('template/header');
    $this->load->view("comisiones/dispersion/dispersionBonosView");
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

  // public function historial_casas_comisiones()
  // {
  //   $this->load->view('template/header');
  //   $this->load->view("casas_comisiones/historial_casas_comisiones");    
  // }

  public function getTotalComisionAsesor()
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Casas_comisiones_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }

  public function insertar_codigo_postal(){
    $cp = $this->input->post('cp');
    $nuevoCp = $this->input->post('nuevoCp');
    $respuesta = $this->Casas_comisiones_model->insertar_codigo_postal($cp, $nuevoCp);
  }
  

  public function consulta_codigo_postal(){
    $resolt = $this->Casas_comisiones_model->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
    echo json_encode($resolt);
  }

  public function SubirPDFExtranjero($id = ''){
        $id_usuario = $this->session->userdata('id_usuario');
        $nombre = $this->session->userdata('nombre');
        $opc = 0;

        if ($id != '') {
            $opc = 1;
            $id_usuario = $this->input->post("id_usuario");
            $nombre = $this->input->post("nombre");
        }

        date_default_timezone_set('America/Mexico_City');
        $hoyM = date("Y-m-d");


        $fileTmpPath = $_FILES['file-upload-extranjero']['tmp_name'];
        $fileName = $_FILES['file-upload-extranjero']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $nombre . $hoyM . md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './static/documentos/extranjero/';

        $dest_path = $uploadFileDir . $newFileName;
        move_uploaded_file($fileTmpPath, $dest_path);


        $response = $this->Casas_comisiones_model->SaveCumplimiento($id_usuario, $newFileName, $opc);
        echo json_encode($response);
  }

  public function getFechaCorteActual(){
    $diaActual = date('d'); 
    $data = array(
      "fechasCorte" => $this->Casas_comisiones_model->getFechaCorteActual($diaActual)
      );
    echo json_encode($data,JSON_NUMERIC_CHECK);
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

    $consulta_comisiones = $this->db->query("SELECT pci.id_pago_i FROM pago_casas_ind pci LEFT JOIN usuarios u ON u.id_usuario=pci.id_usuario WHERE pci.id_pago_i IN (".$sol.")");

    // Validacion de un usuario multitipo
    $multitipo = $this->db->query("SELECT tipo FROM multitipo WHERE id_usuario = $id_user_Vl")->result_array();
    $tipo = $multitipo != null ?  $multitipo[0]["tipo"] : $this->session->userdata('tipo');
    $tipoValidado = $tipo == 2 ? 1 : ($tipo == 3 || $tipo == 4 ? $tipo : 0);
    $consultaTipoUsuario = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario IN (".$id_user_Vl.")")->result_array();

    if(in_array($tipoValidado,$formaPagoInvalida)){ //EL COMISIONISTA SI TIENE UNA FORMA DE PAGO VALIDA Y CONTINUA CON EL PROCESO DE ENVIO DE COMISIONES
      $opinionCumplimiento = $this->Casas_comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl); // viene vacio
      $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual; // viene 7 por el mes actual 

      // falta validar
      $filtro = ($tipoValidado == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($consultaTipoUsuario[0]['forma_pago'] == 2 && $tipoValidado == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
      
      $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND corteOoam = $tipoValidado AND mes = $mesActual  $filtro")->result_array(); //trae dos datos con id de fecha de corte

      $obtenerFechaSql = $this->db->query("SELECT FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;// obtiene la fecha de sistema
      
      if( $consulta_comisiones->num_rows() > 0 && $consultaFechasCorte ){ // valida que tenga datos consulta_comisiones y tambien consultafechasCorte
        $validar_sede = $this->session->userdata('id_sede');
        $fecha_actual = strtotime($obtenerFechaSql);
        $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
        $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
        
        if($formaPagoUsuario == 3){
          $consultaCP = $this->Casas_comisiones_model->consulta_codigo_postal($id_user_Vl)->result_array();
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
              
            if ($up_b === FALSE || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                echo json_encode(array("respuesta" => 0));
              }else{
                $this->db->trans_commit();
                echo json_encode(array("respuesta" => 1, "data" => $this->Casas_comisiones_model->getSumaPagos($this->session->userdata('id_usuario'))->result_array()));
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
      // var_dump('el filtro esta aqui');
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
    // var_dump($id_user);
    if(empty($id_user)){
      // Se revisa despues para cambiar----------------------------------------------------
      $RFC = $this->Usuarios_modelo->getPersonalInformation()->result_array(); 
    }else{
      $RFC = $this->Usuarios_modelo->getPersonalInformation2($id_user)->result_array();  
    }

    // -----------------------------------------------------------------------------------
   
    $respuesta = array( "respuesta" => array( FALSE, "HA OCURRIDO UN ERROR") );
    if( isset( $_FILES ) && !empty($_FILES) ){
        $config['upload_path'] = './UPLOADS/XMLS_CASAS/';
        $config['allowed_types'] = 'xml';
        //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
        $this->load->library('upload', $config);
        if( $this->upload->do_upload("xmlfile") ){
            $xml_subido = $this->upload->data()['full_path'];
            $datos_xml = $this->Casas_comisiones_model->leerxml( $xml_subido, TRUE );
            if( $datos_xml['version'] >= 3.3){
              $responsable_factura = $this->Casas_comisiones_model->verificar_uuid( $datos_xml['uuidV'] );
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
     $respuesta = array( $this->Casas_comisiones_model->borrar_factura( $this->input->post("delete_fact")));
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

    $multitipo = $this->db->query("SELECT tipo FROM multitipo WHERE id_usuario = ".$this->session->userdata('id_usuario')." ")->result_array();
    $tipo = $multitipo != null ?  $multitipo[0]["tipo"] : $this->session->userdata('tipo');
    $tipoValidado = $tipo == 2 ? 1 : ($tipo == 3 || $tipo == 4 ? $tipo : 0);

    $forma_Pago = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario IN (".$this->session->userdata('id_usuario').")")->result_array();


    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $filtro = ($tipoValidado == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($forma_Pago== 2 && $tipoValidado == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE corteOoam = ".$tipoValidado." AND mes = $mesActual  $filtro")->result_array();


    $obtenerFechaSql = $this->db->query("SELECT FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
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
          $config['upload_path'] = './UPLOADS/XMLS_CASAS/';
          $config['allowed_types'] = 'xml';
          $this->load->library('upload', $config);
          $resultado = $this->upload->do_upload("xmlfile");
          
          if( $resultado ){
            $xml_subido = $this->upload->data();
            $datos_xml = $this->Casas_comisiones_model->leerxml( $xml_subido['full_path'], TRUE );
            $total = (float)$this->input->post('total');
            $totalXml = (float)$datos_xml['total'];
            
            if (($total + .50) >= $totalXml && ($total - .50) <= $totalXml) {
              $nuevo_nombre = date("my")."_";
              $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
              $nuevo_nombre .= date("Hms")."_";
              $nuevo_nombre .= rand(4, 100)."_";
              $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
              rename( $xml_subido['full_path'], "./UPLOADS/XMLS_CASAS/".$nuevo_nombre );
              $datos_xml['nombre_xml'] = $nuevo_nombre;
              ini_set('max_execution_time', 0);
              for ($i=0; $i <count($datos) ; $i++) { 
                if(!empty($datos[$i])){
                  $id_com =  $datos[$i];
                  $this->Casas_comisiones_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                  $this->Casas_comisiones_model->update_acepta_solicitante($id_com);
                  $this->db->query("INSERT INTO historial_comision_casas VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A CONTRALORÍA')");
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
      // var_dump($consultaFechasCorte);

      echo json_encode( $resultado );
    }else{
      echo json_encode(3);
    }
  }

  public function resumenIndividual($idLote,$proceso){
    // $idLote = $this->input->post('idLote');
    if($proceso == 1){
        // fusion
        echo json_encode($this->Casas_comisiones_model->resumenIndividual($idLote));
    }else  if ($proceso == 2){
        // excedente
        echo json_encode($this->Casas_comisiones_model->resumenIndividualExce($idLote));
    }
  }

  public function getComments($pago){
    echo json_encode($this->Casas_comisiones_model->getComments($pago)->result_array());
  }

  public function getDesarrolloSelect($a = ''){
    $diaActual = date('d'); 
    $validar_sede = $this->session->userdata('id_sede');
    $tipoUsuario = $this->session->userdata('tipo');
    $id_user = $this->session->userdata('id_usuario');

    $multitipo = $this->db->query("SELECT tipo FROM multitipo WHERE id_usuario = $id_user")->result_array();
    $tipo = $multitipo != null ?  $multitipo[0]["tipo"] : $this->session->userdata('tipo');
    $tipoValidado = $tipo == 2 ? 1 : ($tipo == 3 || $tipo == 4 ? $tipo : 0);

    $consultaTipoUsuario = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario IN (".$id_user.")")->result_array();


    // $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 ELSE 0 END) tipo,forma_pago FROM usuarios WHERE id_usuario IN (".$this->session->userdata('id_usuario').")")->result_array();
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual; 
    // $tipo = $this->session->userdata('tipo') == 1 ? 1 : 2;
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $filtro = ($tipoValidado == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($consultaTipoUsuario == 2 && $tipoValidado == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE corteOoam = ".$tipoValidado." AND mes = $mesActual  $filtro")->result_array();
    $obtenerFechaSql = $this->db->query("SELECT FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
    
    $fecha_actual = strtotime($obtenerFechaSql);
    
    $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
    
    $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
      if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin)){
        if($a == ''){
          echo json_encode($this->Casas_comisiones_model->getDesarrolloSelect()->result_array());
        } else{
          echo json_encode($this->Casas_comisiones_model->getDesarrolloSelect($a)->result_array());
        }
      } else{
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
          $respuesta = array($this->Casas_comisiones_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
          break;
  
          case 2:
          $respuesta = array($this->Casas_comisiones_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
          break;
  
          case 3:
  
          $validate =  $this->db->query("SELECT registro_comision from lotes l where l.idLote in (select c.id_lote from comisiones_casas c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_casas_ind p WHERE p.id_pago_i = ".$this->input->post("id_pago_i")."))");
  
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

  
// ----------------------------------- controladores casas_colaboradorRigel --------------------------------

public function getDatosFechasProyecCondm(){
  //$tipoUsuario = (($this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 ) ?  ($this->session->userdata('tipo') == 1 ? ( date('N') == 3 ? '3' : '1'): '2') :( $this->session->userdata('tipo') == 3 ? '4' : '1' ));
  //var_dump(date('N') );
  //$fechaFin = $this->session->userdata('id_sede') == 8 ? 'fechaTijuana' : 'fechaFinGeneral';
  $diaActual = date('d'); 
  $data = array(
    "proyectos" => $this->Contratacion_model->get_proyecto_lista()->result_array(),
    "fechasCorte" => $this->Casas_comisiones_model->getFechaCorteActual($diaActual),
    "condominios" => $this->Casas_comisiones_model->get_condominios_lista()->result_array(),
    "sumaPagos" => $this->Casas_comisiones_model->getSumaPagos($this->session->userdata('id_usuario'))->result_array(),
    "opinion" => $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array()
  );
  echo json_encode($data,JSON_NUMERIC_CHECK);
  
}

  public function getDatosComisionesRigel(){
      $proyecto = $this->input->post('idProyecto');
      $condominio = $this->input->post('idCondominio');
      $estado= $this->input->post('estatus'); 
      $dat =  $this->Casas_comisiones_model->getDatosComisionesRigel($proyecto,$condominio,$estado)->result_array();
      echo json_encode($dat);
  }

  public function acepto_comisiones_resguardo(){
 
    $this->load->model("Comisiones_model");
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
            'comentario' =>  'ENVÍO A SU RESGUARDO PERSONAL' 
          );

          array_push($data,$row_arr);


        }
        $id_pago_i = rtrim($id_pago_i, $sep);
        $up_b = $this->Casas_comisiones_model->update_acepta_resguardo($id_pago_i);
        $ins_b = $this->Casas_comisiones_model->insert_phc($data);

        if ($up_b === FALSE || $this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          echo json_encode(array("respuesta" => 0));
        }else{
          $this->db->trans_commit();
          echo json_encode(array("respuesta" => 1, "data" => $this->Casas_comisiones_model->getSumaPagos($this->session->userdata('id_usuario'))->result_array()));
        } 
      
      }
      else{
        $data_response = 0;
      echo json_encode($data_response);
      }
  }
  public function getDataDispersionPago() {
    $data['data'] = $this->Casas_comisiones_model->getDataDispersionPago()->result_array();
    echo json_encode($data);
  }

  public function porcentajes(){
    $plan_comision = $this->input->post("plan_comision");
    $totalNeto2 = $this->input->post("totalNeto2");
    $cliente = $this->input->post("idCliente");
    echo json_encode($this->Casas_comisiones_model->porcentajes($cliente,$totalNeto2,$plan_comision)->result_array(),JSON_NUMERIC_CHECK);
  }

   
  public function InsertNeo(){

   // exit;
    $lote_1 =  $this->input->post("idLote");
    $bonificacion =  0;
    $penalizacion = 0;
    $nombreLote =  $this->input->post("nombreLote");
    $disparador =  $this->input->post("id_disparador");
    $ooam = 0;
    $nombreOtro = $this->input->post("nombreOtro");
    $responses = $this->Casas_comisiones_model->validateDispersionCommissions($lote_1)->result_array();
    $totalFilas = count($responses); 
    // var_dump($responses[0]['bandera']);
    // exit;
    if($totalFilas == 0){ 
      // echo "entra a primera";
      // INICIA PRIMERA VALIDACION DE DISPERSION
        $this->db->trans_begin();
        $replace = [",","$"];
        $id_usuario = $this->input->post("id_usuario[]");
        $comision_total = $this->input->post("comision_total[]");
        $porcentaje = $this->input->post("porcentaje[]");
        $id_rol = $this->input->post("id_rol[]");
        $comision_abonada = $this->input->post("comision_abonada[]");
        $comision_pendiente = $this->input->post("comision_pendiente[]");
        $comision_dar = $this->input->post("comision_dar[]");
        $pago_neo = $this->input->post("pago_neo");
        $porcentaje_abono = $this->input->post("porcentaje_abono");
        $abonado = $this->input->post("abonado");
        $total_comision = $this->input->post("total_comision");
        $pendiente = $this->input->post("pendiente");
        $idCliente = $this->input->post("idCliente");
        $tipo_venta_insert = $this->input->post('tipo_venta_insert'); 
        $lugar_p = $this->input->post('lugar_p');
        $totalNeto2 = $this->input->post('totalNeto2');
        $plan_comision = $this->input->post('plan_c');
        $banderita = 0;
        $PorcentajeAsumar=0;
        $porsicionAsesor = '';
        $bandera_segunda = 1;
    //   $respuesta = $this->Casas_comisiones_model->InsertPagoComision($lote_1,str_replace($replace,"",$total_comision),str_replace($replace,"",$abonado),$porcentaje_abono,str_replace($replace,"",$pendiente),$this->session->userdata('id_usuario'),str_replace($replace,"",$pago_neo),str_replace($replace,"",$bonificacion)); 

      $tipo_venta_insert = $plan_comision;
      $pivote=0;
   
      for ($i=0; $i <count($id_usuario) ; $i++) {   
   
        // $respuesta = $this->Casas_comisiones_model->InsertNeo($lote_1,$id_usuario[$i],str_replace($replace,"",$comision_total[$i]),$this->session->userdata('id_usuario'),$porcentaje[$i],str_replace($replace,"",$comision_dar[$i]),str_replace($replace,"",$pago_neo),$id_rol[$i],$idCliente,$tipo_venta_insert,$ooam, $nombreOtro);
        $respuestaInsertNeoNew = $this->Casas_comisiones_model->getDataDispersionPagoInsertNeoNew($bandera_segunda,$lote_1,$id_usuario[$i],$idCliente,str_replace($replace,"",$comision_total[$i]), $this->session->userdata('id_usuario'),$porcentaje[$i],str_replace($replace,"",$comision_dar[$i]), str_replace($replace,"",$pago_neo),$id_rol[$i],$porcentaje_abono,str_replace($replace,"",$total_comision),str_replace($replace,"",$abonado),str_replace($replace,"",$pendiente));
    
       }
      
      $respuesta = $this->Casas_comisiones_model->UpdateLoteDisponible($lote_1,$idCliente);
    
      //TERMINA PRIMERA VALIDACION DE DISPERSION
    
    } else if($responses[0]["bandera"] == 0 && $disparador == 0){

        
            $lote_1 =  $this->input->post("idLote");
            $pending_1 =  $this->input->post("pending");
            $abono_nuevo = $this->input->post("abono_nuevo[]");
            $val_rol = $this->input->post("id_rol[]");
            $id_usuario = $this->input->post("id_usuario[]");
            $id_comision = $this->input->post("id_comision[]");
            $pago = $this->input->post("pago_neo");
            $idCliente = $this->input->post("idCliente");
            
            $suma = 0;
            $replace = [",","$"];
            
            $bandera_segunda = 2; 


            for($i=0;$i<sizeof($id_comision);$i++){
            $var_n = str_replace($replace,"",$abono_nuevo[$i]);
        
                // $respuesta = $this->Comisiones_model->insert_dispersion_individual($id_comision[$i], $id_usuario[$i], $var_n, $pago);
                // $respuestaInsertNeoNew = $this->Casas_comisiones_model->getDataDispersionPagoInsertNeoNew($bandera_segunda,$lote_1,$id_usuario[$i],$idCliente,str_replace($replace,"",$comision_total[$i]), $this->session->userdata('id_usuario'),$porcentaje[$i],str_replace($replace,"",$comision_dar[$i]), str_replace($replace,"",$pago_neo),$id_rol[$i],$porcentaje_abono,str_replace($replace,"",$total_comision),str_replace($replace,"",$abonado),str_replace($replace,"",$pendiente));
    
                $respuestaInsertNeoNew = $this->Casas_comisiones_model->getDataDispersionPagoInsertNeoNew($bandera_segunda,$lote_1,$id_usuario[$i],$idCliente,0,$this->session->userdata('id_usuario'),0,$var_n,$pago);
      
            
            }
            
            for($i=0;$i<sizeof($abono_nuevo);$i++){
            $var_n = str_replace($replace,"",$abono_nuevo[$i]);
            $suma = $suma + $var_n;
            }
            
            $resta = $pending_1 - $pago;
            if($suma > 0){
            $respuesta = $this->Casas_comisiones_model->UpdateLoteDisponible($lote_1, $idCliente);
            // $respuesta = $this->Comisiones_model->update_pago_dispersion($suma, $lote_1, $pago);
            }
    
            /*if ($respuesta === FALSE || $this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $respuesta = false;
            }else{
            $this->db->trans_commit();
            $respuesta = true;
            }*/
    }
    else if($responses[0]->bandera != 0) {
      $respuesta[0] = 2;
    } else{
      $respuesta[0] = 3;
    } 

    if ($respuesta === FALSE || $this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      $respuesta = false;
    }else{
      $this->db->trans_commit();
      $respuesta = 1;
    }

  echo json_encode( $respuesta );
  }

  function getDatosAbonadoSuma11($idlote){
    echo json_encode($this->Casas_comisiones_model->getDatosAbonadoSuma11($idlote)->result_array());
  }
  function getDatosAbonadoDispersion($idlote){

    echo json_encode($this->Casas_comisiones_model->getDatosAbonadoDispersion($idlote)->result_array());
  }

  public function changePrioridad(){
    $prioridadActual = $this->input->post("priridadActual") == 1 ? 0 : 1;
    $idClienteCasas = $this->input->post("idClienteCasas");
    $respuesta = $this->Casas_comisiones_model->changePrioridad($prioridadActual,$idClienteCasas,$this->session->userdata('id_usuario'));
    echo json_encode($respuesta);
  }


  public function getPagosBonos(){
    $respuesta = $this->Casas_comisiones_model->getPagosBonos();
    for( $i = 0; $i < count($respuesta); $i++ ){
      $respuesta[$i]['pa'] = 0;
  }
    echo json_encode( array("data" =>$respuesta));
  }

  public function getUsuariosBonos(){
     echo json_encode($this->Casas_comisiones_model->getUsuariosBonos()->result_array());
  }

  public function AsignarBono(){
    $this->db->trans_begin();
    $usuariosBonos = [10460,15103];
    $id_usuario = $this->input->post("usuarioBono");
    $id_pago_i = $this->input->post("id_pago_i");
    $id_comision = $this->input->post("id_comision");
    $montoActual = $this->input->post("montoPago");
    $monto = $this->input->post("monto_dispersar");
    $totalNeto2 = $this->input->post("totalNeto2");
    $idLote = $this->input->post("idLote");
    $idCliente = $this->input->post("idCliente");
    $porcentajeTotal = 0.4;
    //$porcentajeAsignado = ($monto * 100) / $totalNeto2;
    
   /* $dataUpdateCom = array(
      "comision_total" => $monto,
      "id_usuario" => $id_usuario[0],
      "rol_generado" => $id_usuario[1],
      "porcentaje_abonado" => $porcentajeAsignado
    );
    $dbTransaction = $this->General_model->updateRecord('comisiones_casas', $dataUpdateCom, 'id_comision', $id_comision);*/
    $dataUpdatePago = array(
      "estatus" => 11,
      "modificado_por" => $this->creadoPor
    );
    $dbTransaction = $this->General_model->updateRecord('pago_casas_ind', $dataUpdatePago, 'id_pago_i', $id_pago_i);
    $arrayBonos = array();
    $data = array(
      "id_pago_i" => $id_pago_i,
      "id_usuario" => $id_usuario,
      "abono_bono" => $monto,
      "fecha_abono" => $this->hoy,
      "fecha_pago_intmex" => NULL,
      "pago_bono" => floatval($montoActual),
      "estatus" => 1,
      "creado_por" => $this->creadoPor,
      "comentario" => "DISPERIÓN BONOS",
      "modificado_por " => $this->creadoPor,
      "descuento" => 0
  );
  array_push($arrayBonos, $data);

    $data = array(
      "id_pago_i" => $id_pago_i,
      "id_usuario" => $id_usuario == $usuariosBonos[0] ? $usuariosBonos[1] : $usuariosBonos[0] ,
      "abono_bono" => $montoActual - $monto,
      "fecha_abono" => $this->hoy,
      "fecha_pago_intmex" => NULL,
      "pago_bono" => floatval($montoActual),
      "estatus" => 1,
      "creado_por" => $this->creadoPor,
      "comentario" => "DISPERIÓN BONOS",
      "modificado_por " => $this->creadoPor,
      "descuento" => 0
  );
    array_push($arrayBonos, $data);

    $insertado = $this->General_model->insertBatch('pago_comision_bono', $arrayBonos);
    if ( $insertado === FALSE || $this->db->trans_status() === FALSE){
         $this->db->trans_rollback();
         $resultado = array("resultado" => FALSE);
     }else{
         $this->db->trans_commit();
         $resultado = array("resultado" => TRUE);
     }
    echo json_encode($resultado);
  }

  public function asigancionMasivaBonos(){
    $this->db->trans_begin();

    $id_usuario = $this->input->post("usuarioAsignar");
    $id_pago_i = $this->input->post("idPagos");
    
    $arrayBonos = array();


    $datosPagos =  $this->Casas_comisiones_model->getPagosBonosEnviados($id_pago_i)->result_array();
    for ($i=0; $i < count($datosPagos) ; $i++) { 
      $data = array(
        "id_pago_i" => $datosPagos[$i]['id_pago_i'],
        "id_usuario" => $id_usuario,
        "abono_bono" => floatval($datosPagos[$i]['abono_neodata']),
        "fecha_abono" => $this->hoy,
        "fecha_pago_intmex" => NULL,
        "pago_bono" => floatval($datosPagos[$i]['abono_neodata']),
        "estatus" => 1,
        "creado_por" => $this->creadoPor,
        "comentario" => "DISPERIÓN BONOS",
        "modificado_por " => $this->creadoPor,
        "descuento" => 0
    );
      array_push($arrayBonos, $data);

      $dataUpdatePago = array(
        "estatus" => 11,
        "modificado_por" => $this->creadoPor
      );
      $dbTransaction = $this->General_model->updateRecord('pago_casas_ind', $dataUpdatePago, 'id_pago_i', $datosPagos[$i]['id_pago_i']);

    }
    $insertado = $this->General_model->insertBatch('pago_comision_bono', $arrayBonos);
    if ( $insertado === FALSE || $this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      $resultado = array("resultado" => FALSE);
  }else{
      $this->db->trans_commit();
      $resultado = array("resultado" => TRUE);
  }
 echo json_encode($resultado);


  }

  //------------------------------ Contralodores resguardo_casas.js -----------------------------

  public function getDatosResguardoContraloria(){
    $directivo = $this->input->post('directivo');
    $proyecto = $this -> input->post('proyecto');
    $anio = $this ->input->post('anio');
    $mes = $this -> input->post('mes');

    $dat =  $this->Casas_comisiones_model->getDatosResguardoContraloria($directivo,$proyecto,$anio,$mes)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }
  //-------------------------------- Controlador para solicitudes_bono_casas--------------------------------
  public function getDatosBonoAsesor($a)
  {
    $dat =  $this->Casas_comisiones_model->getDatosBonoAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
      $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
  }

  public function aceptar_bono_user(){
    $formaPagoInvalida = [2,3,4,5];
    $diaActual = date('d'); 
    $id_user_Vl = $this->session->userdata('id_usuario');
    $formaPagoUsuario = $this->session->userdata('forma_pago');
    $sol=$this->input->post('idcomision');  

    $consulta_comisiones = $this->db->query("SELECT pcb.id_pago_bono FROM pago_comision_bono pcb LEFT JOIN usuarios u ON u.id_usuario=pcb.id_usuario WHERE pcb.id_pago_bono IN (".$sol.")");

    // Validacion de un usuario multitipo
    $multitipo = $this->db->query("SELECT tipo FROM multitipo WHERE id_usuario = $id_user_Vl")->result_array();
    $tipo = $multitipo != null ?  $multitipo[0]["tipo"] : $this->session->userdata('tipo');
    $tipoValidado = $tipo == 2 ? 1 : ($tipo == 3 || $tipo == 4 ? $tipo : 0);
    $consultaTipoUsuario = $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario IN (".$id_user_Vl.")")->result_array();

    if(in_array($tipoValidado,$formaPagoInvalida)){ //EL COMISIONISTA SI TIENE UNA FORMA DE PAGO VALIDA Y CONTINUA CON EL PROCESO DE ENVIO DE COMISIONES
      $opinionCumplimiento = $this->Casas_comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl); // viene vacio
      $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual; // viene 7 por el mes actual 

      // falta validar
      $filtro = ($tipoValidado == 1) ?  ( $diaActual <= 15 ? "AND Day(fechaInicio) <= 17" : (($consultaTipoUsuario[0]['forma_pago'] == 2 && $tipoValidado == 1 ) ? " AND Day(fechaInicio) <= 17" :  "AND Day(fechaInicio) >= 17" ) ) : "";
      
      $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND corteOoam = $tipoValidado AND mes = $mesActual  $filtro")->result_array(); //trae dos datos con id de fecha de corte

      $obtenerFechaSql = $this->db->query("SELECT FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;// obtiene la fecha de sistema
      
      if( $consulta_comisiones->num_rows() > 0 && $consultaFechasCorte ){ // valida que tenga datos consulta_comisiones y tambien consultafechasCorte
        $validar_sede = $this->session->userdata('id_sede');
        $fecha_actual = strtotime($obtenerFechaSql);
        $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
        $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
        
        if($formaPagoUsuario == 3){
          $consultaCP = $this->Casas_comisiones_model->consulta_codigo_postal($id_user_Vl)->result_array();
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
            $id_pago_bono = '';
            $data=array();
            $pagoInvoice = array();

            foreach ($consulta_comisiones as $row) {
              $id_pago_bono .= implode($sep, $row);
              $id_pago_bono .= $sep;

              $row_arr=array(
                'id_pago_i' => $row['id_pago_bono'],
                'id_usuario' =>  $id_user_Vl,
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'estatus' => 1,
                'comentario' =>  'COLABORADOR ENVÍO A CONTRALORÍA' 
              );

              array_push($data,$row_arr);

              if ($formaPagoUsuario == 5) { // Pago extranjero
                $pagoInvoice[] = array(
                  'id_pago_i' => $row['id_pago_bono'],
                  'nombre_archivo' => $opinionCumplimiento->archivo_name,
                  'estatus' => 1,
                  'modificado_por' => $id_user_Vl,
                  'fecha_registro' => date('Y-m-d H:i:s')
                );
              }
            }

            $id_pago_bono = rtrim($id_pago_bono, $sep);
            $up_b = $this->Casas_comisiones_model->update_aceptar_bono($id_pago_bono);
            $ins_b = $this->Casas_comisiones_model->insert_phc_bono($data);
            $this->Casas_comisiones_model->changeEstatusOpinion($id_user_Vl);
            if ($formaPagoUsuario == 5) {
              $this->Casas_comisiones_model->insertMany($pagoInvoice);
            }
              
            if ($up_b === FALSE || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                echo json_encode(array("respuesta" => 0));
              }else{
                $this->db->trans_commit();
                echo json_encode(array("respuesta" => 1, "data" => $this->Casas_comisiones_model->getSumaBono($this->session->userdata('id_usuario'))->result_array()));
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
      // var_dump('el filtro esta aqui');
      $data_response = 5;
      echo json_encode($data_response);
    } 
  }

  public function getBonoHistorialPago($id_pago_i) {      
    $dat =  $this->Casas_comisiones_model->getBonoHistorialPago($id_pago_i)->result_array();
    echo json_encode( array( "data" => $dat));
  }

  public function lotes(){
    $lotes = $this->Casas_comisiones_model->lotes();
    
    $pagos = $this->Casas_comisiones_model->pagos();
    
    $monto = $this->Casas_comisiones_model->monto();

    $dispersion[ "lotes"] = $lotes->nuevo_general; 
    $dispersion["pagos"] = $pagos->nuevo_general;
    $dispersion["monto"] = $monto->nuevo_general;

    echo json_encode(  $dispersion);
  }
  public function getDatosHistorialCasas($proyecto, $condominio, $usuario) {

    ini_set('max_execution_time', 900);
    set_time_limit(900);
    ini_set('memory_limit','2048M');

    
    $dat =  $this->Casas_comisiones_model->getDatosHistorialCasas($proyecto,$condominio, $usuario)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

  public function selectTipo(){

    echo json_encode($this->Casas_comisiones_model->selectTipo()->result_array());

  }

  public function cambiarEstatusComisiones()
    {
        $idPagos = explode(',', $this->input->post('idPagos'));
        $userId = $this->session->userdata('id_usuario');
        $estatus = $_POST['estatus'];
        $comentario = $_POST['comentario'];
        $historiales = array();

        foreach($idPagos as $pago) {
            $historiales[] = array(
                'id_pago_i' => $pago,
                'id_usuario' =>  $userId,
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'estatus' => 1,
                'comentario' => $comentario
            );
        }

        $resultUpdate = $this->Casas_comisiones_model->massiveUpdateEstatusComisionInd(implode(',', $idPagos), $estatus);
        $resultMassiveInsert = $this->Casas_comisiones_model->insert_phc($historiales);

        echo ($resultUpdate && $resultMassiveInsert);
    }

}
