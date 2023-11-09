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
        $this->load->model('asesor/Asesor_model');
        $this->load->model('Usuarios_modelo');
        $this->load->model('PagoInvoice_model');
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
      } else{
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
    } else{
      $data_response = 0;
      echo json_encode($data_response);
      }
  }
  
  public function getComments($id_pago ){
    echo json_encode($this->Ooam_model->getComments($id_pago));
  }
  
  public function comisiones() {
    $opn_cumplimiento = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
    $query = $this->Ooam_model->comisiones_Ooam_forma_pago();
    $datos["a"] = 'open';
    $bandera = 2;
    
    if( $query->forma_pago  == 2 ||  $query->forma_pago == '2'){
      $bandera = 1;
      if(count($opn_cumplimiento) == 0){
        $datos["cadena"] = '<a href="'.base_url().'Usuarios/configureProfile"> <span class="label label-danger" style="background:red;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA ></span> </a>';
      } else{
        if($opn_cumplimiento[0]['estatus'] == 1){
          $datos["cadena"] = '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';
        } else if($opn_cumplimiento[0]['estatus'] == 0){
          $datos["cadena"] ='<a href="'.base_url().'Usuarios/configureProfile"> <span class="label label-danger" style="background:orange;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>';
        } else if($opn_cumplimiento[0]['estatus'] == 2){
          $datos["cadena"] = '<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>';
        }
      }
    } else if ($query->forma_pago == 5) {
      $bandera = 1;
      if(count($opn_cumplimiento) == 0){
        $datos["cadena"] = '<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>';
      } else if($opn_cumplimiento[0]['estatus'] == 0) {
        $datos["cadena"]= '<button type="button" class="btn btn-info subir-archivo">SUBIR DOCUMENTO FISCAL</button>';
      } else if ($opn_cumplimiento[0]['estatus'] == 1) {
        $datos["cadena"] = '<p><b>Documento fiscal cargado con éxito</b><a href="#" class="verPDFExtranjero" title="Documento fiscal" data-usuario="'.$opn_cumplimiento[0]["archivo_name"].'" style="cursor: pointer;"><u>Ver documento</u></a></p>';
      } else if($opn_cumplimiento[0]['estatus'] == 2) {
        $datos["cadena"] = '<p style="color: #02B50C;">Documento fiscal bloqueado, hay comisiones asociadas.</p>';
      }
    }
    if($bandera == 1){
      $this->load->view('template/header');
      $this->load->view("ooam/asesor_ooam_view", $datos);
    }else {
      $datos["cadena"] = 2;
      $this->load->view('template/header');
      $this->load->view("ooam/asesor_ooam_view", $datos);
    }
  }
  
  public function lista_condominio($proyecto) {
    $this->validateSession();
    echo json_encode($this->Ooam_model->get_condominio_lista($proyecto)->result_array());
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
    $hoy = date("Y-m-d");
    $fileTmpPath = $_FILES['file-upload-extranjero']['tmp_name'];
    $fileName = $_FILES['file-upload-extranjero']['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = $nombre . $hoy . md5(time() . $fileName) . '.' . $fileExtension;
    $uploadFileDir = './static/documentos/extranjero/';
    
    $dest_path = $uploadFileDir . $newFileName;
    move_uploaded_file($fileTmpPath, $dest_path);
    $response = $this->Ooam_model->SaveCumplimiento($id_usuario, $newFileName, $opc);
    echo json_encode($response);
  }
  
  public function consulta_codigo_postal(){
    $resolt = $this->Ooam_model->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
    echo json_encode($resolt);
  }
  
  public function lista_proyecto() {
    $this->validateSession();
    echo json_encode($this->Ooam_model->get_proyecto_lista()->result_array());
  }
  
  public function acepto_comisiones_user(){
    $id_user_Vl = $this->session->userdata('id_usuario');
    $formaPagoUsuario = $this->session->userdata('forma_pago');
    $sol=$this->input->post('idcomision');  
    $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_ooam_ind where id_pago_i IN (".$sol.")");
    $opinionCumplimiento = $this->Ooam_model->findOpinionActiveByIdUsuario($id_user_Vl);
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechas_corte_ooam WHERE mes=$mesActual")->result_array();
    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;
    if( $consulta_comisiones->num_rows() > 0 ){
      $validar_sede = $this->session->userdata('id_sede');
      $fecha_actual = strtotime($obtenerFechaSql);
      $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
      $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
      if($formaPagoUsuario == 3){
        $consultaCP = $this->Ooam_model->consulta_codigo_postal($id_user_Vl)->result_array();
      }
      if(($fecha_actual != $fechaInicio && $fecha_actual != $fechaFin) || ($id_user_Vl == 7689)){
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
          $up_b = $this->Ooam_model->update_acepta_solicitante($id_pago_i);
          $ins_b = $this->Ooam_model->insert_phc($data);
          $this->Ooam_model->changeEstatusOpinion($id_user_Vl);
          if ($formaPagoUsuario == 5) {
            $this->PagoInvoice_model->insertMany($pagoInvoice);
          }
          if($up_b == true && $ins_b == true){
            $data_response = 1;
            echo json_encode($data_response);
          } else {
            $data_response = 9;
            echo json_encode($data_response);
          }
        }
      } else {
        $data_response = 2;
        echo json_encode($data_response);
      }
    } else{
      $data_response = 8;
      echo json_encode($data_response);
    }
  }
  
  public function getDatosComisionesAsesor($a){
    $dat =  $this->Ooam_model->getDatosComisionesAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
      $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
  }
  
  public function guardar_solicitud($id_comision){
    $resultado = array("resultado" => TRUE);
    if( (isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
      $this->db->trans_begin();
      $responsable = $this->session->userdata('id_usuario');
      $resultado = TRUE;
      if( isset( $_FILES ) && !empty($_FILES) ){
        $config['upload_path'] = './UPLOADS/XMLS/';
        $config['allowed_types'] = 'xml';
        $this->load->library('upload', $config);
        $resultado = $this->upload->do_upload("xmlfile");
        if( $resultado ){
          $xml_subido = $this->upload->data();
          $datos_xml = $this->Ooam_model->leerxml( $xml_subido['full_path'], TRUE );
          $nuevo_nombre = date("my")."_";
          $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
          $nuevo_nombre .= date("Hms")."_";
          $nuevo_nombre .= rand(4, 100)."_";
          $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
          rename( $xml_subido['full_path'], "./UPLOADS/XMLS/".$nuevo_nombre );
          $datos_xml['nombre_xml'] = $nuevo_nombre;
          $id_com = $id_comision;
          $this->Ooam_model->insertar_factura($id_com, $datos_xml);
        }else{
          $resultado["mensaje"] = $this->upload->display_errors();
        }
      }
      if ( $resultado === FALSE || $this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $resultado = array("resultado" => FALSE);
      }else{
        $this->db->trans_commit();
        $resultado = array("resultado" => TRUE);
      }
    }
    echo json_encode( $resultado );
  }


  public function EnviarDesarrollos(){
    if($this->input->post("desarrolloSelect2") == 1000){
      $formaPago = $this->Ooam_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
      if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
        $respuesta = $this->Ooam_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,1);
      }else{
        $respuesta = $this->Ooam_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,2);
      }
    }else{
      $formaPago = $this->Ooam_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
      if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
        $respuesta = $this->Ooam_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),3);
      }else{
        $respuesta = $this->Ooam_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),4);
      }
    }
    echo json_encode($respuesta);
  }
  
  function getDatosProyecto($idlote,$id_usuario = ''){
    if($id_usuario == ''){
      echo json_encode($this->Ooam_model->getDatosProyecto($idlote)->result_array());
    }else{
      echo json_encode($this->Ooam_model->getDatosProyecto($idlote,$id_usuario)->result_array());
    }
  }
  
  public function cargaxml2($id_user = ''){
    $user =   $usuarioid =$this->session->userdata('id_usuario');
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
            $datos_xml = $this->Ooam_model->leerxml( $xml_subido, TRUE );
            if( $datos_xml['version'] >= 3.3){
              $responsable_factura = $this->Ooam_model->verificar_uuid( $datos_xml['uuidV'] );
              if($responsable_factura->num_rows()>=1){
                $respuesta['respuesta'] = array( FALSE, "ESTA FACTURA YA SE SUBIÓ ANTERIORMENTE AL SISTEMA");
              } else{
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


  function borrar_factura(){
    $respuesta = array( FALSE );
    if($this->input->post("delete_fact")){
      $respuesta = array( $this->Ooam_model->borrar_factura( $this->input->post("delete_fact")));
    }
    echo json_encode( $respuesta );
  }
      
  function setPausaPagosOOAM(){
    $respuesta = array( FALSE );
    if($this->input->post("id_pago")){
      $respuesta = array( $this->Ooam_model->setPausaPagosOOAM( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
    }
    echo json_encode( $respuesta );
  }

  public function getDesarrolloSelect($a = ''){
    $validar_user = $this->session->userdata('id_usuario');
    $validar_sede = $this->session->userdata('id_sede');
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechas_corte_ooam WHERE mes=$mesActual")->result_array();
    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
    $fecha_actual = strtotime($obtenerFechaSql);
    $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
    $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
      //fecha inicio
      if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin)){
        if($a == ''){
          echo json_encode($this->Ooam_model->getDesarrolloSelect()->result_array());
        }else{
          echo json_encode($this->Ooam_model->getDesarrolloSelect($a)->result_array());
        }
      }else{
        echo json_encode(3);
      }
    }

  public function getDataDispersionOOAM() {
    $data['data'] = $this->Ooam_model->getDataDispersionOOAM()->result_array();
    echo json_encode($data);
  }

  public function guardar_solicitud2($usuario = ''){
    $validar_user = $this->session->userdata('id_usuario');
    $validar_sede =   $usuarioid =$this->session->userdata('id_sede');
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechas_corte_ooam WHERE mes=$mesActual")->result_array();
    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
    $fecha_actual = strtotime($obtenerFechaSql);
    $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
    $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;

    if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) ){
      if($usuario != ''){
        $usuarioid = $usuario;
      }else{
        $usuarioid =$this->session->userdata('id_usuario');
      }

      $datos = explode(",",$this->input->post('pagos'));
      $resultado = array("resultado" => TRUE);
      if( (isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
        $this->db->trans_begin();
        $responsable = $this->session->userdata('id_usuario');
        $resultado = TRUE;
        if( isset( $_FILES ) && !empty($_FILES) ){
          $config['upload_path'] = './UPLOADS/XMLS/';
          $config['allowed_types'] = 'xml';
          $this->load->library('upload', $config);
          $resultado = $this->upload->do_upload("xmlfile");
          if( $resultado ){
            $xml_subido = $this->upload->data();
            $datos_xml = $this->Ooam_model->leerxml( $xml_subido['full_path'], TRUE );
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
                  $this->Ooam_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                  $this->Ooam_model->update_acepta_solicitante($id_com);
                  $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A CONTRALORÍA')");
                }
              }
            } else {
              $this->db->trans_rollback();
              echo json_encode(4);
              return;
            }
          }else{
            $resultado["mensaje"] = $this->upload->display_errors();
          }
        }
        if ( $resultado === FALSE || $this->db->trans_status() === FALSE){
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
    $responses = $this->Ooam_model->validateDispersionCommissions($lote_1);
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

  public function getRevisionXMLOOAM(){
    $proyecto = $this->input->post('proyecto');
    $dat =  $this->Ooam_model->getRevisionXMLOOAM($proyecto)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['montoOOAM'] = 0;
    }
    echo json_encode( array( "data" => $dat));
  }

}



