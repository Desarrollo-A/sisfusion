<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Seguros extends CI_Controller
{
    private $gph;
    public function __construct()
    {
    parent::__construct();
    $this->load->model(array('Comisiones_model', 'General_model','Seguro_model','Usuarios_modelo'));
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('1616', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = substr($_SERVER["REQUEST_URI"],1);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
    }

    public function index(){
        redirect(base_url());
    }
    public function validateSession() {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

    /**-----------------VISTAS---------------* */
    public function comisiones_colaborador(){
        $datos = array();
        $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
        $this->load->view('template/header');
        $this->load->view("ventas/comisionesColaboradorSeguros", $datos);
    }
    public function historial_colaborador()
    {
      $this->load->view('template/header');
      $this->load->view("comisiones/colaborador/historial_seguros_contraloria_view");    
    }
    
    public function loadFinalPayment() {
      $this->load->view('template/header');
      $this->load->view("internomex/load_final_payment_seguros");
    }
    public function reporteLotesPorComisionista() {
      if ($this->session->userdata('id_rol') == FALSE) {
          redirect(base_url());
      }
      $this->load->view('template/header');
      $this->load->view("comisiones/reporteLotesPorComisionistaSeguros_view");
  }
  public function AutSeguros()
  {
    $this->load->view('template/header');
    $this->load->view("comisiones/autSeguros-view");    
  }
    /**--------------------------------------- */
    public function getDatosComisionesAsesor($a)
    {
    $dat =  $this->Seguro_model->getDatosComisionesAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
        $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
    }
    public function getTotalComisionAsesor()
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Seguro_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }
    public function getComments($id_pago_i){
        echo json_encode($this->Seguro_model->getComments($id_pago_i)->result_array());
    }
    public function consulta_codigo_postal(){
        $resolt = $this->Seguro_model->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
        echo json_encode($resolt);
      }
      public function acepto_comisiones_user(){
        $formaPagoInvalida = [2,3,4,5];
        $id_user_Vl = $this->session->userdata('id_usuario');
        $formaPagoUsuario = $this->session->userdata('forma_pago');
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT pci.id_pago_i FROM pago_seguro_ind pci LEFT JOIN usuarios u ON u.id_usuario=pci.id_usuario WHERE pci.id_pago_i IN (".$sol.")");
        $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 WHEN tipo=4 THEN 4 ELSE 0 END) tipo FROM usuarios WHERE id_usuario IN (".$id_user_Vl.")")->result_array();
    
        if(in_array($consultaTipoUsuario[0]['forma_pago'],$formaPagoInvalida)){ //EL COMISIONISTA SI TIENE UNA FORMA DE PAGO VALIDA Y CONTINUA CON EL PROCESO DE ENVIO DE COMISIONES
          $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
          $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
          $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND tipoCorte = ".$consultaTipoUsuario[0]['tipo']." AND YEAR(GETDATE()) = YEAR(fechaInicio) /*AND DAY(GETDATE()) = DAY(fechaFinGeneral)*/ AND mes = $mesActual")->result_array();
    
          $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;
          
          if( $consulta_comisiones->num_rows() > 0 && $consultaFechasCorte ){
            $validar_sede = $this->session->userdata('id_sede');
            $fecha_actual = strtotime($obtenerFechaSql);
            $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
            $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
            
            if($formaPagoUsuario == 3){
              $consultaCP = $this->Comisiones_model->consulta_codigo_postal($id_user_Vl)->result_array();
            }
    
            if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin)){
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
                $up_b = $this->Seguro_model->update_acepta_solicitante($id_pago_i);
                $ins_b = $this->Seguro_model->insert_phc($data);
                $this->Comisiones_model->changeEstatusOpinion($id_user_Vl);
                if ($formaPagoUsuario == 5) {
                  $this->PagoInvoice_model->insertMany($pagoInvoice);
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

      public function getGeneralStatusFromNeodata($proyecto, $condominio)
      {
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
    
        public function getFechaCorteActual(){
        $tipoUsuario = (($this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 ) ?  ($this->session->userdata('tipo') == 1 ? ( date('N') == 3 ? '3' : '1'): '2') :( $this->session->userdata('tipo') == 4 ? '4' : '1' ));
        $diaActual = date('d'); 
        $fechaCorte = $this->Comisiones_model->getFechaCorteActual($tipoUsuario,$diaActual);
          echo json_encode(array("fechasCorte" => $fechaCorte),JSON_NUMERIC_CHECK);
        }
        public function insertar_codigo_postal(){
            $cp = $this->input->post('cp');
            $nuevoCp = $this->input->post('nuevoCp');
            $respuesta = $this->Comisiones_model->insertar_codigo_postal($cp, $nuevoCp);
        }
        public function getDesarrolloSelect($a = ''){
            $validar_sede = $this->session->userdata('id_sede');
            $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;  
            $tipo = (($this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 ) ?  ($this->session->userdata('tipo') == 1 ? ( date('N') == 3 ? '3' : '1'): '2') :( $this->session->userdata('tipo') == 4 ? '4' : '1' ));
            $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE tipoCorte = $tipo AND estatus = 1 AND mes = $mesActual")->result_array();
            
            $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
            
            $fecha_actual = strtotime($obtenerFechaSql);
            
            $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
            
            $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
              if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin)){
                if($a == ''){
                  echo json_encode($this->Seguro_model->getDesarrolloSelect()->result_array());
                } else{
                  echo json_encode($this->Seguro_model->getDesarrolloSelect($a)->result_array());
                }
              } else{
                echo json_encode(3);
              }
        }
      
        function getDatosProyecto($idlote,$id_usuario = ''){
            if($id_usuario == ''){
              echo json_encode($this->Seguro_model->getDatosProyecto($idlote)->result_array());
            }else{
              echo json_encode($this->Seguro_model->getDatosProyecto($idlote,$id_usuario)->result_array());
            }
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
      $config['upload_path'] = './UPLOADS/XMLSEGUROS/';
      $config['allowed_types'] = 'xml';
      //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
      $this->load->library('upload', $config);
      if( $this->upload->do_upload("xmlfile") ){
          $xml_subido = $this->upload->data()['full_path'];
          $datos_xml = $this->Seguro_model->leerxml( $xml_subido, TRUE );
          if( $datos_xml['version'] >= 3.3){
            $responsable_factura = $this->Seguro_model->verificar_uuid( $datos_xml['uuidV'] );
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
    public function guardar_solicitud2($usuario = ''){
        if($usuario != ''){
          $usuarioid = $usuario;
        }else{
          $usuarioid = $this->session->userdata('id_usuario');
        }
        $validar_sede =  $this->session->userdata('id_sede');
        $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    
        $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 WHEN tipo=4 THEN 4 ELSE 0 END) tipo FROM usuarios WHERE id_usuario IN (".$usuarioid.")")->result_array();
        $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND tipoCorte = ".$consultaTipoUsuario[0]['tipo']." AND YEAR(GETDATE()) = YEAR(fechaInicio) /*AND DAY(GETDATE()) = DAY(fechaInicio)*/ AND mes = $mesActual")->result_array();
    
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
              $config['upload_path'] = './UPLOADS/XMLSEGUROS/';
              $config['allowed_types'] = 'xml';
              $this->load->library('upload', $config);
              $resultado = $this->upload->do_upload("xmlfile");
              
              if( $resultado ){
                $xml_subido = $this->upload->data();
                $datos_xml = $this->Seguro_model->leerxml( $xml_subido['full_path'], TRUE );
                $total = (float)$this->input->post('total');
                $totalXml = (float)$datos_xml['total'];
                
                if (($total + .50) >= $totalXml && ($total - .50) <= $totalXml) {
                  $nuevo_nombre = date("my")."_";
                  $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
                  $nuevo_nombre .= date("Hms")."_";
                  $nuevo_nombre .= rand(4, 100)."_";
                  $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
                  rename( $xml_subido['full_path'], "./UPLOADS/XMLSEGUROS/".$nuevo_nombre );
                  $datos_xml['nombre_xml'] = $nuevo_nombre;

                 


                  ini_set('max_execution_time', 0);
                  for ($i=0; $i <count($datos) ; $i++) { 
                    if(!empty($datos[$i])){
                      $id_com =  $datos[$i];
                      $this->Seguro_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                      $this->Seguro_model->update_acepta_solicitante($id_com);
                      $this->db->query("INSERT INTO historial_seguro VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A CONTRALORÍA')");
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
          $this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
          echo json_encode( $resultado );
        }else{
          echo json_encode(3);
        }
      }

      public function getDatosHistorialPago($proyecto = null,$condominio = null ) {      
        $dat =  $this->Seguro_model->getDatosHistorialPago($proyecto,$condominio)->result_array();
        echo json_encode( array( "data" => $dat));
      }
      public function getPagosFinal() {
        $beginDate = $this->input->post('beginDate');
        $endDate = $this->input->post('endDate');
        $data['data'] = $this->Seguro_model->getPagosFinal($beginDate, $endDate)->result_array();
        echo json_encode($data);
      }
      public function getReporteLotesPorComisionista() {
        if (isset($_POST) && !empty($_POST)) {
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("beginDate"))));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("endDate"))));
            $comisionista = $this->input->post("comisionista");       
            $tipoUsuario = $this->input->post("tipoUsuario");
            $data['data'] = $this->Seguro_model->getReporteLotesPorComisionista($beginDate, $endDate, $comisionista, $tipoUsuario)->result_array();
            echo json_encode($data);
        } else
            json_encode(array());
    }
    public function getOpcionesParaReporteComisionistas() {
      $seeAll = $this->input->post("seeAll");
      $condicionXUsuario = '';
      if ($seeAll == 0 ){
          $condicionXUsuario = 'AND us.id_usuario = '.$this->session->userdata('id_usuario');
      }
      echo json_encode($this->Seguro_model->getOpcionesParaReporteComisionistas($condicionXUsuario)->result_array());
  }
  public function getDataPagosSeguro() {
    $data['data'] =  !isset($_POST["estatus"]) ? $this->Seguro_model->getDataPagosSeguro()->result_array() : $this->Seguro_model->getDataPagosSeguro($_POST["estatus"])->result_array();
    echo json_encode($data);
  }
  public function getDetallePlanesComisiones($idPlan)
  {
      $data = $this->Seguro_model->getDetallePlanesComisiones($idPlan)->result_array();
      $info = array();
      $info['id_plan'] = $data[0]['id_plan'];
      $info['descripcion'] = $data[0]['descripcion'];
      $info['comisiones'][] = array(
          'puesto' => $data[0]['asesor'],
          'com' => $data[0]['comAsesor']
      );
      $info['comisiones'][] = array(
          'puesto' => $data[0]['gerente'],
          'com' => $data[0]['comGerente']
      );
      for ($m=0; $m < count($data) ; $m++) { 
          $info['comisiones'][] = array(
            'puesto' => $data[$m]['nombre'],
            'com' => $data[$m]['valorComision']
        );
      }

      echo json_encode($info);
  }
  function getAbonado($idlote){
    echo json_encode($this->Seguro_model->getAbonado($idlote)->result_array());
  }
  function getDatosAbonadoDispersion($idlote){

    echo json_encode($this->Seguro_model->getDatosAbonadoDispersion($idlote)->result_array());
  }
  public function changeStatusSeguro(){
    $idCliente = $this->input->post('idCliente');
    $estatusAut = $this->input->post('tipoAut');
    $observaciones = $this->input->post('observaciones');
    $dataInsert = [
      "estatus" => $estatusAut,
      "idCliente" => $idCliente,
      "idUsuario" => $this->session->userdata('id_usuario'),
      "observaciones" => $observaciones,
      "fechaCreacion" => date("Y-m-d H:i:s")
    ];
    $data = ['estatusSeguro' => $estatusAut];
    $this->General_model->addRecord("historialSeguros", $dataInsert);
    echo json_encode($this->General_model->updateRecord('clientes',$data,'id_cliente',$idCliente));
  }
  function getHistorialSeguro($idCliente){
    echo json_encode($this->Seguro_model->getHistorialSeguro($idCliente));
  }
}